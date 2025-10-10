<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Estructuraprogramatica;
use App\Models\Finalidad;
use App\Models\Funcion;
use App\Models\Subfuncion;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class EstructuraprogramaticaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'estructuraprogramatica';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Estructuraprogramatica();
		$this->finalidad = new Finalidad();
		$this->funcion = new Funcion();
		$this->subfuncion = new Subfuncion();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'estructuraprogramatica',
			'return'	=> self::returnUrl()
		);
	}
	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		return view('estructuraprogramatica.finalidad.index',$this->data);
	}
	public function getAgregarfin( Request $r )
	{
		$row = $this->finalidad->find($r->idfinalidad);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_finalidad'); 
		}
		return view('estructuraprogramatica.finalidad.form',$this->data);
	}
	public function getSearchfin( Request $r )
	{
		$this->data['rows'] = $this->model->getFinalidad();
		return view('estructuraprogramatica.finalidad.view',$this->data);
	}	
	public function postSavefin( Request $r )
	{
		$data = array("numero"=>$r->numero,"descripcion"=>$r->descripcion);
		$this->finalidad->insertRow($data,$r->idfinalidad);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroyfin( Request $r )
	{
		$this->finalidad->destroy($r->params['idf']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	/*
	*FUNCION
	*/
	public function getFuncion( Request $r )
	{
		$this->data['row'] = $this->finalidad->find($r->idfinalidad,['idfinalidad','numero','descripcion']);
		$this->data['rows'] = $this->model->getFuncion($r->idfinalidad);
		$this->data['idfinalidad'] = $r->idfinalidad;
		return view('estructuraprogramatica.funcion.index',$this->data);
	}	
	public function getSearchfun( Request $r )
	{
		$this->data['rows'] = $this->model->getFuncion($r->idfinalidad);
		$this->data['idfinalidad'] = $r->idfinalidad;
		return view('estructuraprogramatica.funcion.view',$this->data);
	}	
	public function getAgregarfun( Request $r )
	{
		$row = $this->funcion->find($r->idfuncion);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_funcion'); 
		}
		$this->data['idfinalidad'] = $r->idfinalidad;
		return view('estructuraprogramatica.funcion.form',$this->data);
	}
	public function postSavefun( Request $r )
	{
		$data = array("idfinalidad"=>$r->idfinalidad,"numero"=>$r->numero,"descripcion"=>$r->descripcion);
		$this->funcion->insertRow($data,$r->idfuncion);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroyfun( Request $r )
	{
		$this->funcion->destroy($r->params['idf']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	/*
	*SUBFUNCION
	*/
	public function getSubfuncion( Request $r )
	{
		$row = $this->model->getFinalidadFuncion($r->idfuncion);
		$this->data['row'] =  $row[0];
		$this->data['idfinalidad'] =  $r->idfinalidad;
		$this->data['idfuncion'] =  $r->idfuncion;
		return view('estructuraprogramatica.subfuncion.index',$this->data);
	}	
	public function getSearchsubfun( Request $r )
	{
		$this->data['rows'] = $this->model->getSubFuncion($r->idfuncion);
		$this->data['idfuncion'] = $r->idfuncion;
		$this->data['idfinalidad'] = $r->idfinalidad;
		return view('estructuraprogramatica.subfuncion.view',$this->data);
	}
	public function getAgregarsubfun( Request $r )
	{
		$row = $this->subfuncion->find($r->ids);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_subfuncion'); 
		}
		$this->data['idfuncion'] = $r->idfuncion;
		return view('estructuraprogramatica.subfuncion.form',$this->data);
	}
	public function postSavesubfun( Request $r )
	{
		$data = array("idfuncion"=>$r->idfuncion,"numero"=>$r->numero,"descripcion"=>$r->descripcion);
		$this->subfuncion->insertRow($data,$r->idsubfuncion);
		$response = array("success"=>"ok");
		return json_encode($response);
	}	
	public function postDestroysubfun( Request $r )
	{
		$this->subfuncion->destroy($r->params['ids']);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
}