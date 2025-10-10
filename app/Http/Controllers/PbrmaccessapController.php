<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrmaccessap;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class PbrmaccessapController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrmaccessap';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrmaccessap();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrmaccessap',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$this->data['rowData']	= $this->model->getYears();
		$this->data['access'] = $this->access;
		
		$idi = \Auth::user()->idinstituciones;
		$row = $this->model->getInstitucion(isset($request->idi) ? $request->idi : $idi);
		$this->data['rowsInstituciones'] = $this->model->getCatInstituciones();
		$this->data['rows'] = $row[0];
		return view('pbrmaccessap.index',$this->data);
	}	

	public function getShow(Request $request)
	{
		if($this->access['is_detail'] ==0) 
		return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		
		$idanio = $request->id;
		$idi = $request->idi;
		$module = 1;

		$this->data['idanio'] = $idanio;
		$this->data['anio'] = $request->year;
		$this->data['idi'] = $idi;
		$this->data['j'] = 1;

		foreach ($this->model->getAreasAP($idi) as $v) {
			$accesos = $this->model->getAccesosArea($v->ida, $idanio, $idi, $module);
			
			if(count($accesos) == 0){

				$tasks = array(
					'is_add'        => 1,
					'is_edit'       => 1,
					'is_remove'     => 1,
					'is_pdf'        => 1,
					'is_reverse'    => 1,
					'is_generate'   => 1,
				);
				$data = ["idarea" => $v->ida, "idanio" => $idanio, "idinstituciones" => $idi, "module" => $module, "accesos" => json_encode($tasks)];
				$this->model->getInsertTable($data, "ui_area_accesos");
			}
		}

		$this->data['rowsData'] = $this->getAccesosArea($idanio, $idi, $module);
		return view('pbrmaccessap.view',$this->data);	
	}
	private function getAccesosArea($idanio, $idi, $module){
		$data = [];
		foreach ($this->model->getAreasAP($idi) as $v) {
			$accesos = $this->model->getAccesosArea($v->ida, $idanio, $idi, $module);
			if(count($accesos) > 0){
				$tasks = json_decode($accesos[0]->accesos);
				$data[] = ["ida" => $v->ida, "area" => $v->area, "accesos" => $tasks];
			}
			
		}
		return $data;
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
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_area'); 
		}

		
		$this->data['id'] = $id;
		return view('pbrmaccessap.form',$this->data);
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			
			for ($i=0; $i < count($request->ida); $i++) { 
				$ida = $request->ida[$i];

				$tasks = array(
					'is_add'        => (isset($request->is_add[$ida]) ? 1 : 2),
					'is_edit'       => (isset($request->is_edit[$ida]) ? 1 : 2),
					'is_remove'     => (isset($request->is_remove[$ida]) ? 1 : 2),
					'is_pdf'        => (isset($request->is_pdf[$ida]) ? 1 : 2),
					'is_reverse'    => (isset($request->is_reverse[$ida]) ? 1 : 2),
					'is_generate'   => (isset($request->is_generate[$ida]) ? 1 : 2),
				);
				$data = ["accesos" => json_encode($tasks) ];
				$this->model->insertRow($data , $ida);
			}
			return Redirect::to('pbrmaccessap?return='.self::returnUrl())->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
		} else {

			return Redirect::to('pbrmaccessap/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
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
			return Redirect::to('pbrmaccessap')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('pbrmaccessap')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}