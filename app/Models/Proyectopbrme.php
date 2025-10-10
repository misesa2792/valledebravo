<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class proyectopbrme extends Sximo  {
	
	protected $table = 'ui_proy_pbrm01e';
	protected $primaryKey = 'idproy_pbrm01e';
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
	public static function getProgramasAnio($idarea,$idanio){
		return \DB::select("SELECT a.idproy_pbrm01e as id,p.numero as no_programa,p.descripcion as programa,a.url FROM ui_proy_pbrm01e a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio}");
	}
	//PDF
	public static function getPbrme($id){
		return \DB::select("SELECT a.idproy_pbrm01e as id,a.idprograma,p.numero as no_programa,p.objetivo,a.pilar,a.tema,p.descripcion as programa,ar.descripcion as dep_gen,ar.numero as no_dep_gen,ar.titular as titular_dep_gen,a.idprograma,y.anio,
		i.descripcion as institucion,i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio FROM ui_proy_pbrm01e a
		inner join ui_programa p on p.idprograma = a.idprograma
        inner join ui_anio y on y.idanio = a.idanio
		inner join ui_area ar on ar.idarea = a.idarea
			inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
				  inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where a.idproy_pbrm01e={$id}");
	}
	public static function getProyectosPbrme($id,$no){
		return \DB::select("SELECT t.descripcion as tipo,r.* from ui_proy_pbrm01e_tipo t
		left join (SELECT r1.* FROM ui_proy_pbrm01e_reg r1 where r1.idproy_pbrm01e={$id}) r on r.idproy_pbrm01e_tipo = t.idproy_pbrm01e_tipo where t.idproy_pbrm01e_tipo = {$no}");
	}
	public static function getProyectosPbrmeInd($id){
		return \DB::select("SELECT r1.* FROM ui_proy_pbrm01e_reg r1 where r1.idproy_pbrm01e={$id}");
	}
}
