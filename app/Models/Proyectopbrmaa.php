<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class proyectopbrmaa extends Sximo  {
	
	protected $table = 'ui_proy_pbrm02a';
	protected $primaryKey = 'idproy_pbrm02a';
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
	public static function getProyectosAnio($idac,$idanio){
		return \DB::select("SELECT a.idproy_pbrm02a as id,p.numero as no_proyecto,p.descripcion as proyecto,a.url FROM ui_proy_pbrm02a a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac}");
	}
	public static function getMetasPbrmc($idp,$idanio,$idac){
		return \DB::select("SELECT reg.idproy_pbrm01c_reg as id,reg.codigo,reg.meta,reg.unidad_medida FROM ui_proy_pbrm01c c
			inner join ui_proy_pbrm01c_reg reg on reg.idproy_pbrm01c = c.idproy_pbrm01c
			where c.idanio={$idanio} and c.idproyecto={$idp} and c.idarea_coordinacion={$idac}");
	}
	//PDF
	public static function getPbrmaa($id){
		return \DB::select("SELECT a.idproy_pbrm02a as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto,y.anio,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen, i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio FROM ui_proy_pbrm02a a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = s.idprograma
		inner join ui_anio y on y.idanio = a.idanio
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where a.idproy_pbrm02a={$id}");
	}
	public static function getProyectosPbrmaa($id){
		return \DB::select("SELECT idproy_pbrm02a_reg as id, codigo,meta,unidad_medida,anual as aa_anual,trim1 as aa_trim1,porc1 as aa_porc1,trim2 as aa_trim2,porc2 as aa_porc2,trim3 as aa_trim3,porc3 as aa_porc3,trim4 as aa_trim4,porc4 as aa_porc4,loc_beneficiada,pob_beneficiada FROM ui_proy_pbrm02a_reg where idproy_pbrm02a={$id}");
	}
	public static function getProyectoMetasExport($idanio){
		return \DB::select("SELECT a.idproy_pbrm02a as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,
			ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,reg.* FROM ui_proy_pbrm02a a
			inner join ui_proyecto p on p.idproyecto = a.idproyecto
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
			inner join ui_programa pr on pr.idprograma = s.idprograma
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
			inner join ui_proy_pbrm02a_reg reg on reg.idproy_pbrm02a = a.idproy_pbrm02a
			where idanio = {$idanio} order by ar.numero asc");
	}
}
