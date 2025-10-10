<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Proyectopbrmc;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,SiteHelpers ; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ProyectopbrmcController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'proyectopbrmc';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Proyectopbrmc();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'proyectopbrmc',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('proyectopbrmc.index',$this->data);
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
			$rows = $this->getRowsAreasAdmin($this->data['idi'], $request->idy);//(type,idinstitucion)
		}else{
			$rows = $this->getRowsAreasEnlace($this->data['idi'], $request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('proyectopbrmc.principal',$this->data);
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
		return $data;
		*/
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
		return view('proyectopbrmc.anio',$this->data);
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
						"rows"=>$this->model->getProyectosAnio($decoder['idac'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('proyectopbrmc.search',$this->data);
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
			$nombreArchivo = date('d-m-Y') . " Proyecto PbRM-01c.pdf";
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
			//Asignación de valores
			$this->data['token'] = $r->key;
			//proyectos
			$proy = $this->model->getPbrmc($decoder['id']);
			$this->data['proy'] = $proy[0];
			$this->data['projects'] = $this->model->getProyectosPbrmc($decoder['id']);;
			return view('templates.presupuesto.pbrmc.view',$this->data);
		}
	}
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy=$this->model->getPbrmc($decoder['id']);
			$this->data['proy'] = $proy[0];
			//Valores que se llenan en la caja de texto
			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			//Cargos
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['te_c'] = $r->te_c;//Tesorero
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			$directory = "archivos/{$proy[0]->no_municipio}/proyectos/pbrma01c/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
			
			/*
			* 2024-01-09, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
			* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
			*/

			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 90,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 37,
			]);
			// Configurar encabezado
			$this->data['projects'] =  $this->model->getProyectosPbrmc($decoder['id']);

			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmc.pdf_header", $this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmc.pdf_footer", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmc.pdf_body',$this->data));

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
	
	public function getGenerarpdfcparte2( Request $r )
	{

		
					
		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
		'margin_top' => 80,
		'margin_left' => 2,
		'margin_right' => 2,
		'margin_bottom' => 34,
		]);

	
			$rows = \DB::select("SELECT a.idproy_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto,y.anio,
			ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen,ar.cargo, i.descripcion as institucion,
			i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,a.total FROM ui_proy_pbrm01c a
			inner join ui_proyecto p on p.idproyecto = a.idproyecto
				inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = s.idprograma
			inner join ui_anio y on y.idanio = a.idanio
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
				inner join ui_area ar on ar.idarea = ac.idarea
					inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
						inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			where a.idanio = 4 and ar.idarea in (223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243) order by ar.numero  asc ");
			//where a.idanio = 4 and ar.idarea in (223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243) order by ar.numero  asc 
			foreach ($rows as $key => $v) {
				$valores = $v;
					$this->data['proy'] = $valores;
					//Valores que se llenan en la caja de texto
					$this->data['txt_titular_dep'] = $v->titular_dep_gen;
					$this->data['txt_tesorero'] = "MTRO. FLORENCIO VALLADARES ZAMBRANO";
					$this->data['txt_titular_uippe'] = "M.A Y P.P. EFRAÍN ÁNGELES RUÍZ";
					//Cargos
					$this->data['ti_c'] = $v->cargo;//Titular Dep_Gen
					$this->data['te_c'] = "TESORERO MUNICIPAL";//Tesorero
					$this->data['ui_c'] = "TITULAR DE LA UNIDAD DE INFORMACIÓN, PLANEACIÓN, PROGRAMACIÓN Y EVALUACIÓN";//UIPPE
		
					$directory = "archivos/pbrmasesmas";
					$folder = public_path($directory);
					$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
					// Configurar encabezado
					$this->data['projects'] = $this->model->getProyectosPbrmc($v->id);
						$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmc.pdf_header", $this->data)->render());
						$mpdf->AddPage();
						$mpdf->WriteHTML(view('templates.presupuesto.pbrmc.pdf_body',$this->data)->render());
						$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmc.pdf_footer", $this->data)->render());
				
					$valores = null;
					
		}
		
		$time = time();
		$filename = '/'.$time.'.pdf';
		$url = $folder.$filename;
		return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
		$mpdf->Output($url, 'F');//Save PDF in directory
		dd("ok");
	}
	public function getGenerarpdfcparte1( Request $r )
	{
		$rows = \DB::select("SELECT a.idproy_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto,y.anio,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen,ar.cargo, i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,a.total FROM ui_proy_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = s.idprograma
		inner join ui_anio y on y.idanio = a.idanio
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where a.idanio = 4 and ar.idarea in (197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222) order by ar.numero  asc ");

					
		$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
		'margin_top' => 90,
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_bottom' => 37,
		]);
		foreach ($rows as $key => $v) {
			$this->data['proy'] = $v;
			//Valores que se llenan en la caja de texto
			$this->data['txt_titular_dep'] = $v->titular_dep_gen;
			$this->data['txt_tesorero'] = "MTRO. FLORENCIO VALLADARES ZAMBRANO";
			$this->data['txt_titular_uippe'] = "M.A Y P.P. EFRAÍN ÁNGELES RUÍZ";
			//Cargos
			$this->data['ti_c'] = $v->cargo;//Titular Dep_Gen
			$this->data['te_c'] = "TESORERO MUNICIPAL";//Tesorero
			$this->data['ui_c'] = "TITULAR DE LA UNIDAD DE INFORMACIÓN, PLANEACIÓN, PROGRAMACIÓN Y EVALUACIÓN";//UIPPE

			$directory = "archivos/pbrmasesmas";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.
			$metas = [];
			// Configurar encabezado
			$metas = $this->model->getProyectosPbrmc($v->id);
			$this->data['projects'] =  $metas;

			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmc.pdf_header", $this->data)->render());
			$mpdf->AddPage();
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmc.pdf_body',$this->data)->render());
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmc.pdf_footer", $this->data)->render());
	
		}
		$time = time();
		$filename = '/'.$time.'.pdf';
		$url = $folder.$filename;
		return $mpdf->Output("PDF.pdf", \Mpdf\Output\Destination::INLINE);
		$mpdf->Output($url, 'F');//Save PDF in directory
		dd("ok");
	}
	public function getDestroy( Request $r )
	{
		foreach ($this->model->getRegistrosPbrmc($r->id) as $v) {
			$this->model->getDestroyTable("ui_proy_pbrm01c_reg","idproy_pbrm01c_reg",$v->id);
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
	public function getAdd( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		//Obtengo todos los proyectos registrados
		$idanio = $r->idanio == 4 ? 3 : $r->idanio;
		$this->data['rows_projects'] = $this->model->getProjects($idanio);
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		return view('proyectopbrmc.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		$this->data['idac'] = $r->idac;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		$this->data['id'] = $r->id;
		$rows = $this->model->getPbrmc($r->id);
		$this->data['rows'] = $rows[0];
		//Obtengo el nombre de la dependencia general y auxiliar
		$row = $this->model->getAreaCoordinacion($r->idac);
		$this->data['row'] = $row[0];
		$this->data['registros'] = $this->model->getProyectosPbrmc($r->id);
		return view('proyectopbrmc.edit',$this->data);
	}
	public function getAddtr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('proyectopbrmc.tr',$this->data);	
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_proy_pbrm01c_reg","idproy_pbrm01c_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea_coordinacion"=>$r->idac,
							"idanio"=>$r->idanio,
							"idproyecto"=>$r->idp,
							"total"=>$this->getClearNumber($r->total),
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
						);
			$id = $this->model->insertRow($data,0);
			for ($i=0; $i < count($r->idag); $i++) { 
				$limpieza = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $r->desc[$i]);
				$arr = array("idproy_pbrm01c"=>$id,
							"codigo"=>$r->numero[$i],
							"meta"=> mb_substr(rtrim($limpieza), 0, 73),
							"unidad_medida"=>rtrim($r->medida[$i]),
							"programado"=>$r->programado[$i],
							"alcanzado"=>$r->alcanzado[$i],
							"anual"=>$r->anual[$i],
							"absoluta"=>$r->absoluta[$i],
							"porcentaje"=>$r->porcentaje[$i]
						);
				$this->model->getInsertTable($arr,"ui_proy_pbrm01c_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar proyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	function postEdit( Request $r)
	{
		try {
			$data = array("total"=>$this->getClearNumber($r->total));
			$id = $this->model->insertRow($data,$r->id);
			
			for ($i=0; $i < count($r->idag); $i++) { 
				$limpieza = str_replace($this->getControllerFindLetrasPbRM(), $this->getControllerRempLetrasPbRM(), $r->desc[$i]);
				$arr = array("idproy_pbrm01c"=>$id,
							"codigo"=>$r->numero[$i],
							"meta"=> mb_substr(rtrim($limpieza), 0, 73),
							"unidad_medida"=>$r->medida[$i],
							"programado"=>$r->programado[$i],
							"alcanzado"=>$r->alcanzado[$i],
							"anual"=>$r->anual[$i],
							"absoluta"=>$r->absoluta[$i],
							"porcentaje"=>$r->porcentaje[$i]
						);
				if($r->idag[$i] == "0"){
					$this->model->getInsertTable($arr,"ui_proy_pbrm01c_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_proy_pbrm01c_reg","idproy_pbrm01c_reg",$r->idag[$i]);
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
}