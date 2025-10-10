<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Presupuestopbrmc;
use App\Models\Presupuestopbrmaa;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, SiteHelpers ; 
use Illuminate\Support\Facades\View;

class PresupuestopbrmcController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'presupuestopbrmc';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Presupuestopbrmc();
		$this->prespbrmaa = new Presupuestopbrmaa();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'presupuestopbrmc',
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
		return view('presupuestopbrmc.index',$this->data);
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
			$rows = $this->getRowsAreasAdmin($this->data['idi'], $request->idy);//(type,idinstitucion)
		}else{
			$rows = $this->getRowsAreasEnlace($this->data['idi'], $request->idy);
		}
		$this->data['rowData'] = json_encode($rows);
		return view('presupuestopbrmc.principal',$this->data);
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
	}
	public function getProyectos( Request $request )
	{
		$decoder = SiteHelpers::CF_decode_json($request->k);
		if($decoder){
			$this->data['ida'] = $decoder['ida'];//idarea
			$this->data['idi'] = $decoder['idi'];//idinstitucion
			$this->data['idac'] = $decoder['idac'];//idarea_coordinacion
			$this->data['idy'] = $request->idy;
			$this->data['year'] = $request->year;
			$this->data['token'] = $request->k;
			$row = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['row'] = $row[0];
			if($request->year >= "2025"){
				return view('presupuestopbrma.proyectos.index',$this->data);
			}else{
				return view('presupuestopbrmc.anio',$this->data);
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

			$data = $this->getRowsProyectos($decoder['idac'],$r->idyear);
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
	private function getRowsProyectos($idac, $idanio){
		$data = array();
		$total = 0;
		$contador = 0;
		foreach ($this->model->getProyectosAnio($idac, $idanio) as $v) {
			$contador++;
			$rowsProyectos = array("id"=>SiteHelpers::CF_encode_json(array('time'=>time(),'id'=>$v->id)) , 
							"no_proyecto"=>$v->no_proyecto,
							"proyecto"=>$v->proyecto,
							"url"=>(empty($v->url) ? "NO" : "PDF"),
							"total"=> number_format($v->total,2),
							"estatus"=>$v->aa_estatus,
							"color"=> ($v->total > 0 ? 'c-black' : 'c-danger'),
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
		$pres = 0.00;
		return array("data" 		=> $data, 
					"contador" 		=> $contador,
					"total_pres"	=> 0, 
					"total_uippe" 	=> number_format($total,2),
					"total_resta"	=> number_format($pres - $total,2) 
				);
	}
	public function getAdd( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->k);
		if($decoder){
			$this->data['token'] = $r->k;

			$this->data['anio'] = $r->anio;
			$this->data['idanio'] = $r->idanio;
			//Obtengo todos los proyectos registrados
			$this->data['rows_projects'] = $this->model->getProyectosAll();
			//Obtengo el nombre de la dependencia general y auxiliar
			$proy = $this->model->getAreaCoordinacion($decoder['idac']);
			$this->data['proy'] = $proy[0];
			return view('presupuestopbrmc.add',$this->data);
		}
	}
	public function getAddtr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('presupuestopbrmc.tr',$this->data);	
	}
	function postSave( Request $r)
	{
		try {
			//Decoder del key
			$decoder = SiteHelpers::CF_decode_json($r->k);
			if($decoder){
				$data = array("idarea_coordinacion"=>$decoder['idac'],
								"idanio"=>$r->idanio,
								"idproyecto"=>$r->idp,
								"total"=>$this->getClearNumber($r->total),
								"fecha_rg"=>date('Y-m-d'),
								"hora_rg"=>date('H:i:s A'),
								"std_delete"=>1,
							);
				$id = $this->model->insertRow($data,0);
				for ($i=0; $i < count($r->idag); $i++) { 
					$arr = array("idpres_pbrm01c"=>$id,
								"codigo"=>$r->numero[$i],
								"meta"=>$r->desc[$i],
								"unidad_medida"=>$r->medida[$i],
								"programado"=>$r->programado[$i],
								"alcanzado"=>$r->alcanzado[$i],
								"anual"=>$r->anual[$i],
								"absoluta"=>$r->absoluta[$i],
								"porcentaje"=>$r->porcentaje[$i],
							);
					$this->model->getInsertTable($arr,"ui_pres_pbrm01c_reg");
				}
				$response = "ok";
			}
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar presupuesto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}	
	public function getDestroytr( Request $r)
	{
		$this->model->getDestroyTable("ui_pres_pbrm01c_reg","idpres_pbrm01c_reg",$r->id);
		return json_encode(array("success"=>"ok"));
	}
	public function getEdit( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->data['token'] = $r->key;

			$proy = $this->prespbrmaa->getPbrmaa($decoder['id']);
			$this->data['proy'] = $proy[0];
			//Registros
			$this->data['registros'] = $this->model->getProyectosPbrmc($decoder['id']);
			return view('presupuestopbrmc.edit',$this->data);
		}
	}
	function postEdit( Request $r)
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			try {
				//$data = array("total"=>$this->getClearNumber($r->total));
				//$id = $this->model->insertRow($data,$decoder['id']);
				
				for ($i=0; $i < count($r->idag); $i++) { 
					$arr = array("idpres_pbrm01c"	=> $decoder['id'],
								"codigo"			=> $r->numero[$i],
								"meta"				=> $r->desc[$i],
								"unidad_medida"		=> $r->medida[$i],
								"programado"		=> $r->programado[$i],
								"alcanzado"			=> $r->alcanzado[$i],
								"anual"				=> $r->anual[$i],
								"absoluta"			=> $r->absoluta[$i],
								"porcentaje"		=> $r->porcentaje[$i]
							);
					if($r->idag[$i] == "0"){
						$this->model->getInsertTable($arr,"ui_pres_pbrm01c_reg");
					}else{
						$this->model->getUpdateTable($arr,"ui_pres_pbrm01c_reg","idpres_pbrm01c_reg",$r->idag[$i]);
					}
				}
				$response = "ok";
			} catch (\Exception $e) {
				\SiteHelpers::auditTrail( $r , 'Error al registrar presupuestos!');
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
			$nombreArchivo = date('d-m-Y') . " Presupuesto Definitivo PbRM-01c.pdf";
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
			$proy = $this->prespbrmaa->getPbrmaa($decoder['id']);
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
			$proy=$this->prespbrmaa->getPbrmaa($decoder['id']);
			$this->data['proy'] = $proy[0];
			//Valores que se llenan en la caja de texto
			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			//Cargos
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['te_c'] = $r->te_c;//Tesorero
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			$directory = "archivos/{$proy[0]->no_municipio}/presupuesto/pbrma01c/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.

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
				\SiteHelpers::auditTrail( $r , 'Error al eliminar, '.$e->getMessage());
			}
			$this->model->insertRow(array("url"=>null),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
	public function deleteDestroy( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$this->model->insertRow(array('std_delete'=>2),$decoder['id']);
			$response = array("success"=>"ok");
		}else{
			\SiteHelpers::auditTrail( $r , 'Error al eliminar');
			$response = array("success"=>"no");
		}
		return json_encode($response);
	}
}