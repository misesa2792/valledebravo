<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrmb extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01b';
	protected $primaryKey = 'idpres_pbrm01b';
	protected $moduleID = 2;//Módulo Presupuesto Definitivo, sirve para tomar los años del modulo

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
	public static function getProgramasAnio($idarea,$idanio){
		return \DB::select("SELECT a.idpres_pbrm01b as id,p.numero as no_programa,p.descripcion as programa,a.url FROM ui_pres_pbrm01b a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete = 1");
	}
	//PDF
	public static function getPbrmb($id){
		return \DB::select("SELECT a.idpres_pbrm01b as id,a.idprograma,p.numero as no_programa,p.descripcion as programa,ar.descripcion as dep_gen,ar.numero as no_dep_gen,ar.titular as titular_dep_gen,
		a.objetivo_programa,a.estrategias_objetivo,a.pdm,a.ods,y.anio,i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria FROM ui_pres_pbrm01b a
		inner join ui_programa p on p.idprograma = a.idprograma
        inner join ui_anio y on y.idanio = a.idanio
		inner join ui_area ar on ar.idarea = a.idarea
			inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
		where a.idpres_pbrm01b={$id}");
	}
	public static function getDepAuxiliares($idp){
		return \DB::select("SELECT idarea_coordinacion as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_area_coordinacion where idarea={$idp}");
	}
	public static function getPbrmbFoda($id,$type){
		return \DB::select("SELECT idpres_pbrm01b_foda as id,descripcion as foda FROM ui_pres_pbrm01b_foda where idpres_pbrm01b={$id} and type={$type}");
	}
	public static function getPbrmbFodaType($id){
		return \DB::select("SELECT idpres_pbrm01b_foda as id,descripcion as foda,type FROM ui_pres_pbrm01b_foda where idpres_pbrm01b={$id}");
	}
	public static function getPbrmbFodaGeneral($id){
		return \DB::select("SELECT idpres_pbrm01b_foda as id,descripcion as foda FROM ui_pres_pbrm01b_foda where idpres_pbrm01b={$id}");
	}
}
