<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrmaa;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PbrmaaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrmaa';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrmaa();
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrmaa',
			'return'	=> self::returnUrl()
		);
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('pbrmaa.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		//ID de la institución que tiene asignada el usuario
		$idi = \Auth::user()->idinstituciones;
		//Verificó que la key este presente en el return
		if(isset($request->k)){
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($request->k);
			$ida = $decoder['ida'];
			$idi = $decoder['idi'];
		}else{
			$ida = 0;
		}
		$this->data['ida'] = $ida;
		$this->data['idi'] = $idi;
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;

		$gp = \Auth::user()->group_id;
		if($gp == 1 || $gp == 2){
			$this->data['rowsInstituciones'] = $this->model->getCatInstituciones();
		}else{
			$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($idi);
		}

		if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
			$rows = $this->getRowsAreasAdmin($this->data['idi'], $request->idy);//(type,idinstitucion)
		}else{
			$rows = $this->getRowsAreasEnlace($this->data['idi'], $request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('pbrmaa.principal',$this->data);
	}
	private function getRowsAreasAdmin($idi, $idy){
		$data = array();
		foreach ($this->model->getAreasGeneralForYear($idi, $idy) as $v) {
			$data[] = array("ida"=>$v->idarea,
							"no"=>$v->no_dep_gen,
							"area"=>$v->dep_gen,
							"titular"=>$v->titular,
							"rows_coor"=> $this->model->getCoordinacionesGeneral($v->idarea,$idi),
						);
		}
		return $data;
	}
	private function getRowsAreasEnlace($idi, $idy){
		$data = array();
		$idu = \Auth::user()->id;
		$access = $this->model->getPermisoAreaForYear($idu, $idy);//sximo
		foreach ($this->model->getAreasEnlacesGeneralForYear($access[0]->permiso,$idi) as $v) {
			$permiso = $this->model->getPermisoCoordinacion($idu,$v->idarea,$idi);//sximo
			$data[] = array("ida"=>$v->idarea,
							"no"=>$v->no_dep_gen,
							"area"=>$v->dep_gen,
							"titular"=>$v->titular,
							"rows_coor"=>$this->model->getCoordinacionesPermisosGeneral($v->idarea,$permiso[0]->permiso,$idi),
						);
		}
		return $data;
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		$this->data['ida'] = $decoder['ida'];//idarea
		$this->data['idi'] = $decoder['idi'];//idinstitucion
		$this->data['idac'] = $decoder['idac'];//idarea_coordinacion
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
		$this->data['k'] = $request->k;
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		return view('pbrmaa.anio',$this->data);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idac'] = $decoder['idac'];//ui_area_coordinaciones
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$data = array();
		$data[] = array("idanio"=>$r->idy,
						"anio"=>$r->year,
						"rows"=>$this->model->getProyectosAnio($decoder['idac'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('pbrmaa.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		//Obtengo todos los proyectos registrados
		$this->data['rows_projects'] = $this->model->getProjects($r->idanio);
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		return view('pbrmaa.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		$rows = $this->model->getPbrmaa($r->id);
		$this->data['rows'] = $rows[0];
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		//Registros
		$this->data['registros'] = $this->model->getProyectosPbrmaa($r->id);
		return view('pbrmaa.edit',$this->data);
	}
	public function getAddtr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('pbrmaa.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea_coordinacion"=>$r->idac,
							"idanio"=>$r->idanio,
							"idproyecto"=>$r->idp,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
						);
			$id = $this->model->insertRow($data,0);
			for ($i=0; $i < count($r->idaa); $i++) { 
				$arr = array("idap_pbrm02a"=>$id,
							"codigo"=>$r->numero[$i],
							"meta"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"anual"=>$r->anual[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"porc1"=>$r->porc1[$i],
							"porc2"=>$r->porc2[$i],
							"porc3"=>$r->porc3[$i],
							"porc4"=>$r->porc4[$i],
						);
				$this->model->getInsertTable($arr,"ui_ap_pbrm02a_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	function postEdit( Request $r)
	{
		try {
			for ($i=0; $i < count($r->idaa); $i++) { 
				$arr = array(
							"codigo"=>$r->numero[$i],
							"meta"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"anual"=>$r->anual[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"porc1"=>$r->porc1[$i],
							"porc2"=>$r->porc2[$i],
							"porc3"=>$r->porc3[$i],
							"porc4"=>$r->porc4[$i],
						);
				$this->model->getUpdateTable($arr,"ui_ap_pbrm02a_reg","idap_pbrm02a_reg", $r->idaa[$i]);
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		//Asignación de valores
		$this->data['id'] = $decoder['id'];//idpbrma01c
		$this->data['anio'] = $decoder['anio'];//anio
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$this->data['idac'] = $decoder['idac'];//ui_instituciones
		//Institución logos
		$ins = $this->model->getInstitucion($decoder['idi']);
		$this->data['ins'] = $ins[0];
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		//proyectos
		$proy = $this->model->getPbrmaa($decoder['id']);
		$this->data['proy'] = $proy[0];
		$this->data['projects'] = $this->model->getProyectosPbrmaa($decoder['id']);;
		return view('pbrmaa.pdf.view',$this->data);
	}	
	public function getMetaspbrmc( Request $r )
	{
		$this->data['rows'] = $this->model->getMetasPbrmc($r->id,$r->idanio,$r->idac);
		return view('pbrmaa.metas',$this->data);
	}
	
	public function getGenerarpdf( Request $r )
	{
		$proy=$this->model->getPbrmaa($r->id);
		$this->data['proy'] = $proy[0];
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		//$this->data['projects'] = $this->model->getProyectosPbrmaa($r->id);
		$this->data['txt_titular_dep'] = $r->txt_titular_dep;
		$this->data['txt_tesorero'] = $r->txt_tesorero;
		$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
		$this->data['txt_fecha'] = $r->txt_fecha;
		$this->data['anio'] = $r->anio;
		$this->data['idi'] = $r->idi;

		//Institución logos
		$ins = $this->model->getInstitucion($r->idi);
		$this->data['ins'] = $ins[0];

		$directory = "archivos/anteproyectos/pbrma02a/{$r->anio}/{$r->id}";
		$folder = public_path($directory);
		$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
		
		/*
		* 2024-01-09, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
		* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
		*/

		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
		'margin_top' => 80,
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_bottom' => 35,
		]);
		$this->data['projects'] = $this->model->getProyectosPbrmaa($r->id);
		$mpdf->SetHTMLHeader(View::make("pbrmaa.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("pbrmaa.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('pbrmaa.pdf.pdf',$this->data));
	
		//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
		$time = time();
		$filename = '/'.$r->id."_ ".$time.'.pdf';
		$url = $folder.$filename;
		$mpdf->Output($url, 'F');//Save PDF in directory

		$this->model->insertRow(array("url"=> $directory.$filename), $r->id);
		
		$response = array("success"=>"ok","url"=>asset($directory.$filename));
		return json_encode($response);
	}
	public function getDestroy( Request $r )
	{
		foreach ($this->model->getProyectosPbrmaa($r->id) as $v) {
			$this->model->getDestroyTable("ui_ap_pbrm02a_reg","idap_pbrm02a_reg",$v->idap_pbrm02a_reg);
		}
		$this->model->destroy($r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getRevertir( Request $r )
	{
		try {
			$row  = $this->model->find($r->id,['url']);
			$ruta = public_path($row->url);
			if (is_file($ruta)) {
				\File::delete($ruta);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar, '.$e->getMessage());
		}
		$this->model->insertRow(array("url"=>null),$r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
}