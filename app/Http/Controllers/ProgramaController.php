<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input; 
use Illuminate\Support\Facades\Redirect;


class ProgramaController extends Controller {

	protected $layout = "layouts.main";
	protected $data;	
	protected $model;	
	protected $info;	
	protected $access;	
	public $module = 'programa';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Programa();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'programa',
			'return'	=> self::returnUrl()
		);
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios();
		return view('programa.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access']		= $this->access;
		$this->data['pilares'] = $this->model->getCatPilaresActive(); 
		$this->data['idy']	= $request->idy; 
		$this->data['year']	= $request->year; 
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view('programa.principal',$this->data);
	}	
	public function postSearch( Request $request )
	{
		$totales = $this->model->getSearch(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request) as $v) {
			$arr[] = array("id"				=> $v->id,
							"estatus"		=> $v->estatus,
							"no_subfuncion"	=> $v->no_subfuncion,
							"no_programa"	=> $v->no_programa,
							"programa"		=> $v->programa,
							"objetivo"		=> $v->objetivo,
							"pilar"			=> $v->pilares,
							"tema"			=> $v->tema,
							"no_tema"		=> $v->no_tema,
							"tema_des"		=> $v->tema_des,
							"dataMatriz"	=> $this->getDataProgramaNoMatriz($v->id)
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['idy']	= $request->idy;
		return view($this->module.'.search',$this->data);
	}
	private function getDataProgramaNoMatriz($id){
		$data = [];
		foreach ($this->model->getProgramaNoMatriz($id) as $v) {
			$data[] = ['no_matriz' => $v->no_matriz, 'total' => $this->model->getProgramaRegTotal($id, $v->no_matriz) ];
		}
		return $data;
	}
	public function getMatriz( Request $r )
	{
		$id = $r->id;
		$this->data['rows'] = $this->getRowsMatrizPrograma($id, $r->no);
		$this->data['id'] = $id;
		$this->data['no_matriz'] = $r->no;
		$this->data['row'] = $this->model->find($id, ['numero as no_programa', 'descripcion as programa']);
		$this->data['rows_frec_medicion'] = $this->model->getCatFrecuenciaMedicion();
		$this->data['rows_tipo_indicador'] = $this->model->getCatTipoIndicador();
		$this->data['rowsFormulas'] = $this->model->getMirFormula();
		$this->data['rowsComponent'] = $this->model->getProgramaRegComponentes($id, $r->no);
		$this->data['rowsIndEst'] = $this->model->getIndEstrategicos($id, $r->idy);
		return view($this->module.'.matriz.index',$this->data);
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
	/*public function getProgramamatriz( Request $r)
	{
		$rows = \DB::select("SELECT idprograma FROM ui_programa where idanio = 4");
		foreach ($rows as $key => $v) {
			$data = ['idprograma' => $v->idprograma, 'no_matriz' => 1 ];
			$this->model->getInsertTable($data, "ui_programa_matriz");
		}
		return "ok";
	}*/
	function postSavematriz( Request $r)
	{
		try {
			$id = $r->id;
			//Fin
			$da1 = ["idprograma"			=> $id,
					"no_matriz"				=> $r->no_matriz,
					"tipo"					=> 1,
					"descripcion"			=> $this->getUnirTextoSaltosLinea($r->tipo1),
					"nombre"				=> $this->getUnirTextoSaltosLinea($r->nombre1),
					"formula"				=> $this->getUnirTextoSaltosLinea($r->formula1),
					"idfrecuencia_medicion"	=> $r->fi1,
					"idtipo_indicador"		=> $r->ti1,
					"medios"				=> $this->getUnirTextoSaltosLinea($r->medios1),
					"supuestos"				=> $this->getUnirTextoSaltosLinea($r->supuestos1),
					"idind_estrategicos"	=> empty($r->idind1) ? 0 : $r->idind1,
					"idmir_formula"			=> empty($r->idformula1) ? 0 : $r->idformula1
				];
			if($r->idprograma_reg1 > 0){
				$this->model->getUpdateTable($da1,"ui_programa_reg", "idprograma_reg", $r->idprograma_reg1);
			}else{
				$this->model->getInsertTable($da1,"ui_programa_reg");
			}
			//Propósito
			$da2 = array("idprograma"			=> $id,
						"no_matriz"				=> $r->no_matriz,
						"tipo"					=> 2,
						"descripcion"			=> $this->getUnirTextoSaltosLinea($r->tipo2),
						"nombre"				=> $this->getUnirTextoSaltosLinea($r->nombre2),
						"formula"				=> $this->getUnirTextoSaltosLinea($r->formula2),
						"idfrecuencia_medicion"	=> $r->fi2,
						"idtipo_indicador"		=> $r->ti2,
						"medios"				=> $this->getUnirTextoSaltosLinea($r->medios2),
						"supuestos"				=> $this->getUnirTextoSaltosLinea($r->supuestos2),
						"idind_estrategicos"	=> empty($r->idind2) ? 0 : $r->idind2,
						"idmir_formula"			=> empty($r->idformula2) ? 0 : $r->idformula2
					);
			if($r->idprograma_reg2 > 0){
				$this->model->getUpdateTable($da2,"ui_programa_reg", "idprograma_reg", $r->idprograma_reg2);
			}else{
				$this->model->getInsertTable($da2,"ui_programa_reg");
			}
			//Componentes
			for ($i=0; $i < count($r->tipo3); $i++) { 
				$da3 = array("idprograma"			=> $id,
							"no_matriz"				=> $r->no_matriz,
							"tipo"					=> 3,
							"descripcion"			=> $this->getUnirTextoSaltosLinea($r->tipo3[$i]),
							"nombre"				=> $this->getUnirTextoSaltosLinea($r->nombre3[$i]),
							"formula"				=> $this->getUnirTextoSaltosLinea($r->formula3[$i]),
							"idfrecuencia_medicion"	=> $r->fi3[$i],
							"idtipo_indicador"		=> $r->ti3[$i],
							"medios"				=> $this->getUnirTextoSaltosLinea($r->medios3[$i]),
							"supuestos"				=> $this->getUnirTextoSaltosLinea($r->supuestos3[$i]),
							"idind_estrategicos"	=> empty($r->idind3[$i]) ? 0 : $r->idind3[$i],
							"idmir_formula"			=> empty($r->idformula3[$i]) ? 0 : $r->idformula3[$i]
						);
				if($r->idprograma_reg3[$i] > 0){
					$this->model->getUpdateTable($da3,"ui_programa_reg", "idprograma_reg", $r->idprograma_reg3[$i]);
				}else{
					$this->model->getInsertTable($da3,"ui_programa_reg");
				}
			}
			//Actividades
			for ($i=0; $i < count($r->tipo4); $i++) { 
				$da4 = array("idprograma"			=> $id,
							"no_matriz"				=> $r->no_matriz,
							"tipo"					=> 4,
							"descripcion"			=> $this->getUnirTextoSaltosLinea($r->tipo4[$i]),
							"nombre"				=> $this->getUnirTextoSaltosLinea($r->nombre4[$i]),
							"formula"				=> $this->getUnirTextoSaltosLinea($r->formula4[$i]),
							"idfrecuencia_medicion"	=> $r->fi4[$i],
							"idtipo_indicador"		=> $r->ti4[$i],
							"medios"				=> $this->getUnirTextoSaltosLinea($r->medios4[$i]),
							"supuestos"				=> $this->getUnirTextoSaltosLinea($r->supuestos4[$i]),
							"idind_estrategicos"	=> empty($r->idind4[$i]) ? 0 : $r->idind4[$i],
							"idmir_formula"			=> empty($r->idformula4[$i]) ? 0 : $r->idformula4[$i],
							"idprograma_reg_rel"	=> empty($r->idrel4[$i]) ? 0 : $r->idrel4[$i]
						);
				if($r->idprograma_reg4[$i] > 0){
					$this->model->getUpdateTable($da4,"ui_programa_reg", "idprograma_reg", $r->idprograma_reg4[$i]);
				}else{
					$this->model->getInsertTable($da4,"ui_programa_reg");
				}
			}
			$response = ["status"=>"ok",
						"message"=>"Información guardada correctamente."];
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error, '.$e->getMessage());
			$response = ["status"=>"no",
						"message"=>"Error al guardar información."];
		}
		return response()->json($response);
	}
	public function deleteTrprogreg( Request $r){
		$this->model->getDestroyTable("ui_programa_reg", "idprograma_reg", $r->id);
		$response = ["status"=>"ok",
					"message"=>"Registro eliminado correctamente."];
		return response()->json($response);
	}
	function getLoadmatriz( Request $r)
	{
		$this->data['rows'] =  $this->getRowsMatrizPrograma($r->idp,$r->no);
		$this->data['token'] =  $r->k;
		return view('programa.matriz.view',$this->data);
	}
	private function getRowsMatrizPrograma($idp,$no){
		$data = [];
		foreach ($this->model->getProgramaReg($idp, $no) as $v) {
			$data[$v->tipo][] = ['id' 			=> $v->id, 
								'descripcion' 	=> $v->descripcion, 
								'nombre' 		=> $v->nombre, 
								'formula' 		=> $v->formula, 
								'idf' 			=> $v->idf, 
								'idt' 			=> $v->idt, 
								'frecuencia' 	=> $v->frecuencia, 
								'tipo_indicador'=> $v->tipo_indicador, 
								'medios' 		=> $v->medios, 
								'supuestos' 	=> $v->supuestos,
								'idformula' 	=> $v->idmir_formula,
								'idindicador' 	=> $v->idind_estrategicos,
								'idrel' 		=> $v->idrel
							];
		}
		return $data;
	}
	function getUpdate(Request $request, $id = null)
	{
		$id = $request->id;
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_programa'); 
			$this->data['objetivos'] =  array();
		}
		$this->data['rows'] = $this->model->getCatSubfuncion(); 
		$this->data['pilares'] = $this->model->getCatPilaresActive(); 
		$this->data['pilaresTemas'] = $this->model->getCatPilaresTemasActive(); 
		$this->data['estatus'] = array("1" => "Activo", "2" => "Inactivo"); 
		$this->data['id'] = $id;
		$this->data['j'] = 1;
		$this->data['idy']	= $request->idy;
		return view('programa.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = array('estatus' 			=> $request->input('estatus') ,
					'idpdm_pilares'			=> $request->input('idpdm_pilares'),
					'idsubfuncion'			=> $request->input('idsubfuncion'),
					'numero'				=> trim($request->input('numero')),
					'descripcion'			=> trim($request->input('descripcion')),
					'objetivo'				=> $this->getEliminarSaltosDeLinea($request->input('objetivo')),
					'idanio'				=> $request->input('idy'),
					'tema_desarrollo' 		=> $this->getEliminarSaltosDeLinea($request->input('tema_desarrollo')),
					'idpdm_pilares_temas'	=> $request->input('idtema'),
				);
		$id = $this->model->insertRow($data , $request->input('idprograma'));
		$response = array("success"=>"ok");
		return json_encode($response);
	}

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('id'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('programa')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('programa')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}