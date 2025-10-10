<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrme;
use App\Models\Poa\Pbrmereg;
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

use App\Traits\JsonResponds;

use SiteHelpers;
class PbrmeService extends Controller
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
    
    public function edit(Request $request)
    {
        $data = $this->dataEdit($request);
        $this->data['data'] = $data;
        $this->data['id'] = $request->id;
        $this->data['type'] = $request->type;
        $this->data['idy'] = $request->idy;
        $this->data['idarea'] = $request->idarea;
        $this->data['no_matriz'] = $data['no_matriz'];
        $this->data['idprograma'] = $data['idprograma'];
        return view('anteproyecto.pbrme.edit',$this->data);
    }
    public function editmatriz(Request $request)
    {
        $data = $this->dataEdit($request);
        return $this->success('Petición exitosa',['fin' => $data['rows']['fin'],
                'proposito' => $data['rows']['proposito'],
                'componente' => $data['rows']['componente'],
                'actividad' => $data['rows']['actividad']  ]);
    }
    public function dataEdit(Request $request){
        $id = $request->id; //ID del registro PbRM-01e
        $data = [];
        $row = Pbrme::getInfoRegistro($id);
        if($row){
            $matriz = $this->dataMatrizEdit($id);
            //Matriz
            $matrizAux = $this->dataMatrizFull($row->idprograma, $matriz, $row->no_matriz);
            $data = ['no_matriz'     => $row->no_matriz, 
                    'idprograma'     => $row->idprograma,
                    'no_programa'    => $row->no_programa, 
                    'programa'       => $row->programa,
                    'obj_programa'   => $row->obj_programa,
                    'no_pilar'       => $row->no_pilar,
                    'pilar'          => $row->pilar,
                    'no_tema'        => $row->no_tema,
                    'tema'           => $row->tema_desarrollo,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'anio'           => $row->anio,
                    'rows' => $matrizAux
                ];
        }

        return $data;
    }
    private function dataMatrizFull($idprograma,$rows, $no_matriz){
        $fin = [];
        $proposito = [];
        $componente = [];
        $actividad = [];
        foreach (Pbrme::getMatrizPrograma($idprograma, $no_matriz) as $row) {
            $idprograma_reg = $row->idprograma_reg;
            $data = $this->formatMatriz($row);
            if($row->tipo == 1){ 
                $data['checked'] = true;
                $fin = $data;
            } elseif($row->tipo == 2){
                $data['checked'] = true;
                $proposito = $data;
            } elseif($row->tipo == 3){
                if(isset($rows[$idprograma_reg])){
                    $data['checked'] = true;
                }
                $componente[] = $data;
            } elseif($row->tipo == 4){
                if(isset($rows[$idprograma_reg])){
                    $data['checked'] = true;
                }
                $actividad[] = $data;
            } 
        }
        return ['fin'           => $fin, 
                'proposito'     => $proposito, 
                'componente'    => $componente, 
                'actividad'     => $actividad,
                ];
    }
    private function formatMatriz($row){
        $data = ['idprograma_reg'       => $row->idprograma_reg, 
                'idprograma_reg_rel'    => $row->idprograma_reg_rel, 
                'idprograma'            => $row->idprograma,
                'tipo'                  => $row->tipo,
                'descripcion'           => $row->descripcion,
                'nombre'                => $row->nombre,
                'formula'               => $row->formula,
                'idfrecuencia_medicion' => $row->idfrecuencia_medicion,
                'idtipo_indicador'      => $row->idtipo_indicador,
                'medios'                => $row->medios,
                'supuestos'             => $row->supuestos,
                'idmir_formula'         => $row->idmir_formula,
                'idind_estrategicos'    => $row->idind_estrategicos,
                'frecuencia'            => $row->frecuencia,
                'tipo_indicador'        => $row->tipo_indicador,
                //Estos 2 campos son los que se relacionan con la tabla ui_ind_estrategicos
                'codigo'                => $row->mir,
                'indicador'             => $row->indicador,
                'checked'               => false //Estatus para la edicicón
                ];
        return $data;
    }
    private function dataMatrizEdit($id){
        $data = [];
        foreach (Pbrme::getRowsMatrices($id) as $row) {
           $data[$row->idprograma_reg] = $row->id;
        }
        return $data;
    }
    public function editar(Request $request)
    {
        try {
            if(count($request->componentes) == 0){
                return $this->error('Selecciona mínimo un componente!');
            }
            if(count($request->actividades) == 0){
                return $this->error('Selecciona mínimo una actividad!');
            }

            $idpd_pbrme = $request->id;
            //Matriz registrada
            $data = $this->getDataMatrizIds($idpd_pbrme);
            //Matriz seleccionada al editar
            $componentes = $this->getDataMatrizEdit($request->componentes);
            $actividades = $this->getDataMatrizEdit($request->actividades);
    
            //Se valida si la matriz registrada no esta registrada
            foreach ($data['comp'] as $v) {
                $idprograma_reg = $v['idprograma_reg'];

                if(isset($componentes[$idprograma_reg])){
                    //No hacer nada por que el registro existe, solo es cambiar el checked en false para que no se inserte 
                    $componentes[$idprograma_reg]['checked'] = false;
                }else{
                    //No hacer nada por que el registro existe, solo es cambiar el checked en false para que no se inserte 
                    $this->getDeleteMatrizID($v['id']);
                }
            }
             foreach ($data['act'] as $v) {
                $idprograma_reg = $v['idprograma_reg'];

                if(isset($actividades[$idprograma_reg])){
                    $actividades[$idprograma_reg]['checked'] = false;
                }else{
                    //Eliminar el registro que no existe
                    $this->getDeleteMatrizID($v['id']);
                }
            }

            //Se insertan los nuevos registros
            foreach ($componentes as $c) {
                //True es para validar nuevos registros
                if($c['checked'] == true){
                    $this->getInsertNewMatriz($idpd_pbrme, $c['id'], 0 , 0);
                }
            }

            foreach ($actividades as $a) {
                //True es para validar nuevos registros
                if($a['checked'] == true){
                    $this->getInsertNewMatriz($idpd_pbrme, $a['id'], 0 , 0);
                }
            }

            return $this->success('Datos guardados correctamente.');
        } catch (\Exception $e) {
            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }

    private function getDeleteMatrizID($id){
         $matriz = Pbrmereg::find($id);
        if ($matriz) {
            $matriz->delete();
            //Checar por que ahroa los indicadores se eliminan el otro módulo
            //Pbrmd::getDeleteIndicador($idpd_pbrme_matriz);
        }
        return true;
    }

    private function getDataMatrizIds($idpd_pbrme){
        $dataComp = [];
        $dataAct = [];
        foreach (Pbrme::getMatrizIds($idpd_pbrme) as $v) {
            if($v->tipo == 3){
                $dataComp[] = ['idprograma_reg' => $v->idprograma_reg, 'id' => $v->id ];
            }else if($v->tipo == 4){
                $dataAct[] = ['idprograma_reg' => $v->idprograma_reg, 'id' => $v->id ];
            }

        }
        return ['comp' => $dataComp, 'act' => $dataAct];
    }
    private function getDataMatrizEdit($rows){
        $data = [];
        foreach ($rows as $id) {
            $data[$id] = ['id' => $id, 'checked' => true ];
        }
        return $data;
    }
    public function store(Request $request)
    {
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $request->type;
        $this->data['idy'] = $idy;
        $idi = Auth::user()->idinstituciones;
        $area = Area::find($idarea,['numero', 'descripcion']);
        $idmodule = $this->poaService->getModuleNumber($type);
        $row = $this->model->getInfoModuleAnio($idi, $idy, $idmodule);
        if($row){
            $this->data['type'] = $type;
            $this->data['id'] = $idarea;
            $this->data['idy'] = $idy;
            $this->data['data'] = ['year'            => $row->anio,
                                    'no_institucion' => $row->no_institucion,
                                    'institucion'    => $row->institucion,
                                    'no_dep_gen'     => $area->numero,
                                    'dep_gen'        => $area->descripcion
                                ];
            $this->data['rowsPogramas'] = $this->model->getProgramasMatricez($row->idanio_info);
            //$this->data['rowsProyectos'] = $this->model->getProyectosPorYear($row->idanio_info);
            //$this->data['rowsDepAux'] = $this->model->getDepAux($idarea);
            return view('anteproyecto.pbrme.add',$this->data);
        }
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            if(count($request->componentes) == 0){
                return $this->error('Selecciona mínimo un componente!');
            }
            if(count($request->actividades) == 0){
                return $this->error('Selecciona mínimo una actividad!');
            }

            $idi = Auth::user()->idinstituciones;
            $iduser = Auth::user()->id;
            $idy = $request->idy;
            $idarea = $request->id;
            $idprograma = $request->idprograma;
            $type = $this->poaService->getTypeNumber($request->type);

            $validated = Pbrme::getValidatedRecord($type, $idi, $idy, $idarea, $idprograma);

            if($validated){
                return response()->json([
                    'status' => 'error',
                    'message' => 'El programa ya fue asignado a la dependencia general, por lo que no es posible volver a asignarlo.!'
                ]);
            }

            $data = [
                "type"                => $type,
                "idinstituciones"     => $idi,
                "idanio"              => $idy,
                "idarea"              => $idarea,
                "idprograma"          => $idprograma,
                "iduser_rg"           => $iduser,
                "std_delete"          => 1,
                "no_matriz"           => $request->no_matriz
            ];

            $pbrme = Pbrme::create($data);
            $id = $pbrme->idpd_pbrme;

            $this->getInsertNewMatriz($id, $request->fin);
            $this->getInsertNewMatriz($id, $request->proposito);

            for ($i=0; $i < count($request->componentes); $i++) { 
                $this->getInsertNewMatriz($id, $request->componentes[$i]);
            }

            for ($i=0; $i < count($request->actividades); $i++) { 
                $this->getInsertNewMatriz($id, $request->actividades[$i]);
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
    private function getInsertNewMatriz($idpd_pbrme, $idprograma_reg){
        //Insertar en la tabla ui_pd_pbrme_reg
        Pbrmereg::create(['idpd_pbrme' => $idpd_pbrme, 'idprograma_reg' => $idprograma_reg]);
        //Ahora estos se insertan en la tabla ui_pd_pbrmd manualmente
       // $row = Pbrme::getProgramaReg($idprograma_reg);
       // $this->insertMatrizPrograma($idpd_pbrme, $row, $idproyecto, $idac);
    }
    /*private function insertMatrizPrograma($id, $row, $idproyecto, $idac){
        $data = [
            'idpd_pbrme'            => $id,
            'idarea_coordinacion'   => $idac,
            'idproyecto'            => $idproyecto,
            'idprograma_reg'        => $row->idprograma_reg,
            'tipo'                  => $row->tipo,
            'descripcion'           => $row->descripcion,
            'mir'                   => $row->codigo,
            'nombre'                => $row->indicador,
            'formula'               => $row->formula,
            'idfrecuencia_medicion' => $row->idfrecuencia_medicion,
            'idtipo_indicador'      => $row->idtipo_indicador,
            'medios'                => $row->medios,
            'supuestos'             => $row->supuestos,
            'idmir_formula'         => $row->idmir_formula,
            'idind_estrategicos'    => $row->idind_estrategicos
        ];

        $pbrm = Pbrmd::create($data);
        $id = $pbrm->idpd_pbrme_matriz;

        //Se inserta los indicaores
        foreach (Pbrme::getIndicadoresReg($row->idind_estrategicos) as $v) {
            $indicador = ['idpd_pbrme_matriz' => $id,'nombre_corto' => $v->nombre_corto, 'nombre_largo' => $v->nombre_largo ];
            Pbrmdindicador::create($indicador);
        }
    }*/
    public function matriz(Request $request)
    {
        $rows = Pbrme::getMatrizPrograma($request->idprograma, $request->no_matriz);
        $this->data['rows'] = $this->dataMatriz($rows);
        return $this->success('matriz',$this->data['rows']);
    }
    public function generate(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['view'] = $request->view;
        return view('anteproyecto.pbrme.generate',$this->data);
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
            $rows = Pbrme::getSearch($type, $idarea, $idy, $idi);
            $data = $this->getDataSearch($rows);
        }

        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }
    public function searchGeneral(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $type = $this->poaService->getTypeNumber($request->type);

        $rows = Pbrme::getSearchGeneral($type, $idy, $idi);
        $data = $this->getDataSearchGeneral($rows);

        return $this->success("PbRM-01b", array_values($data));
    }
    private function getDataSearchGeneral($rows = []){
        $data = [];
        foreach ($rows as $v) {
            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }
            $data[$v->no_dep_gen]['data'][] = ['id'             => $v->id, 
                                                'no_dep_aux'    => $v->no_dep_aux, 
                                                'dep_aux'       => $v->dep_aux, 
                                                'no_programa'   => $v->no_programa,
                                                'programa'      => $v->programa,
                                                'no_proyecto'   => $v->no_proyecto,
                                                'proyecto'      => $v->proyecto,
                                                'url'           => $v->url
                                            ];

        }
        return $data;
    }
    private function getDataSearch($rows){
         $data = [];
        foreach ($rows as $v) {
            $data[] = ['id'     => $v->id, 
                'no_programa'   => $v->no_programa, 
                'programa'      => $v->programa,
                'url'           => $v->url
            ];
        }
        return $data;
        //old
        $data = [];
        foreach ($rows as $v) {
             if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }
            $data[$v->no_dep_aux]['data'][] = ['id'             => $v->id, 
                                                'no_programa'   => $v->no_programa, 
                                                'programa'      => $v->programa,
                                                'no_proyecto'   => $v->no_proyecto,
                                                'proyecto'      => $v->proyecto,
                                                'url'           => $v->url
                                            ];
        }
        return array_values($data);
    }
    private function getDataSearchOld($type,$idarea,$idy,$idi){
        $data = [];
        foreach (Pbrme::getSearchOld($idy,$idarea) as $v) {
            $data[] = ['id'     => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                'no_programa'   => $v->no_programa, 
                'programa'      => $v->programa,
                'url'           => $v->url
            ];
        }
        return $data;
        //Old
        $data = [];
        foreach (Pbrme::getSearchOld($idy,$idarea) as $v) {
             if(!isset($data['000'])){
                $data['000']=['no_dep_aux' => '000', 'dep_aux' => 'Sin dependencia auxiliar'];
            }

            $data['000']['data'][] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                        'no_programa' => $v->no_programa, 
                        'programa' => $v->programa,
                        'url' => $v->url
                    ];

        }
        return array_values($data);
    }
    public function delete(Request $request)
    {
        $row = Pbrme::find($request->id);
        if($row){
            $row->update(['std_delete' => 2]);
            return $this->success('Registro eliminado correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    public function reverse(Request $request)
    {
        $params = $request->params;
        $row = Pbrme::find($params['id']);
        if($row){
            $url = $row['url'];

            $row->update(['url' => null]);
  
            $this->updatePlanPDFNew($url);
  
            return $this->success('PDF revertido correctamente!');
        }

        return $this->error('ID no encontrado!');
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
            $number = $this->getBuildFilenamePDF($type."1E",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['anio'], $this->poaService->getTypeFolder($type), '01e');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                        'margin_top' => 67,
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_bottom' => 35,
                        ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrme.pdf.header", $this->data)->render());
			$mpdf->WriteHTML(view('anteproyecto.pbrme.pdf.body',$this->data));
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrme.pdf.footer", $this->data)->render());
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrme = Pbrme::find($id);
            if ($pbrme) {
                $pbrme->update(['url' => $number]);
                $this->getInsertTablePlan($idi, $number, $url, $result['directory']);
                //Return del resultado con el key
                return $this->success('PDF generado exitosamente.',['number' => $number]);
            }else{
                return $this->error('ID no encontrado!');
            }
        } catch (\Exception $e) {
            \SiteHelpers::auditTrail( $request , 'Error:'.$e->getMessage());

            return $this->error('Error al generar el PDF!');
        }
    }
    private function dataPDF($id){
        $idi = Auth::user()->idinstituciones;
        $data = [];
        $row = Pbrme::getInfoRegistro($id);
        if($row){
            $rows = Pbrme::getRowsMatrices($id);

            $data = ['no_programa'   => $row->no_programa, 
                    'programa'       => $row->programa,
                    'obj_programa'   => $row->obj_programa,
                    'no_pilar'       => $row->no_pilar,
                    'pilar'          => $row->pilar,
                    'no_tema'        => $row->no_tema,
                    'tema'           => $row->tema_desarrollo,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'anio'           => $row->anio,
                    'footer'         => [
                        'dg' => ['titular' => $row->titular, 'cargo' => $row->cargo],
                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                    ],
                    'rows' => $this->dataMatriz($rows)
                ];
        }
        return $data;
    }
    private function dataMatriz($rows){
        $fin = [];
        $proposito = [];
        $componente = [];
        $actividad = [];
        foreach ($rows as $row) {
            if($row->tipo == 1){
                $fin = $row;
            } elseif($row->tipo == 2){
                $proposito = $row;
            } elseif($row->tipo == 3){
                $componente[] = $row;
            } elseif($row->tipo == 4){
                $actividad[] = $row;
            } 
        }
        return ['fin'           => $fin, 
                'proposito'     => $proposito, 
                'componente'    => $componente, 
                'actividad'     => $actividad,
                ];
    }
}