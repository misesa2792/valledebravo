<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Reporte;
use App\Models\Exportar;
use App\Models\Access\Years;

use App\Services\MetasService;
use App\Services\GeneralService;

use Illuminate\Http\Request;

use SiteHelpers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReporteController extends Controller {

	protected $data;	
	protected $model;	
	protected $exportar;	
	protected $info;	
	protected $access;	
	
	protected $metasService;
	protected $generalService;

	public $module = 'reporte';
	static $per_page = '10';
    const MODULE = 5;

	public function __construct(MetasService $metasService, GeneralService $generalService){
		$this->model = new Reporte();
		$this->exportar = new Exportar();

		$this->metasService = $metasService;
		$this->generalService = $generalService;

		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'reporte'
		);
	}
	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0){
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		return view('reporte.index',$this->data);
	}	
	public function getPrincipal( Request $request ){
		$idy = $request->idy;
		$idi = Auth::user()->idinstituciones;
		//Validar si se tiene acceso al año
		$modulo = Years::getModuleAccessByYearsID(self::MODULE,$idi,$idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		if(isset($request->k)){
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($request->k);
			$ida = $decoder['ida'];
		}else{
			$ida = 0;
		}

		$type = 0;
		//Accesos a Dependencias
		$rows = $this->generalService->getAccessDepGenForUsers($idy, $type);
		$this->data['rowData'] = json_encode($rows);
		$this->data['year'] 			= $modulo[0]->anio;
		$this->data['ida'] 				= $ida;
		$this->data['idi'] 				= $idi;
		$this->data['idy'] 				= $idy;
		$this->data['type'] 			= $type;// 0 - Metas y 1 Indicadores 
		$this->data['active'] 			= 1;
		$this->data['activeName'] 		= 'Dependencias';
		if($idy > 2){
			return view('reporte.proyectos.dependencias',$this->data);
		}
		return view('reporte.old.principal',$this->data);
	}
	public function getProjects( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder == null){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
        $gp = Auth::user()->group_id;
        if($gp == 1 || $gp == 2 || $gp == 4){
			$this->data['rowsMenu'] = $this->generalService->getAccessDepGenForUsersView($decoder);
		}else{
			$this->data['rowsMenu'] = [];
		}
		$row = $this->model->getInformationDepAuxID($decoder['idac']);
		//Validamos si tenemos informacion
		if(count($row) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['token'] = $r->k;
		$this->data['type'] = $decoder['type'];
		$this->data['idac'] = $decoder['idac'];
		$this->data['row'] = $row[0];
		return view('reporte.proyectos.index',$this->data);	
	}
	public function getListprojects( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$data = $this->metasService->viewMetas($decoder);
		return response()->json($data);
	}
	public function getDetalle( Request $r){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->id);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['id'] = $r->id;
			$this->data['json'] = $this->metasService->viewInforReporte($decoder, $r->all());
			return view($this->module.".proyectos.detalle",$this->data);	
		}
	}
	public function getMeses( Request $r)
	{
		$this->data['idrg'] = $r->idrg;
		$this->data['idmes'] = $r->idmes;
		$this->data['trim'] = $r->trim;
		$reg = $this->model->getRegistroReg($r->idrg);
		$numero = "access_trim".$r->trim;
		$this->data['mes'] = $this->getDataMeses($r->idmes);
		$this->data['row'] = $reg[0];
		$this->data['accesos'] = $reg[0]->$numero;
		$this->data['color'] = $this->getColorTrimestre($r->trim);
		return view('reporte.proyectos.meses.gallery',$this->data);	
	}




	public function getDownloadpdf( Request $r ){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Obtengo la URL
			$row = $this->model->getReportePDFURL($decoder['idrp']);
			if(count($row) > 0){
				//Asigno el path completo
				$rutaArchivo = public_path($row[0]->url);
				//Nombre del archivo 
				if($row[0]->type == "1"){
					$filename = " PbRM - Formato Reconducción Trim #".$row[0]->trim.".pdf";
				}else if($row[0]->type == "2"){
					$filename = " PbRM - Formato Tarjeta de Justificación Trim #".$row[0]->trim.".pdf";
				}else if($row[0]->type == "3"){
					$filename = " PbRM - Oficio Dictamen de Reconducción Trim #".$row[0]->trim.".pdf";
				}
				$nombreArchivo = date('d-m-Y') . $filename;
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
					return view('errors.414');
				}
			}else{
				return view('errors.414');
			}
		}else{
			return view('errors.414');
		}
	}
	public function getRegistrarmeta( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['idac'] = $decoder['idac'];
		$this->data['ida'] = $decoder['ida'];
		$this->data['idi'] = $decoder['idi'];;
		$this->data['type'] = $decoder['type'];
		$this->data['idr'] = $decoder['idr'];
		$this->data['anio'] = $decoder['year'];
		$this->data['idy'] = $decoder['idy'];
		//key donde contiene el array de informacion
		$this->data['k'] = $r->k;
		//Información de las metas
		$proy = $this->model->getRowReporte($decoder['idr']);
		$this->data['proy'] = $proy[0];
		//Informacion de la dependencia general, auxiliar e institución
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		return view('reporte.meta.registrar',$this->data);	
	}
	private function getRowsAreasAdminAccess($type=0){
		$data = array();
		foreach ($this->model->getAreaAll($type) as $v) {
			$arr = array();
			foreach ($this->model->getCoordinaciones($v->idarea,$type) as $c) {
				$arr[] = array("coor"=>$c->descripcion,"total"=>$c->total,"projects"=>$this->model->getReporte($c->id,1));
			}
			$data[] = array("ida"=>$v->idarea,
							"area"=>$v->descripcion,
							"titular"=>$v->titular,
							"rows_coor"=> $arr,
						);
		}
		return $data;
	}
	public function getMetasall( Request $r)
	{
		return $this->getMetas($r->idr);
	}
	protected function getMetas($idr){
		$data = array();
		$j = 1;
		foreach ($this->model->getMetas($idr) as $v) {
			$tm1 = $this->model->getMetasMeses($v->idreporte_reg,"1,2,3","cant");
			$tm2 = $this->model->getMetasMeses($v->idreporte_reg,"4,5,6","cant");
			$tm3 = $this->model->getMetasMeses($v->idreporte_reg,"7,8,9","cant");
			$tm4 = $this->model->getMetasMeses($v->idreporte_reg,"10,11,12","cant");
			//Verifico si ya tienen registros
			$total_reg1 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"1,2,3");
			$total_reg2 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"4,5,6");
			$total_reg3 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"7,8,9");
			$total_reg4 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"10,11,12");
			$data[] = array("j"=>$j++,
							"anio"=>$v->anio,
							"idrg"=>$v->idreporte_reg,
							"meta"=>$v->descripcion,
							"deno"=>$v->denominacion,
							"um"=>$v->unidad_medida,
							"obs"=>$v->observaciones,
							"obs2"=>$v->obs2,
							"obs3"=>$v->obs3,
							"obs4"=>$v->obs4,
							"pa"=>$v->prog_anual,
							"no_a"=>$v->no_accion,
							"fm"=>$v->frec_medicion,
							"to"=>$v->tipo_operacion,
							"t1"=>$this->getQuitarDobleCeros($v->trim_1),
							"m1"=>$this->getRowsMetasMeses($this->model->getMetasMeses($v->idreporte_reg,"1,2,3")),
							"total_m1"=> $this->getCalcularPorcentaje($tm1[0]->total, $v->trim_1),
							"t2"=>$this->getQuitarDobleCeros($v->trim_2),
							"m2"=>$this->getRowsMetasMeses($this->model->getMetasMeses($v->idreporte_reg,"4,5,6")),
							"total_m2"=> $this->getCalcularPorcentaje($tm2[0]->total, $v->trim_2),
							"t3"=>$this->getQuitarDobleCeros($v->trim_3),
							"m3"=>$this->getRowsMetasMeses($this->model->getMetasMeses($v->idreporte_reg,"7,8,9")),
							"total_m3"=> $this->getCalcularPorcentaje($tm3[0]->total, $v->trim_3),
							"t4"=>$this->getQuitarDobleCeros($v->trim_4),
							"m4"=>$this->getRowsMetasMeses($this->model->getMetasMeses($v->idreporte_reg,"10,11,12")),
							"total_m4"=> $this->getCalcularPorcentaje($tm4[0]->total, $v->trim_4),
							"tt1"=>$this->getQuitarDobleCeros($tm1[0]->total),
							"tt2"=>$this->getQuitarDobleCeros($tm2[0]->total),
							"tt3"=>$this->getQuitarDobleCeros($tm3[0]->total),
							"tt4"=>$this->getQuitarDobleCeros($tm4[0]->total),
							"resta1"=>$this->getQuitarDobleCeros($tm1[0]->total - $v->trim_1),
							"resta2"=>$this->getQuitarDobleCeros($tm2[0]->total - $v->trim_2),
							"resta3"=>$this->getQuitarDobleCeros($tm3[0]->total - $v->trim_3),
							"resta4"=>$this->getQuitarDobleCeros($tm4[0]->total - $v->trim_4),
							"tr1"=>$this->getQuitarDobleCeros($total_reg1[0]->total),
							"tr2"=>$this->getQuitarDobleCeros($total_reg2[0]->total),
							"tr3"=>$this->getQuitarDobleCeros($total_reg3[0]->total),
							"tr4"=>$this->getQuitarDobleCeros($total_reg4[0]->total),
						);
		}
		return json_encode($data);
	}
	public function getExportarmetas( Request $r)
	{
		$data = [];
		foreach ($this->model->getExportMetas() as $v) {
			$data[] = ['nop'=>$v->no_proyecto, 
						'no_dep_gen' => $v->no_dep_gen, 
						'no_dep_aux' => $v->no_dep_aux,
						'rowsMetas' => $this->getRowsMetasRec($v->id)
					];
		}
		return $this->exportar->getExportarMetasDepGen($data);
	}
	private function getRowsMetasRec($id){
		$data = array();
		$j = 1;
		foreach ($this->model->getMetas($id) as $v) {
			$tm1 = $this->model->getMetasMeses($v->idreporte_reg,"1,2,3","cant");
			$tm2 = $this->model->getMetasMeses($v->idreporte_reg,"4,5,6","cant");
			$tm3 = $this->model->getMetasMeses($v->idreporte_reg,"7,8,9","cant");
			$tm4 = $this->model->getMetasMeses($v->idreporte_reg,"10,11,12","cant");
			//Verifico si ya tienen registros
			$total_reg1 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"1,2,3");
			$total_reg2 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"4,5,6");
			$total_reg3 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"7,8,9");
			$total_reg4 = $this->model->getMetasMesesTotalRegistros($v->idreporte_reg,"10,11,12");

			$rec1 = $rec2 = $rec3 = $rec4 = "";
			$obs1 = $obs2 = $obs3 = $obs4 = "";
			$porc1= $this->getCalcularPorcentaje($tm1[0]->total, $v->trim_1);
			$porc2 = $this->getCalcularPorcentaje($tm2[0]->total, $v->trim_2);
			$porc3 = $this->getCalcularPorcentaje($tm3[0]->total, $v->trim_3);
			$porc4 = $this->getCalcularPorcentaje($tm4[0]->total, $v->trim_4);
			if($this->getQuitarDobleCeros($total_reg1[0]->total) > 0 && ($porc1 > 110 || $porc1 <= 89.99 )){
				$rec1 = "X"; 
				$obs1 = $v->observaciones;
			}
			if($this->getQuitarDobleCeros($total_reg2[0]->total) > 0 && ($porc2 > 110 || $porc2 <= 89.99 )){
				$rec2 = "X"; 
				$obs2 = $v->obs2;
			}
			if($this->getQuitarDobleCeros($total_reg3[0]->total) > 0 && ($porc3 > 110 || $porc3 <= 89.99 )){
				$rec3 = "X"; 
				$obs3 = $v->obs3;
			}
			if($this->getQuitarDobleCeros($total_reg4[0]->total) > 0 && ($porc4 > 110 || $porc4 <= 89.99 )){
				$rec4 = "X"; 
				$obs4 = $v->obs4;
			}
			$t1 = $this->getQuitarDobleCeros($tm1[0]->total);
			$t2 = $this->getQuitarDobleCeros($tm2[0]->total);
			$t3 = $this->getQuitarDobleCeros($tm3[0]->total);
			$t4 = $this->getQuitarDobleCeros($tm4[0]->total);
			$avance = ($t1 + $t2 + $t3 + $t4);
			if($avance > 0){
				if($v->prog_anual > 0){
					$porcentaje = ($avance * 100)/$v->prog_anual;
				}else{
					$porcentaje = 0;
				}
			}else{
				$porcentaje = 0;
			}
			$data[] = array(
							"no_a"=>$v->no_accion,
							"meta"=>$v->descripcion,
							"rec1" => $rec1,
							"rec2" => $rec2,
							"rec3" => $rec3,
							"rec4" => $rec4,
							"obs1" => $obs1,
							"obs2" => $obs2,
							"obs3" => $obs3,
							"obs4" => $obs4,
							"porcentaje" => number_format($porcentaje,0),
							"avance" => $avance,
							"anual" => $v->prog_anual,
						);
		}
		return $data;
	}
	protected function getRowsMetasMeses($rows = array()){
		$data = array();
		foreach ($rows as $v) {
			if($v->cant == "mass"){
				$cant = "mass";
			}else if($v->cant == 0){
				$cant = 0;
			}else{
				$cant = $this->getQuitarDobleCeros($v->cant);
			}
			$data[] = array("idmes"=>$v->idmes, 
							"mes"=> $v->mes, 
							"cant"=> $cant, 
							"total_img" => $v->total_img);
		}
		return $data;
	}
	protected function getCalcularPorcentaje($total = 0,$trim=0){
		if($trim == 0 && $total == 0){
			$cant = "100";
		}elseif($total == 0 && $trim != 0){
			$cant = "-100";
		}elseif($trim == 0){
			$cant = "-100";
		}else{
			$cant = ($total * 100)/$trim;
		}
		return $this->getQuitarDobleCeros($cant);
	}
	public function getAddfoda( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['json'] = $this->metasService->viewInfoFODA($decoder, $r->all());
			$this->data['token'] = $r->k;
			$this->data['trim'] = $r->trim;
			return view('indicadores.foda.index',$this->data);	
		}
	}
	private function getInsertFoda($idr,$type, $desc,$trim){
		$data = array("idreporte"=>$idr, 
						"type"=>$type,
						"descripcion"=>$desc,
						"fecha_rg"=> date('Y-m-d'),
						"hora_rg"=> date('H:i:s A'),
						"iduser_rg"=> Auth::user()->id,
						"trimestre"=>$trim,
					);
		$this->model->getInsertTable($data,"ui_foda");	
	}
	private function getUpdateFoda($id,$type, $desc,$trim){
		$data = array("type"=>$type,
						"descripcion"=>$desc,
						"iduser_rg"=> Auth::user()->id,
						"trimestre"=>$trim,
					);
		$this->model->getUpdateTable($data,"ui_foda","idfoda",$id);	
	}
	function getEliminarfodatr(Request $r){
		$this->model->getDestroyTable("ui_foda","idfoda",$r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function postSavefoda( Request $r)
	{
		try {
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($r->k);
			//Nuevos registros
			if(isset($r->idfoda1)){
				for ($i=0; $i < count($r->idfoda1); $i++) { 
					if(!empty($r->foda1[$i])){
						$this->getInsertFoda($decoder['id'], 1, $r->foda1[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->idfoda2)){
				for ($i=0; $i < count($r->idfoda2); $i++) { 
					if(!empty($r->foda2[$i])){
						$this->getInsertFoda($decoder['id'], 2, $r->foda2[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->idfoda3)){
				for ($i=0; $i < count($r->idfoda3); $i++) { 
					if(!empty($r->foda3[$i])){
						$this->getInsertFoda($decoder['id'], 3, $r->foda3[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->idfoda4)){
				for ($i=0; $i < count($r->idfoda4); $i++) { 
					if(!empty($r->foda4[$i])){
						$this->getInsertFoda($decoder['id'], 4, $r->foda4[$i], $r->trimestre);
					}
				}
			}
			//Update rows
			if(isset($r->id1)){
				for ($i=0; $i < count($r->id1); $i++) { 
					if(!empty($r->desc1[$i])){
						$this->getUpdateFoda($r->id1[$i], 1, $r->desc1[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->id2)){
				for ($i=0; $i < count($r->id2); $i++) { 
					if(!empty($r->desc2[$i])){
						$this->getUpdateFoda($r->id2[$i], 2, $r->desc2[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->id3)){
				for ($i=0; $i < count($r->id3); $i++) { 
					if(!empty($r->desc3[$i])){
						$this->getUpdateFoda($r->id3[$i], 3, $r->desc3[$i], $r->trimestre);
					}
				}
			}
			if(isset($r->id4)){
				for ($i=0; $i < count($r->id4); $i++) { 
					if(!empty($r->desc4[$i])){
						$this->getUpdateFoda($r->id4[$i], 4, $r->desc4[$i], $r->trimestre);
					}
				}
			}
			$success = "ok";
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error, '.$e->getMessage());
		}
		$result = array("success"=>$success);
		return json_encode($result);
	}
	public function getAddfodatr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		$this->data['num'] = $r->num;
		return view('indicadores.foda.tr',$this->data);	
	}
	public function getRegistrarmes( Request $r)
	{
		$this->data['idrg'] = $r->idrg;
		$this->data['idmes'] = $r->idmes;
		$this->data['trim'] = $r->trim;
		$mes = $this->model->getMes($r->idmes);
		$reg = $this->model->getRegistroReg($r->idrg);
		$numero = "access_trim".$r->trim;
		//$this->data['permiso'] = $this->getPermiso($r->trim, $reg[0]);se elimina por que ya es basura
		$this->data['mes'] = $mes[0]->mes;
		$this->data['row'] = $reg[0];
		$this->data['access_trim'] =$reg[0]->$numero;
		return view('reporte.meta.llenarmes',$this->data);	
	}
	public function getEditreg( Request $r)
	{
		$this->data['idrm'] = $r->idrm;
		$row = $this->model->getRegMes($r->idrm);
		$this->data['row'] = $row[0];
		return view('reporte.meta.editreg',$this->data);	
	}
	public function getRegistros( Request $r)
	{
		$data = array();
		$j = 1;
		foreach ($this->model->getRegistrosMes($r->idrg,$r->idmes) as $v) {
			$data[] = array("j"=>$j++,"idrm"=>$v->idrm,"cant"=>$this->getQuitarDobleCeros($v->cant),"fecha_rg"=>$v->fecha_rg,"hora_rg"=>$v->hora_rg,"usuario"=>$v->usuario,"rowsImgs"=>$this->getRowImg($v->idrm));
		}
		return json_encode($data);
	}
	protected function getRowImg($idrm){
		$data=array();
		foreach ($this->model->getRegistrosMesImgs($idrm) as $v) {
			$data[]=array(
				"idri" => $v->idri, 
				"name" => $v->nombre, 
				"url" => asset($v->url), 
				"ico" => asset($this->getTypeImg($v->url,$v->ext)), 
			);	
		}
		return $data;
	}
	protected function getTypeImg($url=null,$ext='otros'){
		if($ext == "jpg" || $ext == "jpeg" ||  $ext == "png" ||  $ext == "PNG" || $ext == "gif" || $ext == "JPG" || $ext == "JPEG"){
			$path_icon = "{$url}";
		}elseif(file_exists(public_path()."/images/icons/". SiteHelpers::getIconExt($ext) . ".png")) {
			$path_icon = "./images/icons/". SiteHelpers::getIconExt($ext) . ".png";
		} else {
			$path_icon = "./images/icons/otros.png";
		}
		return $path_icon;
	}
	public function getRegistrarobs( Request $r)
	{
		$this->data['idrg'] = $r->idrg;
		$this->data['obs'] = $r->obs;
		$this->data['trim'] = $r->trim;
		$numero = "access_trim".$r->trim;
		$reg = $this->model->getRegistroReg($r->idrg);
		$this->data['row'] = $reg[0];
		$this->data['access_trim'] = $reg[0]->$numero;
		return view('reporte.meta.llenarobs',$this->data);	
	}
	function postSavemetaobs( Request $r)
	{
		if($r->typeobs == "obs1"){
			$data_mes = array("observaciones"=>$r->obs);
		}elseif($r->typeobs == "obs2"){
			$data_mes = array("obs2"=>$r->obs);
		}elseif($r->typeobs == "obs3"){
			$data_mes = array("obs3"=>$r->obs);
		}elseif($r->typeobs == "obs4"){
			$data_mes = array("obs4"=>$r->obs);
		}
		$this->model->getUpdateTable($data_mes,"ui_reporte_reg","idreporte_reg",$r->idrg);
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	function postDestroymetaobs( Request $r)
	{
		if($r->typeobs == "obs1"){
			$data_mes = array("observaciones"=> null);
		}elseif($r->typeobs == "obs2"){
			$data_mes = array("obs2"=> null);
		}elseif($r->typeobs == "obs3"){
			$data_mes = array("obs3"=> null);
		}elseif($r->typeobs == "obs4"){
			$data_mes = array("obs4"=> null);
		}
		$this->model->getUpdateTable($data_mes,"ui_reporte_reg","idreporte_reg",$r->idrg);
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	function postEditmetames( Request $r)
	{
		$data_mes = array("cantidad"=>$r->cantidad,"fecha_rg"=> date('Y-m-d'),"hora_rg"=> date('H:i:s'),"iduser_rg"=> Auth::user()->id);
		$this->model->getUpdateTable($data_mes,"ui_reporte_mes","idreporte_mes",$r->idrm);
		$success = "ok";
		try {
			//Inserto los arhivos
			if(isset($r->evidencia)){
				$row = $this->model->getReporteRegistro($r->idrg);
				$ruta = "archivos/metas/{$row[0]->anio}/{$row[0]->idac}/{$r->idmes}/";
				$url = "./".$ruta;
				for ($i=0; $i <count($r->evidencia) ; $i++) {
					$file = $r->evidencia[$i];
					if(!empty($file)){
						$filename = $this->getInsertImgMss($file, $url);

						//calculó el tamaño del archivo 
						$full_dir = public_path($ruta.$filename['newfilename']);
						$size = $this->getSizeFiles($full_dir);

						$data_img = array("idreporte_mes"=>$r->idrm,
										"url"=>$url.$filename['newfilename'],
										"nombre"=>$filename['filename'],
										"ext"=>$filename['ext'],
										"bytes"=>$size['bytes'],
										"size"=>$size['size'],
									);
						$this->model->getInsertTable($data_img, "ui_reporte_img");
					}
				}
			}
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error al insertar IMG, '.$e->getMessage());
		}
		$result = array("success"=>$success);
		return json_encode($result);
	}
	function postSavemetames( Request $r)
	{
		$data_mes = array("idreporte_reg"=>$r->idrg,
						"idmes"=>$r->idmes,
						"cantidad"=>$r->cantidad,
						"fecha_rg"=> date('Y-m-d'),
						"hora_rg"=> date('H:i:s A'),
						"iduser_rg"=> Auth::user()->id,
					);
		$id = $this->model->getInsertTable($data_mes,"ui_reporte_mes");
		$success = "ok";
		try {
			//Inserto los arhivos
			if(isset($r->evidencia)){
				$row = $this->model->getReporteRegistro($r->idrg);
				$ruta = "archivos/{$row[0]->no_municipio}/metas/{$row[0]->anio}/{$row[0]->idac}/{$r->idmes}/";
				$url = "./".$ruta;
				for ($i=0; $i <count($r->evidencia) ; $i++) {
					$file = $r->evidencia[$i];
					if(!empty($file)){
						$filename = $this->getInsertImgMss($file, $url);

						//calculó el tamaño del archivo 
						$full_dir = public_path($ruta.$filename['newfilename']);
						$size = $this->getSizeFiles($full_dir);

						$data_img = array("idreporte_mes"=>$id,
										"url"=>$url.$filename['newfilename'],
										"nombre"=>$filename['filename'],
										"ext"=>$filename['ext'],
										"bytes"=>$size['bytes'],
										"size"=>$size['size'],
									);
						$this->model->getInsertTable($data_img, "ui_reporte_img");
					}
				}
			}
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error al insertar IMG, '.$e->getMessage());
		}
		$result = array("success"=>$success);
		return json_encode($result);
	}
	public function getDataproject( Request $r)
	{
		$row= $this->model->getProject($r->id);
		return json_encode($row[0]);
	}
	public function getDestroyregistro( Request $r)
	{
		try {
			foreach ($this->model->getRegistrosMesImgs($r->idrm) as $v) {
				$ruta = public_path($v->ruta);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_reporte_img','idreporte_img',$v->idri);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar, '.$e->getMessage());
		}
		$this->model->getDestroyTable('ui_reporte_mes','idreporte_mes',$r->idrm);
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	public function getDestroyfile( Request $r)
	{
		try {
			foreach ($this->model->getRegistrosFile($r->idri) as $v) {
				$ruta = public_path($v->ruta);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_reporte_img','idreporte_img',$v->idri);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar file, '.$e->getMessage());
		}
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	/*
	 * 
	 * 
	 * NUEVO MÓDULO
	 * 
	 * 
	 */
	public function getAddmeta(Request $request){
		return $this->metasService->addMeta($request);
	}
	public function getEditmeta(Request $request){
		return $this->metasService->editMeta($request);
	}
	public function getMovemeta(Request $request){
		return $this->metasService->moveMeta($request);
	}
	public function getLoaddepaux(Request $request){
		return $this->metasService->loadDepAux($request);
	}
	public function getAddtrmeta( Request $request)
	{
		return $this->metasService->trMeta($request);
	}
	public function postAddmeta(Request $request){
		try {
			$dataProy = ['idinstituciones' 		=> Auth::user()->idinstituciones,
					'idanio' 				=> $request->idy,
					'id_area_coordinacion' 	=> $request->idac,
					'idproyecto' 			=> $request->idp,
					'type' 					=> 0
				];
			$id = $this->model->getInsertTable($dataProy, 'ui_reporte');
			
			for ($i=0; $i < count($request->idrg); $i++) { 
				$data = ['idreporte' 		=> $id,
						'no_accion' 		=> $request->codigo[$i],
						'descripcion' 		=> $request->meta[$i],
						'unidad_medida' 	=> $request->um[$i],
						'prog_anual' 		=> $request->anual[$i],
						'trim_1'			=> $request->t1[$i],
						'trim_2' 			=> $request->t2[$i],
						'trim_3' 			=> $request->t3[$i],
						'trim_4' 			=> $request->t4[$i]
					];
				$this->model->getInsertTable($data, 'ui_reporte_reg');
			}
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Proyecto con metas guardadas correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $request , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al guardar la información!"];
		}
		return response()->json($response);
	}
	public function postMovemeta(Request $request){
		try {
			$data = ['id_area_coordinacion' => $request->idac];
			$this->model->getUpdateTable($data, 'ui_reporte', 'idreporte', $request->id);
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Proyecto transferido correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $request , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al guardar la información!"];
		}
		return response()->json($response);
	}
	public function postEditmeta(Request $request){
		try {
			for ($i=0; $i < count($request->idrg); $i++) { 
				$data = ['idreporte' 		=> $request->id,
						'no_accion' 		=> $request->codigo[$i],
						'descripcion' 		=> $request->meta[$i],
						'unidad_medida' 	=> $request->um[$i],
						'prog_anual' 		=> $request->anual[$i],
						'trim_1'			=> $request->t1[$i],
						'trim_2' 			=> $request->t2[$i],
						'trim_3' 			=> $request->t3[$i],
						'trim_4' 			=> $request->t4[$i]
					];

				if($request->idrg[$i] > 0){
					$this->model->getUpdateTable($data, 'ui_reporte_reg', 'idreporte_reg', $request->idrg[$i]);
				}else{
					$this->model->getInsertTable($data, 'ui_reporte_reg');
				}
			}
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Meta guardada correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $request , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al guardar la meta!"];
		}
		return response()->json($response);
	}
	public function deleteMeta( Request $r){
		try {
			DB::transaction(function () use ($r) {
				$this->model->getDestroyTable('ui_reporte_reg','idreporte_reg',$r->id);
			});
			$response = ["status" => "ok", "message" => "Meta eliminada correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error al eliminar la meta: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al eliminar la meta!"];
		}
		return response()->json($response);
	}
	public function deleteMetafull( Request $request){
		try {
			$this->model->getDestroyTable('ui_reporte','idreporte',$request->id);
			$this->model->getDeleteMetasDelProyecto($request->id);
			$response = ["status" => "ok", "message" => "Meta eliminada correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail($request, "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al eliminar la meta!"];
		}
		return response()->json($response);
	}
	public function getReversereconduccion( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$rec = "rec".$r->trim;
			$oficio = "oficio".$r->trim;
			$this->model->getUpdateTable([$rec => null, $oficio => null], "ui_reporte", "idreporte", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReverserecindicador( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$rec = "rec".$r->trim;
			$this->model->getUpdateTable([$rec => null], "ui_reporte_mir", "idreporte_mir", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReversejustificacion( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$jus = "jus".$r->trim;
			$this->model->getUpdateTable([$jus => null], "ui_reporte", "idreporte", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReversepbrmocho( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$ocho = "foda".$r->trim;
			$this->model->getUpdateTable([$ocho => null], "ui_reporte", "idreporte", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReverseochob( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$ocho = "url".$r->trim;
			$semaforo = "idmir_semaforo".$r->trim;
			$this->model->getUpdateTable([$ocho => null, $semaforo => 0], "ui_reporte_mir", "idreporte_mir", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReversefoda( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$foda = "foda".$r->trim;
			$this->model->getUpdateTable([$foda => null], "ui_reporte", "idreporte", $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getReversedictamen( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$dictamen = $this->model->getReporteDictamenPdf($decoder['idac'], $decoder['type']);
			$dic = "dic".$r->trim;
			$arr_dictamen = [$dic => null];
			$this->model->getUpdateTable($arr_dictamen, "ui_reporte_dic", "idreporte_dic", $dictamen[0]->id);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($r->number);
			$response = ["status"=> "ok", "message"=>"PDF revertido exitosamente" ];
		}else{
			$response = ["status"=>"error", "message"=>"Error de key." ];
		}
		return response()->json($response);
	}
	public function getMetasprojectsindicador( Request $r){
		$data = array();
		$j = 1;
		$decoder = SiteHelpers::CF_decode_json($r->id);
		$json = $this->metasService->viewInforMetasIndicadores($decoder, $r->all());
		return response()->json($json);
	}
	public function getMetasprojects( Request $r){
		$data = array();
		$j = 1;
		$decoder = SiteHelpers::CF_decode_json($r->id);
		$json = $this->metasService->viewInforMetas($decoder, $r->all());
		return response()->json($json);
	}
	public function getMesesedit( Request $r)
	{
		$this->data['idrm'] = $r->idrm;
		$this->data['trim'] = $r->trim;
		$row = $this->model->getRegMes($r->idrm);
		$this->data['row'] = $row[0];
		return view('reporte.proyectos.meses.edit',$this->data);	
	}
	function postMesesedit( Request $r){
		$data_mes = ["cantidad"=>$r->cantidad];
		$this->model->getUpdateTable($data_mes,"ui_reporte_mes","idreporte_mes",$r->idrm);
		try {
			if(isset($r->evidencia))
				$this->getInsertFilesMultiple($r->idrm,$r->idrg, $r->idmes, $r->trim, $r->evidencia);
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al insertar IMG, '.$e->getMessage());
		}
		$response = ["status"=>"ok", "message"=>"Información guardada correctamente!" ];
		return response()->json($response);
	}
	function postSavemeses( Request $r){
		$data_mes = array("idreporte_reg"	=>	$r->idrg,
						"idmes"				=>	$r->idmes,
						"cantidad"			=>	$r->cantidad,
						"fecha_rg"			=> date('Y-m-d'),
						"hora_rg"			=> date('H:i:s A'),
						"iduser_rg"			=> Auth::user()->id,
					);
		$id = $this->model->getInsertTable($data_mes,"ui_reporte_mes");
		//Imagenes
		try{
			if(isset($r->evidencia))
				$this->getInsertFilesMultiple($id,$r->idrg, $r->idmes, $r->trim, $r->evidencia);
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al insertar IMG, '.$e->getMessage());
		}

		$response = ["status"=>"ok", "message"=>"Información guardada correctamente!" ];
		return response()->json($response);
	}
	public function deleteGallery( Request $r)
	{
		try {
			foreach ($this->model->getGalleryMesImgs($r->idrm) as $v) {
				$url = $v->url.'/'.$v->nombre.'.'.$v->ext;
				$ruta = public_path($url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_reporte_img','idreporte_img',$v->idri);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error eliminar archivo: '.$e->getMessage());
		}
		$this->model->getDestroyTable('ui_reporte_mes','idreporte_mes',$r->idrm);
		$response = ["status"=>"ok", "message"=>"Archivos eliminados correctamente!" ];
		return response()->json($response);
	}
	public function deleteGalleryfile( Request $r)
	{
		try {
			foreach ($this->model->getRegistrosFileID($r->idri) as $v) {
				$url = $v->url.'/'.$v->nombre.'.'.$v->ext;
				$ruta = public_path($url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_reporte_img','idreporte_img',$v->idri);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar file, '.$e->getMessage());
		}
		$response = ["status"=>"ok", "message"=>"Archivo eliminado correctamente!" ];
		return response()->json($response);
	}
	private function getInsertFilesMultiple($id,$idrg, $idmes, $trim, $evidencia){
		$row = $this->model->getReporteRegistro($idrg);
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectoryGallery($row[0]->no_institucion, $row[0]->anio, ($row[0]->type == 1 ? 'indicador' : 'meta'), 'files', $idrg);
		$url = "./".$result['directory'];
		$name_dir = ($row[0]->type == 1 ? 'IFF' : 'MFF');
		for ($i=0; $i <count($evidencia) ; $i++) {
			$file = $evidencia[$i];
			if(!empty($file)){
				$number = $this->getBuildFilenamePDF($name_dir.$trim,$row[0]->no_institucion,$row[0]->no_dep_gen,$idrg);
				$filename = $this->getInsertImgMssFiles($file, $url, $number);
				$full_dir = public_path($result['directory'].$filename['newfilename']);
				$size = $this->getSizeFiles($full_dir);
				$data_img = array("idreporte_mes"=>$id,
								"url"=>$url,
								"nombre"=>$number,
								"ext"=>$filename['ext'],
								"bytes"=>$size['bytes'],
								"size"=>$size['size'],
							);
				$this->model->getInsertTable($data_img, "ui_reporte_img");
			}
		}
	}
	public function getGallery( Request $r)
	{
		$data = array();
		$j = 1;
		foreach ($this->model->getRegistrosMes($r->idrg,$r->idmes) as $v) {
			$data[] = array("j"=>$j++,
							"idrm"=>$v->idrm,
							"cant"=>$this->getQuitarDobleCeros($v->cant),
							"fecha_rg"=>$v->fecha_rg,
							"hora_rg"=>$v->hora_rg,
							"usuario"=>$v->usuario,"rowsImgs"=>$this->getRowImgGallery($v->idrm));
		}
		return json_encode($data);
	}
	protected function getRowImgGallery($idrm){
		$data=array();
		foreach ($this->model->getGalleryMesImgs($idrm) as $v) {
			$url = $v->url.'/'.$v->nombre.'.'.$v->ext;
			$data[]=array(
				"idri" => $v->idri, 
				"url" => asset($url), 
				"ico" => asset($this->getTypeImg($url,$v->ext)), 
			);	
		}
		return $data;
	}

	/*
	 * GENERACIÓN DE PDF 
	 */
	public function getFormatos( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			if($r->type == 1){//Formato de Reconducción
				$this->data['json'] = $this->metasService->viewFormatoReconduccion($decoder, $r->all());
				return view($this->module.'.proyectos.formatos.reconduccion.view',$this->data);	
			}else if($r->type == 2){//Formato tarjeta de justificación
				$this->data['json'] = $this->metasService->viewFormatoJustificacion($decoder, $r->all());
				return view($this->module.'.proyectos.formatos.justificacion.view',$this->data);	
			}else if($r->type == 4){//Formato PbRM-08c
				$this->data['json'] = $this->metasService->viewFormatoOchoc($decoder,$r->all());
				return view($this->module.'.proyectos.formatos.ochoc.view',$this->data);	
			}else if($r->type == 3){//Formato Dictamen
				$this->data['json'] = $this->metasService->viewFormatoDictamen($decoder, $r->all());
				return view($this->module.'.proyectos.formatos.dictamen.view',$this->data);	
			}
		}
	}
	public function postPdfreconduccion( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				//Validaciones de campos
				if(empty($r->oficio)){
					$response = ["status"=>"error","message"=>"Ingresa número de oficio."];
					return response()->json($response);
				}else if(empty($r->fecha)){
					$response = ["status"=>"error","message"=>"Ingresa fecha."];
					return response()->json($response);
				}else if(empty($r->t_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa nombre completo del titular del área."];
					return response()->json($response);
				}else if(empty($r->t_tesoreria)){
					$response = ["status"=>"error","message"=>"Ingresa nombre completo del responsable de tesorería."];
					return response()->json($response);
				}else if(empty($r->t_uippe)){
					$response = ["status"=>"error","message"=>"Ingresa nombre completo del responsable de la UIEPPE o equivalente."];
					return response()->json($response);
				}
				$json = json_decode($r->input('json'), true);
				/*Se construye el nombre del PDF
					MFR[1,2,3,4] = Avance de Meta Formato de Reconducción con Número del trimestre
				*/
				$number = $this->getBuildFilenamePDF("MFR".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], 'meta', 'rec', $json['trimestre']['numero']);
				//Json
				$this->data['json'] 		= $json;
				//Datos generales
				$this->data['oficio'] 		= $r->oficio;
				$this->data['fecha'] 		= $r->fecha;
				$this->data['t_dep_gen'] 	= $r->t_dep_gen;
				$this->data['t_tesoreria'] 	= $r->t_tesoreria;
				$this->data['t_uippe'] 		= $r->t_uippe;
				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
										'margin_top' => 25,
										'margin_left' => 5,
										'margin_right' => 5,
										'margin_bottom' => 37
									]);
				$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.reconduccion.header", $this->data)->render());
				$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.reconduccion.body", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.reconduccion.footer", $this->data)->render());
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				//Insercción de URL en la tabla	
				$this->getUpgradePbrmRec($decoder['id'], $json['trimestre']['numero'], $number, $r->oficio);
				//Insert PDF in Table
				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
				//Response
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , "Formato PDF Reconducción : ".$e->getMessage());
				$response = ["status"=>"error", "message"=>"Error al generar el PDF."];
			}
		}else{
			$response = ["status"=>"error", "message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmRec($id, $trim, $number, $oficio){
		$this->model->getUpdateTable(['oficio'.$trim => $oficio, 'rec'.$trim => $number], "ui_reporte", "idreporte", $id);
	}
	public function postPdfjustificacion( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				//Validaciones de campos
				if(empty($r->fecha)){
					$response = ["status"=>"error","message"=>"Campo fecha vacio, ingresa fecha."];
					return response()->json($response);
				}else if(empty($r->folio_reconduccion)){
					$response = ["status"=>"error","message"=>"Ingresa número de folio de reconducción"];
					return response()->json($response);
				}else if(empty($r->folio)){
					$response = ["status"=>"error","message"=>"Ingresa folio."];
					return response()->json($response);
				}else if(empty($r->t_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa nombre del director del área"];
					return response()->json($response);
				}else if(empty($r->c_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa cargo del director del área"];
					return response()->json($response);
				}
				$json = json_decode($r->input('json'), true);
				$this->data['json'] = $json;
				$this->data['fecha'] = $r->fecha;
				$this->data['folio_reconduccion'] = $r->folio_reconduccion;
				$this->data['folio'] = $r->folio;
				$this->data['t_dep_gen'] = $r->t_dep_gen;
				$this->data['c_dep_gen'] = $r->c_dep_gen;
				$number = $this->getBuildFilenamePDF(($json['type'] == 1 ? "IFJ" : "MFJ").$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], ($json['type'] == 1 ? "indicador" : "meta"), 'jus', $json['trimestre']['numero']);
				$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
								'margin_top' => 25,
							'margin_left' => 0,
							'margin_right' => 0,
							'margin_bottom' => 30,
									]);
				$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.justificacion.header", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.justificacion.footer", $this->data)->render());
				$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.justificacion.body", $this->data)->render());
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				//Insercción de URL en la tabla	
				$this->getUpgradePbrmJus($decoder['id'], $json['trimestre']['numero'], $number);
				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF."];
				\SiteHelpers::auditTrail($r ,'Error Formato Tarjeta de Justificación - '.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmJus($id, $trim, $number){
		$this->model->getUpdateTable(['jus'.$trim => $number], "ui_reporte", "idreporte", $id);
	}
	public function postPdfdictamen( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				//Validaciones de campos
				if(empty($r->fecha)){
					$response = ["status"=>"error","message"=>"Campo fecha vacio, ingresa fecha."];
					return response()->json($response);
				}else if(empty($r->oficio)){
					$response = ["status"=>"error","message"=>"Ingresa número de oficio."];
					return response()->json($response);
				}else if(empty($r->asunto)){
					$response = ["status"=>"error","message"=>"Ingresa asunto."];
					return response()->json($response);
				}else if(empty($r->t_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa nombre del director del área"];
					return response()->json($response);
				}else if(empty($r->c_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa cargo del director del área"];
					return response()->json($response);
				}else if(empty($r->t_uippe)){
					$response = ["status"=>"error","message"=>"Ingresa nombre del titular de la UIPPE"];
					return response()->json($response);
				}
				$json = json_decode($r->input('json'), true);
				$this->data['json'] = $json;
				$this->data['fecha'] = $r->fecha;
				$this->data['oficio'] = $r->oficio;
				$this->data['asunto'] = $r->asunto;
				$this->data['t_dep_gen'] = $r->t_dep_gen;
				$this->data['c_dep_gen'] = $r->c_dep_gen;
				$this->data['t_uippe'] = $r->t_uippe;

				$number = $this->getBuildFilenamePDF(($json['type'] == 1 ? "IFD" : "MFD").$json['trimestre']['numero'],$json['header']['no_institucion'],$json['header']['no_dep_gen'],$decoder['idac']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], ($json['type'] == 1 ? "indicador" : "meta"), 'dic', $json['trimestre']['numero']);
				$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
									'margin_top' => 28,
									'margin_left' => 0,
									'margin_right' => 0,
									'margin_bottom' => 30,
									]);
				$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.dictamen.header", $this->data)->render());
				$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.dictamen.body", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.dictamen.footer", $this->data)->render());
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				//Valido si no existe el registro para agregarlo
				$dictamen = $this->model->getReporteDictamenPdf($decoder['idac'], $decoder['type']);
				$dic = "dic".$json['trimestre']['numero'];
				if(count($dictamen) == 0 ){
					$arr_dictamen = ['idarea_coordinacion' => $decoder['idac'], 
									'type' => $decoder['type'],
									$dic => $number
								];
					$this->model->getInsertTable($arr_dictamen, "ui_reporte_dic");
				}else{
					$arr_dictamen = [$dic => $number];
					$this->model->getUpdateTable($arr_dictamen, "ui_reporte_dic", "idreporte_dic", $dictamen[0]->id);
				}

				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF."];
				\SiteHelpers::auditTrail($r ,'Error Oficio Dictamen de Reconducción - '.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	public function postGeneratepdfeightc( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				//Validaciones de campos
				if(empty($r->total)){
					$response = ["status"=>"error","message"=>"Ingresa número en total!"];
					return response()->json($response);
				}else if(empty($r->txt_elaboro)){
					$response = ["status"=>"error","message"=>"Ingresa nombre de la persona que elaboro!"];
					return response()->json($response);
				}else if(empty($r->txt_elaboro_cargo)){
					$response = ["status"=>"error","message"=>"Ingresa cargo de la persona que elaboro!"];
					return response()->json($response);
				}else if(empty($r->txt_reviso)){
					$response = ["status"=>"error","message"=>"Ingresa nombre de la persona que reviso!"];
					return response()->json($response);
				}else if(empty($r->txt_reviso_cargo)){
					$response = ["status"=>"error","message"=>"Ingresa cargo de la persona que reviso!"];
					return response()->json($response);
				}else if(empty($r->txt_autorizo)){
					$response = ["status"=>"error","message"=>"Ingresa nombre de la persona que autorizo!"];
					return response()->json($response);
				}else if(empty($r->txt_reviso_cargo)){
					$response = ["status"=>"error","message"=>"Ingresa cargo de la persona que autorizo!"];
					return response()->json($response);
				}

				$json = json_decode($r->input('json'), true);
				/*Se construye el nombre del PDF
					MFC[1,2,3,4] = Avance de Meta Formato Ochoc con Número del trimestre
				*/
				$number = $this->getBuildFilenamePDF("MFC".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], 'meta', 'ochoc', $json['trimestre']['numero']);
				$this->data['json'] = $json;
				$this->data['total'] = $r->total;
				$this->data['txt_elaboro'] = $r->txt_elaboro;
				$this->data['txt_elaboro_cargo'] = $r->txt_elaboro_cargo;
				$this->data['txt_reviso'] = $r->txt_reviso;
				$this->data['txt_reviso_cargo'] = $r->txt_reviso_cargo;
				$this->data['txt_autorizo'] = $r->txt_autorizo;
				$this->data['txt_autorizo_cargo'] = $r->txt_autorizo_cargo;
				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
										'margin_top' => 27,
										'margin_left' => 5,
										'margin_right' => 5,
										'margin_bottom' => 37,
										]);
				$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.ochoc.header", $this->data)->render());
				$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.ochoc.body", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.ochoc.footer", $this->data)->render());
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				//Insercción de URL en la tabla	
				$this->getUpgradePbrmOcho($decoder['id'], $json['trimestre']['numero'], $number);
				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);

				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF."];
				\SiteHelpers::auditTrail($r ,'Error formato PbRM-08c - '.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error", "message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmOcho($id, $trim, $number){
		$this->model->getUpdateTable(['foda'.$trim => $number], "ui_reporte", "idreporte", $id);
	}

	public function getPermisos( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE,Auth::user()->idinstituciones,$r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 2;
		$this->data['activeName'] 	= 'Permisos Metas';
		return view('reporte.proyectos.permisos.index',$this->data);	
	}
	public function getReconducciones(Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE,Auth::user()->idinstituciones,$r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
        $idi =  \Auth::user()->idinstituciones;
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 7;
		$this->data['activeName'] 	= 'Reconducciones Metas';
		$this->data['rowsDepGen'] 	= $this->model->getCatDepGeneralNew($idi, $r->idy);
		return view('reporte.proyectos.reconducciones.index',$this->data);	
	}
	public function getSearchreconducciones( Request $r){
		return $this->metasService->viewMetasReconduccion($r->all());
	}
	public function getSearchsegmetas( Request $r){
		return $this->metasService->viewSeguimientoMetas($r->all());
	}
	public function getSeguimiento( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 3;
		$this->data['trim'] 		= $this->getSelectMesActual($modulo[0]->anio);
		$this->data['activeName'] 	= 'Seguimiento por meta';
		return view('reporte.proyectos.seguimiento.seguimiento',$this->data);	
		return view('reporte.proyectos.seguimiento.index',$this->data);	
	}
	public function getMetasproyecto( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 8;//Metas proyecto
		$this->data['activeName'] 	= 'Metas proyectos';
		return view('reporte.proyectos.metas.index',$this->data);	
	}
	public function getMetasproyectosall(Request $request){
		$data = $this->metasService->getRowsMetasProyectos($request);
		return response()->json($data);
	}
	private function getSelectMesActual($year){
		if($year < date('Y')){
			return 4;
		}

		$mes = date('n');
		if($mes == 1 || $mes == 2 || $mes == 3){
			return 1;
		}else if($mes == 4 || $mes == 5 || $mes == 6){
			return 2;
		}else if($mes == 7 || $mes == 8 || $mes == 9){
			return 3;
		}else if($mes == 10 || $mes == 11 || $mes == 12){
			return 4;
		}
	}
	public function getCalendarizar(Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 4;
		$this->data['activeName'] 	= 'Calendarización de metas';
		return view('reporte.proyectos.calendarizar.index',$this->data);	
	}
	public function getOchoc(Request $r)
	{
		$idy = $r->idy;
        $idi =  Auth::user()->idinstituciones;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, $idi,$idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 0;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $idy;
		$this->data['active'] 		= 6;
		$this->data['activeName'] 	= 'PbRM-08c';
		$this->data['nameTxt'] 	= 'AM'.$modulo[0]->clave.$modulo[0]->no_institucion.$modulo[0]->anio;
		//Dep Gen
		$this->data['rowsIns']   	= $this->model->getDependenciasGenerales($idy,$idi);
		return view('reporte.proyectos.ochoc.index',$this->data);	
	}
	public function getGraficas(Request $r){
		$idy = $r->idy;
		$idi = Auth::user()->idinstituciones;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, $idi, $idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$type = 0;
		$this->data['type'] 		= $type;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $idy;
		$total = $this->model->getGraficasTotalMetas($idy,$idi,$type);
		$this->data['total'] = $total[0]->total;
		$info = $this->model->getGraficasTotalMetasPorcentaje($idy,$idi,$type,$total[0]->total);
		$this->data['info'] = $info;
		$str ="";
		$porcentaje=array();
		$color=array();
		$area=array();
		foreach ($info as $key => $v) {
			$porcentaje[] = $v->porcentaje;
			$color[] = $this->getGenerarColorAleatorio();
			$area[] = $v->area;
		}
		$this->data['porcentaje'] = json_encode($porcentaje);
		$this->data['color'] = json_encode($color);
		$this->data['area'] = json_encode($area);
		$this->data['active'] = 5;
		$this->data['activeName'] = 'Gráficas de metas';
		return view('reporte.proyectos.graficas.index',$this->data);	
	}
	public function getGraficasmetasexportar(Request $r)
	{
		$idi = \Auth::user()->idinstituciones;
		$total = $this->model->getGraficasTotalMetas($r->idy, $idi, $r->type);
		return $this->exportar->getExportarGraficasMetas($this->model->getGraficasTotalMetasPorcentaje($r->idy,$idi, $r->type,$total[0]->total));
	}	
	public function getCuentapublica( Request $r)
	{
		$rows  = \DB::select("SELECT r.idreporte as id,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,pr.numero as no_programa,pr.descripcion as programa,
		a.idarea,pr.idprograma  FROM ui_reporte r
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
		where r.idanio = {$r->idy} and r.type = 0 and a.idinstituciones = 1");
		$data = [];
		foreach ($rows as $v) {
			$val = \DB::select("SELECT sum(val.prog_anual) as anual,sum(val.cantidad) as cantidad from (SELECT r.idreporte_reg as id,r.prog_anual,info.cantidad FROM ui_reporte_reg r
			left join (select m1.idreporte_reg, sum(m1.cantidad) as cantidad from ui_reporte_mes m1 group by m1.idreporte_reg) as info on info.idreporte_reg = r.idreporte_reg
			where r.idreporte = {$v->id}) as val ");

			if(count($val) > 0){
				$anual = $val[0]->anual;
				$cantidad = $val[0]->cantidad;
			}else{
				$anual = 0;
				$cantidad = 0;
			}
			$pdm = $this->getCuentaPublicaPDM($v->idarea, $r->idy, $v->idprograma);
			$data[] = ['no_dep_aux' => $v->no_dep_aux, 
						'dep_aux' => $v->dep_aux, 
						'no_dep_gen' => $v->no_dep_gen, 
						'dep_gen' => $v->dep_gen, 
						'no_programa' => $v->no_programa, 
						'programa' => $v->programa, 
						'anual' => $anual, 
						'cantidad' => $cantidad, 
						'obj' => $pdm['obj'], 
						'est' => $pdm['est'], 
						'linea' => $pdm['linea'], 
					];
		}
		$arr = [];
		foreach ($data as $k) {
			$aux = $k['no_programa'].'_'.$k['no_dep_gen'].'_'.$k['no_dep_aux']; 
			if(isset($arr[$aux])){
				$arreglo = $arr[$aux];
				$arr[$aux] = ['no_dep_aux' => $k['no_dep_aux'], 
						'dep_aux' => $k['dep_aux'], 
						'no_dep_gen' => $k['no_dep_gen'], 
						'dep_gen' => $k['dep_gen'], 
						'no_programa' => $k['no_programa'], 
						'programa' => $k['programa'], 
						'anual' => $k['anual'] + $arreglo['anual'], 
						'cantidad' => $k['cantidad'] + $arreglo['cantidad'], 
						'obj' => $k['obj'], 
						'est' => $k['est'], 
						'linea' => $k['linea'], 
					];
			}else{
				$arr[$aux] = ['no_dep_aux' => $k['no_dep_aux'], 
						'dep_aux' => $k['dep_aux'], 
						'no_dep_gen' => $k['no_dep_gen'], 
						'dep_gen' => $k['dep_gen'], 
						'no_programa' => $k['no_programa'], 
						'programa' => $k['programa'], 
						'anual' => $k['anual'], 
						'cantidad' => $k['cantidad'], 
						'obj' => $k['obj'], 
						'est' => $k['est'], 
						'linea' => $k['linea'], 
					];
			}
		}
		return $this->exportar->getExportarCuentaPublica($arr);
	}
	private function getCuentaPublicaPDM($ida,$idy,$idp){
		$pdm = \DB::select("SELECT objetivo_programa,estrategias_objetivo,pdm FROM ui_pres_pbrm01b where idarea = {$ida} and idanio = {$idy} and std_delete = 1 and idprograma = {$idp} ");
		$obj = $est = $linea = "";
		foreach ($pdm as $v) {
			$obj = $obj . $v->objetivo_programa;
			$est = $est . $v->estrategias_objetivo;
			$linea = $linea . $v->pdm;
		}
		$data = ['obj'=>$obj, 'est'=>$est, 'linea'=>$linea];
		return $data;
	}











	/*
	 * 
	 * DESARROLLO VIEJO 
	 * 
	 */
	public function getProyectos( Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$this->data['idac'] = $decoder['idac'];//ui_area_coordinacion
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$this->data['type'] = $r->type;
		$this->data['idy']  = $r->idy;
		$this->data['year'] = $r->year;
		$this->data['k'] = $r->k;
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		return view('reporte.old.anio',$this->data);	
	}
	public function getSearch( Request $r ){
		$idy = $r->idy;
		$idi = Auth::user()->idinstituciones;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, $idi, $idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$data = array();
		$month_current = date("n");
		$idac = $decoder['idac'];
		$type = $r->type;//0 - Metas , 1 - Indicadores
		$anio = $modulo[0]->anio;
		$idanio = $idy;
		//Asignación de valores
		$this->data['idac'] = $idac;//ui_area_coordinacion
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$this->data['idy'] = $idanio;
		$this->data['year'] = $anio;
		$this->data['type'] = $type;
		//0 - Reporte Avance de Metas
		//1 - Indicadores Estrategicos
		//PDF 1 Meta - Reconducción 
		//PDF 2 Meta - Justificación
		//PDF 3 Meta - Dictamen
		//PDF 4 Indicador - Reconducción
		//PDF 5 Indicador - Justificación
		//PDF 6 Indicador - Dictamen
			$projects = array();
			$total_1 = $total_2 = $total_3 = $total_4 = 0;
			
			foreach ($this->model->getReporte($idac,$idy,$type) as $p) {
				$t1 = $t2 = $t3 = $t4 = array("total"=>0,"url"=>'','url_j'=>'');
				
				$trim1 = $this->getRowsInfo(1,$p->idreporte);
				$trim2 = $this->getRowsInfo(2,$p->idreporte);
				$trim3 = $this->getRowsInfo(3,$p->idreporte);
				$trim4 = $this->getRowsInfo(4,$p->idreporte);

				if($anio >= date('Y')){
					if(($month_current > 2)){
						$t1 = $this->getReconduccionPDF($p->idreporte,1,$idanio);
					}
					if($month_current > 5){
						$t2 = $this->getReconduccionPDF($p->idreporte,2,$idanio);
					}
					if($month_current > 8){
						$t3 = $this->getReconduccionPDF($p->idreporte,3,$idanio);
					}
					if($month_current > 11){
						$t4 = $this->getReconduccionPDF($p->idreporte,4,$idanio);
					}
				}else{
					//Aplica para años anteriores, ejemplo 2022 < 2023
					$t1 = $this->getReconduccionPDF($p->idreporte,1,$idanio);
					$t2 = $this->getReconduccionPDF($p->idreporte,2,$idanio);
					$t3 = $this->getReconduccionPDF($p->idreporte,3,$idanio);
					$t4 = $this->getReconduccionPDF($p->idreporte,4,$idanio);
				}
				
				$projects[] = array("idreporte"=>$p->idreporte,
									"numero"=>$p->numero,
									"proyecto"=>$p->proyecto,
									"idproyecto"=>$p->idproyecto,
									"t1"=>$t1,
									"t2"=>$t2,
									"t3"=>$t3,
									"t4"=>$t4,
									"total_proj_1"=>$trim1['total'],
									"total_proj_2"=>$trim2['total'],
									"total_proj_3"=>$trim3['total'],
									"total_proj_4"=>$trim4['total'],
								);
				$total_1 += $trim1['total'];
				$total_2 += $trim2['total'];
				$total_3 += $trim3['total'];
				$total_4 += $trim4['total'];
			}
			$d1 = $d2 = $d3 = $d4 = array("total"=>0,"url"=>'');
			if($anio >= date('Y')){
				/*
				* Type = 3; Dictamen
				*/
				if(($month_current > 2)){
					$d1 = $this->getOficioPDFDictamen($idac,1,$total_1,$idanio);
				}
				if($month_current > 5){
					$d2 = $this->getOficioPDFDictamen($idac,2,$total_2,$idanio);
				}
				if($month_current > 8){
					$d3 = $this->getOficioPDFDictamen($idac,3,$total_3,$idanio);
				}
				if($month_current > 11){
					$d4 = $this->getOficioPDFDictamen($idac,4,$total_4,$idanio);
				}
			}else{
				//Aplica para años anteriores, ejemplo 2022 < 2023
				$d1 = $this->getOficioPDFDictamen($idac,1,$total_1,$idanio);
				$d2 = $this->getOficioPDFDictamen($idac,2,$total_2,$idanio);
				$d3 = $this->getOficioPDFDictamen($idac,3,$total_3,$idanio);
				$d4 = $this->getOficioPDFDictamen($idac,4,$total_4,$idanio);
			}
			$data[] = array("ida"=>$idanio,
							"anio"=>$anio,
							"reporte"=> $projects,
							"d1"=>$d1,
							"d2"=>$d2,
							"d3"=>$d3,
							"d4"=>$d4,
						);
		$this->data['j'] = 1;
		$this->data['rows'] = $data;
		$row=$this->model->getAreaCoordinacion($idac);
		$this->data['row'] = $row[0];
		return view('reporte.old.search',$this->data);
	}
	public function getViewanalisis( Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$rows = $this->model->getProject($decoder['idp']);
		$row =$this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		$this->data['rows'] = $rows[0];
		$proy = $this->model->getRowReporte($decoder['idr']);
		$this->data['proy'] = $proy[0];
		$this->data['info'] =  $this->getReportesRegistrados($decoder['idr']);
		return view('reporte.old.analisis',$this->data);	
	}
	public function getPdf(Request $r){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$rows = $this->model->getProject($decoder['idp']);
			$row=$this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['row'] = $row[0];
			$this->data['rows'] = $rows[0];
			$proy = $this->model->getRowReporte($decoder['idr']);
			$this->data['proy'] = $proy[0];
			$this->data['metas'] = $this->getMetas($decoder['idr']);
			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
				'margin_top' => 65,
				'margin_left' => 5,
				'margin_right' => 5,
				'margin_bottom' => 5,
			]);
			//Institución logos
			$ins = $this->model->getInstitucion($decoder['idi']);
			$this->data['ins'] = $ins[0];
			$mpdf->SetHTMLHeader(View::make("reporte.old.pdf.header", $this->data)->render());
			// Configurar encabezado
			$mpdf->WriteHTML(view("reporte.old.pdf.".($decoder['type'] == 0 ? 'reporte' : 'indicadores'),$this->data));
			return $mpdf->Output();
		}else{
			return view('errors.414');
		}
	}
	private function getOficioPDFDictamen($idac,$trim,$total,$idanio){
		$dic = $this->model->getPdfReporte($idac,$trim,3,$idanio);
		$total = ($total > 0 ? 1 : 2);
		return array("total"=>$total,
					"idrp_dic"=> count($dic) > 0 ? SiteHelpers::CF_encode_json(array('idrp'=>$dic[0]->idrp)) : "",
					"url"=> count($dic) > 0 ? $dic[0]->url : "",
				);
	}
	private function getReconduccionPDF($idr,$trim,$idanio){
		$rec = $this->model->getPdfReporte($idr,$trim,1,$idanio);//Type = 1; Reconducción
		$just = $this->model->getPdfReporte($idr,$trim,2,$idanio);//Type = 2; Justificacion
		return array('total'=>1, 
					'idrp_rec'=> count($rec) > 0 ? SiteHelpers::CF_encode_json(array('idrp'=>$rec[0]->idrp)) : '', 
					'url'=> count($rec) > 0 ? $rec[0]->url : '', 
					'idrp_jus'=> count($just) > 0 ? SiteHelpers::CF_encode_json(array('idrp'=>$just[0]->idrp)) : '',
					'url_j'=> count($just) > 0 ? $just[0]->url : '');
	}

	/*
    |--------------------------------------------------------------------------
    | PERMISOS, FODA
    |--------------------------------------------------------------------------
    */
	public function getProjectpermits(Request $r){
		$idi = \Auth::user()->idinstituciones;
		$idy = $r->idy;
		$data = array();
		$rows = $this->getDataProjectsByArea($idy,$idi,$r->type);
		return response()->json($rows);
	}	
	private function getDataProjectsByArea($idy, $idi, $type){
		$data = [];
		foreach ($this->model->getProjectpermitsbyarea($idy, $idi, $type) as $v) {
			$arr = ['id' => $v->id, 
					'nop' => $v->no_proyecto,
					'pro' => $v->proyecto,
					'nda' => $v->no_dep_aux,
					'da' => $v->dep_aux,
					'a1' => $v->a1,
					'a2' => $v->a2,
					'a3' => $v->a3,
					'a4' => $v->a4
				];
			if(isset($data[$v->no_dep_gen])){
				$data[$v->no_dep_gen]['rows'][] = $arr;
			}else{
				$data[$v->no_dep_gen] = ['nodg' => $v->no_dep_gen, 'dg' => $v->dep_gen, 'rows' =>[ $arr]];
			}
			
		}
		return $data;
	}
	function postChangepermission( Request $request){
		$no = ($request['params']['numero'] == 1 ? 0 : 1);
		$data = array("access_trim".$request['params']['trim'] => $no);
		$this->model->getUpdateTable($data,"ui_reporte","idreporte",$request['params']['idr']);
		$response = ["status" => "ok", "message" => "Información guardada correctamente."];
		return response()->json($response);
	}
	function postChangepermissiontrim(Request $request){
		$idi = \Auth::user()->idinstituciones;
		$idy = $request['params']['idy'];
		$type = $request['params']['type'];
		foreach ($this->model->getProjectpermitsbyarea($idy,$idi,$type) as $v) {
			$data = array("access_trim".$request['params']['trim'] => $request['params']['numero']);
			$this->model->getUpdateTable($data,"ui_reporte","idreporte",$v->id);
		}
		$response = ["status" => "ok", "message" => "Información guardada correctamente."];
		return response()->json($response);
	}
	public function getFoda(Request $r){
		$data = $this->getRowsInfoFODA($r->idy, $r->type, $r->trim);
		return response()->json($data);
	}
	private function getRowsInfoFODA($idy, $type, $trim){
		$idi = \Auth::user()->idinstituciones;
		$data = array();
		foreach ($this->model->getProjectpermitsbyarea($idy,$idi,$type) as $v) {
			$rows = $this->getRowsFoda($v->id, $trim);
			if(count($rows) > 0){
				$data[] = array(
							"no_programa"		=> $v->no_programa,
							"programa"			=> $v->programa,
							"dep_gen"			=> $v->dep_gen,
							"dep_aux"			=> $v->dep_aux,
							"no_dep_gen"		=> $v->no_dep_gen,
							"no_dep_aux"		=> $v->no_dep_aux,
							"f1"				=> isset($rows[1]) ? $rows[1] : [],
							"f2"				=> isset($rows[2]) ? $rows[2] : [],
							"f3"				=> isset($rows[3]) ? $rows[3] : [],
							"f4"				=> isset($rows[4]) ? $rows[4] : [],
				);
			}
		}
		return $data;
	}
	private function getRowsFoda($id, $trim){
		$data = [];
		foreach ($this->model->getRowsFodaReporte($id, $trim) as $v) {
			$key = $v->type;
			$data[$key][] = $v->foda;
		}
		return $data;
	}
	public function getFodaexportar(Request $r){
		$data = $this->getRowsInfoFODA($r->idy, $r->type, $r->trim);
		return $this->exportar->getExportarFODA($data);
	}	
	/*
    |--------------------------------------------------------------------------
    | SEGUIMIENTO
    |--------------------------------------------------------------------------
    */	
	public function getSegmetas(Request $r){
		$data = $this->model->getSeguimientoMetas($r->idy, \Auth::user()->idinstituciones, $r->type);
		return response()->json($data);
	}
	public function getSegmetasexportar(Request $r){
		return $this->exportar->getExportarSegMetas($this->model->getSeguimientoMetas($r->idy, \Auth::user()->idinstituciones, $r->type));
	}
	/*
    |--------------------------------------------------------------------------
    | CALENDARIZAR
    |--------------------------------------------------------------------------
    */
	public function getCalmetas(Request $r){
		$data = $this->model->getCalendarizarMetas($r->idy, \Auth::user()->idinstituciones, $r->type);
		return response()->json($data);
	}
	public function getCalmetasexportar(Request $r){
		return $this->exportar->getExportarCalMetas($this->model->getCalendarizarMetas($r->idy, \Auth::user()->idinstituciones, $r->type));
	}
	/*
    |--------------------------------------------------------------------------
    | PbRM-08c
    |--------------------------------------------------------------------------
    */
	public function getProjectsochoc(Request $r){
		$data = $this->metasService->getRowsProjectsOchoc($r->idy, $r->type,$r->year,$r->ida);
		return response()->json($data);
	}	
	public function getProjectsochoctxt(Request $r){
		$data = $this->metasService->getRowsProjectsOchocTxt($r->idy,$r->trim);
		return response()->json($data);
	}
	public function getGeneratetxtochoc(Request $r){
		$rows = $this->metasService->getRowsProjectsOchocTxt($r->idy,$r->trim);
		$nombre_archivo = rand(5,99999).time();
		$archivo = public_path('storage/101/txt/'.$nombre_archivo.'.txt');
		//Crea el archivo vacio
		touch($archivo);
		$manejador;
		$manejador = fopen($archivo, 'w+');
		$linea="";
		foreach ($rows['rowsData'] as $v) {
			$linea = '"'.$v['lb'].'"|'.'"'.$v['pb'].'"|'.'"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['no1'].'"|'.'"'.$v['no2'].'"|'.'"'.$v['no3'].'"|'.'"'.$v['no4'].'"|'.'"'.$v['no5'].'"|'.'"'.$v['no6'].'"|'.'"'.$v['ac'].'"|'.'"'.$v['me'].'"|'.'"'.$v['um'].'"|'.'"'.$v['pa'].'"|'.'"'.$v['vp'].'"|'.'"'.$v['va'].'"|'.'"'.$v['vv'].'"|'.'"'.$v['vvp'].'"|'.'"'.$v['aa'].'"|'.'"'.$v['av'].'"|'.'"'.$v['avp'].'"|';
			$nueva_cadena = substr($linea, 0, -1);
			fwrite($manejador, $nueva_cadena . PHP_EOL);
		}		
		fclose($manejador);
		return response()->download($archivo, $r->name.'.txt');
	}		
	private function getLimpiarCadenaTXT($text){
		$cadena = (!empty($text) ? trim(str_replace(["'","|", '"', "\n", "\r", "\r\n"], "", $text)) : $text);
		return $cadena;
	}
}