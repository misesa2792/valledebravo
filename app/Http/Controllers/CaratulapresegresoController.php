<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Caratulapresegreso;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Illuminate\Support\Facades\View;


class CaratulapresegresoController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'caratulapresegreso';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Caratulapresegreso();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'caratulapresegreso',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('caratulapresegreso.index',$this->data);
	}	

	public function getPrincipal( Request $r )
	{
		$this->data['year'] = $r->year;
		$this->data['idy'] = $r->idy;
		$this->data['type'] = $r->type;
		return view('caratulapresegreso.principal',$this->data);
	}
	public function getData(Request $r)
	{
		$idi = 1;
		$row = $this->model->getExisteRegistro($r->type, $idi, $r->idyear);
		$result = ['rowsData' => []];
		if(count($row) > 0){
			$data = $this->getRegistrosPbrm($row[0]->id);
			$result = [
						'rowsData' => $data['data'],
						'autorizado' => $data['autorizado'],
						'ejercido' => $data['ejercido'],
						'presupuesto' => $data['presupuesto'],
						'number' => $row[0]->url,
						'id' => $row[0]->id,
			];
		}
		return response()->json($result);

	}
	private function getRegistrosPbrm($id){
		$data = [];
		$autorizado = $ejercido = $presupuesto = 0;
		foreach ($this->model->getInformacionEdit($id) as $v) {
			$data[] = ['id' 			=> $v->id, 
						'no_capitulo' 	=> $v->no_capitulo, 
						'capitulo' 		=> $v->capitulo, 
						'autorizado'	=> $this->getNumberFormart($v->autorizado),
						'ejercido'		=> $this->getNumberFormart($v->ejercido),
						'presupuesto'	=> $this->getNumberFormart($v->presupuesto),
					];
			$autorizado += $v->autorizado;
			$ejercido += $v->ejercido;
			$presupuesto += $v->presupuesto;
		}
		return ['data' => $data, 
				"autorizado" => $this->getNumberFormart($autorizado),
				"ejercido" => $this->getNumberFormart($ejercido),
				"presupuesto" => $this->getNumberFormart($presupuesto),
			];
	}
	public function postReverse( Request $r )
	{
		$params = $r->params;
		$id = $params['idkey'];
		$this->model->getUpdateTable(['url' => null],"ui_pd_pbrm04d", "idpd_pbrm04d", $id);
		//Cambio el estatus del PDF a 2
		$this->model->updatePlanPDF($params['number']);
		$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		return response()->json($response);
	}
	public function getEdit( Request $r )
	{
		$idi = 1;
		$this->data['year'] = $r->year;
		$this->data['id'] = $r->idkey;
		$this->data['rows'] = $this->model->getInformacionEdit($r->idkey);
		return view('caratulapresegreso.form',$this->data);
	}
	public function getPdf( Request $r )
	{
		$this->data['row'] = $this->getInfoPbrmCuatroD($r->idkey);
		$this->data['token'] = $r->idkey;
		return view('templates.presupuesto.pbrmcuatrod.view',$this->data);
	}
	public function getInfoPbrmCuatroD($id){
		$proy = $this->model->getInfoPdf($id);
		$row = $proy[0];
		$info = $this->getRegistrosPbrm($id);
        $data = [
			"header"		=> [
									"logo_izq"      => $row->logo_izq,
                                    "anio"  		=> $row->anio,
                                    "no_municipio"  => $row->no_institucion,
                                    "municipio"     => $row->institucion,
									"tipo" 	=> $row->tipo,
								],
            "footer"		=> [
									"titular_secretario"     => $row->titular_secretario,
									"titular_tesoreria" => $row->titular_tesoreria
								],
            "id"		    => [
									"idi"   => $row->idi,
								],
			"rowsRegistros" => $info['data'],
			"autorizado" => $info['autorizado'],
			"ejercido" => $info['ejercido'],
			"presupuesto" => $info['presupuesto'],
		];
		return $data;
    }
	function postEdit( Request $r)
	{
		try {
			for ($i=0; $i < count($r->idc) ; $i++) { 
				$data = array(
					"autorizado" => $this->getClearNumber($r->auto[$i]),
					"ejercido" => $this->getClearNumber($r->eje[$i]),
					"presupuesto" => $this->getClearNumber($r->pres[$i]),
				);
				$this->model->getUpdateTable($data, "ui_pd_pbrm04d_reg", "idpd_pbrm04d_reg",$r->idc[$i]);
			}
			$response = ['status' => 'ok', 
						'message' => 'Información actualizada correctamente.'
					];
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar!'.$e->getMessage());
			$response = ['status' => 'error', 'message' => 'Error al guardar'];
		}
    	return response()->json($response);
	}
	public function getSync(Request $r){
		$idi = 1;
		$row = $this->model->getExisteRegistro($r->type, $idi, $r->idyear);
		if(count($row) == 0){
			$data = ['tipo' => $r->type, 'idanio' => $r->idyear, 'idinstituciones' => $idi];
			$id = $this->model->getInsertTable($data, "ui_pd_pbrm04d");
		}else{
			$id = $row[0]->id;
		}
		foreach ($this->model->getCapitulos() as $v) {
			$row = $this->model->getValidarReg($v->id, $id);
			if(count($row) == 0){
				$arr = ["idpd_pbrm04d" => $id, 
						"idteso_capitulos" => $v->id,
						"autorizado" => '0.00',
						"ejercido" => '0.00',
						"presupuesto" =>'0.00',
					];
				$this->model->getInsertTable($arr, "ui_pd_pbrm04d_reg");
			}
		}
	
    	return response()->json(array("response" => "ok"));
	}
	public function postGenerarpdf( Request $r )
	{
		$id = $r->k;
		$row = $this->getInfoPbrmCuatroD($id);
		$this->data['row'] = $row;
		$this->data['request'] = $r->all();
		list($year, $month, $day) = explode("-", $r->fecha);
		$this->data['dia'] = $day;
		$this->data['mes'] = $month;
		$this->data['anio'] = $year;

		//Se construye el nombre del PDF
		if($row['header']['tipo'] == 1){
			$name = "PD4D";
			$folder = "pres";
		}elseif($row['header']['tipo'] == 2){
			$name = "PP4D";
			$folder = "proy";
		}elseif($row['header']['tipo'] == 3){
			$name = "PA4D";
			$folder = "ante";
		}
		$number = $this->getBuildFilenamePDF($name,$row['header']['no_municipio'], '000', $id);
		$filename = $number.".pdf";
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectory($row['header']['no_municipio'], $row['header']['anio'], $folder, '04d');

		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
							'margin_top' => 50,
							'margin_left' => 5,
							'margin_right' => 5,
							'margin_bottom' => 37,
						]);
		$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmcuatrod.pdf_header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmcuatrod.pdf_footer", $this->data)->render());
		$mpdf->WriteHTML(view('templates.presupuesto.pbrmcuatrod.pdf_body',$this->data));
		//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
		//Generación del nombre del PDF
		//Construcción del full path
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		$this->model->getUpdateTable(['url' => $number], "ui_pd_pbrm04d",  "idpd_pbrm04d", $id);
		$this->getInsertTablePlan($row['id']['idi'], $number, $url, $result['directory']);
		//Return del resultado con el key
		$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
		return response()->json($response);
	}
}