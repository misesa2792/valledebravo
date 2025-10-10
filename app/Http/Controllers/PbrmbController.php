<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Pbrmb;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect,SiteHelpers ; 
use Illuminate\Support\Facades\View;

class PbrmbController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'pbrmb';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Pbrmb();
		
		$this->info = $this->model->makeInfoSesmas( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'pbrmb',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$this->data['rowsAnios'] = $this->model->getModuleYears();
		return view('pbrmb.index',$this->data);
	}	
	public function getAddfodatr( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		$this->data['num'] = $r->num;
		return view('pbrmb.foda.tr',$this->data);	
	}
	public function getPrincipal( Request $request )
	{
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
		return view('pbrmb.principal',$this->data);
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
		return view('pbrmb.anio',$this->data);
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
		return view('pbrmb.search',$this->data);
	}
	public function getAdd( Request $r )
	{
		$this->data['programas'] = $this->model->getProgramas();
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['idanio'] = $r->idanio;
		return view('pbrmb.add',$this->data);
	}
	function postSave( Request $r)
	{
		try {
			$data = array("idarea"=>$r->idarea,
							"idanio"=>$r->idanio,
							"idprograma"=>$r->idprograma,
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>date('H:i:s A'),
							"foda"=>$r->foda,
							"objetivo_programa"=>$r->objetivo_programa,
							"pdm"=>$r->pdm,
							"estrategias_objetivo"=>$r->estrategias_objetivo,
							"ods"=>$r->ods,
						);
			$id = $this->model->insertRow($data,0);

			//Nuevos registros
			if(isset($r->idfoda1)){
				for ($i=0; $i < count($r->idfoda1); $i++) { 
					if(!empty($r->foda1[$i])){
						$this->getInsertFoda($id, 1, $r->foda1[$i]);
					}
				}
			}
			if(isset($r->idfoda2)){
				for ($i=0; $i < count($r->idfoda2); $i++) { 
					if(!empty($r->foda2[$i])){
						$this->getInsertFoda($id, 2, $r->foda2[$i]);
					}
				}
			}
			if(isset($r->idfoda3)){
				for ($i=0; $i < count($r->idfoda3); $i++) { 
					if(!empty($r->foda3[$i])){
						$this->getInsertFoda($id, 3, $r->foda3[$i]);
					}
				}
			}
			if(isset($r->idfoda4)){
				for ($i=0; $i < count($r->idfoda4); $i++) { 
					if(!empty($r->foda4[$i])){
						$this->getInsertFoda($id, 4, $r->foda4[$i]);
					}
				}
			}

			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail($r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	private function getInsertFoda($id,$type, $desc){
		$data = array("idap_pbrm01b"=>$id, 
						"type"=>$type,
						"descripcion"=>$desc,
					);
		$this->model->getInsertTable($data,"ui_ap_pbrm01b_foda");	
	}
	public function getEdit( Request $r )
	{
		$row = $this->model->getPbrmb($r->id);
		$this->data['programas'] = $row[0];
		$this->data['depgen'] = $this->model->getCatDepGen($r->idarea);
		$this->data['auxiliares'] = $this->model->getDepAuxiliares($r->idarea);
		$this->data['idarea'] = $r->idarea;
		$this->data['anio'] = $r->anio;
		$this->data['id'] = $r->id;
		//FODA
		$this->data['foda1'] = $this->model->getPbrmbFoda($r->id, 1); 
		$this->data['foda2'] = $this->model->getPbrmbFoda($r->id, 2); 
		$this->data['foda3'] = $this->model->getPbrmbFoda($r->id, 3); 
		$this->data['foda4'] = $this->model->getPbrmbFoda($r->id, 4); 
		return view('pbrmb.edit',$this->data);
	}
	function getEliminarfodatr(Request $r){
		$this->model->getDestroyTable("ui_ap_pbrm01b_foda","idap_pbrm01b_foda",$r->id);
		$response = array("success"=>"ok");
		return json_encode($response);
	}
	function postEdit( Request $r)
	{
		try {
			$data = array(
							"fecha_rg"=>date('Y-m-d'),
							"hora_rg"=>date('H:i:s A'),
							"foda"=>$r->foda,
							"objetivo_programa"=>$r->objetivo_programa,
							"pdm"=>$r->pdm,
							"estrategias_objetivo"=>$r->estrategias_objetivo,
							"ods"=>$r->ods,
						);
			$id = $this->model->insertRow($data, $r->id);

			//Nuevos registros
			if(isset($r->idfoda1)){
				for ($i=0; $i < count($r->idfoda1); $i++) { 
					if(!empty($r->foda1[$i])){
						$this->getInsertFoda($id, 1, $r->foda1[$i]);
					}
				}
			}
			if(isset($r->idfoda2)){
				for ($i=0; $i < count($r->idfoda2); $i++) { 
					if(!empty($r->foda2[$i])){
						$this->getInsertFoda($id, 2, $r->foda2[$i]);
					}
				}
			}
			if(isset($r->idfoda3)){
				for ($i=0; $i < count($r->idfoda3); $i++) { 
					if(!empty($r->foda3[$i])){
						$this->getInsertFoda($id, 3, $r->foda3[$i]);
					}
				}
			}
			if(isset($r->idfoda4)){
				for ($i=0; $i < count($r->idfoda4); $i++) { 
					if(!empty($r->foda4[$i])){
						$this->getInsertFoda($id, 4, $r->foda4[$i]);
					}
				}
			}
			//Update rows
			if(isset($r->id1)){
				for ($i=0; $i < count($r->id1); $i++) { 
					if(!empty($r->desc1[$i])){
						$this->getUpdateFoda($r->id1[$i], 1, $r->desc1[$i]);
					}
				}
			}
			if(isset($r->id2)){
				for ($i=0; $i < count($r->id2); $i++) { 
					if(!empty($r->desc2[$i])){
						$this->getUpdateFoda($r->id2[$i], 2, $r->desc2[$i]);
					}
				}
			}
			if(isset($r->id3)){
				for ($i=0; $i < count($r->id3); $i++) { 
					if(!empty($r->desc3[$i])){
						$this->getUpdateFoda($r->id3[$i], 3, $r->desc3[$i]);
					}
				}
			}
			if(isset($r->id4)){
				for ($i=0; $i < count($r->id4); $i++) { 
					if(!empty($r->desc4[$i])){
						$this->getUpdateFoda($r->id4[$i], 4, $r->desc4[$i]);
					}
				}
			}

			$response = "ok";
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , 'Error al registrar anteproyecto!');
			$response = "no";
		}
		return json_encode(array("success"=>$response));
	}
	private function getUpdateFoda($id,$type, $desc){
		$data = array("descripcion"=>$desc);
		$this->model->getUpdateTable($data,"ui_ap_pbrm01b_foda","idap_pbrm01b_foda",$id);	
	}
	public function getPdf( Request $r )
	{
		//Decoder del key
		$decoder = SiteHelpers::CF_decode_json($r->key);
		$this->data['token'] = $r->key;

		$proy = $this->model->getPbrmb($decoder['id']);
		$this->data['proy'] = $proy[0];

		$this->data['foda1'] = $this->model->getPbrmbFoda($decoder['id'],1); 
		$this->data['foda2'] = $this->model->getPbrmbFoda($decoder['id'],2); 
		$this->data['foda3'] = $this->model->getPbrmbFoda($decoder['id'],3); 
		$this->data['foda4'] = $this->model->getPbrmbFoda($decoder['id'],4); 
		return view('templates.presupuesto.pbrmb.view',$this->data);
		//return view('pbrmb.pdf.view',$this->data);
	}
	public function getGenerarpdf( Request $r )
	{
		$decoder = SiteHelpers::CF_decode_json($r->key);
		if($decoder){
			$proy=$this->model->getPbrmb($decoder['id']);
			$this->data['proy'] = $proy[0];

			$this->data['txt_titular_dep'] = $r->txt_titular_dep;
			$this->data['txt_tesorero'] = $r->txt_tesorero;
			$this->data['txt_titular_uippe'] = $r->txt_titular_uippe;
			$this->data['ti_c'] = $r->ti_c;//Titular Dep_Gen
			$this->data['te_c'] = $r->te_c;//Tesorero
			$this->data['ui_c'] = $r->ui_c;//UIPPE

			$this->data['foda1'] = $this->model->getPbrmbFoda($decoder['id'],1); 
			$this->data['foda2'] = $this->model->getPbrmbFoda($decoder['id'],2); 
			$this->data['foda3'] = $this->model->getPbrmbFoda($decoder['id'],3); 
			$this->data['foda4'] = $this->model->getPbrmbFoda($decoder['id'],4); 

			$directory = "archivos/{$proy[0]->no_municipio}/anteproyectos/pbrma01b/{$proy[0]->anio}/{$decoder['id']}";
			$folder = public_path($directory);
			$this->getCreateDirectoryGeneral($folder);//Create directory if not exist.

			$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L',
			'margin_top' => 30,
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_bottom' => 35,]);

			
			/*
			* 2024-01-07, nueva manera de generar PDF, en esta forma ya no se enciman los textos.
			* Si solo se requiere un solo footer, solo dejarlo abajo del PDF
			*/

			// Establece el encabezado y pie de página
			$mpdf->SetHTMLHeader(View::make("templates.presupuesto.pbrmb.pdf_header", $this->data)->render());
			$mpdf->WriteHTML(view('templates.presupuesto.pbrmb.pdf_body',$this->data));
			$mpdf->SetHTMLFooter(View::make("templates.presupuesto.pbrmb.pdf_footer", $this->data)->render());
			$time = time();
			$filename = '/'.$decoder['id']."_ ".$time.'.pdf';
			$url = $folder.$filename;

			$mpdf->Output($url, 'F');//Save PDF in directory
			
			$this->model->insertRow(array("url"=> $directory.$filename), $decoder['id']);

			$response = array("success"=>"ok","k"=>$r->key);
			return json_encode($response);
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
			$nombreArchivo = date('d-m-Y') . " Anteproyecto PbRM-01b.pdf";
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
	public function getDestroy( Request $r )
	{
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