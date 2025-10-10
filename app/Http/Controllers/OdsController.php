<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Ods;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class OdsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model = array();	
	protected $info = array();	
	protected $access = array();	
	public $module = 'ods';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Ods();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'ods',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'idods'); 
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
		$pagination->setPath('ods');
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('ods.index',$this->data);
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
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['metas'] = $this->model->getMetas($row->idods); 
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_ods'); 
			$this->data['metas'] = array(); 
		}
		
		
		$this->data['id'] = $id;
		return view('ods.form',$this->data);
	}	
	public function getAddtr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('ods.tr',$this->data);	
	}

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_ods'); 
		}
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('ods.view',$this->data);	
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_ods');
			
			$id = $this->model->insertRow($data , $request->input('idods'));
			
			if(isset($request->metas)){
				for ($i=0; $i < count($request->metas) ; $i++) {
					if(!empty($request->metas[$i])) 
						$this->model->getInsertTable(array("descripcion"=>$request->metas[$i],"idods"=>$id),"ui_ods_metas");
				}
			}
			if(isset($request->metas_ins)){
				for ($i=0; $i < count($request->metas_ins) ; $i++) {
					if(!empty($request->metas_ins[$i])) 
						$this->model->getUpdateTable(array("descripcion"=>$request->metas_ins[$i]),"ui_ods_metas","idods_metas",$request->id_ins[$i]);
				}
			}

			return Redirect::to('ods?return='.self::returnUrl())->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('ods/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}	
	function getEliminartrods(Request $r){
		$this->model->getDestroyTable("ui_ods_metas","idods_metas",$r->id);
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
			return Redirect::to('ods')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('ods')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}		

}