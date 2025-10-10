<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class proyectopbrmc extends Sximo  {
	
	protected $table = 'ui_proy_pbrm01c';
	protected $primaryKey = 'idproy_pbrm01c';
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
		return \DB::select("SELECT a.idproy_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,a.total,a.url FROM ui_proy_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac}");
	}
	//Eliminar registros
	public static function getRegistrosPbrmc($id){
		return \DB::select("SELECT idproy_pbrm01c_reg as id FROM ui_proy_pbrm01c_reg where idproy_pbrm01c={$id}");
	}
	//PDF
	public static function getPbrmc($id){
		return \DB::select("SELECT a.idproy_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto,y.anio,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen,ar.cargo, i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,a.total FROM ui_proy_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = s.idprograma
		inner join ui_anio y on y.idanio = a.idanio
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where a.idproy_pbrm01c={$id}");
	}
	public static function getProyectosPbrmc($id){
		return \DB::select("SELECT idproy_pbrm01c_reg as id,codigo,meta,unidad_medida,programado,alcanzado,anual,absoluta,porcentaje FROM ui_proy_pbrm01c_reg where idproy_pbrm01c={$id}");
	}
}
