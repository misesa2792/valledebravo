<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Area;
use App\Models\Usuarios;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;

use App\Traits\JsonResponds;

class AreaController extends Controller {

    use JsonResponds;

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $access;	
	protected $user;	
	public $module = 'area';
	static $per_page	= '10';

	public function __construct()
	{
		$this->model = new Area();
		$this->user = new Usuarios();
		
		$info = $this->model->makeInfoSesmas($this->module);
		$this->access = $this->model->validAccess($info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note'],
			'pageModule'=> 'area'
		);
	}
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios(); 
		return view('area.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['pages']	= $this->getNoPaginacion(); 
		$this->data['rowsMunicipios'] = $this->model->getCatMunicipios(); 
		$this->data['rowsTipoDep'] = $this->model->getCatTipoDependencia(); 
		$this->data['rowsEstatus'] = $this->getDataEstatus();
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		return view('area.view',$this->data);	
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
					'ndgr' 	=> $row->no_dep_gen_rel,
					'ndg' 	=> $row->no_dep_gen,
					'dg' 	=> $row->dep_gen,
					'tl' 	=> $row->titular,
					'cg' 	=> $row->cargo
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
			$this->data['row'] = $this->model->getColumnTable('ui_area'); 
		}
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $request->id;
		$this->data['rowsEstatus'] = $this->getDataEstatus();
		$this->data['rowsDepGen'] = $this->model->getDepGen($request->idy, $request->idtd); 
		
		return view('area.form',$this->data);
	}	
	function getAdd(Request $request)
	{
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $request->id;
		$this->data['j'] = 1;
		$this->data['rowsDepGen'] = $this->model->getDepGen($request->idy, $request->id); 
		$this->data['rowsInstitucion'] = $this->model->getActiveInstitutions($request->id); 
		return view('area.add',$this->data);
	}
	private function getDataEstatus(){
		return ["1"=>"Activo","2"=>"Inactivo"];
	}
	function postAdd(Request $request){
		foreach ($this->model->getDepGen($request->idy, $request->idtd) as $v) {
			$data = ["idinstituciones" => $request->idi,
						"iddep_gen"  	=> $v->id,
						"numero"	   => $v->no_dep_gen,
						"descripcion"  => $v->dep_gen,
						"estatus"	   => 1,
						"idanio"	   => $request->idy,
						"titular"	   => null,
						"cargo"		   => null
					];
			$this->model->insertRow($data, null);
		}
		return $this->success('Dependencias agregadas correctamente');
	}
	function postSave(Request $r){
		$id = $r->id;
		$data = ["iddep_gen"	=> $r->iddep_gen,
				"descripcion"	=> $r->descripcion,
					"numero"	=> $r->numero,
					"estatus"	=> $r->estatus,
					"titular"	=> $r->titular,
					"cargo"		=> $r->cargo
				];
		$row = $this->model->find($id);

		if($row){
			$row->update($data);
			return $this->success('Datos actualizados correctamente');
		}
	}	
	public function deleteDepgen( Request $request)
	{
		$this->model->destroy($request->id);
        return $this->success('Dependencia eliminada correctamente');
	}			
}