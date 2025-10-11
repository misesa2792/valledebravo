<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Services\Poa\PoaService;
use App\Services\Poa\PbrmaService;
use App\Services\Poa\PbrmcService;
use App\Services\Poa\PbrmaaService;
use App\Services\Poa\PbrmbService;
use App\Services\Poa\PbrmeService;
use App\Services\Poa\PbrmdService;
use App\Services\Poa\PlanService;

use Illuminate\Http\Request;

class AnteproyectoController extends Controller
{
	protected $poaservice;	
	protected $pbrmaservice;	
	protected $pbrmcservice;	
	protected $pbrmaaservice;	
	protected $pbrmbservice;	
	protected $pbrmeservice;	
	protected $pbrmdservice;	
	protected $planservice;	

	const MODULE = 4;

	public function __construct(PoaService $poaservice, 
								PbrmaService $pbrmaservice,
								PbrmcService $pbrmcservice,
								PbrmaaService $pbrmaaservice,
								PbrmbService $pbrmbservice,
								PbrmeService $pbrmeservice,
								PbrmdService $pbrmdservice,
								PlanService $planservice
								)
	{
		$this->poaservice = $poaservice;
		$this->pbrmaservice = $pbrmaservice;
		$this->pbrmcservice = $pbrmcservice;
		$this->pbrmaaservice = $pbrmaaservice;
		$this->pbrmbservice = $pbrmbservice;
		$this->pbrmeservice = $pbrmeservice;
		$this->pbrmdservice = $pbrmdservice;
		$this->planservice = $planservice;
	}

	public function getIndex()
	{
		return $this->poaservice->index('PA',self::MODULE);
	}
	public function getDependencias(Request $request)
	{
		return $this->poaservice->dependencias($request);
	}	
	public function getGeneral(Request $request)
	{
		return $this->poaservice->general($request);
	}
	public function getPoa(Request $request)
	{
		return $this->poaservice->poa($request);
	}
	public function getAddum(Request $request)
	{
		return $this->poaservice->unidadmedida($request);
	}
	public function postUnidadmedida(Request $request)
	{
		return $this->poaservice->saveum($request);
	}

		public function getSearcha(Request $request)
		{
			return $this->pbrmaservice->searchGeneral($request);
		}
		public function getSearchc(Request $request)
		{
			return $this->pbrmcservice->searchGeneral($request);
		}
		public function getSearchaa(Request $request)
		{
			return $this->pbrmaaservice->searchGeneral($request);
		}
		public function getSearchb(Request $request)
		{
			return $this->pbrmbservice->searchGeneral($request);
		}
		public function getSearche(Request $request)
		{
			return $this->pbrmeservice->searchGeneral($request);
		}
	//Planeación
		public function getSearcharppdm(Request $request)
		{
			return $this->planservice->searcharppdm($request);
		}
		public function getSearchpmpdm(Request $request)
		{
			return $this->planservice->searchpmpdm($request);
		}


		//Checar para eliminar las funciones
		public function getAddpprograma(Request $request)
		{
			return $this->planservice->store($request);
		}
		public function postSaveplan( Request $request )
		{
			return $this->planservice->save($request);
		}
		public function getSearchplan( Request $request )
		{
			return $this->planservice->search($request);
		}	
		public function deletePlan( Request $request )
		{
			return $this->planservice->delete($request);
		}
		public function getAddarpppdm(Request $request)
		{
			return $this->planservice->arpppdm($request);
		}
		public function postUpdatearpppdm(Request $request)
		{
			return $this->planservice->updatearpppdm($request);
		}
		public function getAddpmpdm(Request $request)
		{
			return $this->planservice->pmpdm($request);
		}
		public function getAddtrpmpdm(Request $request)
		{
			return $this->planservice->trpmpdm($request);
		}
		public function postSavepmpdm(Request $request)
		{
			return $this->planservice->savepmpdm($request);
		}
		public function deleteTrpmpdm( Request $request )
		{
			return $this->planservice->deletepmpdm($request);
		}
		public function getAddappdm(Request $request)
		{
			return $this->planservice->appdm($request);
		}
		public function postUpdateappdm(Request $request)
		{
			return $this->planservice->updateappdm($request);
		}
		public function getAddtrappdm(Request $request)
		{
			return $this->planservice->trappdm($request);
		}
		
