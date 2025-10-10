<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrma;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,SiteHelpers ; 
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Exportar;

class PbrmaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrma';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrma();
		$this->area = new Area();
		$this->exportar = new Exportar();
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrma',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('pbrma.index',$this->data);
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

		if($gp == 1 || $gp == 2){
			$this->data['rowsInstituciones'] = $this->model->getCatInstituciones();
		}else{
			$this->data['rowsInstituciones'] = $this->model->getCatInstitucionesID($idi);
		}
		if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
			$rows = $this->model->getAreasGeneralForYear($this->data['idi'], $request->idy);
		}else{
			$permiso = $this->model->getPermisoAreaForYear(\Auth::user()->id, $request->idy);
			$rows = $this->model->getAreasEnlacesGeneralForYear($permiso[0]->permiso,$this->data['idi']);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('pbrma.principal',$this->data);
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
		return view('pbrma.anio',$this->data);
	}
	public function getSearch( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		//Asignación de valores
		$this->data['ida'] = $decoder['ida'];//ui_area
		$this->data['idi'] = $decoder['idi'];//ui_instituciones
		$data = array();
		$data[] = array("idanio"=>$r->idy,
						"anio"=>$r->year,
						"rows"=>$this->model->getProgramasAnio($decoder['ida'], $r->idy),
					);
		$this->data['rows'] = json_encode($data);
		//Vista
		return view('pbrma.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$this->data['programas'] = $this->model->getProgramas();
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		return view('pbrma.add',$this->data);
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		$row = $this->model->getPbrma($decoder['id']);
		$this->data['programas'] = $row[0];
		$this->data['rows'] = $this->model->getProyectosPbrma($decoder['id']);
		$this->data['depgen'] = $this->model->getCatDepGen($decoder['idarea']);
		$this->data['proyectos'] = $this->model->getProyectos($row[0]->idprograma);
		$this->data['auxiliares'] = $this->model->getDepAuxiliares($decoder['idarea']);
		$this->data['idarea'] = $decoder['idarea'];
		$this->data['anio'] = $decoder['anio'];
		//Valores encriptados
		$this->data['k'] = $r->key;
		return view('pbrma.edit',$this->data);
	}
	public function getPrograma( Request $r )
	{
		$this->data['idprograma'] = $r->idprograma;
		$this->data['idarea'] = $r->idarea;
		return view('pbrma.programa',$this->data);
	}
	public function getDownloadpdf( Request $r ){
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			//Obtengo la URL
			$row = $this->model->find($decoder['id'],['url']);
			//Asigno el path completo
			$rutaArchivo = public_path($row->url);
			//Nombre del archivo 
			$nombreArchivo = date('d-m-Y') . " Anteproyecto PbRM-01a.pdf";
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
		//Asignación de valores
		$this->data['id'] = $decoder['id'];//idpbrma01a
		$this->data['anio'] = $decoder['anio'];//anio
		//Aquí va encriptados los valores
		$this->data['k'] = $r->key;//key_encrypt (id,anio,idanio,idi,idarea)
		//Institución logos
		$ins = $this->model->getInstitucion($decoder['idi']);
		$this->data['ins'] = $ins[0];
		$area = $this->model->getCatDepGen($decoder['idarea']);
		$this->data['area'] = $area[0];
		$row = $this->model->getPbrma($decoder['id']);
		$this->data['row'] = $row[0];
		$this->data['rows_projects'] = $this->model->getProyectosPbrma($decoder['id']);
		return view('pbrma.pdf.view',$this->data);
	}
	public function getGenerarpdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		//Se obtienen la información del registros
		$row=$this->model->getPbrma($decoder['id']);
		$this->data['row'] = $row[0];
		//Obtención de los registros
		$this->data['rows_projects'] = $this->model->getProyectosPbrma($decoder['id']);
		$this->data['txt_titular_dep'] = $r->txt_titular_dep;
		$this->data['txt_tesorero'] = $r->txt_tesorero;
		$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
		$this->data['anio'] = $decoder['anio'];
		$this->data['idi'] = $decoder['idi'];
		//Institución logos
		$ins = $this->model->getInstitucion($decoder['idi']);
		$this->data['ins'] = $ins[0];
		//Directorio donde se va a guardar el PDF del anteproyecto
		$directory = "archivos/anteproyectos/pbrma01a/{$decoder['anio']}/{$decoder['id']}";
		//Se coloca el path de la raiz
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
		$mpdf->SetHTMLHeader(View::make("pbrma.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("pbrma.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('pbrma.pdf.pdf',$this->data));
		//Generación del nombre del PDF
		$filename = '/'.$decoder['id']."_ ".time().'.pdf';
		$url = $folder.$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		//Guardo la URL en la base de datos
		$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);
		//Se regresa el key para descargar el PDF
		$response = array("success"=>"ok","k"=>$r->key);
		return json_encode($response);
	}
	public function getDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		//Se eliminan los registros
		foreach ($this->model->getRegistrosPbrma($decoder['id']) as $v) {
			$this->model->getDestroyTable("ui_ap_pbrm01a_reg","idap_pbrm01a_reg",$v->id);
		}
		//Se elimina el registro
		$this->model->destroy($decoder['id']);
		//Se regresa un estatus
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	public function getRevertir( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
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
		return view('pbrma.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea"=>$r->idarea,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idprograma,
							"total"=>$this->getClearNumber($r->total),
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>Carbon::now()->format('H:i:s A'),
						);
			$id = $this->model->insertRow($data,0);
			for ($i=0; $i < count($r->idac); $i++) { 
				$arr = array("idap_pbrm01a"=>$id,
							"idarea_coordinacion"=>$r->idac[$i],
							"idproyecto"=>$r->idp[$i],
							"presupuesto"=>$this->getClearNumber($r->pres[$i]),
						);
				$this->model->getInsertTable($arr,"ui_ap_pbrm01a_reg");
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		try {
			$data = array("total"=>$this->getClearNumber($r->total),
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>date('H:i:s A'));
			$id = $this->model->insertRow($data, $decoder['id']);

			for ($i=0; $i < count($r->ida); $i++) { 
				$arr = array("idap_pbrm01a"=>$decoder['id'],
							"idarea_coordinacion"=>$r->idac[$i],
							"idproyecto"=>$r->idp[$i],
							"presupuesto"=>$this->getClearNumber($r->pres[$i]),
						);
				if($r->ida[$i] == "0"){
					$this->model->getInsertTable($arr,"ui_ap_pbrm01a_reg");
				}else{
					$this->model->getUpdateTable($arr,"ui_ap_pbrm01a_reg","idap_pbrm01a_reg",$r->ida[$i]);
				}
			}
			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al editar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_ap_pbrm01a_reg","idap_pbrm01a_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	/*public function getLimpiardecominacion( Request $r ){
		
		foreach (\DB::select("SELECT r.idreporte_reg as id FROM ui_reporte_reg r
					inner join ui_reporte re on re.idreporte = r.idreporte
					where re.idanio_module = 4 and re.type = 1") as $v) {
			$data = ['denominacion'=> null];
			$this->model->getUpdateTable($data, "ui_reporte_reg", "idreporte_reg",$v->id);
		}
		dd("ok");
	}*/
	/*public function getAreadepgen( Request $r ){
		
		foreach (\DB::select("SELECT idarea,idinstituciones,idanio,idanio_module FROM ui_area where idinstituciones = 1") as $v) {
			$data = ['idanio_module'=> $v->idanio];
			$this->model->getUpdateTable($data, "ui_area", "idarea",$v->idarea);
		}
		foreach (\DB::select("SELECT idreporte,idanio,idanio_module FROM ui_reporte") as $v) {
			$data = ['idanio_module'=> $v->idanio];
			$this->model->getUpdateTable($data, "ui_reporte", "idreporte",$v->idreporte);
		}
		dd("ok");
	}*/
	/*public function getLimpiarcadenauno( Request $r ){
		
		$rows =  \DB::select("SELECT r.idproy_pbrm01c_reg as id,r.meta FROM ui_proy_pbrm01c c
		inner join ui_proy_pbrm01c_reg r  on c.idproy_pbrm01c = r.idproy_pbrm01c
		");
		$data = [];
		foreach ($rows as $v) {
			$carpeta = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $v->meta);
			$data = ['meta'=>  mb_substr(rtrim($carpeta), 0, 73), 'meta_old'=> $v->meta];
			$this->model->getUpdateTable($data, "ui_proy_pbrm01c_reg", "idproy_pbrm01c_reg",$v->id);
		}
		dd("ok");
	}
	public function getLimpiarcadenados( Request $r ){
		$rows =  \DB::select("SELECT idproy_pbrm02a_reg as id,meta FROM ui_proy_pbrm02a_reg");
		$data = [];
		foreach ($rows as $v) {
			$carpeta = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $v->meta);
			$data = ['meta'=>  mb_substr(rtrim($carpeta), 0, 73), 'meta_old'=> $v->meta];
			$this->model->getUpdateTable($data, "ui_proy_pbrm02a_reg", "idproy_pbrm02a_reg",$v->id);
		}
		dd("ok");
	}*/
	/*public function getMigrarpbrmaa( Request $r ){
		$rows =  \DB::select("SELECT idproy_pbrm02a as id,idarea_coordinacion as idac,idanio,idproyecto FROM ui_proy_pbrm02a where idanio = 4");

		foreach ($rows as $key => $v) {
			$data = ['id_area_coordinacion' => $v->idac, 
					'idanio_module' => $v->idanio,
					'idproyecto' => $v->idproyecto,
					'type' => 0
				];
			$ver =  \DB::select("SELECT idreporte as id FROM ui_reporte where id_area_coordinacion = {$v->idac} and idanio_module = {$v->idanio} and idproyecto = {$v->idproyecto} and type = 0");
			if(count($ver) == 0){
				$id = $this->model->getInsertTable($data, 'ui_reporte');
				$metas =  \DB::select("SELECT * FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
				foreach ($metas as $m) {
					$data_metas = ['idreporte' => $id, 
									'no_accion' =>$m->codigo,
									'unidad_medida' =>$m->unidad_medida,
									'descripcion' =>$m->meta,
									'prog_anual' =>$m->anual,
									'trim_1' =>$m->trim1,
									'trim_2' =>$m->trim2,
									'trim_3' =>$m->trim3,
									'trim_4' =>$m->trim4
								];
					$this->model->getInsertTable($data_metas, 'ui_reporte_reg');
				}
			}
		}
		dd("ok");
	}*/
	/*public function getMigrarpbrmd( Request $r ){
		$rows =  \DB::select("SELECT idarea_coordinacion as idac,idanio,idproyecto,
				mir,nombre_indicador,formula,interpretacion,dimencion,frecuencia,factor,tipo,desc_factor,linea,descripcion_meta,medios_verificacion,metas_actividad FROM ui_proy_pbrm01d where idanio = 4
				group by idarea_coordinacion,idproyecto");

		foreach ($rows as $key => $v) {
			$data = ['id_area_coordinacion' => $v->idac, 
					'idanio_module' => $v->idanio,
					'idproyecto' => $v->idproyecto,
					'type' => 1
				];
			$ver =  \DB::select("SELECT idreporte as id FROM ui_reporte where id_area_coordinacion = {$v->idac} and idanio_module = {$v->idanio} and idproyecto = {$v->idproyecto} and type = 1");
			if(count($ver) == 0){
				$this->model->getInsertTable($data, 'ui_reporte');
			}
		}
		dd("ok");
	}
	public function getMigrarpbrmdasignar( Request $r ){
		$rows =  \DB::select("SELECT idproy_pbrm01d as id,idarea_coordinacion as idac,idanio,idproyecto,
		mir,nombre_indicador,formula,interpretacion,dimencion,frecuencia,factor,tipo,desc_factor,linea,descripcion_meta,medios_verificacion,metas_actividad FROM ui_proy_pbrm01d where idanio = 4");

		foreach ($rows as $key => $v) {
			$ver =  \DB::select("SELECT idreporte as id FROM ui_reporte where id_area_coordinacion = {$v->idac} and idanio_module = {$v->idanio} and idproyecto = {$v->idproyecto} and type = 1");
			if(count($ver) > 0){
				$tipo_ind = \DB::select("SELECT idtipo_indicador as id FROM ui_tipo_indicador where descripcion = '{$v->tipo}'");
				$fre = \DB::select("SELECT idfrecuencia_medicion as id FROM ui_frecuencia_medicion where descripcion = '{$v->frecuencia}'");
				$dim = \DB::select("SELECT iddimension_atiende as id FROM ui_dimension_atiende where descripcion = '{$v->dimencion}'");
				$idfrecuencia = (count($fre) > 0 ? $fre[0]->id : 0);
				$data = ['idreporte' 	=> $ver[0]->id, 
					'idrelacion' 	    => $v->id, 
					'mir' 				=> $v->mir, 
					'nombre_indicador' 	=> $v->nombre_indicador,
					'formula' 			=> $v->formula,
					'interpretacion' 	=> $v->interpretacion,
					'iddimension_atiende' 	=> (count($dim) > 0 ? $dim[0]->id : 0),
					'idfrecuencia_medicion' => $idfrecuencia,
					'factor' 			=> $v->factor,
					'idtipo_indicador'  => (count($tipo_ind) > 0 ? $tipo_ind[0]->id : 0),
					'desc_factor' 		=> $v->desc_factor,
					'linea' 			=> $v->linea,
					'descripcion_meta' 	=> $v->descripcion_meta,
					'medios_verificacion' => $v->medios_verificacion,
					'metas_actividad' 		=> $v->metas_actividad
				];
				$idmir = $this->model->getInsertTable($data, 'ui_reporte_mir');
				
				foreach (\DB::select("SELECT indicador,unidad_medida,tipo_operacion,trim1,trim2,trim3,trim4,anual FROM ui_proy_pbrm01d_reg where idproy_pbrm01d = {$v->id}") as $k) {
					$tipo = \DB::select("SELECT idtipo_operacion as id FROM ui_tipo_operacion where descripcion = '{$k->tipo_operacion}'");
					$arr = ['idreporte' 	=> $ver[0]->id, 
							'idreporte_mir' => $idmir,
							'idtipo_operacion' 	=> (count($tipo) > 0 ? $tipo[0]->id : 0),
							'idfrecuencia_medicion' => $idfrecuencia,
							'no_accion' 	=> $v->mir,
							'unidad_medida' => $k->unidad_medida,
							'descripcion' 	=> $k->indicador,
							'denominacion' 	=> $v->nombre_indicador,
							'prog_anual' 	=> $k->anual,
							'trim_1' 		=> $k->trim1,
							'trim_2' 		=> $k->trim2,
							'trim_3' 		=> $k->trim3,
							'trim_4' 		=> $k->trim4,

						];
					$this->model->getInsertTable($arr, 'ui_reporte_reg');
				}
			}
		}
		dd("ok");
	}
	*/
	
/*
	public function getLimpiarproc( Request $r ){
		$rows =  \DB::select("SELECT idproy_pbrm01c as id,total FROM ui_proy_pbrm01c where idanio = 4");

		foreach ($rows as $key => $v) {
				$data = ["total" => null];
				$this->model->getUpdateTable($data, "ui_proy_pbrm01c", "idproy_pbrm01c", $v->id);
		}
		dd("ok");
	}
*/
	public function getExportarpbrmaosfem( Request $r ){
		/*
		$rows =  \DB::select("SELECT a.idproy_pbrm01a as id,ar.numero as no_dep_gen,p.numero as no_programa,a.total FROM ui_proy_pbrm01a a 
			left join ui_programa p on p.idprograma = a.idprograma
			left join ui_area ar on ar.idarea = a.idarea
			where a.idanio = 4 and a.idarea = 230 ORDER BY ar.numero asc");
		*/
		$rows =  \DB::select("SELECT r.idproy_pbrm01a as id,ar.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,r.presupuesto FROM ui_proy_pbrm01a_reg r
		inner join ui_proy_pbrm01a pro on pro.idproy_pbrm01a = r.idproy_pbrm01a
        	inner join ui_area ar on ar.idarea = pro.idarea
				left join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				left join ui_proyecto p on p.idproyecto = r.idproyecto
				where pro.idanio = 4 ORDER BY ar.numero,ac.numero ASC");

		$data = [];
		foreach ($rows as $v) {
					$partes = str_split($v->no_proyecto, 2);
					$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
								"no_dep_aux" => $v->no_dep_aux,
								"fin" => "'".$partes[0],
								"fun" => "'".$partes[1],
								"sub" => "'".$partes[2],
								"prog" => "'".$partes[3],
								"subp" => "'".$partes[4],
								"proy" => "'".$partes[5],
								"pres" => $v->presupuesto// $v->no_dep_gen.'-'.$v->no_dep_aux.'-'.$v->no_proyecto
							];
		}
		return $this->getExportPbRMa($data);
	}
	public function getExportarpbrmanormal( Request $r ){
		$rows =  \DB::select("SELECT r.idproy_pbrm01a as id,ar.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,r.presupuesto FROM ui_proy_pbrm01a_reg r
		inner join ui_proy_pbrm01a pro on pro.idproy_pbrm01a = r.idproy_pbrm01a
        	inner join ui_area ar on ar.idarea = pro.idarea
				left join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				left join ui_proyecto p on p.idproyecto = r.idproyecto
				where pro.idanio = 4 ORDER BY ar.numero,ac.numero ASC");

		$data = [];
		foreach ($rows as $v) {
					$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
								"no_dep_aux" => $v->no_dep_aux,
								"proy" => "'".$v->no_proyecto,
								"pres" => $v->presupuesto
							];
		}
		return $this->getExportPbRMaNormal($data);
	}
	

	public function getReemplazarcaracteres( Request $r ){

		/*$rows =  \DB::select("SELECT objetivo,descripcion,idprograma FROM ui_programa where idanio = 3");
		foreach ($rows as $key => $v) {
			$this->model->getUpdateTable(['objetivo'=> str_replace("\r\n", " ", $v->objetivo)], "ui_programa", "idprograma", $v->idprograma);
		}*/

		/*$foda =  \DB::select("SELECT * FROM ui_proy_pbrm01b_foda order by descripcion desc;");
		foreach ($foda as $key => $v) {
			$this->model->getUpdateTable(['descripcion'=> str_replace("\r\n", " ", $v->descripcion)], "ui_proy_pbrm01b_foda", "idproy_pbrm01b_foda", $v->idproy_pbrm01b_foda);
		}*/

		/*$rows =  \DB::select("SELECT b.idproy_pbrm01b,a.numero as no_dep_gen,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,b.estrategias_objetivo,b.pdm,b.ods FROM ui_proy_pbrm01b b
		inner join ui_area a on a.idarea = b.idarea 
		inner join ui_programa p on p.idprograma = b.idprograma
		where b.idanio = 4");
		foreach ($rows as $key => $v) {
			//uno
			$this->model->getUpdateTable(['estrategias_objetivo'=> str_replace("\r\n", " ", rtrim($v->estrategias_objetivo)), 
									'pdm'=> str_replace("\r\n", " ", rtrim($v->pdm)),
								'ods'=> str_replace("\r\n", " ", rtrim($v->ods))], "ui_proy_pbrm01b", "idproy_pbrm01b", $v->idproy_pbrm01b);
			
		}*/
		dd("ok");
		
	
	}
	/*public function getLimpiarpresupuesto( Request $r ){
		$rows =  \DB::select("SELECT * FROM  ui_proy_pbrm01a where idanio = 4");
		foreach ($rows as $v) {
			$this->model->getUpdateTable(['total'=>0], "ui_proy_pbrm01a","idproy_pbrm01a",$v->idproy_pbrm01a);
		}
		$rows2 =  \DB::select("SELECT r.* FROM ui_proy_pbrm01a_reg r
			inner join ui_proy_pbrm01a a on a.idproy_pbrm01a = r.idproy_pbrm01a
			where a.idanio = 4");
		foreach ($rows2 as $d) {
			$this->model->getUpdateTable(['presupuesto'=>0], "ui_proy_pbrm01a_reg","idproy_pbrm01a_reg",$d->idproy_pbrm01a_reg);
		}
		dd("limpiado");
	}*/
	/*public function getLimpiarcadenasnuevas( Request $r ){
		$rows =  \DB::select("SELECT * FROM ui_proy_pbrm01c where idanio = 4");
		foreach ($rows as $v) {
			$this->model->getUpdateTable(['total'=>0], "ui_proy_pbrm01c","idproy_pbrm01c",$v->idproy_pbrm01c);
		}
		dd("limpiado");
	}*/
	/*public function getLimpiaremail( Request $r ){
		$rows =  \DB::select("SELECT id,username,email,active FROM tb_users where group_id = 3 and active = 0");
		foreach ($rows as $v) {
			$this->model->getUpdateTable(['email'=>null], "tb_users","id",$v->id);
		}
		dd("limpiado");
	}*/
	public function getGenerarmir( Request $r ){
		$rows =  \DB::select("SELECT idreporte_mir as id,mir,nombre_indicador,a.numero as no_dep_gen,ac.numero as no_dep_aux,pr.numero as programa FROM ui_reporte_mir m 
		inner join ui_reporte r on r.idreporte = m.idreporte 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea");
		foreach ($rows as $v) {
			$mir = $v->no_dep_gen.$v->no_dep_aux.$v->programa;
				$this->model->getUpdateTable(['mir'=> $mir ], "ui_reporte_mir","idreporte_mir",$v->id);
		}
		dd("MIR asignado correctamente.");
	}
	/*public function getUpdatemirambito( Request $r ){
		$rows =  \DB::select("SELECT idreporte_mir as id FROM ui_reporte_mir ");
		foreach ($rows as $v) {
			$data = [
							'ambito' 			=> 'Municipio de Toluca', 
							'cobertura' 		=> 'Población del municipio' 
						];
			$this->model->getUpdateTable($data, "ui_reporte_mir","idreporte_mir", $v->id);
		}
		dd("Mir actualizado correctamente.");
	}*/
	/*public function getInsertmir( Request $r ){
		$rows =  \DB::select("SELECT idreporte_mir as id FROM ui_reporte_mir ");
		foreach ($rows as $v) {
			$data = [];
			for ($i=1; $i <= 4; $i++) { 
				$data[] = ['idreporte_mir'		=> $v->id, 
							'trim' 				=> $i, 
							'desc_meta' 		=> null,
							'desc_res' 			=> null,
							'evaluacion' 		=> null,
						];
			}
			$this->model->getInsertTableData($data, "ui_reporte_mir_eva");
		}
		dd("Mir asignado correctamente.");
	}*/
	public function getColocarpres( Request $r ){
		$rows =  \DB::select("SELECT r.idproy_pbrm01a_reg as id,r.idarea_coordinacion as idac,r.idproyecto,presupuesto FROM ui_proy_pbrm01a_reg r
	inner join ui_proy_pbrm01a a on r.idproy_pbrm01a = a.idproy_pbrm01a
	where a.idanio = 4");

		foreach ($rows as $key => $v) {
			$proy =  \DB::select("SELECT * FROM ui_proy_pbrm01c where idanio = 4 and idarea_coordinacion = {$v->idac} and idproyecto = {$v->idproyecto}");
			if(count($proy) > 0){
				$data = ["total" => $v->presupuesto];
				$this->model->getUpdateTable($data, "ui_proy_pbrm01c", "idproy_pbrm01c", $proy[0]->idproy_pbrm01c);
			}
		}
		dd("ok");
	}
	public function getAsignarpresupuestoreporte( Request $r ){
		$rows =  \DB::select("SELECT idreporte as id,id_area_coordinacion as idac,idproyecto,type FROM ui_reporte where idanio_module = 4 and type = 0 and idreporte = 727");
		foreach ($rows as $v) {
			$val =  \DB::select("SELECT r.idarea_coordinacion as idac,r.idproyecto,r.presupuesto FROM ui_proy_pbrm01a_reg r 
			inner join ui_proy_pbrm01a p on r.idproy_pbrm01a = p.idproy_pbrm01a
			where p.idanio = 4 and r.idarea_coordinacion = {$v->idac} and r.idproyecto ={$v->idproyecto}");
			if(count($val) > 0){
				$this->model->getUpdateTable(['presupuesto'=> $val[0]->presupuesto ], "ui_reporte","idreporte",$v->id);
			}
		}
		dd("Presupuesto asignado correctamente!!");
	}
	public function getLimpiarcadenasreportes( Request $r ){
		$rows =  \DB::select("SELECT idreporte_reg as id,descripcion,denominacion FROM ui_reporte_reg where denominacion is not null");
		foreach ($rows as $v) {
			$denominacion = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $v->denominacion);
			$descripcion = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $v->descripcion);
			$this->model->getUpdateTable(['denominacion'=> trim(str_replace('"', "", $denominacion)), "descripcion" => trim(str_replace('"', "", $descripcion)) ], "ui_reporte_reg","idreporte_reg",$v->id);
		}

		foreach (\DB::select("SELECT idreporte_mir as id,nombre_indicador FROM ui_reporte_mir") as $v) {
			$nombre_indicador = str_replace($this->getControllerFindLetras(), $this->getControllerRempLetras(), $v->nombre_indicador);
			$this->model->getUpdateTable(['nombre_indicador'=> trim(str_replace('"', "", $nombre_indicador))], "ui_reporte_mir","idreporte_mir",$v->id);
		}
		dd("limpiado");
	}
	public function getExportarpbrmbnormal( Request $r ){
		$rows =  \DB::select("SELECT b.idproy_pbrm01b as id,a.numero as no_dep_gen,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,b.estrategias_objetivo,b.pdm,b.ods FROM ui_proy_pbrm01b b
		inner join ui_area a on a.idarea = b.idarea 
		inner join ui_programa p on p.idprograma = b.idprograma
		where b.idanio = 4 order by a.numero asc");
		$data = [];
		foreach ($rows as $v) {
			$foda = $this->getExportarpbrmbnormalType($v->id);
					$partes = str_split($v->no_programa, 2);
					$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
								"fin" => "'".$partes[0],
								"fun" => "'".$partes[1],
								"sub" => "'".$partes[2],
								"prog" => "'".$partes[3],
								"programa" => $v->programa,
								"f1" => (isset( $foda[1]) ?  $foda[1] : ''),
								"f2" => (isset( $foda[2]) ?  $foda[2] : ''),
								"f3" => (isset( $foda[3]) ?  $foda[3] : ''),
								"f4" => (isset( $foda[4]) ?  $foda[4] : ''),
								"obj" => $v->obj_programa,
								"est" => $v->estrategias_objetivo,
								"pdm" => $v->pdm,
								"ods" => $v->ods,
							];
		}
		return $this->getExportPbRMbNormal($data);
	}
	public function getExportarpbrmenormal( Request $r ){
		$rows =  \DB::select("SELECT e.idproy_pbrm01e as id,p.idprograma,a.numero as no_dep_gen,p.numero as no_programa,pi.no_tipo as eje_cambio,pi.numero as no_eje,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,p.tema_desarrollo FROM ui_proy_pbrm01e e
			inner join ui_programa p on p.idprograma = e.idprograma 
				left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
	inner join ui_area a on a.idarea = e.idarea
	where e.idanio = 4 order by a.numero,p.numero asc");
		$data = [];
		foreach ($rows as $v) {
			$row2 = $this->getRegPbRMe($v->id,2);
				$ver =  \DB::select("SELECT ac.numero as no_dep_aux FROM ui_proy_pbrm01d d 
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = d.idarea_coordinacion
			where d.idanio = 4 and d.idprograma ={$v->idprograma}");
					$partes = str_split($v->no_programa, 2);
					$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
								'no_dep_aux'=> (count($ver) > 0 ? $ver[0]->no_dep_aux : ''), 
								"fin" => "'".$partes[0],
								"fun" => "'".$partes[1],
								"sub" => "'".$partes[2],
								"prog" => "'".$partes[3],
								"programa" => $v->programa,
								"obj_programa" => $v->obj_programa,
								"tema_desarrollo" => $v->tema_desarrollo,
								"obj" => $v->obj_programa,
								"eje_cambio" => $v->eje_cambio,
								"no_eje" => "'".$v->no_eje,
								"reg1" => $this->getRegPbRMe($v->id,1),
								"reg2" => $this->getRegPbRMe($v->id,2),
								"reg3" => $this->getRegPbRMe($v->id,3),
								"reg4" => $this->getRegPbRMe($v->id,4),
							
							];
		}
		return $this->getExportPbRMeNormal($data);
	}
	public function getRegPbRMe($id,$no ){
		$ver =  \DB::select("SELECT * FROM ui_proy_pbrm01e_reg where idproy_pbrm01e = {$id} and idproy_pbrm01e_tipo = {$no}");
		return $ver;
	}
	public function getExportarpbrmdnormal( Request $r ){
		$rows =  \DB::select("SELECT d.idproy_pbrm01d as id,pi.numero as no_eje,pi.no_tipo as eje_cambio,p.tema_desarrollo,a.numero as no_dep_gen,ac.numero as no_dep_aux,y.numero as no_proyecto,p.objetivo as obj_programa,
	d.nombre_indicador,d.formula,d.interpretacion,d.dimencion,d.factor,d.desc_factor,d.tipo,d.linea,d.frecuencia,d.medios_verificacion,d.descripcion_meta FROM ui_proy_pbrm01d d
	inner join ui_area_coordinacion ac on ac.idarea_coordinacion = d.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
	inner join ui_proyecto y on y.idproyecto = d.idproyecto
		inner join ui_subprograma sp on sp.idsubprograma = y.idsubprograma
		inner join ui_programa p on p.idprograma = d.idprograma
			left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
	where d.idanio = 4 order by a.numero,ac.numero asc");
		$data = [];
		foreach ($rows as $v) {
					$partes = str_split($v->no_proyecto, 2);
					$data[] = ['eje_cambio'=>$v->eje_cambio, 
								'no_eje'=>"'".$v->no_eje, 
								'tema_desarrollo'=>$v->tema_desarrollo, 
								'no_dep_gen'=>$v->no_dep_gen, 
								'no_dep_aux'=>$v->no_dep_aux, 
								"fin" => "'".$partes[0],
								"fun" => "'".$partes[1],
								"sub" => "'".$partes[2],
								"prog" => "'".$partes[3],
								"subp" => "'".$partes[4],
								"proy" => "'".$partes[5],
								"obj_programa" => $v->obj_programa,
								"nombre_indicador" => $v->nombre_indicador,
								"tipo" => $v->tipo,
								"formula" => $v->formula,
								"interpretacion" => $v->interpretacion,
								"dimencion" => $v->dimencion,
								"factor" => $v->factor,
								"desc_factor" => $v->desc_factor,
								"linea" => $v->linea,
								"frecuencia" => $v->frecuencia,
								"medios_verificacion" => $v->medios_verificacion,
								"descripcion_meta" => $v->descripcion_meta,
								"regs" => \DB::select("SELECT * FROM ui_proy_pbrm01d_reg where idproy_pbrm01d = {$v->id}"),
							];
		}
		return $this->getExportPbRMdNormal($data);
	}
	public function getExportarpbrmbnormalType($id ){
		$data= [];
		$rows =  \DB::select("SELECT GROUP_CONCAT(descripcion SEPARATOR ';') AS foda,type FROM ui_proy_pbrm01b_foda where idproy_pbrm01b={$id} group by type");
		foreach ($rows as $key => $v) {
			$data[$v->type] = $v->foda;
		}
		return $data;
	}
	public function getExportarpbrmcosfem( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm01c as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,c.idarea_coordinacion as idac,c.idproyecto FROM ui_proy_pbrm01c c
			left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
				left join ui_area a on a.idarea = ac.idarea
			left join ui_proyecto p on p.idproyecto = c.idproyecto
			where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,programado,alcanzado,anual,absoluta,porcentaje FROM ui_proy_pbrm01c_reg where idproy_pbrm01c = {$v->id}");
			foreach ($regs as $k) {
				$partes = str_split($v->no_proyecto, 2);
				$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
							"no_dep_aux" => $v->no_dep_aux,
							"fin" => "'".$partes[0],
							"fun" => "'".$partes[1],
							"sub" => "'".$partes[2],
							"prog" => "'".$partes[3],
							"subp" => "'".$partes[4],
							"proy" => "'".$partes[5],
							"cod" => $k->codigo,
							"meta" => $k->meta,
							"um" => $k->unidad_medida,
							"progr" => $k->programado,
							"alc" => $k->alcanzado,
							"anual" => $k->anual,
							"abs" => $k->absoluta,
							"por" => $k->porcentaje,
						];
			}
		}
		return $this->getExportPbRMc($data);
	}
	public function getExportarpbrmcosfemnormal( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm01c as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,c.idarea_coordinacion as idac,c.idproyecto,c.total FROM ui_proy_pbrm01c c
			left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
				left join ui_area a on a.idarea = ac.idarea
			left join ui_proyecto p on p.idproyecto = c.idproyecto
			where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,programado,alcanzado,anual,absoluta,porcentaje FROM ui_proy_pbrm01c_reg where idproy_pbrm01c = {$v->id}");
			//$ver =  \DB::select("SELECT idproy_pbrm02a FROM ui_proy_pbrm02a where idarea_coordinacion = {$v->idac} and idanio = 4 and idproyecto = {$v->idproyecto}");
		
			foreach ($regs as $k) {
				$ver =  \DB::select("SELECT r.* FROM ui_proy_pbrm02a_reg r
				inner join ui_proy_pbrm02a a on a.idproy_pbrm02a = r.idproy_pbrm02a
				where a.idanio = 4 and a.idproyecto = {$v->idproyecto} and a.idarea_coordinacion={$v->idac} and r.meta = '{$k->meta}' ");
				$data[] = ['no_dep_gen'=>$v->no_dep_gen, 
							"no_dep_aux" => $v->no_dep_aux,
							"proy" => "'".$v->no_proyecto,
							"cod" => $k->codigo,
							"meta" => $k->meta,
							"um" => $k->unidad_medida,
							"progr" => $k->programado,
							"alc" => $k->alcanzado,
							"anual" => $k->anual,
							"abs" => $k->absoluta,
							"por" => $k->porcentaje,
							"presupuesto" => $v->total,
							"total" => count($ver) > 0 ? 'si' : 'no',
						];
			}
		}
		return $this->getExportPbRMcNormal($data);
	}
	public function getExportarpbrmaaosfem( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			foreach ($regs as $k) {
				$partes = str_split($v->no_proyecto, 2);
				$data[] = ['loc_ben'		=> 0,//$k->loc_beneficiada
							'pob_ben'		=> 100,//$k->pob_beneficiada 
							'no_dep_gen'	=> $v->no_dep_gen, 
							"no_dep_aux" 	=> $v->no_dep_aux,
							"fin" 			=> "'".$partes[0],
							"fun" 			=> "'".$partes[1],
							"sub" 			=> "'".$partes[2],
							"prog" 			=> "'".$partes[3],
							"subp" 			=> "'".$partes[4],
							"proy" 			=> "'".$partes[5],
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							"anual" 		=> $k->anual,
							"trim1" 		=> $k->trim1,
							"trim2" 		=> $k->trim2,
							"trim3" 		=> $k->trim3,
							"trim4" 		=> $k->trim4,
							"porc1" 		=> $k->porc1,
							"porc2" 		=> $k->porc2,
							"porc3" 		=> $k->porc3,
							"porc4" 		=> $k->porc4,
						];
			}
		}
		return $this->getExportPbRMaa($data);
	}
	public function getExportarpbrmaanormal( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,c.idarea_coordinacion as idac,c.idproyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			foreach ($regs as $k) {
				$val =  \DB::select("SELECT r.codigo,r.meta,c.idarea_coordinacion,c.idproyecto FROM ui_proy_pbrm01c_reg r
inner join ui_proy_pbrm01c c on r.idproy_pbrm01c = r.idproy_pbrm01c
where c.idanio = 4 and c.idarea_coordinacion = {$v->idac}  and c.idproyecto = {$v->idproyecto} and  r.meta = '{$k->meta}' ");
				$data[] = ['loc_ben'		=> 0,//$k->loc_beneficiada
							'pob_ben'		=> 100,//$k->pob_beneficiada 
							'no_dep_gen'	=> $v->no_dep_gen, 
							"no_dep_aux" 	=> $v->no_dep_aux,
							"proy" 			=> "'".$v->no_proyecto,
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							"anual" 		=> $k->anual,
							"trim1" 		=> $k->trim1,
							"trim2" 		=> $k->trim2,
							"trim3" 		=> $k->trim3,
							"trim4" 		=> $k->trim4,
							"porc1" 		=> $k->porc1,
							"porc2" 		=> $k->porc2,
							"porc3" 		=> $k->porc3,
							"porc4" 		=> $k->porc4,
							"val" 		=> count($val) > 0 ? 'si' : 'no',
						];
			}
		}
		return $this->getExportPbRMaaNormal($data);
	}
	public function getMetas( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,c.idarea_coordinacion as idac,c.idproyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			foreach ($regs as $k) {
				$val =  \DB::select("SELECT r.codigo,r.meta,c.idarea_coordinacion,c.idproyecto,r.programado,r.alcanzado FROM ui_proy_pbrm01c_reg r
				inner join ui_proy_pbrm01c c on r.idproy_pbrm01c = r.idproy_pbrm01c
				where c.idanio = 4 and c.idarea_coordinacion = {$v->idac}  and c.idproyecto = {$v->idproyecto} and  r.meta = '{$k->meta}' ");

					$metas =  \DB::select("SELECT r.id_area_coordinacion as idac,r.idproyecto as idp,g.descripcion as meta FROM ui_reporte r 
				inner join ui_reporte_reg g on g.idreporte = r.idreporte
				where idanio = 4 and r.type = 0 and r.id_area_coordinacion = {$v->idac} and r.idproyecto = {$v->idproyecto} and g.descripcion = '{$k->meta}' ");

				$data[] = [
							"proy" 			=> $v->no_proyecto,
							'no_dep_gen'	=> $v->no_dep_gen, 
							'no_dep_aux'	=> $v->no_dep_aux, 
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							'prog_ant'		=> count($val) > 0 ? $val[0]->programado : 0,
							'real_ant'		=> count($val) > 0 ? $val[0]->alcanzado : 0,
							"t1" 			=> $k->trim1,
							"t2" 			=> $k->trim2,
							"t3" 			=> $k->trim3,
							"t4" 			=> $k->trim4,
							"val1" 			=> count($val) > 0 ? 1 : 0,
							"val2" 			=> count($metas) > 0 ? 1 : 0,
						];
			}
		}
		$response = ['status' => 'ok', 'rowsData' => $data];
		return response()->json($response);

		return $this->exportar->getExportarCalendarizacionMetasNew($data);
	}
	public function getExportarpbrmaanormalprogress( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,c.idarea_coordinacion as idac,c.idproyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			foreach ($regs as $k) {
				$val =  \DB::select("SELECT r.codigo,r.meta,c.idarea_coordinacion,c.idproyecto,r.programado,r.alcanzado FROM ui_proy_pbrm01c_reg r
				inner join ui_proy_pbrm01c c on r.idproy_pbrm01c = r.idproy_pbrm01c
				where c.idanio = 4 and c.idarea_coordinacion = {$v->idac}  and c.idproyecto = {$v->idproyecto} and  r.meta = '{$k->meta}' ");
				$data[] = [
							"proy" 			=> "'".$v->no_proyecto,
							'no_dep'	=> $v->no_dep_gen.$v->no_dep_aux, 
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							'pob_ben'		=> 100,//$k->pob_beneficiada 
							'prog_ant'		=> count($val) > 0 ? $val[0]->programado : 0,
							'real_ant'		=> count($val) > 0 ? $val[0]->alcanzado : 0,
							"trim1" 		=> $k->trim1,
							"trim2" 		=> $k->trim2,
							"trim3" 		=> $k->trim3,
							"trim4" 		=> $k->trim4,
							'loc_ben'		=> 0,//$k->loc_beneficiada
						
						];
			}
		}
		return $this->exportar->getExportarCalendarizacionMetasNew($data);
	}
	public function getExportarpbrmaaprogress( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			$ver =  \DB::select("SELECT idproy_pbrm02a FROM ui_proy_pbrm02a where idarea_coordinacion = {$v->idac} and idanio = 4 and idproyecto = {$v->idproyecto}");
			foreach ($regs as $k) {
				$data[] = ['loc_ben'		=> 0,//$k->loc_beneficiada
							'pob_ben'		=> 100,//$k->pob_beneficiada 
							'no_dep_gen'	=> $v->no_dep_gen, 
							"no_dep_aux" 	=> $v->no_dep_aux,
							"proy" 			=> "'".$v->no_proyecto,
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							"anual" 		=> $k->anual,
							"trim1" 		=> $k->trim1,
							"trim2" 		=> $k->trim2,
							"trim3" 		=> $k->trim3,
							"trim4" 		=> $k->trim4,
							"porc1" 		=> $k->porc1,
							"porc2" 		=> $k->porc2,
							"porc3" 		=> $k->porc3,
							"porc4" 		=> $k->porc4,
						];
			}
		}
		return $this->getExportPbRMaaProgress($data);
	}
	public function getExportarpbrme( Request $r ){
		$rows =  \DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto  FROM ui_proy_pbrm02a c
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
		where c.idanio = 4 AND a.idarea = 230 ORDER BY a.numero,ac.numero ASC");
		$data = [];
		foreach ($rows as $v) {
			$regs =  \DB::select("SELECT codigo,meta,unidad_medida,anual,trim1,trim2,trim3,trim4,porc1,porc2,porc3,porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a = {$v->id}");
			foreach ($regs as $k) {
				$partes = str_split($v->no_proyecto, 2);
				$data[] = ['loc_ben'		=> $k->loc_beneficiada,
							'pob_ben'		=> $k->pob_beneficiada, 
							'no_dep_gen'	=> $v->no_dep_gen, 
							"no_dep_aux" 	=> $v->no_dep_aux,
							"fin" 			=> "'".$partes[0],
							"fun" 			=> "'".$partes[1],
							"sub" 			=> "'".$partes[2],
							"prog" 			=> "'".$partes[3],
							"subp" 			=> "'".$partes[4],
							"proy" 			=> "'".$partes[5],
							"cod" 			=> $k->codigo,
							"meta" 			=> $k->meta,
							"um" 			=> $k->unidad_medida,
							"anual" 		=> $k->anual,
							"trim1" 		=> $k->trim1,
							"trim2" 		=> $k->trim2,
							"trim3" 		=> $k->trim3,
							"trim4" 		=> $k->trim4,
							"porc1" 		=> $k->porc1,
							"porc2" 		=> $k->porc2,
							"porc3" 		=> $k->porc3,
							"porc4" 		=> $k->porc4,
						];
			}
		}
		return $this->getExportPbRMaa($data);
	}
	public function getArpppdm( Request $r ){
		$rows =  \DB::select("SELECT ar.numero as no_dep_gen,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,a.total,pi.no_tipo as eje_cambio,pi.numero as no_eje,pi.pilares FROM ui_proy_pbrm01a a
inner join ui_area ar on ar.idarea = a.idarea
inner join ui_programa p on p.idprograma = a.idprograma
	left join  ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
where a.idanio = 4 order by ar.numero asc");
		return $this->getExportARPPPDM($rows);
	}
	public function getExportpmpdm( Request $r ){
		$rows =  \DB::select("SELECT pi.no_tipo as no_eje,pi.numero as eje_cambio,a.numero as no_dep_gen,ac.numero as no_dep_aux,pr.numero as no_programa,pr.descripcion as programa,py.codigo,py.meta,py.unidad_medida,py.anual  FROM ui_proy_pbrm02a c
	left join ui_proy_pbrm02a_reg py on py.idproy_pbrm02a = c.idproy_pbrm02a
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			left join ui_area a on a.idarea = ac.idarea
		left join ui_proyecto p on p.idproyecto = c.idproyecto
			left join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			left join ui_programa pr on pr.idprograma = sp.idprograma
			left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
		where c.idanio = 4 ORDER BY a.numero,ac.numero ASC");
		return $this->getExportNewPMPDM($rows);
	}
	public function getExportapdm( Request $r ){
		$rows =  \DB::select("SELECT pi.no_tipo as no_eje,pi.numero as eje_cambio,b.idproy_pbrm01b as id,a.numero as no_dep_gen,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,b.estrategias_objetivo,b.pdm,b.ods FROM ui_proy_pbrm01b b
		inner join ui_area a on a.idarea = b.idarea 
		inner join ui_programa p on p.idprograma = b.idprograma
         left join ui_pdm_pilares pi on p.idpdm_pilares = pi.idpdm_pilares
		where b.idanio = 4 order by a.numero asc");
		return $this->getExportNewAPDM($rows);
	}
	public function getExportPbRMa($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrma",$data);
		return self::getReturnExcelNew($c, "PbRMa.xls");
	}
	public function getExportARPPPDM($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.arpppdm",$data);
		return self::getReturnExcelNew($c, "ARPPPDM-2025.xls");
	}
	public function getExportPbRMdNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmd",$data);
		return self::getReturnExcelNew($c, "PbRM-01d.xls");
	}
	public function getExportPbRMeNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrme",$data);
		return self::getReturnExcelNew($c, "PbRM-01e.xls");
	}
	public function getExportNewAPDM($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.apdm",$data);
		return self::getReturnExcelNew($c, "APDM-2025.xls");
	}
	public function getExportNewPMPDM($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pmpdm",$data);
		return self::getReturnExcelNew($c, "PMPDM-2025.xls");
	}
	public function getExportPbRMaNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmanormal",$data);
		return self::getReturnExcelNew($c, "PbRMa.xls");
	}
	public function getExportPbRMbNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmbnormal",$data);
		return self::getReturnExcelNew($c, "PbRMb.xls");
	}
	public function getExportPbRMc($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmc",$data);
		return self::getReturnExcelNew($c, "PbRMc.xls");
	}
	public function getExportPbRMcNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmcnormal",$data);
		return self::getReturnExcelNew($c, "PbRMc.xls");
	}
	public function getExportPbRMaa($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmaa",$data);
		return self::getReturnExcelNew($c, "PbRM2a.xls");
	}
	public function getExportPbRMaaNormal($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.pbrmaanormal",$data);
		return self::getReturnExcelNew($c, "PbRM2a.xls");
	}
	public function getExportPbRMaaProgress($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pbrma.exportar.progress.pbrmc",$data);
		return self::getReturnExcelNew($c, "PbRM-2a.xls");
	}
	public function getReturnExcelNew($c=null, $name){
		@header('Content-Encoding: UTF-8');
		@header('Content-type: application/ms-excel; charset=UTF-8');
		@header('Content-Length: '.strlen($c));
		@header('Content-disposition: inline; filename="'.$name.'"');
		echo $c;
		exit;
	}

}