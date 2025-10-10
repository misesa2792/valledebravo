<?php
namespace App\Services\Presupuesto;

use App\Models\Access\Years;
use App\Models\Seguimientoproyectos;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SeguimientoService extends Controller
{
	protected $data = array();	
	protected $model;	

    public function __construct(Seguimientoproyectos $model)
	{
        $this->model = $model;
		$this->data = array(
			'pageTitle'	=> "Seguimiento royectos",
			'pageNote'	=> "Lista de proyectos",
			'pageModule'=> 'seguimientoproyectos'
		);
		
	}
    public function index(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getAccessYearsModule($idi, 1);
		return view('seguimientoproyectos.index',$this->data);
    }
	public function principal(Request $request)
    {
		$this->data['idam'] = $request->idam;
		$this->data['rowsDepGen'] = [];
		$this->data['pages']	= $this->getNoPaginacion(); 
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
		return view('seguimientoproyectos.principal',$this->data);
    }
	public function search(Request $request)
	{
		$this->data['idam'] = $request->idam;
		$this->data['j'] = 1;
		$this->data['rowRegistros'] = $this->getRowsRegistros($request->idam);
		return view('seguimientoproyectos.search',$this->data);
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
	
}