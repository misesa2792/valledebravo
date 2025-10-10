<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Seguimientoproyectos;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 

use App\Services\GeneralService;
use App\Services\Presupuesto\SeguimientoService;

class SeguimientoproyectosController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'seguimientoproyectos';
	static $per_page	= '10';

	protected $genService;
	protected $seguimientoService;

	public function __construct(SeguimientoService $seguimientoService)
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Seguimientoproyectos();
		$this->genService = new GeneralService();
		$this->seguimientoService = $seguimientoService;
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'seguimientoproyectos',
			'return'	=> self::returnUrl()
		);
	}

	public function getIndex( Request $request )
	{
		return $this->seguimientoService->index($request);
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('seguimientoproyectos.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		return $this->seguimientoService->principal($request);

		$this->data['rowsDepGen'] = $this->model->getCatDepGeneralNew(1, $request->idy);
		$this->data['pages']	= $this->getNoPaginacion(); 
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
		return view('seguimientoproyectos.principal',$this->data);
	}
	public function postSearch( Request $request )
	{
		return $this->seguimientoService->search($request);

		$idi = \Auth::user()->idinstituciones;
		$totales = $this->model->getSearch(2, $request, $idi);
		$this->data['j'] = ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request, $idi) as $v) {
			$arr[] = array("idp"=>$v->idp,
							"anio"=>$v->anio,
							"no_proyecto"=>$v->no_proyecto,
							"proyecto"=>$v->proyecto,
							"no_dep_gen"=>$v->no_dep_gen,
							"dep_gen"=>$v->dep_gen,
							"no_dep_aux"=>$v->no_dep_aux,
							"dep_aux"=>$v->dep_aux,
							"totales" => $this->genService->getSesTotalesProyecto($v->presupuesto, $request->idanio, $v->iddep_aux, $v->idp, 0,2)
						);
		}
		$this->data['rows']	= json_encode($arr);
		return view($this->module.'.search',$this->data);
	}
	

}