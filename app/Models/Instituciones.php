<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class instituciones extends Sximo  {
	
	protected $table = 'ui_instituciones';
	protected $primaryKey = 'idinstituciones';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null,$request=null){
		$nombre = (empty($request->nombre)) ? "" : " AND descripcion like '%{$request->nombre}%'";
		$active = (empty($request->active)) ? "" : " AND active = ".$request->active;
		$clave = (empty($request->clave)) ? "" : " AND numero = ".$request->clave;
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " WHERE idmunicipios IS NOT NULL ".$nombre.$active.$clave." order by numero asc  ";
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  * ";
		}else{
			$dato = " count(idmunicipios) as suma ";
			$lc = "";
		}
		return DB::select("SELECT {$dato} FROM ui_municipios {$cad} {$lc}");
	}
	public static function getOrganismos($id){
		return DB::select("SELECT i.idinstituciones as id,i.idtipo_dependencias,i.active,i.denominacion as no_institucion,i.descripcion as institucion FROM ui_instituciones i where i.idmunicipios = {$id}");
	}
	public static function getCatTipoDependencias(){
		return DB::select("SELECT idtipo_dependencias as id,descripcion as nombre FROM ui_tipo_dependencias");
	}

	public static function getYears(){
		return DB::select("SELECT idanio,anio FROM ui_anio where idanio != 3 order by anio desc");
	}
	public static function getYearsAll(){
		return DB::select("SELECT idanio,anio FROM ui_anio order by anio desc");
	}
	public static function getModuleID($idi,$idy,$no){
		return DB::select("SELECT idmodule_anio as id FROM ui_module_anio where idanio = {$idy} and idinstituciones = {$idi} and module = {$no}");
	}

	public static function getInstitucionesYears($idi){
		return DB::select("SELECT i.idinstituciones_info as id,a.anio,i.logo_izq,i.logo_der,i.t_uippe,i.t_tesoreria,i.t_egresos,i.t_prog_pres,i.t_secretario,
		i.c_uippe,i.c_tesoreria,i.c_egresos,i.c_prog_pres,i.c_secretario FROM ui_instituciones_info i
		inner join ui_anio a on a.idanio = i.idanio 
		where i.idinstituciones = {$idi} order by i.idanio asc");
	}
	public static function getInstitucionesYearsID($id){
		return DB::select("SELECT i.idinstituciones_info as id,i.logo_izq,i.logo_der,i.t_uippe,i.t_tesoreria,i.t_egresos,i.t_prog_pres,i.t_secretario,
		i.c_uippe,i.c_tesoreria,i.c_egresos,i.c_prog_pres,i.c_secretario,t.denominacion as no_institucion FROM ui_instituciones_info i
		inner join ui_instituciones t on t.idinstituciones = i.idinstituciones
		where i.idinstituciones_info = {$id} ");
	}
	public static function getModulesInstituciones($id,$no){
		return DB::select("SELECT m.idmodule_anio  as id,y.anio FROM ui_module_anio m
		inner join ui_anio y on y.idanio = m.idanio
		where m.idinstituciones = {$id} and m.module = {$no} order by y.anio desc ");
	}
	public static function getDepGen($idy,$idtp){
		return DB::select("SELECT iddep_gen as id FROM ui_dep_gen where idanio = ? and idtipo_dependencias = ?",[$idy,$idtp]);
	}



	
	public static function getModules(){
		return DB::select("SELECT * FROM ui_module");
	}
	public static function getModuleNewInstituciones($idi,$idm){
		return DB::select("SELECT am.idanio_access as id,y.anio,ai.anio as anio_info FROM ui_anio_access am
		inner join ui_anio y on y.idanio = am.idanio
		inner join ui_anio ai on ai.idanio = am.idanio_info
		where am.idinstituciones = ? and am.idmodule = ? order by y.anio desc ", [$idi,$idm]);
	}
}
