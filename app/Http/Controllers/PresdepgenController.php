<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presdepgen;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class PresdepgenController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presdepgen';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presdepgen();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presdepgen',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('presdepgen.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
		return view('presdepgen.principal',$this->data);
	}
	public function getData(Request $r)
	{
		$idi = \Auth::user()->idinstituciones;
		$gp = \Auth::user()->group_id;
		if($gp == 1 || $gp == 8){
		}
		$rows = $this->getRowsAreasAdmin($idi,$r->idyear);
		$result = [
					'rowsData'   => $rows['data'],
					'rowsPres' => $rows['rowsPres'],
					'rowsProy' => $rows['rowsProy'],
					'rowsAnte' => $rows['rowsAnte']
		];
    	return response()->json($result);
	}
	private function getRowsAreasAdmin($idi,$idyear){
		$data = array();
		if($idyear >= 3){
			$pres = $this->getDataTotalPresDef($this->model->getTotalPresDefinitivoNew($idyear));
		}else{
			$pres = $this->getDataTotalPresDef($this->model->getTotalPresDefinitivo($idyear));
		}
		$proy = $this->getDataTotalPresDef($this->model->getTotalProyecto($idyear));
		$ante = $this->getDataTotalPresDef($this->model->getTotalAnteProyecto($idyear));
		$presupuesto = $uippe = 0;
		$generalProy = $generalProyUippe = 0;
		$generalAnte = $generalAnteUippe = 0;
		foreach ($this->model->getAreasGeneralPresupuesto($idi,$idyear) as $v) {
			$pres_uippe = isset($pres[$v->ida]) ? $pres[$v->ida] : 0;
			$pres_restante = $v->presupuesto - $pres_uippe;

			$proy_uippe = isset($proy[$v->ida]) ? $proy[$v->ida] : 0;
			$proy_restante = $v->proyecto - $proy_uippe;

			$ante_uippe = isset($ante[$v->ida]) ? $ante[$v->ida] : 0;
			$ante_restante = $v->anteproyecto - $ante_uippe;
			
			$data[] = array("id"			=> $v->id,
							"no_dep_gen"	=> $v->no_dep_gen,
							"dep_gen"		=> $v->dep_gen,
							"estatus"		=> $v->estatus,
							"pres"			=> [
												"presupuesto"	=> number_format($v->presupuesto,2),
												"uippe"    		=> number_format($pres_uippe,2),
												"restante"		=> number_format($pres_restante,2)
							],
							"proy"			=> [
												"presupuesto"	=> number_format($v->proyecto,2),
												"uippe"    		=> number_format($proy_uippe,2),
												"restante"		=> number_format($proy_restante,2)
											],
							"ante"			=> [
												"presupuesto"	=> number_format($v->anteproyecto,2),
												"uippe"    		=> number_format($ante_uippe,2),
												"restante"		=> number_format($ante_restante,2)
											]
						);
			$presupuesto += $v->presupuesto;
			$uippe += $pres_uippe;
			//Proyecto
			$generalProy += $v->proyecto;
			$generalProyUippe += $proy_uippe;
			//Anteproyecto
			$generalAnte += $v->anteproyecto;
			$generalAnteUippe += $ante_uippe;
		}
		return array("data" => $data, 
					"rowsPres" => [
						"presupuesto" => number_format($presupuesto,2), 
						"uippe" => number_format($uippe,2), 
						"restante" => number_format($presupuesto - $uippe,2)
					],
					"rowsProy" => [
						"presupuesto" => number_format($generalProy,2), 
						"uippe" => number_format($generalProyUippe,2), 
						"restante" => number_format($generalProy - $generalProyUippe,2)
					],
					"rowsAnte" => [
						"presupuesto" => number_format($generalAnte,2), 
						"uippe" => number_format($generalAnteUippe,2), 
						"restante" => number_format($generalAnte - $generalAnteUippe,2)
					]
				
				);
	}
	private function getDataTotalPresDef($rows){
		$data = [];
		foreach ($rows as $v) {
			$data[$v->idarea] = $v->presupuesto;
		}
		return $data;
	}
	public function getSync(Request $r){
		foreach ($this->model->getDepGenActivas(1, $r->idyear) as $v) {
			$row = $this->model->getValidarReg($r->idyear, $v->ida);
			if(count($row) == 0){
				$data = ["idarea" => $v->ida, "idanio" => $r->idyear];
				$this->model->insertRow($data, 0);
			}
		}
    	return response()->json(array("response" => "ok"));
	}
	function getAdd(Request $r)
	{
		$row = $this->model->getAreasGeneralPresID($r->id);
		$this->data['row'] = $row[0];
		$pres = 0;
		if($r->modulo == 1){
			$pres = empty($row[0]->anteproyecto) ? $row[0]->anteproyecto : $row[0]->anteproyecto;
		}else if($r->modulo == 2){
			$pres = empty($row[0]->proyecto) ? $row[0]->proyecto : $row[0]->proyecto;
		}else if($r->modulo == 3){
			$pres = empty($row[0]->presupuesto) ? $row[0]->presupuesto : $row[0]->presupuesto;
		}
		$this->data['pres'] = $pres;
		$this->data['modulo'] = $r->modulo;
		return view('presdepgen.form',$this->data);
	}	
	function postSavepres( Request $r){
		$pres = $this->getClearNumber($r->presupuesto);
		if($r->modulo == 1){
			$data = array("anteproyecto" => $pres);
		}else if($r->modulo == 2){
			$data = array("proyecto" => $pres);
		}else if($r->modulo == 3){
			$data = array("presupuesto" => $pres);
		}
		$this->model->insertRow($data , $r->id);
    	return response()->json(array("response" => "ok"));
	}	

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_teso_dep_gen'); 
		}
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('presdepgen.view',$this->data);	
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_presdepgen');
			
			$id = $this->model->insertRow($data , $request->input('idteso_dep_gen'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'presdepgen/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'presdepgen?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('idteso_dep_gen') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('presdepgen/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('presdepgen')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('presdepgen')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}