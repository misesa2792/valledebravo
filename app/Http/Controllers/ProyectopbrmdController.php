<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Proyectopbrmd;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ProyectopbrmdController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'proyectopbrmd';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Proyectopbrmd();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'proyectopbrmd',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('proyectopbrmd.index',$this->data);
	}	
	public function getPrincipal( Request $request )
	{
		$this->data['access'] = $this->access;
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
			$rows = $this->getRowsAreasAdmin($this->data['idi'], $request->idy);//(type,idinstitucion)
		}else{
			$rows = $this->getRowsAreasEnlace($this->data['idi'], $request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('proyectopbrmd.principal',$this->data);
	}
	private function getRowsAreasAdmin($idi, $idy){
		$data = array();
		foreach ($this->model->getAreasGeneralForYear($idi, $idy) as $v) {
			$data[] = array("ida"=>$v->idarea,
							"no"=>$v->no_dep_gen,
							"area"=>$v->dep_gen,
							"titular"=>$v->titular,
							"rows_coor"=> $this->model->getCoordinacionesGeneral($v->idarea,$idi),
						);
		}
		return $data;
	}
	private function getRowsAreasEnlace($idi, $idy){
		$data = array();
		$idu = \Auth::user()->id;
		$access = $this->model->getPermisoAreaForYearDenGen($idu);
		if($access[0]->dep_gen != null){
			$replace = str_replace('"',"'",$access[0]->dep_gen);
			foreach ($this->model->getAreasGeneralForYearDepGen($idi, $idy, $replace) as $v) {
				$permiso = $this->model->getPermisoCoordinacion($idu,$v->idarea,$idi);//sximo
				$data[] = array("ida"=>$v->idarea,
								"no"=>$v->no_dep_gen,
								"area"=>$v->dep_gen,
								"titular"=>$v->titular,
								"rows_coor"=>$this->model->getDepAuxPorArea($v->idarea),
							);
			}
		}
		return $data;

		/*$data = array();
		$idu = \Auth::user()->id;
		$access = $this->model->getPermisoAreaForYear($idu, $idy);//sximo
		foreach ($this->model->getAreasEnlacesGeneralForYear($access[0]->permiso,$idi) as $v) {
			$permiso = $this->model->getPermisoCoordinacion($idu,$v->idarea,$idi);//sximo
			$data[] = array("ida"=>$v->idarea,
							"no"=>$v->no_dep_gen,
							"area"=>$v->dep_gen,
							"titular"=>$v->titular,
							"rows_coor"=>$this->model->getCoordinacionesPermisosGeneral($v->idarea,$permiso[0]->permiso,$idi),
						);
		}
		return $data;*/
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		$this->data['ida'] = $decoder['ida'];//idarea
		$this->data['idi'] = $decoder['idi'];//idinstitucion
		$this->data['idac'] = $decoder['idac'];//idarea_coordinacion
		$this->data['idy'] = $request->idy;
		$this->data['year'] = $request->year;
		$this->data['k'] = $request->k;
		$row = $this->model->getAreaCoordinacion($decoder['idac']);
		$this->data['row'] = $row[0];
		$this->data['instituciones'] = $this->model->getCatInstitucionesID($decoder['idi']);
		return view('proyectopbrmd.anio',$this->data);
	}		
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idac'] = $decoder['idac'];//ui_area_coordinaciones
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$data = array();
		$data[] = array("idanio"=>$r->idy,
						"anio"=>$r->year,
						"valores"=>$this->getRowsProgramasMIR($decoder['idac'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('proyectopbrmd.search',$this->data);
	}
	private function getRowsProgramasMIR($idac, $idy){
		$data = [];
		foreach ($this->model->getProyectosAnio($idac, $idy) as $v) {
			if(isset($data[$v->no_programa])){
				$data[$v->no_programa]['rows'][] = ["id" => $v->id, "mir" => $v->mir, "nombre_indicador"=> $v->nombre_indicador, "frecuencia" => $v->frecuencia,"url" => $v->url];
			}else{
				$data[$v->no_programa] = ["no_programa" => $v->no_programa,
										"programa" => $v->programa,
											"rows" => [["id" => $v->id, "mir" => $v->mir, "nombre_indicador"=> $v->nombre_indicador, "frecuencia" => $v->frecuencia,"url" => $v->url]] 
										];
			}
		}
		return $data;
	}
	public function getAdd( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		//Obtengo todos los proyectos registrados
		$this->data['rows_pilares'] = $this->model->getPilares($r->idperiodo);
		$idanio = $r->idanio == 4 ? 3 : $r->idanio;
		$this->data['rows_programas'] = $this->model->getProgramasActivos($idanio);//sximo
		$this->data['rowsProjects'] = $this->model->getProjectsActive($idanio);//sximo
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		return view('proyectopbrmd.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		$rows = $this->model->getPbrmd($r->id);
		$this->data['rows'] = $rows[0];
		$this->data['registros'] = $this->model->getProyectosPbrmd($r->id);
		//Obtengo todos los proyectos registrados
		$this->data['rows_pilares'] = $this->model->getPilares($r->idperiodo);
		$idanio = $r->idanio == 4 ? 3 : $r->idanio;
		$this->data['rows_programas'] = $this->model->getProgramasActivos($idanio);//sximo
		$this->data['rowsProjects'] = $this->model->getProjectsActive($idanio);//sximo
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		return view('proyectopbrmd.edit',$this->data);
	}
	function postEdit( Request $r)
	{
		try {
			$data = array(
							"idprograma"=>$r->idp,
							"idproyecto"=>$r->idproyecto,
							"idpdm_pilares"=>$r->idpdm_pilares,
							"temas_desarrollo"=>$r->temas_desarrollo,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
							"nombre_indicador"=>$r->nombre_indicador,
							"formula"=>$r->formula,
							"interpretacion"=>$r->interpretacion,
							"dimencion"=>$r->dimencion,
							"frecuencia"=>$r->frecuencia,
							"factor"=>$r->factor,
							"tipo"=>$r->tipo_ind,
							"desc_factor"=>$r->desc_factor,
							"linea"=>$r->linea,
							"descripcion_meta"=>$r->descripcion_meta,
							"medios_verificacion"=>$r->medios_verificacion,
							"metas_actividad"=>$r->metas_actividad,
							"porc1"=>$r->porc1,
							"porc2"=>$r->porc2,
							"porc3"=>$r->porc3,
							"porc4"=>$r->porc4,
							"porc_anual"=>$r->porc_anual,
							"mir"=>$r->mir
						);
			$id = $this->model->insertRow($data,$r->id);
			for ($i=0; $i < count($r->idad); $i++) { 
				$arr = array("idproy_pbrm01d"=>$id,
							"indicador"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"tipo_operacion"=>$r->tipo[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"trim4"=>$r->trim4[$i],
							"anual"=>$r->anual[$i],
						);
				if($r->idad[$i] == "0"){
					$this->model->getInsertTable($arr,"ui_proy_pbrm01d_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_proy_pbrm01d_reg","idproy_pbrm01d_reg",$r->idad[$i]);
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
		$this->model->getDestroyTable("ui_proy_pbrm01d_reg","idproy_pbrm01d_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getAddtr( Request $r)
	{
		$this->data['catalogos'] = $this->getCatalogosGeneralPbrmd();
		$this->data['time'] = rand(3,100).time();
		return view('proyectopbrmd.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea_coordinacion"=>$r->idac,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idp,
							"idpdm_pilares"=>$r->idpdm_pilares,
							"temas_desarrollo"=>$r->temas_desarrollo,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
							"nombre_indicador"=>$r->nombre_indicador,
							"formula"=>$r->formula,
							"interpretacion"=>$r->interpretacion,
							"dimencion"=>$r->dimencion,
							"frecuencia"=>$r->frecuencia,
							"factor"=>$r->factor,
							"tipo"=>$r->tipo_ind,
							"desc_factor"=>$r->desc_factor,
							"linea"=>$r->linea,
							"descripcion_meta"=>$r->descripcion_meta,
							"medios_verificacion"=>$r->medios_verificacion,
							"metas_actividad"=>$r->metas_actividad,
							"porc1"=>$r->porc1,
							"porc2"=>$r->porc2,
							"porc3"=>$r->porc3,
							"porc4"=>$r->porc4,
							"porc_anual"=>$r->porc_anual,
							"idproyecto"=>$r->idproyecto,
						);
			$id = $this->model->insertRow($data,0);
			for ($i=0; $i < count($r->idad); $i++) { 
				$arr = array("idproy_pbrm01d"=>$id,
							"indicador"=>$r->desc[$i],
							"unidad_medida"=>$r->medida[$i],
							"tipo_operacion"=>$r->tipo[$i],
							"trim1"=>$r->trim1[$i],
							"trim2"=>$r->trim2[$i],
							"trim3"=>$r->trim3[$i],
							"trim4"=>$r->trim4[$i],
							"trim4"=>$r->trim4[$i],
							"anual"=>$r->anual[$i],
						);
				$this->model->getInsertTable($arr,"ui_proy_pbrm01d_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar proyecto!'.$e->getMessage());
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
			$nombreArchivo = date('d-m-Y') . " Proyecto PbRM-01d.pdf";
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
			$this->data['token'] = $r->key;
			//proyectos
			$proy = $this->model->getPbrmd($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['projects'] = $this->model->getProyectosPbrmd($decoder['id']);
			return view('templates.presupuesto.pbrmd.view',$this->data);
		}
	}	
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy = $this->model->getPbrmd($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['projects'] = $this->model->getProyectosPbrmd($decoder['id']);

			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			$directory = "archivos/{$proy[0]->no_municipio}/proyectos/pbrma01d/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
			

			/*
			* 2024-01-09, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
			* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
			*/
			
			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 35,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 35,
			]);

			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmd.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmd.pdf_body',$this->data));
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmd.pdf_footer", $this->data)->render());
			//return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
			$time = time();
			$filename = '/'.$decoder['id']."_ ".$time.'.pdf';
			$url = $folder.$filename;
			$mpdf->Output($url, 'F');//Save PDF in directory

			$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);
			
			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
		}
	}
	public function getDestroy( Request $r )
	{
		foreach ($this->model->getProyectosPbrmd($r->id) as $v) {
			$this->model->getDestroyTable("ui_proy_pbrm01d_reg","idproy_pbrm01d_reg",$v->idproy_pbrm01d_reg);
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

}