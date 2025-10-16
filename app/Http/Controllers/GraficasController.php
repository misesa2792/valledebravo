<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Graficas;
use App\Models\Exportar;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Illuminate\Support\Facades\View;

class GraficasController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	protected $model;	
	protected $exportar;	
	protected $info;	
	protected $access;	
	public $module = 'graficas';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Graficas();
		$this->exportar = new Exportar();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'graficas',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
	}	
	
	public function postSaveimg(Request $r)
	{
		$imageData = $r->input('image_data');
        // Decodificar los datos de imagen codificados en base64
        list($type, $imageData) = explode(';', $imageData);
        list(, $imageData) = explode(',', $imageData);
        $decodedImage = base64_decode($imageData);
        // Generar un nombre único para la imagen
        $imageName = 'captured_chart_' . time() . '.png';
        // Ruta donde se guardará la imagen
        $imagePath = public_path('archivos/graficas/' . $imageName);
        // Guardar la imagen en el servidor
        file_put_contents($imagePath, $decodedImage);

        // Devolver la URL completa de la imagen
      //  $imageUrl = url('images/' . $imageName);

        // Devolver la URL de la imagen en formato JSON
		$response = array("imagen"=>$imageName);
        return json_encode($response);
	}
	public function getPdf(Request $r){
		$idi = \Auth::user()->idinstituciones;
		$type = 0;
		$this->data['image_url'] = $r->image_url;
		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 30,
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_bottom' => 30,]);

		$this->data['no'] = $r->no;
		$this->data['no_tipo'] = $r->no_tipo;

		$dep_gen = $this->model->getCatDepGen($r->ida);
		$this->data['dep_gen'] = $dep_gen[0];

		$ins = $this->model->getInstitucion($idi);
		$this->data['ins'] = $ins[0];
	
		$this->data['info'] = json_decode($this->getRowsGraficaproyectos($r->ida,$r->no,$r->idanio,$r->no_tipo,$type));
		$mpdf->SetHTMLHeader(View::make("graficas.pdf.header_banner", $this->data)->render());
		// Establecer el encabezado y pie de página
		$mpdf->WriteHTML(view('graficas.pdf.pdf',$this->data));
		//$mpdf->SetHTMLFooter(View::make("graficas.pdf.footer_banner", $this->data)->render());
		
		$time = time();
		return $mpdf->Output();
	}
	public function getPdfgeneral(Request $r){
		$this->data['image_url'] = $r->image_url;
		$this->data['type'] = $r->type;
		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 30,
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_bottom' => 30,]);

		$this->data['info'] = json_encode($this->getRowsGraficaGeneral($r->idanio,$r->type));
		$mpdf->SetHTMLHeader(View::make("graficas.pdfgeneral.header_banner", $this->data)->render());
		// Establecer el encabezado y pie de página
		//$mpdf->SetHTMLFooter(View::make("graficas.pdfgeneral.footer_banner", $this->data)->render());
		$mpdf->WriteHTML(view('graficas.pdfgeneral.pdf',$this->data));
		
		$time = time();
		return $mpdf->Output();
	}
	public function getGrafica(Request $r){
		$arr = array('rows' => $this->getRowsGraficaGeneral($r->idanio,$r->type));
		return json_encode($arr);
	}
	public function getRowsGraficaGeneral($idanio,$type){
		$idi = \Auth::user()->idinstituciones;
		$i = 1;
		foreach ($this->model->getGraficaMetasGeneral($idanio,$type,$idi) as $key => $v) {
			$porcentaje = ($v->cantidad * 100)/$v->prog_anual;
			$data[] = array('no' => $v->idarea,
							'cant' => number_format($porcentaje,2), 
							'dep_gen'=>$v->dep_gen,
							'prog_anual'=>number_format($v->prog_anual,2), 
							'cantidad'=>number_format($v->cantidad,2)
						);
		}
		return $data;
	}
	public function getRowTotalSinReconduccion($idr,$no_tipo){
		$prog_anual = $trim_1 = $trim_2 = $trim_3 = $trim_4 = $avance_1 = $avance_2 = $avance_3 = $avance_4 = 0;
		$data = array();
		foreach (self::getReportesRegistrados($idr) as $v) {
			$prog_anual += $v->prog_anual;
			
			if($no_tipo == 5){
				$trim_1 += $v->trim_1;
				$trim_2 += $v->trim_2;
				$trim_3 += $v->trim_3;
				$trim_4 += $v->trim_4;

				$avance_1 += $v->cant_1;
				$avance_2 += $v->cant_2;
				$avance_3 += $v->cant_3;
				$avance_4 += $v->cant_4;
			}else if($no_tipo == 1){
				$trim_1 += $v->trim_1;
				$trim_2 += 0;
				$trim_3 += 0;
				$trim_4 += 0;

				$avance_1 += $v->cant_1;
				$avance_2 += 0;
				$avance_3 += 0;
				$avance_4 += 0;
			}else if($no_tipo == 2){
				$trim_1 += 0;
				$trim_2 += $v->trim_2;
				$trim_3 += 0;
				$trim_4 += 0;

				$avance_1 += 0;
				$avance_2 += $v->cant_2;
				$avance_3 += 0;
				$avance_4 += 0;
			}else if($no_tipo == 3){
				$trim_1 += 0;
				$trim_2 += 0;
				$trim_3 += $v->trim_3;
				$trim_4 += 0;

				$avance_1 += 0;
				$avance_2 += 0;
				$avance_3 += $v->cant_3;
				$avance_4 += 0;
			}else if($no_tipo == 4){
				$trim_1 += 0;
				$trim_2 += 0;
				$trim_3 += 0;
				$trim_4 += $v->trim_4;

				$avance_1 += 0;
				$avance_2 += 0;
				$avance_3 += 0;
				$avance_4 += $v->cant_4;
			}
		
		}
		$data = array("prog_anual"=>$prog_anual,
					"trim_1"=>$trim_1,  
					"trim_2"=>$trim_2,  
					"trim_3"=>$trim_3,  
					"trim_4"=>$trim_4,  
					"avance_1"=>$avance_1,  
					"avance_2"=>$avance_2,  
					"avance_3"=>$avance_3,  
					"avance_4"=>$avance_4,  
					"total_trim"=>($trim_1 + $trim_2 + $trim_3 + $trim_4),  
					"total_avance"=>($avance_1 + $avance_2 + $avance_3 + $avance_4),  
					);
		return $data;
	}
	public function getGraficaproyectos(Request $r){
		$type = 0;
		return $this->getRowsGraficaproyectos($r->ida,$r->no,$r->idanio,$r->no_tipo,$type);
	}
	private function getRowsGraficaproyectos($ida,$no,$idy,$no_tipo,$type){
		$idi = \Auth::user()->idinstituciones;
		$i = 1;
		$data = array();
		$prog_anual = $avance = 0;
			//Grafica sin reconducción
			foreach ($this->model->getGraficaMetasProyectos($ida,$idy,$idi,$type) as $key => $v) {
				$cantidad = 0;
				$modificada = 0;
				$row = $this->getRowTotalSinReconduccion($v->idreporte, $no_tipo);
				if($no == 2){
					//Con reconducción
					if($row['total_avance'] > 0 && $row['prog_anual'] > 0){
						$cantidad = $row['total_avance'];
						$porc = ($row['total_avance']/$row['prog_anual']) * 100;
						if($porc > 89.9 && $porc <=110){
							$modificada = $row['prog_anual'];
						}else{
							$modificada = $row['total_avance'];
						}
						$porcentaje = ($row['total_avance']/$modificada)*100;
					}else if($row['total_avance'] > 0){
						$porcentaje = 100;
					}else {
						$porcentaje = 0;
					}
				}else if($no == 3){
					//Sin reconducción
					$cantidad = $row['total_avance'];
					$modificada =  $row['total_avance'];
					//Porcentaje
					if($cantidad > 0 && $row['prog_anual'] > 0){
						$porcentaje = ($cantidad/$row['prog_anual'])*100;
					}else if($cantidad > 0){
						$porcentaje = 100;
					}else {
						$porcentaje = 0;
					}
				}
				$avance_1 = $row['avance_1'];
				$avance_2 = $row['avance_2'];
				$avance_3 = $row['avance_3'];
				$avance_4 = $row['avance_4'];

				$data[] = array('no' => $i++,
								'cant' => number_format($porcentaje,2), 
								'no_proy'=>$v->no_proy,
								'proyecto'=>$v->proyecto,
								'no_dep_gen'=>$v->no_dep_gen,
								'dep_gen'=>$v->dep_gen,
								'no_dep_aux'=>$v->no_dep_aux,
								'dep_aux'=>$v->dep_aux,
								'prog_anual'=>number_format($row['prog_anual'],2), 
								'cantidad'=>number_format($cantidad,2),
								'modificada'=>number_format($modificada,2),
								'prog_anual'=>number_format($row['prog_anual'],2), 
								'avance_1'=>number_format($avance_1,2), 
								'avance_2'=>number_format($avance_2,2), 
								'avance_3'=>number_format($avance_3,2), 
								'avance_4'=>number_format($avance_4,2), 
								'trim_1'=>number_format($row['trim_1'],2), 
								'trim_2'=>number_format($row['trim_2'],2), 
								'trim_3'=>number_format($row['trim_3'],2), 
								'trim_4'=>number_format($row['trim_4'],2), 
							);
				$prog_anual += $row['prog_anual'];
				$avance += $cantidad;
			}
			$porcentaje = ($prog_anual > 0 ? (($avance * 100)/$prog_anual) : 0);
			$arr = array('rows' =>$data, 
						"prog_anual"=>number_format($prog_anual,2), 
						"prog_anual1"=>$prog_anual, 
						"avance"=>number_format($avance,2),
						"avance1"=>$avance,
						"porcentaje"=>number_format($porcentaje ,2),
						"no"=>$no,
						"no_tipo"=>$no_tipo,
					);
			return json_encode($arr);
	}
	public function getTemplate(Request $r){
		$idi = \Auth::user()->idinstituciones;
		$this->data['no'] = $r->no;
		$this->data['idanio'] = $r->idanio;
		$this->data['type'] = $r->type;
		$this->data['dep_gen'] = $this->model->getCatDepGeneralNew($idi,$r->idanio);
		if($r->no == 1 || $r->no == 6){
			return view('panel.graficas.general',$this->data);	
		}else if($r->no == 3){
			return view('panel.graficas.proyectos',$this->data);	
		}
	}
	
}