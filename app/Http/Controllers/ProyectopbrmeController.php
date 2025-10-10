<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Proyectopbrme;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ProyectopbrmeController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'proyectopbrme';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Proyectopbrme();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'proyectopbrme',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('proyectopbrme.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{

		//ID de la institución que tiene asignada el usuario
		$idi = \Auth::user()->idinstituciones;
		//Verificó que la key este presente en el return
		if(isset($request->k)){
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($request->k);
			$ida = $decoder['ida'];
			$idi = $decoder['idi'];
		}else{
			$ida = 0;
		}
		$this->data['ida'] = $ida;
		$this->data['idi'] = $idi;
		$this->data['year'] = $request->year;
		$this->data['idy'] = $request->idy;
		$gp = \Auth::user()->group_id;
		//$idi = \Auth::user()->idinstituciones;
		if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
			$rows = $this->model->getAreasGeneralForYear($this->data['idi'],$request->idy);
		}else{
			$idu = \Auth::user()->id;
			$access = $this->model->getPermisoAreaForYearDenGen($idu);
			if($access[0]->dep_gen != null){
				$replace = str_replace('"',"'",$access[0]->dep_gen);
				$rows = $this->model->getAreasGeneralForYearDepGen($idi, $request->idy, $replace);
			}
			//$permiso = $this->model->getPermisoAreaForYear(\Auth::user()->id, $request->idy);
			//$rows = $this->model->getAreasEnlacesGeneralForYear($permiso[0]->permiso,$this->data['idi']);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('proyectopbrme.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		$this->data['ida'] = $decoder['ida'];
		$this->data['idi'] = $decoder['idi'];
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		$this->data['k'] = $request->k;
		$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		return view('proyectopbrme.anio',$this->data);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$data[] = array("idanio"=>$r->idy,
						"anio"=>$r->year,
						"rows"=>$this->model->getProgramasAnio($decoder['ida'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('proyectopbrme.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$idanio = $r->idanio == 4 ? 3 : $r->idanio;
		$this->data['programas'] = $this->model->getProgramasActivos($idanio);
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		return view('proyectopbrme.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$row = $this->model->getPbrme($r->id);
		$this->data['row'] = $row[0];
		$idanio = $r->idanio == 4 ? 3 : $r->idanio;
		$this->data['programas'] = $this->model->getProgramasActivos($idanio);
		$this->data['rows1'] = $this->model->getProyectosPbrme($r->id,1);
		$this->data['rows2'] = $this->model->getProyectosPbrme($r->id,2);
		$this->data['rows3'] = $this->model->getProyectosPbrme($r->id,3);
		$this->data['rows4'] = $this->model->getProyectosPbrme($r->id,4);
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		return view('proyectopbrme.edit',$this->data);
	}
	public function getAddtr( Request $r)
	{
		$this->data['no'] = $r->no;
		$this->data['text'] = $r->text;
		$this->data['time'] = rand(3,100).time();
		return view('proyectopbrme.tr',$this->data);	
	}
	function postSave( Request $r)
	{
	
		try {
			$data = array("idarea"=>$r->idarea,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idprograma,
							"pilar"=>$r->pilar,
							"tema"=>$r->tema,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
						);
			$id = $this->model->insertRow($data,0);

			$da1 = array("idproy_pbrm01e"=>$id,"idproy_pbrm01e_tipo"=>1,"descripcion"=>$r->tipo1,"nombre"=>$r->nombre1,"formula"=>$r->formula1,"frecuencia"=>$r->frecuencia1,"medios"=>$r->medios1,"supuestos"=>$r->supuestos1);
			$this->model->getInsertTable($da1,"ui_proy_pbrm01e_reg");
			$da2 = array("idproy_pbrm01e"=>$id,"idproy_pbrm01e_tipo"=>2,"descripcion"=>$r->tipo2,"nombre"=>$r->nombre2,"formula"=>$r->formula2,"frecuencia"=>$r->frecuencia2,"medios"=>$r->medios2,"supuestos"=>$r->supuestos2);
			$this->model->getInsertTable($da2,"ui_proy_pbrm01e_reg");
			//En componentes y actividades se agrega más de uno
			for ($i=0; $i < count($r->tipo3); $i++) { 
				$da3 = array("idproy_pbrm01e"=>$id,
							"idproy_pbrm01e_tipo"=>3,
							"descripcion"=>$r->tipo3[$i],
							"nombre"=>$r->nombre3[$i],
							"formula"=>$r->formula3[$i],
							"frecuencia"=>$r->frecuencia3[$i],
							"medios"=>$r->medios3[$i],
							"supuestos"=>$r->supuestos3[$i]);
				$this->model->getInsertTable($da3,"ui_proy_pbrm01e_reg");
			}
			for ($i=0; $i < count($r->tipo4); $i++) { 
				$da4 = array("idproy_pbrm01e"=>$id,
							"idproy_pbrm01e_tipo"=>4,
							"descripcion"=>$r->tipo4[$i],
							"nombre"=>$r->nombre4[$i],
							"formula"=>$r->formula4[$i],
							"frecuencia"=>$r->frecuencia4[$i],
							"medios"=>$r->medios4[$i],
							"supuestos"=>$r->supuestos4[$i]);
				$this->model->getInsertTable($da4,"ui_proy_pbrm01e_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar proyecto! '.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	function postEdit( Request $r)
	{
	
		try {
			$data = array("idarea"=>$r->idarea,
							"idprograma"=>$r->idprograma,
							"pilar"=>$r->pilar,
							"tema"=>$r->tema,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
						);
			$id = $this->model->insertRow($data,$r->id);
			
			$da1 = array("descripcion"=>$r->tipo1,"nombre"=>$r->nombre1,"formula"=>$r->formula1,"frecuencia"=>$r->frecuencia1,"medios"=>$r->medios1,"supuestos"=>$r->supuestos1);
			$this->model->getUpdateTable($da1,"ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$r->idproy_pbrm01e_reg1);

			$da2 = array("descripcion"=>$r->tipo2,"nombre"=>$r->nombre2,"formula"=>$r->formula2,"frecuencia"=>$r->frecuencia2,"medios"=>$r->medios2,"supuestos"=>$r->supuestos2);
			$this->model->getUpdateTable($da2,"ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$r->idproy_pbrm01e_reg2);
			//En componentes y actividades se agrega más de uno
			if(isset($r->tipo3)){
				for ($i=0; $i < count($r->tipo3); $i++) { 
					$da3 = array("idproy_pbrm01e"=>$id,
								"idproy_pbrm01e_tipo"=>3,
								"descripcion"=>$r->tipo3[$i],
								"nombre"=>$r->nombre3[$i],
								"formula"=>$r->formula3[$i],
								"frecuencia"=>$r->frecuencia3[$i],
								"medios"=>$r->medios3[$i],
								"supuestos"=>$r->supuestos3[$i]);
					if($r->idproy_pbrm01e_reg3[$i] > 0){
						$this->model->getUpdateTable($da3,"ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$r->idproy_pbrm01e_reg3[$i]);
					}else{
						$this->model->getInsertTable($da3,"ui_proy_pbrm01e_reg");
					}
				}
			}
			if(isset($r->tipo4)){
				for ($i=0; $i < count($r->tipo4); $i++) { 
					$da4 = array("idproy_pbrm01e"=>$id,
								"idproy_pbrm01e_tipo"=>4,
								"descripcion"=>$r->tipo4[$i],
								"nombre"=>$r->nombre4[$i],
								"formula"=>$r->formula4[$i],
								"frecuencia"=>$r->frecuencia4[$i],
								"medios"=>$r->medios4[$i],
								"supuestos"=>$r->supuestos4[$i]);
					if($r->idproy_pbrm01e_reg4[$i] > 0){
						$this->model->getUpdateTable($da4,"ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$r->idproy_pbrm01e_reg4[$i]);
					}else{
						$this->model->getInsertTable($da4,"ui_proy_pbrm01e_reg");
					}
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar proyecto! '.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getDestroy( Request $r )
	{
		foreach ($this->model->getProyectosPbrmeInd($r->id) as $v) {
			$this->model->getDestroyTable("ui_proy_pbrm01e_reg","idproy_pbrm01e_reg",$v->idproy_pbrm01e_reg);
		}
		$this->model->destroy($r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getRevertir( Request $r )
	{
		try {
			$row  = $this->model->find($r->id,['url']);
			$ruta = public_path($row->url);
			if (is_file($ruta)) {
				\File::delete($ruta);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al eliminar, '.$e->getMessage());
		}
		$this->model->insertRow(array("url"=>null),$r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getDownload( Request $r ){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Obtengo la URL
			$row = $this->model->find($decoder['id'],['url']);
			//Asigno el path completo
			$rutaArchivo = public_path($row->url);
			//Nombre del archivo 
			$nombreArchivo = date('d-m-Y') . " Proyecto PbRM-01e.pdf";
			// Verificar si el archivo existe en el directorio public
			if (file_exists($rutaArchivo)) {
				// Descargar el archivo usando response()->download()
				// Iniciar la transmisión del archivo PDF
				return response()->stream(function () use ($rutaArchivo) {
					// Abrir y enviar el contenido del archivo al flujo de salida
					$stream = fopen($rutaArchivo, 'r');
					fpassthru($stream);
					fclose($stream);
				}, 200, [
					'Content-Type' => 'application/pdf',
					'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
				]);
			}else{
				//Vista si no existe el archivo
				return view('errors.414');
			}
		}else{
			return view('errors.414');
		}
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Token
			$this->data['token'] = $r->key;
			$proy = $this->model->getPbrme($decoder['id']);
			$this->data['proy'] = $proy[0];

			$this->data['rows_projects1'] = $this->model->getProyectosPbrme($decoder['id'],1);
			$this->data['rows_projects2'] = $this->model->getProyectosPbrme($decoder['id'],2);
			$this->data['rows_projects3'] = $this->model->getProyectosPbrme($decoder['id'],3);
			$this->data['rows_projects4'] = $this->model->getProyectosPbrme($decoder['id'],4);
			return view('templates.presupuesto.pbrme.view',$this->data);
		}
	}
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy = $this->model->getPbrme($decoder['id']);
			$this->data['proy'] = $proy[0];
			
			$this->data['rows_projects1'] = $this->model->getProyectosPbrme($decoder['id'],1);
			$this->data['rows_projects2'] = $this->model->getProyectosPbrme($decoder['id'],2);
			$this->data['rows_projects3'] = $this->model->getProyectosPbrme($decoder['id'],3);
			$this->data['rows_projects4'] = $this->model->getProyectosPbrme($decoder['id'],4);

			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			$this->data['txt_fecha'] = $r->txt_fecha;
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['te_c'] = $r->te_c;//Tesorero
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			$directory = "archivos/{$proy[0]->no_municipio}/proyectos/pbrma01e/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
			
			/*
			* 2024-01-07, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
			* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
			*/

			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 30,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 30,
			]);
			// Configurar encabezado
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrme.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrme.pdf_body',$this->data));
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrme.pdf_footer", $this->data)->render());

			//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			$time = time();
			$filename = '/'.$decoder['id']."_ ".$time.'.pdf';
			$url = $folder.$filename;
			$mpdf->Output($url, 'F');//Save PDF in directory
			//return $mpdf->Output();//Save PDF in directory

			$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);
			
			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
		}
	}
}