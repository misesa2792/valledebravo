<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrmc extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01c';
	protected $primaryKey = 'idpres_pbrm01c';
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
	public static function getProyectosAnio($idac,$idanio){
		return \DB::select("SELECT a.idpres_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,a.total,a.url,a.aa_estatus,pr.idprograma,pr.numero as no_programa,pr.descripcion as programa FROM ui_pres_pbrm01c a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac} and std_delete = 1 ");
	}
	public static function getProyectosPbrmc($id){
		return \DB::select("SELECT idpres_pbrm01c_reg as id,codigo,meta,unidad_medida,programado,alcanzado,anual,absoluta,porcentaje FROM ui_pres_pbrm01c_reg where idpres_pbrm01c={$id}");
	}
	public static function getProyectosAll(){
		return \DB::select("SELECT p.idproyecto as idp,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto  FROM ui_proyecto p 
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
		inner join ui_programa pr on pr.idprograma = sp.idprograma
		where p.estatus = 1 order by p.numero asc");
	}
}
