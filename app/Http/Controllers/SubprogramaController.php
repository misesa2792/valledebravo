<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Subprograma;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class SubprogramaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'subprograma';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Subprograma();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'subprograma',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios();
		return view('subprograma.index',$this->data);
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
		$this->data['rowsEstatus']	= $this->getEstatusSubPrograma(); 
		return view('subprograma.principal',$this->data);
	}	
	private function getEstatusSubPrograma(){
		return ['1' => 'Activo', '2' => 'Inactivo'];
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
							"p_std"		=> $v->estatus,
							"p_pro"		=> $v->no_programa,
							"p_num"		=> $v->no_subprograma,
							"p_sub"		=> $v->subprograma,
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['idy']	= $request->idy;
		return view($this->module.'.search',$this->data);
	}

	function getUpdate(Request $request)
	{
		$id = $request->id;
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_subprograma'); 
		}
		$this->data['estatus'] = $this->getEstatusSubPrograma(); 
		$this->data['rowsProgramas'] = $this->model->getProgramaActiveForYears($request->idy); 
		$this->data['id'] = $id;
		$this->data['idy'] = $request->idy;
		return view('subprograma.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = array('estatus' 	=> $request->input('estatus') ,
					'idanio'		=> $request->input('idy'),
					'idprograma'	=> $request->input('idprograma'),
					'numero'		=> trim($request->input('numero')),
					'descripcion'	=> trim($request->input('descripcion')),
				);
		$id = $this->model->insertRow($data , $request->input('idsubprograma'));
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
			return Redirect::to('subprograma')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('subprograma')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}