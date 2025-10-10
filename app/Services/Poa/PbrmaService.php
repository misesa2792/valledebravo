<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrma;
use App\Models\Poa\Pbrmc;

use App\Services\Poa\PoaService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use SiteHelpers;

use App\Helpers\FunctionHelper;

use App\Traits\JsonResponds;

class PbrmaService extends Controller
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
    
    public function search(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);
        
        if($idy == 0){
            $data = $this->dataSearchOld($type,$idarea, $idy, $idi);
        }else{
            $rows = Pbrma::getSearch($type,$idarea, $idy, $idi);
            $data = $this->dataSearch($rows);
        }

        return $this->success("", $data);
    }

    public function searchGeneral(Request $request)
    {
        $type = $this->poaService->getTypeNumber($request->type);
        
        $rows = Pbrma::getSearchGeneral($type, $request->idy, Auth::user()->idinstituciones);
        
        $data = $this->dataSearchGeneral($rows);

        return $this->success("", $data);
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
        $row = $this->model->getInfoModuleAnio($idi,$idy, $idmodule);
        if($row){
            $this->data['type'] = $type;
            $this->data['id'] = $idarea;
            $this->data['idy'] = $idy;
            $this->data['data'] = ['year'            => $row->anio,
                                    'no_institucion' => $row->no_institucion,
                                    'institucion'    => $row->institucion,
                                    'iddep_gen'      => $data['iddep_gen'],
                                    'no_dep_gen'     => $data['no_dep_gen'],
                                    'dep_gen'        => $data['dep_gen']
                                ];
            $this->data['rowsPogramas'] = $this->model->getProgramas($row->idanio_info);
            return view('anteproyecto.pbrma.add',$this->data);
        }
    }
    public function generate(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        return view('anteproyecto.pbrma.generate',$this->data);
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataEdit($request);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['idy'] = $request->idy;
        $this->data['idarea'] = $request->idarea;
        return view('anteproyecto.pbrma.edit',$this->data);
    }
    public function dataEdit(Request $request){
        $id = $request->id; //ID del registro PbRM-01a
        $type = $request->type;
        $idy = $request->idy;
        $idi = Auth::user()->idinstituciones;
        $data = [];
        $row = Pbrma::getInfoRegistro($id);
        $idmodule = $this->poaService->getModuleNumber($type);
        $info = $this->model->getInfoModuleAnio($idi,$idy,$idmodule);
        if($row){
            $idi = Auth::user()->idinstituciones;
            $data = ['idprograma'   => $row->idprograma,
                    'no_programa'   => $row->no_programa, 
                    'programa'       => $row->programa,
                    'total'          => $row->total,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'anio'           => $row->anio,
                    'rowsDepAux'     => $this->model->getDepAux($request->idarea),//$this->model->getDepAux($idy, $info->idtipo_dependencias),
                    'rowsProyectos'  => $this->model->getProyectos($info->idanio_info, $row->idprograma),//$this->model->getProyectos($info->idanio_info, $row->idprograma),
                    'data' => $this->fetchRows($id)
                ];
        }
        return $data;
    }
    private function fetchRows($id){
        $data = [];
        foreach (Pbrma::getInfoRegistroAux($id) as $v) {
            $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
            $data[] = ['id'                  => $v->id,
                    'idarea_coordinacion'   => $v->idarea_coordinacion,
                    'idproyecto'            => $v->idproyecto,
                    'no_dep_aux'            => $v->no_dep_aux,
                    'dep_aux'               => $v->dep_aux,
                    'no_proyecto'           => $v->no_proyecto,
                    'proyecto'              => $v->proyecto,
                    'presupuesto'           => number_format($amount,2)
                    ];
        }
        return $data;
    }
    public function dataPDF($id){
        $idi = Auth::user()->idinstituciones;
        $data = [];
        $row = Pbrma::getInfoRegistro($id);
        if($row){
            $total = FunctionHelper::centsBigIntToMoney($row->total);
            $data = ['no_programa'   => $row->no_programa, 
                    'programa'       => $row->programa,
                    'total'          => number_format($total,2),
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'anio'           => $row->anio,
                    'footer'         => [
                        'dg' => ['titular' => $row->titular, 'cargo' => $row->cargo],
                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                    ],
                    'data' => $this->fetchRows($id)
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
            $number = $this->getBuildFilenamePDF($type."1A",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['anio'], $this->poaService->getTypeFolder($type), '01a');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                        'margin_top' => 48,
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_bottom' => 35,
                        ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrma.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrma.pdf.footer", $this->data)->render());
            $html = View::make('anteproyecto.pbrma.pdf.body', $this->data)->render();
            $mpdf->WriteHTML($html);
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrma = Pbrma::find($id);
            if ($pbrma) {
                $pbrma->update(['url' => $number]);
                $this->getInsertTablePlan($idi, $number, $url, $result['directory']);
                return $this->success('PDF generado exitosamente.', ['number' => $number]);
            }else{
                return $this->error('El registro no existe!');
            }
        } catch (\Exception $e) {
            \SiteHelpers::auditTrail( $request , 'Error al generar el PDF - PbRM-01a !'.$e->getMessage());
            return $this->error('Error al generar el PDF!');
        }
    }
    public function programas(Request $request)
    {
        $this->data['idp'] = $request->idprograma;
        $this->data['idy'] = $request->idy;
        $this->data['type'] = $request->type;
        $this->data['id'] = $request->id;
        return view('anteproyecto.pbrma.programa',$this->data);
    }
    private function dataSearch($rows = [])
    {
        $data = [];
        $total = 0;
        foreach ($rows as $v) {
            $amount = FunctionHelper::centsBigIntToMoney($v->total);
            $data[] = ['id'         => $v->id,
                    'no_programa'   => $v->no_programa,
                    'programa'      => $v->programa,
                    'total'         => number_format($amount,2),
                    'url'           => $v->url
                ];
            $total = $total + $v->total;
        }
        $totalGeneral = FunctionHelper::centsBigIntToMoney($total);
        return ['data' => $data, 'total' => number_format($totalGeneral, 2) ];
    }
    private function dataSearchGeneral($rows = [])
    {
        $data = [];
        $total = 0;
        foreach ($rows as $v) {
            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['idarea' => $v->idarea,'no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }

            $amount = FunctionHelper::centsBigIntToMoney($v->total);

            $data[$v->no_dep_gen]['data'][] = [
                                                'id'            => $v->id,
                                                'no_programa'   => $v->no_programa,
                                                'programa'      => $v->programa,
                                                'total'         => number_format($amount,2),
                                                'url'           => $v->url
                                            ];
            $total = $total + $v->total;
        }
        $totalGeneral = FunctionHelper::centsBigIntToMoney($total);

        return ['data' => array_values($data), 
                'total' => number_format($totalGeneral, 2) ];
    }
    private function dataSearchOld($type,$idarea, $idy, $idi)
    {
       $data = [];
       $total = 0;
       foreach (Pbrma::getSearchOld($idy,$idarea) as $v) {
        $data[] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]),
                    'no_programa' => $v->no_programa,
                    'programa' => $v->programa,
                    'total' => FunctionHelper::numberFormat($v->total),
                    'url' => $v->url
                ];
        $total = $total + $v->total;
       }
      
       return ['data' => $data, 'total' => FunctionHelper::numberFormat($total) ];
    }
    public function update(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $id = $request->id;

            //Validar que en las cantidades no contenga letras
            /*
                \d{1,3}(?:,\d{3})* → permite números con comas correctas (1,234, 12,345,678).
                |\d+ → o solo dígitos sin comas (1234567).
                (?:\.\d+)? → permite un punto decimal con cualquier cantidad de decimales (opcional).
             */
            $pattern = '/^(?:\d{1,3}(?:,\d{3})*|\d+)(?:\.\d+)?$/';

            for ($i = 0; $i < count($request->ida); $i++) {
                $raw = trim($request->pres[$i]);

                if ($raw === '' || !preg_match($pattern, $raw)) {
                    return $this->error(
                        "El valor de presupuesto en la fila ".($i+1)." es inválido: '{$raw}'. ".
                        "Formato esperado: 9,999.99 (solo dígitos, comas de miles y un punto decimal)."
                    );
                }
            }

            $presupuesto = 0;

            for ($i = 0; $i < count($request->ida); $i++) {
                $idac = $request->iddep_aux[$i];
                $idproyecto = $request->idproyecto[$i];
                $pres = FunctionHelper::parseMoneyToBigInt($request->pres[$i]);
                //Se obtiene el iddep_aux, por que en el request solo viene el idarea_coordinacion, y se va olvidar el campo idarea_coordinacion en un futuro
                $dep_aux = Pbrma::getDepAuxID($idac);

                if($request->ida[$i] > 0){
                    $info = Pbrmc::find($request->ida[$i]);
                    $info->update([
                            'iddep_aux'             => $dep_aux->iddep_aux,
                            'idarea_coordinacion'   => $idac,
                            'idproyecto'            => $idproyecto,
                            'presupuesto'           => $pres
                        ]);
                }else{
                    $pbrmc = [
                        'idpd_pbrma'            => $id,
                        'iddep_aux'             => $dep_aux->iddep_aux,
                        'idarea_coordinacion'   => $idac,
                        'idproyecto'            => $idproyecto,
                        'presupuesto'           => $pres,
                        'c_estatus'             => 1,
                        'aa_estatus'            => 1,
                    ];
                    Pbrmc::create($pbrmc);
                }
                $presupuesto += $pres;
            }

            //Actualizar el campo presupuesto en la tabla pbrma
            $infoPbrma = Pbrma::find($id);
            $infoPbrma->update([ 'presupuesto' => $presupuesto ]);

            DB::commit(); // Confirma la transacción

            return $this->success('Datos guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción
            
            SiteHelpers::auditTrail($request, 'Error al guardar los datos : '.$e->getMessage());
            
            return $this->error('Error al guardar los datos!');
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
            $iddg   = $request->iddg;
            $type   = $this->poaService->getTypeNumber($request->type);
            $idprograma = $request->idprograma;

            //Validar que contenga programa
            if(!isset($request->ida)){
                return $this->error('El programa no tiene proyectos asignados. Por favor, asegúrate de que contenga al menos un proyecto.');
            }

            //Validar que el programa no exista
            $exists = Pbrma::getProgramExists($type, $idi, $idy, $idarea, $idprograma);
            if($exists){
                return $this->error('El programa ya se encuentra registrado en la dependencia. Por favor, verifica para evitar duplicados.');
            }

            //Validar que en las cantidades no contenga letras
            /*
                \d{1,3}(?:,\d{3})* → permite números con comas correctas (1,234, 12,345,678).
                |\d+ → o solo dígitos sin comas (1234567).
                (?:\.\d+)? → permite un punto decimal con cualquier cantidad de decimales (opcional).
             */
            $pattern = '/^(?:\d{1,3}(?:,\d{3})*|\d+)(?:\.\d+)?$/';

            for ($i = 0; $i < count($request->ida); $i++) {
                $raw = trim($request->pres[$i]);

                if ($raw === '' || !preg_match($pattern, $raw)) {
                    return $this->error(
                        "El valor de presupuesto en la fila ".($i+1)." es inválido: '{$raw}'. ".
                        "Formato esperado: 9,999.99 (solo dígitos, comas de miles y un punto decimal)."
                    );
                }
            }
            
            $data = [
                "type"              => $type,
                "idinstituciones"   => $idi,
                "idanio"            => $idy,
                "idarea"            => $idarea,
                "iddep_gen"         => $iddg,
                "idprograma"        => $idprograma,
                "iduser_rg"         => $iduser,
                "std_delete"        => 1,
            ];

            $pbrma = Pbrma::create($data);
            $id = $pbrma->idpd_pbrma;
            $presupuesto = 0;

            for ($i = 0; $i < count($request->ida); $i++) {
                //Se obtiene el iddep_aux, por que en el request solo viene el idarea_coordinacion, y se va olvidar el campo idarea_coordinacion en un futuro
                $dep_aux = Pbrma::getDepAuxID($request->iddep_aux[$i]);
                $pres = FunctionHelper::parseMoneyToBigInt($request->pres[$i]);
                $pbrmc = [
                    'idpd_pbrma'            => $id,
                    'iddep_aux'             => $dep_aux->iddep_aux,
                    'idarea_coordinacion'   => $request->iddep_aux[$i],
                    'idproyecto'            => $request->idproyecto[$i],
                    'presupuesto'           => $pres,
                    'c_estatus'             => 1,
                    'aa_estatus'            => 1,
                ];
                Pbrmc::create($pbrmc);

                $presupuesto += $pres;
            }

            //Actualizar el campo presupuesto en la tabla pbrma
            $infoPbrma = Pbrma::find($id);
            $infoPbrma->update([ 'presupuesto' => $presupuesto ]);

            DB::commit(); // Confirma la transacción
            
            return $this->success('Datos guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }
	public function deletetr(Request $request)
    {
        DB::beginTransaction();
        try {
            $row = Pbrmc::find($request->id);
            if($row){
                //Se elimina el regostro de la tabla ui_pd_pbrma_aux
                $row->delete();

                //Actualizo el total en la tabla pbrma
                $presupuesto = Pbrma::getSumPresupuesto($row->idpd_pbrma);
                $pbrma = Pbrma::find($row->idpd_pbrma);
                //Actualizo el total
                $pbrma->update(['presupuesto' => $presupuesto]);

                DB::commit(); // Confirma la transacción

                return $this->success('Registro eliminado correctamente!');
            }
            
            return $this->error('ID no encontrado!');

        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción

            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }
	public function reverse(Request $request)
    {
        $params = $request->params;
        $row = Pbrma::find($params['id']);
        if($row){
            $url = $row['url'];

            $row->update(['url' => null]);
  
            $this->updatePlanPDFNew($url);

            return $this->success('PDF revertido correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
    public function delete(Request $request)
    {
        $row = Pbrma::find($request->id);
        if($row){
            $row->update(['std_delete' => 2]);

            return $this->success('Registro eliminado correctamente!');
        }

        return $this->error('ID no encontrado!');
    }
	public function tr(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idprograma = $request->idp;
        $type = $request->type;
        $idmodule = $this->poaService->getModuleNumber($type);
        $row = $this->model->getInfoModuleAnio($idi,$idy,$idmodule);
        if($row){
            $this->data['rowsDepAux'] = $this->model->getDepAux($request->id);
            $this->data['rowsProyectos'] = $this->model->getProyectos($row->idanio_info, $idprograma);
            $this->data['time'] = rand(5,9999).time();
            return view('anteproyecto.pbrma.tr',$this->data);
        }
    }
    
    
}