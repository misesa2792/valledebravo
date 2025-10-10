<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class FuncionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'funcion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Funcion();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'funcion',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios();
		return view($this->module.'.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access']		= $this->access;
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
							"p_fin"		=> $v->no_finalidad,
							"p_num"		=> $v->no_funcion,
							"p_fun"		=> $v->funcion,
							"p_obj"		=> $v->obj_funcion
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
			$this->data['row'] = $this->model->getColumnTable('ui_funcion'); 
		}
		$this->data['rowsFinalidad'] = $this->model->getFinalidadActiveForYears($request->idy); 
		$this->data['id'] = $id;
		$this->data['idy'] = $request->idy;
		return view('funcion.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = array(
					'idanio'		=> $request->input('idy'),
					'idfinalidad'	=> $request->input('idfinalidad'),
					'numero'		=> trim($request->input('numero')),
					'descripcion'	=> trim($request->input('descripcion')),
					'objetivo'		=> $this->getEliminarSaltosDeLinea($request->input('objetivo')),
				);
		$id = $this->model->insertRow($data , $request->input('idfuncion'));
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
			return Redirect::to('funcion')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('funcion')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}