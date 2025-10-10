<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Coordinaciones;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;

use App\Traits\JsonResponds;

class CoordinacionesController extends Controller {
    
	use JsonResponds;

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $access;
	protected $model;
	public $module = 'coordinaciones';
	static $per_page	= '10';

	public function __construct()
	{
		$this->model = new Coordinaciones();
		$info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($info['id']);
		$this->data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note'],
			'pageModule'=> 'coordinaciones'
		);
	}
	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios(); 
		return view('coordinaciones.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['pages']	= $this->getNoPaginacion(); 
		$idi = \Auth::user()->idinstituciones;
		$this->data['rowsDepGen'] = $this->model->getCatDepGeneralNew($idi,$request->idy);
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		$this->data['rowsMunicipios'] = $this->model->getCatMunicipios(); 
		$this->data['rowsTipoDep'] = $this->model->getCatTipoDependencia(); 
		return view('coordinaciones.view',$this->data);
	}	
	public function postSearch( Request $request )
	{
		$rows = $this->model->getSearch($request->all());
		// Agrega/transforma campos en cada item de la página actual
		$rows->getCollection()->transform(function ($row) {
			$data = ['id' 	=> $row->id,
					'idtd' 	=> $row->idtd,
					'std' 	=> $row->estatus,
					'mun' 	=> $row->municipio,
					'abr' 	=> $row->abreviatura,
					'noi' 	=> $row->no_institucion,
					'ins' 	=> $row->institucion,
					'ndg' 	=> $row->no_dep_gen,
					'dg' 	=> $row->dep_gen,
					'rows'  => $this->model->getDepAuxRel($row->id)
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
		$this->data['rowsDepAux'] = $this->model->getDepAux($request->idy, $request->idtd); 
		$this->data['idarea'] = $request->id;
		$this->data['depaux'] = $this->getDataDepAux($request->id);
		return view('coordinaciones.form',$this->data);
	}	
	private function getDataDepAux($id){
		$data = [];
		foreach ($this->model->getDepAuxRel($id) as $v) {
			$data[] = $v->iddep_aux;
		}
		return $data;
	}
	function postSave( Request $request)
	{
		if(!isset($request->ids)){
			return $this->error('Selecciona mínimo una dependencia auxiliar');
		}

		foreach ($request->ids as $id) {
			$row = $this->model->getDepAuxID($id);
			$data = ["iddep_aux"	=>	$id,
					"idarea"		=>	$request->idarea,
					"numero"		=>	$row->no_dep_aux,
					"descripcion"	=>	$row->dep_aux
					];
			$this->model->insertRow($data , null);
		}
		return $this->success('Dependencia agregadas correctamente');
	}	
	public function deleteDepaux( Request $request)
	{
		$this->model->destroy($request->id);
		return $this->success('Dependencia eliminada correctamente');
	}		


}