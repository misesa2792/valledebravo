<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Services\Pdm\AlineacionService;

use App\Models\Alineacion;
use App\Models\Anios;
use App\Models\Reporte;
use App\Models\Exportar;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,SiteHelpers,Auth ; 
use Carbon\Carbon;

class AlineacionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	

	protected $model;	

	public $module = 'alineacion';
	static $per_page	= '10';

	protected $alineacionservice;	

	public function __construct(AlineacionService $alineacionservice)
	{
		$this->alineacionservice = $alineacionservice;
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Alineacion();
		$this->reporte = new Reporte();
		$this->anios = new Anios();
		$this->exportar = new Exportar();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'alineacion',
			'return'	=> self::returnUrl()
		);
	}
	public function getIndex( Request $request )
	{
		return $this->alineacionservice->index($request);
	}
	public function getOld( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		//$this->data['rows_pilares'] = json_encode($this->getRowsPeriodo());	
		$this->data['access'] = $this->access;
		//$this->data['i'] = 1;
		//$this->data['id'] = isset($request->id) ? $request->id : 0;

		//ID de la institución que tiene asignada el usuario
		$idi = \Auth::user()->idinstituciones;
		//Verificó que la key este presente en el return
		if(isset($request->k)){
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($request->k);
			if($decoder){
				$idi = $decoder['idi'];//ID Institución
			}else{
				return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
			}
		}
		//ID de la institución que tiene asignada el usuario
		$this->data['idi'] = $idi;
		//User
		$gp = \Auth::user()->group_id;
		//El nivel administrador tiene permitido ver todas las instituciones
		if($gp == 1 || $gp == 2 || $gp == 7){
			$this->data['rowsInstituciones'] = $this->model->getCatInstituciones();
		}else{
			$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($idi);
		}
		//Encripto el ID de la Institución(Ayuntamiento,DIF,IMCUFIDE,etc.)
		$this->data['k'] = SiteHelpers::CF_encode_json(array("idi" => $idi));
		//view
		return view('alineacion.index',$this->data);
	}	
	public function getEjes( Request $request )
	{
		return $this->alineacionservice->ejes($request);
	}
	public function getMetas( Request $request )
	{
		return $this->alineacionservice->metas($request);
	}
	public function getLoadpdm( Request $request )
	{
		return $this->alineacionservice->loadpdm($request);
	}
	public function getAlinearmetas( Request $request )
	{
		return $this->alineacionservice->alinearmetas($request);
	}
	public function postSearchmetas( Request $request )
	{
		return $this->alineacionservice->searchMetas($request);
	}
	public function postSavealineacion( Request $request )
	{
		return $this->alineacionservice->saveAlineacion($request);
	}
	public function deleteMetapbrm( Request $request )
	{
		return $this->alineacionservice->destroyMeta($request);
	}











	public function getPrincipal( Request $request )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($request->k);
		//Aquí creó este IF para validar que exista número de institución
		if($decoder['idi'] != null){
			//ID de la institución que tiene asignada el usuario
			$this->data['idi'] = $decoder['idi'];
			//Muestro los periodos
			$this->data['rows_pilares'] = json_encode($this->getRowsPeriodo());	
			return view('alineacion.principal',$this->data);
		}
	}
	public function getPdm( Request $request)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			//Institución
			$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
			//Variables
			$this->data['k'] 			= $request->k;
			$this->data['anio'] 		= $decoder['anio'];
			$this->data['idanio'] 		= $decoder['idanio'];
			$this->data['idpilar'] 		= $decoder['idpilar'];
			$this->data['idperiodo'] 	= $decoder['idperiodo'];
			$this->data['idi'] 			= $decoder['idi'];//idinstitucion
			$this->data['idg'] 			= \Auth::user()->group_id;
			$this->data['idu'] 			= \Auth::user()->id;
			//View
			return view('alineacion.pdm',$this->data);
		}else{
			return Redirect::to('alineacion')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}
	}
	protected function getRowsPeriodo(){
		$data = array();
		foreach ($this->model->getCatPeriodos() as $v) {
			$data[] = array("idperiodo"=>$v->idperiodo,
							"periodo"=>$v->descripcion,
							"rows_pilares"=>$this->model->getPilaresPeriodo($v->idperiodo),
							"rows_anios"=>$this->model->getCatPeriodoAnios($v->idperiodo));
		}
		return $data;
	}
	
	public function getPdmpilar( Request $request)
	{
		return $this->getPilares($request->idperiodo,$request->idpilar,$request->idanio,$request->idi);
	}	
	protected function getPilares($idperiodo,$idpilar,$idanio,$user_idi){

		//ID de la institución que tiene asignada el usuario
		$user_idg = \Auth::user()->group_id;
		$idu = \Auth::user()->id;

		$data = array();
		foreach ($this->model->getPilares($idperiodo,$idpilar) as $p) {
			$temas = array();
			foreach ($this->model->getPilaresTemasOld($p->idpdm_pilares) as $t) {
				$subtemas = array();
				foreach ($this->model->getPilaresSubTemas($t->id) as $s) {
					$obj = array();
					foreach ($this->model->getPilaresSubTemasObj($s->id) as $o) {
						$est = array();
						foreach ($this->model->getPilaresTemasObjEst($o->id) as $e) {
							$linea = array();
							foreach ($this->model->getPilaresTemasObjEstLinAccion($e->id) as $l) {
								$rows_metas = array();

								if($user_idg == 1 || $user_idg == 2 || $user_idg == 7 || $user_idg == 5){
									$rows_metas_alineacion = $this->model->getMetaAlineacion($l->id,$idanio);
									$rows_act_relevantes = $this->model->getActividadesRelevantes($l->id,$idanio);
								}else if($user_idg == 3 || $user_idg == 4){
									$access = $this->model->getPermisoAreaCoordinacion($idu,$user_idi);
									$rows_metas_alineacion = $this->model->getMetaAlineacionInstitucionEnlaces($l->id,$idanio,$access[0]->permiso);
									$rows_act_relevantes = $this->model->getActividadesRelevantesEnlace($l->id,$idanio,$user_idi,$idu);
								}else{
									$rows_metas_alineacion = $this->model->getMetaAlineacionInstitucion($l->id,$idanio,$user_idi);
									$rows_act_relevantes = $this->model->getActividadesRelevantesEnlace($l->id,$idanio,$user_idi,$idu);
								}

								foreach ($rows_metas_alineacion as $cc) {
									$rows_metas[] = array("id"=>$cc->id,
													"no_proyecto"=>$cc->no_proyecto,
													"proyecto"=>$cc->proyecto,
													"meta"=>$cc->meta,
													"no_coordinacion"=>$cc->no_coordinacion,
													"coordinacion"=>$cc->coordinacion,
													"no_area"=>$cc->no_area,
													"area"=>$cc->area,
													"institucion"=>$cc->institucion,
													"logo"=>$cc->logo,
													"comentarios"=>$cc->comentarios,
													"usuario"=>$cc->usuario,
													"fecha_rg"=>$cc->fecha_rg,
													"hora_rg"=>$cc->hora_rg,
													"iduser_rg"=>$cc->iduser_rg,
												);
								}
								$linea[] = array("id"=>$l->id,"clave"=>$l->clave,"linea"=>$l->linea,
												"rows_metas"=>$rows_metas,
												"rows_ar"=>$rows_act_relevantes,
											);
							}
							$est[] = array("id"=>$e->id,"clave"=>$e->clave,"estrategia"=>$e->estrategia,"rows_linea"=>$linea);
						}
						$obj[] = array("id"=>$o->id,"clave"=>$o->clave,"objetivo"=>$o->objetivo,"rows_est"=>$est);
					}
					$subtemas[] = array("id"=>$s->id,"subtema"=>$s->subtema,"rows_obj"=>$obj);
				}
				$temas[] = array("id"=>$t->id,"tema"=>$t->tema,"rows_subtemas"=>$subtemas);
			}
			$data[] = array("id"=>$p->idpdm_pilares,"tipo"=>$p->tipo,"pilares"=>$p->pilares,"color"=>$p->color,"rows_temas"=>$temas);
		}
		return json_encode($data);
	}
	public function getAlinear( Request $request )
	{
		$this->data['idlinea_accion'] = $request->idlinea_accion;
		$this->data['idanio'] = $request->idanio;
		$row = $this->anios->find($request->idanio,['anio']);
		$this->data['anio'] = $row->anio;
		$this->data['rows_projects'] = $this->reporte->getProjects();
		$linea = $this->model->getLineaAccion($request->idlinea_accion);
		$this->data['linea'] = $linea[0];
		return view('alineacion.alinear',$this->data);
	}
	public function getComentarios( Request $r )
	{
		$linea = $this->model->getLineaAccion($r->idlinea_accion);
		$this->data['linea'] = $linea[0];
		$this->data['idanio'] = $r->idanio;
		$this->data['idlinea_accion'] = $r->idlinea_accion;
		$rows = $this->model->getMetaAlineacionIndividual($r->id);
		$this->data['rows_metas'] = $rows[0];
		$this->data['delegaciones'] = $this->model->getDelegaciones($r->id); 
		$this->data['conectores'] = $this->model->getConectores(); 
		$this->data['id'] = $r->id;//idpdm_alineacion
		return view('alineacion.comentarios',$this->data);
	}
	public function getActividadesrelevantes( Request $r )
	{
		$linea = $this->model->getLineaAccion($r->idlinea_accion);
		$this->data['linea'] = $linea[0];
		$this->data['idanio'] = $r->idanio;
		$this->data['idlinea_accion'] = $r->idlinea_accion;
		$this->data['idi'] = $r->idi;//idinstitucion
		$this->data['delegaciones'] = $this->model->getDelegacionesAll(); 
		$this->data['conectores'] = $this->model->getConectores(); 
		return view('alineacion.actividadesrelevantes',$this->data);
	}
	public function getActividadesrelevanteseditar( Request $r )
	{
		$linea = $this->model->getLineaAccion($r->idlinea_accion);
		$this->data['linea'] = $linea[0];
		$this->data['idanio'] = $r->idanio;
		$this->data['idlinea_accion'] = $r->idlinea_accion;
		$this->data['idar'] = $r->idar;
		$this->data['delegaciones'] = $this->model->getDelegacionesActRelevantes($r->idar); 
		$this->data['conectores'] = $this->model->getConectores(); 
		$rows = $this->model->getMetaAlineacionActRelevantes($r->idar);
		$this->data['rows_metas'] = $rows[0];
		return view('alineacion.actividadesrelevanteseditar',$this->data);
	}
	public function postActividadesrelevantes( Request $r )
	{
		$data = array("comentarios"=>$r->comentarios,
					"paso1"=>$r->paso1,
					"paso2"=>$r->paso2,
					"paso3"=>$r->paso3,
					"paso4"=>$r->paso4,
					"paso6"=>$r->paso6,
					"c1"=>$r->slt_paso1,
					"c2"=>$r->slt_paso2,
					"c3"=>$r->slt_paso3,
					"c4"=>$r->slt_paso4,
					"c6"=>$r->slt_paso6,
					"idpdm_pilares_lineas_accion"=>$r->idlinea_accion,
					"idanio"=>$r->idanio,
					"idinstituciones"=>$r->idi,
					"fecha_rg"=> date('Y-m-d'),
					"hora_rg"=> Carbon::now()->format('H:i:s A'),
					"iduser_rg"=> Auth::user()->id,
				);
		$idar = $this->model->getInsertTable($data,"ui_pdm_alineacion_ar");	

		if(isset($r->iddelegacion)){
			//Agregó las nuevas delegeaciones
			for ($i=0; $i < count($r->iddelegacion); $i++) { 
				if($r->iddelegacion[$i] != ""){
					//Tipo 1 es para registros con alineación
					//Tipo 2 es para actividades relevantes
					$arr = array("idpdm_alineacion_ar"=>$idar, "iddelegacion"=>$r->iddelegacion[$i]);
					$this->model->getInsertTable($arr,"ui_pdm_alineacion_del_ar");	
				}
			}
		}
		
		try {
			//Inserto los arhivos
			if(isset($r->evidencia)){
				$anio = $this->anios->find($r->idanio);
				$ruta = "archivos/alineacion/ar/{$anio->anio}/{$idar}/";
				$url = "./".$ruta;
				for ($i=0; $i <count($r->evidencia) ; $i++) {
					$file = $r->evidencia[$i];
					if(!empty($file)){
						$filename = $this->getInsertImgMss($file, $url);

						//calculó el tamaño del archivo 
						$full_dir = public_path($ruta.$filename['newfilename']);
						$size = $this->getSizeFiles($full_dir);

						$data_img = array("idpdm_alineacion_ar"=>$idar,
										"url"=>$url.$filename['newfilename'],
										"nombre"=>$filename['filename'],
										"ext"=>$filename['ext'],
										"bytes"=>$size['bytes'],
										"size"=>$size['size'],
									);
						$this->model->getInsertTable($data_img, "ui_pdm_alineacion_img_ar");
					}
				}
			}
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error al insertar IMG, '.$e->getMessage());
		}

		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function postActividadesrelevanteseditar( Request $r )
	{
		$data = array("comentarios"=>$r->comentarios,
					"paso1"=>$r->paso1,
					"paso2"=>$r->paso2,
					"paso3"=>$r->paso3,
					"paso4"=>$r->paso4,
					"paso6"=>$r->paso6,
					"c1"=>$r->slt_paso1,
					"c2"=>$r->slt_paso2,
					"c3"=>$r->slt_paso3,
					"c4"=>$r->slt_paso4,
					"c6"=>$r->slt_paso6,
				);
		$this->model->getUpdateTable($data,"ui_pdm_alineacion_ar","idpdm_alineacion_ar",$r->idar);	

		//Elimino primero las delegaciones
		foreach ($this->model->getAlineacionesDelegacionesActRel($r->idar) as $v) {
			$this->model->getDestroytable("ui_pdm_alineacion_del_ar","idpdm_alineacion_del_ar",$v->idpdm_alineacion_del_ar);
		}

		if(isset($r->iddelegacion)){
			//Agregó las nuevas delegeaciones
			for ($i=0; $i < count($r->iddelegacion); $i++) { 
				if($r->iddelegacion[$i] != ""){
					//Tipo 1 es para registros con alineación
					//Tipo 2 es para actividades relevantes
					$arr = array("idpdm_alineacion_ar"=>$r->idar, "iddelegacion"=>$r->iddelegacion[$i]);
					$this->model->getInsertTable($arr,"ui_pdm_alineacion_del_ar");	
				}
			}
		}
		
		try {
			//Inserto los arhivos
			if(isset($r->evidencia)){
				$anio = $this->anios->find($r->idanio);
				$ruta = "archivos/alineacion/ar/{$anio->anio}/{$r->idar}/";
				$url = "./".$ruta;
				for ($i=0; $i <count($r->evidencia) ; $i++) {
					$file = $r->evidencia[$i];
					if(!empty($file)){
						$filename = $this->getInsertImgMss($file, $url);

						//calculó el tamaño del archivo 
						$full_dir = public_path($ruta.$filename['newfilename']);
						$size = $this->getSizeFiles($full_dir);

						$data_img = array("idpdm_alineacion_ar"=>$r->idar,
										"url"=>$url.$filename['newfilename'],
										"nombre"=>$filename['filename'],
										"ext"=>$filename['ext'],
										"bytes"=>$size['bytes'],
										"size"=>$size['size'],
									);
						$this->model->getInsertTable($data_img, "ui_pdm_alineacion_img_ar");
					}
				}
			}
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error al insertar IMG, '.$e->getMessage());
		}

		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getComentariosimg( Request $r )
	{
		$data=array();
		foreach ($this->model->getComentariosImgs($r->id) as $v) {
			$data[]=array(
				"id" => $v->idpdm_alineacion_img, 
				"name" => $v->nombre, 
				"url" => asset($v->url), 
				"ico" => asset($this->getTypeImg($v->url,$v->ext)), 
			);	
		}
		return json_encode($data);
	}
	public function getComentariosimgar( Request $r )
	{
		$data=array();
		foreach ($this->model->getComentariosImgsActRel($r->idar) as $v) {
			$data[]=array(
				"id" => $v->idpdm_alineacion_img_ar, 
				"name" => $v->nombre, 
				"url" => asset($v->url), 
				"ico" => asset($this->getTypeImg($v->url,$v->ext)), 
			);	
		}
		return json_encode($data);
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
	
	public function getDestroyfilealineacion( Request $r)
	{
		try {
			foreach ($this->model->getComentariosImagen($r->idai) as $v) {
				$ruta = public_path($v->url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_pdm_alineacion_img','idpdm_alineacion_img',$v->idpdm_alineacion_img);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar file, '.$e->getMessage());
		}
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	public function getDestroyfilealineacionar( Request $r)
	{
		try {
			foreach ($this->model->getComentariosImagenar($r->idai) as $v) {
				$ruta = public_path($v->url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_pdm_alineacion_img_ar','idpdm_alineacion_img_ar',$v->idpdm_alineacion_img_ar);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar file, '.$e->getMessage());
		}
		$result = array("success"=>"ok");
		return json_encode($result);
	}
	public function postComentarios( Request $r )
	{
		$data = array("comentarios"=>$r->comentarios,
					"paso1"=>$r->paso1,
					"paso2"=>$r->paso2,
					"paso3"=>$r->paso3,
					"paso4"=>$r->paso4,
					"paso6"=>$r->paso6,
					"c1"=>$r->slt_paso1,
					"c2"=>$r->slt_paso2,
					"c3"=>$r->slt_paso3,
					"c4"=>$r->slt_paso4,
					"c6"=>$r->slt_paso6,
					"fecha_rg"=> date('Y-m-d'),
					"hora_rg"=> Carbon::now()->format('H:i:s A'),
					"iduser_rg"=> Auth::user()->id,
				);
		$this->model->getUpdateTable($data,"ui_pdm_alineacion","idpdm_alineacion",$r->id);	

		//Elimino primero las delegaciones
		foreach ($this->model->getAlineacionesDelegaciones($r->id) as $v) {
			$this->model->getDestroytable("ui_pdm_alineacion_del","idpdm_alineacion_del",$v->id);
		}
		if(isset($r->iddelegacion)){
			//Agregó las nuevas delegeaciones
			for ($i=0; $i < count($r->iddelegacion); $i++) { 
				if($r->iddelegacion[$i] != ""){
					//Tipo 1 es para registros con alineación
					//Tipo 2 es para actividades relevantes
					$arr = array("idpdm_alineacion"=>$r->id, "iddelegacion"=>$r->iddelegacion[$i]);
					$this->model->getInsertTable($arr,"ui_pdm_alineacion_del");	
				}
			}
		}
		
		try {
			//Inserto los arhivos
			if(isset($r->evidencia)){
				$anio = $this->anios->find($r->idanio);
				$ruta = "archivos/alineacion/{$anio->anio}/{$r->id}/";
				$url = "./".$ruta;
				for ($i=0; $i <count($r->evidencia) ; $i++) {
					$file = $r->evidencia[$i];
					if(!empty($file)){
						$filename = $this->getInsertImgMss($file, $url);

						//calculó el tamaño del archivo 
						$full_dir = public_path($ruta.$filename['newfilename']);
						$size = $this->getSizeFiles($full_dir);

						$data_img = array("idpdm_alineacion"=>$r->id,
										"url"=>$url.$filename['newfilename'],
										"nombre"=>$filename['filename'],
										"ext"=>$filename['ext'],
										"bytes"=>$size['bytes'],
										"size"=>$size['size'],
									);
						$this->model->getInsertTable($data_img, "ui_pdm_alineacion_img");
					}
				}
			}
		} catch (\Exception $e) {
			$success = "no";
			\SiteHelpers::auditTrail( $r , 'Error al insertar IMG, '.$e->getMessage());
		}

		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getLoadmeta( Request $r )
	{
		$data = array();
		foreach ($this->model->getMetasProyectos($r->idp,$r->idanio) as $key => $v) {
			$data[]=array("id"=>$v->id,
						"meta"=>$v->meta,
						"unidad_medida"=>$v->unidad_medida,
						"coordinacion"=>$v->coordinacion,
						"area"=>$v->area,
						"institucion"=>$v->institucion,
						"logo"=>$v->logo,
						"rows"=>$this->model->getMetaAlineacionReg($v->id,$r->idanio),
						);
		}
		$this->data['rows_metas'] = json_encode($data);
		return view('alineacion.metas',$this->data);
	}
	/*public function postDestroycomentario( Request $r )
	{
		$this->model->getDestroytable("ui_pdm_alineacion_comentarios","idpdm_alineacion_comentarios",$r->params['idcomm']);
		foreach ($this->model->getDelegacionesComentarios($r->params['idcomm']) as $key => $cc) {
			$this->model->getDestroyTable("ui_pdm_alineacion_comentarios_del","idpdm_alineacion_comentarios_del",$cc->id);
		}
		$response = array("success"=>"ok");
		return json_encode($response);
	}	*/
	public function postDestroyactrel( Request $r )
	{
		$this->model->getDestroytable("ui_pdm_alineacion_ar","idpdm_alineacion_ar",$r->params['idar']);
		//Elimino la parte de las delegaciones
		foreach ($this->model->getAlineacionesDelegacionesActRel($r->params['idar']) as $v) {
			$this->model->getDestroytable("ui_pdm_alineacion_del_ar","idpdm_alineacion_del_ar",$v->idpdm_alineacion_del_ar);
		}
		//Elimino las fotos
		try {
			foreach ($this->model->getComentariosImgsActRel($r->params['idar']) as $v) {
				$ruta = public_path($v->url);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
				$this->model->getDestroyTable('ui_pdm_alineacion_img_ar','idpdm_alineacion_img_ar',$v->idpdm_alineacion_img_ar);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar la IMGs, '.$e->getMessage());
		}
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroyalineacion( Request $r )
	{
		$this->model->getDestroytable("ui_pdm_alineacion","idpdm_alineacion",$r->params['id']);
		//Elimino la parte de las delegaciones
		foreach ($this->model->getAlineacionesDelegaciones($r->params['id']) as $v) {
			$this->model->getDestroytable("ui_pdm_alineacion_del","idpdm_alineacion_del",$v->id);
		}
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postSavealinear( Request $r )
	{
		if(isset($r->idreg)){
			if(count($r->idreg) > 0){
				for ($i=0; $i < count($r->idreg); $i++) { 
					$this->getInsertProyectoMetasLineaAcción($r->idanio,$r->idp,$r->id,$r->idreg[$i]);
				}
			}else{
				$this->getInsertProyectoLineaAcción($r->idanio,$r->idp,$r->id,0);
			}
		}else{
			$this->getInsertProyectoLineaAcción($r->idanio,$r->idp,$r->id,0);
		}
			
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function getExportar( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$user_idg = \Auth::user()->group_id;
			$idu = \Auth::user()->id;

			if($user_idg == 1 || $user_idg == 2 || $user_idg == 7 || $user_idg == 5){
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'admin');
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'admin');
			}else if($user_idg == 3 || $user_idg == 4){
				$access = $this->model->getPermisoAreaCoordinacion($idu,$decoder['idi']);
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'enlace',$access[0]->permiso);
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'enlace',$idu);
			}else{
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'supervisor');
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'supervisor',$idu);
			}

			return $this->exportar->getExportarLineaAccion($metas, $act_rel);
		}else{
			return Redirect::to('alineacion')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$user_idg = \Auth::user()->group_id;
			$idu = \Auth::user()->id;

			if($user_idg == 1 || $user_idg == 2){
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'admin');
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'admin');
			}else if($user_idg == 3 || $user_idg == 4){
				$access = $this->model->getPermisoAreaCoordinacion($idu,$decoder['idi']);
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'enlace',$access[0]->permiso);
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'enlace',$idu);
			}else{
				$metas = $this->model->getExportarAlineacionMetas($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'supervisor');
				$act_rel = $this->model->getExportarAlineacionActrelevantes($decoder['idperiodo'], $decoder['idanio'],  $decoder['idi'],'supervisor',$idu);
			}

			$mpdf = new \Mpdf\Mpdf([
				'margin_top' => 2,
				'margin_left' => 5,
				'margin_right' => 5,
				'margin_bottom' => 5,
			]);
			$this->data['rows_metas'] = json_encode($metas);
			$mpdf->WriteHTML(view("alineacion.pdf.index",$this->data));
			return $mpdf->Output("PDM", \Mpdf\Output\Destination::INLINE);

		}else{
			return Redirect::to('alineacion')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}
	}


	protected function getInsertProyectoLineaAcción($idanio,$idp,$idla){
		$row = $this->model->getTotalProyectos($idp,$idla);
		if($row[0]->total == 0){
			$data = array("idanio"=>$idanio,"idpdm_pilares_lineas_accion"=>$idla,"idproyecto"=>$idp,"idreporte_reg"=>0);
			$this->model->getInsertTable($data,"ui_pdm_alineacion");
		}
	}
	protected function getInsertProyectoMetasLineaAcción($idanio,$idp,$idla,$idrr){
		$row = $this->model->getTotalMetas($idrr,$idla);
		if($row[0]->total == 0){
			$data = array("idanio"=>$idanio,"idpdm_pilares_lineas_accion"=>$idla,"idproyecto"=>$idp,"idreporte_reg"=>$idrr);
			$this->model->getInsertTable($data,"ui_pdm_alineacion");
		}
	}

}