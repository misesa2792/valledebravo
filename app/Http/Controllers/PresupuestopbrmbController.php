<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrmb;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use App\Services\PrespbrmbService;

class PresupuestopbrmbController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrmb';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrmb();
		$this->pbrmbService = new PrespbrmbService();

		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrmb',
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
		return view('presupuestopbrmb.index',$this->data);
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
		return view('presupuestopbrmb.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			$this->data['token'] = $request->k;
			$this->data['idy'] = $request->idy;
			$this->data['year'] = $request->year;
			$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);

			//Para el año 2025 se va a usar otra tabla llamada : ui_pd_pbrm01a
			if($request->year >= "2025"){
				return view('presupuestopbrmb.programas.index',$this->data);
			}else{
				return view('presupuestopbrmb.anio',$this->data);
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
							"number"=>$v->url,
						);
		}
		$pres = 0.00;
		return array("data" 		=> $data, 
					"contador" 		=> count($data)
				);
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
							"url"=>(empty($v->url) ? "NO" : "PDF"),
						);
		}
		$pres = 0.00;
		return array("data" 		=> $data, 
					"contador" 		=> count($data)
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
			$this->data['programas'] = $this->model->getProgramasPbRMa($r->idanio, $decoder['ida']);
			$proy = $this->model->getCatDepGen($decoder['ida']);
			$this->data['proy'] = $proy[0];
			return view('presupuestopbrmb.add',$this->data);
		}
	}
	function postSave( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$data = array("idarea"=>$decoder['ida'],
								"idanio"=>$r->idanio,
								"idprograma"=>$r->idprograma,
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
								"objetivo_programa"=>$r->objetivo_programa,
								"pdm"=>$r->pdm,
								"estrategias_objetivo"=>$r->estrategias_objetivo,
								"ods"=>$r->ods,
								"std_delete"=>1,
							);
				$id = $this->model->insertRow($data,0);
	
				//Nuevos registros
				if(isset($r->idfoda1)){
					for ($i=0; $i < count($r->idfoda1); $i++) { 
						if(!empty($r->foda1[$i])){
							$this->getInsertFoda($id, 1, $r->foda1[$i]);
						}
					}
				}
				if(isset($r->idfoda2)){
					for ($i=0; $i < count($r->idfoda2); $i++) { 
						if(!empty($r->foda2[$i])){
							$this->getInsertFoda($id, 2, $r->foda2[$i]);
						}
					}
				}
				if(isset($r->idfoda3)){
					for ($i=0; $i < count($r->idfoda3); $i++) { 
						if(!empty($r->foda3[$i])){
							$this->getInsertFoda($id, 3, $r->foda3[$i]);
						}
					}
				}
				if(isset($r->idfoda4)){
					for ($i=0; $i < count($r->idfoda4); $i++) { 
						if(!empty($r->foda4[$i])){
							$this->getInsertFoda($id, 4, $r->foda4[$i]);
						}
					}
				}
	
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar presupuesto!');
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	private function getInsertFoda($id,$type, $desc){
		$data = array("idpres_pbrm01b"=>$id, 
						"type"=>$type,
						"descripcion"=>$desc,
					);
		$this->model->getInsertTable($data,"ui_pres_pbrm01b_foda");	
	}
	private function getUpdateFoda($id,$type, $desc){
		$data = array("descripcion"=>$desc);
		$this->model->getUpdateTable($data,"ui_pres_pbrm01b_foda","idpres_pbrm01b_foda",$id);	
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Token
			$this->data['token'] = $r->key;
			//Information
			$proy = $this->model->getPbrmb($decoder['id']);
			$this->data['proy'] = $proy[0];
			//FODA
			$this->data['foda1'] = $this->model->getPbrmbFoda($decoder['id'],1); 
			$this->data['foda2'] = $this->model->getPbrmbFoda($decoder['id'],2); 
			$this->data['foda3'] = $this->model->getPbrmbFoda($decoder['id'],3); 
			$this->data['foda4'] = $this->model->getPbrmbFoda($decoder['id'],4); 
			//View
			return view('presupuestopbrmb.edit',$this->data);
		}
	}
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			try {
				$data = array(
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
								"objetivo_programa"=>$r->objetivo_programa,
								"pdm"=>$r->pdm,
								"estrategias_objetivo"=>$r->estrategias_objetivo,
								"ods"=>$r->ods,
							);
				$id = $this->model->insertRow($data, $decoder['id']);

				//Nuevos registros
				if(isset($r->idfoda1)){
					for ($i=0; $i < count($r->idfoda1); $i++) { 
						if(!empty($r->foda1[$i])){
							$this->getInsertFoda($id, 1, $r->foda1[$i]);
						}
					}
				}
				if(isset($r->idfoda2)){
					for ($i=0; $i < count($r->idfoda2); $i++) { 
						if(!empty($r->foda2[$i])){
							$this->getInsertFoda($id, 2, $r->foda2[$i]);
						}
					}
				}
				if(isset($r->idfoda3)){
					for ($i=0; $i < count($r->idfoda3); $i++) { 
						if(!empty($r->foda3[$i])){
							$this->getInsertFoda($id, 3, $r->foda3[$i]);
						}
					}
				}
				if(isset($r->idfoda4)){
					for ($i=0; $i < count($r->idfoda4); $i++) { 
						if(!empty($r->foda4[$i])){
							$this->getInsertFoda($id, 4, $r->foda4[$i]);
						}
					}
				}
				//Update rows
				if(isset($r->id1)){
					for ($i=0; $i < count($r->id1); $i++) { 
						if(!empty($r->desc1[$i])){
							$this->getUpdateFoda($r->id1[$i], 1, $r->desc1[$i]);
						}
					}
				}
				if(isset($r->id2)){
					for ($i=0; $i < count($r->id2); $i++) { 
						if(!empty($r->desc2[$i])){
							$this->getUpdateFoda($r->id2[$i], 2, $r->desc2[$i]);
						}
					}
				}
				if(isset($r->id3)){
					for ($i=0; $i < count($r->id3); $i++) { 
						if(!empty($r->desc3[$i])){
							$this->getUpdateFoda($r->id3[$i], 3, $r->desc3[$i]);
						}
					}
				}
				if(isset($r->id4)){
					for ($i=0; $i < count($r->id4); $i++) { 
						if(!empty($r->desc4[$i])){
							$this->getUpdateFoda($r->id4[$i], 4, $r->desc4[$i]);
						}
					}
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto definitivo!');
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
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
			$nombreArchivo = date('d-m-Y') . " Presupuesto Definitivo PbRM-01b.pdf";
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
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;
			$this->data['json'] = $this->pbrmbService->getInfoPbrmb($decoder);
			return view('templates.presupuesto.pbrmb.view_new',$this->data);
		}
	}
	public function postGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Validaciones de campos
			if(empty($r->footer1)){
				$response = ["status"=>"error","message"=>"Ingresa nombre del titular de la dependencia"];
				return response()->json($response);
			}else if(empty($r->footer2)){
				$response = ["status"=>"error","message"=>"Ingresa nombre del tesorero municipal"];
				return response()->json($response);
			}else if(empty($r->footer3)){
				$response = ["status"=>"error","message"=>"Ingresa nombre de titular de la UIPPE"];
			}

			$json = json_decode($r->input('json'), true);

			$this->data['json'] = $json;

			$this->data['footer1'] = $r->footer1;
			$this->data['footer2'] = $r->footer2;
			$this->data['footer3'] = $r->footer3;
			$this->data['cargo1'] = $r->cargo1;//Titular Dep_Gen
			$this->data['cargo2'] = $r->cargo2;//Tesorero
			$this->data['cargo3'] = $r->cargo3;//UIPPE

			//Se construye el nombre del PDF
			$number = $this->getBuildFilenamePDF("PD1B",$json['header']['no_institucion'], $json['header']['no_dep_gen'], $decoder['id']);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectory($json['header']['no_institucion'], $json['header']['anio'], 'pres', '01b');
			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
								'margin_top' => 30,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 35,]);
			// Establece el encabezado y pie de página
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmb.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmb.pdf_body',$this->data));
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmb.pdf_footer", $this->data)->render());

			$url = $result['full_path'].$filename;
			//Save PDF in directory
			$mpdf->Output($url, 'F');
			$this->model->getUpdateTable(['url' => $number], 'ui_pres_pbrm01b',  'idpres_pbrm01b', $decoder['id']);
			$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
			$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{
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
	public function postReversenew( Request $r )
	{
		$request = $r->params;
		$decoder = SiteHelpers::CF_decode_json($request['key']);
		if($decoder){
			$this->model->getUpdateTable(['url' => null], "ui_pres_pbrm01b", "idpres_pbrm01b", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($request['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	public function deleteDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Se cambia el estatus a eliminado y se coloca en null el valor de la URL
			$this->model->insertRow(array("std_delete"=>"2"),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return response()->json($response);
	}
	public function getAddfodatr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		$this->data['num'] = $r->num;
		return view('presupuestopbrmb.foda.tr',$this->data);	
	}
	function getEliminarfodatr(Request $r){
		$this->model->getDestroyTable("ui_pres_pbrm01b_foda","idpres_pbrm01b_foda",$r->id);
		$response = array("success"=>"ok");
		return response()->json($response);
	}
}