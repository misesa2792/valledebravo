<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Catalogos\Depgen;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

use App\Traits\JsonResponds;

class DepgenController extends Controller {

    use JsonResponds;

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $access;	
	public $module = 'depgen';
	static $per_page	= '10';

	public function __construct()
	{
		$this->model = new Depgen();

		$info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note'],
			'pageModule'=> 'depgen'
		);
	}

	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios(); 
		return view($this->module.'.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$idi = Auth::user()->idinstituciones;
		$ins = $this->model->getInstitucion($idi);
		$this->data['ins'] = $ins[0];
		$this->data['pages'] = $this->getNoPaginacion(); 
		$this->data['rowsTipo'] = $this->model->getCatTipoDependencia(); 
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		return view($this->module.'.view',$this->data);	
	}
	public function postSearch( Request $request )
	{
		$rows = $this->model->getSearch($request->all());
		// Agrega/transforma campos en cada item de la página actual
		$rows->getCollection()->transform(function ($row) {
			$data = ['id' 	=> $row->id,
					'ab' 	=> $row->abreviatura,
					'ndg' 	=> $row->no_dep_gen,
					'dg' 	=> $row->dep_gen 
					];
			return $data;
		});
		$this->data['j'] = ($request->page * $request->nopagina)- $request->nopagina;
		$this->data['pagination'] = $rows;
		$this->data['access'] = $this->access;
		$this->data['idy'] = $request->idy;
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
			$this->data['row'] = $this->model->getColumnTable('ui_dep_gen'); 
		}
		$this->data['rowsTipo'] = $this->model->getCatTipoDependencia(); 
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $id;
		return view($this->module.'.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = [
				'idtipo_dependencias'   => $request->idtipo_dependencias,
				'idanio'   				=> $request->idanio,
				'numero'            	=> $request->numero,
				'descripcion'  	 		=> $request->descripcion,
			];

		$id = empty($request->iddep_gen) ? 0 : $request->iddep_gen;

        $row = $this->model->find($id);
		if($row){
        	$row->update($data);
       		return $this->success('Datos actualizados correctamente');
		}

		$this->model->insertRow($data,0);
       	return $this->success('Datos guardados correctamente');
	}	

	public function deleteRegistro( Request $request)
	{
		$this->model->destroy($request->id);
       	return $this->success('Dependencia eliminada correctamente');
	}			


}