	//PbRM-01a
		public function getAddpbrma(Request $request)
		{
			return $this->pbrmaservice->store($request);
		}
		public function getEditpbrma(Request $request)
		{
			return $this->pbrmaservice->edit($request);
		}		
		public function getPrograma( Request $request )
		{
			return $this->pbrmaservice->programas($request);
		}
		public function getAddpbrmatr( Request $request )
		{
			return $this->pbrmaservice->tr($request);
		}
		public function deletePbrmatr( Request $request )
		{
			return $this->pbrmaservice->deletetr($request);
		}
		public function postSavepbrma( Request $request )
		{
			return $this->pbrmaservice->save($request);
		}
		public function postUpdatepbrma( Request $request )
		{
			return $this->pbrmaservice->update($request);
		}
		public function getSearchpbrma( Request $request )
		{
			return $this->pbrmaservice->search($request);
		}	
		public function getGeneratepbrma(Request $request)
		{
			return $this->pbrmaservice->generate($request);
		}
		public function postPdfpbrma(Request $request)
		{
			return $this->pbrmaservice->pdf($request);
		}	
		public function postReversepbrma(Request $request)
		{
			return $this->pbrmaservice->reverse($request);
		}
		public function deletePbrma(Request $request)
		{
			return $this->pbrmaservice->delete($request);
		}		
				
	//PbRM-01c
		public function getSearchpbrmc( Request $request )
		{
			return $this->pbrmcservice->search($request);
		}
		public function getAddpbrmc(Request $request)
		{
			return $this->pbrmcservice->store($request);
		}
		public function getAddpbrmctr( Request $request )
		{
			return $this->pbrmcservice->tr($request);
		}
		public function postSavepbrmc( Request $request )
		{
			return $this->pbrmcservice->save($request);
		}
		public function deletePbrmctr( Request $request )
		{
			return $this->pbrmcservice->deletetr($request);
		}
		public function getGeneratepbrmc(Request $request)
		{
			return $this->pbrmcservice->generate($request);
		}
		public function postPdfpbrmc(Request $request)
		{
			return $this->pbrmcservice->pdf($request);
		}
		public function postReversepbrmc(Request $request)
		{
			return $this->pbrmcservice->reverse($request);
		}	
	//PbRM-02a
		public function getSearchpbrmaa( Request $request )
		{
			return $this->pbrmaaservice->search($request);
		}	
		public function getAddpbrmaa(Request $request)
		{
			return $this->pbrmaaservice->store($request);
		}
		public function postSavepbrmaa( Request $request )
		{
			return $this->pbrmaaservice->save($request);
		}
		public function getGeneratepbrmaa(Request $request)
		{
			return $this->pbrmaaservice->generate($request);
		}
		public function postPdfpbrmaa(Request $request)
		{
			return $this->pbrmaaservice->pdf($request);
		}
		public function postReversepbrmaa(Request $request)
		{
			return $this->pbrmaaservice->reverse($request);
		}	
	//PbRM-01b
		public function getAddpbrmb(Request $request)
		{
			return $this->pbrmbservice->store($request);
		}
		public function getAddpbrmbtr( Request $request )
		{
			return $this->pbrmbservice->tr($request);
		}
		public function postSavepbrmb( Request $request )
		{
			return $this->pbrmbservice->save($request);
		}
		public function getSearchpbrmb( Request $request )
		{
			return $this->pbrmbservice->search($request);
		}
		public function getGeneratepbrmb(Request $request)
		{
			return $this->pbrmbservice->generate($request);
		}	
		public function postPdfpbrmb(Request $request)
		{
			return $this->pbrmbservice->pdf($request);
		}
		public function postReversepbrmb(Request $request)
		{
			return $this->pbrmbservice->reverse($request);
		}
		public function deletePbrmb(Request $request)
		{
			return $this->pbrmbservice->delete($request);
		}
		public function getEditpbrmb(Request $request)
		{
			return $this->pbrmbservice->edit($request);
		}
		public function postUpdatepbrmb( Request $request )
		{
			return $this->pbrmbservice->update($request);
		}
	//PbRM-01e
		public function getAddpbrme(Request $request)
		{
			return $this->pbrmeservice->store($request);
		}
		public function postSavepbrme( Request $request )
		{
			return $this->pbrmeservice->save($request);
		}
		public function getMatriz( Request $request )
		{
			return $this->pbrmeservice->matriz($request);
		}
		public function getEditmatriz( Request $request )
		{
			return $this->pbrmeservice->editmatriz($request);
		}
		public function getSearchpbrme( Request $request )
		{
			return $this->pbrmeservice->search($request);
		}	
		public function deletePbrme(Request $request)
		{
			return $this->pbrmeservice->delete($request);
		}
		public function getGeneratepbrme(Request $request)
		{
			return $this->pbrmeservice->generate($request);
		}
		public function postPdfpbrme(Request $request)
		{
			return $this->pbrmeservice->pdf($request);
		}
		public function postReversepbrme(Request $request)
		{
			return $this->pbrmeservice->reverse($request);
		}
		public function getEditpbrme(Request $request)
		{
			return $this->pbrmeservice->edit($request);
		}
		public function postEditarpbrme(Request $request)
		{
			return $this->pbrmeservice->editar($request);
		}
	//PbRM-01d
		public function getSearchpbrmd( Request $request )
		{
			return $this->pbrmdservice->search($request);
		}
		public function getAddpbrmd(Request $request)
		{
			return $this->pbrmdservice->store($request);
		}
		public function getAddpbrmdproy(Request $request)
		{
			return $this->pbrmdservice->viewProyecto($request);
		}
		public function postSavepbrmd( Request $request )
		{
			return $this->pbrmdservice->save($request);
		}
		public function postSaveproy( Request $request )
		{
			return $this->pbrmdservice->saveProy($request);
		}
		public function getGeneratepbrmd(Request $request)
		{
			return $this->pbrmdservice->generate($request);
		}
		public function postPdfpbrmd(Request $request)
		{
			return $this->pbrmdservice->pdf($request);
		}
		public function postReversepbrmd(Request $request)
		{
			return $this->pbrmdservice->reverse($request);
		}
		public function getMovepbrmd(Request $request)
		{
			return $this->pbrmdservice->move($request);
		}
		public function postMovepbrmd(Request $request)
		{
			return $this->pbrmdservice->moveSave($request);
		}
		public function deleteIndicador(Request $request)
		{
			return $this->pbrmdservice->deleteIndicador($request);
		}
	
