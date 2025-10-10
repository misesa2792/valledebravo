<?php
namespace App\Services\Pdm;

use App\Http\Controllers\controller;

use App\Models\Alineacion;
use App\Models\Access\Years;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class AlineacionService extends Controller
{
	protected $data;	
	protected $model;	
	const MODULE_ID = 5;
    public function __construct(Alineacion $model)
	{
		$this->model = $model;
		$this->data = array(
			'pageTitle'	=> "PDM",
			'pageNote'	=> "Alineación con metas",
			'pageModule'=> 'alineacion'
		);
	}
    public function index(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE_ID, $idi);
        return view('alineacion.pdm.index',$this->data);
    }
	public function ejes(Request $request)
    {
		$this->data['rowsPilares'] = $this->getDataPilares($request->idy);
		$this->data['idy'] = $request->idy;
        return view('alineacion.pdm.pilares',$this->data);
    }
	public function destroyMeta(Request $request)
    {
		$this->model->getDestroyTable("ui_pdm_pilares_pbrm","idpdm_pilares_pbrm",$request->id);
		return response()->json([
			'status'  => 'ok',
			'message' => 'Registro eliminado correctamente.'
		]);
    }
	private function getDataPilares($idy)
	{
		$data = [];
		foreach ($this->model->getPilaresEjes($idy) as $v) {
			$arr = ['id' => $v->idtema, 'no' => $v->no_tema, 'tema' => $v->tema];
			if(isset($data[$v->id])){
				$data[$v->id]['temas'][] = $arr;
			}else{
				$data[$v->id] = array(
					"id" => $v->id,
					"no" => $v->no_pilar,
					"pilar" => $v->pilares,
					"color" => $v->color,
					"temas" => [$arr]
				);
			}
		}
		return $data;
	}
	public function searchMetas( Request $request )
	{
		$idi = \Auth::user()->idinstituciones;
		$arr = array();
		foreach ($this->model->getSearchMetas(1,$request,$idi) as $v) {
			$metas = ['id' => $v->idreporte_reg, 'no' => $v->no_accion, 'um' => $v->unidad_medida, 'meta' => $v->meta];
			if(isset($arr[$v->id])){
				$arr[$v->id]['metas'][] = $metas;
			}else{
				$arr[$v->id] = array(
							"no_proyecto"	=>$v->no_proyecto,
							"proyecto"		=>$v->proyecto,
							"no_dep_gen"	=>$v->no_dep_gen,
							"dep_gen"		=>$v->dep_gen,
							"no_dep_aux"	=>$v->no_dep_aux,
							"dep_aux"		=>$v->dep_aux,
							"no_ins" 		=>$v->no_institucion,
							"ins" 			=>$v->institucion,
							"metas" 		=> [$metas]
						);
			}
			
		}

		if(!empty($request->meta)){
			$totalRegistros = 1;
		}else{
			$totales = $this->model->getSearchMetas(2,$request,$idi);
			$totalRegistros = $totales[0]->suma;
		}

		$pagination = new Paginator($arr, $totalRegistros, $request->nopagina);
		$this->data['pagination'] = $pagination;
		$this->data['idy'] = $request->idy;
        return view('alineacion.pdm.search',$this->data);
	}
	public function metas(Request $request)
    {
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $request->id;
		$this->data['idt'] = $request->idt;
        return view('alineacion.pdm.temas',$this->data);
    }
	public function loadpdm(Request $request)
    {
		$data = [];
		foreach ($this->model->getPïlaresTema($request->idt) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_tema, 'tema' => $v->tema, 'subtemas' => $this->getSubtemas($v->id,$request->idy)];
		}
		$this->data['data'] = $data;
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $request->idt;
        return view('alineacion.pdm.viewtemas',$this->data);
    }
	public function saveAlineacion(Request $request)
    {
		if(!isset($request->idrg)){
			return response()->json([
				'status'  => 'error',
				'message' => 'Faltan datos para guardar la alineación.'
			]);
		}
		
		$data = ['idanio' => $request->idy, 'idpdm_pilares_metas' => $request->idmeta, 'idreporte_reg' => $request->idrg];
		$this->model->getInsertTable($data,"ui_pdm_pilares_pbrm");
		return response()->json([
			'status'  => 'ok',
			'message' => 'Información guardada correctamente.'
		]);
    }
	public function alinearmetas(Request $request)
    {
		$this->data['idy'] = $request->idy;
		$this->data['idmeta'] = $request->idmeta;
		$this->data['idla'] = $request->idla;
		$this->data['rowsProyectos'] = $this->model->getProyectoMetas($request->idy);
        return view('alineacion.pdm.alinear',$this->data);
    }
	private function getSubtemas($id,$idy)
	{
		$data = [];
		foreach ($this->model->getPïlaresSubTema($id) as $v) {
			$data[] = ['id' => $v->id, 'subtema' => $v->subtema, 'objetivos' => $this->getObjetivos($v->id,$idy)];
		}
		return $data;
	}
	private function getObjetivos($id,$idy)
	{
		$data = [];
		foreach ($this->model->getPïlaresObjetivos($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_objetivo,'objetivo' => $v->objetivo,'estrategias' => $this->getEstrategias($v->id,$idy)];
		}
		return $data;
	}
	private function getEstrategias($id,$idy)
	{
		$data = [];
		foreach ($this->model->getPïlaresEstrategias($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_est,'est' => $v->est,'lineas' => $this->getLineasAccion($v->id,$idy)];
		}
		return $data;
	}
	private function getLineasAccion($id,$idy)
	{
		$data = [];
		foreach ($this->model->getLineasAccion($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_la,'la' => $v->la, 'metas' => $this->getMetasPbrm($v->id,$idy)];
		}
		return $data;
	}
	private function getMetasPbrm($id,$idy)
	{
		$data = [];
		foreach ($this->model->getPdmMetas($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->clave,'meta' => $v->meta, 'metas' => $this->model->getPdmMetasPbrm($v->id,$idy)];
		}
		return $data;
	}
}