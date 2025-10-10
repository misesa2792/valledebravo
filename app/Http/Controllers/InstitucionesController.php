<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Instituciones;
use App\Models\Usuarios;
use App\Models\Access\Years;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 


class InstitucionesController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $info;	
	protected $access;	
	protected $usuarios;	
	public $module = 'instituciones';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Instituciones();
		$this->usuarios = new Usuarios();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'instituciones',
			'return'	=> self::returnUrl()
		);
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access']		= $this->access;
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view('instituciones.index',$this->data);
	}	
	public function postSearch( Request $request )
	{
		$totales = $this->model->getSearch(2,$request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1,$request) as $v) {
			$arr[] = array("id"=>$v->idmunicipios,
							"municipio"=>$v->descripcion,
							"no_municipio"=>$v->numero,
							"estatus"=>$v->active,
							"rowsInstituciones"=>$this->getRowsOrganismos($v->idmunicipios),
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['access'] = $this->access;
		return view($this->module.'.search',$this->data);
	}
	protected function getRowsOrganismos($idm){
		$data = array();
		foreach ($this->model->getOrganismos($idm) as $v) {
			$data[] = array("id"=> $v->id,
							"active"=>$v->active,
							"no_institucion"=>$v->no_institucion,
							"institucion"=>$v->institucion,
							"idtp"=>$v->idtipo_dependencias,
						);
		}
		return $data;
	}
	function getYears(Request $request, $id = null)
	{
		$this->data['idi'] = $id;
		return view('instituciones.years',$this->data);
	}	
	function getModule(Request $request, $id = null)
	{
		$this->data['idi'] = $id;
		return view('instituciones.module',$this->data);
	}	
	function getAddmodule(Request $r)
	{
		$this->data['idi'] = $r->idi;
		$this->data['no'] = $r->no;
		$this->data['years'] = $this->model->getYears();
		return view('instituciones.addmodule',$this->data);
	}	
	function getListmodules(Request $r)
	{
		$data = [];
		foreach ($this->getModuleInstitucion() as $v) {
			$data[] = ['no'=>$v['id'], 'module'=>$v['name'], 'rows'=>$this->model->getModulesInstituciones($r->idi,$v['id'])];
		}
		$response = ['rowData' => $data];
		return response()->json($response);
	}	
	function deleteYearmodule(Request $r)
	{
		$this->model->getDestroyTable("ui_module_anio","idmodule_anio",$r->id);
		$response = ['status' => 'ok', 'message' => 'Año eliminado correctamente!'];
		return response()->json($response);
	}
	function postSavemodule(Request $r)
	{
		$val = $this->model->getModuleID($r->idi, $r->idy, $r->module);
		if(count($val) > 0){
			$response = ['status' => 'error', 'message' => 'El año en el módulo ya existe!'];
			return response()->json($response);
		}
		$data = ['idanio' => $r->idy, 'module'=>$r->module, 'idinstituciones'=>$r->idi];
		$this->model->getInsertTable($data, 'ui_module_anio');
		$response = ['status' => 'ok', 'message' => 'Año agregado correctamente!'];
		return response()->json($response);
	}
	private function getModuleInstitucion(){
		$data[] = ['id'=>1,'name'=>'Presupuesto'];
		$data[] = ['id'=>2,'name'=>'Presupuesto Definitivo'];
		$data[] = ['id'=>3,'name'=>'Proyecto'];
		$data[] = ['id'=>4,'name'=>'Anteproyecto'];
		$data[] = ['id'=>5,'name'=>'Metas/Indicadores'];
		return $data;
	}
	function getListyears(Request $r)
	{
		$rows = $this->model->getInstitucionesYears($r->idi);
		$response = ['rowData' => $rows];
		return response()->json($response);
	}	
	function getEdityear(Request $r)
	{
		$row = $this->model->getInstitucionesYearsID($r->id);
		$this->data['row'] = $row[0];
		$this->data['id'] = $r->id;
		return view('instituciones.edityear',$this->data);
	}	
	function postSaveyears(Request $r)
	{
		$data = array('t_uippe'			=> $r->input('t_uippe'),
					't_tesoreria'		=> $r->input('t_tesoreria'),
					't_egresos'			=> $r->input('t_egresos'),
					't_prog_pres'		=> $r->input('t_prog_pres'),
					't_secretario'		=> $r->input('t_secretario'),
					'c_uippe'			=> $r->input('c_uippe'),
					'c_tesoreria'		=> $r->input('c_tesoreria'),
					'c_egresos'			=> $r->input('c_egresos'),
					'c_prog_pres'		=> $r->input('c_prog_pres'),
					'c_secretario'		=> $r->input('c_secretario'),
				);
		$id = $this->model->getUpdateTable($data , "ui_instituciones_info", "idinstituciones_info",$r->id);

		if(!is_null($r->file('logo_izq'))){
			$this->getInsertLogoMunicipios('logo_izq',$r->id,$r->no_institucion,$r->file('logo_izq'));
		}
		if(!is_null($r->file('logo_der'))){
			$this->getInsertLogoMunicipios('logo_der',$r->id,$r->no_institucion,$r->file('logo_der'));
		}

		$response = ["success"=>"ok"];
		return response()->json($response);
	}	
	function getUpdate(Request $request)
	{
		$this->data['row'] = $this->model->getColumnTable('ui_instituciones'); 
		$this->data['rowsOrganismos'] = $this->model->getCatTipoDependencias(); 
		$this->data['idm'] = $request->idm;
		return view('instituciones.form',$this->data);
	}	
	function postSave( Request $request)
	{
		$data = ["descripcion"		  => $request->descripcion, 
				"idmunicipios"		  => $request->idm,
				"denominacion"		  => $request->denominacion,
				"idtipo_dependencias" => $request->idtipo_dependencias,
				"active" 			  => 1
				];
		$id = $this->model->insertRow($data , $request->input('idinstituciones'));
		$response = ["status"=>"ok","message"=>"Organismo agregado correctamente!"];
		return response()->json($response);
	
	}	
	protected function getInsertLogoMunicipios($text,$id,$institucion,$file){
		$path = 'mass/images/logos/'.$institucion.'/';
		$destinationPath = './'.$path;
		\File::makeDirectory($destinationPath, 0777, true, true);
		$extension = $file->getClientOriginalExtension();
		$new_name_file = rand(5,100).time().'.'.$extension;
		$uploadSuccess = $file->move($destinationPath, $new_name_file);
		if($uploadSuccess)
			$this->model->getUpdateTable([$text => $path.$new_name_file],'ui_instituciones_info', 'idinstituciones_info', $id);
	}
	public function getUsers(Request $r)
	{
		$this->data['idi'] = $r->id; 
		$this->data['idtd'] = $r->idtd; 
		$this->data['pages'] = $this->getNoPaginacion(); 
		$this->data['rowsNivel'] = $this->usuarios->getGruposUser();
		return view('usuarios.index',$this->data);	
	}	

	function getNewmodule(Request $request, $id = null)
	{
		$this->data['idi'] = $id;
		return view('instituciones.newmodule',$this->data);
	}
	function getListnewmodule(Request $r)
	{
		$data = [];
		foreach ($this->model->getModules() as $v) {
			$data[] = ['no'=>$v->idmodule, 
					'module'=>$v->descripcion, 
					'rows'=>$this->model->getModuleNewInstituciones($r->idi, $v->idmodule)];
		}
		$response = ['rowData' => $data];
		return response()->json($response);
	}
	function deleteYearnewmodule(Request $r)
	{
		$this->model->getDestroyTable("ui_anio_access","idanio_access",$r->id);
		$response = ['status' => 'ok', 'message' => 'Año eliminado correctamente!'];
		return response()->json($response);
	}	
	function getAddnewmodule(Request $r)
	{
		$this->data['idi'] = $r->idi;
		$this->data['no'] = $r->no;
		$this->data['years'] = $this->model->getYearsAll();
		return view('instituciones.addnewmodule',$this->data);
	}
	function postSavenewmodule(Request $r)
	{
		$data = ['idanio' => $r->idy, 
				'idmodule'=>$r->module, 
				'idinstituciones'=>$r->idi,
				'idanio_info' => $r->idanio_info];
		$this->model->getInsertTable($data, 'ui_anio_access');
		$response = ['status' => 'ok', 'message' => 'Año agregado correctamente!'];
		return response()->json($response);
	}
}