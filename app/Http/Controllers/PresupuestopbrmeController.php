<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrme;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use App\Services\PrespbrmeService;

class PresupuestopbrmeController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrme';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrme();
		$this->pbrmeService = new PrespbrmeService();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrme',
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
		return view('presupuestopbrme.index',$this->data);
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
		return view('presupuestopbrme.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			$this->data['ida'] = $decoder['ida'];
			$this->data['idi'] = $decoder['idi'];
			$this->data['idy'] = $request->idy;
			$this->data['year'] = $request->year;
			$this->data['token'] = $request->k;
			$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);
			$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
			if($request->year >= "2025"){
				return view('presupuestopbrme.programas.index',$this->data);
			}else{
				return view('presupuestopbrme.anio',$this->data);
			}
		}else{
			return view('errors.414');
		}
	}
	public function getSearchnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$data = $this->getRowsProyectosNew($decoder['ida'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectosNew($idarea, $idanio){
		$data = array();
		foreach ($this->model->getProgramasAnio($idarea, $idanio) as $v) {
			$data[] = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa"=>$v->no_programa,
							"programa"=>$v->programa,
							"number"=>$v->url
						);
		}
		return array("data" 		=> $data, 
					"contador" 		=> count($data), 
				);
	}
	public function postReversenew( Request $r )
	{
		$request = $r->params;
		$decoder = SiteHelpers::CF_decode_json($request['key']);
		if($decoder){
			$this->model->getUpdateTable(['url' => null], "ui_pres_pbrm01e", "idpres_pbrm01e", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($request['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$data = $this->getRowsProyectos($decoder['ida'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectos($idarea, $idanio){
		$data = array();
		foreach ($this->model->getProgramasAnio($idarea, $idanio) as $v) {
			$data[] = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa"=>$v->no_programa,
							"programa"=>$v->programa,
							"url"=>(empty($v->url) ? "NO" : "PDF")
						);
		}
		return array("data" 		=> $data, 
					"contador" 		=> count($data), 
				);
	}
	public function getAdd( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			$proy = $this->model->getCatDepGen($decoder['ida']);
			$this->data['proy'] = $proy[0];
			$this->data['programas'] = $this->model->getProgramasPbRMa($r->idanio, $decoder['ida']);
			$this->data['rows_frec_medicion'] = $this->model->getCatFrecuenciaMedicion();
			$this->data['rows_tipo_indicador'] = $this->model->getCatTipoIndicador();
			return view('presupuestopbrme.add',$this->data);
		}
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;
			$this->data['rows_frec_medicion'] = $this->model->getCatFrecuenciaMedicion();
			$this->data['rows_tipo_indicador'] = $this->model->getCatTipoIndicador();
			$this->data['json'] = $this->pbrmeService->getInfoPbrme($decoder);
			return view('presupuestopbrme.matriz.edit',$this->data);
		}
	}
	private function getSelectPilares($idpilar){
		$data = [];
		foreach ($this->model->getPilaresTemas() as $key => $v) {
			if($v->idpilar == $idpilar){
				$data[] = array("idtema" => $v->idtema, "no_tema" => $v->no_tema, "tema" => $v->tema);
			}
		}
		return $data;
	}
	public function getAddtr( Request $r)
	{
		$this->data['tr_tmp'] 	= 'no';//Estatus que me permite saber cuando se edita si va a usar el tmp de campos llenos
		$this->data['tr_no'] 	= $r->no;
		$this->data['tr_name'] 	= $r->text;
		$this->data['time'] 	= rand(3,100).time();
		$this->data['tr_rows'] 	= [];
		$this->data['rows_frec_medicion'] = $this->model->getCatFrecuenciaMedicion();
		$this->data['rows_tipo_indicador'] = $this->model->getCatTipoIndicador();
		return view($this->module.'.matriz.includetrmulti',$this->data);	
	}
	function postSavemanual( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$data = ["idarea"	=> $decoder['ida'],
						"idanio"	=> $r->idanio,
						"idprograma"=> $r->idprograma,
						"tema"		=> $r->tema,
						"fecha_rg"	=> date('Y-m-d'),
						"hora_rg"	=> date('H:i:s A'),
						"std_delete"=> 1
						];
				$id = $this->model->insertRow($data,0);
				//Fin
				$da1 = ["idpres_pbrm01e"		=> $id,
						"idpres_pbrm01e_tipo"	=> 1,
						"descripcion"			=> $r->tipo1,
						"nombre"				=> $r->nombre1,
						"formula"				=> $r->formula1,
						"idfrecuencia_medicion"	=> $r->fi1,
						"idtipo_indicador"		=> $r->ti1,
						"medios"				=> $r->medios1,
						"supuestos"				=> $r->supuestos1
						];
				$this->model->getInsertTable($da1,"ui_pres_pbrm01e_reg");
				//Proposito
				$da2 = ["idpres_pbrm01e"		=> $id,
						"idpres_pbrm01e_tipo"	=> 2,
						"descripcion"			=> $r->tipo2,
						"nombre"				=> $r->nombre2,
						"formula"				=> $r->formula2,
						"idfrecuencia_medicion"	=> $r->fi2,
						"idtipo_indicador"		=> $r->ti2,
						"medios"				=> $r->medios2,
						"supuestos"				=> $r->supuestos2
						];
				$this->model->getInsertTable($da2,"ui_pres_pbrm01e_reg");
				//Componentes
				for ($i=0; $i < count($r->tipo3); $i++) { 
					$da3 = ["idpres_pbrm01e"		=> $id,
							"idpres_pbrm01e_tipo"	=> 3,
							"descripcion"			=> $r->tipo3[$i],
							"nombre"				=> $r->nombre3[$i],
							"formula"				=> $r->formula3[$i],
							"idfrecuencia_medicion"	=> $r->fi3[$i],
							"idtipo_indicador"		=> $r->ti3[$i],
							"medios"				=> $r->medios3[$i],
							"supuestos"				=> $r->supuestos3[$i]
							];
					$this->model->getInsertTable($da3,"ui_pres_pbrm01e_reg");
				}
				//Actividades
				for ($i=0; $i < count($r->tipo4); $i++) { 
					$da4 = ["idpres_pbrm01e"			=> $id,
							"idpres_pbrm01e_tipo"		=> 4,
							"descripcion"				=> $r->tipo4[$i],
							"nombre"					=> $r->nombre4[$i],
							"formula"					=> $r->formula4[$i],
							"idfrecuencia_medicion"		=> $r->fi4[$i],
							"idtipo_indicador"			=> $r->ti4[$i],
							"medios"					=> $r->medios4[$i],
							"supuestos"					=> $r->supuestos4[$i]
							];
					$this->model->getInsertTable($da4,"ui_pres_pbrm01e_reg");
				}
				$response = ["status"=>"ok", "message"=>"Información guardada correctamente."];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar presupuesto! '.$e->getMessage());
				$response = ["status"=>"no", "message"=>"Error al guardar información."];
			}
		}else{
			$response = ["status"=>"no", "message"=>"Error de key."];
		}
		return response()->json($response);
	}
	function postSaveautomatico( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$data = array("idarea"=>$decoder['ida'],
								"idanio"=>$r->idanio,
								"idprograma"=>$r->idprograma,
								"tema"=>$r->tema,
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
								"std_delete"=>1,
							);
				$id = $this->model->insertRow($data,0);

				$fin = json_decode($r->fin);
				$da1 = array("idpres_pbrm01e"		=> $id,
							"idpres_pbrm01e_tipo"	=> 1,
							"descripcion"			=> $fin->descripcion,
							"nombre"				=> $fin->nombre,
							"formula"				=> $fin->formula,
							"idfrecuencia_medicion"	=> $fin->idf,
							"idtipo_indicador"		=> $fin->idt,
							"medios"				=> $fin->medios,
							"supuestos"				=> $fin->supuestos
						);
				$this->model->getInsertTable($da1,"ui_pres_pbrm01e_reg");

				$proposito = json_decode($r->proposito);
				$da2 = array("idpres_pbrm01e"		=> $id,
							"idpres_pbrm01e_tipo"	=> 2,
							"descripcion"			=> $proposito->descripcion,
							"nombre"				=> $proposito->nombre,
							"formula"				=> $proposito->formula,
							"idfrecuencia_medicion"	=> $fin->idf,
							"idtipo_indicador"		=> $fin->idt,
							"medios"				=> $proposito->medios,
							"supuestos"				=> $proposito->supuestos
						);
				$this->model->getInsertTable($da2,"ui_pres_pbrm01e_reg");
				//Componentes
				for ($i=0; $i < count($r->componente); $i++) { 
					$componente = json_decode($r->componente[$i]);
					$da3 = array("idpres_pbrm01e"		=> $id,
								"idpres_pbrm01e_tipo"	=> 3,
								"descripcion"			=> $componente->descripcion,
								"nombre"				=> $componente->nombre,
								"formula"				=> $componente->formula,
								"idfrecuencia_medicion"	=> $fin->idf,
								"idtipo_indicador"		=> $fin->idt,
								"medios"				=> $componente->medios,
								"supuestos"				=> $componente->supuestos);
					$this->model->getInsertTable($da3,"ui_pres_pbrm01e_reg");
				}
				//Actividades
				for ($i=0; $i < count($r->actividad); $i++) { 
					$actividad = json_decode($r->actividad[$i]);
					$da4 = array("idpres_pbrm01e"		=> $id,
								"idpres_pbrm01e_tipo"	=> 4,
								"descripcion"			=> $actividad->descripcion,
								"nombre"				=> $actividad->nombre,
								"formula"				=> $actividad->formula,
								"idfrecuencia_medicion"	=> $fin->idf,
								"idtipo_indicador"		=> $fin->idt,
								"medios"				=> $actividad->medios,
								"supuestos"				=> $actividad->supuestos
							);
					$this->model->getInsertTable($da4,"ui_pres_pbrm01e_reg");
				}
				$response = ["status"=>"ok", "message"=>"Información guardada correctamente."];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar presupuesto! '.$e->getMessage());
				$response = ["status"=>"no", "message"=>"Error al guardar información."];
			}
		}else{
			$response = ["status"=>"no", "message"=>"Error de key."];
		}
		return response()->json($response);
	}
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			try {
				$id = $this->model->insertRow(["tema"=>$r->tema],$decoder['id']);
				//Fin
				$da1 = ["descripcion"			=> $r->tipo1,
						"nombre"				=> $r->nombre1,
						"formula"				=> $r->formula1,
						"idfrecuencia_medicion"	=> $r->fi1,
						"idtipo_indicador"		=> $r->ti1,
						"medios"   				=> $r->medios1,
						"supuestos" 			=> $r->supuestos1
						];
				$this->model->getUpdateTable($da1,"ui_pres_pbrm01e_reg","idpres_pbrm01e_reg",$r->idproy_pbrm01e_reg1);
				//Proposito
				$da2 = ["descripcion"			=> $r->tipo2,
						"nombre"				=> $r->nombre2,
						"formula"				=> $r->formula2,
						"idfrecuencia_medicion"	=> $r->fi2,
						"idtipo_indicador"		=> $r->ti2,
						"medios"				=> $r->medios2,
						"supuestos"				=> $r->supuestos2
						];
				$this->model->getUpdateTable($da2,"ui_pres_pbrm01e_reg","idpres_pbrm01e_reg",$r->idproy_pbrm01e_reg2);
				//Componentes
				if(isset($r->tipo3)){
					for ($i=0; $i < count($r->tipo3); $i++) { 
						$da3 = ["idpres_pbrm01e"		=> $id,
								"idpres_pbrm01e_tipo"	=> 3,
								"descripcion"			=> $r->tipo3[$i],
								"nombre"				=> $r->nombre3[$i],
								"formula"				=> $r->formula3[$i],
								"idfrecuencia_medicion"	=> $r->fi3[$i],
								"idtipo_indicador"		=> $r->ti3[$i],
								"medios"				=> $r->medios3[$i],
								"supuestos"				=> $r->supuestos3[$i]
								];
						if($r->idproy_pbrm01e_reg3[$i] > 0){
							$this->model->getUpdateTable($da3,"ui_pres_pbrm01e_reg","idpres_pbrm01e_reg",$r->idproy_pbrm01e_reg3[$i]);
						}else{
							$this->model->getInsertTable($da3,"ui_pres_pbrm01e_reg");
						}
					}
				}
				//Actividades
				if(isset($r->tipo4)){
					for ($i=0; $i < count($r->tipo4); $i++) { 
						$da4 = ["idpres_pbrm01e"		=> $id,
								"idpres_pbrm01e_tipo"	=> 4,
								"descripcion"			=> $r->tipo4[$i],
								"nombre"				=> $r->nombre4[$i],
								"formula"				=> $r->formula4[$i],
								"idfrecuencia_medicion"	=> $r->fi4[$i],
								"idtipo_indicador"		=> $r->ti4[$i],
								"medios"				=> $r->medios4[$i],
								"supuestos"				=> $r->supuestos4[$i]
								];
						if($r->idproy_pbrm01e_reg4[$i] > 0){
							$this->model->getUpdateTable($da4,"ui_pres_pbrm01e_reg","idpres_pbrm01e_reg",$r->idproy_pbrm01e_reg4[$i]);
						}else{
							$this->model->getInsertTable($da4,"ui_pres_pbrm01e_reg");
						}
					}
				}
				$response = ["status"=>"ok", "message"=>"Información guardada correctamente."];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error, '.$e->getMessage());
				$response = ["status"=>"no", "message"=>"Error al guardar información."];
			}
		}else{
			$response = ["status"=>"no", "message"=>"Error de key"];
		}
		return response()->json($response);
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_pres_pbrm01e_reg","idpres_pbrm01e_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getDownload( Request $r ){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Obtengo la URL
			$row = $this->model->find($decoder['id'],['url']);
			//Asigno el path completo
			$rutaArchivo = public_path($row->url);
			//Nombre del archivo 
			$nombreArchivo = date('d-m-Y') . " Presupuesto Definitivo PbRM-01e.pdf";
			// Verificar si el archivo existe en el directorio public
			if (file_exists($rutaArchivo)) {
				// Descargar el archivo usando response()->download()
				// Iniciar la transmisión del archivo PDF
				return response()->stream(function () use ($rutaArchivo) {
					// Abrir y enviar el contenido del archivo al flujo de salida
					$stream = fopen($rutaArchivo, 'r');
					fpassthru($stream);
					fclose($stream);
				}, 200, [
					'Content-Type' => 'application/pdf',
					'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
				]);
			}else{
				//Vista si no existe el archivo
				return view('errors.414');
			}
		}else{
			return view('errors.414');
		}
	}
	public function getPdfnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;
			$this->data['json'] = $this->pbrmeService->getInfoPbrme($decoder);
			return view('templates.presupuesto.pbrme.new.view',$this->data);
		}
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Token
			$this->data['token'] = $r->key;
			//Information
			$proy = $this->model->getPbrme($decoder['id']);
			$this->data['proy'] = $proy[0];

			$this->data['rows_projects1'] = $this->model->getProyectosPbrme($decoder['id'],1);
			$this->data['rows_projects2'] = $this->model->getProyectosPbrme($decoder['id'],2);
			$this->data['rows_projects3'] = $this->model->getProyectosPbrme($decoder['id'],3);
			$this->data['rows_projects4'] = $this->model->getProyectosPbrme($decoder['id'],4);
			return view('templates.presupuesto.pbrme.view_new',$this->data);
		}
	}
	public function postGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){

			if(empty($r->footer1)){
				$response = ["status"=>"error","message"=>"Ingresa nombre del titular de la dependencia"];
				return response()->json($response);
			}else if(empty($r->footer2)){
				$response = ["status"=>"error","message"=>"Ingresa nombre del tesorero municipal"];
				return response()->json($response);
			}else if(empty($r->footer3)){
				$response = ["status"=>"error","message"=>"Ingresa nombre de titular de la UIPPE"];
				return response()->json($response);
			}

			$json = json_decode($r->input('json'), true);
			$this->data['json'] = $json;
			$this->data['footer1'] = $r->footer1;
			$this->data['footer2'] = $r->footer2;
			$this->data['footer3'] = $r->footer3;
			$this->data['cargo1'] = $r->cargo1;
			$this->data['cargo2'] = $r->cargo2;
			$this->data['cargo3'] = $r->cargo3;
			//Se construye el nombre del PDF
			$number = $this->getBuildFilenamePDF("PD1E",$json['header']['no_institucion'], $json['header']['no_dep_gen'], $decoder['id']);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectory($json['header']['no_institucion'], $json['header']['year'], 'pres', '01e');
			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
					'margin_top' => 30,
					'margin_left' => 5,
					'margin_right' => 5,
					'margin_bottom' => 30,
				]);
			// Establece el encabezado y pie de página
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrme.new.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrme.new.pdf_body',$this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrme.new.pdf_footer", $this->data)->render());
			$url = $result['full_path'].$filename;
			$mpdf->Output($url, 'F');

			$this->model->getUpdateTable(['url' => $number], 'ui_pres_pbrm01e',  'idpres_pbrm01e', $decoder['id']);
			$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
			$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{	//Information
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	public function postRevertir( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		if($decoder){
			try {
				$row  = $this->model->find($decoder['id'],['url']);
				$ruta = public_path($row->url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al eliminar, '.$e->getMessage());
			}
			$this->model->insertRow(array("url"=>null),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	public function deleteDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->model->insertRow(array("std_delete"=>"2"),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
}