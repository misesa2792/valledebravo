<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrme;
use App\Models\Poa\Pbrmd;
use App\Models\Poa\Pbrmdindicador;
use App\Models\Instituciones;
use App\Models\Access\Years;
use App\Models\Area;

use App\Services\Poa\PoaService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use SiteHelpers;
use App\Traits\JsonResponds;

class PbrmdService extends Controller
{
    use JsonResponds;

	protected $data;	
    protected $poaService;
	protected $model;	

    public function __construct(Poa $model, PoaService $poaService)
	{
		$this->model = $model;
        $this->poaService = $poaService;
		$this->data = array(
			'pageTitle'	=> "POA",
			'pageNote'	=> "Lista de registros"
		);
		
	}
    
    public function search(Request $request)
    {
        if($request->idy == 0){
            $data = $this->dataSearchOld($request);
        }else{
            $data = $this->dataSearch($request);
        }
        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'No tienes acceso al año!'
        ], 500);
    }
    public function store(Request $request)
    {
        $idy = $request->idy;
        $id = $request->id;
        $idarea = $request->idarea;
        $this->data['idy'] = $idy;
        $idi = Auth::user()->idinstituciones;
        $type = $request->type;
        $this->data['type'] = $type;
        $this->data['idy'] = $idy;
        $this->data['id'] = $id;
        $this->data['idarea'] = $idarea;
        $data = $this->dataPDF($id);
        $this->data['data'] = $data;
        $this->data['rowsTipoOpe'] = $this->model->getCatTipoOperacion();
        $this->data['rowsUnidadMedida'] = $this->model->getUnidadMedidas();
        $this->data['rowsDimension'] = $this->model->getCatDimensionAtiende();
        $this->data['rowsMetas'] = Pbrmd::getMetas($this->poaService->getTypeNumber($type), $idi, $idy); 
        $this->data['rowsDepAux'] = $this->model->getDepAux($idarea);
        $this->data['rowsProyectos'] = Pbrmd::getRowsProyectosPrograma($data['idprograma']);
        return view('anteproyecto.pbrmd.add',$this->data);
    }
    public function viewProyecto(Request $request)
    {
        $idy = $request->idy;
        $id = $request->id;
        $idarea = $request->idarea;
        $this->data['idy'] = $idy;
        $idi = Auth::user()->idinstituciones;
        $type = $request->type;
        $this->data['type'] = $type;
        $this->data['idy'] = $idy;
        $this->data['id'] = $id;
        $this->data['idarea'] = $idarea;
        $row = Pbrme::getInfoRegistro($id);
        $this->data['data'] = $row;
        $this->data['rowsDepAux'] = $this->model->getDepAux($idarea);
        $this->data['rowsProyectos'] = Pbrmd::getRowsProyectosPrograma($row->idprograma);
        $this->data['matriz'] = $this->dataMatriz($id);
        return view('anteproyecto.pbrmd.proy',$this->data);
    }
    private function dataMatriz($id){
        $fin = [];
        $proposito = [];
        $componente = [];
        $actividad = [];
        foreach (Pbrme::getRowsMatrices($id) as $row) {
            $validated = Pbrmd::getValidatedRecordProject($id,$row->idprograma_reg);
            
            //validamos que este asignado a un proyecto
            if($row->tipo == 1){
                $fin = ['row' => $row, 'validate' => ($validated) ? true : false];
            } elseif($row->tipo == 2){
                $proposito = ['row' => $row, 'validate' => ($validated) ? true : false];
            } elseif($row->tipo == 3){
                $componente[] = ['row' => $row, 'validate' => ($validated) ? true : false];
            } elseif($row->tipo == 4){
                $actividad[] = ['row' => $row, 'validate' => ($validated) ? true : false];
            } 
        }
        return ['fin'           => $fin, 
                'proposito'     => $proposito, 
                'componente'    => $componente, 
                'actividad'     => $actividad,
                ];
    }
    public function deleteIndicador(Request $request)
    {
        $row = Pbrmd::find($request->id);
        if($row){
            //Eliminar los indicadores
            Pbrmdindicador::where('idpd_pbrme_matriz', $row->idpd_pbrme_matriz)->delete();
            //Eliminar el registro
            $row->delete();
            return $this->success('Indicador eliminado correctamente.');
        }
        return $this->error('ID no encontrado!');
    }
    public function move(Request $request)
    {
        $data = Pbrmd::getInfoPbrmd($request->id);
        $this->data['data'] = $data;
        $this->data['id'] = $request->id;
        $this->data['rowsDepAux'] = $this->model->getDepAux($request->idarea);
        $this->data['rowsProyectos'] = Pbrmd::getRowsProyectosPrograma($data->idprograma);
        return view('anteproyecto.pbrmd.move',$this->data);
    }
    public function moveSave(Request $request)
    {
        $data = ['idarea_coordinacion' => $request->idac,
                 'idproyecto'         => $request->idproyecto
                ];
        $indicador = Pbrmd::find($request->id);
        $indicador->update($data);
        return $this->success('Datos actualizados correctamente.');
    }
    private function dataIDMetas($rows){
        $data = [];
        $result = (empty($rows)) ? [] : json_decode($rows);
        foreach ($result as $v) {
            $data[$v] = true;
        }
        return $data;
    }
    private function dataMetas($rows){
        $data = [];
        foreach ($rows as $v) {
            $data[] = $v;
        }
        return $data;
    }
    private function dataPDF($id){
        $idi = Auth::user()->idinstituciones;
        $data = [];
        $row = Pbrmd::getInfoRegistro($id);
        if($row){
            $data = ['anio'             => $row->anio,
                    'no_institucion'    => $row->no_institucion,
                    'institucion'       => $row->institucion,
                    'no_dep_gen'        => $row->no_dep_gen,
                    'dep_gen'           => $row->dep_gen,
                    'idac'              => $row->idac,
                    'no_dep_aux'        => $row->no_dep_aux,
                    'dep_aux'           => $row->dep_aux,
                    'idprograma'        => $row->idprograma,
                    'no_programa'       => $row->no_programa,
                    'programa'          => $row->programa,
                    'obj_programa'      => $row->obj_programa,
                    'idproyecto'        => $row->idproyecto,
                    'no_proyecto'       => $row->no_proyecto,
                    'proyecto'          => $row->proyecto,
                    'no_tema'           => $row->no_tema,
                    'tema'              => $row->tema_desarrollo,
                    'no_pilar'          => $row->no_pilar,
                    'pilar'             => $row->pilar,
                    'mir'               => $row->mir,
                    'indicador'         => $row->indicador,
                    'idformula'         => $row->idformula,
                    'formula'           => $row->formula,
                    'formula_corta'     => $row->formula_corta,
                    'frecuencia'        => $row->frecuencia,
                    'tipo_indicador'    => $row->tipo_indicador,
                    'medios'            => $row->medios,
                    'porc1'             => $row->d_porc1,
                    'porc2'             => $row->d_porc2,
                    'porc3'             => $row->d_porc3,
                    'porc4'             => $row->d_porc4,
                    'porc_anual'        => $row->d_porc_anual,
                    'interpretacion'    => $row->d_interpretacion,
                    'iddimension_atiende' => $row->iddimension_atiende,
                    'dimencion'         => $row->d_dimencion,
                    'factor'            => $row->d_factor,
                    'factor_desc'       => $row->d_factor_desc,
                    'linea_base'        => $row->d_linea_base,
                    'desc_meta'         => $row->d_descripcion_meta,
                    'metas_act'         => $row->d_metas_actividad,
                    'aplica1'           => $row->d_aplica1,
                    'aplica2'           => $row->d_aplica2,
                    'aplica3'           => $row->d_aplica3,
                    'aplica4'           => $row->d_aplica4,
                    'idmetas'           => $this->dataIDMetas($row->d_idpd_pbrma_metas),
                    'rows'              => Pbrmd::getIndicadoresMatriz($row->id),
                    'footer'         => [
                        'dg' => ['titular' => $row->titular, 'cargo' => $row->cargo],
                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                    ],
                ];
        }
        return $data;
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        //dd($request->all());
        try {
            $idi = Auth::user()->idinstituciones;
            $iduser = Auth::user()->id;
            $idy = $request->idy;
            
            $idmetas = [];

            if(isset($request->idmetas)){
                $idmetas = $this->dataMetas($request->idmetas);
            }

            //Se realiza un update de los indicadores
            for ($i=0; $i < count($request->idindicador); $i++) { 
                $data = ['unidad_medida'    => $request->unidad_medida[$i],
                         'idtipo_operacion' => $request->tipo_operacion[$i],
                         'trim1'            => $request->trim1[$i],
                         'trim2'            => $request->trim2[$i],
                         'trim3'            => $request->trim3[$i],
                         'trim4'            => $request->trim4[$i],
                         'anual'            => $request->anual[$i]
                        ];
                $row = Pbrmdindicador::find($request->idindicador[$i]);
                $row->update($data);
            }

            $data_porc = [ 'idarea_coordinacion'  => $request->idac,
                            'idproyecto'          => $request->idproyecto,
                            'd_estatus'           => 1,
                            'd_porc1'             => $request->porc1,
                            'd_porc2'             => $request->porc2,
                            'd_porc3'             => $request->porc3,
                            'd_porc4'             => $request->porc4, 
                            'd_porc_anual'        => $request->porc_anual,
                            'd_interpretacion'    => $request->interpretacion,
                            'iddimension_atiende' => $request->iddimension_atiende,
                            'd_factor'            => $request->factor,
                            'd_factor_desc'       => $request->factor_desc,
                            'd_linea_base'        => $request->linea_base,
                            'd_descripcion_meta'  => $request->desc_meta,
                            'd_metas_actividad'   => $request->metas_act,
                            'd_aplica1'           => $request->aplica1,
                            'd_aplica2'           => $request->aplica2,
                            'd_aplica3'           => $request->aplica3,
                            'd_aplica4'           => $request->aplica4,
                            "d_idpd_pbrma_metas"  => json_encode($idmetas)
                        ];
            $indicador = Pbrmd::find($request->id);
            $indicador->update($data_porc);

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
    public function saveProy(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            if(count($request->ids) == 0){
                return $this->error('Selecciona mínimo un indicador!');
            }
            foreach ($request->ids as $idprograma_reg) {
                if(Pbrmd::getValidatedRecordMatrizProject($request->id, $idprograma_reg, $request->idproyecto, $request->idac)){
                    return $this->error('El indicador ya fue asignado a este proyecto y dependencia auxiliar!');
                }
            }

            foreach ($request->ids as $idprograma_reg) {
                $data = [
                    "idpd_pbrme"              => $request->id,
                    "idarea_coordinacion"     => $request->idac,
                    "idproyecto"              => $request->idproyecto,
                    "idprograma_reg"          => $idprograma_reg,
                ];
                $pbrm = Pbrmd::create($data);
                $id = $pbrm->idpd_pbrme_matriz;
                $this->insertIndicador($id, $idprograma_reg);
            }
            //Fin 
            DB::commit(); // Confirma la transacción
            return $this->success('Datos guardados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción
            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());
            return $this->error('Error al guardar los datos!');
        }
    }
    private function insertIndicador($id, $idprograma_reg){
        foreach (Pbrmd::getRowsIndicadores($idprograma_reg) as $row) {
            $data = ['idpd_pbrme_matriz' => $id,
                     'idind_estrategicos_reg'  => $row->id,
                     'nombre_corto'  => $row->nombre_corto,
                     'nombre_largo'  => $row->nombre_largo
                    ]; 
            Pbrmdindicador::create($data);
        }
        return true;
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
            $number = $this->getBuildFilenamePDF($type."1D",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['anio'], $this->poaService->getTypeFolder($type), '01d');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                        'margin_top' => 30,
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_bottom' => 35,
                        ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrmd.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrmd.pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view('anteproyecto.pbrmd.pdf.body',$this->data));
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrmd = Pbrmd::find($id);
            if ($pbrmd) {
                $pbrmd->update(['d_url' => $number]);
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
    public function reverse(Request $request)
    {
        $params = $request->params;
        $row = Pbrmd::find($params['id']);
        if($row){
            $url = $row['d_url'];
            $row->update(['d_url' => null]);
  
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
    public function generate(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['view'] = $request->view;
        return view('anteproyecto.pbrmd.generate',$this->data);
    }
    private function dataSearch(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = [];
        foreach (Pbrme::getSearch($type, $idarea, $idy, $idi) as $v) {
            if(!isset($data[$v->id])){
                $data[$v->id]=['id' => $v->id,'no_programa' => $v->no_programa, 'programa' => $v->programa];
            }

           $data[$v->id]['rows'] = $this->getDataIndicadores($v->id);
        }
        return array_values($data);

        //old
       /* $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = [];
        foreach (Pbrme::getSearch($type, $idarea, $idy, $idi) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }

           $data[$v->no_dep_aux]['data'][] = [
                      'no_programa' => $v->no_programa,
                      'programa'    => $v->programa,
                      'no_proyecto' => $v->no_proyecto,
                      'proyecto'    => $v->proyecto,
                      'rows'        => $this->getDataIndicadores($v->id)
                    ];
        }
        return array_values($data);
        */
    }
    private function getDataIndicadores($id){
        $fin = [];
        $proposito = [];
        $componente = [];
        $actividad = [];
        $data = [];
        foreach (Pbrmd::getIndicadores($id) as $v) {
            $kp = $v->no_dep_aux.'-'.$v->no_proyecto;
            if(!isset($data[$kp])){
                $data[$kp]=['no_dep_aux'    => $v->no_dep_aux, 
                            'dep_aux'       => $v->dep_aux,
                            'no_proyecto'   => $v->no_proyecto,
                            'proyecto'      => $v->proyecto,
                        ];
            }
           $data[$kp]['indicadores'][] = ['id'              => $v->id, 
                        'no_dep_aux'    => $v->no_dep_aux, 
                        'no_proyecto'   => $v->no_proyecto,
                        'tipo'          => $v->tipo, 
                        'no_mir'        => $v->no_mir, 
                        'indicador'     => $v->indicador, 
                        'frecuencia'    => $v->frecuencia, 
                        'formula'       => $v->formula, 
                        'url'           => $v->url,
                        'estatus'       => $v->estatus,
                        'aplica1'       => $v->aplica1,
                        'aplica2'       => $v->aplica2,
                        'aplica3'       => $v->aplica3,
                        'aplica4'       => $v->aplica4,
                        'validate'      => Pbrmd::getValidatedRecordMatriz($id, $v->idprograma_reg)
                    ];

            /*if($v->tipo == 1){
                $fin[] = $v;
            }else if($v->tipo == 2){
                $proposito[] = $v;
            }else if($v->tipo == 3){
                $componente[] = $v;
            }else if($v->tipo == 4){
                $actividad[] = $v;
            }*/
        }
        return array_values($data);
       // return ['fin' => $fin,'proposito' => $proposito,'componente' => $componente,'actividad' => $actividad ];
    }
    private function dataSearchOld(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $data = [];
        foreach (Pbrmd::getSearchOld($idy, $idarea) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }

           $data[$v->no_dep_aux]['data'][] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                      'no_programa' => $v->no_programa,
                      'programa'    => $v->programa,
                      'no_proyecto' => $v->no_proyecto,
                      'proyecto'    => $v->proyecto,
                      'indicador'   => $v->nombre_indicador,
                      'frecuencia'  => $v->frecuencia,
                      'url'         => $v->url
                    ];
        }
        return array_values($data);
    }
}