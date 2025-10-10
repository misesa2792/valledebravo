<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class proyectopbrma extends Sximo  {
	
	protected $table = 'ui_proy_pbrm01a';
	protected $primaryKey = 'idproy_pbrm01a';
	protected $moduleID = 3;//Módulo Presupuesto Definitivo, sirve para tomar los años del modulo

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
	public static function getProyectos($idp){
		return \DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proyecto p
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
			where s.idprograma={$idp} AND p.estatus = 1 ORDER BY p.numero ASC");
	}

	public static function getProgramasAnio($idarea,$idanio){
		return \DB::select("SELECT a.idproy_pbrm01a as id,p.numero as no_programa,p.descripcion as programa,a.total,a.url FROM ui_proy_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio}");
	}
	
	public static function getDepAuxiliares($idp){
		return \DB::select("SELECT idarea_coordinacion as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_area_coordinacion where idarea={$idp}");
	}
	//Eliminar registros
	public static function getRegistrosPbrma($id){
		return \DB::select("SELECT idproy_pbrm01a_reg as id FROM ui_proy_pbrm01a_reg where idproy_pbrm01a={$id}");
	}
	public static function getProyectosPbrma($id){
		return \DB::select("SELECT ar.idproy_pbrm01a_reg as id,ar.idarea_coordinacion,ar.idproyecto,ar.presupuesto,ac.descripcion as dep_aux,ac.numero as no_dep_aux,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proy_pbrm01a_reg ar 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = ar.idarea_coordinacion
		inner join ui_proyecto p on p.idproyecto = ar.idproyecto 
		where ar.idproy_pbrm01a={$id}");
	}
	//PDF
	public static function getPbrma($id){
		return \DB::select("SELECT a.idproy_pbrm01a as id,a.idprograma,ar.titular as titular_dep_gen,ar.cargo,p.numero as no_programa,p.descripcion as programa,a.total,ar.descripcion as dep_gen,ar.numero as no_dep_gen,
		i.descripcion as institucion,i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio, m.numero as no_municipio,a.url,y.anio,a.idarea FROM ui_proy_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			inner join ui_area ar on ar.idarea = a.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			inner join ui_anio y on y.idanio = a.idanio
			where a.idproy_pbrm01a={$id}");
	}
}
