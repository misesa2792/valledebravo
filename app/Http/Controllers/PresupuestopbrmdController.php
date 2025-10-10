<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrmd;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use App\Services\PrespbrmdService;

class PresupuestopbrmdController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrmd';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrmd();
		$this->pbrmdService = new PrespbrmdService();

		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrmd',
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
		return view('presupuestopbrmd.index',$this->data);
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
			$rows = $this->getRowsAreasEnlace($this->data['idi'],$request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('presupuestopbrmd.principal',$this->data);
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
		if($decoder){
			$this->data['ida'] = $decoder['ida'];//idarea
			$this->data['idi'] = $decoder['idi'];//idinstitucion
			$this->data['idac'] = $decoder['idac'];//idarea_coordinacion
			$this->data['idy'] = $request->idy;
			$this->data['year'] = $request->year;
			$this->data['token'] = $request->k;
			$row = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['row'] = $row[0];
			$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
			$this->data['rowsAnios'] = $this->model->getModuleYears();
			if($request->year >= "2025"){
				return view('presupuestopbrmd.programas.index',$this->data);
			}else{
				return view('presupuestopbrmd.anio',$this->data);
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

			$data = $this->getRowsProyectosNew($decoder['idac'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectosNew($idac, $idanio){
		$data = array();
		$contador = 0;
		foreach ($this->model->getProyectosAnio($idac, $idanio) as $v) {
			$contador++;
			$rowsProyectos = array("id"			=>	SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa"		=>	$v->no_programa,
							"programa"			=>	$v->programa,
							"number"			=>	$v->url,
							"nombre_indicador"	=>	$v->nombre_indicador,
							"proyecto"			=>	$v->proyecto,
							"no_proyecto"		=>	$v->no_proyecto,
							"mir"				=>	$v->mir
						);
			if(!isset($data[$v->idprograma])){
				$data[$v->idprograma] = array("no_programa" => $v->no_programa, 
											"programa" => $v->programa,
											'rowsProyectos' => array()
										);
			}
			$data[$v->idprograma]['rowsProyectos'][] = $rowsProyectos;
						
		}
		return array("data" 		=> $data, 
					"contador" 		=> $contador,
				);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){

			$data = $this->getRowsProyectos($decoder['idac'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectos($idac, $idanio){
		$data = array();
		$contador = 0;
		foreach ($this->model->getProyectosAnio($idac, $idanio) as $v) {
			$contador++;

			$rowsProyectos = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa"=>$v->no_programa,
							"programa"=>$v->programa,
							"url"=>(empty($v->url) ? "NO" : "PDF"),
							"nombre_indicador"=>$v->nombre_indicador,
							"proyecto"=>$v->proyecto,
							"no_proyecto"=>$v->no_proyecto,
							"mir"=>$v->mir,
						);
			if(!isset($data[$v->idprograma])){
				$data[$v->idprograma] = array("no_programa" => $v->no_programa, 
											"programa" => $v->programa,
											'rowsProyectos' => array()
										);
			}

			$data[$v->idprograma]['rowsProyectos'][] = $rowsProyectos;
						
		}
		return array("data" 		=> $data, 
					"contador" 		=> $contador,
				);
	}
	public function getAdd( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['rowsProyectos'] = $this->model->getProyectosPbRMa($r->idanio,$decoder['idac']);
			//$this->data['rowsPilares'] = $this->model->getPilaresTemas();
			$this->data['token'] = $r->k;
			$proy = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['proy'] = $proy[0];
			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			//Obtengo todos los proyectos registrados
			//$this->data['rows_pilares'] = $this->model->getPilaresActivos();
			//$this->data['rows_programas'] = $this->model->getProgramas();
			//Obtengo el nombre de la dependencia general y auxiliar
			$this->data['rows_frec_medicion'] = $this->model->getCatFrecuenciaMedicion();
			$this->data['rows_tipo_indicador'] = $this->model->getCatTipoIndicador();
			$this->data['rows_dimension_atiende'] = $this->model->getCatDimensionAtiende();
			return view('presupuestopbrmd.add',$this->data);
		}
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;
			$rows = $this->model->getPbrmdNew($decoder['id']);
			//IDs
			//$this->data['idpdm_pilares_temas'] 	 = $rows[0]->idpdm_pilares_temas;
			$this->data['idproyecto']			 = $rows[0]->idproyecto;
			$this->data['iddimension_atiende']   = $rows[0]->iddimension_atiende;
			$this->data['idfrecuencia_medicion'] = $rows[0]->idfrecuencia_medicion;
			$this->data['idtipo_indicador'] 	 = $rows[0]->idtipo_indicador;
			//Información
			$this->data['row'] 					 = $this->getRowsDataInfo($rows[0]);
			//Proyectos
			$this->data['rowsProyectos'] 		 = $this->model->getProyectosPbRMa($rows[0]->idanio, $rows[0]->idac);
			//$this->data['rowsPilares'] 			 = $this->model->getPilaresTemas();//sximo
			$this->data['rowsTipoOperacion'] 	 = $this->model->getCatTipoOperacion();
			$this->data['rows_frec_medicion'] 	 = $this->model->getCatFrecuenciaMedicion();
			$this->data['rows_tipo_indicador'] 	 = $this->model->getCatTipoIndicador();
			$this->data['rows_dimension_atiende'] = $this->model->getCatDimensionAtiende();
			return view('presupuestopbrmd.edit',$this->data);
		}
	}
	private function getRowsDataInfo($row){
		$data = [
				"header" => ["no_pilar" 	=> $row->no_pilar, 
							"pilar" 		=> $row->pilar,
							"tema" 			=> $row->tema,
							"no_proyecto" 	=> $row->no_proyecto,
							"no_programa" 	=> $row->no_programa,
							"programa" 		=> $row->programa,
							"obj_programa" 	=> $row->obj_programa,
							"year" 			=> $row->anio,
							"logo_izq" 		=> $row->logo_izq
						],
				"indicador" => ["mir" 			=> $row->mir, 
							"nombre" 			=> $row->nombre_indicador,
							"formula" 			=> $row->formula,
							"interpretacion" 	=> $row->interpretacion,
							"dimension" 		=> $row->dimencion,
							"frecuencia" 		=> $row->frecuencia,
							"tipo_indicador" 	=> $row->tipo,
							"factor" => ["nombre" => $row->factor,
										 "descripcion" => $row->desc_factor
										],
							"linea" => $row->linea,
							"porcentaje" => [
												"trim1" => $row->porc1,
												"trim2" => $row->porc2,
												"trim3" => $row->porc3,
												"trim4" => $row->porc4,
												"anual" => $row->porc_anual
											]
						],
				"metas" => ["des" => $row->descripcion_meta, 
							"ver" => $row->medios_verificacion,
							"act" => $row->metas_actividad,
						],
				"dg"	=> ["no_dep_gen" 	=> $row->no_dep_gen,
							"dep_gen" 		=> $row->dep_gen,
							"no_dep_aux" 	=> $row->no_dep_aux,
							"dep_aux" 		=> $row->dep_aux
						],
				"registros"	=> $this->model->getProyectosPbrmd($row->id),
				"footer" => [
							"titular_dep_gen" => $row->titular_dep_gen
						]
				];
		return $data;
	}
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			try {
				$data = array("idproyecto"				=>$r->idproyecto,
								"temas_desarrollo"		=>$r->tema,
								"nombre_indicador"		=>$r->nombre_indicador,
								"formula"				=>$r->formula,
								"interpretacion"		=>$r->interpretacion,
								"iddimension_atiende"	=>$r->dimencion,
								"idfrecuencia_medicion"	=>$r->frecuencia,
								"factor"				=>$r->factor,
								"idtipo_indicador"		=>$r->tipo_ind,
								"desc_factor"			=>$r->desc_factor,
								"linea"					=>$r->linea,
								"descripcion_meta"		=>$r->descripcion_meta,
								"medios_verificacion"	=>$r->medios_verificacion,
								"metas_actividad"		=>$r->metas_actividad,
								"porc1"					=>$r->porc1,
								"porc2"					=>$r->porc2,
								"porc3"					=>$r->porc3,
								"porc4"					=>$r->porc4,
								"porc_anual"			=>$r->porc_anual,
								"mir"					=>$r->mir
							);
				$id = $this->model->insertRow($data,$decoder['id']);
				for ($i=0; $i < count($r->idad); $i++) { 
					$arr = array("idpres_pbrm01d"=>$id,
								"indicador"=>$r->desc[$i],
								"unidad_medida"=>$r->medida[$i],
								"idtipo_operacion"=>$r->tipo[$i],
								"trim1"=>$r->trim1[$i],
								"trim2"=>$r->trim2[$i],
								"trim3"=>$r->trim3[$i],
								"trim4"=>$r->trim4[$i],
								"trim4"=>$r->trim4[$i],
								"anual"=>$r->anual[$i],
							);
					if($r->idad[$i] == "0"){
						$this->model->getInsertTable($arr,"ui_pres_pbrm01d_reg");
					}else{
						$this->model->getUpdateTable($arr,"ui_pres_pbrm01d_reg","idpres_pbrm01d_reg",$r->idad[$i]);
					}
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_pres_pbrm01d_reg","idpres_pbrm01d_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getAddtr( Request $r)
	{
		$this->data['rowsTipoOperacion'] = $this->model->getCatTipoOperacion();
		$this->data['time'] = rand(5,10000).time();
		return view('presupuestopbrmd.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($r->k);
			if($decoder){
				$data = array("idarea_coordinacion"		=> $decoder['idac'],
								"idanio"				=> $r->idanio,
								"idproyecto"			=> $r->idproyecto,
								"temas_desarrollo"		=> $r->tema,
								"fecha_rg"				=> date('Y-m-d'),
								"hora_rg"				=> date('H:i:s A'),
								"nombre_indicador"		=> $r->nombre_indicador,
								"formula"				=> $r->formula,
								"interpretacion"		=> $r->interpretacion,
								"iddimension_atiende"	=> $r->dimencion,
								"idfrecuencia_medicion"	=> $r->frecuencia,
								"factor"				=> $r->factor,
								"idtipo_indicador"		=> $r->tipo_ind,
								"desc_factor"			=> $r->desc_factor,
								"linea"					=> $r->linea,
								"descripcion_meta"		=> $r->descripcion_meta,
								"medios_verificacion"	=> $r->medios_verificacion,
								"metas_actividad"		=> $r->metas_actividad,
								"porc1"					=> $r->porc1,
								"porc2"					=> $r->porc2,
								"porc3"					=> $r->porc3,
								"porc4"					=> $r->porc4,
								"porc_anual"			=> $r->porc_anual,
								"std_delete"			=> 1,
								"mir"					=> $r->mir,
							);
				$id = $this->model->insertRow($data,0);
				for ($i=0; $i < count($r->idad); $i++) { 
					$data_indicador = array("idpres_pbrm01d"=>$id,
								"indicador"=>$r->desc[$i],
								"unidad_medida"=>$r->medida[$i],
								"idtipo_operacion"=>$r->tipo[$i],
								"trim1"=>$r->trim1[$i],
								"trim2"=>$r->trim2[$i],
								"trim3"=>$r->trim3[$i],
								"trim4"=>$r->trim4[$i],
								"trim4"=>$r->trim4[$i],
								"anual"=>$r->anual[$i],
							);
					$this->model->getInsertTable($data_indicador,"ui_pres_pbrm01d_reg");

				}
				$response = "ok";
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
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
			$nombreArchivo = date('d-m-Y') . " Presupuesto Definitivo PbRM-01d.pdf";
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
			$this->data['json'] = $this->pbrmdService->getInfoPbrmd($decoder);
			return view('templates.presupuesto.pbrmd.view_new',$this->data);
		}
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;
			//proyectos
			$rows = $this->model->getPbrmdNew($decoder['id']);
			$this->data['row'] = $this->getRowsDataInfo($rows[0]);
			return view('templates.presupuesto.pbrmd.view_new',$this->data);
		}
	}	
	public function postGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Validaciones de campos
			if(empty($r->footer1)){
				$response = ["status"=>"error","message"=>"Ingresa nombre de la persona que elaboró"];
				return response()->json($response);
			}else if(empty($r->footer2)){
				$response = ["status"=>"error","message"=>"Ingresa nombre de la dependencia general"];
				return response()->json($response);
			}

			$json = json_decode($r->input('json'), true);

			$this->data['json'] = $json;
			$this->data['footer1'] = $r->footer1;
			$this->data['footer2'] = $r->footer2;
			$this->data['cargo1'] = $r->cargo1;
			$this->data['cargo2'] = $r->cargo2;
			//Se construye el nombre del PDF
			$number = $this->getBuildFilenamePDF("PD1D",$json['header']['no_institucion'], $json['header']['no_dep_gen'], $decoder['id']);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectory($json['header']['no_institucion'], $json['header']['year'], 'pres', '01d');

			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 30,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 35,]);
			// Establece el encabezado y pie de página
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmd.new.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmd.new.pdf_body',$this->data));
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmd.new.pdf_footer", $this->data)->render());
			$url = $result['full_path'].$filename;
			$mpdf->Output($url, 'F');

			$this->model->getUpdateTable(['url' => $number], 'ui_pres_pbrm01d',  'idpres_pbrm01d', $decoder['id']);
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
			$this->model->getUpdateTable(['url' => null], "ui_pres_pbrm01d", "idpres_pbrm01d", $decoder['id']);
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
			$this->model->insertRow(array("std_delete"=>2),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	/*public function getSincronizarmir(){
		$rows =  \DB::select("SELECT r.*,d.mir FROM ui_pres_pbrm01d_reg r 
		inner join ui_pres_pbrm01d d on r.idpres_pbrm01d = d.idpres_pbrm01d
		where d.std_delete=1");
		foreach ($rows as $key => $v) {
			$data = array("no_accion"=>$v->mir);
			$this->model->getUpdateTable($data,"ui_reporte_reg","idreporte_reg",$v->idreporte_reg);
		}
		return "ok";
	}*/
}