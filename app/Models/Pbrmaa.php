<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrmaa extends Sximo  {
	
	protected $table = 'ui_ap_pbrm02a';
	protected $primaryKey = 'idap_pbrm02a';
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
	public static function getProyectosAnio($idac,$idanio){
		return \DB::select("SELECT a.idap_pbrm02a as id,p.numero as no_proyecto,p.descripcion as proyecto,a.url FROM ui_ap_pbrm02a a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac}");
	}
	//PDF
	public static function getPbrmaa($id){
		return \DB::select("SELECT a.idap_pbrm02a as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa FROM ui_ap_pbrm02a a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
		inner join ui_programa pr on pr.idprograma = s.idprograma
		where a.idap_pbrm02a={$id}");
	}
	public static function getProyectosPbrmaa($id){
		return \DB::select("SELECT * FROM ui_ap_pbrm02a_reg where idap_pbrm02a={$id}");
	}
	public static function getMetasPbrmc($idp,$idanio,$idac){
		return \DB::select("SELECT reg.idap_pbrm01c_reg as id,reg.codigo,reg.meta,reg.unidad_medida FROM ui_ap_pbrm01c c
			inner join ui_ap_pbrm01c_reg reg on reg.idap_pbrm01c = c.idap_pbrm01c
			where c.idanio={$idanio} and c.idproyecto={$idp} and c.idarea_coordinacion={$idac}");
	}
}
