<?php namespace App\Http\Controllers\core;

use App\Http\Controllers\controller;
use App\Models\Core\Users;
use App\Models\Core\Groups;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,Response ; 


class UsersController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'users';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Users();
		$this->groups = new Groups();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'core/users',
			'return'	=> self::returnUrl()
			
		);
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['pages'] = $this->getNoPaginacion(); 
		$this->data['niveles']	= $this->model->getGrupos(); 
		$this->data['municipios'] = $this->model->getCatMunicipios(); 
		return view('core.users.index',$this->data);
	}	
	public function postSearch( Request $request )
	{
		$totales = $this->model->getSearch(2,$request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1,$request) as $v) {
			$arr[] = array("id"=>$v->id,
							"active"=>$v->active,
							"group_id"=>$v->group_id,
							"nivel"=>$v->nivel,
							"name"=>$v->name." ".$v->ap." ".$v->am,
							"email"=>$v->email,
							"no_institucion"=>$v->no_institucion,
							"institucion"=>$v->institucion,
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['access'] = $this->access;
		return view('core.users.search',$this->data);
	}


	function getUpdate(Request $request)
	{
		$id = $request->id;	
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			//Selecciono las institurciones
			$this->data['estatus'] = 'edit';
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
			$this->data['estatus'] = 'new';
		}
		$this->data['instituciones'] =  $this->model->getInstituciones();
		$this->data['groups'] = $this->model->getGrupos();
		$this->data['id'] = $id;
		$this->data['j'] = 1;
		return view('core.users.form',$this->data);
	}
	function getInstituciones( Request $r)
	{
		return json_encode($this->model->getInstitucionesMunicipio($r->id));
	}
	function postSave( Request $request)
	{
		//Guardo los datos del usuario
		$array = array('username' =>$request->input('username') ,
					'first_name'=>$request->input('first_name'),
					'last_name'=>$request->input('last_name'),
					'email'=>$request->input('email'),
					'group_id'=>$request->input('group_id'),
					'active'=>$request->input('active'),
					'idinstituciones'=>$request->input('idinstitucion'),
					);
		$id = $this->model->insertRow($array , $request->input('id'));
		if(!empty($request->input('password'))){
			$arr = array('password'=> \Hash::make($request->input('password')) );
			$this->model->insertRow($arr , $id);
		}
		//Elimino la imagen
		if($request->input('id') != ''){
			if(!is_null($request->file('avatar'))){
				$row = $this->model->find($request->input('id'),['avatar']);
				$ruta = public_path("images/operadores/".$row->avatar);
				if (is_file($ruta)) {
					\File::delete($ruta);
				}
			} 
		} 

		//Inserción de avatar
		if(!is_null($request->file('avatar'))){
			$file = $request->file('avatar');
			$destinationPath = './images/operadores/';
			 \File::makeDirectory($destinationPath, 0777, true, true);
			$filename = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension(); //if you need extension of the file
			$new_name_file = time().'.'.$extension;
			$uploadSuccess = $request->file('avatar')->move($destinationPath, $new_name_file);
			if( $uploadSuccess ) {
				$this->model->insertRow(array('avatar' => $new_name_file), $id);
			}
		}
		$response = array("success"=>"ok");
		return json_encode($response);
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
			
			// redirect
			return Redirect::to('core/users')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('core/users')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}

	function getBlast()
	{
		$this->data = array(
			'groups'	=> Groups::all(),
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users'
		);	
		return view('core.users.blast',$this->data);		
	}

	function postDoblast( Request $request)
	{

		$rules = array(
			'subject'		=> 'required',
			'message'		=> 'required|min:10',
			'groups'		=> 'required',				
		);	
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{	

			if(!is_null($request->input('groups')))
			{
				$groups = $request->input('groups');
				for($i=0; $i<count($groups); $i++)
				{
					if($request->input('uStatus') == 'all')
					{
						$users = \DB::table('tb_users')->where('group_id','=',$groups[$i])->get();
					} else {
						$users = \DB::table('tb_users')->where('active','=',$request->input('uStatus'))->where('group_id','=',$groups[$i])->get();
					}
					$count = 0;
					foreach($users as $row)
					{

						$to = $row->email;
						$subject = $request->input('subject');
						$message = $request->input('message');
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: '.CNF_APPNAME.' <'.CNF_EMAIL.'>' . "\r\n";
							mail($to, $subject, $message, $headers);
						
						$count = ++$count;					
					} 
					
				}
				return Redirect::to('core/users/blast')->with('messagetext','Total '.$count.' Message has been sent')->with('msgstatus','success');

			}
			return Redirect::to('core/users/blast')->with('messagetext','No Message has been sent')->with('msgstatus','info');
			

		} else {

			return Redirect::to('core/users/blast')->with('messagetext', 'The following errors occurred')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	

	}



}