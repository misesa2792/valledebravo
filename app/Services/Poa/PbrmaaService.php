<?php
namespace App\Services\Poa;

use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Poa\Pbrmc;
use App\Models\Poa\Pbrmaa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Services\Poa\PoaService;

use SiteHelpers;

use App\Traits\JsonResponds;

use App\Helpers\FunctionHelper;

class PbrmaaService extends Controller
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
            $data = $this->getDataSearchOld($type,$idarea,$idy,$idi);
        }else{
            $data = $this->getDataSearch($type,$idarea,$idy,$idi);
        }
        return $this->success("", $data);
    }
     public function searchGeneral(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $idarea = $request->id;
        $type = $this->poaService->getTypeNumber($request->type);
        $data = $this->getDataSearchGeneral($type,$idy,$idi);
        return $this->success("", $data);
    }
    private function getDataSearchGeneral($type,$idy,$idi){
        $data = [];
        foreach (Pbrmaa::getSearchGeneral($type,$idy,$idi) as $v) {
            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }
            $data[$v->no_dep_gen]['data'][] = ['id' => $v->id, 
                                                'no_dep_aux'    => $v->no_dep_aux, 
                                                'dep_aux'       => $v->dep_aux, 
                                                'no_proyecto' => $v->no_proyecto, 
                                                'proyecto' => $v->proyecto,
                                                'estatus' => $v->aa_estatus,
                                                'c_estatus' => $v->c_estatus,
                                                'url' => $v->aa_url
                                            ];

        }
        return $data;
    }
    private function getDataSearch($type,$idarea,$idy,$idi){
        $data = [];
        foreach (Pbrmaa::getSearch($type,$idarea,$idy,$idi) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }
            $data[$v->no_dep_aux]['data'][] = ['id' => $v->id, 
                                                'no_proyecto' => $v->no_proyecto, 
                                                'proyecto' => $v->proyecto,
                                                'estatus' => $v->aa_estatus,
                                                'c_estatus' => $v->c_estatus,
                                                'url' => $v->aa_url
                                            ];

        }
        return $data;
    }
    private function getDataSearchOld($type,$idarea,$idy,$idi){
        $data = [];
        foreach (Pbrmaa::getSearchOld($idy,$idarea) as $v) {
            if(!isset($data[$v->no_dep_aux])){
                $data[$v->no_dep_aux]=['no_dep_aux' => $v->no_dep_aux, 'dep_aux' => $v->dep_aux];
            }
            $data[$v->no_dep_aux]['data'][] = ['id' => SiteHelpers::CF_encode_json(['id'=>$v->id]), 
                                                'no_proyecto' => $v->no_proyecto, 
                                                'proyecto' => $v->proyecto,
                                                'estatus' => 2,
                                                'c_estatus' => 2,
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
        return view('anteproyecto.pbrmaa.add',$this->data);
    }
    private function dataPDF($id){
        $idi = Auth::user()->idinstituciones;
        $row = Pbrmc::getInfoPbrmC($id);
        $data = [];
        if($row){
            $data = ['year'          => $row->anio,
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
                    'footer'        => [
                                        'dg' => ['titular' => $row->titular,'cargo' => $row->cargo],
                                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $row->idanio),
                                    ],
                    'rowsMetas'   => Pbrmaa::getMetas($id)
                ];
        }
        return $data;
    }
    public function save(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $id = $request->id;
            
            //Se valida que las cantidades entre el 1c y 2a sean iguales
            for ($i = 0; $i < count($request->idaa); $i++) {
                if($request->canual[$i] != $request->anual[$i]){
                    return $this->error(
                                        "La cantidad del PbRM-01c no coincide con la del PbRM-02a en la fila ".($i+1).". ".
                                        "Verifica que ambas cantidades sean iguales."
                                    );
                }
            }

            for ($i = 0; $i < count($request->idaa); $i++) {

                $anual = FunctionHelper::normalizeAmount($request->anual[$i]);
                $t1 = FunctionHelper::normalizeAmount($request->trim1[$i]);
                $t2 = FunctionHelper::normalizeAmount($request->trim2[$i]);
                $t3 = FunctionHelper::normalizeAmount($request->trim3[$i]);
                $t4 = FunctionHelper::normalizeAmount($request->trim4[$i]);

                $data = [
                    'aa_anual' => FunctionHelper::replaceDobleCeros($anual),
                    'aa_trim1' => FunctionHelper::replaceDobleCeros($t1),
                    'aa_trim2' => FunctionHelper::replaceDobleCeros($t2),
                    'aa_trim3' => FunctionHelper::replaceDobleCeros($t3),
                    'aa_trim4' => FunctionHelper::replaceDobleCeros($t4),
                    'aa_porc1' => $request->porc1[$i],
                    'aa_porc2' => $request->porc2[$i],
                    'aa_porc3' => $request->porc3[$i],
                    'aa_porc4' => $request->porc4[$i]
                ];

                $pbrmaa = Pbrmaa::find($request->idaa[$i]);
                $pbrmaa->update($data);
            }

            //Actualizo el estatus
            $row = Pbrmc::find($id);
            $row->update(['aa_estatus' => 2]);

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
        return view('anteproyecto.pbrmaa.generate',$this->data);
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
            $number = $this->getBuildFilenamePDF($type."2A",$row['no_institucion'], $row['no_dep_gen'], $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($row['no_institucion'], $row['year'], $this->poaService->getTypeFolder($type), '02a');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                                    'margin_top' => 54,
                                    'margin_left' => 5,
                                    'margin_right' => 5,
                                    'margin_bottom' => 37,
                                ]);

			$mpdf->SetHTMLHeader(View::make("anteproyecto.pbrmaa.pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("anteproyecto.pbrmaa.pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view('anteproyecto.pbrmaa.pdf.body',$this->data));
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');

            $pbrmc = Pbrmc::find($id);
            if ($pbrmc) {
                $pbrmc->update(['aa_url' => $number]);
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
            $url = $row['aa_url'];
            $row->update(['aa_url' => null]);
  
            $this->updatePlanPDFNew($url);
  
            return $this->success('PDF revertido correctamente!');
        }
        
        return $this->error('ID no encontrado!');
    }
}