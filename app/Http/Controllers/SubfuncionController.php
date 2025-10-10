<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Subfuncion;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class SubfuncionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'subfuncion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Subfuncion();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'subfuncion',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios();
		return view('subfuncion.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['idy']	= $request->idy; 
		$this->data['year']	= $request->year; 
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view($this->module.'.principal',$this->data);
	}
	public function postSearch( Request $request )
	{
		$totales = $this->model->getSearch(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request) as $v) {
			$arr[] = array("id"			=> $v->id,
							"p_fun"		=> $v->no_funcion,
							"p_num"		=> $v->no_subfuncion,
							"p_sub"		=> $v->subfuncion,
							"p_obj"		=> $v->obj_subfuncion
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['idy']	= $request->idy;
		return view($this->module.'.search',$this->data);
	}
	function getUpdate(Request $request, $id = null)
	{
		$id = $request->id;
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_subfuncion'); 
		}
		$this->data['rowsFuncion'] = $this->model->getFuncionActiveForYears($request->idy); 
		$this->data['id'] = $id;
		$this->data['idy'] = $request->idy;
		return view('subfuncion.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = array(
					'idanio'		=> $request->input('idy'),
					'idfuncion'		=> $request->input('idfuncion'),
					'numero'		=> trim($request->input('numero')),
					'descripcion'	=> trim($request->input('descripcion')),
					'objetivo'		=> $this->getEliminarSaltosDeLinea($request->input('objetivo')),
				);
		$id = $this->model->insertRow($data , $request->input('idsubfuncion'));
		$response = ["success"=>"ok"];
		return response()->json($response);
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
			return Redirect::to('subfuncion')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('subfuncion')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}