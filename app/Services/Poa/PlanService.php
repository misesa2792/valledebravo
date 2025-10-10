<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Plan;
use App\Models\Poa\Planmetas;

use App\Services\Poa\PoaService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use SiteHelpers;

use App\Helpers\FunctionHelper;

use App\Traits\JsonResponds;

class PlanService extends Controller
{
	protected $data;	
    protected $poaService;
	protected $model;	

    use JsonResponds;

    public function __construct(Poa $model, PoaService $poaService)
	{
		$this->model = $model;
        $this->poaService = $poaService;
		$this->data = array(
			'pageTitle'	=> "Presupuesto Operativo Anual",
			'pageNote'	=> ""
		);
	}
   
    public function store(Request $request)
    {
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $request->type;
        $this->data['idy'] = $idy;
        $idi = Auth::user()->idinstituciones;
        $data = $this->poaService->getDataInfo($type, $idy, $idarea);
        $idmodule = $this->poaService->getModuleNumber($type);
        $row = $this->model->getInfoModuleAnio($idi, $idy, $idmodule);
        if($row){
            $this->data['type'] = $type;
            $this->data['id'] = $idarea;
            $this->data['idy'] = $idy;
            $this->data['data'] = ['year'            => $row->anio,
                                    'no_institucion' => $row->no_institucion,
                                    'institucion'    => $row->institucion,
                                    'no_dep_gen'     => $data['no_dep_gen'],
                                    'dep_gen'        => $data['dep_gen']
                                ];
            $this->data['rowsPogramas'] = $this->dataProgramas($row->idanio_info, $request);
            return view('anteproyecto.plan.add',$this->data);
        }
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $idi    = Auth::user()->idinstituciones;
            $iduser = Auth::user()->id;
            $idy    = $request->idy;
            $idarea = $request->id;
            $type = $this->poaService->getTypeNumber($request->type);

            for ($i = 0; $i < count($request->idprograma); $i++) {
                 $data = [
                        "type"              => $type,
                        "idinstituciones"   => $idi,
                        "idanio"            => $idy,
                        "idarea"            => $idarea,
                        "idprograma"        => $request->idprograma[$i],
                        "iduser_rg"         => $iduser,
                        "std_apdm"          => 1,
                        "std_arpppdm"       => 1,
                        "std_pmpdm"         => 1,
                    ];
                Plan::create($data);
            }

            DB::commit(); // Confirma la transacción
            
            return $this->success('Datos guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }
    public function savepmpdm(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $id = $request->id;

            for ($i = 0; $i < count($request->idag); $i++) {
                
                $prog = FunctionHelper::normalizeAmount($request->programado[$i]);
                $t1 = FunctionHelper::normalizeAmount($request->total1[$i]);
                $t2 = FunctionHelper::normalizeAmount($request->total2[$i]);
                $t3 = FunctionHelper::normalizeAmount($request->total3[$i]);

                $data = [
                        "idpd_plan"         => $id,
                        "numero"            => $request->numero[$i],
                        "meta"              => $request->meta[$i],
                        "unidad_medida"     => $request->medida[$i],
                        "total_programado"  => FunctionHelper::replaceDobleCeros($prog),
                        "total_year1"       => FunctionHelper::replaceDobleCeros($t1),
                        "total_year2"       => FunctionHelper::replaceDobleCeros($t2),
                        "total_year3"       => FunctionHelper::replaceDobleCeros($t3),
                    ];

                if($request->idag[$i] == 0){
                    Planmetas::create($data);
                }else{
                    $meta = Planmetas::find($request->idag[$i]);
                    $meta->update($data);
                }
            }

            $row = Plan::find($id);
            $row->update(['std_pmpdm' => 2]);

            DB::commit(); // Confirma la transacción
            
            return $this->success('Datos guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }
    public function searcharppdm(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = $this->dataSearchARPPDM($type,$idy, $idi);
        return $this->success("", $data);
    }
    public function searchpmpdm(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = $this->getProgramasPMPDM($type,$idy, $idi);
        return $this->success("", $data);
    }
    private function dataSearchARPPDM($type, $idy, $idi)
    {
        if($idy == 5){//2026
            $idy1 = 4;//2025
            $idy2 = 2;//2024
        }else if($idy == 4){
            $idy1 = 2;//2024
            $idy2 = 1;//2023
        }
        $year1 = $this->getDataLastYearARPPDM($type, $idi, $idy1);
        $year2 = $this->getDataLastYearARPPDM($type, $idi, $idy2);
       $data = [];
       foreach (Plan::getProgramasARPPDM($type, $idi, $idy) as $v) {
        $cad = $v->no_dep_gen."".$v->no_programa;
        $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
        $data[] = ['id' => $v->id,
                    'no_dep_gen' => $v->no_dep_gen,
                    'dep_gen' => $v->dep_gen,
                    'no_programa' => $v->no_programa,
                    'programa' => $v->programa,
                    'pres_1' => isset($year1[$cad]) ? $year1[$cad] : 0,
                    'pres_2' => isset($year2[$cad]) ? $year2[$cad] : 0,
                    'pres_3' => number_format($amount, 2)
                ];
       }
       return $data;
    }
    private function getDataLastYearARPPDM($type, $idi, $idy)
    {
       $data = [];
       foreach (Plan::getProgramasARPPDM($type, $idi, $idy) as $v) {
        $cad = $v->no_dep_gen."".$v->no_programa;
        $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
        $data[$cad] = number_format($amount, 2);
       }
       return $data;
    }
    private function getProgramasPMPDM($type, $idy, $idi)
    {
       $data = [];
       foreach (Plan::getProgramasPMPDM($type, $idi, $idy) as $v) {
        $data[] = ['id' => $v->id,
                    'no_dep_gen' => $v->no_dep_gen,
                    'no_programa' => $v->no_programa,
                    'meta' => $v->meta,
                    'total_1' => 0,
                    'total_2' => 0,
                    'total_3' => $v->aa_anual
                ];
       }
       return $data;
    }


    public function search(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = $this->dataSearch($type,$idarea, $idy, $idi);
        return $this->success("", $data);
    }
    public function arpppdm(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $this->data['data'] = Plan::getRegistros($request->id, $idi);
        $this->data['id'] = $request->id;
        return view('anteproyecto.plan.arpppdm',$this->data);
    }
    public function pmpdm(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $this->data['data'] = Plan::getRegistros($request->id, $idi);
        $this->data['id'] = $request->id;
        $this->data['rowsMetas'] = Planmetas::getMetas($request->id);
        return view('anteproyecto.plan.pmpdm',$this->data);
    }
    public function appdm(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $type = $request->type;
        $idmodule = $this->poaService->getModuleNumber($type);
        $info = $this->model->getInfoModuleAnio($idi, $request->idy, $idmodule);
        if($info){
            $row = Plan::getRegistros($request->id, $idi);
            $idla = (empty($row->a_idlineas_accion) ? [] : json_decode($row->a_idlineas_accion));
            $this->data['data'] = $row;
            $this->data['rowsIdla'] = $idla;
            $this->data['id'] = $request->id;
            $this->data['idy'] = $info->idanio_info;
            $this->data['rowsODS'] = $this->model->getOds();
            $this->data['rowsPDM'] = $this->model->getPlanDesarrolloMunicipal($request->idy);
            return view('anteproyecto.plan.appdm',$this->data);
        }
    }
    public function trappdm(Request $request)
    {
        $this->data['rowsPDM'] = $this->model->getPlanDesarrolloMunicipal($request->idy);
       $this->data['time'] = rand(3,100).time();
        return view('anteproyecto.plan.trappdm',$this->data);
    }
    public function trpmpdm(Request $request)
    {
       $this->data['time'] = rand(3,100).time();
        return view('anteproyecto.plan.tr',$this->data);
    }
    public function updatearpppdm(Request $request)
    {
        $row = Plan::find($request->id);
        if($row){
           
            $t1 = FunctionHelper::normalizeAmount($request->total_year1);
            $t2 = FunctionHelper::normalizeAmount($request->total_year2);
            $t3 = FunctionHelper::normalizeAmount($request->total_year3);
            $pres = FunctionHelper::normalizeAmount($request->total_presupuesto);

            $data = ['total_year1' => FunctionHelper::replaceDobleCeros($t1), 
                     'total_year2' => FunctionHelper::replaceDobleCeros($t2), 
                     'total_year3' => FunctionHelper::replaceDobleCeros($t3), 
                     'total_presupuesto' => FunctionHelper::replaceDobleCeros($pres), 
                     'std_arpppdm' => 2
                    ];
                    
            $row->update($data);

            return $this->success('Información guardada correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    private function dataRegistros($rows){
        $data = [];
        foreach ($rows as $v) {
            $data[] = $v;
        }
        return $data;
    }
    public function updateappdm(Request $request)
    {
        $row = Plan::find($request->id);
        if($row){
            $idla = $this->dataRegistros($request->idla);

            $data = ['a_meta_nacional'  => $request->meta_nacional, 
                     'a_obj_plan_nacional'  => $request->obj_plan_nacional,
                     'a_obj_plan_estado'    => $request->obj_plan_estado,
                     'a_estrategias'        => $request->estrategias,
                     'a_idods'              => $request->idods,
                     'a_idlineas_accion'    => json_encode($idla),
                     'std_apdm'             => 2
                    ];

            $row->update($data);

            return $this->success('Información guardada correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    private function dataSearch($type,$idarea, $idy, $idi)
    {
       $data = [];
       foreach (Plan::getProgramas($type, $idi, $idy, $idarea) as $v) {
        $data[] = ['id' => $v->id,
                    'no_programa' => $v->no_programa,
                    'programa' => $v->programa,
                    'std_apdm' => $v->std_apdm,
                    'std_arpppdm' => $v->std_arpppdm,
                    'std_pmpdm' => $v->std_pmpdm,
                ];
       }
       return $data;
    }
    public function delete(Request $request)
    {
        $row = Plan::find($request->id);
        if($row){
            $row->delete();

            return $this->success('Registro eliminado correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    public function deletepmpdm(Request $request)
    {
        $row = Planmetas::find($request->id);
        if($row){
            $row->delete();

            return $this->success('Registro eliminado correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    private function dataProgramas($idanio_info, Request $request){
        $type = $this->poaService->getTypeNumber($request->type);
        $idi    = Auth::user()->idinstituciones;
        $idy    = $request->idy;
        $idarea = $request->id;
        $prog = [];
		foreach (Plan::getProgramas($type, $idi, $idy, $idarea) as $v) {
			if(!isset($prog[$v->idprograma]))
				$prog[$v->idprograma] = true;
		}

        $data = [];
        foreach ($this->model->getProgramas($idanio_info) as $v) {
           $programas = ["id" => $v->id, 
                        "no_programa" => $v->no_programa,
                        "programa" => $v->programa,
                        "status" => (isset($prog[$v->id]) ? 1 : 2)
                    ];
			if(isset($data[$v->idpdm_pilares])){
				$data[$v->idpdm_pilares]["programas"][] = $programas;
			}else{
				$data[$v->idpdm_pilares] = ["pilar" => $v->pilares, "programas" => [$programas] ];
			}
        }
        return $data;
    }
    
    
}