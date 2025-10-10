<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class seguimientoproyectos extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01a';
	protected $primaryKey = 'idpres_pbrm01a';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($idam){
		return DB::select("SELECT idteso_proyectos as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,pr.numero as no_proyecto,pr.descripcion as proyecto,tp.presupuesto FROM ui_teso_proyectos tp
		inner join ui_dep_gen dg on dg.iddep_gen = tp.iddep_gen
		inner join ui_dep_aux da on da.iddep_aux = tp.iddep_aux
		inner join ui_proyecto pr on pr.idproyecto = tp.idproyecto
		where tp.idanio_module = ? order by dg.numero,da.numero,pr.numero asc",[$idam]);
	}




	public static function getSearchold($numero=null, $request=null, $idi){
		
		$nop = (empty($request->no_proyecto)) ? "" : " AND p.numero like '%{$request->no_proyecto}%'";
		$proy = (empty($request->proyecto)) ? "" : " AND p.descripcion like '%{$request->proyecto}%'";
		$iddg = (empty($request->iddep_gen)) ? "" : " AND a.idarea = {$request->iddep_gen} ";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad = $nop.$proy.$iddg;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  * ";
		}else{
			$dato = " count(info.idp) as suma ";
			$lc = "";
		}
		//2025
		if($request->idanio >= 3){
			return \DB::select("SELECT {$dato} FROM (SELECT o.anio,p.idproyecto as idp,p.numero as no_proyecto,p.descripcion as proyecto,a.idarea as iddep_gen,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.idarea_coordinacion as iddep_aux,ac.numero as no_dep_aux,ac.descripcion as dep_aux,r.presupuesto FROM ui_pd_pbrm01a_reg r
			inner join ui_pd_pbrm01a pa on pa.idpd_pbrm01a = r.idpd_pbrm01a
				inner join ui_anio o on o.idanio = pa.idanio
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where pa.idanio = {$request->idanio} {$cad} and pa.std_delete = 1 and a.idinstituciones = {$idi} order by a.numero asc) AS info {$lc}");
		}else{
			return \DB::select("SELECT {$dato} FROM (SELECT o.anio,p.idproyecto as idp,p.numero as no_proyecto,p.descripcion as proyecto,a.idarea as iddep_gen,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.idarea_coordinacion as iddep_aux,ac.numero as no_dep_aux,ac.descripcion as dep_aux,r.presupuesto FROM ui_pres_pbrm01a_reg r
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_pres_pbrm01a pa on pa.idpres_pbrm01a = r.idpres_pbrm01a
			inner join ui_anio o on o.idanio = r.idanio
			where r.idanio = {$request->idanio} {$cad} and pa.std_delete = 1 and a.idinstituciones = {$idi} order by a.numero asc) AS info {$lc}");
		}

	}
	//Total suficiencia presupuestal
	public static function getTotalSuficienciaPresupuestal($idanio, $idac, $idp){
		return \DB::select("SELECT sum(r.importe) as importe FROM ui_teso_suficiencia_pres p
		inner join ui_teso_suficiencia_pres_reg r on p.idteso_suficiencia_pres = r.idteso_suficiencia_pres
		where p.std_delete = 2 and p.idanio = {$idanio} and p.idarea_coordinacion = {$idac} and p.idproyecto = {$idp}");
	}
	//Total de Transpasos Internos
	public static function getTotalTraspaso($type,$idanio, $idac, $idp){
		return \DB::select("SELECT sum(r.importe) as importe FROM ui_teso_trans_int i
		inner join ui_teso_trans_int_reg r on r.idteso_trans_int = i.idteso_trans_int
		where i.type = {$type} and i.std_delete = 2 and i.idanio = {$idanio} and i.idarea_coordinacion = {$idac} and i.idproyecto = {$idp}");
	}
	//Transpaso Externo aumenta
	public static function getTotalTraspasoExterno($type, $idanio, $idac, $idp){
		return \DB::select("SELECT sum(r.importe) as importe FROM ui_teso_trans_int i
		inner join ui_teso_trans_int_reg r on r.idteso_trans_int = i.idteso_trans_int
		where i.type = {$type} and i.std_delete = 2 and i.idanio = {$idanio} and i.idarea_coordinacion_ext = {$idac} and i.idproyecto_ext = {$idp}");
	}
}
