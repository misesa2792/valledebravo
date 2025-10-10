<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrmaa extends Sximo  {
	
	protected $table = 'ui_pres_pbrm02a';
	protected $primaryKey = 'idpres_pbrm02a';
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
	public static function getMetasPbrmcID($id){
		return \DB::select("SELECT r.*,c.idreporte FROM ui_pres_pbrm01c_reg r 
		inner join ui_pres_pbrm01c c on c.idpres_pbrm01c = r.idpres_pbrm01c
		where r.idpres_pbrm01c_reg={$id}");
	}
	public static function getProyectosAnio($idac,$idanio){
		//Query que muestra aquellos registros activos
		return \DB::select("SELECT c.idpres_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,c.aa_url as url,c.aa_estatus,c.idreporte,pr.idprograma,pr.numero as no_programa,pr.descripcion as programa FROM ui_pres_pbrm01c c
		inner join ui_proyecto p on p.idproyecto = c.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
		where c.idanio={$idanio} and c.idarea_coordinacion={$idac} and c.std_delete = 1");//and c.aa_estatus = 1
	}
	public static function getMetasPbrmc($id){
		return \DB::select("SELECT idpres_pbrm01c_reg as id, codigo,meta,unidad_medida,aa_anual,aa_trim1,aa_porc1,aa_trim2,aa_porc2,
		aa_trim3,aa_porc3,aa_trim4,aa_porc4,aa_loc_beneficiada, aa_pob_beneficiada
		FROM ui_pres_pbrm01c_reg where idpres_pbrm01c={$id}");
	}
	public static function getPbrmaa($id){
		return \DB::select("SELECT c.idpres_pbrm01c as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,p.objetivo as obj_proyecto,y.anio,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen, i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,c.total FROM ui_pres_pbrm01c c
		inner join ui_proyecto p on p.idproyecto = c.idproyecto
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = s.idprograma
		inner join ui_anio y on y.idanio = c.idanio
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where c.idpres_pbrm01c={$id}");
	}




	/*
		Sincronización de Pbrm-02a con Pbrm
	*/
	public static function getMetasSync($idanio){
		return \DB::select("SELECT idpres_pbrm01c,idarea_coordinacion,idanio,idproyecto FROM ui_pres_pbrm01c where idanio={$idanio} and std_delete = 1");
	}
	public static function getVerificar($id){
		return \DB::select("SELECT idreporte FROM ui_reporte where idpres_pbrm01c = {$id}");
	}
	public static function getVerificarReg($id){
		return \DB::select("SELECT idreporte_reg FROM ui_reporte_reg where idpres_pbrm01c_reg = {$id}");
	}
	public static function getMetasSyncReg($id){
		return \DB::select("SELECT * FROM ui_pres_pbrm01c_reg where idpres_pbrm01c={$id}");
	}
}
