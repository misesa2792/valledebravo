<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Proyectopbrma;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ProyectopbrmaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'proyectopbrma';
	static $per_page	= '10';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Proyectopbrma();
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'proyectopbrma',
			'return'	=> self::returnUrl()
		);
	}
	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('proyectopbrma.index',$this->data);
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

		if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
			$rows = $this->model->getAreasGeneralForYear($this->data['idi'], $request->idy);//Ver dependencias por año
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
		return view('proyectopbrma.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		$this->data['ida'] = $decoder['ida'];
		$this->data['idi'] = $decoder['idi'];
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		$this->data['token'] = $request->k;
		$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('proyectopbrma.anio',$this->data);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$data = $this->getRowsProyectos($decoder['ida'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'total_uippe' 	=> $data['total_uippe'],
				'total_pres' 	=> $data['total_pres'],
				'total_resta' 	=> $data['total_resta'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectos($idarea, $idanio){
		$data = array();
		$total = 0;
		foreach ($this->model->getProgramasAnio($idarea, $idanio) as $v) {
			$data[] = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa"=>$v->no_programa,
							"programa"=>$v->programa,
							"url"=>(empty($v->url) ? "NO" : "PDF"),
							"total"=> number_format($v->total,2),
							"color"=> ($v->total > 0 ? 'c-black' : 'c-danger'),
						);
			$total += $v->total;
		}
		$pres = 0.00;
		return array("data" 		=> $data, 
					"contador" 		=> count($data), 
					"total_pres"	=> 0, 
					"total_uippe" 	=> number_format($total,2),
					"total_resta"	=> number_format($pres - $total,2) 
				);
	}
	public function getAdd( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$idanio = $r->idanio == 4 ? 3 : $r->idanio;
			$this->data['programas'] = $this->model->getProgramasActivos($idanio);//sximo
			$proy = $this->model->getCatDepGen($decoder['ida']);
			$this->data['proy'] = $proy[0];
			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			return view('proyectopbrma.add',$this->data);
		}
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy = $this->model->getPbrma($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['rows'] = $this->model->getProyectosPbrma($decoder['id']);
			$this->data['proyectos'] = $this->model->getProyectos($proy[0]->idprograma);
			$this->data['auxiliares'] = $this->model->getDepAuxiliares($proy[0]->idarea);
			//Valores encriptados
			$this->data['token'] = $r->key;
			return view('proyectopbrma.edit',$this->data);
		}
	}
	public function getPrograma( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['idprograma'] = $r->idprograma;
			$this->data['token'] = $r->k;
			$this->data['ida'] = $decoder['ida'];
			return view('proyectopbrma.programa',$this->data);
		}
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
			$nombreArchivo = date('d-m-Y') . " Proyecto PbRM-01a.pdf";
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
			//Aquí va encriptados los valores
			$this->data['token'] = $r->key;
			$proy = $this->model->getPbrma($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['rows_projects'] = $this->model->getProyectosPbrma($decoder['id']);
			return view('templates.presupuesto.pbrma.view_new',$this->data);
		}
	}
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Se obtienen la información del registros
			$proy = $this->model->getPbrma($decoder['id']);
			$this->data['proy'] = $proy[0];
			
			$this->data['rows_projects'] = $this->model->getProyectosPbrma($decoder['id']);

			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			//Cargos
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['te_c'] = $r->te_c;//Tesorero
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			//Directorio donde se va a guardar el PDF del anteproyecto
			$directory = "archivos/{$proy[0]->no_municipio}/proyectos/pbrma01a/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			//Create directory if not exist.
			$this->getCreateDirectoryGeneral($folder);

			/*
			* 2024-01-09, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
			* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
			*/

			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 60,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 35,
			]);

			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrma.pdf_header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrma.pdf_footer", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrma.pdf_body',$this->data));
			//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			//Generación del nombre del PDF
			$time = time();
			$filename = '/'.$decoder['id']."_ ".$time.'.pdf';
			$url = $folder.$filename;
			//Save PDF in directory
			$mpdf->Output($url, 'F');
			//Guardo la URL en la base de datos
			$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);
			//Se regresa el key para descargar el PDF
			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
		}
	}
	public function getGenerarpdfa( Request $r )
	{
		$rows = \DB::select("SELECT a.idproy_pbrm01a as id,a.idprograma,ar.titular as titular_dep_gen,ar.cargo,p.numero as no_programa,p.descripcion as programa,a.total,ar.descripcion as dep_gen,ar.numero as no_dep_gen,
		i.descripcion as institucion,i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio, m.numero as no_municipio,a.url,y.anio,a.idarea FROM ui_proy_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			inner join ui_area ar on ar.idarea = a.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			inner join ui_anio y on y.idanio = a.idanio
            where a.idanio = 4 order by ar.numero asc");
				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
				'margin_top' => 60,
				'margin_left' => 5,
				'margin_right' => 5,
				'margin_bottom' => 35,
				]);
	
			foreach ($rows as $key => $v) {
			//Se obtienen la información del registros
			$this->data['proy'] = $v;
			
			$this->data['rows_projects'] = $this->model->getProyectosPbrma($v->id);

			$this->data['txt_titular_dep'] = $v->titular_dep_gen;
			$this->data['txt_tesorero'] = "MTRO. FLORENCIO VALLADARES ZAMBRANO";
			$this->data['txt_titular_uippe'] = "M.A Y P.P. EFRAÍN ÁNGELES RUÍZ";
			//Cargos
			$this->data['ti_c'] = $v->cargo;//Titular Dep_Gen
			$this->data['te_c'] = "TESORERO MUNICIPAL";//Tesorero
			$this->data['ui_c'] = "TITULAR DE LA UNIDAD DE INFORMACIÓN, PLANEACIÓN, PROGRAMACIÓN Y EVALUACIÓN";//UIPPE

			//Directorio donde se va a guardar el PDF del anteproyecto
			$directory = "archivos/pbrmasesmas";
			$folder = public_path($directory);
			//Create directory if not exist.
			$this->getCreateDirectoryGeneral($folder);

		
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrma.pdf_header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrma.pdf_footer", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrma.pdf_body',$this->data));
			$mpdf->AddPage();
			}
			$time = time();
			$filename = '/'.$time.'.pdf';
			$url = $folder.$filename;
			//Save PDF in directory
			return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			$mpdf->Output($url, 'F');
			dd("ok");

			//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			//Generación del nombre del PDF
		
			//Guardo la URL en la base de datos
			$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);
			//Se regresa el key para descargar el PDF
			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
	}
	public function deleteDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		//Se eliminan los registros
		foreach ($this->model->getRegistrosPbrma($decoder['id']) as $v) {
			$this->model->getDestroyTable("ui_proy_pbrm01a_reg","idproy_pbrm01a_reg",$v->id);
		}
		//Se elimina el registro
		$this->model->destroy($decoder['id']);
		//Se regresa un estatus
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function postRevertir( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		try {
			$row  = $this->model->find($decoder['id'],['url']);
			$ruta = public_path($row->url);
			if (is_file($ruta)) {
				\File::delete($ruta);
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al eliminar, '.$e->getMessage());
		}
		//Se regresa la URL a valor null
		$this->model->insertRow(array("url"=>null),$decoder['id']);
		//Se regresa un estatus
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getAddtr( Request $r)
	{
		$this->data['idprograma'] = $r->idprograma;
		$this->data['proyectos'] = $this->model->getProyectos($r->idprograma);
		$this->data['auxiliares'] = $this->model->getDepAuxiliares($r->idarea);
		$this->data['time'] = rand(3,100).time();
		return view('proyectopbrma.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$data = array("idarea"=>$decoder['ida'],
								"idanio"=>$r->idanio,
								"idprograma"=>$r->idprograma,
								"total"=>$this->getClearNumber($r->total),
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
							);
				$id = $this->model->insertRow($data,0);

				$registros = array();
				for ($i=0; $i < count($r->idac); $i++) { 
					$registros[] = array("idproy_pbrm01a"=>$id,
								"idarea_coordinacion"=>$r->idac[$i],
								"idproyecto"=>$r->idp[$i],
								"presupuesto"=>$this->getClearNumber($r->pres[$i]),
							);
				}
				//Inserto todos los registros directamente
				if(count($registros) > 0){
					$this->model->getInsertTableData($registros,"ui_proy_pbrm01a_reg");
				}

				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar proyecto!'.$e->getMessage());
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		try {
			//Actualización de totales
			$data = array("total"=>$this->getClearNumber($r->total),
						"fecha_rg"=>date('Y-m-d'),
						"hora_rg"=>Carbon::now()->format('H:i:s A'));
			$id = $this->model->insertRow($data, $decoder['id']);
			//Actualización de Dep. Aux
			for ($i=0; $i < count($r->ida); $i++) {
				$arr = array("idproy_pbrm01a"=> $decoder['id'],
							"idarea_coordinacion"=>$r->idac[$i],
							"idproyecto"=>$r->idp[$i],
							"presupuesto"=>$this->getClearNumber($r->pres[$i]),
						);
				if($r->ida[$i] == "0"){
					$this->model->getInsertTable($arr,"ui_proy_pbrm01a_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_proy_pbrm01a_reg","idproy_pbrm01a_reg",$r->ida[$i]);
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar proyecto!'.$e->getMessage());
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_proy_pbrm01a_reg","idproy_pbrm01a_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getSesmas( Request $r )
	{
		foreach (\DB::select("SELECT * FROM ui_proy_pbrm01a where url != ''") as $key => $v) {
				$url = str_replace("archivos/", "archivos/101/", $v->url);
				$this->model->getUpdateTable(array("url"=>$url),'ui_proy_pbrm01a','idproy_pbrm01a',$v->idproy_pbrm01a);
		}
		dd("ok");
	}

}