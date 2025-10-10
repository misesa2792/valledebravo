<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrmaa;
use App\Models\Poa\Pbrmc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\Services\Poa\PoaService;

use SiteHelpers;

use App\Helpers\FunctionHelper;

use App\Traits\JsonResponds;

class PbrmcService extends Controller
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
        if($idy == 0){//Año 2025
            $data = $this->getDataSearchOld($type,$idarea, $idy, $idi);
        }else{
            $data = $this->getDataSearch($type,$idarea, $idy, $idi);
        }
        return $this->success("PbRM-01c", $data);
    }
    public function searchGeneral(Request $request)
    {
        $type = $this->poaService->getTypeNumber($request->type);
        $rows = Pbrmc::getSearchGeneral($type, $request->idy, Auth::user()->idinstituciones);
        $data = $this->getDataSearchGeneral($rows);
        return $this->success("PbRM-01c", $data);
    }
    private function getDataSearch($type,$idarea, $idy, $idi){
        $data = [];
        foreach ( Pbrmc::getSearch($type,$idarea, $idy, $idi) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }
            $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
            $data[$v->no_dep_aux]['data'][] = ['id' => $v->id, 
                                                'no_proyecto' => $v->no_proyecto, 
                                                'proyecto' => $v->proyecto,
                                                'presupuesto' => number_format($amount, 2),
                                                'estatus' => $v->c_estatus,
                                                'url' => $v->c_url
                                            ];

        }
        return $data;
    }
    private function getDataSearchGeneral($rows = []){
        $data = [];
        foreach ($rows as $v) {
            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }
            $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
            $data[$v->no_dep_gen]['data'][] = ['id'             => $v->id, 
                                                'no_dep_aux'    => $v->no_dep_aux, 
                                                'dep_aux'       => $v->dep_aux, 
                                                'no_proyecto'   => $v->no_proyecto,
                                                'proyecto'      => $v->proyecto,
                                                'presupuesto'   => number_format($amount, 2),
                                                'estatus'       => $v->c_estatus,
                                                'url'           => $v->c_url
                                            ];

        }
        return $data;
    }
    private function getDataSearchOld($type,$idarea, $idy, $idi){
        $data = [];
        foreach (Pbrmc::getSearchOld($idy,$idarea) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }
            $data[$v->no_dep_aux]['data'][] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                                                'no_proyecto' => $v->no_proyecto, 
                                                'proyecto' => $v->proyecto,
                                                'presupuesto' => FunctionHelper::numberFormat($v->presupuesto),
                                                'estatus' => 2,
                                                'url' => $v->url
                                            ];

        }
        return $data;
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $this->data['id'] = $id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['rowsUnidadMedida'] = $this->model->getUnidadMedidas();
        return view('anteproyecto.pbrmc.add',$this->data);
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $id = $request->id;
            $limitCaracter = 120;
            //Validar que contenga programa
            if(!isset($request->idag)){
                return $this->error('El proyecto no tiene metas asignadas. Por favor, asegúrate de que contenga al menos una meta.');
            }

            for ($i = 0; $i < count($request->idag); $i++) {
                if (mb_strlen($request->meta[$i], 'UTF-8') > $limitCaracter) {
                    return $this->error("La descripción de meta en la fila ".($i+1)." excede el límite de 120 caracteres: actualmente tiene " . mb_strlen($request->meta[$i], 'UTF-8') . " caracteres.");
                }
            }

            for ($i = 0; $i < count($request->idag); $i++) {
                $programado = FunctionHelper::normalizeAmount($request->programado[$i]);
                $alcanzado = FunctionHelper::normalizeAmount($request->alcanzado[$i]);
                $anual = FunctionHelper::normalizeAmount($request->anual[$i]);
                $data = [
                    'idpd_pbrma_aux'    => $id,
                    'codigo'            => $request->numero[$i],
                    'meta'              => trim($request->meta[$i]),
                    'unidad_medida'     => $request->medida[$i],
                    'c_programado'      => FunctionHelper::replaceDobleCeros($programado),
                    'c_alcanzado'       => FunctionHelper::replaceDobleCeros($alcanzado),
                    'c_anual'           => FunctionHelper::replaceDobleCeros($anual),
                    'c_absoluta'        => $request->absoluta[$i],
                    'c_porcentaje'      => $request->porcentaje[$i]
                ];
                if($request->idag[$i] == 0){
                    Pbrmaa::create($data);
                }else{
                    $pbrmaa = Pbrmaa::find($request->idag[$i]);
                    $pbrmaa->update($data);
                }
            }

            //Actualizar estatus
            $row = Pbrmc::find($id);
            $row->update(['c_estatus' => 2]);

            DB::commit();
            
            return $this->success('Datos guardados correctamente');

        } catch (\Exception $e) {
            DB::rollBack();

            SiteHelpers::auditTrail($request, 'Error: '.$e->getMessage());

            return $this->error('Error al guardar los datos!');
        }
    }
    public function generate(Request $request)
    {
        $id = $request->id;
        $this->data['data'] = $this->dataPDF($id);
        $this->data['id'] = $id;
        $this->data['type'] = $request->type;
        $this->data['view'] = $request->view;
        return view('anteproyecto.pbrmc.generate',$this->data);
    }
    private function dataPDF($id){
        $idi = Auth::user()->idinstituciones;
        $row = Pbrmc::getInfoPbrmC($id);
        $data = [];
        if($row){
            $amount = FunctionHelper::centsBigIntToMoney($row->presupuesto);
            $data = ['year'            => $row->anio,
                    'no_institucion' => $row->no_institucion,
                    'institucion'    => $row->institucion,
                    'no_dep_gen'     => $row->no_dep_gen,
                    'dep_gen'        => $row->dep_gen,
                    'no_dep_aux'     => $row->no_dep_aux,
                    'dep_aux'        => $row->dep_aux,
                    'no_proyecto'    => $row->no_proyecto,
                    'proyecto'       => $row->proyecto,
                    'obj_proyecto'   => $row->obj_proyecto,
                    'no_programa'   => $row->no_programa,
                    'programa'      => $row->programa,
                    'presupuesto'   => number_format($amount, 2),
                    'footer'        => [
                                        'dg' => ['titular' => $row->titular,'cargo' => $row->cargo],
                                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                                    ],
                    'rowsMetas'   => Pbrmc::getMetas($id)
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
            $number = $this->getBuildFilenamePDF($type."1C",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['year'], $this->poaService->getTypeFolder($type), '01c');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                                    'margin_top' => 65,
                                    'margin_left' => 5,
                                    'margin_right' => 5,
                                    'margin_bottom' => 33,
                                ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrmc.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrmc.pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view('anteproyecto.pbrmc.pdf.body',$this->data));
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrmc = Pbrmc::find($id);
            if ($pbrmc) {
                $pbrmc->update(['c_url' => $number]);
                $this->getInsertTablePlan($idi, $number, $url, $result['directory']);
                
                return $this->success('PDF generado exitosamente.', ['number' => $number]);
            }
            
            return $this->error('ID no encontrado!');

        } catch (\Exception $e) {
            \SiteHelpers::auditTrail( $request , 'Error: '.$e->getMessage());

            return $this->error('Error al generar el PDF!');
        }
    }
    public function reverse(Request $request)
    {
        $params = $request->params;
        $row = Pbrmc::find($params['id']);
        if($row){
            $url = $row['c_url'];
            $row->update(['c_url' => null]);
  
            $this->updatePlanPDFNew($url);
  
            return $this->success('PDF revertido correctamente!');
        }
        
        return $this->error('ID no encontrado!');
    }
    public function deletetr(Request $request)
    {
        $row = Pbrmaa::find($request->id);
        if($row){
            $row->delete();
            
            return $this->success('Registro eliminado correctamente!');
        }
        
        return $this->error('ID no encontrado!');
    }
    public function tr()
    {
        $this->data['rowsUnidadMedida'] = $this->model->getUnidadMedidas();
        $this->data['time'] = rand(5,9999).time();
        return view('anteproyecto.pbrmc.tr',$this->data);
    }
    
    
}