<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrma extends Sximo  {
	
	protected $table = 'ui_ap_pbrm01a';
	protected $primaryKey = 'idap_pbrm01a';
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
	public static function getProgramas(){
		return \DB::select("SELECT idprograma,numero as no_programa,descripcion as programa FROM ui_programa where estatus = 1 ORDER BY numero ASC");
	}
	public static function getProyectos($idp){
		return \DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proyecto p
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
			where s.idprograma={$idp} AND p.estatus = 1 ORDER BY p.numero ASC");
	}
	public static function getDepAuxiliares($idp){
		return \DB::select("SELECT idarea_coordinacion as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_area_coordinacion where idarea={$idp}");
	}
	public static function getProgramasAnio($idarea,$idanio){
		return \DB::select("SELECT a.idap_pbrm01a as id,p.numero as no_programa,p.descripcion as programa,a.total,a.url FROM ui_ap_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio}");
	}
	//Eliminar registros
	public static function getRegistrosPbrma($id){
		return \DB::select("SELECT idap_pbrm01a_reg as id FROM ui_ap_pbrm01a_reg where idap_pbrm01a={$id}");
	}
	//PDF
	public static function getPbrma($id){
		return \DB::select("SELECT a.idap_pbrm01a as id,a.idprograma,p.numero as no_programa,p.descripcion as programa,a.total,ar.descripcion as dep_gen,ar.numero as no_dep_gen FROM ui_ap_pbrm01a a
		inner join ui_programa p on p.idprograma = a.idprograma
		inner join ui_area ar on ar.idarea = a.idarea
		where a.idap_pbrm01a={$id}");
	}
	public static function getProyectosPbrma($id){
		return \DB::select("SELECT ar.idap_pbrm01a_reg as id,ar.idarea_coordinacion,ar.idproyecto,ar.presupuesto,ac.descripcion as dep_aux,ac.numero as no_dep_aux,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_ap_pbrm01a_reg ar 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = ar.idarea_coordinacion
		inner join ui_proyecto p on p.idproyecto = ar.idproyecto 
		where ar.idap_pbrm01a={$id}");
	}
}
