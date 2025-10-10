<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Avancepdm;
use App\Models\Access\Years;

use App\Services\GeneralService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use DB;

class AvancepdmController extends Controller {

	protected $data;	
	protected $model;	
	protected $info;	
	protected $access;	

	public $module = 'avancepdm';
	static $per_page	= '10';

	protected $generalService;
	
    const MODULE = 5;

	public function __construct(GeneralService $generalService)
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Avancepdm();
		$this->generalService = $generalService;
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'avancepdm',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function getIndex( Request $request )
	{
		$this->access = $this->model->validAccess($this->info['id']);
		if($this->access['is_view'] ==0){
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		return view('avancepdm.index',$this->data);
	}	
	public function getPrincipal( Request $request ){
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, Auth::user()->idinstituciones,$request->idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$this->data['year'] = $modulo[0]->anio;
		$this->data['idy'] 	= $request->idy;
		$this->data['trim'] = $request->t;
		return view('avancepdm.view',$this->data);
	}

	public function getProgramas(Request $r ){
		$this->data['rows'] = $this->getRowsInfoProgramas($r->idy,$r->trim);
		$this->data['j'] = 1;
		$this->data['trim'] = $r->trim;
		$this->data['idy'] = $r->idy;
		return view('avancepdm.search',$this->data);
	}
	/*public function getSincronizar( Request $r ){
		foreach ($this->model->getProgramaSincronizar($r->idy) as $v) {
			$data = ['idanio_module' => $r->idy, "idprograma" => $v->idprograma];
			$this->model->getInsertTable($data, "ui_reporte_programa");
		}
		$response = ["status" => "ok", "message" => "Programas sincronizados correctamente!"];
		return response()->json($response);
	}*/
	public function getPdf( Request $r ){
		$idy = $r->idy;
        $idi =  Auth::user()->idinstituciones;
		$modulo = Years::getModuleAccessByYearsID(self::MODULE, $idi, $idy);
		if(count($modulo) == 0){
			return Redirect::to('dashboard')->with('messagetext', 'No se encontro información!')->with('msgstatus','error');
		}
		$periodo = $this->model->getPeriodoAnio($idy);
		$this->data['periodo'] = $periodo[0]->periodo;
		$row = $this->model->getTitularesFirmas($idi,$idy);
		$this->data['header'] = $row[0];
		$this->data['anio'] = $modulo[0]->anio;
		$this->data['rows'] = $this->getRowsInfoProgramas($idy,$r->t);
		$mpdf = new \Mpdf\Mpdf(['format' => 'Letter',
								'margin_top' => 23,
								'margin_left' => 10,
								'margin_right' => 10,
								'margin_bottom' => 17,
								]);
		$mpdf->SetHTMLHeader(View::make($this->module.".pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make($this->module.".pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(View::make($this->module.".pdf.title", $this->data)->render());
		$mpdf->AddPage();
		$mpdf->WriteHTML(View::make($this->module.".pdf.body", $this->data)->render());
		return $mpdf->Output('Avance de programas PDM.pdf', 'I');
	}
	private function getRowsInfoProgramas($idy,$trim){
		$data = [];
        $idi =  Auth::user()->idinstituciones;
		foreach ($this->model->getProgramas($idy, $trim, $idi) as $v) {
			$row = $this->getRowsMetasReg($v->id, $trim);
			$info = [
						'id' => $v->id, 
						'idp' => $v->idprograma, 
						'no' => $v->no_programa, 
						'pro' => $v->programa, 
						'obj' => $v->obj_programa, 
						'meta' => $row['meta'], 
						'indicador' => $row['indicador'],
						'li' => $v->leyenda_indicador, 
						'lm' => $v->leyenda_meta 
					];
			if(!isset($data[$v->idpdm_pilares])){
				$data[$v->idpdm_pilares] = ['pilar' => $v->pilares,'info' => [$info] ];
			}else{
				$data[$v->idpdm_pilares]['info'][] = $info;
			}
		}
		return $data;	
	}
	public function getEdit( Request $r ){
		$this->data['idp'] = $r->idp;
		$this->data['idy'] = $r->idy;
		$this->data['trim'] = $r->trim;
		$this->data['id'] = $r->id;
		$this->data['rows'] = $this->getRowsMetas($r->idy, $r->idp,$r->trim);
		$row = $this->model->getProgramasID($r->id,$r->trim);
		$this->data['row'] = $row[0];
		$this->data['rowsReg'] = $this->getRowsMetasReg($r->id,$r->trim);
		return view('avancepdm.edit',$this->data);
	}
	private function getRowsMetasReg($id,$trim){
		$meta = [];
		$indicador = [];
		foreach ($this->model->getRegPrograma($id, $trim) as $v) {
			if($v->type == 0){
				$meta[] = ['id' => $v->id, 
						    'text' => $v->descripcion
						];
			}else{
				$indicador[] = ['id' => $v->id, 
						    'text' => $v->descripcion
						];
			}
			
		}
		return ['meta' => $meta, 'indicador' => $indicador];
	}
	private function getRowsMetas($idy, $idp,$t){
        $idi =  Auth::user()->idinstituciones;
		$meta = [];
		$indicador = [];
		$trim = "trim_".$t;
		$cant = "cant_".$t;
		$por = "por_".$t;
		foreach ($this->model->getMetasPrograma($idy, $idp, $idi) as $v) {
			if($v->type == 0){
				$meta[] = ['meta' => $v->meta, 
						"pa" => $v->prog_anual, 
						'trim' => $v->$trim,
						'cant' => $v->$cant,
						'por' => $v->$por,
					];
			}else{
				$indicador[] = ['meta' => $v->meta, 
						"pa" => $v->prog_anual, 
						'trim' => $v->$trim,
						'cant' => $v->$cant,
						'por' => $v->$por,
					];
			}
			
		}
		return ['meta' => $meta, 'indicador' => $indicador];
	}
	public function getAddtrindi( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('avancepdm.trindi',$this->data);	
	}
	public function getAddtrmeta( Request $r)
	{
		$this->data['time'] = rand(3,100).time();
		return view('avancepdm.trmeta',$this->data);	
	}
	function deleteRegistro( Request $r)
	{
		try {
			DB::transaction(function () use ($r) {
				$this->model->getDestroyTable("ui_reporte_programa_reg", "idreporte_programa_reg", $r->id);
			});
			$response = ["status" => "ok", "message" => "Información eliminada correctamente!"];
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al eliminar!"];
		}
		return response()->json($response);
	}
	function postSave( Request $r)
	{
		try {
			DB::transaction(function () use ($r) {
				$trim = $r->trim;
				$arrProg = ['li_'.$trim => (isset($r->checkindicador) ? 1 : 0), 'lm_'.$trim => (isset($r->checkmeta) ? 1 : 0)];
				$this->model->getUpdateTable($arrProg, "ui_reporte_programa", "idreporte_programa", $r->id);

				for ($i=0; $i < count($r->indicador); $i++) { 
					if(!empty($r->indicador[$i])){
						$dataInd = ['idreporte_programa' => $r->id, 'trim' => $trim, 'type' => 1,'descripcion' => $r->indicador[$i]];
						$this->model->getInsertTable($dataInd, "ui_reporte_programa_reg");
					}
				}
				for ($i=0; $i < count($r->meta); $i++) { 
					if(!empty($r->meta[$i])){
						$dataMeta = ['idreporte_programa' => $r->id, 'trim' => $trim, 'type' => 0,'descripcion' => $r->meta[$i]];
						$this->model->getInsertTable($dataMeta, "ui_reporte_programa_reg");
					}
				}

				for ($i=0; $i < count($r->indicador_edit); $i++) { 
					$dataEIndi = ['descripcion' => $r->indicador_edit[$i]];
					$this->model->getUpdateTable($dataEIndi, "ui_reporte_programa_reg","idreporte_programa_reg",$r->idindicador_edit[$i]);
				}
				for ($i=0; $i < count($r->meta_edit); $i++) { 
					$dataEMeta = ['descripcion' => $r->meta_edit[$i]];
					$this->model->getUpdateTable($dataEMeta, "ui_reporte_programa_reg","idreporte_programa_reg",$r->idmeta_edit[$i]);
				}

			});
			$response = ["status" => "ok", "message" => "Información guardada correctamente."];
		} catch (\Exception $e) {
			\SiteHelpers::auditTrail( $r , "Error: " . $e->getMessage());
			$response = ["status" => "error", "message" => "Error al guardar la información!"];
		}
		return response()->json($response);
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('id'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('avancepdm')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('avancepdm')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}			


}