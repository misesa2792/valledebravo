<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrme extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01e';
	protected $primaryKey = 'idpres_pbrm01e';
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
		return \DB::select("SELECT a.idpres_pbrm01e as id,p.numero as no_programa,p.descripcion as programa,a.url,pp.pilares FROM ui_pres_pbrm01e a
			inner join ui_programa p on p.idprograma = a.idprograma
				inner join ui_pdm_pilares pp on pp.idpdm_pilares = p.idpdm_pilares
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete = 1");
	}
	
	//PDF
	public static function getPbrme($id){
		return \DB::select("SELECT a.idpres_pbrm01e as id,a.idprograma,p.numero as no_programa,p.objetivo,p.descripcion as programa,
		ar.descripcion as dep_gen,ar.numero as no_dep_gen,ar.titular as t_dep_gen,ar.cargo as c_dep_gen,a.idprograma,y.idanio,y.anio,
		i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,
			pp.idpdm_pilares as idpilar,pp.numero as no_pilar,pp.pilares as pilar,a.tema FROM ui_pres_pbrm01e a
				inner join ui_programa p on p.idprograma = a.idprograma
					inner join ui_pdm_pilares pp on pp.idpdm_pilares = p.idpdm_pilares
				inner join ui_anio y on y.idanio = a.idanio
				inner join ui_area ar on ar.idarea = a.idarea
					inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
			where a.idpres_pbrm01e={$id}");
	}
	public static function getProyectosPbrme($id,$no){
		return \DB::select("SELECT t.descripcion as tipo,r.* from ui_pres_pbrm01e_tipo t
		left join (SELECT r1.* FROM ui_pres_pbrm01e_reg r1 where r1.idpres_pbrm01e={$id}) r on r.idpres_pbrm01e_tipo = t.idpres_pbrm01e_tipo where t.idpres_pbrm01e_tipo = {$no}");
	}
	public static function getPbrmeReg($id){
		return \DB::select("SELECT r.idpres_pbrm01e_reg as id,r.idpres_pbrm01e_tipo as tipo,r.descripcion,r.nombre,r.formula,
				fm.idfrecuencia_medicion as idf,ti.idtipo_indicador as idt,fm.descripcion as frecuencia,ti.descripcion as tipo_indicador,r.medios,r.supuestos FROM ui_pres_pbrm01e_reg r 
				left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = r.idfrecuencia_medicion
                left join ui_tipo_indicador ti on ti.idtipo_indicador = r.idtipo_indicador
                where r.idpres_pbrm01e = {$id}");
	}
	public static function getProyectosPbrmeInd($id){
		return \DB::select("SELECT r1.* FROM ui_pres_pbrm01e_reg r1 where r1.idpres_pbrm01e={$id}");
	}
}
