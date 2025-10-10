<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Suficienciapresupuestal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;

class SuficienciapresupuestalController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'suficienciapresupuestal';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Suficienciapresupuestal();
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'suficienciapresupuestal',
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
		return view('suficienciapresupuestal.index',$this->data);
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

		if($gp == 1 || $gp == 8){
			$rows = $this->getRowsAreasAdmin($this->data['idi'], $request->idy);//(type,idinstitucion)
		}else{
			$rows = $this->getRowsAreasEnlace($this->data['idi'], $request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('suficienciapresupuestal.principal',$this->data);
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
		$this->data['token'] = $request->k;
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('suficienciapresupuestal.anio',$this->data);
	}
	public function getBienes( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['idyear'] = $r->idyear;
			$this->data['year'] = $r->year;
			$row = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['row'] = $row[0];
			if($r->year >= "2025"){
				$this->data['rows_projects'] = $this->model->getProyectosPresDefDepAuxNew($r->idyear, $decoder['idac']);
			}else{
				$this->data['rows_projects'] = $this->model->getProyectosPresDefDepAux($r->idyear, $decoder['idac']);
			}
			$this->data['rowsFF'] 		= $this->model->getFuentesFinanciamiento($decoder['idi'], $r->idyear);
			$this->data['rowsPartidas'] = $this->model->getPartidasEspecificas($this->getCapitulosAccess($decoder['ida']));
			return view('suficienciapresupuestal.bienes.add',$this->data);
		}
	}
	public function getEdit( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$row = $this->model->getSuficienciaID($r->id);
			$this->data['row'] = $row[0];
			$this->data['token'] = $r->k;
			$this->data['idyear'] = $r->idyear;
			$this->data['id'] = $r->id;
			$this->data['rows_projects'] = $this->model->getProjectsProgram();
			$this->data['rowsFF'] 		= $this->model->getFuentesFinanciamiento($decoder['idi'], $r->idyear);
			$this->data['rowsPartidas'] = $this->model->getPartidasEspecificas($this->getCapitulosAccess($decoder['ida']));
			$this->data['rowsRegistros'] = $this->model->getSuficienciaRegistrosID($r->id);
			if($r->type == 1){
				return view('suficienciapresupuestal.bienes.edit',$this->data);
			}else{
				$this->data['rowsServicios'] = $this->model->getListServicios();
				$this->data['servicios'] = $this->getTipoServicios($r->id);
				return view('suficienciapresupuestal.servicios.edit',$this->data);
			}
		}
	}
	
	public function postEditbienes( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{	
			try {
			$this->getEditSolicitudBienes($r->all(), $decoder);
			$this->getEditSolicitudBienesRegistros($r->all(), $decoder);
				$response = ['status' => 'ok', 
							'message' => 'Información guardada correctamente.'
							];
			}catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error - '.$e->getMessage());
				$response = ['status' => 'error', 'message' => 'Error al guardar'];
			}
		}else{
			$response = ['status' => 'error', 'message' => 'Error de clave.'];
		}
    	return response()->json($response);
	}
	private function getEditSolicitudBienes($request, $decoder){
		$data = [
				'idproyecto' 			=> $request['idproyecto'],
				'idteso_ff_n3' 			=> $request['idteso_ff_n3'],
				'fecha_requerida' 		=> $request['fecha_requerida'],
				'idteso_partidas_esp' 	=> $request['idesp'],
				'porc_iva' 				=> $request['porc_iva'],
				'subtotal' 				=> $this->getClearNumber($request['subtotal']),
				'iva' 					=> $this->getClearNumber($request['iva']),
				'total' 				=> $this->getClearNumber($request['total']),
				'observaciones' 		=> mb_strtoupper($this->getUnirTextoSaltosLinea($request['obs']), 'UTF-8'),
				];
		$this->model->getUpdateTable($data, "ui_teso_suficiencia_pres","idteso_suficiencia_pres",$request['id']);
	}
	private function getEditSolicitudBienesRegistros($request, $decoder){
		for ($i=0; $i < count($request['idr']); $i++) { 
			$data = ['idteso_suficiencia_pres'  => $request['id'], 
					'desc' 						=> $request['desc'][$i],
					'unidad_medida' 			=> $request['unidad'][$i],
					'cantidad' 					=> $this->getClearNumber($request['cantidad'][$i]),
					'costo' 					=> $this->getClearNumber($request['costo'][$i]),
					'importe' 					=> $this->getClearNumber($request['importe'][$i]),
					];
			if($request['idr'][$i] == 0){
				$this->model->getInsertTable($data, "ui_teso_suficiencia_pres_reg");
			}else{
				$this->model->getUpdateTable($data, "ui_teso_suficiencia_pres_reg", "idteso_suficiencia_pres_reg",$request['idr'][$i]);
			}
		}
	}
	public function getAddtr( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{
			$this->data['time'] = rand(3,100).time();
			return view('suficienciapresupuestal.bienes.tr',$this->data);	
		}
	}
	public function postSave( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{	
			try {
			$id = $this->getInsertSolicitudBienes($r->all(), $decoder);
			$this->getInsertSolicitudBienesRegistros($r->all(), $decoder, $id);
				$response = ['status' => 'ok', 
							'message' => 'Información guardada correctamente.'
							];
			}catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error - '.$e->getMessage());
				$response = ['status' => 'error', 'message' => 'Error al guardar'];
			}
		}else{
			$response = ['status' => 'error', 'message' => 'Error de clave.'];
		}
    	return response()->json($response);
	}
	private function getInsertSolicitudBienes($request, $decoder){
		$data = ['idanio' 				=> $request['idyear'], 
				'idarea_coordinacion' 	=> $decoder['idac'],
				'idproyecto' 			=> $request['idproyecto'],
				'idteso_ff_n3' 			=> $request['idteso_ff_n3'],
				'fecha_requerida' 		=> $request['fecha_requerida'],
				'idteso_partidas_esp' 	=> $request['idesp'],
				'porc_iva' 				=> $request['porc_iva'],
				'subtotal' 				=> $this->getClearNumber($request['subtotal']),
				'iva' 					=> $this->getClearNumber($request['iva']),
				'total' 				=> $this->getClearNumber($request['total']),
				'type' 					=> 1,
				'fecha_elaboracion' 	=> date('Y-m-d'),
				'observaciones' 		=> mb_strtoupper($this->getUnirTextoSaltosLinea($request['obs']), 'UTF-8'),
				'iduser_rg' 			=> \Auth::user()->id,
				'std_delete' 			=> 1
				];
		$id = $this->model->getInsertTable($data, "ui_teso_suficiencia_pres");
		return $id;
	}
	private function getInsertSolicitudBienesRegistros($request, $decoder, $id){
		for ($i=0; $i < count($request['idr']); $i++) { 
			$data[] = ['idteso_suficiencia_pres'=> $id, 
					'desc' 						=> $request['desc'][$i],
					'unidad_medida' 			=> $request['unidad'][$i],
					'cantidad' 					=> $this->getClearNumber($request['cantidad'][$i]),
					'costo' 					=> $this->getClearNumber($request['costo'][$i]),
					'importe' 					=> $this->getClearNumber($request['importe'][$i]),
					];
		}
		$this->model->getInsertTableData($data, "ui_teso_suficiencia_pres_reg");
	}

	public function postEditservicios( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{	
			try {
			$this->getEditSolicitudServicios($r->all(), $decoder,$r->id);
			$this->getEditSolicitudServiciosHeviculo($r->idser, $r->id);
			$this->getEditSolicitudServiciosRegistros($r->all(), $decoder, $r->id);
			
				$response = ['status' => 'ok', 
							'message' => 'Información guardada correctamente.'
							];
			}catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error - '.$e->getMessage());
				$response = ['status' => 'error', 'message' => 'Error al guardar'];
			}
		}else{
			$response = ['status' => 'error', 'message' => 'Error de clave.'];
		}
    	return response()->json($response);
	}
	private function getEditSolicitudServiciosRegistros($request, $decoder, $id){
		for ($i=0; $i < count($request['idr']); $i++) { 
			if($request['idr'][$i] == 0){
				$data = ['idteso_suficiencia_pres' => $id, 
							'desc' 				   => $request['desc'][$i],
							'unidad_medida' 	   => null,
							'cantidad' 			   => null,
							'costo' 			   => null,
							'importe' 			   => $this->getClearNumber($request['importe'][$i])
						];
				$this->model->getInsertTable($data, "ui_teso_suficiencia_pres_reg");
			}else{
				$data = ['desc' 	=> $request['desc'][$i],
						'importe'   => $this->getClearNumber($request['importe'][$i])
						];
				$this->model->getUpdateTable($data, "ui_teso_suficiencia_pres_reg", "idteso_suficiencia_pres_reg", $request['idr'][$i]);
			}
		}
	}
	private function getEditSolicitudServicios($request, $decoder,$id){
		$data = [
				'idproyecto' 			=> $request['idproyecto'],
				'idteso_ff_n3' 			=> $request['idteso_ff_n3'],
				'fecha_requerida' 		=> $request['fecha_requerida'],
				'fecha_servicio' 		=> $request['fecha_servicio'],
				'idteso_partidas_esp' 	=> $request['idesp'],
				'porc_iva' 				=> $request['porc_iva'],
				'subtotal' 				=> $this->getClearNumber($request['subtotal']),
				'iva' 					=> $this->getClearNumber($request['iva']),
				'total' 				=> $this->getClearNumber($request['total']),
				'observaciones' 		=> mb_strtoupper($this->getUnirTextoSaltosLinea($request['obs']), 'UTF-8'),
				];
		$id = $this->model->getUpdateTable($data, "ui_teso_suficiencia_pres","idteso_suficiencia_pres", $id);
		return $id;
	}
	private function getEditSolicitudServiciosHeviculo($servicios, $id){
		foreach ($servicios as $val => $v) {
			$row = $this->model->getSearchServicios($id, $val);
			if(count($row) > 0){
				$data = ["descripcion" => $v];
				$this->model->getUpdateTable($data, "ui_teso_suficiencia_pres_veh", "idteso_suficiencia_pres_veh", $row[0]->id);
			}else{
				if($v != ""){
					$data = ["idteso_suficiencia_pres" => $id, "idteso_suficiencia_pres_ser" => $val, "descripcion" => $v];
					$this->model->getInsertTable($data, "ui_teso_suficiencia_pres_veh");
				}
			}
		}
	}
	public function deleteServiciosbienes(Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{	
			try {
				$this->model->getDestroyTable("ui_teso_suficiencia_pres_reg", "idteso_suficiencia_pres_reg", $r->id);
				$response = ['status' => 'ok', 
							'message' => 'Registro eliminado correctamente.'
							];
			}catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error - '.$e->getMessage());
				$response = ['status' => 'error', 'message' => 'Error al eliminar el registro'];
			}
		}else{
			$response = ['status' => 'error', 'message' => 'Error de clave.'];
		}
    	return response()->json($response);
	}
	public function getServicios( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['idyear'] = $r->idyear;
			$this->data['year'] = $r->year;
			$row = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['row'] = $row[0];
			if($r->year >= "2025"){
				$this->data['rows_projects'] = $this->model->getProyectosPresDefDepAuxNew($r->idyear, $decoder['idac']);
			}else{
				$this->data['rows_projects'] = $this->model->getProyectosPresDefDepAux($r->idyear, $decoder['idac']);
			}
			$this->data['rowsFF'] 		= $this->model->getFuentesFinanciamiento($decoder['idi'], $r->idyear);
			$this->data['rowsPartidas'] = $this->model->getPartidasEspecificas($this->getCapitulosAccess($decoder['ida']));
			$this->data['rowsServicios'] = $this->model->getListServicios();
			return view('suficienciapresupuestal.servicios.add',$this->data);
		}
	}
	public function getAddtrservicios( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{
			$this->data['time'] = rand(3,100).time();
			return view('suficienciapresupuestal.servicios.tr',$this->data);	
		}
	}
	public function postSaveservicios( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{	
			try {
			$id = $this->getInsertSolicitudServicios($r->all(), $decoder);
			$this->getInsertSolicitudServiciosHeviculo($r->idser, $id);
			$this->getInsertSolicitudServiciosRegistros($r->all(), $decoder, $id);
				$response = ['status' => 'ok', 
							'message' => 'Información guardada correctamente.'
							];
			}catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error - '.$e->getMessage());
				$response = ['status' => 'error', 'message' => 'Error al guardar'];
			}
		}else{
			$response = ['status' => 'error', 'message' => 'Error de clave.'];
		}
    	return response()->json($response);
	}
	private function getInsertSolicitudServiciosHeviculo($servicios, $id){
		foreach ($servicios as $val => $v) {
			if($v != ""){
				$data = ["idteso_suficiencia_pres" => $id, "idteso_suficiencia_pres_ser" => $val, "descripcion" => $v];
				$this->model->getInsertTable($data, "ui_teso_suficiencia_pres_veh");
			}
		}
	}

	private function getInsertSolicitudServicios($request, $decoder){
		$data = ['idanio' 				=> $request['idyear'], 
				'idarea_coordinacion' 	=> $decoder['idac'],
				'idproyecto' 			=> $request['idproyecto'],
				'idteso_ff_n3' 			=> $request['idteso_ff_n3'],
				'fecha_elaboracion' 	=> date('Y-m-d'),
				'fecha_requerida' 		=> $request['fecha_requerida'],
				'fecha_servicio' 		=> $request['fecha_servicio'],
				'idteso_partidas_esp' 	=> $request['idesp'],
				'porc_iva' 				=> $request['porc_iva'],
				'subtotal' 				=> $this->getClearNumber($request['subtotal']),
				'iva' 					=> $this->getClearNumber($request['iva']),
				'total' 				=> $this->getClearNumber($request['total']),
				'type' 					=> 2,
				'observaciones' 		=> mb_strtoupper($this->getUnirTextoSaltosLinea($request['obs']), 'UTF-8'),
				'iduser_rg' 			=> \Auth::user()->id,
				'std_delete' 			=> 1
				];
		$id = $this->model->getInsertTable($data, "ui_teso_suficiencia_pres");
		return $id;
	}
	private function getInsertSolicitudServiciosRegistros($request, $decoder, $id){
		for ($i=0; $i < count($request['idr']); $i++) { 
			$data[] = ['idteso_suficiencia_pres'=> $id, 
					'desc' 						=> $request['desc'][$i],
					'unidad_medida' 			=> null,
					'cantidad' 					=> null,
					'costo' 					=> null,
					'importe' 					=> $this->getClearNumber($request['importe'][$i]),
					];
		}
		$this->model->getInsertTableData($data, "ui_teso_suficiencia_pres_reg");
	}
	public function getData(Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$result = [
						'rowsData' => $this->getDataSolicitudPresupuestal($decoder['idac'],$r->idyear)
			];
			return response()->json($result);
		}
	}
	private function getDataSolicitudPresupuestal($idac, $idy){
		$data = [];
		foreach ($this->model->getRegistrosSolicitudPres($idac,$idy) as $v) {
			$data[] = ['id' 			=> $v->id, 
						'no_proyecto' 	=> $v->no_proyecto,
						'proyecto' 		=> $v->proyecto,
						'type' 			=> $v->type,
						'number' 		=> $v->number,
						'folio'			=> $v->folio,
						'obs' 			=> $v->observaciones,
						'no_fuente' 	=> $v->no_fuente,
						'std_delete' 	=> $v->std_delete,
						'fecha_rg' 		=> $v->fecha_rg
					];
		}
		return $data;
	}
	public function postReverse( Request $r )
	{
		$params = $r->params;
		$decoder = SiteHelpers::CF_decode_json($params['k']);
		if($decoder){
			$this->model->insertRow(['folio' => null, 'number' => null], $params['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($params['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	public function getGenerate( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder)
		{
			$this->data['token'] = $r->k;
			$this->data['idyear'] = $r->idyear;
			$this->data['year'] = $r->year;
			$this->data['id'] = $r->id;
			$this->data['row'] = $this->getDataSolicitudPresBienes($r->id);
			if($r->type == 1){	//Bienes
				return view('suficienciapresupuestal.bienes.generate',$this->data);
			}else if($r->type == 2){ //Servicios
				$this->data['servicios'] = $this->getTipoServicios($r->id);
				return view('suficienciapresupuestal.servicios.generate',$this->data);
			}
		}
	}
	private function getTipoServicios($id){
		$data = [];
		foreach ($this->model->getTiposServicios($id) as $v) {
			$data[$v->tipo] = $v->servicios;
		}
		return $data;
	}
	private function getDataSolicitudPresBienes($id){
		$info = $this->model->getRegistrosSolicitudPresID($id);
		$row = $info[0];
		$fe = $this->getSplitDate($row->fecha_elaboracion);
		$rows = $this->getDataSolPresRegistros($id);
		$data = [
			"anio" 		 		 => $row->anio,
			"no_municipio" 		 => $row->no_municipio,
			"fecha_elaboracion"  => $fe['dia']." DE ".strtoupper(SiteHelpers::mes($fe['mes']))." DE ".$fe['year'],
			"no_dep_gen"  		=> $row->no_dep_gen,
			"dep_gen"  			=> $row->dep_gen,
			"dep_aux"     		=> $row->dep_aux,
			"no_dep_aux"     	=> $row->no_dep_aux,
			"no_proyecto"     	=> $row->no_proyecto,
			"clasificacion"     => $row->clasificacion,
			"fuente" 			=> $row->no_fuente.' '.$row->fuente,
			"no_partida" 		=> $row->no_partida,
			"obs" 				=> $row->observaciones,
			"subtotal" 			=> number_format($row->subtotal,2),
			"iva" 				=> number_format($row->iva,2),
			"total" 			=> number_format($row->total,2),
			"fecha_requerida"   => $this->getSplitDate($row->fecha_requerida),
			"fecha_servicio"    => $this->getSplitDate($row->fecha_servicio),
			"rowsRegistros" 	=> $rows['data'],
			"count" 			=> $rows['count'],
			"resta" 			=> ($rows['count'] > 10 ? $rows['count'] : 10 - $rows['count']),
			"footer"		=> [
							"prog_pres"  => $row->titular_prog_pres,
							"tesorero"   => $row->titular_tesoreria,
							"egresos"    => $row->titular_egresos,
						]
		];
		return $data;
	}
	
	private function getDataSolPresRegistros($id){
		$data = [];
		$count = 0;
		foreach ($this->model->getRegistrosSolicitudPresReg($id) as $v) {
			$count++;
			$data[] = ['desc' 			=> $v->desc, 
						'um' => $v->unidad_medida,
						'cant' 		=> $v->cantidad,
						'costo' 		=> number_format($v->costo,2),
						'importe' 		=> number_format($v->importe,2)
					];
		}
		return ['data' => $data, 'count' => $count];
	}
	/*
	*	DELETE
	*/
	public function deleteSuficienciapres( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->model->insertRow(['std_delete' => $r->numero], $r->id);
			if($r->numero == 2){
				$message = "Solicitud AUTORIZADA correctamente.";
			}else if($r->numero == 3){
				$message = "Solicitud CANCELADA correctamente.";
			}
			$response = ["status"=>"ok", "message"=> $message];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	public function postGeneratepdf( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			
			$row = $this->getDataSolicitudPresBienes($r->id);
			$this->data['row'] = $row;

			//Se construye el nombre del PDF
			$number = $this->getBuildFilenamePDF("SSPB",$row['no_municipio'], $row['no_dep_gen'], $r->id);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectory($row['no_municipio'], $row['anio'], 'tesoreria', 'sspb');

			//Valores que se llenan en la caja de texto
			$this->data['request'] = $r->all();
			$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
									'margin_top' => 47,
									'margin_left' => 5,
									'margin_right' => 5,
									'margin_bottom' => 40,
									]);
		    //Construcción del PDF
			$mpdf->SetHTMLHeader(View::make($this->module.".bienes.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make($this->module.".bienes.pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view($this->module.'.bienes.pdf.body',$this->data));
						
			//Construcción del full path
			$url = $result['full_path'].$filename;
			//Save PDF in directory
			$mpdf->Output($url, 'F');
			$this->model->getUpdateTable(['number' => $number, 'folio' => $r->folio], "ui_teso_suficiencia_pres", "idteso_suficiencia_pres", $r->id);
			$this->getInsertTablePlan($decoder['idi'], $number, $url, $result['directory']);
		
			//Return del resultado con el key
			$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{
			$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
		}
		return response()->json($response);
	}

	public function postGenerateserviciospdf( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			
			$row = $this->getDataSolicitudPresBienes($r->id);
			$this->data['row'] = $row;
			$this->data['servicios'] = $this->getTipoServicios($r->id);

			//Se construye el nombre del PDF
			$number = $this->getBuildFilenamePDF("SSPS",$row['no_municipio'], $row['no_dep_gen'], $r->id);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectory($row['no_municipio'], $row['anio'], 'tesoreria', 'ssps');

			//Valores que se llenan en la caja de texto
			$this->data['request'] = $r->all();
			$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
									'margin_top' => 47,
									'margin_left' => 5,
									'margin_right' => 5,
									'margin_bottom' => 40,
									]);
		    //Construcción del PDF
			$mpdf->SetHTMLHeader(View::make($this->module.".servicios.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make($this->module.".servicios.pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view($this->module.'.servicios.pdf.body',$this->data));
			//Construcción del full path
			$url = $result['full_path'].$filename;
			//Save PDF in directory
			$mpdf->Output($url, 'F');

			$this->model->getUpdateTable(['number' => $number, 'folio' => $r->folio], "ui_teso_suficiencia_pres", "idteso_suficiencia_pres", $r->id);
			$this->getInsertTablePlan($decoder['idi'], $number, $url, $result['directory']);
		
			//Return del resultado con el key
			$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{
			$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
		}
		return response()->json($response);
	}

	public function getCapitulosAccess($ida)
	{
		if($ida == 21){
			$capitulo = "1";
		}else{
			$capitulo = "2,3,4,5,6,7,8,9";
		}
		return $capitulo;
	}
}