<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pilares;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class PilaresController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pilares';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pilares();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pilares',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'idpdm_pilares'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

		
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('pilares');
		$this->data['rowData']		= json_encode($this->getRowsPilares($results['rows']));
		$this->data['pagination']	= $pagination;
		$this->data['pager'] 		= $this->injectPaginate();	
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		$this->data['access']		= $this->access;
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		return view('pilares.index',$this->data);
	}	
	protected function getRowsPilares($rows = array()){
		$data = array();
		foreach ($rows as $v) {
			$data[] = array("idpdm_pilares"=>$v->idpdm_pilares,
							"pilares"=>$v->pilares,
							"tipo"=>$v->tipo,
							"color"=>$v->color,
							"periodo"=>$v->periodo,
							"numero"=>$v->numero,
							"estatus"=>$v->estatus,
							"temas"=>$this->model->getTemas($v->idpdm_pilares));
		}
		return $data;
	}
	public function getAddtr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('pilares.tr',$this->data);	
	}


	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		$this->data['j'] = 1;
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['temas'] = $this->model->getTemas($id);
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_pdm_pilares'); 
			$this->data['temas'] = array();
		}
		$this->data['rows_periodos'] = $this->model->getCatPeriodos();
		$this->data['rows_pilares'] = $this->model->getCatPilaresTipo();
		$this->data['rows_colores'] = $this->model->getCatColores();
		$this->data['estatus'] = array("1" => "Activo", "2" => "Inactivo"); 
		$this->data['id'] = $id;
		return view('pilares.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$row = $this->model->getPilarTipo($request->idpdm_pilares_tipo);

		$data = array("pilares"=>$request->pilares,
						"idpdm_pilares_tipo"=>$request->idpdm_pilares_tipo,
						"tipo"=>$row[0]->pilar,
						"color"=>$request->color,
						"numero"=>$request->numero,
						"idperiodo"=>$request->idperiodo,
						"estatus"=>$request->estatus,
						) ;
		$id = $this->model->insertRow($data, $request->input('idpdm_pilares'));

		if(isset($request->temas)){
			for ($i=0; $i < count($request->temas) ; $i++) {
				if(!empty($request->temas[$i])) {
					$this->model->getInsertTable(array("descripcion"=>$request->temas[$i],"idpdm_pilares"=>$id),"ui_pdm_pilares_temas");
				}
			}
		}
		if(isset($request->temas_ins)){
			for ($i=0; $i < count($request->temas_ins) ; $i++) {
				if(!empty($request->temas_ins[$i])) {
					$this->model->getUpdateTable(array("descripcion"=>$request->temas_ins[$i]),"ui_pdm_pilares_temas","idpdm_pilares_temas",$request->id_ins[$i]);
				}
			}
		}
		return Redirect::to('pilares?return='.self::returnUrl())->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
	}	
	function getEliminartr(Request $r){
		$this->model->getDestroyTable("ui_pdm_pilares_temas","idpdm_pilares_temas",$r->id);
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
			return Redirect::to('pilares')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('pilares')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}