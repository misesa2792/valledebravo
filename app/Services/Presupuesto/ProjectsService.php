<?php
namespace App\Services\Presupuesto;

use App\Models\Projects;
use App\Models\Access\Years;
use App\Models\Transpasosinternos;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProjectsService extends Controller
{
	protected $data = array();	
	protected $model;	
	protected $poaService;	

    public function __construct(Projects $model)
	{
        $this->model = $model;
		$this->data = array(
			'pageTitle'	=> "Proyecto",
			'pageNote'	=> "Lista de proyectos",
			'pageModule'=> 'projects'
		);
		
	}
    public function index(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getAccessYearsModule($idi, 1);
		return view('projects.index',$this->data);
    }
	public function proyectos(Request $request)
    {
		$this->data['idam'] = $request->idam;
		return view('projects.proyectos',$this->data);
    }
	public function search(Request $request)
	{
		$params = $request->params;
		return response()->json([
			'status' => 'ok',
			'data' => $this->getRowsRegistros($params['idam'])
		]);
	}
	private function getRowsRegistros($idam){
		$data = [];
		foreach ($this->model->getSearch($idam) as $v) {
			$arr = ['id' 			=> $v->id, 
					'no_dep_aux' 	=> $v->no_dep_aux,
					'dep_aux' 		=> $v->dep_aux,
					'no_proyecto' 	=> $v->no_proyecto,
					'proyecto' 		=> $v->proyecto,
					'importe' 		=> number_format($v->presupuesto, 2)
				];
			if(isset($data[$v->no_dep_gen])){
				$data[$v->no_dep_gen]['rows'][] = $arr;
			}else{
				$data[$v->no_dep_gen] = ['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen, 'rows' =>[ $arr]];
			}
		}
		return $data;
	}
	public function add(Request $request)
    {
		$idam = $request->idam;
		$module = Years::getIdModule($idam);
		$this->data['idam'] = $idam;
		$this->data['rowsProyectos'] = Transpasosinternos::getProyectos($module->idanio_info);
		$this->data['rowsDepGen'] = Transpasosinternos::getDepGen($module->idtipo_dependencias,$module->idanio_info);
		$this->data['rowsDepAux'] = Transpasosinternos::getDepAux($module->idtipo_dependencias, $module->idanio_info);
		return view('projects.add',$this->data);
    }
	public function edit(Request $request)
    {
		$idam = $request->idam;
		$module = Years::getIdModule($idam);
		$this->data['idam'] = $idam;
		$this->data['id'] = $request->id;
		$this->data['row'] = $this->model->find($request->id);
		$this->data['rowsProyectos'] = Transpasosinternos::getProyectos($module->idanio_info);
		$this->data['rowsDepGen'] = Transpasosinternos::getDepGen($module->idtipo_dependencias,$module->idanio_info);
		$this->data['rowsDepAux'] = Transpasosinternos::getDepAux($module->idtipo_dependencias, $module->idanio_info);
		return view('projects.edit',$this->data);
    }
	public function store(Request $request)
    {
		$data = array("idanio_module"=>$request->idam,
						"iddep_gen"=>$request->iddep_gen,
						"iddep_aux"=>$request->iddep_aux,
						"idproyecto"=>$request->idproyecto,
						"presupuesto"=>$this->getClearNumber($request->importe),
					);
		$this->model->insertRow($data,0);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Información guardada exitosamente.'
		]);
    }
	public function update(Request $request)
    {
		$data = array(
						"iddep_gen"=>$request->iddep_gen,
						"iddep_aux"=>$request->iddep_aux,
						"idproyecto"=>$request->idproyecto,
						"presupuesto"=>$this->getClearNumber($request->importe),
					);
		$this->model->getUpdateTable($data,'ui_teso_proyectos','idteso_proyectos',$request->id);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Información actualizada exitosamente.'
		]);
    }
	public function destroy(Request $request)
    {
		$this->model->getDestroyTable("ui_teso_proyectos","idteso_proyectos",$request->id);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Proyecto eliminado exitosamente.'
		]);
    }
}