	public function getPermisos(Request $request)
	{
		return $this->poaservice->permisos($request);
	}
	public function postSavepermisos(Request $request)
	{
		return $this->poaservice->savepermisos($request);
	}
	/*public function getEliminarmuestras(){
		$rows = \DB::select("SELECT idreporte FROM ui_reporte where idinstituciones = 1");
		foreach ($rows as $key => $v) {
			foreach (\DB::select("SELECT idreporte_reg FROM ui_reporte_reg where idreporte = {$v->idreporte} ") as $k) {
				\DB::table('ui_reporte_reg')->where('idreporte_reg', $k->idreporte_reg)->delete();
			}
			\DB::table('ui_reporte')->where('idreporte', $v->idreporte)->delete();
		}
		dd("ok");
	}*/
	
	/*public function getAsignarprograma()
	{
		$rows = \DB::select("SELECT * FROM ui_pd_pbrme");
		foreach($rows as $r){
			$row = \DB::select("SELECT p.*,sp.idprograma FROM ui_proyecto p
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			where p.idproyecto = ?", [$r->idproyecto]);

			$area = \DB::select("SELECT idarea FROM ui_area_coordinacion where idarea_coordinacion = ?", [$r->idarea_coordinacion]);
			\DB::table('ui_pd_pbrme')
			->where('idpd_pbrme', $r->idpd_pbrme)
			->update([
				'idprograma' => $row[0]->idprograma,
				'idarea'     => $area[0]->idarea,
			]);
		}


		$pbrme = \DB::select("SELECT m.idpd_pbrme_matriz,e.idarea_coordinacion,e.idproyecto FROM ui_pd_pbrme_matriz m
			inner join ui_pd_pbrme e on m.idpd_pbrme = e.idpd_pbrme");
		foreach($pbrme as $r){
			\DB::table('ui_pd_pbrme_matriz')
				->where('idpd_pbrme_matriz', $r->idpd_pbrme_matriz)
				->update([
					'idarea_coordinacion' => $r->idarea_coordinacion,
					'idproyecto'          => $r->idproyecto,
				]);
		}
			
		dd("ok");
	}
	public function getMigrare(){
		foreach(\DB::select("SELECT idpd_pbrme as id FROM ui_pd_pbrme where std_delete = 1") as $r){
			$this->getInsertIndicadores($r->id);
		}
		return "ok";
	}
	private function getInsertIndicadores($id){
		foreach (\DB::select("SELECT idprograma_reg FROM ui_pd_pbrme_matriz where idpd_pbrme = {$id}") as  $v) {
			\DB::table('ui_pd_pbrme_reg')->insertGetId(['idpd_pbrme' => $id, 'idprograma_reg' => $v->idprograma_reg]);
		}
	}
	//Elimino los registros
	public function getDeletepbrme(){
		foreach(\DB::select("SELECT idpd_pbrme as id FROM ui_pd_pbrme where std_delete = 2") as $r){
			$this->getDeleteIndicadores($r->id);
			\DB::table('ui_pd_pbrme')->where('idpd_pbrme', $r->id)->delete();
		}
		return "ok";
	}
	private function getDeleteIndicadores($id){
		foreach(\DB::select("SELECT idpd_pbrme_matriz as id FROM ui_pd_pbrme_matriz where idpd_pbrme = {$id}") as $r){
			$this->getDeleteRegistro($r->id);
			\DB::table('ui_pd_pbrme_matriz')->where('idpd_pbrme_matriz', $r->id)->delete();
		}
	}
	private function getDeleteRegistro($id){
		foreach(\DB::select("SELECT idpd_pbrme_indicador as id FROM ui_pd_pbrme_indicador where idpd_pbrme_matriz = {$id}") as $r){
			\DB::table('ui_pd_pbrme_indicador')->where('idpd_pbrme_indicador', $r->id)->delete();
		}
	}
	//fin Elimino los registros
	public function getAsignarid(){
		foreach(\DB::select("SELECT * FROM ui_pd_pbrme_indicador where idind_estrategicos_reg = 0") as $r){

			$row = \DB::select("SELECT m.idpd_pbrme_matriz,pr.idind_estrategicos,g.nombre_corto,g.idind_estrategicos_reg FROM ui_pd_pbrme_matriz m
				inner join ui_programa_reg pr on pr.idprograma_reg = m.idprograma_reg
					inner join ui_ind_estrategicos_reg g on g.idind_estrategicos = pr.idind_estrategicos
				where m.idpd_pbrme_matriz = {$r->idpd_pbrme_matriz} and g.nombre_corto = '".$r->nombre_corto."'"); 
			if(count($row) == 0){
				dd("Error en el registro: ".$r);
			}else{
				\DB::table('ui_pd_pbrme_indicador')
					->where('idpd_pbrme_indicador', $r->idpd_pbrme_indicador)
					->update([
						'idind_estrategicos_reg' => $row[0]->idind_estrategicos_reg,
					]);
			}

		}
		return "ok";
	}*/
	/*public function getInsertindicador()
	{
		$rows = \DB::select("SELECT m.* FROM ui_pd_pbrme e 
inner join ui_pd_pbrme_matriz m on m.idpd_pbrme = e.idpd_pbrme
where e.std_delete = 1 and e.idanio = 4 and e.type = 1 and e.idinstituciones = 1 and m.d_estatus = 1");
		foreach($rows as $r){
			$row = \DB::select("SELECT * FROM ui_reporte where idinstituciones =1 and idanio = 4 and id_area_coordinacion = ? and idproyecto = ? and type = 1", [$r->idarea_coordinacion, $r->idproyecto]);
			if(count($row) == 0){
				$id = \DB::table('ui_reporte')->insertGetId([
					'idinstituciones'      => 1,
					'idanio'               => 4,
					'id_area_coordinacion' => $r->idarea_coordinacion,
					'idproyecto'           => $r->idproyecto,
					'type'                 => 1,
				]);
			}else{
				$id = $row[0]->idreporte;
			}

			$idmir = \DB::table('ui_reporte_mir')->insertGetId([
					'idreporte'      => $id,
					'idprograma_reg'               => $r->idprograma_reg,
					'interpretacion' => $r->d_interpretacion,
					'iddimension_atiende'           => $r->iddimension_atiende,
					'factor'           => $r->d_factor,
					'desc_factor'           => $r->d_factor_desc,
					'linea'           => $r->d_linea_base,
					'descripcion_meta'           => $r->d_descripcion_meta,
					'metas_actividad'           => $r->d_metas_actividad,
					'aplica1'           => $r->d_aplica1,
					'aplica2'           => $r->d_aplica2,
					'aplica3'           => $r->d_aplica3,
					'aplica4'           => $r->d_aplica4,
				]);
			foreach (\DB::select("SELECT * FROM ui_pd_pbrme_indicador where idpd_pbrme_matriz = ?", [$r->idpd_pbrme_matriz]) as $v) {
				 \DB::table('ui_reporte_reg')->insertGetId([
					'idreporte'      => $id,
					'idreporte_mir'               => $idmir,
					'idtipo_operacion' => $v->idtipo_operacion,
					'idind_estrategicos_reg' => $v->idind_estrategicos_reg,
					'unidad_medida'           => $v->unidad_medida,
					'descripcion'           => $v->nombre_largo,
					'prog_anual'           => $v->anual,
					'trim_1'           => $v->trim1,
					'trim_2'           => $v->trim2,
					'trim_3'           => $v->trim3,
					'trim_4'           => $v->trim4,
				]);
			}

	}
	dd("okkk");
	}*/
}