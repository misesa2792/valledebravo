<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrmd;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PbrmdController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrmd';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrmd();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrmd',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('pbrmd.index',$this->data);
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
		$gp = \Auth::user()->group_id;
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
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
		return view('pbrmd.principal',$this->data);
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
		return view('pbrmd.anio',$this->data);
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
		return view('pbrmd.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		//Obtengo todos los proyectos registrados
		$this->data['rows_pilares'] = $this->model->getPilares($r->idperiodo);
		$this->data['rows_programas'] = $this->model->getProgramas();
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		return view('pbrmd.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		$rows = $this->model->getPbrmd($r->id);
		$this->data['rows'] = $rows[0];
		$this->data['registros'] = $this->model->getProyectosPbrmd($r->id);
		//Obtengo todos los proyectos registrados
		$this->data['rows_pilares'] = $this->model->getPilares($r->idperiodo);
		$this->data['rows_programas'] = $this->model->getProgramas();
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		return view('pbrmd.edit',$this->data);
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_ap_pbrm01d_reg","idap_pbrm01d_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getDatapilares( Request $r )
	{
		return json_encode($this->model->getPilaresTemas($r->id));
	}
	public function getDataobjetivo( Request $r )
	{
		$row = $this->model->getProgramasID($r->id);
		return json_encode($row[0]);
	}
	public function getAddtr( Request $r)
	{
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		$this->data['time'] = rand(3,100).time();
		return view('pbrmd.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea_coordinacion"=>$r->idac,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idp,
							"idpdm_pilares"=>$r->idpdm_pilares,
							"temas_desarrollo"=>$r->temas_desarrollo,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
							"nombre_indicador"=>$r->nombre_indicador,
							"formula"=>$r->formula,
							"interpretacion"=>$r->interpretacion,
							"dimencion"=>$r->dimencion,
							"frecuencia"=>$r->frecuencia,
							"factor"=>$r->factor,
							"tipo"=>$r->tipo_ind,
							"desc_factor"=>$r->desc_factor,
							"linea"=>$r->linea,
							"descripcion_meta"=>$r->descripcion_meta,
							"medios_verificacion"=>$r->medios_verificacion,
							"metas_actividad"=>$r->metas_actividad,
							"porc1"=>$r->porc1,
							"porc2"=>$r->porc2,
							"porc3"=>$r->porc3,
							"porc4"=>$r->porc4,
							"porc_anual"=>$r->porc_anual,
						);
			$id = $this->model->insertRow($data,0);
			for ($i=0; $i < count($r->idad); $i++) { 
				$arr = array("idap_pbrm01d"=>$id,
							"indicador"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"tipo_operacion"=>$r->tipo[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"trim4"=>$r->trim4[$i],
							"anual"=>$r->anual[$i],
						);
				$this->model->getInsertTable($arr,"ui_ap_pbrm01d_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!'.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	function postEdit( Request $r)
	{
		try {
			$data = array(
							"idprograma"=>$r->idp,
							"idpdm_pilares"=>$r->idpdm_pilares,
							"temas_desarrollo"=>$r->temas_desarrollo,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
							"nombre_indicador"=>$r->nombre_indicador,
							"formula"=>$r->formula,
							"interpretacion"=>$r->interpretacion,
							"dimencion"=>$r->dimencion,
							"frecuencia"=>$r->frecuencia,
							"factor"=>$r->factor,
							"tipo"=>$r->tipo_ind,
							"desc_factor"=>$r->desc_factor,
							"linea"=>$r->linea,
							"descripcion_meta"=>$r->descripcion_meta,
							"medios_verificacion"=>$r->medios_verificacion,
							"metas_actividad"=>$r->metas_actividad,
							"porc1"=>$r->porc1,
							"porc2"=>$r->porc2,
							"porc3"=>$r->porc3,
							"porc4"=>$r->porc4,
							"porc_anual"=>$r->porc_anual,
						);
			$id = $this->model->insertRow($data,$r->id);
			for ($i=0; $i < count($r->idad); $i++) { 
				$arr = array("idap_pbrm01d"=>$id,
							"indicador"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"tipo_operacion"=>$r->tipo[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"trim4"=>$r->trim4[$i],
							"anual"=>$r->anual[$i],
						);
				if($r->idad[$i] == "0"){
					$this->model->getInsertTable($arr,"ui_ap_pbrm01d_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_ap_pbrm01d_reg","idap_pbrm01d_reg",$r->idad[$i]);
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!'.$e->getMessage());
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
		$proy = $this->model->getPbrmd($decoder['id']);
		$this->data['proy'] = $proy[0];
		$this->data['projects'] = $this->model->getProyectosPbrmd($decoder['id']);;
		return view('pbrmd.pdf.view',$this->data);
	}	
	public function getGenerarpdf( Request $r )
	{
		$proy=$this->model->getPbrmd($r->id);
		$this->data['proy'] = $proy[0];
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['projects'] = $this->model->getProyectosPbrmd($r->id);
		$this->data['txt_titular_dep'] = $r->txt_titular_dep;
		$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
		$this->data['txt_titular_dep_cargo'] = $r->txt_titular_dep_cargo;
		$this->data['txt_titular_uippe_cargo'] = $r->txt_titular_uippe_cargo;
		$this->data['anio'] = $r->anio;
		$this->data['idi'] = $r->idi;

		//Institución logos
		$ins = $this->model->getInstitucion($r->idi);
		$this->data['ins'] = $ins[0];

		$directory = "archivos/anteproyectos/pbrma01d/{$r->anio}/{$r->id}";
		$folder = public_path($directory);
		$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
		
		
		/*
		* 2024-01-09, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
		* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
		*/

		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
		'margin_top' => 35,
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_bottom' => 35,
		]);

		$mpdf->SetHTMLHeader(View::make("pbrmd.pdf.header", $this->data)->render());
		$mpdf->WriteHTML(view('pbrmd.pdf.pdf',$this->data));
		$mpdf->SetHTMLFooter(View::make("pbrmd.pdf.footer", $this->data)->render());
		
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
		foreach ($this->model->getProyectosPbrmd($r->id) as $v) {
			$this->model->getDestroyTable("ui_ap_pbrm01d_reg","idap_pbrm01d_reg",$v->idap_pbrm01d_reg);
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