<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Planpdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, Excel ; 


class PlanpdfController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'planpdf';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Planpdf();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'planpdf',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		return Redirect::to('planpdf/pdf');
	}	
	public function getPdf( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access']		= $this->access;
		$this->data['pages']	= $this->getNoPaginacion(); 
		$this->data['active'] =  1;
		return view('planpdf.pdf.index',$this->data);
	}	
	public function postPdfsearch( Request $request )
	{
		$totales = $this->model->getSearch(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request) as $v) {
			$arr[] = array("id"				=> $v->id,
							"no_ins"		=> $v->no_institucion,
							"ins"			=> $v->institucion,
							"number"		=> $v->number,
							"url"			=> $v->url,
							"size"			=> $v->size,
							"user"			=> $v->usuario,
							"std"			=> $v->std_delete,
							"fecha"			=> $v->fecha
						);
		}
		$this->data['rows']	= json_encode($arr);
		return view($this->module.'.pdf.search',$this->data);
	}
	public function deletePdf(Request $r){
		try {
			$row = $this->model->find($r->id, ['number','url','ext']);
			if(count($row) > 0){
				$url = $row->url.$row->number.'.'.$row->ext;
				$ruta = public_path($url);
				if (is_file($ruta)){
					\File::delete($ruta);
				}
				$this->model->destroy($r->id);
				$response = ["status"=>"ok", "message"=>"PDF eliminado correctamente!" ];
			}else{
				$response = ["status"=>"error", "message"=>"Error al buscar el ID!" ];
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error eliminar archivo: '.$e->getMessage());
			$response = ["status"=>"error", "message"=>"Error al eliminar ID!" ];
		}
		return response()->json($response);
	}

	public function getFiles( $id = null)
	{
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['active'] = 2;
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view('planpdf.files.index',$this->data);	
	}	
	public function getNavigation( $id = null)
	{
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['active'] = 3;
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view('planpdf.navigation.index',$this->data);	
	}	
	public function getUsers( $id = null)
	{
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['active'] = 4;
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view('planpdf.users.index',$this->data);	
	}	
	public function postFilesearch( Request $request )
	{
		$totales = $this->model->getSearchFile(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearchFile(1, $request) as $v) {
			if(strpos($v->url, "/2025/")){
				$arr[] = ["id"			=> $v->id,
							"url"		=> $v->url.$v->nombre.".".$v->ext,
							"nombre"    => $v->nombre,
							"size"		=> $v->size,
							"fecha"		=> $v->fecha_rg.' '.$v->hora_rg,
							"usuario"	=> $v->usuario
					];
			}else{
				$arr[] = ["id"			=> $v->id,
							"url"		=> $v->url,
							"nombre"    => $v->nombre,
							"size"		=> $v->size,
							"fecha"		=> $v->fecha_rg.' '.$v->hora_rg,
							"usuario"	=> $v->usuario
					];
			}
			
		}
		$this->data['rows']	= json_encode($arr);
		return view($this->module.'.files.search',$this->data);
	}
	public function postNavigationsearch( Request $request )
	{
		$totales = $this->model->getSearchNavigation(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearchNavigation(1, $request) as $v) {
				$arr[] = ["id"			=> $v->id,
							"url"		=> $v->url,
							"metodo"    => $v->metodo,
							"fecha"		=> $v->created_at,
							"usuario"	=> $v->usuario,
							"agent"		=> $v->user_agent,
							"ip"		=> $v->ip_address,
							"type"		=> $v->type
					];
		}
		$this->data['rows']	= json_encode($arr);
		return view($this->module.'.navigation.search',$this->data);
	}
	public function postUsersearch( Request $request )
	{
		$totales = $this->model->getSearchUsers(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearchUsers(1, $request) as $v) {
				$arr[] = ["id"			=> $v->id,
							"nivel"		=> $v->nivel,
							"usuario"	=> $v->usuario,
							"email"    	=> $v->email,
							"fecha"		=> $v->last_activity,
							"minutos"	=> $this->getCalcularTiempoInactivo($v->last_activity)
					];
		}
		$this->data['rows']	= json_encode($arr);
		return view($this->module.'.users.search',$this->data);
	}
	public function getCalcularTiempoInactivo($fechaInactividad) {
		$fechaActual = new \DateTime();
		$fechaUsuario = new \DateTime($fechaInactividad);
		// Validar si la fecha es futura (error en datos)
		if ($fechaUsuario > $fechaActual) {
			return "La fecha de inactividad es futura. Verifique los datos.";
		}
		$diferencia = $fechaActual->diff($fechaUsuario);
		// Extraer días, horas y minutos
		$dias = $diferencia->days;
		$horas = $diferencia->h;
		$minutos = $diferencia->i;
		// Construir mensaje según el tiempo
		if ($dias > 0) {
			return sprintf("%d día(s), %d hora(s) y %d minuto(s)",$dias, $horas, $minutos);
		} elseif ($horas > 0) {
			return sprintf("%d hora(s) y %d minuto(s)",$horas, $minutos);
		} else {
			return sprintf("%d minuto(s)",$minutos);
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
			return Redirect::to('planpdf')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('planpdf')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			
}