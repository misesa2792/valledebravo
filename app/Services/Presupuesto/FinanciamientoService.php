<?php
namespace App\Services\Presupuesto;

use App\Models\Access\Years;
use App\Models\Fuentefinanciamiento;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class FinanciamientoService extends Controller
{
	protected $data = array();	
	protected $model;	
	protected $poaService;	

    public function __construct(Fuentefinanciamiento $model)
	{
        $this->model = $model;
		$this->data = array(
			'pageTitle'	=> "Fuente de financiamiento",
			'pageNote'	=> "Lista de proyectos",
			'pageModule'=> 'fuentefinanciamiento'
		);
		
	}
    public function index(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(5, $idi);
		return view('fuentefinanciamiento.index',$this->data);
    }
	public function registros(Request $request)
    {
		$this->data['idam'] = $request->idam;
		return view('fuentefinanciamiento.registros',$this->data);
    }
	public function agregar(Request $request)
    {
		$module = Years::getIdModule($request->idam);
		$this->data['idam'] = $request->idam;
		$this->data['rowsFF'] = $this->model->getFFN3($module->idanio_info);
		return view('fuentefinanciamiento.form',$this->data);
    }
	public function edit(Request $request)
    {
		$this->data['row'] = $this->model->getFuenteFinID($request->id);
		$this->data['id'] = $request->id;
		return view('fuentefinanciamiento.edit',$this->data);
    }
	public function update(Request $request)
	{
		$data = array(
			"m1" => $this->getClearNumber($request->m1),
			"m2" => $this->getClearNumber($request->m2),
			"m3" => $this->getClearNumber($request->m3),
			"m4" => $this->getClearNumber($request->m4),
			"m5" => $this->getClearNumber($request->m5),
			"m6" => $this->getClearNumber($request->m6),
			"m7" => $this->getClearNumber($request->m7),
			"m8" => $this->getClearNumber($request->m8),
			"m9" => $this->getClearNumber($request->m9),
			"m10" => $this->getClearNumber($request->m10),
			"m11" => $this->getClearNumber($request->m11),
			"m12" => $this->getClearNumber($request->m12),
			"total" => $this->getClearNumber($request->total)
		);
		$this->model->getUpdateTable($data, "ui_teso_ff", "idteso_ff",$request->id);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Información actualizada correctamente.'
		]);
	}
	public function store(Request $request)
    {
		$idam = $request->idam;
		$val = $this->model->getValidarFF($idam, $request->idff);
		if($val){
			return response()->json([
				'status'  => 'error',
				'message' => 'La Fuente de Financiamiento ya esta registrada en el año.'
			]);
		}

		//Se valida que el programa no este registrado en la dependencia
		$data = array("idteso_ff_n3" => $request->idff, 
				"idanio_module" => $idam, 
				"m1" => $this->getClearNumber($request->m1),
				"m2" => $this->getClearNumber($request->m2),
				"m3" => $this->getClearNumber($request->m3),
				"m4" => $this->getClearNumber($request->m4),
				"m5" => $this->getClearNumber($request->m5),
				"m6" => $this->getClearNumber($request->m6),
				"m7" => $this->getClearNumber($request->m7),
				"m8" => $this->getClearNumber($request->m8),
				"m9" => $this->getClearNumber($request->m9),
				"m10" => $this->getClearNumber($request->m10),
				"m11" => $this->getClearNumber($request->m11),
				"m12" => $this->getClearNumber($request->m12),
				"total" => $this->getClearNumber($request->total)
			);
		$this->model->getInsertTable($data, "ui_teso_ff");
		return response()->json([
			'status'  => 'ok',
			'message' => 'Información guardada correctamente.'
		]);
    }
	public function destroy(Request $request)
	{
		$this->model->getDestroyTable("ui_teso_ff","idteso_ff",$request->id);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Registro eliminado correctamente!'
		]);
	}
	public function search(Request $request)
	{
		return response()->json([
			'status'  => 'ok',
			'data' => $this->getRegistrosFF($request->idam)
		]);
	}
	private function getRegistrosFF($idam){
		$data = [];
		$m1 = 0;
		$m2 = 0;
		$m3 = 0;
		$m4 = 0;
		$m5 = 0;
		$m6 = 0;
		$m7 = 0;
		$m8 = 0;
		$m9 = 0;
		$m10 = 0;
		$m11 = 0;
		$m12 = 0;
		$total = 0;
		foreach ($this->model->getRegistrosFF($idam) as $v) {
			$m1 += $v->m1;
			$m2 += $v->m2;
			$m3 += $v->m3;
			$m4 += $v->m4;
			$m5 += $v->m5;
			$m6 += $v->m6;
			$m7 += $v->m7;
			$m8 += $v->m8;
			$m9 += $v->m9;
			$m10 += $v->m10;
			$m11 += $v->m11;
			$m12 += $v->m12;
			$total += $v->total;

			$data[] = ['id' => $v->id,
						'clave' => $v->clave,
						'fuente' => $v->fuente,
						'm1' => [
							'importe' 	=> number_format($v->m1,2),
						],
						'm2' => [
							'importe' 	=> number_format($v->m2,2),
						],
						'm3' => [
							'importe' 	=> number_format($v->m3,2),
						],
						'm4' => [
							'importe' 	=> number_format($v->m4,2),
						],
						'm5' => [
							'importe' 	=> number_format($v->m5,2),
						],
						'm6' => [
							'importe' 	=> number_format($v->m6,2),
						],
						'm7' => [
							'importe' 	=> number_format($v->m7,2),
						],
						'm8' => [
							'importe' 	=> number_format($v->m8,2),
						],
						'm9' => [
							'importe' 	=> number_format($v->m9,2),
						],
						'm10' => [
							'importe' 	=> number_format($v->m10,2),
						],
						'm11' => [
							'importe' 	=> number_format($v->m11,2),
						],
						'm12' => [
							'importe' 	=> number_format($v->m12,2),
						],
						'total' => [
							'importe' 	=>  number_format($v->total,2),
						]
				];
		}
		return ['data' => $data, 
				'totales' => [
					'm1' => number_format($m1,2),
					'm2' => number_format($m2,2),
					'm3' => number_format($m3,2),
					'm4' => number_format($m4,2),
					'm5' => number_format($m5,2),
					'm6' => number_format($m6,2),
					'm7' => number_format($m7,2),
					'm8' => number_format($m8,2),
					'm9' => number_format($m9,2),
					'm10' => number_format($m10,2),
					'm11' => number_format($m11,2),
					'm12' => number_format($m12,2),
					'total' => number_format($total,2)
				]
			];
	}
}