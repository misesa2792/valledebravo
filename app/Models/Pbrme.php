<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrme extends Sximo  {
	
	protected $table = 'ui_ap_pbrm01e';
	protected $primaryKey = 'idap_pbrm01e';
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
	public static function getProgramasAnio($idarea,$idanio){
		return \DB::select("SELECT a.idap_pbrm01e as id,p.numero as no_programa,p.descripcion as programa,a.url FROM ui_ap_pbrm01e a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio}");
	}
	public static function getProgramas(){
		return \DB::select("SELECT idprograma,numero as no_programa,descripcion as programa,objetivo FROM ui_programa where estatus = 1 ORDER BY numero ASC");
	}
	public static function getProyectosPbrmeInd($id){
		return \DB::select("SELECT r1.* FROM ui_ap_pbrm01e_reg r1 where r1.idap_pbrm01e={$id}");
	}
	//PDF
	public static function getPbrme($id){
		return \DB::select("SELECT a.idap_pbrm01e as id,a.idprograma,p.numero as no_programa,p.objetivo,a.pilar,a.tema,p.descripcion as programa,ar.descripcion as dep_gen,ar.numero as no_dep_gen,a.idprograma FROM ui_ap_pbrm01e a
		inner join ui_programa p on p.idprograma = a.idprograma
		inner join ui_area ar on ar.idarea = a.idarea
		where a.idap_pbrm01e={$id}");
	}
	public static function getProyectosPbrme($id,$no){
		return \DB::select("SELECT t.descripcion as tipo,r.* from ui_ap_pbrm01e_tipo t
		left join (SELECT r1.* FROM ui_ap_pbrm01e_reg r1 where r1.idap_pbrm01e={$id}) r on r.idap_pbrm01e_tipo = t.idap_pbrm01e_tipo where t.idap_pbrm01e_tipo = {$no}");
	}
}
