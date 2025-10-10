<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrmc extends Sximo  {
	
	protected $table = 'ui_ap_pbrm01c';
	protected $primaryKey = 'idap_pbrm01c';
	protected $moduleID = 4;//Módulo Presupuesto Definitivo, sirve para tomar los años del modulo

	/*
		1.- Presupuesto
		2.- Presupuesto Definitivo  (Programa Anual)
		3.- Proyectos 				(Programa Anual)
		4.- Ante Proyecto 			(Programa Anual)
		5.- PbRM
	*/
	public function __construct() {
		parent::__construct();
	}
	public static function getAreas($idi){
		return \DB::select("SELECT a.*,ui.descripcion as institucion,ui.logo FROM ui_area a
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
	 	where a.idinstituciones ={$idi}");
	}
	public static function getProyectosAnio($idac,$idanio){
		return \DB::select("SELECT a.idap_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,a.total,a.url FROM ui_ap_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac}");
	}
	//PDF
	public static function getPbrmc($id){
		return \DB::select("SELECT a.idap_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,a.total,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo,p.objetivo as obj_proyecto FROM ui_ap_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
		inner join ui_programa pr on pr.idprograma = s.idprograma
		where a.idap_pbrm01c={$id}");
	}
	public static function getProyectosPbrmc($id){
		return \DB::select("SELECT idap_pbrm01c_reg as id,codigo,meta,unidad_medida,programado,alcanzado,anual,absoluta,porcentaje FROM ui_ap_pbrm01c_reg where idap_pbrm01c={$id}");
	}
	//Eliminar registros
	public static function getRegistrosPbrmc($id){
		return \DB::select("SELECT idap_pbrm01c_reg as id FROM ui_ap_pbrm01c_reg where idap_pbrm01c={$id}");
	}
}
