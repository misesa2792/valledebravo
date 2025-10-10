<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrma;
use App\Models\Poa\Pbrmc;
use App\Models\Poa\Pbrmb;
use App\Models\Poa\Pbrmaa;
use App\Models\Instituciones;
use App\Models\Access\Years;
use App\Models\Area;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Services\Poa\PoaService;

use SiteHelpers;

use App\Traits\JsonResponds;

class PbrmbService extends Controller
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
			'pageTitle'	=> "POA",
			'pageNote'	=> "Lista de registros"
		);
		
	}
    
    public function store(Request $request)
    {
        $idy = $request->idy;
        $type = $request->type;
        $this->data['idy'] = $idy;
        $idi = Auth::user()->idinstituciones;
        $area = Area::find($request->id,['numero', 'descripcion']);
        $idmodule = $this->poaService->getModuleNumber($type);
        $row = $this->model->getInfoModuleAnio($idi,$idy,$idmodule);
        if($row){
            $this->data['type'] = $request->type;
            $this->data['id'] = $request->id;
            $this->data['data'] = ['year'            => $row->anio,
                                    'no_institucion' => $row->no_institucion,
                                    'institucion'    => $row->institucion,
                                    'no_dep_gen'     => $area->numero,
                                    'dep_gen'        => $area->descripcion
                                ];
            $this->data['rowsPogramas'] = $this->model->getProgramas($row->idanio_info);
            $this->data['rowsPDM'] = $this->model->getPlanDesarrolloMunicipal($idy, $idi);
            $this->data['rowsODS'] = $this->model->getOds();
            return view('anteproyecto.pbrmb.add',$this->data);
        }
    }
     public function edit(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataEdit($request);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['idy'] = $request->idy;
        $this->data['idarea'] = $request->idarea;
       return view('anteproyecto.pbrmb.edit',$this->data);
    }
    public function dataEdit(Request $request){
        $id = $request->id; //ID del registro PbRM-01a
        $type = $request->type;
        $idy = $request->idy;
        $idi = Auth::user()->idinstituciones;
        $data = [];
        $row = Pbrmb::getInfoRegistro($id);
        $idmodule = $this->poaService->getModuleNumber($type);
        $info = $this->model->getInfoModuleAnio($idi, $idy, $idmodule);
        if($row){
            $idi = Auth::user()->idinstituciones;
            $data = ['year'          => $row->anio,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_programa'    => $row->no_programa,
                    'programa'       => $row->programa,
                    'fortalezas'     => json_decode($row->fortalezas),
                    'oportunidades'  => json_decode($row->oportunidades),
                    'debilidades'    => json_decode($row->debilidades),
                    'amenazas'       => json_decode($row->amenazas),
                    'estrategias'    => json_decode($row->estrategias),
                    'lineas_accion'  => json_decode($row->lineas_accion),
                    'ods'            => json_decode($row->ods),
                    'rowsPogramas'   => $this->model->getProgramas($info->idanio_info),
                    'rowsPDM'        => $this->model->getPlanDesarrolloMunicipal($idy, $idi),
                    'rowsODS'        => $this->model->getOds()
                ];
        }
        return $data;
    }
    public function tr(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $this->data['time'] = rand(5,9999).time();
        $this->data['num'] = $request->num;
        $this->data['rowsPDM'] = $this->model->getPlanDesarrolloMunicipal($request->idy, $idi);
        $this->data['rowsODS'] = $this->model->getOds();
        return view('anteproyecto.pbrmb.tr',$this->data);
    }
    private function dataFODA($foda){
        $data = [];
        foreach ($foda as $v) {
            $data[] = $v;
        }
        return $data;
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $idi = Auth::user()->idinstituciones;
            $iduser = Auth::user()->id;
            $idy = $request->idy;
            $foda = $request->foda;
            $idarea = $request->id;
            $idprograma = $request->idprograma;
            $type = $this->poaService->getTypeNumber($request->type);

            $validated = Pbrmb::getValidatedRecord($type, $idi, $idy, $idarea, $idprograma);
            if($validated){
                return response()->json([
                    'status' => 'error',
                    'message' => 'El programa ya fue asignado a la dependencia general, por lo que no es posible volver a asignarlo.!'
                ]);
            }

            $fortalezas= [];
            $oportunidades=[];
            $debilidades=[];
            $amenazas=[];

            if(isset($foda[1])){
                $fortalezas = $this->dataFODA($foda[1]);
            }
            if(isset($foda[2])){
                $oportunidades = $this->dataFODA($foda[2]);
            }
            if(isset($foda[3])){
                $debilidades = $this->dataFODA($foda[3]);
            }
            if(isset($foda[4])){
                $amenazas = $this->dataFODA($foda[4]);
            }
            
            $estrategias = $this->dataFODA($request->estrategias);
            $idlinea_accion = $this->dataFODA($request->idlinea_accion);
            $ods = $this->dataFODA($request->idods);

            $data = [
                "type"              => $type,
                "idinstituciones"   => $idi,
                "idanio"            => $idy,
                "idarea"            => $idarea,
                "idprograma"        => $idprograma,
                "fortalezas"        => json_encode($fortalezas),
                "oportunidades"     => json_encode($oportunidades),
                "debilidades"       => json_encode($debilidades),
                "amenazas"          => json_encode($amenazas),
                "estrategias"       => json_encode($estrategias),
                "lineas_accion"     => json_encode($idlinea_accion),
                "ods"               => json_encode($ods),
                "iduser_rg"         => $iduser,
                "std_delete"        => 1,
            ];
            
            Pbrmb::create($data);

            DB::commit(); // Confirma la transacción

            return response()->json([
                'status' => 'ok',
                'message' => 'Datos guardados correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error al guardar los datos : '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar los datos!'
            ]);
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción

        try {
            $idi = Auth::user()->idinstituciones;
            $iduser = Auth::user()->id;
            $idy = $request->idy;
                
            $foda = $request->foda;

            $fortalezas= [];
            $oportunidades=[];
            $debilidades=[];
            $amenazas=[];
            $estrategias=[];
            $idlinea_accion=[];
            $ods=[];

            if(isset($foda[1])){
                $fortalezas = $this->dataFODA($foda[1]);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas fortalezas!']);
            }
            if(isset($foda[2])){
                $oportunidades = $this->dataFODA($foda[2]);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas oportunidades!']);
            }
            if(isset($foda[3])){
                $debilidades = $this->dataFODA($foda[3]);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas debilidades!']);
            }
            if(isset($foda[4])){
                $amenazas = $this->dataFODA($foda[4]);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas amenazas!']);
            }
            if(isset($request->estrategias)){
                $estrategias = $this->dataFODA($request->estrategias);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas estrategias!']);
            }
            if(isset($request->idlinea_accion)){
                $idlinea_accion = $this->dataFODA($request->idlinea_accion);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas líneas de acción!']);
            }
            if(isset($request->idods)){
                $ods = $this->dataFODA($request->idods);
            }else{
                return response()->json(['status' => 'error','message' => 'No se tiene registradas ODS!']);
            }

             $data = [
                "fortalezas"        => json_encode($fortalezas),
                "oportunidades"     => json_encode($oportunidades),
                "debilidades"       => json_encode($debilidades),
                "amenazas"          => json_encode($amenazas),
                "estrategias"       => json_encode($estrategias),
                "lineas_accion"     => json_encode($idlinea_accion),
                "ods"               => json_encode($ods),
            ];

            $pbrmb = Pbrmb::find($request->id);
            $pbrmb->update($data);

            DB::commit(); // Confirma la transacción

            return response()->json([
                'status' => 'ok',
                'message' => 'Datos guardados correctamente'
            ]);

           return response()->json([
                'status' => 'error',
                'message' => 'No tienes acceso al año!'
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error al guardar los datos : '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar los datos!'
            ], 500);
        }
    }
    public function generate(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['view'] = $request->view;
        return view('anteproyecto.pbrmb.generate',$this->data);
    }
    public function dataPDF($id){
        $data = [];
        $idi = Auth::user()->idinstituciones;
        $row = Pbrmb::getInfoRegistro($id);
        if($row){
            $la = json_decode($row->lineas_accion);
            $idla = (is_array($la) ? implode(',', $la) : 0);
            $ods = json_decode($row->ods);
            $idods = (is_array($ods) ? implode(',', $ods) : 0);

            $arr = [];
            $arr_ods = [];
            foreach (Pbrmb::getLineasAccion($idla) as $item) {
                $no_objetivo = $item->no_objetivo;
                $no_estrategia = $item->no_estrategia;
                
                // Inicializar objetivo si no existe
                if (!isset($arr[$no_objetivo])) {
                    $arr[$no_objetivo] = [
                        'objetivo' => $item->objetivo,
                        'estrategias' => []
                    ];
                }

                // Inicializar estrategia si no existe
                if (!isset($arr[$no_objetivo]['estrategias'][$no_estrategia])) {
                    $arr[$no_objetivo]['estrategias'][$no_estrategia] = [
                        'estrategia' => $item->estrategia,
                        'lineas_accion' => []
                    ];
                }

                // Agregar línea de acción
                $arr[$no_objetivo]['estrategias'][$no_estrategia]['lineas_accion'][] = [
                    'no_linea_accion' => $item->no_linea_accion,
                    'linea_accion' => $item->linea_accion
                ];
            }

            foreach (Pbrmb::getMetasODS($idods) as $item) {
                $no_ods = $item->idods;
                // Inicializar ODS si no existe
                if (!isset($arr_ods[$no_ods])) {
                    $arr_ods[$no_ods] = [
                        'ods' => $item->ods,
                        'metas' => []
                    ];
                }

                $arr_ods[$no_ods]['metas'][] = $item->meta;
            }
            
            $data = ['no_programa'   => $row->no_programa, 
                    'programa'       => $row->programa,
                    'obj_programa'   => $row->obj_programa,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'anio'           => $row->anio,
                    'fortalezas'     => json_decode($row->fortalezas),
                    'oportunidades'  => json_decode($row->oportunidades),
                    'debilidades'    => json_decode($row->debilidades),
                    'amenazas'       => json_decode($row->amenazas),
                    'estrategias'    => json_decode($row->estrategias),
                    'lineas_accion'  => $arr,
                    'ods'            => $arr_ods,
                    'footer'         => [
                        'dg' => ['titular' => $row->titular, 'cargo' => $row->cargo],
                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                    ],
                ];
        }
        return $data;
    }
    public function pdf(Request $request)
    {
        try {
             $idi = Auth::user()->idinstituciones;
            $id = $request->id;
            $row = $this->dataPDF($id);
            $type = $request->type;

            $this->data['data'] = $row;
            $this->data['request'] = $request->all();

            //Se construye el nombre del PDF
            $number = $this->getBuildFilenamePDF($type."1B",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['anio'], $this->poaService->getTypeFolder($type), '01b');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                        'margin_top' => 48,
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_bottom' => 35,
                        ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrmb.pdf.header", $this->data)->render());
			$mpdf->WriteHTML(view('anteproyecto.pbrmb.pdf.body',$this->data));
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrmb.pdf.footer", $this->data)->render());
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrmb = Pbrmb::find($id);
            if ($pbrmb) {
                $pbrmb->update(['url' => $number]);
                $this->getInsertTablePlan($idi, $number, $url, $result['directory']);
                    //Return del resultado con el key
                return response()->json([
                    'status'  => 'ok',
                    'message' => 'PDF generado exitosamente.',
                    'number'  => $number
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    "message"=> 'El registro no existe!'
                ]);
            }
        } catch (\Exception $e) {
            \SiteHelpers::auditTrail( $request , 'Error al generar el PDF - PbRM-01a !'.$e->getMessage());

            return response()->json([
                'status' => 'error',
                "message"=>"Error al generar el PDF!"
            ]);
        }
    }
    public function search(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);

        if($idy == 0){
            $data = $this->getDataSearchOld($type,$idarea,$idy,$idi);
        }else{
            $data = $this->getDataSearch($type,$idarea,$idy,$idi);
        }

        return $this->success("PbRM-01b", $data);
    }
    public function searchGeneral(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $type = $this->poaService->getTypeNumber($request->type);

        $data = $this->getDataSearchGeneral($type,$idy,$idi);

        return $this->success("PbRM-01b", $data);
    }
    private function getDataSearch($type,$idarea,$idy,$idi){
        $data = [];
        foreach (Pbrmb::getSearch($type,$idarea,$idy,$idi) as $v) {
            $data[] = ['id' => $v->id, 
                        'no_programa' => $v->no_programa, 
                        'programa' => $v->programa,
                        'url' => $v->url
                    ];

        }
        return $data;
    }
    private function getDataSearchGeneral($type,$idy,$idi){
        $data = [];
        foreach (Pbrmb::getSearchGeneral($type,$idy,$idi) as $v) {
            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }
            $data[$v->no_dep_gen]['data'][] = ['id' => $v->id, 
                        'no_programa' => $v->no_programa, 
                        'programa' => $v->programa,
                        'url' => $v->url
                    ];
        }
        return array_values($data);
    }
    private function getDataSearchOld($type,$idarea,$idy,$idi){
        $data = [];
        foreach (Pbrmb::getSearchOld($idy,$idarea) as $v) {
            $data[] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                        'no_programa' => $v->no_programa, 
                        'programa' => $v->programa,
                        'url' => $v->url
                    ];

        }
        return $data;
    }
    public function reverse(Request $request)
    {
        $params = $request->params;
        $row = Pbrmb::find($params['id']);
        if($row){
            $url = $row['url'];
            $row->update(['url' => null]);
  
            $this->updatePlanPDFNew($url);
  
            return response()->json([
                'status' => 'ok',
                'message' => 'PDF revertido correctamente!'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'ID no encontrado!'
        ], 500);
    }
    public function delete(Request $request)
    {
        $row = Pbrmb::find($request->id);
        if($row){
            $row->update(['std_delete' => 2]);

            return response()->json([
                'status' => 'ok',
                'message' => 'Registro eliminado correctamente!'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'ID no encontrado!'
        ], 500);
    }
   
}