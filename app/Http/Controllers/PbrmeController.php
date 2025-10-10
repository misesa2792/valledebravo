<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrme;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,SiteHelpers ; 
use Illuminate\Support\Facades\View;

class PbrmeController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrme';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrme();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrme',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('pbrme.index',$this->data);
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
			$rows = $this->model->getAreasGeneralForYear($this->data['idi'], $request->idy);
		}else{
			$permiso = $this->model->getPermisoAreaForYear(\Auth::user()->id, $request->idy);
			$rows = $this->model->getAreasEnlacesGeneralForYear($permiso[0]->permiso,$this->data['idi']);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('pbrme.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		$this->data['ida'] = $decoder['ida'];
		$this->data['idi'] = $decoder['idi'];
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		$this->data['k'] = $request->k;
		$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		return view('pbrme.anio',$this->data);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$data = array();
		$data[] = array("idanio"=>$r->idy,
						"anio"=>$r->year,
						"rows"=>$this->model->getProgramasAnio($decoder['ida'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('pbrme.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$this->data['programas'] = $this->model->getProgramas();
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		return view('pbrme.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$row = $this->model->getPbrme($r->id);
		$this->data['row'] = $row[0];
		$this->data['programas'] = $this->model->getProgramas();
		$this->data['rows1'] = $this->model->getProyectosPbrme($r->id,1);
		$this->data['rows2'] = $this->model->getProyectosPbrme($r->id,2);
		$this->data['rows3'] = $this->model->getProyectosPbrme($r->id,3);
		$this->data['rows4'] = $this->model->getProyectosPbrme($r->id,4);
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		return view('pbrme.edit',$this->data);
	}
	public function getAddtr( Request $r)
	{
		$this->data['no'] = $r->no;
		$this->data['text'] = $r->text;
		$this->data['time'] = rand(3,100).time();
		return view('pbrme.tr',$this->data);	
	}
	function postSave( Request $r)
	{
	
		try {
			$data = array("idarea"=>$r->idarea,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idprograma,
							"pilar"=>$r->pilar,
							"tema"=>$r->tema,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>date('H:i:s A'),
						);
			$id = $this->model->insertRow($data,0);

			$da1 = array("idap_pbrm01e"=>$id,"idap_pbrm01e_tipo"=>1,"descripcion"=>$r->tipo1,"nombre"=>$r->nombre1,"formula"=>$r->formula1,"frecuencia"=>$r->frecuencia1,"medios"=>$r->medios1,"supuestos"=>$r->supuestos1);
			$this->model->getInsertTable($da1,"ui_ap_pbrm01e_reg");
			$da2 = array("idap_pbrm01e"=>$id,"idap_pbrm01e_tipo"=>2,"descripcion"=>$r->tipo2,"nombre"=>$r->nombre2,"formula"=>$r->formula2,"frecuencia"=>$r->frecuencia2,"medios"=>$r->medios2,"supuestos"=>$r->supuestos2);
			$this->model->getInsertTable($da2,"ui_ap_pbrm01e_reg");
			//En componentes y actividades se agrega más de uno
			for ($i=0; $i < count($r->tipo3); $i++) { 
				$da3 = array("idap_pbrm01e"=>$id,
							"idap_pbrm01e_tipo"=>3,
							"descripcion"=>$r->tipo3[$i],
							"nombre"=>$r->nombre3[$i],
							"formula"=>$r->formula3[$i],
							"frecuencia"=>$r->frecuencia3[$i],
							"medios"=>$r->medios3[$i],
							"supuestos"=>$r->supuestos3[$i]);
				$this->model->getInsertTable($da3,"ui_ap_pbrm01e_reg");
			}
			for ($i=0; $i < count($r->tipo4); $i++) { 
				$da4 = array("idap_pbrm01e"=>$id,
							"idap_pbrm01e_tipo"=>4,
							"descripcion"=>$r->tipo4[$i],
							"nombre"=>$r->nombre4[$i],
							"formula"=>$r->formula4[$i],
							"frecuencia"=>$r->frecuencia4[$i],
							"medios"=>$r->medios4[$i],
							"supuestos"=>$r->supuestos4[$i]);
				$this->model->getInsertTable($da4,"ui_ap_pbrm01e_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar anteproyecto! '.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	function postEdit( Request $r)
	{
	
		try {
			$data = array("idarea"=>$r->idarea,
							"idprograma"=>$r->idprograma,
							"pilar"=>$r->pilar,
							"tema"=>$r->tema,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>date('H:i:s A'),
						);
			$id = $this->model->insertRow($data,$r->id);
			
			$da1 = array("descripcion"=>$r->tipo1,"nombre"=>$r->nombre1,"formula"=>$r->formula1,"frecuencia"=>$r->frecuencia1,"medios"=>$r->medios1,"supuestos"=>$r->supuestos1);
			$this->model->getUpdateTable($da1,"ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$r->idproy_pbrm01e_reg1);

			$da2 = array("descripcion"=>$r->tipo2,"nombre"=>$r->nombre2,"formula"=>$r->formula2,"frecuencia"=>$r->frecuencia2,"medios"=>$r->medios2,"supuestos"=>$r->supuestos2);
			$this->model->getUpdateTable($da2,"ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$r->idproy_pbrm01e_reg2);
			//En componentes y actividades se agrega más de uno
			if(isset($r->tipo3)){
				for ($i=0; $i < count($r->tipo3); $i++) { 
					$da3 = array("idap_pbrm01e"=>$id,
								"idap_pbrm01e_tipo"=>3,
								"descripcion"=>$r->tipo3[$i],
								"nombre"=>$r->nombre3[$i],
								"formula"=>$r->formula3[$i],
								"frecuencia"=>$r->frecuencia3[$i],
								"medios"=>$r->medios3[$i],
								"supuestos"=>$r->supuestos3[$i]);
					if($r->idproy_pbrm01e_reg3[$i] > 0){
						$this->model->getUpdateTable($da3,"ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$r->idproy_pbrm01e_reg3[$i]);
					}else{
						$this->model->getInsertTable($da3,"ui_ap_pbrm01e_reg");
					}
				}
			}
			if(isset($r->tipo4)){
				for ($i=0; $i < count($r->tipo4); $i++) { 
					$da4 = array("idap_pbrm01e"=>$id,
								"idap_pbrm01e_tipo"=>4,
								"descripcion"=>$r->tipo4[$i],
								"nombre"=>$r->nombre4[$i],
								"formula"=>$r->formula4[$i],
								"frecuencia"=>$r->frecuencia4[$i],
								"medios"=>$r->medios4[$i],
								"supuestos"=>$r->supuestos4[$i]);
					if($r->idproy_pbrm01e_reg4[$i] > 0){
						$this->model->getUpdateTable($da4,"ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$r->idproy_pbrm01e_reg4[$i]);
					}else{
						$this->model->getInsertTable($da4,"ui_ap_pbrm01e_reg");
					}
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar anteproyecto! '.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
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
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		//Asignación de valores
		$this->data['id'] = $decoder['id'];//idpbrma01a
		$this->data['anio'] = $decoder['anio'];//anio
		$this->data['idi'] = $decoder['idi'];//ui_instituciones

		//Institución logos
		$ins = $this->model->getInstitucion($decoder['idi']);
		$this->data['ins'] = $ins[0];

		$area = $this->model->getCatDepGen($decoder['idarea']);
		$this->data['area'] = $area[0];
		$row = $this->model->getPbrme($decoder['id']);
		$this->data['row'] = $row[0];
		$this->data['rows_projects1'] = $this->model->getProyectosPbrme($decoder['id'],1);
		$this->data['rows_projects2'] = $this->model->getProyectosPbrme($decoder['id'],2);
		$this->data['rows_projects3'] = $this->model->getProyectosPbrme($decoder['id'],3);
		$this->data['rows_projects4'] = $this->model->getProyectosPbrme($decoder['id'],4);
		return view('pbrme.pdf.view',$this->data);
	}
	public function getGenerarpdf( Request $r )
	{
		$row=$this->model->getPbrme($r->id);
		$this->data['row'] = $row[0];
		$this->data['rows_projects1'] = $this->model->getProyectosPbrme($r->id,1);
		$this->data['rows_projects2'] = $this->model->getProyectosPbrme($r->id,2);
		$this->data['rows_projects3'] = $this->model->getProyectosPbrme($r->id,3);
		$this->data['rows_projects4'] = $this->model->getProyectosPbrme($r->id,4);
		$this->data['txt_titular_dep'] = $r->txt_titular_dep;
		$this->data['txt_tesorero'] = $r->txt_tesorero;
		$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
		$this->data['anio'] = $r->anio;
		$this->data['idi'] = $r->idi;

		//Institución logos
		$ins = $this->model->getInstitucion($r->idi);
		$this->data['ins'] = $ins[0];

		$directory = "archivos/anteproyectos/pbrma01e/{$r->anio}/{$r->id}";
		$folder = public_path($directory);
		$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
		
		/*
		* 2024-01-07, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
		* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
		*/

		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
		'margin_top' => 30,
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_bottom' => 35,
		]);
		// Configurar encabezado
		$mpdf->SetHTMLHeader(View::make("pbrme.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("pbrme.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('pbrme.pdf.pdf',$this->data));

		//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
		$time = time();
		$filename = '/'.$r->id."_ ".$time.'.pdf';
		$url = $folder.$filename;
		$mpdf->Output($url, 'F');//Save PDF in directory
		//return $mpdf->Output();//Save PDF in directory

		$this->model->insertRow(array("url"=> $directory.$filename), $r->id);
		
		$response = array("success"=>"ok","url"=>asset($directory.$filename));
		return json_encode($response);
	}
	public function getDestroy( Request $r )
	{
		foreach ($this->model->getProyectosPbrmeInd($r->id) as $v) {
			$this->model->getDestroyTable("ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$v->idap_pbrm01e_reg);
		}
		$this->model->destroy($r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_ap_pbrm01e_reg","idap_pbrm01e_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}

}