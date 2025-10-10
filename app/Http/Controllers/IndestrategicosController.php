<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Indestrategicos;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, DB, Excel ; 
use Illuminate\Support\Facades\Redirect;

class IndestrategicosController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $info;	
	protected $access;	
	public $module = 'indestrategicos';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Indestrategicos();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'indestrategicos',
			'return'	=> self::returnUrl()
		);
	}
	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getCatGenAnios();
		return view('indestrategicos.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['access'] = $this->access;
		$this->data['idy']	= $request->idy; 
		$this->data['year']	= $request->year; 
		$this->data['pages']	= $this->getNoPaginacion(); 
		return view($this->module.'.principal',$this->data);
	}
	function getUpdate(Request $request, $id = null)
	{
		$id = $request->id;
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ui_ind_estrategicos'); 
		}
		$this->data['id'] = $id;
		$this->data['idy'] = $request->idy;
		$this->data['rowsProgramas'] = $this->model->getProgramas($request->idy); 
		$this->data['rowsIndicadores'] = $this->model->getVariables($id); 
		return view($this->module.'.form',$this->data);
	}
	public function deleteTr( Request $request )
	{
		$this->model->getDestroyTable('ui_ind_estrategicos_reg', 'idind_estrategicos_reg', $request->id);
		$response = ["status" => "ok", "message" => "Registro eliminado correctamente!"];
		return response()->json($response);

	}
	function getTr(Request $request)
	{
        $this->data['time'] = rand(5,9999).time();
		return view($this->module.'.tr',$this->data);
	}
	function postSave( Request $r)
	{
		try {
			DB::transaction(function () use ($r) {
				$data = ['idprograma' => $r->idprograma, 
						'idanio' => $r->idanio,
						'codigo' => $r->codigo,
						'indicador' => $r->indicador,
					 ];
				if($r->id == 0){
					$id = $this->model->getInsertTable($data,'ui_ind_estrategicos', 'idind_estrategicos');
				}else{
					$this->model->getUpdateTable($data,'ui_ind_estrategicos', 'idind_estrategicos', $r->id);
					$id = $r->id;
				}

				for ($i=0; $i < count($r->idreg); $i++) { 
					$variables = ['idind_estrategicos' => $id, 
								  'nombre_corto' => $r->nombre_corto[$i],
								  'nombre_largo' => $r->nombre_largo[$i],
								];
					if($r->idreg[$i] == 0){
						$this->model->getInsertTable($variables,'ui_ind_estrategicos_reg', 'idind_estrategicos_reg');
					}else{
						$this->model->getUpdateTable($variables,'ui_ind_estrategicos_reg', 'idind_estrategicos_reg', $r->idreg[$i]);
					}
				}
			});
			$response = ["status" => "ok", "message" => "Indicador agregado correctamente!"];
		} catch (\Exception $e) {
			// Si hay un error, retornar mensaje de error
			\SiteHelpers::auditTrail( $r , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al insertar indicador!"];
		}
		return response()->json($response);
	}
	public function postSearch( Request $request )
	{
		$totales = $this->model->getSearch(2, $request);
		$this->data['j']		= ($request->page * $request->nopagina)- $request->nopagina;
		$pagination = new Paginator(array(), $totales[0]->suma, $request->nopagina);
		$this->data['pagination']	= $pagination;
		$arr = array();
		foreach ($this->model->getSearch(1, $request) as $v) {
			$rows = $this->getRowsIndVariables($v->id);
			$ind = $this->model->getIndEstrategicoRelacion($v->id);
			$indicador = "";
			$no_rel = 2;
			if($ind){
				$indicador = $ind->indicador;
				$no_rel = 1;
			}
			$arr[] = array("id"				=> $v->id,
							"pro"			=> $v->programa,
							"mir"			=> $v->mir,
							"cod"			=> $v->codigo,
							"ind"			=> $v->indicador,
							"idrel"			=> $no_rel,
							"rel_indicador"	=> $indicador,
							"rows"			=> $rows
						);
		}
		$this->data['rows']	= json_encode($arr);
		$this->data['idy']	= $request->idy;
		return view($this->module.'.search',$this->data);
	}
	public function getRowsIndVariables($id){
		$data = [];
		foreach ($this->model->getIndVariables($id) as $v) {
			$data[] = ['id' => $v->id, 'nc' => $v->nombre_corto, 'nl' => $v->nombre_largo];

			//$this->model->getUpdateTable(['nombre_largo' => $this->getCapitalizarPrimeraLetra($v->nombre_largo)], 'ui_ind_estrategicos_reg', 'idind_estrategicos_reg', $v->id);
		}
		return $data;
	}
	function getCapitalizarPrimeraLetra($texto) {
		if (empty($texto)) return $texto;
		return mb_strtoupper(mb_substr($texto, 0, 1, 'UTF-8'), 'UTF-8') . 
			   mb_strtolower(mb_substr($texto, 1, null, 'UTF-8'), 'UTF-8');
	}
	function postSaveind( Request $r)
	{
		$file= Input::file('archivos');
		$ext = $file->getClientOriginalExtension();//OBTENGO LA EXTENSIÓN DEL ARCHIVO
		if($ext == "xlsx" or $ext == "xls" or $ext == "XLSX" or $ext == "XLS"){
			//Obtengo el directorio del archivo
			$path = $file->getRealPath();
			//Obtengo los datos del excel
			$data = Excel::selectSheetsByIndex(0)->load($path, function($reader) { })->get();
			//Verificó que tenga datos el excel
			if(!empty($data) && $data->count()){
				$arreglo = [];	
				for ($l=0; $l < count($data)  ; $l++) {
					$codigo = $data[$l]['codigo'];
					if(isset($arreglo[$codigo])){
						$arreglo[$codigo]['rows'][] = ['nombre_corto' => $data[$l]['nombre_corto'],'nombre_largo' => $data[$l]['nombre_largo']];
					}else{
						$arreglo[$codigo] = ['idprograma' => $data[$l]['idprograma'], 
												'codigo' => $data[$l]['codigo'],
												'indicador' => $data[$l]['indicador'],
 												'rows' => [['nombre_corto' => $data[$l]['nombre_corto'],
												 'nombre_largo' => $data[$l]['nombre_largo']
											  ]]
											];
					}
					
				}
				foreach ($arreglo as $a) {
					$arr = ['idprograma' => $a['idprograma'], 
							'idanio' => 3,
							'codigo' => trim($a['codigo']),
							'indicador' => trim($a['indicador']),
						];
					$id = $this->model->getInsertTable($arr,'ui_ind_estrategicos', 'idind_estrategicos');
					foreach ($a['rows'] as $v) {
						$variables = ['idind_estrategicos' => $id, 
										'nombre_corto' => $v['nombre_corto'],
										'nombre_largo' => $v['nombre_largo'],
									];
						$this->model->getInsertTable($variables,'ui_ind_estrategicos_reg', 'idind_estrategicos_reg');
					}
				}
				return Redirect::to('indestrategicos/principal?idy=3&year=2025')->with('messagetext', 'Información guardada correctamente')->with('msgstatus','success');
			} 
		} 
	}
}