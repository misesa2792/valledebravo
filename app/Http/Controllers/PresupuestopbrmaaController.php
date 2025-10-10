<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrmaa;
use App\Models\Presupuestopbrmc;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;

class PresupuestopbrmaaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrmaa';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrmaa();
		$this->prespbrmc = new Presupuestopbrmc();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrmaa',
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
		return view('presupuestopbrmaa.index',$this->data);
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
		return view('presupuestopbrmaa.principal',$this->data);
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
			$this->data['rowsAnios'] = $this->model->getModuleYears();
			if($request->year >= "2025"){
				return view('presupuestopbrma.metas.index',$this->data);
			}else{
				return view('presupuestopbrmaa.anio',$this->data);
			}
		}else{
			return view('errors.414');
		}
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
								"no_proyecto"=>$v->no_proyecto,
								"proyecto"=>$v->proyecto,
								"url"=>(empty($v->url) ? "NO" : "PDF"),
								"estatus"=>$v->aa_estatus,
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
			$this->data['token'] = $r->k;
			$this->data['rows'] = $this->model->getMetasPbrmc($decoder['id']);
			$this->data['porcentajes'] = $this->getPorcentajePobBeneficiada();
			//proyectos
			$proy = $this->model->getPbrmaa($decoder['id']);
			$this->data['proy'] = $proy[0];
			return view('presupuestopbrmaa.add',$this->data);
		}
	}
	/*public function getMigrarmeta( Request $r )
	{
		$row = $this->model->getMetasPbrmcID($r->id);
		$data = array("descripcion"=>$row[0]->meta,
					"unidad_medida"=>$row[0]->unidad_medida,
					"no_accion"=>$row[0]->codigo,
					"prog_anual"=>$row[0]->aa_anual,
					"trim_1"=>$row[0]->aa_trim1,
					"trim_2"=>$row[0]->aa_trim2,
					"trim_3"=>$row[0]->aa_trim3,
					"trim_4"=>$row[0]->aa_trim4,
					"idreporte"=>$row[0]->idreporte,
				);
		if($row[0]->idreporte_reg > 0){
			$this->model->getUpdateTable($data, "ui_reporte_reg","idreporte_reg",$row[0]->idreporte_reg);
		}else{
			$idrr = $this->model->getInsertTable($data, "ui_reporte_reg");
			$this->model->getUpdateTable(array("idreporte_reg"=>$idrr), "ui_pres_pbrm01c_reg","idpres_pbrm01c_reg",$row[0]->idpres_pbrm01c_reg);
		}
		$arr = array("success"=>"ok");
		return json_encode($arr);
	}*/
	/*public function getSesmasfrecuenciatipo( Request $r ){
		
		foreach (\DB::select("SELECT * FROM ui_pres_pbrm01d") as $key => $v) {
			if($v->tipo == "Estratégico"){
				$no = "1";
			}else if($v->tipo == "Gestión"){
				$no = "2";
			}
			$data = array("idtipo_indicador"=>$no);
			$this->model->getUpdateTable($data, "ui_pres_pbrm01d", "idpres_pbrm01d", $v->idpres_pbrm01d);
		}
		return "ok";
	}
	public function getSesmasdimension( Request $r ){
		
		foreach (\DB::select("SELECT * FROM ui_pres_pbrm01d") as $key => $v) {
			if($v->dimencion == "Eficacia"){
				$no = "1";
			}else if($v->dimencion == "Eficiencia"){
				$no = "2";
			}else if($v->dimencion == "Economía"){
				$no = "3";
			}else if($v->dimencion == "Calidad"){
				$no = "4";
			}
			$data = array("iddimension_atiende"=>$no);
			$this->model->getUpdateTable($data, "ui_pres_pbrm01d", "idpres_pbrm01d", $v->idpres_pbrm01d);
		}
		return "ok";
	}*/
	/*public function getSesmascambios( Request $r ){
		0 = Sumable       = 1
		1 = Constante	  = 3
		2 = Valor Actual  = 4
		3 = Sin Dato      = 0
		4 = No Sumable    = 2
		5 = Promedio      = 0
		foreach (\DB::select("SELECT idreporte_reg,sumable,idtipo_operacion FROM ui_reporte_reg reg
		inner join ui_reporte r on r.idreporte = reg.idreporte 
		where r.type = 1") as $key => $v) {
			if($v->sumable == "0"){
				$no = "1";
			}else if($v->sumable == "1"){
				$no = "3";
			}else if($v->sumable == "2"){
				$no = "4";
			}else if($v->sumable == "3"){
				$no = "0";
			}else if($v->sumable == "4"){
				$no = "2";
			}else if($v->sumable == "5"){
				$no = "1";
			}
			$data = array("idtipo_operacion"=>$no);
			$this->model->getUpdateTable($data, "ui_reporte_reg", "idreporte_reg", $v->idreporte_reg);
		}
		return "ok";
	}
	*/
	/*public function getSesmasproceso( Request $r ){
		foreach (\DB::select("SELECT * FROM ui_pres_pbrm01c") as $key => $v) {
			$row = \DB::select("SELECT * FROM ui_pres_pbrm02a where idarea_coordinacion={$v->idarea_coordinacion} and idanio={$v->idanio} and idproyecto={$v->idproyecto}");
			if(count($row) > 0){
				$this->model->getUpdateTable(array("idpres_pbrm01c"=>$v->idpres_pbrm01c), "ui_pres_pbrm02a", "idpres_pbrm02a", $row[0]->idpres_pbrm02a);

				//obtengo los valores del 1c y los comparo
				foreach (\DB::select("SELECT * FROM ui_pres_pbrm01c_reg where idpres_pbrm01c={$v->idpres_pbrm01c}") as $k) {
					$ver =  \DB::select("SELECT * FROM ui_pres_pbrm02a_reg where idpres_pbrm02a={$row[0]->idpres_pbrm02a} and codigo = {$k->codigo}");
					if(count($ver) > 0){
						$data = array("aa_anual"=>$ver[0]->anual,
										"aa_trim1"=>$ver[0]->trim1, 
										"aa_trim2"=>$ver[0]->trim2, 
										"aa_trim3"=>$ver[0]->trim3, 
										"aa_trim4"=>$ver[0]->trim4, 
										"aa_porc1"=>$ver[0]->porc1, 
										"aa_porc2"=>$ver[0]->porc2, 
										"aa_porc3"=>$ver[0]->porc3, 
										"aa_porc4"=>$ver[0]->porc4, 
										  );
						$this->model->getUpdateTable($data, "ui_pres_pbrm01c_reg", "idpres_pbrm01c_reg", $k->idpres_pbrm01c_reg);
					}
				}
				//Cambio el estatus
				$this->model->getUpdateTable(array("aa_estatus"=>1, "aa_url"=>$row[0]->url, "aa_fecha_rg"=>$row[0]->fecha_rg, "aa_hora_rg"=>$row[0]->hora_rg), "ui_pres_pbrm01c", "idpres_pbrm01c", $v->idpres_pbrm01c);
			}
		}
		dd("ok");
	}*/
	function postSave( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				//0 - Cuando aún no se registra en el apartado de presupuesto definitivo 2a
				//1 - Cuando ya esta registrado en el presupuesto definitivo 2a
				$data = array("aa_estatus"=>1,
								"aa_fecha_rg"=>date('Y-m-d'),
								"aa_hora_rg"=>date('H:i:s A'));
				$this->model->getUpdateTable($data,"ui_pres_pbrm01c", "idpres_pbrm01c", $decoder['id']);

				for ($i=0; $i < count($r->idaa); $i++) { 
					$arr = array("aa_anual"=>$this->getClearNumber($r->anual[$i]),
								"aa_trim1"=>$this->getClearNumber($r->trim1[$i]),
								"aa_trim2"=>$this->getClearNumber($r->trim2[$i]),
								"aa_trim3"=>$this->getClearNumber($r->trim3[$i]),
								"aa_trim4"=>$this->getClearNumber($r->trim4[$i]),
								"aa_porc1"=>$r->porc1[$i],
								"aa_porc2"=>$r->porc2[$i],
								"aa_porc3"=>$r->porc3[$i],
								"aa_porc4"=>$r->porc4[$i],
								"aa_loc_beneficiada"=>$r->aa_loc_beneficiada[$i],
								"aa_pob_beneficiada"=>$r->aa_pob_beneficiada[$i],
							);
					$this->model->getUpdateTable($arr,"ui_pres_pbrm01c_reg", "idpres_pbrm01c_reg", $r->idaa[$i]);
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!');
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
			$row = $this->prespbrmc->find($decoder['id'],['aa_url']);
			//Asigno el path completo
			$rutaArchivo = public_path($row->aa_url);
			//Nombre del archivo 
			$nombreArchivo = date('d-m-Y') . " Presupuesto Definitivo PbRM-02a.pdf";
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
			//Asignación de valores
			$this->data['token'] = $r->key;
			//proyectos
			$proy = $this->model->getPbrmaa($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['projects'] = $this->model->getMetasPbrmc($decoder['id']);;
			return view('templates.presupuesto.pbrmaa.view_new',$this->data);
		}
	}
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy=$this->model->getPbrmaa($decoder['id']);
			$this->data['proy'] = $proy[0];
			//Valores que se llenan en la caja de texto
			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			$this->data['txt_fecha'] = $r->txt_fecha;
			$this->data['ti_c'] = $r->ti_c;//Elaboró
			$this->data['te_c'] = $r->te_c;//Revisó
			$this->data['ui_c'] = $r->ui_c;//Autorizó (UIPPE)
			//Creación de directorios
			$directory = "archivos/{$proy[0]->no_municipio}/presupuesto/pbrma02a/{$proy[0]->anio}/{$decoder['id']}";
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
			$this->data['projects'] = $this->model->getMetasPbrmc($decoder['id']);
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmaa.pdf_header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmaa.pdf_footer", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmaa.pdf_body',$this->data));

			//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			$time = time();
			$filename = '/'.$decoder['id']."_ ".$time.'.pdf';
			$url = $folder.$filename;
			$mpdf->Output($url, 'F');//Save PDF in directory

			$this->model->getUpdateTable(array("aa_url"=> $directory.$filename), "ui_pres_pbrm01c", "idpres_pbrm01c", $decoder['id']);
			
			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
		}
	}
	public function postRevertir( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		if($decoder){
			try {
				$row  = $this->prespbrmc->find($decoder['id'],['aa_url']);
				$ruta = public_path($row->aa_url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al eliminar imagen, '.$e->getMessage());
			}
			//Coloco nulo
			$this->prespbrmc->insertRow(array("aa_url"=>null),$decoder['id']);
			//Respuesta
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
			/* 13-02-2024
				Se hace eliminación logica, se desarrollará un proceso para que se borren por año.
			*/
			$data = array("aa_estatus"=>0, 
						"aa_fecha_rg"=>null,
						"aa_hora_rg"=>null,
						"aa_url"=>null,
					);
			$this->model->getUpdateTable($data,"ui_pres_pbrm01c", "idpres_pbrm01c", $decoder['id']);
			//Colocó todos los registros del 2a en nulos
			foreach ($this->model->getMetasPbrmc($decoder['id']) as $v) {
				$arr = array("aa_anual"=>null,
								"aa_trim1"=>null,
								"aa_trim2"=>null,
								"aa_trim3"=>null,
								"aa_trim4"=>null,
								"aa_porc1"=>null,
								"aa_porc2"=>null,
								"aa_porc3"=>null,
								"aa_porc4"=>null,
							);
					$this->model->getUpdateTable($arr,"ui_pres_pbrm01c_reg", "idpres_pbrm01c_reg", $v->id);
			}
			//Respuesta
			$response = array("success"=>"ok");
		}else{
			\SiteHelpers::auditTrail( $r , 'Error al eliminar');
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	/*
	public function getMigrarindicadores( Request $r ){
		foreach (\DB::select("SELECT d.idpres_pbrm01d, d.idarea_coordinacion, d.idanio,d.idproyecto,d.idreporte FROM ui_pres_pbrm01d d where d.std_delete = 1 and idanio =2") as $v) {

		
			$data = array("id_area_coordinacion" => $v->idarea_coordinacion,
						"idanio" => $v->idanio,
						"idproyecto" => $v->idproyecto,
						"fecha_rg" => date("Y-m-d"),
						"hora_rg" => date("H:i:s"),
						"type" => "1",
			);

			$ver = \DB::select("SELECT * FROM ui_reporte where type=1 and idanio={$v->idanio} and idproyecto={$v->idproyecto} and id_area_coordinacion={$v->idarea_coordinacion}");

			if(count($ver) == 0){
				$id = $this->model->getInsertTable($data,"ui_reporte");
			}else{
				$this->model->getUpdateTable($data,"ui_reporte","idreporte",$v->idreporte);
				$id = $ver[0]->idreporte;
			}
			
			$this->model->getUpdateTable(array("idreporte"=>$id),"ui_pres_pbrm01d","idpres_pbrm01d",$v->idpres_pbrm01d);


		foreach (\DB::select("SELECT r.*,d.mir,d.nombre_indicador as denominacion,d.frecuencia FROM ui_pres_pbrm01d_reg r 
		inner join ui_pres_pbrm01d d on d.idpres_pbrm01d = r.idpres_pbrm01d
		where r.idpres_pbrm01d=".$v->idpres_pbrm01d) as $k) {
			if($k->idtipo_operacion == 1){
				$sumable = 0;
			}else if($k->idtipo_operacion == 2){
				$sumable = 4;
			}else if($k->idtipo_operacion == 3){
				$sumable = 1;
			}else if($k->idtipo_operacion == 4){
				$sumable = 2;
			}
					$arr = array("idreporte"=>$id,
						"descripcion"=>$k->indicador,
						"unidad_medida"=>$k->unidad_medida,
						"prog_anual"=>$k->anual,
						"no_accion"=>$k->mir,
						"trim_1"=>$k->trim1,
						"trim_2"=>$k->trim2,
						"trim_3"=>$k->trim3,
						"trim_4"=>$k->trim4,
						"denominacion"=>$k->denominacion,
						"frec_medicion"=>$k->frecuencia,
						"sumable"=>$sumable,
					);
				if($k->idreporte_reg == 0){
					$idr = $this->model->getInsertTable($arr,"ui_reporte_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_reporte_reg", "idreporte_reg", $k->idreporte_reg);
					$idr =  $k->idreporte_reg;
				}

				$this->model->getUpdateTable(array("idreporte_reg"=>$idr),"ui_pres_pbrm01d_reg","idpres_pbrm01d_reg",$k->idpres_pbrm01d_reg);


			}	
		}
	
		return "ok";
	}*/
	/*public function getSync( Request $r )
	{
		//Decoder del key
		foreach ($this->model->getMetasSync(2) as $v) {
			$ver = $this->model->getVerificar($v->idpres_pbrm01c);

			//Verifico que no exista
			$data = array("id_area_coordinacion" => $v->idarea_coordinacion,
						"idanio" => $v->idanio,
						"idproyecto" => $v->idproyecto,
						"fecha_rg" => date("Y-m-d"),
						"hora_rg" => date("H:i:s"),
						"idpres_pbrm01c" => $v->idpres_pbrm01c,
			);
			if(count($ver) == 0){
				$id = $this->model->getInsertTable($data,"ui_reporte");
			}else{
				$this->model->getUpdateTable($data,"ui_reporte","idreporte",$ver[0]->idreporte);
				$id = $ver[0]->idreporte;
			}

			foreach ($this->model->getMetasSyncReg($v->idpres_pbrm01c) as $k) {
				
				$arr = array("idreporte"=>$id,
					"descripcion"=>$k->meta,
					"unidad_medida"=>$k->unidad_medida,
					"prog_anual"=>$k->aa_anual,
					"no_accion"=>$k->codigo,
					"trim_1"=>$k->aa_trim1,
					"trim_2"=>$k->aa_trim2,
					"trim_3"=>$k->aa_trim3,
					"trim_4"=>$k->aa_trim4,
					"idpres_pbrm01c_reg"=>$k->idpres_pbrm01c_reg,
				);

				$std = $this->model->getVerificarReg($k->idpres_pbrm01c_reg);
				if(count($std) == 0){
					$this->model->getInsertTable($arr,"ui_reporte_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_reporte_reg", "idreporte_reg", $std[0]->idreporte_reg);
				}
			}

		}
		return "ok";
	}*/
	/*public function getSesmas( Request $r )
	{
		foreach ($this->prespbrmc->all() as $key => $v) {
			if($v->aa_url != ""){
				$url = str_replace("archivos/presupuesto/", "archivos/101/presupuesto/", $v->aa_url);
				$this->prespbrmc->insertRow(array("aa_url"=>$url),$v->idpres_pbrm01c);
			}
		}
		dd("ok");
	}*/
	public function getPorcentajePobBeneficiada(){
		return [100,90,80,70,60,50,40,30,20,10];
	}
}