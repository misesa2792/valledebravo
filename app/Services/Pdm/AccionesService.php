<?php
namespace App\Services\Pdm;

use App\Http\Controllers\controller;

use App\Models\Avanceacciones;
use App\Models\Alineacion;
use App\Models\Access\Years;
use App\Models\Anios;

use App\Services\Poa\PoaService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\View;

class AccionesService extends Controller
{
	protected $data;	
	protected $model;	
	protected $poaService;	
	const MODULE_ID = 5;
	public $module = 'avanceacciones';
    public function __construct(Avanceacciones $model, PoaService $poaService)
	{
		$this->model = $model;
		$this->poaService = $poaService;
		$this->data = array(
			'pageTitle'	=> "Avance de Obras o Acciones",
			'pageNote'	=> "Lista de registros de avance de obras o acciones",
			'pageModule'=> $this->module
		);
	}
    public function index(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE_ID, $idi);
        return view($this->module.'.index',$this->data);
    }
	public function ejes(Request $request)
    {
		$this->data['rowsPilares'] = $this->getDataPilares($request->idy);
		$this->data['idy'] = $request->idy;
        return view($this->module.'.pilares',$this->data);
    }
	public function metas(Request $request)
    {
		$this->data['idy'] = $request->idy;
		$this->data['id'] = $request->id;
		$this->data['idt'] = $request->idt;
        return view($this->module.'.temas',$this->data);
    }
	public function loadpdm(Request $request)
    {
		$data = [];
		foreach (Alineacion::getPïlaresTema($request->idt) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_tema, 'tema' => $v->tema, 'subtemas' => $this->getSubtemas($v->id,$request->idy)];
		}
		$this->data['data'] = $data;
		$this->data['idy'] = $request->idy;
		$this->data['idt'] = $request->idt;
        return view($this->module.'.viewtemas',$this->data);
    }
	public function generate(Request $request)
    {
		$this->data['idy'] = $request->idy;
		$this->data['idmeta'] = $request->idmeta;
		$this->data['trim'] = $request->trim;
		$this->data['data'] = $this->dataPDF($request->idmeta, $request->idy);
        return view($this->module.'.generate',$this->data);
    }
	public function dataPDF($idmeta,$idy)
	{
        $idi = Auth::user()->idinstituciones;
		$row = $this->model->getInfoMeta($idmeta);
		$year = Anios::find($idy,['anio']);
		$data = ['year' 			=> $year['anio'],
				'pilares' 			=> $row->pilares,
				'no_meta' 			=> $row->no_meta,	
				'meta' 				=> $row->meta,
				'no_meta_pdm' 		=> $row->no_meta_pdm,
				'meta_pdm' 			=> $row->meta_pdm,
				'no_linea_accion' 	=> $row->no_linea_accion,
				'linea_accion' 		=> $row->linea_accion,
				'footer'        	=> [
                                        'firmas' => $this->poaService->getTitularesLogosFormatos($idi, $idy),
                                    ],
				];
		return $data;
	}
	public function pdf(Request $request)
    {
		try {
            $idi = Auth::user()->idinstituciones;
			$id = $request->idmeta;
            $row = $this->dataPDF($id, $request->idy);
            $this->data['data'] = $row;
            $this->data['request'] = $request->all();
			$no_institucion = "101";
            //Se construye el nombre del PDF
            $number = $this->getBuildFilenamePDF("APDM",$no_institucion, "XXX", $id);
            $filename = $number.".pdf";
            //Construcción del directorio donde se va almacenar el PDF
            $result = $this->getBuildDirectory($no_institucion, $row['year'], 'pdm', 'acciones');
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
                        'margin_top' => 24,
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_bottom' => 35,
                        ]);

			$mpdf->SetHTMLHeader(View::make($this->module.".pdf.header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make($this->module.".pdf.footer", $this->data)->render());
			$mpdf->WriteHTML(view($this->module.'.pdf.body',$this->data));
            //Construcción del full path
            $url = $result['full_path'].$filename;
            //Save PDF in directory
            $mpdf->Output($url, 'F');
            
			$this->model->getUpdateTable(['trim'.$request->trim => $number], "ui_pdm_pilares_pbrm","idpdm_pilares_pbrm",$id);
			$this->getInsertTablePlan($idi, $number, $url, $result['directory']);

			return response()->json([
				'status'  => 'ok',
				'message' => 'PDF generado exitosamente.',
				'number'  => $number
			]);
        } catch (\Exception $e) {
            \SiteHelpers::auditTrail( $request , 'Error al generar el PDF - PbRM-01a !'.$e->getMessage());

            return response()->json([
                'status' => 'error',
                "message"=>"Error al generar el PDF!"
            ]);
        }
    }












	private function getSubtemas($id,$idy)
	{
		$data = [];
		foreach (Alineacion::getPïlaresSubTema($id) as $v) {
			$data[] = ['id' => $v->id, 'subtema' => $v->subtema, 'objetivos' => $this->getObjetivos($v->id,$idy)];
		}
		return $data;
	}
	private function getObjetivos($id,$idy)
	{
		$data = [];
		foreach (Alineacion::getPïlaresObjetivos($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_objetivo,'objetivo' => $v->objetivo,'estrategias' => $this->getEstrategias($v->id,$idy)];
		}
		return $data;
	}
	private function getEstrategias($id,$idy)
	{
		$data = [];
		foreach (Alineacion::getPïlaresEstrategias($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_est,'est' => $v->est,'lineas' => $this->getLineasAccion($v->id,$idy)];
		}
		return $data;
	}
	private function getLineasAccion($id,$idy)
	{
		$data = [];
		foreach (Alineacion::getLineasAccion($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->no_la,'la' => $v->la, 'metas' => $this->getMetasPbrm($v->id,$idy)];
		}
		return $data;
	}
	private function getMetasPbrm($id,$idy)
	{
		$data = [];
		foreach (Alineacion::getPdmMetas($id) as $v) {
			$data[] = ['id' => $v->id, 'no' => $v->clave,'meta' => $v->meta, 'metas' => Alineacion::getPdmMetasPbrm($v->id,$idy)];
		}
		return $data;
	}
	private function getDataPilares($idy)
	{
		$data = [];
		foreach (Alineacion::getPilaresEjes($idy) as $v) {
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
	
}