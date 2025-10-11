<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Reporte;
use App\Models\Indicadores;
use App\Models\Graficas;
use App\Models\Access\Years;

use App\Services\MetasService;
use App\Services\GeneralService;

use SiteHelpers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndicadoresController extends Controller {

	protected $data;	
	protected $model;	
	protected $info;	
	protected $reporte;	
	protected $graficas;	
	protected $access;	

	protected $metasService;
	protected $generalService;

	public $module = 'indicadores';
	static $per_page	= '10';
    const MODULE = 5;

	public function __construct(MetasService $metasService, GeneralService $generalService)
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Indicadores();
		$this->reporte = new Reporte();
		$this->graficas = new Graficas();
		$this->metasService = $metasService;
		$this->generalService = $generalService;

		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'indicadores',
			'return'	=> self::returnUrl()
		);
	}

	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0){
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE,$idi);
		return view('indicadores.index',$this->data);
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
		$type = 1;
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
		if($request->idy > 2){
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
		$this->data['rowsMenu'] = $this->generalService->getAccessDepGenForUsersView($decoder);
		$row = $this->model->getInformationDepAuxID($decoder['idac']);
		//Validamos si tenemos informacion
		if(count($row) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['token'] = $r->k;
		$this->data['type'] = $decoder['type'];
		$this->data['idac'] = $decoder['idac'];
		$this->data['row'] = $row[0];
		return view('indicadores.proyectos.index',$this->data);	
	}
	public function getProyectos( Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$this->data['idac'] = $decoder['idac'];//ui_area_coordinacion
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$this->data['type'] = $r->type;
		$this->data['idy']  = $r->idy;
		$this->data['year'] = $r->year;
		$this->data['k'] = $r->k;
		$row = $this->reporte->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		return view('indicadores.old.anio',$this->data);	
	}
	public function getSearch( Request $r )
	{
		try {
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($r->k);
			//Declaraciones de variables
			$data = array();
			$month_current = date("n");
			$idac = $decoder['idac'];
			$type = $r->type;//0 - Metas , 1 - Indicadores
			$anio = $r->year;
			$idanio = $r->idy;
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
			//foreach ($this->model->getCatAnios() as $a) {
				$projects = array();

				$total_1 = $total_2 = $total_3 = $total_4 = 0;
				foreach ($this->reporte->getReporte($idac, $idanio, $type) as $p) {
					$t1 = $t2 = $t3 = $t4 = array("total"=>0,"url"=>'','url_j'=>'','url_f'=>'');
						
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
						/*$t1 = $this->getReconduccionPDF($p->idreporte,1,$a->idanio);
						$t2 = $this->getReconduccionPDF($p->idreporte,2,$a->idanio);
						$t3 = $this->getReconduccionPDF($p->idreporte,3,$a->idanio);
						$t4 = $this->getReconduccionPDF($p->idreporte,4,$a->idanio);*/
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
				//$count_projs = count($projects);
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
					/*$d1 = $this->getOficioPDFDictamen($idac,1,$total_1,$a->idanio);
					$d2 = $this->getOficioPDFDictamen($idac,2,$total_2,$a->idanio);
					$d3 = $this->getOficioPDFDictamen($idac,3,$total_3,$a->idanio);
					$d4 = $this->getOficioPDFDictamen($idac,4,$total_4,$a->idanio);*/
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
			//}
			$this->data['j'] = 1;
			//array
			$this->data['rows'] = $data;
			//Informacion de la dependencia general, auxiliar e institución
			$row=$this->reporte->getAreaCoordinacion($idac);
			$this->data['row'] = $row[0];
			//Vista
			return view('indicadores.old.search',$this->data);
		} catch (\Exception $e) {
			//return $e->getMessage();
		}
	}	
	private function getOficioPDFDictamen($idac,$trim,$total,$idanio){
		$dic = $this->reporte->getPdfReporte($idac,$trim,6,$idanio);
		$total = ($total > 0 ? 1 : 2);
		return array("total"=>$total,"url"=> count($dic) > 0 ? $dic[0]->url : "");
	}
	private function getReconduccionPDF($idr,$trim,$idanio){
		$rec = $this->reporte->getPdfReporte($idr,$trim,4,$idanio);//Type = 1; Reconducción
		$just = $this->reporte->getPdfReporte($idr,$trim,5,$idanio);//Type = 2; Justificacion
		$foda = $this->reporte->getPdfFoda($idr,$trim,$idanio);
		return array('total'=>1, 
					'url'=> count($rec) > 0 ? $rec[0]->url : '', 
					'url_j'=> count($just) > 0 ? $just[0]->url : '',
					'url_f'=> count($foda) > 0 ? $foda[0]->url : '',
				);
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
		$proy = $this->reporte->getRowReporte($decoder['idr']);
		$this->data['proy'] = $proy[0];
		//Informacion de la dependencia general, auxiliar e institución
		$row = $this->reporte->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		return view('indicadores.old.registrar',$this->data);	
	}

	/*
	 * 
	 * 
	 * NUEVO MÓDULO
	 * 
	 * 
	 */
	public function getReconducciones( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 8;
		$this->data['activeName'] 	= 'Reconducciones Indicadores';
        $idi = \Auth::user()->idinstituciones;
		$this->data['rowsDepGen'] 	= $this->model->getCatDepGeneralNew($idi, $r->idy);
		return view('indicadores.proyectos.reconducciones.index',$this->data);	
	}
	public function getSearchreconducciones( Request $r){
		return $this->metasService->viewIndicadoresFull($r->all());
	}
	public function getPermisos( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 2;
		$this->data['activeName'] 	= 'Permisos Indicadores';
		return view('reporte.proyectos.permisos.index',$this->data);	
	}
	public function getOchob( Request $r){
		$idy = $r->idy;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
        $idi =  Auth::user()->idinstituciones;
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $idy;
		$this->data['active'] 		= 7;
		$this->data['activeName'] 	= 'PbRM-08b';
		//Dep Gen
		$this->data['rowsIns']   	= $this->reporte->getDependenciasGenerales($idy,$idi);
		return view('indicadores.proyectos.ochob.index',$this->data);	
	}
	public function getFoda( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 6;
		$this->data['activeName'] 	= 'FODA';
		return view('indicadores.foda.registrar.index',$this->data);	
	}
	public function getSeguimiento( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 3;
		$this->data['activeName'] 	= 'Seguimiento por indicador';
		$this->data['trim'] 		= $this->getSelectMesActual($modulo[0]->anio);
		return view('reporte.proyectos.seguimiento.seguimiento',$this->data);	
		return view('reporte.proyectos.seguimiento.index',$this->data);	
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
	public function getCalendarizar( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 4;
		$this->data['activeName'] 	= 'Calendarización de indicadores';
		return view('reporte.proyectos.calendarizar.index',$this->data);	
	}
	public function getIndicadoresproyecto( Request $r){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['type'] 		= 1;// 0 - Metas y 1 Indicadores 
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $r->idy;
		$this->data['active'] 		= 9;
		$this->data['activeName'] 	= 'Indicadores proyectos';
		return view('reporte.proyectos.indicadores.index',$this->data);	
	}
	public function getGraficas( Request $r){
		$idy = $r->idy;
		$idi = Auth::user()->idinstituciones;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, $idi, $r->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$type = 1;// 0 - Metas y 1 Indicadores 
		$this->data['type'] 		= $type;
		$this->data['year'] 		= $modulo[0]->anio;
		$this->data['idy']  		= $idy;
		$total = $this->reporte->getGraficasTotalMetas($idy,$idi,$type);
		$this->data['total'] = $total[0]->total;
		$info = $this->reporte->getGraficasTotalMetasPorcentaje($idy,$idi,$type,$total[0]->total);
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
		$this->data['activeName'] = 'Gráficas de indicadores';
		return view('reporte.proyectos.graficas.index',$this->data);	
	}
	public function getPbrmb( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$this->data['type'] = $decoder['type'];
		$this->data['idy']  = $decoder['idy'];
		$this->data['year'] = $decoder['year'];
		//key donde contiene el array de informacion
		$this->data['token'] = $r->k;
		//Informacion de la dependencia general, auxiliar e institución
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		return view('indicadores.proyectos.pbrmb',$this->data);	
	}
	public function getListprojects( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$data = $this->metasService->viewIndicadores($decoder);
		return response()->json($data);
	}
	public function getFormatos( Request $r)
	{
		//Formato ochob
		if($r->type == 6){
			$this->data['json'] = $this->metasService->viewFormatoOchobEvaluacion($r->all());
			$this->data['id'] = $r->id;
			if($this->data['json']['status'] == 1){
				return view($this->module.'.proyectos.ochob.vista',$this->data);	
			}
			return view($this->module.'.proyectos.ochob.view',$this->data);	
		}
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			if($r->type == 1){//Formato de Reconducción
				$this->data['json'] = $this->metasService->viewFormatoReconduccionIndicador($decoder, $r->all());
				return view($this->module.'.proyectos.formatos.reconduccion.view',$this->data);	
			}else if($r->type == 2){//Formato tarjeta de justificación
				$this->data['json'] = $this->metasService->viewFormatoJustificacion($decoder, $r->all());
				return view('reporte.proyectos.formatos.justificacion.view',$this->data);	
			}else if($r->type == 3){//Formato Dictamen
				$this->data['json'] = $this->metasService->viewFormatoDictamen($decoder, $r->all());
				return view('reporte.proyectos.formatos.dictamen.view',$this->data);	
			}else if($r->type == 4){//Formato Dictamen
				//$this->data['json'] = $this->metasService->viewFormatoOchob($decoder,$r->all());
				//return view($this->module.'.proyectos.formatos.ochob.view',$this->data);	
			}else if($r->type == 5){//Formato FODA
				$this->data['json'] = $this->metasService->viewInfoFODA($decoder,$r->all());
				return view($this->module.'.proyectos.formatos.foda.view',$this->data);	
			}
		}
	}
	public function postRevertirochob( Request $r ){
		try{
			DB::transaction(function () use ($r) {
				$data = ['status' 		=> 0,
						'desc_meta' 	=> null,
						'desc_res' 		=> null,
						'evaluacion' 	=> null,
						'meta_anual' 	=> 0.00,
						'programado' 	=> 0.00,
						'alcanzado' 	=> 0.00,
						'ef' 			=> 0.00,
						'idmir_semaforo' => 0,
						'a_programado' 	=> 0.00,
						'a_alcanzado' 	=> 0.00,
						'a_ef' 			=> 0.00
					];
				$this->model->getUpdateTable($data, "ui_reporte_mir_eva", "idreporte_mir_eva", $r->id);
			});
			$response = ["status"=>"ok", "message"=>"Evaluación revertida exitosamente."];
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , "Error al revertir evaluación: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al revertir evaluación!"];
		}
		return response()->json($response);
	}
	public function postPdfdictamen( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
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
				}else if(empty($r->titular_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa nombre del director del área"];
					return response()->json($response);
				}else if(empty($r->titular_dep_gen_cargo)){
					$response = ["status"=>"error","message"=>"Ingresa cargo del director del área"];
					return response()->json($response);
				}

				$json = json_decode($r->input('json'), true);

				$this->data['json'] = $json;

				$this->data['fecha'] = $r->fecha;
				$this->data['oficio'] = $r->oficio;
				$this->data['asunto'] = $r->asunto;
				$this->data['titular_dep_gen'] = $r->titular_dep_gen;
				$this->data['titular_dep_gen_cargo'] = $r->titular_dep_gen_cargo;

				$number = $this->getBuildFilenamePDF("IFD".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['header']['no_dep_gen'],$decoder['idac']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectory($json['header']['no_institucion'], $json['year'], 'indicador', 'dic');
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
				$dictamen = $this->reporte->getReporteDictamenPdf($decoder['idac'],$json['idanio'], $decoder['type']);
				$dic = "dic".$json['trimestre']['numero'];
				if(count($dictamen) == 0 ){
					$arr_dictamen = ['idarea_coordinacion' => $decoder['idac'], 
									'idanio' => $json['idanio'],
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
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	public function postEvaluacion( Request $r ){
		try {
			// Iniciar la transacción
			DB::transaction(function () use ($r) {
				$data = ['status' 		=> 1,
						'desc_meta' 	=> $r->desc_meta,
						'desc_res' 		=> $r->desc_res,
						'evaluacion' 	=> $r->evaluacion,
						'meta_anual' 	=> $r->meta_anual,
						'programado' 	=> $r->programado,
						'alcanzado' 	=> $r->alcanzado,
						'ef' 			=> $r->ef,
						'idmir_semaforo' => $r->idmir_semaforo,
						'a_programado' 	=> $r->a_programado,
						'a_alcanzado' 	=> $r->a_alcanzado,
						'a_ef' 			=> $r->ef
					];
				$this->model->getUpdateTable($data, "ui_reporte_mir_eva", "idreporte_mir_eva", $r->id);
			});
			// Si todo sale bien, retornar éxito
			$response = ["status"=>"ok", "message"=>"Información guardada exitosamente."];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error al guardar el indicador: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al editar el indicador!"];
		}
		return response()->json($response);
	}
	public function getGeneratepdfeightb( Request $r )
	{
		$info = $this->metasService->viewFormatoOchob($r->all());
		$this->data['title'] = $info['data'];
		$filename = time().".pdf";
		$result = $this->getBuildDirectoryGallery('101', '2025', 'indicador', 'ochob',$r->trim);
		$this->data['fecha'] = date('d/m/Y');
		$mpdf = new \Mpdf\Mpdf([
								'format' => 'A4-L',
								'margin_top' => 27,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 37,
								'mode' => 'c', // Modo de compatibilidad (más rápido)
								'default_font' => 'arial', // Fuente simple
								]);
		$indicadores = $info['info'];
		$totales = count($indicadores);
		$this->data['hf'] = $totales;
		$cont = 0;
		$url = $result['full_path'].$filename;
		$header = View::make($this->module.".proyectos.formatos.ochob.header", $this->data)->render();
		foreach ($indicadores as $v) {
			$cont++;
			$this->data['json'] = $v;
			$this->data['hi'] = $cont;
			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.ochob.footer", $this->data)->render());
			$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.ochob.body", $this->data)->render());
			if($cont < $totales){
				$mpdf->AddPage();
			}
		}
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		//$mpdf->Output($url, 'F');
		$mpdf->Output($url, 'I');
		unset($mpdf);
		dd("ok");
			try {

				$json = json_decode($r->input('json'), true);
				/*Se construye el nombre del PDF
					IFB[1,2,3,4] = Avance de Meta Formato Ochoc con Número del trimestre
				*/
				$number = $this->getBuildFilenamePDF("IFB".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], 'indicador', 'ochob',$json['trimestre']['numero']);
				$idsemaforo1 = $r->idsemaforo1;
				$this->data['json'] = $json;
				$this->data['txt_elaboro'] = $r->txt_elaboro;
				$this->data['txt_vo_bo'] = $r->txt_vo_bo;
				$this->data['txt_fecha'] = $r->txt_fecha;
				$this->data['desc_meta'] = $r->desc_meta;
				$this->data['justificacion'] = $r->justificacion;
				$this->data['evaluacion_ind'] = $r->evaluacion_ind;
				$this->data['semaforo1'] = $this->getSearchSemaforo($idsemaforo1);
				$this->data['semaforo2'] = $this->getSearchSemaforo($r->idsemaforo2);
				$this->data['aplica'] = $r->aplica;
				$this->data['ambito'] = $r->ambito;
				$this->data['cobertura'] = $r->cobertura;
				$this->data['text1'] = $r->text1;
				$this->data['text2'] = $r->text2;
				$this->data['text3'] = $r->text3;
				$this->data['text4'] = $r->text4;
				$this->data['text5'] = $r->text5;
				$this->data['text6'] = $r->text6;
				$this->data['text7'] = $r->text7;
				
			
				//Construcción del full path
			
				//Insercción de URL en la tabla	
				$this->getUpgradePbrmOcho($decoder['id'], $json['trimestre']['numero'], $number, $idsemaforo1);
				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF."];
				\SiteHelpers::auditTrail($r ,'Error formato PbRM-08b - '.$e->getMessage());
			}
		return response()->json($response);
	}
	private function getSearchSemaforo($id){
		$row = $this->reporte->getMIRSemaforoID($id);
		$semaforo = (count($row) > 0 ? $row[0]->semaforo : '');
		return $semaforo;
	}
	private function getUpgradePbrmOcho($id, $trim, $number, $idsemaforo){
		$data = ['url'.$trim => $number, 'idmir_semaforo'.$trim => $idsemaforo];
		$this->model->getUpdateTable($data, "ui_reporte_mir", "idreporte_mir", $id);
	}
	public function postPdfjustificacion( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
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
				}else if(empty($r->titular)){
					$response = ["status"=>"error","message"=>"Ingresa nombre del director del área"];
					return response()->json($response);
				}else if(empty($r->titular_cargo)){
					$response = ["status"=>"error","message"=>"Ingresa cargo del director del área"];
					return response()->json($response);
				}

				$json = json_decode($r->input('json'), true);

				$this->data['json'] = $json;

				$this->data['fecha'] = $r->fecha;
				$this->data['folio_reconduccion'] = $r->folio_reconduccion;
				$this->data['folio'] = $r->folio;
				$this->data['titular'] = $r->titular;
				$this->data['titular_cargo'] = $r->titular_cargo;

				$number = $this->getBuildFilenamePDF(($json['type'] == 1 ? '"IFJ"' : '"MFJ"').$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectory($json['header']['no_institucion'], $json['year'], ($json['type'] == 1 ? 'indicador' : 'meta'), 'jus');

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
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmJus($id, $trim, $number){
		$this->model->getUpdateTable(['jus'.$trim => $number], "ui_reporte", "idreporte", $id);
	}
	public function postPdfreconduccion( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
				//Validaciones de campos
				if(empty($r->oficio)){
					$response = ["status"=>"error","message"=>"Ingresa número de oficio."];
					return response()->json($response);
				}else if(empty($r->fecha)){
					$response = ["status"=>"error","message"=>"Ingresa fecha."];
					return response()->json($response);
				}else if(empty($r->titular_dep_gen)){
					$response = ["status"=>"error","message"=>"Ingresa nombre completo del titular del área."];
					return response()->json($response);
				}else if(empty($r->titular_uippe)){
					$response = ["status"=>"error","message"=>"Ingresa nombre completo del responsable de la UIEPPE o equivalente."];
					return response()->json($response);
				}

				$json = json_decode($r->input('json'), true);

				$this->data['json'] = $json;
				$this->data['oficio'] = $r->oficio;
				$this->data['fecha'] = $r->fecha;
				$this->data['titular_dep_gen'] = $r->titular_dep_gen;
				$this->data['titular_uippe'] = $r->titular_uippe;
				$this->data['iti'] = $r->iti;
				$this->data['ita'] = $r->ita;
				$this->data['itm'] = $r->itm;
				$this->data['it1'] = $r->it1;
				$this->data['it2'] = $r->it2;
				$this->data['it3'] = $r->it3;
				$this->data['it4'] = $r->it4;

				$number = $this->getBuildFilenamePDF("IFR".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['proyecto']['no_dep_gen'],$decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], 'indicador', 'rec',$json['trimestre']['numero']);

				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
										'margin_top' => 27,
										'margin_left' => 5,
										'margin_right' => 5,
										'margin_bottom' => 37,
										]);
				$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.reconduccion.header", $this->data)->render());
				$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.reconduccion.body", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.reconduccion.footer", $this->data)->render());
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				//Insercción de URL en la tabla	
				$this->getUpgradePbrmRec($decoder['id'], $json['trimestre']['numero'], $number);
				$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmRec($id, $trim, $number){
		$this->model->getUpdateTable(['rec'.$trim => $number], "ui_reporte_mir", "idreporte_mir", $id);
	}
	public function getDetalle( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->id);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['id'] = $r->id;
			$this->data['json'] = $this->metasService->viewInforReporte($decoder, $r->all());
			return view($this->module.".proyectos.detalle",$this->data);	
		}
	}

	public function postPdffoda( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Validaciones de campos
			if(empty($r->footer1)){
				$response = ["status"=>"error","message"=>"Ingresa Nombre del titular de la dependencia."];
				return response()->json($response);
			}else if(empty($r->footer2)){
				$response = ["status"=>"error","message"=>"Ingresa Nombre del titular de la UIPPE."];
				return response()->json($response);
			}

			$json = json_decode($r->input('json'), true);
			$this->data['json'] = $json;
			$this->data['tema'] = $r->tema;
			$this->data['footer1'] = $r->footer1;
			$this->data['footer2'] = $r->footer2;
			$number = $this->getBuildFilenamePDF("IFF".$json['trimestre']['numero'],$json['header']['no_institucion'],$json['header']['no_dep_gen'],$decoder['id']);
			$filename = $number.".pdf";
			//Construcción del directorio donde se va almacenar el PDF
			$result = $this->getBuildDirectoryGallery($json['header']['no_institucion'], $json['year'], 'indicador', 'foda',$json['trimestre']['numero']);
			$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
									'margin_top' => 20,
									'margin_left' => 0,
									'margin_right' => 0,
									'margin_bottom' => 45,
								]);


			$mpdf->SetHTMLHeader(View::make($this->module.".proyectos.formatos.foda.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make($this->module.".proyectos.formatos.foda.footer", $this->data)->render());
			$mpdf->WriteHTML(View::make($this->module.".proyectos.formatos.foda.body", $this->data)->render());
			$url = $result['full_path'].$filename;
			$mpdf->Output($url, 'F');
			//Insercción de URL en la tabla	
			$this->getUpgradePbrmFODA($decoder['id'], $json['trimestre']['numero'], $number);
			$this->getInsertTablePlan($json['header']['idi'], $number, $url, $result['directory']);
			$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		}else{
			$response = ["status"=>"error",
						"message"=>"Error de key."];
		}
		return response()->json($response);
	}
	private function getUpgradePbrmFODA($id, $trim, $number){
		$this->model->getUpdateTable(['foda'.$trim => $number], "ui_reporte", "idreporte", $id);
	}
	/*
    |--------------------------------------------------------------------------
    | PbRM-08d
    |--------------------------------------------------------------------------
    */
	public function getProjectsochob(Request $r){
		$data = $this->metasService->getRowsProjectsOchob($r->idy, $r->type,$r->year,$r->ida);
		return response()->json($data);
	}	
	public function getEditindicador(Request $request){
		$this->data['json'] = $this->metasService->getRowsEditIndicador($request->id);
		$this->data['rowsMetas'] = $this->reporte->getMirMetas($request->id);
		$this->data['rowsAplica'] = ['1' => 'Aplica', '2' => 'No Aplica'];
		$this->data['rowsDim'] = $this->model->getCatDimensionAtiende();
		$this->data['rowsOperacion'] = $this->model->getCatTipoOperacion();
		$this->data['id'] = $request->id;
		return view("reporte.proyectos.indicadores.edit",$this->data);
	}	
	public function getAddindicador(Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		$this->data['json'] = $this->metasService->getRowsAddIndicador($decoder);
		$this->data['rowsAplica'] = ['1' => 'Aplica', '2' => 'No Aplica'];
		$this->data['rowsFormulas'] = $this->reporte->getMirFormulas();
		$this->data['rowsFrec'] = $this->model->getCatFrecuenciaMedicion();
		$this->data['rowsDim'] = $this->model->getCatDimensionAtiende();
		$this->data['rowsTipo'] = $this->model->getCatTipoIndicador();
		$this->data['rowsOperacion'] = $this->model->getCatTipoOperacion();
		$this->data['token'] = $r->k;
		return view($this->module.".proyectos.ochob.add",$this->data);
	}	
	public function getAddtrindicador( Request $r)
	{
		$this->data['rowsOperacion'] = $this->model->getCatTipoOperacion();
		$this->data['time'] = rand(3,100).time();
		return view($this->module.".proyectos.ochob.tr",$this->data);
	}
	public function getIndest( Request $r)
	{
		$data = $this->reporte->getCatIndEstId($r->id);
		$response = ['status' => 'ok', 'data' => $data];
		return response()->json($response);
	}
	public function postEditindicador(Request $r){
		try {
			// Iniciar la transacción
				$data = [
					'interpretacion' 		=> $r->interpretacion,
					'iddimension_atiende' 	=> $r->iddimension_atiende,
					'factor' 				=> $r->factor,
					'desc_factor' 			=> $r->desc_factor,
					'linea' 				=> $r->linea,
					'descripcion_meta' 		=> $r->descripcion_meta,
					'metas_actividad' 		=> $r->metas_actividad,
					'ambito' 				=> $r->ambito,
					'cobertura' 			=> $r->cobertura,
					'aplica1'  				=> $r->aplica1,
					'aplica2'  				=> $r->aplica2,
					'aplica3'  				=> $r->aplica3,
					'aplica4'  				=> $r->aplica4,
				];
				$this->model->getUpdateTable($data, 'ui_reporte_mir', 'idreporte_mir', $r->id);
				//Actualizo registros
				for ($i=0; $i < count($r->idrg); $i++) { 
					$arr = [
							'unidad_medida' 	=> $r->unidad_medida[$i],
							'idtipo_operacion' 	=> $r->idtipo_operacion[$i],
							'prog_anual' 		=> $r->prog_anual[$i],
							'trim_1'			=> $r->trim1[$i],
							'trim_2' 			=> $r->trim2[$i],
							'trim_3' 			=> $r->trim3[$i],
							'trim_4' 			=> $r->trim4[$i]
						];
					$this->model->getUpdateTable($arr, 'ui_reporte_reg', 'idreporte_reg', $r->idrg[$i]);
				}
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Indicador guardado correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error al editar el indicador: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al editar el indicador!"];
		}
		return response()->json($response);
	}
	public function postAddindicador(Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if (!$decoder) {
			return response()->json(["status" => "error", "message" => "Error de key!"]);
		}

		try {
			// Iniciar la transacción
			DB::transaction(function () use ($r, $decoder) {
				$data = ['idreporte'		=> $decoder['id'],
					'mir'					=> $r->mir, 
					'nombre_indicador'  	=> $r->nombre_indicador,
					'formula' 				=> $r->formula,
					'idmir_formula' 		=> $r->idmir_formula,
					'interpretacion' 		=> $r->interpretacion,
					'idfrecuencia_medicion' => $r->idfrecuencia_medicion,
					'iddimension_atiende' 	=> $r->iddimension_atiende,
					'factor' 				=> $r->factor,
					'idtipo_indicador' 		=> $r->idtipo_indicador,
					'desc_factor' 			=> $r->desc_factor,
					'linea' 				=> $r->linea,
					'descripcion_meta' 		=> $r->descripcion_meta,
					'medios_verificacion' 	=> $r->medios_verificacion,
					'metas_actividad' 		=> $r->metas_actividad,
					'ambito' 				=> $r->ambito,
					'cobertura' 			=> $r->cobertura,
					'aplica1' 				=> $r->aplica1,
					'aplica2' 				=> $r->aplica2,
					'aplica3' 				=> $r->aplica3,
					'aplica4' 				=> $r->aplica4
				];
				$idmir = $this->model->getInsertTable($data, 'ui_reporte_mir');
				//Inserto los trimestre
				$this->getInsertMIRTrimestral($idmir);
				//Actualizo registros
				for ($i=0; $i < count($r->meta); $i++) { 
					$arr = ['idreporte' 		=> $decoder['id'],
							'idreporte_mir' 	=> $idmir,
							'idtipo_operacion' 	=> $r->idtipo_operacion[$i],
							'descripcion' 		=> $r->meta[$i],
							'unidad_medida' 	=> $r->unidad_medida[$i],
							'prog_anual' 		=> $r->anual[$i],
							'trim_1'			=> $r->trim1[$i],
							'trim_2' 			=> $r->trim2[$i],
							'trim_3' 			=> $r->trim3[$i],
							'trim_4' 			=> $r->trim4[$i]
						];
					$this->model->getInsertTable($arr, 'ui_reporte_reg');
				}
			});
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Indicador agregado correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error al agergar el indicador: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al agergar el indicador!"];
		}
		return response()->json($response);
	}
	private function getInsertMIRTrimestral($id){
		$data = [];
		for ($i=1; $i <= 4; $i++) { 
			$data[] = ['idreporte_mir'		=> $id, 
						'trim' 				=> $i, 
						'desc_meta' 		=> null,
						'desc_res' 			=> null,
						'evaluacion' 		=> null
					];
		}
		$this->model->getInsertTableData($data, "ui_reporte_mir_eva");
	}
	public function deleteIndicadormir(Request $r){
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if (!$decoder) {
			return response()->json(["status" => "error", "message" => "Error de key!"]);
		}
		try {
			// Iniciar la transacción
			DB::transaction(function () use ($decoder) {
				// Eliminar el registro principal
				$this->model->getDestroyTable('ui_reporte_mir', 'idreporte_mir', $decoder['id']);
				// Eliminar los registros relacionados
				foreach ($this->reporte->getMirMetas($decoder['id']) as $v) {
					$this->model->getDestroyTable('ui_reporte_reg', 'idreporte_reg', $v->id);
				}
				//Elimina también los registros de Evaluación trimestral
				foreach ($this->reporte->getMirEvaluacion($decoder['id']) as $v) {
					$this->model->getDestroyTable('ui_reporte_mir_eva', 'idreporte_mir_eva', $v->id);
				}
			});
			// Si todo sale bien, retornar éxito
			$response = ["status" => "ok", "message" => "Indicador eliminado correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error al eliminar el indicador: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al eliminar el indicador!"];
		}
		return response()->json($response);
	}
}