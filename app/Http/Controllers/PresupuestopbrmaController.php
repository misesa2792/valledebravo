<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrma;
use App\Models\Exportar;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers,Excel ; 
use Illuminate\Support\Facades\View;

use App\Services\PrespbrmaService;

class PresupuestopbrmaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrma';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrma();
		$this->exportar = new Exportar();
		$this->pbrmaService = new PrespbrmaService();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrma',
			'return'	=> self::returnUrl()
			
		);
		
	}
	/*public function postExcelprogupdate( Request $request )
	{
		try {
			$file= Input::file('archivos');
		//Compruebo que el proyecto no tenga actividad

		$ext = $file->getClientOriginalExtension();//OBTENGO LA EXTENSIÓN DEL ARCHIVO
		if($ext == "xlsx" or $ext == "xls" or $ext == "XLSX" or $ext == "XLS"){
			//Obtengo el directorio del archivo
			$path = $file->getRealPath();
			//Obtengo los datos del excel
			$data = Excel::selectSheetsByIndex(0)->load($path, function($reader) { })->get();
			//Verificó que tenga datos el excel
			if(!empty($data) && $data->count()){
				//Recorro hasta las preguntas del excel
				$nombre_archivo = rand(5,99999).'_'.time();
				//Path donde estara el archivo .txt
				 // Obtener los encabezados del archivo Excel
				 // Hacer lo que necesites con los encabezados, por ejemplo, imprimirlos
								
				for ($l=0; $l < count($data)  ; $l++) {
					$arr = array("mir"=>$data[$l]['mir']);
					$this->model->getUpdateTable($arr, "ui_pres_pbrm01d","idpres_pbrm01d",$data[$l]['id']);
				}
				dd("noooooo");
			} 
		} 
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
		return "ok";
	}*/
	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('presupuestopbrma.index',$this->data);
	}	
	public function getPrincipal( Request $r )
	{
		//ID de la institución que tiene asignada el usuario
		$idi = \Auth::user()->idinstituciones;
		//Verificó que la key este presente en el return
		if(isset($r->k)){
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($r->k);
			$ida = $decoder['ida'];
			$idi = $decoder['idi'];
		}else{
			$ida = 0;
		}
		$this->data['ida'] = $ida;
		$this->data['idi'] = $idi;
		$this->data['year'] = $r->year;
		$this->data['idy'] = $r->idy;
		$gp = \Auth::user()->group_id;
		if($gp == 1 || $gp == 2){
			$this->data['rowsInstituciones'] = $this->model->getCatInstituciones();
		}else{
			$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($idi);
		}
		if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
			$rows = $this->model->getAreasGeneralForYear($this->data['idi'], $r->idy);
		}else{
			$permiso = $this->model->getPermisoAreaForYear(\Auth::user()->id, $r->idy);
			$rows = $this->model->getAreasEnlacesGeneralForYear($permiso[0]->permiso,$this->data['idi']);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('presupuestopbrma.principal',$this->data);
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			$this->data['token'] = $request->k;
			$this->data['idy'] = $request->idy;
			$this->data['year'] = $request->year;
			$this->data['depgen'] = $this->model->getCatDepGen($decoder['ida']);

			//Para el año 2025 se va a usar otra tabla llamada : ui_pd_pbrm01a, lo quite para que la carga sea manual
			if($request->year >= "2025"){
				return view('presupuestopbrma.programas.index',$this->data);
			}else{
				return view('presupuestopbrma.anio',$this->data);
			}
		}else{
			return view('errors.414');
		}
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
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	private function getRowsProyectos($idarea, $idanio){
		$data = array();
		$total = 0;
		$proy = $this->getProyectosDepAux($idarea, $idanio);
		foreach ($this->model->getProgramasAnio($idarea, $idanio) as $v) {
			$proyectos = isset($proy[$v->id]) ? $proy[$v->id] : array();
			$data[] = array("id" 		  => SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa" => $v->no_programa,
							"programa"	  => $v->programa,
							"url"		  =>(empty($v->url) ? "NO" : "PDF"),
							"total"		  => number_format($v->total,2),
							"color"		  => ($v->total > 0 ? 'c-black' : 'c-danger'),
							"proy"	  	  => $proyectos,
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
	private function getProyectosDepAux($idarea, $idanio){
		$data = array();
		foreach ($this->model->getProyectosDepAux($idarea, $idanio) as $v) {
			$data[$v->id][] = ["no_dep_aux"  => $v->no_dep_aux,
							"dep_aux" 	  => $v->dep_aux,
							"no_proyecto" => $v->no_proyecto,
							"proyecto"    => $v->proyecto,
							"pres" 		  => number_format($v->presupuesto,2),
						];
		}
		return $data;
	}
	public function getAdd( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$this->data['programas'] = $this->model->getProgramasActivos($r->idanio);//sximo
			$proy = $this->model->getCatDepGen($decoder['ida']);
			$this->data['proy'] =$proy[0];
			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			return view('presupuestopbrma.add',$this->data);
		}
	}
	public function getPrograma( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['idprograma'] = $r->idprograma;
			$this->data['token'] = $r->k;
			$this->data['ida'] = $decoder['ida'];
			return view('presupuestopbrma.programa',$this->data);
		}
	}
	public function getAddtr( Request $r)
	{
		$this->data['idprograma'] = $r->idprograma;
		$this->data['proyectos'] = $this->model->getProyectos($r->idprograma);
		$this->data['auxiliares'] = $this->model->getDepAuxiliares($r->idarea);
		$this->data['time'] = rand(3,100).time();
		return view('presupuestopbrma.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$data = array("idarea"=>$decoder['ida'],
								"idanio"=>$r->idanio,
								"idprograma"=>$r->idprograma,
								"total"=>$this->getClearNumber($r->total),
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
								"std_delete"=>1,
							);
				$id = $this->model->insertRow($data,0);
				//Se insertan la lista de dependencias auxiliares
				$registros = array();
				for ($i=0; $i < count($r->idac); $i++) {
					$total = $this->getClearNumber($r->pres[$i]); 
					//Primero Insert el PbRM-01c
					$arr_c = array(
									"idarea_coordinacion" => $r->idac[$i],
									"idanio"			  => $r->idanio,
									"idproyecto"		  => $r->idp[$i],
									"fecha_rg"			  => date('Y-m-d'),
									"hora_rg"			  => date('H:i:s A'),
									"total"				  => $total,
									"std_delete" 		  => 1
								);
					$idregc = $this->model->getInsertTable($arr_c,"ui_pres_pbrm01c");
					
					$arr_a = array(
								"idanio"			  =>$r->idanio,
								"idpres_pbrm01a"	  => $id,
								"idarea_coordinacion" => $r->idac[$i],
								"idproyecto"		  => $r->idp[$i],
								"presupuesto"		  => $total,
								"idpres_pbrm01c"	  => $idregc
							);
					$this->model->getInsertTable($arr_a,"ui_pres_pbrm01a_reg");
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
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
			return view('presupuestopbrma.edit',$this->data);
		}
	}
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			try {
				//Actualización de totales
				$id = $this->model->insertRow(array("total"=> $this->getClearNumber($r->total)), $decoder['id']);
				//Actualización de Dep. Aux
				for ($i=0; $i < count($r->ida); $i++) {
					$total = $this->getClearNumber($r->pres[$i]);
					//Cero es para nuevos registros
					if($r->ida[$i] == "0"){
						//Primero Insert el PbRM-01c
						$arr_c = array(
							"idarea_coordinacion" => $r->idac[$i],
							"idanio"			  => $r->idanio,
							"idproyecto"		  => $r->idp[$i],
							"fecha_rg"			  => date('Y-m-d'),
							"hora_rg"			  => date('H:i:s A'),
							"total"				  => $total,
							"std_delete" 		  => 1
						);
						$idregc = $this->model->getInsertTable($arr_c,"ui_pres_pbrm01c");
						//Inserto los nuevos registros
						$arr_a = array(
								"idanio"			    => $r->idanio,
								"idpres_pbrm01a" 		=> $decoder['id'],
								"idarea_coordinacion" 	=>$r->idac[$i],
								"idproyecto"		  	=>$r->idp[$i],
								"presupuesto"         	=> $total,
								"idpres_pbrm01c"	  	=> $idregc
							);
						$this->model->getInsertTable($arr_a,"ui_pres_pbrm01a_reg");
					}else{

						//Actualizo el total de PbRM-01c
						if($r->idregc[$i] > 0){
							$arr_c = array("idarea_coordinacion" =>$r->idac[$i],
										"idproyecto"		 	 =>$r->idp[$i],
										"total" 				 => $total
									);
							$this->model->getUpdateTable($arr_c,"ui_pres_pbrm01c","idpres_pbrm01c",$r->idregc[$i]);
						}

						$arr_a = array("idarea_coordinacion" =>$r->idac[$i],
										"idproyecto"		 =>$r->idp[$i],
										"presupuesto"        => $total,
										"idanio"			 => $r->idanio,
									);
						$this->model->getUpdateTable($arr_a,"ui_pres_pbrm01a_reg","idpres_pbrm01a_reg",$r->ida[$i]);
					}
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = "no";
			}
		}else{
			$response = "no";
		}
		return json_encode(array("success"=>$response));
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
			$nombreArchivo = date('d-m-Y') . " Presupuesto PbRM-01a.pdf";
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
			$proy=$this->model->getPbrma($decoder['id']);
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
			$directory = "archivos/{$proy[0]->no_municipio}/presupuesto/pbrma01a/{$proy[0]->anio}/{$decoder['id']}";
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
	public function postDestroytr( Request $r)
	{
		$row = $this->model->getProyectosRegPbrmc($r->params['id']);
		if(count($row) > 0){
			$this->getUpdateTablePbRMc($row[0]->id);
		}
		//Elimino el registro
		$this->model->getDestroyTable("ui_pres_pbrm01a_reg","idpres_pbrm01a_reg",$r->params['id']);
		return json_encode(array("success"=>"ok"));
	}
	private function getUpdateTablePbRMc($id){
		$this->model->getUpdateTable(array("std_delete" => 2), "ui_pres_pbrm01c", "idpres_pbrm01c", $id);
	}
	public function postDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		if($decoder){
			foreach ($this->model->getProyectosPbrmc($decoder['id']) as $v) {
				if($v->id > 0){
					$this->getUpdateTablePbRMc($v->id);
				}
			}
			//Se elimina logica
			$this->model->insertRow( array("std_delete"=>2),$decoder['id']);
			//Se regresa un estatus
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	public function postRevertir( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		if($decoder){
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
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	public function getExportarcalendarizacionmetas( Request $r ){
		return $this->exportar->getExportarCalendarizacionMetas($this->model->getRowsCalendarizacionMetas());
	}
	public function getExportardescripcionprograma( Request $r ){
		$data = array();
		foreach ($this->model->getRowsDescripcionPrograma() as $v) {
			$data[] = array("no_programa"=>$v->no_programa, 
							"no_dep_gen"=>$v->no_dep_gen, 
							"objetivo_programa"=>$v->objetivo_programa,
							"estrategias_objetivo"=>$v->estrategias_objetivo,
							"pdm"=>$v->pdm,
							"ods"=>$v->ods,
							"fortalezas"=>$this->model->getRowsDescripcionProgramaFODA($v->id,1),
							"oportunidades"=>$this->model->getRowsDescripcionProgramaFODA($v->id,2),
							"debilidades"=>$this->model->getRowsDescripcionProgramaFODA($v->id,3),
							"amenazas"=>$this->model->getRowsDescripcionProgramaFODA($v->id,4),
						);
		}
		return $this->exportar->getExportarDescripcionPrograma($data);
	}
	public function getExportarindicadores( Request $r ){
		$data = array();
		foreach ($this->model->getRowsindicadores() as $v) {
			$info = $this->model->getRowsindicadoresRegistros($v->id);
			$data[] = array("tipo"=>$v->tipo, 
							"pilares"=>$v->pilares, 
							"temas_desarrollo"=>$v->temas_desarrollo,
							"no_dep_gen"=>$v->no_dep_gen,
							"dep_gen"=>$v->dep_gen,
							"no_dep_aux"=>$v->no_dep_aux,
							"dep_aux"=>$v->dep_aux,
							"no_programa"=>$v->no_programa,
							"programa"=>$v->programa,
							"no_subfuncion"=>$v->no_subfuncion,
							"subfuncion"=>$v->subfuncion,
							"no_funcion"=>$v->no_funcion,
							"funcion"=>$v->funcion,
							"no_finalidad"=>$v->no_finalidad,
							"finalidad"=>$v->finalidad,
							"nombre_indicador"=>$v->nombre_indicador,
							"tipo_indicador"=>$v->tipo_indicador,
							"formula_calculo"=>$v->formula_calculo,
							"interpretacion"=>$v->interpretacion,
							"dimencion"=>$v->dimencion,
							"factor_comparacion"=>$v->factor_comparacion,
							"desc_factor"=>$v->desc_factor,
							"frecuencia"=>$v->frecuencia,
							"linea_base"=>$v->linea_base,
							"medios_verificacion"=>$v->medios_verificacion,
							"no_proyecto"=>$v->no_proyecto,
							"proyecto"=>$v->proyecto,
							"obj_proyecto"=>$v->obj_proyecto,
							"no_subprograma"=>$v->no_subprograma,
							"subprograma"=>$v->subprograma,
							"total"=>count($info),
							"info"=>$info,
						);
		}
		return $this->exportar->getExportarIndicadores($data);
	}
	public function getExportarmatriz( Request $r ){
		$data = array();
		foreach ($this->model->getRowsIndicadoresMatriz() as $v) {
			$data[] = array("no_dep_gen"=>$v->no_dep_gen, 
							"no_programa"=>$v->no_programa,
							"no_subfuncion"=>$v->no_subfuncion,
							"subfuncion"=>$v->subfuncion,
							"no_funcion"=>$v->no_funcion,
							"funcion"=>$v->funcion,
							"no_finalidad"=>$v->no_finalidad,
							"finalidad"=>$v->finalidad,
							"programa"=>$v->programa,
							"objetivo"=>$v->objetivo,
							"tipo"=>$v->tipo,
							"pilares"=>$v->pilares,
							"pilar"=>$v->pilar,
							"tema"=>$v->tema,
							"rows_1"=>$this->model->getRowsIndicadoresMatrizReg(1,$v->id),
							"rows_2"=>$this->model->getRowsIndicadoresMatrizReg(2,$v->id),
							"rows_3"=>$this->model->getRowsIndicadoresMatrizReg(3,$v->id),
							"rows_4"=>$this->model->getRowsIndicadoresMatrizReg(4,$v->id),
						);
		}
		return $this->exportar->getExportarIndicadoresMatriz($data);
	}


















	/*
	 * 
	 * NUEVO MÓDULO, SOLO APLICA PARA EL AÑO 2025 EN ADELANTE
	 * 
	 */
	public function getSearchnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$data = $this->getRowsProyectosNew($decoder['ida'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'total_uippe' 	=> $data['total_uippe'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	public function postDestroynew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->params['key']);
		if($decoder){
			//Se elimina logica
			$this->model->getUpdateTable( array("std_delete"=>2), $this->model['tablePD'], $this->model['primaryPDKey'], $decoder['id']);
			//Se regresa un estatus
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	public function getPdfnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Aquí va encriptados los valores
			$this->data['token'] = $r->key;
			$this->data['row'] = $this->pbrmaService->getInfoPbrma($decoder['id']);
			return view('templates.presupuesto.pbrma.new.view',$this->data);
		}
	}
	private function getRowsProyectosNew($idarea, $idanio){
		$data = array();
		$total = 0;
		$proy = $this->getProyectosDepAuxNew($idarea, $idanio);
		foreach ($this->model->getProgramasAnioNew($idarea, $idanio) as $v) {
			$proyectos = isset($proy[$v->id]) ? $proy[$v->id] : array();
			$data[] = array("id" 		  => SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_programa" => $v->no_programa,
							"programa"	  => $v->programa,
							"number"	  => $v->url,
							"total"		  => number_format($v->total,2),
							"color"		  => ($v->total > 0 ? 'c-black' : 'c-danger'),
							"proy"	  	  => $proyectos,
						);
			$total += $v->total;
		}
		return array("data" 		=> $data, 
					"contador" 		=> count($data), 
					"total_uippe" 	=> number_format($total,2),
				);
	}
	private function getProyectosDepAuxNew($idarea, $idanio){
		$data = array();
		foreach ($this->model->getProyectosDepAuxNew($idarea, $idanio) as $v) {
			$data[$v->id][] = ["no_dep_aux"  => $v->no_dep_aux,
							"dep_aux" 	  => $v->dep_aux,
							"no_proyecto" => $v->no_proyecto,
							"proyecto"    => $v->proyecto,
							"pres" 		  => number_format($v->presupuesto,2),
						];
		}
		return $data;
	}
	public function getAddnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;
			$idanio = ($r->idanio == 4 ? 3 : $r->idanio);
			$this->data['programas'] = $this->model->getProgramasActivos($idanio);//Los programas se cargaron en el ID 3 por eso el Idanio 4 debe de buscar en el 3
			$proy = $this->model->getCatDepGenNew($decoder['ida']);
			$this->data['proy'] =$proy[0];
			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			return view('presupuestopbrma.programas.create',$this->data);
		}
	}
	public function getEditnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$row = $this->pbrmaService->getInfoPbrma($decoder['id']);
			$this->data['row'] = $row;
			$this->data['proyectos'] = $this->model->getProyectos($row['id']['idp']);//Proyectos que pertenecen a dicho programa
			$this->data['auxiliares'] = $this->model->getDepAuxiliares($row['id']['ida']);//Dependencias auxiliares que pertenecen a la Dep. Gen
			//Valores encriptados
			$this->data['token'] = $r->key;
			return view('presupuestopbrma.programas.edit',$this->data);
		}
	}
	public function deleteProjectlog( Request $r)
	{
		//Elimino el registro
		$this->model->getDestroyTable($this->model['tablePDReg'], $this->model['primaryPDKeyReg'], $r->id);
		$response = ["status"=>"ok", "message"=>"Registro eliminado exitosamente"];
		return response()->json($response);
	}
	public function postGenerarpdfnew( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$row = $this->pbrmaService->getInfoPbrma($decoder['id']);
				$this->data['row'] = $row;
				$this->data['request'] = $r->all();
				//Se construye el nombre del PDF
				$number = $this->getBuildFilenamePDF("PD1A",$row['header']['no_institucion'], $row['header']['no_dep_gen'], $decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectory($row['header']['no_institucion'], $row['header']['anio'], 'pres', '01a');
				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
				'margin_top' => 60,
				'margin_left' => 5,
				'margin_right' => 5,
				'margin_bottom' => 35,
				]);
				$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrma.new.pdf_header", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrma.new.pdf_footer", $this->data)->render());
				$mpdf->WriteHTML(view('templates.presupuesto.pbrma.new.pdf_body',$this->data));
				//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
				//Generación del nombre del PDF
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				$this->model->getUpdateTable(['url' => $number], $this->model['tablePD'],  $this->model['primaryPDKey'], $decoder['id']);
				$this->getInsertTablePlan($row['id']['idi'], $number, $url, $result['directory']);
				//Return del resultado con el key
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
				\SiteHelpers::auditTrail( $r , 'Error al generar el PDF - PbRM-01a !'.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
		}
		return response()->json($response);
	}
	public function postReversenew( Request $r )
	{
		$request = $r->params;
		$decoder = SiteHelpers::CF_decode_json($request['key']);
		if($decoder){
			$this->model->getUpdateTable(['url' => null], $this->model['tablePD'],  $this->model['primaryPDKey'], $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($request['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	function postSavenew( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$id = $this->getInsertNewPbrma($decoder, $r->all());
				$this->getInsertNewPbrmaReg($id, $r->all());
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail($r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = "no";
			}
		}else{
			$response = "no";
		}
    	return response()->json(['response' => $response]);
	}
	function postEditnew( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$this->getUpdateTotalPbrma($decoder['id'], $r->total);
				//Actualización de Dep. Aux
				$this->getUpdateRegPbrma($decoder['id'],$r->all());
				$response = ['status' => 'ok', 'message' => 'Información guadada exitosamente'];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = ['status' => 'no', 'message' => 'Error al guardar la información.'];
			}
		}else{
			$response = ['status' => 'no', 'message' => 'Clave no valida'];
		}
    	return response()->json($response);
	}
	private function getUpdateTotalPbrma($id, $total){
		$data = ["total"=> $this->getClearNumber($total)];
		$this->model->getUpdateTable($data, $this->model['tablePD'], $this->model['primaryPDKey'], $id);
	}
	private function getUpdateRegPbrma($id, $request){
		for ($i=0; $i < count($request['ida']); $i++) {
			$total = $this->getClearNumber($request['pres'][$i]);
			//Cero es para nuevos registros
			if($request['ida'][$i] == "0"){
				//Inserto los nuevos registros
				$data = [
						"idpd_pbrm01a" 			=> $id,
						"idarea_coordinacion" 	=> $request['idac'][$i],
						"idproyecto"		  	=> $request['idp'][$i],
						"presupuesto"         	=> $total
						];
				$this->model->getInsertTable($data, $this->model['tablePDReg']);
			}else{
				$data = ["idarea_coordinacion" => $request['idac'][$i],
						"idproyecto"   => $request['idp'][$i],
						"presupuesto"  => $total
						];
				$this->model->getUpdateTable($data, $this->model['tablePDReg'], $this->model['primaryPDKeyReg'], $request['ida'][$i]);
			}
		}
	}
	private function getInsertNewPbrma($decoder, $request){
		$data = array("idarea"	 => $decoder['ida'],
					"idanio"	 => $request['idanio'],
					"idprograma" => $request['idprograma'],
					"total"		 =>$this->getClearNumber($request['total']),
					"iduser_rg"	 =>\Auth::user()->id,
					"std_delete" =>1
				);
		$id = $this->model->getInsertTable($data, $this->model['tablePD']);//Nueva tabla
		return $id;
	}
	private function getInsertNewPbrmaReg($id, $request){
		for ($i=0; $i < count($request['idac']); $i++) {
			$total = $this->getClearNumber($request['pres'][$i]); 
			$data = ["idpd_pbrm01a"	  => $id,
					"idarea_coordinacion" => $request['idac'][$i],
					"idproyecto"		  => $request['idp'][$i],
					"presupuesto"		  => $total
					];
			$this->model->getInsertTable($data, $this->model['tablePDReg']);//Nueva tabla
		}
	}

	
	/*
	 * 
	 * MÓDULO PBRMC
	 * 
	 */
	public function getSearchpbrmc( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){

			$data = $this->getRowsProyectosPbrmc($decoder['idac'],$r->idyear);
			$result = [
				'rowsData'  	=> $data['data'],
				'contador'  	=> $data['contador'],
				'total_uippe' 	=> $data['total_uippe'],
				'response'  	=> "Success"
			];
			return response()->json($result);
		}
	}
	public function getEditpbrmc( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$row = $this->pbrmaService->getInfoPbrmc($decoder['id']);
			$this->data['row'] = $row;
			//Valores encriptados
			$this->data['token'] = $r->key;
			return view('presupuestopbrma.proyectos.edit',$this->data);
		}
	}
	private function getRowsProyectosPbrmc($idac, $idanio){
		$data = array();
		$total = 0;
		$contador = 0;
		foreach ($this->model->getProyectosAniosPbrmc($idac, $idanio) as $v) {
			$contador++;
			$rowsProyectos = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_proyecto"	=> $v->no_proyecto,
							"proyecto"		=> $v->proyecto,
							"estatus"		=> $v->c_estatus,
							"number"		=> $v->c_url,
							"total"			=> number_format($v->total,2),
							"aa_estatus"	=> $v->aa_estatus,
							"aa_number"		=> $v->aa_url,
							"color"			=> ($v->total > 0 ? 'c-black' : 'c-danger'),
						);

			if(!isset($data[$v->idprograma])){
				$data[$v->idprograma] = array("no_programa" => $v->no_programa, 
											"programa" => $v->programa,
											'rowsProyectos' => array()
										);
			}

			$data[$v->idprograma]['rowsProyectos'][] = $rowsProyectos;
			
			$total += $v->total;
		}
		return array("data" 		=> $data, 
					"contador" 		=> $contador,
					"total_uippe" 	=> number_format($total,2)
				);
	}
	public function deleteProjectmeta( Request $r)
	{
		//Elimino el registro
		$this->model->getDestroyTable($this->model['tablePDMeta'], $this->model['primaryPDKeyMeta'], $r->id);
		$response = ["status"=>"ok", "message"=>"Registro eliminado exitosamente"];
		return response()->json($response);
	}
	function postEditpbrmc( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$this->getInsertPbrmc($decoder['id'], $r->all());
				$response = ['status' => 'ok', 'message' => 'Información guadada exitosamente'];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = ['status' => 'no', 'message' => 'Error al guardar la información.'];
			}
		}else{
			$response = ['status' => 'no', 'message' => 'Clave no valida'];
		}
    	return response()->json($response);
	}
	public function getPdfpbrmc( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Aquí va encriptados los valores
			$this->data['token'] = $r->key;
			$this->data['row'] = $this->pbrmaService->getInfoPbrmc($decoder['id']);
			return view('templates.presupuesto.pbrmc.new.view',$this->data);
		}
	}
	public function postGenerarpdfpbrmc( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$row = $this->pbrmaService->getInfoPbrmc($decoder['id']);
				$this->data['row'] = $row;
				$this->data['request'] = $r->all();
				//Se construye el nombre del PDF
				$number = $this->getBuildFilenamePDF("PD1C",$row['header']['no_institucion'], $row['header']['no_dep_gen'], $decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectory($row['header']['no_institucion'], $row['header']['anio'], 'pres', '01c');

				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
									'margin_top' => 90,
									'margin_left' => 5,
									'margin_right' => 5,
									'margin_bottom' => 37,
								]);
				$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmc.new.pdf_header", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmc.new.pdf_footer", $this->data)->render());
				$mpdf->WriteHTML(view('templates.presupuesto.pbrmc.new.pdf_body',$this->data));
				//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
				//Generación del nombre del PDF
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				$this->model->getUpdateTable(['c_url' => $number], $this->model['tablePDReg'],  $this->model['primaryPDKeyReg'], $decoder['id']);
				$this->getInsertTablePlan($row['id']['idi'], $number, $url, $result['directory']);
				//Return del resultado con el key
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
				\SiteHelpers::auditTrail( $r , 'Error al generar el PDF - PbRM-01c !'.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error", "message"=>"Error de Key!"];
		}
		return response()->json($response);
	}
	public function postReversepbrmc( Request $r )
	{
		$request = $r->params;
		$decoder = SiteHelpers::CF_decode_json($request['key']);
		if($decoder){
			$this->model->getUpdateTable(['c_url' => null], $this->model['tablePDReg'],  $this->model['primaryPDKeyReg'], $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($request['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	private function getInsertPbrmc($id, $request){
		for ($i=0; $i < count($request['idag']); $i++) {
			$data = ['idpd_pbrm01a_reg' => $id, 
						'idpd_pbrm01a_reg' => $id, 
						'codigo' 			=> $request['numero'][$i],
						'meta' 				=> $request['desc'][$i],
						'unidad_medida' 	=> $request['medida'][$i],
						'c_programado' 		=> $request['programado'][$i],
						'c_alcanzado' 		=> $request['alcanzado'][$i],
						'c_anual' 			=> $request['anual'][$i],
						'c_absoluta' 		=> $request['absoluta'][$i],
						'c_porcentaje' 		=> $request['porcentaje'][$i],
					];
			if($request['idag'][$i] > 0){
				$this->model->getUpdateTable($data, $this->model['tablePDMeta'], $this->model['primaryPDKeyMeta'], $request['idag'][$i]);
			}else{
				$this->model->getInsertTable($data, $this->model['tablePDMeta']);
			}
		}
		//actualizo el estatus
		$this->model->getUpdateTable(['c_estatus' => 2], $this->model['tablePDReg'], $this->model['primaryPDKeyReg'], $id);
	}

	/*
	 *
	 * MODULO PBRM-02A
	 *  
	 */
	public function getEditpbrmaa( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$row = $this->pbrmaService->getInfoPbrmaa($decoder['id']);
			$this->data['row'] = $row;
			//Valores encriptados
			$this->data['token'] = $r->key;
			$this->data['porcentajes'] = $this->getPorcentajePobBeneficiada();
			return view('presupuestopbrma.metas.edit',$this->data);
		}
	}
	function postEditpbrmaa( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$this->getInsertPbrmaa($decoder['id'], $r->all());
				$response = ['status' => 'ok', 'message' => 'Información guadada exitosamente'];
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!'.$e->getMessage());
				$response = ['status' => 'no', 'message' => 'Error al guardar la información.'];
			}
		}else{
			$response = ['status' => 'no', 'message' => 'Clave no valida'];
		}
    	return response()->json($response);
	}
	private function getInsertPbrmaa($id, $request){
		for ($i=0; $i < count($request['idaa']); $i++) {
			$data = [
						'aa_loc_beneficiada' => $request['loc_ben'][$i],
						'aa_pob_beneficiada' => $request['pob_ben'][$i],
						'aa_anual' 			=> $request['anual'][$i],
						'aa_trim1' 			=> $request['trim1'][$i],
						'aa_trim2' 			=> $request['trim2'][$i],
						'aa_trim3' 			=> $request['trim3'][$i],
						'aa_trim4' 			=> $request['trim4'][$i],
						'aa_porc1' 			=> $request['porc1'][$i],
						'aa_porc2' 			=> $request['porc2'][$i],
						'aa_porc3' 			=> $request['porc3'][$i],
						'aa_porc4' 			=> $request['porc4'][$i]
					];
				$this->model->getUpdateTable($data, $this->model['tablePDMeta'], $this->model['primaryPDKeyMeta'], $request['idaa'][$i]);
		}
		//actualizo el estatus
		$this->model->getUpdateTable(['aa_estatus' => 2], $this->model['tablePDReg'], $this->model['primaryPDKeyReg'], $id);
	}
	public function getPdfpbrmaa( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			//Aquí va encriptados los valores
			$this->data['token'] = $r->key;
			$this->data['row'] = $this->pbrmaService->getInfoPbrmaa($decoder['id']);
			return view('templates.presupuesto.pbrmaa.new.view',$this->data);
		}
	}
	public function postGenerarpdfpbrmaa( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			try {
				$row = $this->pbrmaService->getInfoPbrmaa($decoder['id']);
				$this->data['row'] = $row;
				$this->data['request'] = $r->all();
				//Se construye el nombre del PDF
				$number = $this->getBuildFilenamePDF("PD2A",$row['header']['no_institucion'], $row['header']['no_dep_gen'], $decoder['id']);
				$filename = $number.".pdf";
				//Construcción del directorio donde se va almacenar el PDF
				$result = $this->getBuildDirectory($row['header']['no_institucion'], $row['header']['anio'], 'pres', '02a');
				$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
										'margin_top' => 80,
										'margin_left' => 5,
										'margin_right' => 5,
										'margin_bottom' => 35,
										]);
				$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmaa.new.pdf_header", $this->data)->render());
				$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmaa.new.pdf_footer", $this->data)->render());
				$mpdf->WriteHTML(view('templates.presupuesto.pbrmaa.new.pdf_body',$this->data));
				//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
				//Generación del nombre del PDF
				//Construcción del full path
				$url = $result['full_path'].$filename;
				//Save PDF in directory
				$mpdf->Output($url, 'F');
				$this->model->getUpdateTable(['aa_url' => $number], $this->model['tablePDReg'],  $this->model['primaryPDKeyReg'], $decoder['id']);
				$this->getInsertTablePlan($row['id']['idi'], $number, $url, $result['directory']);
				//Return del resultado con el key
				$response = ["status"=>"ok", "message"=>"PDF generado exitosamente.", "number"=> $number];
			} catch (\Exception $e) {
				$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
				\SiteHelpers::auditTrail( $r , 'Error al generar el PDF - PbRM-02a !'.$e->getMessage());
			}
		}else{
			$response = ["status"=>"error", "message"=>"Error al generar el PDF"];
		}
		return response()->json($response);
	}
	public function postReversepbrmaa( Request $r )
	{
		$request = $r->params;
		$decoder = SiteHelpers::CF_decode_json($request['key']);
		if($decoder){
			$this->model->getUpdateTable(['aa_url' => null], $this->model['tablePDReg'],  $this->model['primaryPDKeyReg'], $decoder['id']);
			//Cambio el estatus del PDF a 2
			$this->model->updatePlanPDF($request['number']);
			$response = ["status"=>"ok", "message"=>"PDF revertido exitosamente."];
		}else{
			$response = ["status"=>"error", "message"=>"Error de clave!"];
		}
		return response()->json($response);
	}
	public function getPorcentajePobBeneficiada(){
		return [100,90,80,70,60,50,40,30,20,10];
	}
}