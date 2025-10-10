<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pdm;
use App\Models\Exportar;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Illuminate\Support\Facades\Auth;

class PdmController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $exportar;	
	protected $info;	
	protected $access;	
	public $module = 'pdm';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pdm();
		$this->exportar = new Exportar();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pdm',
			'return'	=> self::returnUrl()
			
		);
		
	}
	/*
	 ** PILARES 
	 */
	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access']		= $this->access;
		$this->data['rowData'] = json_encode($this->getRowsPilares());
		$this->data['i'] = 0;
		$this->data['id'] = isset($request->id) ? $request->id : 0;
		return view('pdm.index',$this->data);
	}
	/* 
	 ** SUBTEMAS 
	*/
	public function getSubtemas( Request $request ){
		$this->data['i'] = 0;
		$this->data['id'] = $request->id;//ID PILARES
		$this->data['idtema'] = $request->idtema;//ID TEMA
		$row = $this->model->getPilarTema($request->idtema);
		$this->data['row'] = $row[0];
		return view('pdm.subtemas.index',$this->data);
	}
	public function getSearchsubtemas( Request $request ){
		$this->data['rows'] = $this->model->getPilarSubtemas($request->idtema, Auth::user()->idinstituciones);
		$this->data['idtema'] = $request->idtema;
		$this->data['id'] = $request->id;
		$this->data['color'] = $request->color;
		return view('pdm.subtemas.view',$this->data);
	}	
	public function getAgregarsubtema( Request $request ){
		$this->data['idtema'] = $request->idtema;
		return view('pdm.subtemas.add',$this->data);
	}
	public function postSavesubtema( Request $r ){
		$data = array("idpdm_pilares_temas"	=> $r->idtema,
					"descripcion"			=> $r->descripcion,
					"idinstituciones"		=> Auth::user()->idinstituciones,
				);
		$this->model->getInsertTable($data,"ui_pdm_pilares_subtemas");
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getEditarsubtema( Request $request )
	{
		$row = $this->model->getPilarSubtema($request->idps);
		$this->data['idps'] = $request->idps;
		$this->data['row'] = $row[0];
		return view('pdm.subtemas.edit',$this->data);
	}
	public function postEditarsubtema( Request $r )
	{
		$data = ["descripcion"=>$r->descripcion];
		$this->model->getUpdateTable($data,"ui_pdm_pilares_subtemas","idpdm_pilares_subtemas",$r->idps);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroysubtema( Request $r )
	{
		$this->model->getDestroyTable("ui_pdm_pilares_subtemas","idpdm_pilares_subtemas",$r->params['idps']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	/* 
	 ** OBJETIVOS 
	*/
	public function getObjetivos( Request $request ){
		$this->data['i'] = 0;
		$this->data['id'] = $request->id;//ID PILARES
		$this->data['idtema'] = $request->idtema;//ID TEMA
		$this->data['idps'] = $request->idps;//ID SUBTEMA
		$row = $this->model->getPilarTemaSubtema($request->idps);
		$this->data['row'] = $row[0];
		return view('pdm.objetivos.index',$this->data);
	}
	public function getSearchobj( Request $request ){
		$this->data['rows'] = $this->model->getPilarObjetivos($request->idps);
		$this->data['idps'] = $request->idps;
		$this->data['idtema'] = $request->idtema;
		$this->data['id'] = $request->id;
		$this->data['color'] = $request->color;
		return view('pdm.objetivos.view',$this->data);
	}	
	public function getAgregarobj( Request $request ){
		$this->data['idps'] = $request->idps;
		return view('pdm.objetivos.add',$this->data);
	}
	public function getEditarobj( Request $request ){
		$row = $this->model->getPilarObj($request->idpo);
		$this->data['idpo'] = $request->idpo;
		$this->data['row'] = $row[0];
		return view('pdm.objetivos.edit',$this->data);
	}
	public function postSaveobj( Request $r ){
		$data = array("idpdm_pilares_subtemas"=>$r->idps,
					"clave"=>$r->clave,
					"descripcion"=>$r->descripcion,
					"idinstituciones"		=> Auth::user()->idinstituciones,
				);
		$this->model->getInsertTable($data,"ui_pilares_objetivos");
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postEditarobj( Request $r ){
		$data = array("clave"=>$r->clave,"descripcion"=>$r->descripcion);
		$this->model->getUpdateTable($data,"ui_pilares_objetivos","idpilares_objetivos",$r->idpo);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroyobj( Request $r ){
		$this->model->getDestroyTable("ui_pilares_objetivos","idpilares_objetivos",$r->params['idpo']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}		
	/* 
	 ** ESTRATEGIAS 
	*/
	public function getEstrategias( Request $request )
	{
		$this->data['i'] = 0;
		$this->data['id'] = $request->id;//ID PILARES
		$this->data['idtema'] = $request->idtema;// ID TEMA
		$this->data['idps'] = $request->idps;//ID SUBTEMA
		$this->data['idpo'] = $request->idpo;//ID OBJETIVO
		$row = $this->model->getPilarTemaObjetivo($request->idpo);
		$this->data['row'] = $row[0];
		return view('pdm.estrategias.index',$this->data);
	}
	public function getSearchest( Request $request )
	{
		$this->data['rows'] = $this->model->getPilarEstrategias($request->idpo);
		$this->data['idtema'] = $request->idtema;
		$this->data['id'] = $request->id;
		$this->data['idpo'] = $request->idpo;
		$this->data['idps'] = $request->idps;
		$this->data['color'] = $request->color;
		return view('pdm.estrategias.view',$this->data);
	}	
	public function getAgregarest( Request $request )
	{
		$this->data['idpo'] = $request->idpo;
		return view('pdm.estrategias.add',$this->data);
	}
	public function postSaveest( Request $r )
	{
		$data = array("idpilares_objetivos"=>$r->idpo,
					"clave"=>$r->clave,
					"descripcion"=>$r->descripcion,
					"idinstituciones" => Auth::user()->idinstituciones,
				);
		$this->model->getInsertTable($data,"ui_pdm_pilares_estrategias");
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function getEditarest( Request $request )
	{
		$row = $this->model->getPilarEst($request->idpe);
		$this->data['idpe'] = $request->idpe;
		$this->data['row'] = $row[0];
		return view('pdm.estrategias.edit',$this->data);
	}
	public function postEditarest( Request $r )
	{
		$data = array("clave"=>$r->clave,"descripcion"=>$r->descripcion);
		$this->model->getUpdateTable($data,"ui_pdm_pilares_estrategias","idpdm_pilares_estrategias",$r->idpe);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function postDestroyest( Request $r )
	{
		$this->model->getDestroyTable("ui_pdm_pilares_estrategias","idpdm_pilares_estrategias",$r->params['idpe']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	/* 
	 ** LINEA DE ACCIÓN 
	*/
	public function getLineasaccion( Request $request )
	{
		$this->data['i'] = 0;
		$this->data['id'] = $request->id;//ID PILARES
		$this->data['idtema'] = $request->idtema;//ID TEMA
		$this->data['idps'] = $request->idps;//ID SUBTEMA
		$this->data['idpo'] = $request->idpo;//ID OBJETIVO
		$this->data['idpe'] = $request->idpe;//ID ESTRATEGIA
		$row = $this->model->getPilarTemaObjetivoEstrategia($request->idpe);
		$this->data['row'] = $row[0];
		return view('pdm.lineas_accion.index',$this->data);
	}
	public function getSearchlinaccion( Request $request )
	{
		$this->data['rows'] = $this->model->getPilarLineasAccion($request->idpe);
		$this->data['idtema'] = $request->idtema;
		$this->data['id'] = $request->id;
		$this->data['idpo'] = $request->idpo;
		$this->data['idps'] = $request->idps;
		$this->data['idpe'] = $request->idpe;
		$this->data['color'] = $request->color;
		return view('pdm.lineas_accion.view',$this->data);
	}	
	public function getAgregarlinaccion( Request $request )
	{
		$this->data['idpe'] = $request->idpe;
		return view('pdm.lineas_accion.add',$this->data);
	}
	public function postSavelinaccion( Request $r )
	{
		$data = array("idpdm_pilares_estrategias"=>$r->idpe,
					"clave"=>$r->clave,
					"descripcion"=>$r->descripcion,
					"idinstituciones" => Auth::user()->idinstituciones
				);
		$this->model->getInsertTable($data,"ui_pdm_pilares_lineas_accion");
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getEditarlinaccion( Request $request )
	{
		$row = $this->model->getPilarLinAccion($request->idpla);
		$this->data['idpla'] = $request->idpla;
		$this->data['row'] = $row[0];
		return view('pdm.lineas_accion.edit',$this->data);
	}
	public function postEditarlinaccion( Request $r )
	{
		$data = array("clave"=>$r->clave,"descripcion"=>$r->descripcion);
		$this->model->getUpdateTable($data,"ui_pdm_pilares_lineas_accion","idpdm_pilares_lineas_accion",$r->idpla);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function postDestroylinaccion( Request $r )
	{
		$this->model->getDestroyTable("ui_pdm_pilares_lineas_accion","idpdm_pilares_lineas_accion",$r->params['idpla']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	protected function getRowsPilares(){
		$data = array();
		foreach ($this->model->getCatPeriodos() as $p) {
			$arr = array();
			foreach ($this->model->getPilaresPeriodo($p->idperiodo) as $key => $v) {
				$arr[] = array("id"=>$v->idpdm_pilares,"tipo"=>$v->tipo,"color"=>$v->color,"pilares"=>$v->pilares,"temas"=>$this->model->getTemas($v->idpdm_pilares));
			}
			$data[] = array("idperiodo"=>$p->idperiodo,"periodo"=>$p->descripcion,"rows"=>$arr);
		}
		return $data;
	}
	public function getExportar( Request $r )
	{
		/*$data = array();
		foreach ($this->model->getPilaresPeriodo($r->idperiodo) as $v) {
			$temas = array();
			foreach ($this->model->getTemas($v->idpdm_pilares) as $t) {
				$subtemas = array();
				foreach ($this->model->getPilarSubtemas($t->idtema) as $s) {
					
					$objetivos = array();
					foreach ($this->model->getPilarObjetivos($s->idps) as $o) {
						$objetivos[] = array("clave"=>$o->clave,"objetivo"=>$o->descripcion);
					}

					$subtemas[] = array("subtema"=>$s->descripcion,"objetivos"=>$objetivos);
				}
				$temas[] = array("tema"=>$t->tema,"subtemas"=>$subtemas);
			}
			$data[] = array("pilares"=>$v->pilares,"temas"=>$temas);
		}*/
		return $this->exportar->getExportarPDM($this->model->getPDM($r->idperiodo));
	}
	/* 
	 ** METAS
	*/
	public function getMetas( Request $request )
	{
		$this->data['i'] = 0;
		$this->data['id'] = $request->id;//ID PILARES
		$this->data['idtema'] = $request->idtema;//ID TEMA
		$this->data['idps'] = $request->idps;//ID SUBTEMA
		$this->data['idpo'] = $request->idpo;//ID OBJETIVO
		$this->data['idpe'] = $request->idpe;//ID ESTRATEGIA
		$this->data['idpla'] = $request->idpla;//ID LINEA DE ACCION
		$row = $this->model->getPilarTemaObjetivoEstrategiaLineaAccion($request->idpla);
		$this->data['row'] = $row[0];
		return view('pdm.metas.index',$this->data);
	}
	public function getAgregarmeta( Request $request )
	{
		$this->data['idpla'] = $request->idpla;
		return view('pdm.metas.add',$this->data);
	}
	public function postSavemeta( Request $r )
	{
		$data = array("idpdm_pilares_lineas_accion"=>$r->idpla,
					"clave"=>$r->clave,
					"descripcion"=>$r->descripcion,
					"idinstituciones" => Auth::user()->idinstituciones
				);
		$this->model->getInsertTable($data,"ui_pdm_pilares_metas");
		return response()->json(["status" => "ok", "message" => "Información guardada exitosamente!"]);
	}
	public function getSearchmetas( Request $request )
	{
		$this->data['rows'] = $this->model->getPdmMetas($request->idpla);
		$this->data['idpla'] = $request->idpla;                                                                                                                                                                                                                                                            
		return view('pdm.metas.view',$this->data);
	}
	public function deleteMeta( Request $request )
	{
		$this->model->getDestroyTable("ui_pdm_pilares_metas","idpdm_pilares_metas",$request->id);
		return response()->json(["status" => "ok", "message" => "Campo eliminado correctamente!"]);
	}	
	public function getEditarmeta( Request $request )
	{
		$this->data['id'] = $request->id;
		$this->data['row'] = $this->model->getPDMMeta($request->id);
		return view('pdm.metas.edit',$this->data);
	}
	public function postEditarmeta( Request $request )
	{
		$data = array("clave"=>$request->clave,"descripcion"=>$request->descripcion);
		$this->model->getUpdateTable($data,"ui_pdm_pilares_metas","idpdm_pilares_metas",$request->id);
		return response()->json(["status" => "ok", "message" => "Información editada exitosamente!"]);
	}
}