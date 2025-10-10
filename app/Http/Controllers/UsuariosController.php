<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ;
use App\Models\Exportar;


class UsuariosController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	protected $model;
	protected $exportar;
	protected $info;
	protected $access;
	public $module = 'usuarios';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Usuarios();
		$this->exportar = new Exportar();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'usuarios',
			'return'	=> self::returnUrl()
		);
	}
	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['idi'] = \Auth::user()->idinstituciones;
		$this->data['pages']	= $this->getNoPaginacion(); 
		$this->data['rowsNivel'] = $this->model->getGruposUser();
		return view('usuarios.index',$this->data);	
	}
	public function postSearch( Request $request )
	{
		$idi = $request->idi;
		$totales = $this->model->getSearch(2, $request, $idi);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request, $idi) as $v) {
			$arr[] = array("id"=>$v->id,
							"id_token"=>SiteHelpers::CF_encode_json(['idu'=>$v->id]),
							"active"=>$v->active,
							"nivel"=>$v->nivel,
							"name"=>$v->nombre_completo,
							"email"=>$v->email,
							"institucion"=>$v->institucion,
							"rowsAccess" => $this->getAccessDepGen($v->id)
						);
		}
		$this->data['instituciones'] = $this->model->getCatInstituciones();
		$this->data['rows']	= json_encode($arr);
		$this->data['idtd']	= $request->idtd;
		return view($this->module.'.search',$this->data);
	}
	public function deleteDepgen( Request $request )
	{
		$this->model->getDestroyTable("ui_user_area","iduser_area",$request->id);
		$response = ['status' => 'ok', 'message' => 'Permiso eliminado correctamente'];
		return response()->json($response);
	}
	private function getAccessDepGen($id){
		$data = [];
		foreach ($this->model->getAcccessUserDepGen($id) as $v) {
			$dep_aux = [];
			if($v->dep_aux != null){
				$dep_aux = json_decode($v->dep_aux);
				$permisos = implode(',', $dep_aux);
				$dep_aux = $this->model->getDepAuxView($permisos);
			}
			$data[] =["id" => $v->id, 
					"no_dep_gen" => $v->no_dep_gen,
					"dep_gen" => $v->dep_gen,
					"dep_aux" => $dep_aux];
		}
		return $data;
	}

	function getUpdate(Request $r)
	{
		$this->data['rowsNivel'] = $this->model->getGruposUser();
		return view('usuarios.form',$this->data);
	}
	function getAccesos(Request $r)
	{
		$data = $this->getRowsGepGenAccess($r->idtd);
		$accesos = $this->getRowsGepGenUser($r->id);
		$arr = [];
		foreach ($data as $key => $v) {
			$arr[] = ['id' => $v['id'], 
						'no' => $key, 
						'na' => $v['dep'], 
						'std' => array_key_exists($key, $accesos) ];
		}
		$this->data['rows'] = $arr;
		$this->data['idu'] = $r->id;
		return view('usuarios.accesos',$this->data);
	}
	function getAccesosaux(Request $r)
	{
		$rows = $this->model->getDepAuxPorDepGen(\Auth::user()->idinstituciones, $r->da);
		$this->data['rows'] = $rows;
		$this->data['accesos'] = $this->getPermisosAuxiliar($r->id);
		$this->data['id'] = $r->id;
		return view('usuarios.accesosaux',$this->data);
	}
	private function getPermisosAuxiliar($id){
		$data = [];
		$row = $this->model->getPermisoAux($id);
		if($row){
			if($row->dep_aux != null){
				foreach (json_decode($row->dep_aux) as $v) {
					$data[$v] = true;
				}
			}
		}
		return $data;
	}
	private function getRowsGepGenUser($idu){
		$data = [];
		foreach ($this->model->getAcccessUserDepGen($idu) as $v) {
			$data[$v->no_dep_gen] = $v->dep_gen;
		}
		return $data;
	}
	private function getRowsGepGenAccess($idtd){
		$data = [];
		foreach ($this->model->getDepGen($idtd) as $v) {
			$data[$v->no_dep_gen] = ['id' => $v->id,'dep' => $v->dep_gen];
		}
		return $data;
	}
	function postSaveaccesos(Request $r)
	{
		// Validar que el iduser esté presente
		if (empty($r->idu)) {
			return response()->json(["status" => "error", "message" => "El ID de usuario es requerido."]);
		}
		// Validar que los permisos sean un array y no estén vacíos
		if (empty($r->permiso) || !is_array($r->permiso)) {
			return response()->json(["status" => "error", "message" => "Los permisos son requeridos y deben ser un array."]);
		}
		// Iniciar una transacción
		\DB::beginTransaction();
		try {
			// Verificar si hay registros para eliminar
			/*$existenRegistros = \DB::table('ui_user_area')
				->where('iduser', $r->idu)
				->exists();
			if ($existenRegistros) {
				// Eliminar registros existentes
				\DB::table('ui_user_area')
					->where('iduser', $r->idu)
					->delete();
			}
			
			*/
			// Preparar datos para la inserción
			$data = [];
			foreach ($r->permiso as $v) {
				$data[] = ['iduser' => $r->idu, 'iddep_gen' => $v];
			}
			// Insertar nuevos registros
			if (count($data) > 0) {
				$this->model->getInsertTableData($data, "ui_user_area");
			}
			// Confirmar la transacción
			\DB::commit();
			// Respuesta exitosa
			$response = ["status" => "ok", "message" => "Permisos actualizados correctamente!"];
			return response()->json($response);
		} catch (\Exception $e) {
			// Revertir la transacción en caso de error
			\DB::rollBack();
			// Respuesta de error
			$response = ["status" => "error", "message" => "Ocurrió un error al actualizar los permisos: " . $e->getMessage()];
			return response()->json($response);
		}
	}
	function postSaveaccesosaux(Request $r)
	{
		// Validar que el iduser esté presente
		if (empty($r->id)) {
			return response()->json(["status" => "error", "message" => "El ID es requerido."]);
		}
		// Iniciar una transacción
		\DB::beginTransaction();
		try {
			if(count($r->permiso) > 0){
				$data = [];
				foreach ($r->permiso as $v) {
					$data[] = $v;
				}
				$dep_aux = json_encode($data);
			}else{
				$dep_aux = null;
			}
			$this->model->getUpdateTable(['dep_aux' => $dep_aux], "ui_user_area", "iduser_area", $r->id);
			// Confirmar la transacción
			\DB::commit();
			// Respuesta exitosa
			$response = ["status" => "ok", "message" => "Permisos actualizados correctamente!"];
			return response()->json($response);
		} catch (\Exception $e) {
			// Revertir la transacción en caso de error
			\DB::rollBack();
			// Respuesta de error
			$response = ["status" => "error", "message" => "Ocurrió un error al actualizar los permisos: " . $e->getMessage()];
			return response()->json($response);
		}
	}
	function postSave(Request $request)
	{
		$validar_correo = $this->model->getValidarCorreo($request->input('email'));
		if(count($validar_correo) > 0){
			$response = ["success"=>"duplicate"];
			return response()->json($response);
		}
		$array = array('username' 		=> $request->input('username') ,
					'first_name'		=> $request->input('first_name'),
					'last_name'			=> $request->input('last_name'),
					'email'				=> $request->input('email'),
					'group_id'			=> $request->input('group_id'),
					'active'			=> 1,
					'idinstituciones'	=> \Auth::user()->idinstituciones,
					'password'			=> \Hash::make($request->input('password'))
				);
		$id = $this->model->insertRow($array, 0);
		//Inserto la imagen del usuario
		/*if(!is_null($request->file('avatar'))){
			$this->getInsertAvatarUser($id,$request->file('avatar'));
		}*/
		$response = ["success"=>"ok"];
		return response()->json($response);
	}
	function getInformacion(Request $r)
	{
		$this->data['row'] = $this->model->find($r->id,['id','username','first_name','last_name','email','password','avatar']);
		$this->data['id'] = $r->id;
		return view('usuarios.informacion',$this->data);
	}
	function postInformacion( Request $request)
	{
		$array = array('username' =>$request->input('username') ,
					'first_name'=>$request->input('first_name'),
					'last_name'=>$request->input('last_name'),
					'email'=>$request->input('email'));
		$this->model->insertRow($array , $request->id);
		//Cambio de contraseña
		if(!empty($request->input('password'))){
			$arr = array('password'=> \Hash::make($request->input('password')) );
			$this->model->insertRow($arr, $request->id);
		}
		$response = ['status' => 'ok', 'message' => 'Usuario editado correctamente'];
		return response()->json($response);
	}
	/*
	 * 
	 * 	ESTATUS 
	 * 
	*/
	function getEstatus(Request $request)
	{
		$this->data['estatus'] = $this->getRowEstatus();
		$this->data['row'] = $this->model->find($request->id,['active']);
		$this->data['id'] = $request->id;
		return view('usuarios.estatus',$this->data);
	}
	function postEstatus(Request $request)
	{
		$this->model->insertRow(["active"=>$request->active, 'remember_token' => null], $request->id);
		$response = ['status' => 'ok', 'message' => 'Estatus cambiado correctamente'];
		return response()->json($response);
	}
	/*
	 * 
	 * 	CONSTANTES 
	 * 
	*/
	protected function getRowEstatus(){
		return array("0"=>"Inactivo","1"=>"Activo");
	}
	protected function getDestroyAvatar($idu){
		$row = $this->model->find($idu,['avatar']);
		$ruta = public_path("images/operadores/".$row->avatar);
		if (is_file($ruta))
			\File::delete($ruta);
	}
	protected function getInsertAvatarUser($id,$file){
		$destinationPath = './images/operadores/';
		\File::makeDirectory($destinationPath, 0777, true, true);
		$filename = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();
		$new_name_file = time().'.'.$extension;
		$uploadSuccess = $file->move($destinationPath, $new_name_file);
		if( $uploadSuccess ) {
			$this->model->insertRow(array('avatar' => $new_name_file) , $id);
		}
	}
	

}
