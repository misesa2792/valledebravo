<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Capitulos;
use App\Models\Anios;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;

use Validator, Input ; 


class CapitulosController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $info;	
	protected $access;	
	public $module = 'capitulos';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Capitulos();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'capitulos',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'idteso_capitulos'); 
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
		$pagination->setPath('capitulos');
		
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
		return view('capitulos.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_teso_capitulos'); 
		}
		$this->data['rowsYears'] =  Anios::all(['idanio','anio']);
		$this->data['id'] = $id;
		return view('capitulos.form',$this->data);
	}	

	function postSave( Request $request)
	{
		$data = ['idanio' => $request->idanio,"clave" => $request->clave,"descripcion" => $request->descripcion];
		$id = $this->model->insertRow($data , $request->input('idteso_capitulos'));
		
		$return = 'capitulos?return='.self::returnUrl();

		// Insert logs into database
		if($request->input('idteso_capitulos') =='')
		{
			\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
		} else {
			\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
		}
		return Redirect::to($return)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
	}	

	public function postDelete( Request $request)
	{
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('id'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('capitulos')
        		->with('messagetext', Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
		} else {
			return Redirect::to('capitulos')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}