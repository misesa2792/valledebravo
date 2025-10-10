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
							"rowsAccess" => $this->model->getAcccessUserDepGen($v->id)
						);
		}
		$this->data['instituciones'] = $this->model->getCatInstituciones();
		$this->data['rows']	= json_encode($arr);
		$this->data['idtd']	= $request->idtd;
		return view($this->module.'.search',$this->data);
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
			$existenRegistros = \DB::table('ui_user_area')
				->where('iduser', $r->idu)
				->exists();
			if ($existenRegistros) {
				// Eliminar registros existentes
				\DB::table('ui_user_area')
					->where('iduser', $r->idu)
					->delete();
			}
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
		if(!is_null($request->file('avatar'))){
			$this->getInsertAvatarUser($id,$request->file('avatar'));
		}
		$response = ["success"=>"ok"];
		return response()->json($response);
	}

	/*public function getMunicipio(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$ins = $this->model->getInstitucion($decoder['idi']);
			$this->data['pages']	= $this->getNoPaginacion(); 
			$this->data['access'] = $this->access;
			$this->data['ins'] = $ins[0];
			$this->data['token'] = $r->k;//Está encriptado el idmunicipio (idm) y idinstitución (idi)
			$this->data['areas'] = $this->model->getCatDepGeneral($decoder['idi']); 
			$this->data['rowsNivel'] = $this->model->getGruposUser();
			return view('usuarios.view',$this->data);	
		}else{
			return view('errors.414');
		}
	}*/
	/*private function getRowsAccessMunicipios($rows = array()){
		$data = array();
		foreach ($rows as $v) {
			$data[] = array("id"=>$v->idmunicipios, 
							"no"=>$v->numero,
							"name"=>$v->descripcion,
							"rowsInstituciones"=>$this->getRowsDepAux($this->model->getCatInstitucionesMunicipio($v->idmunicipios)),
						);
		}
		return $data;
	}
	private function getRowsDepAux($rows = array()){
		$data = array();
		foreach ($rows as $v) {
			$data[] = array("token"=>SiteHelpers::CF_encode_json(array('time'=>time(),'idm'=>$v->idmunicipios,'idi'=>$v->idinstituciones)), 
							"institucion"=>$v->descripcion);
		}
		return $data;
	}*/
	
	/*protected function getPermisosDependenciasUsuarios($iduser){
		$data = array();
		foreach ($this->model->getDepGenPerUserGroupByArea($iduser) as $u) {
			$data[] = array("id"=>$u->id,
						"dep_gen"=>$u->dep_gen,
						"no_dep_gen"=>$u->no_dep_gen,
						"rows_dep_auxs"=>$this->model->getDepAuxPerUserPerArea($iduser,$u->id)
					);
		}
		return $data;
	}*/
	public function getDatauser(Request $r){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$row = $this->model->getOperador($decoder['idu']);
			$avatar = $this->model->getAvatarUser("images/operadores/".$row[0]->avatar);
			$data = array("active" => $row[0]->active,
						"nombre" => $row[0]->nombre,
						"ap" => $row[0]->ap,
						"am" => $row[0]->am,
						"email" => $row[0]->email,
						"mun" => $row[0]->municipio,
						"nivel" => $row[0]->nivel,
						"institucion" => $row[0]->institucion,
						"avatar" => asset($avatar),
						"deps" =>  $this->getRowsYears($decoder['idu'])
						);

			return json_encode($data);
		}
	}
	private function getRowsYears($idu){
		$data = [];
		foreach ($this->model->getCatGenAnios() as $v) {
			if($v->idanio != 3 && $v->idanio != 1){
				$data[] = ['idy' 		 => $v->idanio, 
							'year' 		 => $v->anio,
							'rowsdepgen' => $this->getRowsDepGen($idu, $v->idanio)
						];
			}
		}
		return $data;
	}
	private function getRowsDepGen($idu, $idy){
		$data = [];
		foreach ($this->model->getUserAreasCoordinacionesAccess($idu, $idy) as $v) {
			$data[] = ['no_dep_gen' 	=> $v->no_dep_gen, 
						'dep_gen' 	 	=> $v->dep_gen,
						'no_dep_aux' 	=> $v->no_dep_aux,
						'dep_aux' 		=> $v->dep_aux
					];
		}
		return $data;
	}
	function getVista(Request $r)
	{
		$idi = \Auth::user()->idinstituciones;
		//Institución
		$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($idi);
		//Variables
		$this->data['token'] 	= $r->k;//idu, idm, idi
		$this->data['rowsAnios'] = $this->model->getCatGenAnios(); 
		return view('usuarios.vista',$this->data);
	}
	/*
	 * 
	 * 	PERMISOS DEPENDENCIAS 
	 * 
	*/
	function getPermisosdep(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$idi = \Auth::user()->idinstituciones;
			$data = array();
			foreach ($this->model->getDependenciasForYears($idi, $r->idy) as $v) {
				$data[] = array("id"=>$v->id,
							"dep_gen"=>$v->dep_gen,
							"numero"=>$v->numero,
							"dep_aux"=>$this->model->getUserAreasCoordinaciones($v->id, $decoder['idu']),
						);
			}
			$this->data['k'] = $r->k;
			$this->data['idy'] = $r->idy;
			$this->data['rows'] = json_encode($data);
			return view('usuarios.permisosdep',$this->data);
		}
	}
	function postPermisosdep(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Elimino los que ya están registrados
			foreach ($this->model->getUserAreasCoordinacionesAccess($decoder['idu'], $r->idy) as $v) {
				$this->model->getDestroyTable("ui_user_coordinacion","iduser_coordinacion",$v->iduc);
			}
			//Insertó las nuevas dependencias
			for ($i=0; $i < count($r->permiso); $i++) { 
				$this->model->getInsertTable(array("iduser"=>$decoder['idu'],"idarea_coordinacion"=>$r->permiso[$i]), "ui_user_coordinacion");
			}
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	/*
	 * 
	 * 	INFORMACIÓN 
	 * 
	*/
	function getInformacion(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['row'] = $this->model->find($decoder['idu'],['id','username','first_name','last_name','email','password','avatar']);
			$this->data['k'] = $r->k;
			return view('usuarios.informacion',$this->data);
		}
	}
	function postInformacion( Request $request)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			//Elimino la imagen
			if(!is_null($request->file('avatar'))){
				$this->getDestroyAvatar($decoder['idu']);
			} 
			//Data
			$array = array('username' =>$request->input('username') ,
						'first_name'=>$request->input('first_name'),
						'last_name'=>$request->input('last_name'),
						'email'=>$request->input('email'));
			$this->model->insertRow($array , $decoder['idu']);
			//Cambio de contraseña
			if(!empty($request->input('password'))){
				$arr = array('password'=> \Hash::make($request->input('password')) );
				$this->model->insertRow($arr, $decoder['idu']);
			}
			//Verifico si exite la imagen
			if(!is_null($request->file('avatar'))){
				$this->getInsertAvatarUser($decoder['idu'], $request->file('avatar'));
			}
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	/*
	 * 
	 * 	ESTATUS 
	 * 
	*/
	function getEstatus(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['estatus'] = $this->getRowEstatus();
			$this->data['row'] = $this->model->find($decoder['idu'],['active']);
			$this->data['k'] = $r->k;
			//View
			return view('usuarios.estatus',$this->data);
		}
	}
	function postEstatus(Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->model->insertRow(array("active"=>$r->active), $decoder['idu']);
			$response = array("success"=>"ok","active"=>$r->active);
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
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
