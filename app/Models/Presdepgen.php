<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presdepgen extends Sximo  {
	
	protected $table = 'ui_teso_dep_gen';
	protected $primaryKey = 'idteso_dep_gen';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_dep_gen.* FROM ui_teso_dep_gen  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_dep_gen.idteso_dep_gen IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static function getAreasGeneralPresupuesto($idi,$idanio){
		return \DB::select("SELECT d.idteso_dep_gen as id,a.idarea as ida,a.estatus,a.numero as no_dep_gen,a.descripcion as dep_gen,d.presupuesto,d.proyecto,d.anteproyecto FROM ui_teso_dep_gen d
		inner join ui_area a on a.idarea = d.idarea
		where d.idanio = {$idanio} and a.idinstituciones = {$idi}");
	}
	public static function getAreasGeneralPresID($id){
		return \DB::select("SELECT d.idteso_dep_gen as id,a.estatus,a.numero as no_dep_gen,a.descripcion as dep_gen,d.presupuesto,d.proyecto,d.anteproyecto FROM ui_teso_dep_gen d
		inner join ui_area a on a.idarea = d.idarea
		where d.idteso_dep_gen = {$id}");
	}
	public static function getTotalPresDefinitivo($idyear){
		return \DB::select("SELECT idarea,sum(total) as presupuesto FROM ui_pres_pbrm01a 
			WHERE idanio = {$idyear} and std_delete = 1 group by idarea");
	}
	//Nuevo para el año 2025
	public static function getTotalPresDefinitivoNew($idyear){
		return \DB::select("SELECT idarea,sum(total) as presupuesto FROM ui_pd_pbrm01a 
			WHERE idanio = {$idyear} and std_delete = 1 group by idarea");
	}
	public static function getTotalProyecto($idyear){
		return \DB::select("SELECT idarea,sum(total) as presupuesto FROM ui_proy_pbrm01a 
			WHERE idanio = {$idyear} group by idarea");
	}
	public static function getTotalAnteProyecto($idyear){
		return \DB::select("SELECT idarea,sum(total) as presupuesto FROM ui_ap_pbrm01a 
			WHERE idanio = {$idyear} group by idarea");
	}

	public static function getDepGenActivas($idi, $idy){
		return \DB::select("SELECT a.idarea as ida FROM ui_area a
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
	 	where a.idinstituciones = {$idi} and a.estatus = 1 AND a.idanio = {$idy}");
	}
	public static function getValidarReg($idyear,$idarea){
		return \DB::select("SELECT idteso_dep_gen as id FROM ui_teso_dep_gen where idanio = {$idyear} and idarea = {$idarea}");
	}
}
