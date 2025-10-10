<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrmd extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01d';
	protected $primaryKey = 'idpres_pbrm01d';
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
		return \DB::select("SELECT a.idpres_pbrm01d as id,p.idprograma,p.numero as no_programa,p.descripcion as programa,a.url,a.nombre_indicador,pp.numero as no_proyecto,pp.descripcion as proyecto,a.mir FROM ui_pres_pbrm01d a
		inner join ui_proyecto pp on pp.idproyecto = a.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = pp.idsubprograma
				inner join ui_programa p on p.idprograma = sp.idprograma
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac} and a.std_delete = 1");
	}
	/*public static function getProgramas(){
		return \DB::select("SELECT idprograma,numero as no_programa,descripcion as programa,objetivo FROM ui_programa  where estatus = 1 ORDER BY numero ASC");
	}*/
	public static function getProyectosPbrmd($id){
		return \DB::select("SELECT r.idpres_pbrm01d_reg,r.indicador,r.unidad_medida,r.trim1,r.trim2,r.trim3,r.trim4,r.anual,tp.descripcion as tipo_operacion,r.idtipo_operacion FROM ui_pres_pbrm01d_reg r 
		left join ui_tipo_operacion tp on tp.idtipo_operacion = r.idtipo_operacion
		where r.idpres_pbrm01d = {$id}");
	}
	//PDF
	public static function getPbrmdNew($id){
		return \DB::select("SELECT a.idpres_pbrm01d as id,
		a.temas_desarrollo as tema,
		pi.numero as no_pilar,pi.pilares as pilar,
		pro.idproyecto,pro.numero as no_proyecto,pro.descripcion as proyecto,
		pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,
		ar.numero as no_dep_gen,ar.descripcion as dep_gen,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,
		y.idanio,y.anio,a.mir,
		a.nombre_indicador,a.formula,a.interpretacion,da.iddimension_atiende,da.descripcion as dimencion,fm.idfrecuencia_medicion,fm.descripcion as frecuencia,a.factor,ti.idtipo_indicador,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,ar.titular as titular_dep_gen,i.idinstituciones as idi, i.descripcion as institucion,i.denominacion as no_institucion,
		a.idarea_coordinacion as idac,
				ti.descripcion as tipo,a.desc_factor,a.linea,
				a.descripcion_meta,a.medios_verificacion,a.metas_actividad,a.porc1,a.porc2,a.porc3,a.porc4,a.porc_anual
				FROM ui_pres_pbrm01d a
				inner join ui_proyecto pro on pro.idproyecto = a.idproyecto
					inner join ui_subprograma sp on sp.idsubprograma = pro.idsubprograma
						inner join ui_programa pr on pr.idprograma = sp.idprograma
							inner join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
				inner join ui_anio y on y.idanio = a.idanio
				inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
					inner join ui_area ar on ar.idarea = ac.idarea
						inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
				left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = a.idfrecuencia_medicion
				left join ui_tipo_indicador ti on ti.idtipo_indicador = a.idtipo_indicador
				left join ui_dimension_atiende da on da.iddimension_atiende = a.iddimension_atiende
				where a.idpres_pbrm01d={$id}");
	}
	/*public static function getPbrmd($id){
		return \DB::select("SELECT a.idpres_pbrm01d as id,a.idarea_coordinacion as idac,a.idproyecto,a.idprograma,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo,a.temas_desarrollo,pi.numero as no_pilar,pi.pilares,a.idpdm_pilares_temas,a.idpdm_pilares,a.idprograma,
		a.nombre_indicador,a.formula,a.interpretacion,da.iddimension_atiende,da.descripcion as dimencion,fm.idfrecuencia_medicion,fm.descripcion as frecuencia,a.factor,ti.idtipo_indicador,ti.descripcion as tipo,a.desc_factor,a.linea,a.descripcion_meta,
		a.medios_verificacion,a.metas_actividad,a.porc1,a.porc2,a.porc3,a.porc4,a.porc_anual,
        y.idanio,y.anio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,ar.titular as titular_dep_gen, i.descripcion as institucion,
		i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,y.idperiodo,a.mir FROM ui_pres_pbrm01d a
		inner join ui_programa pr on pr.idprograma = a.idprograma
		inner join ui_pdm_pilares pi on pi.idpdm_pilares = a.idpdm_pilares
        inner join ui_anio y on y.idanio = a.idanio
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = a.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = a.idfrecuencia_medicion
        left join ui_tipo_indicador ti on ti.idtipo_indicador = a.idtipo_indicador
        left join ui_dimension_atiende da on da.iddimension_atiende = a.iddimension_atiende
		where a.idpres_pbrm01d={$id}");
	}*/
	/*public static function getProyectoPrograma($id,$programa){
		return \DB::select("SELECT info.* FROM (SELECT p.idproyecto as id,p.numero as no_proyecto,p.descripcion as proyecto,LEFT(p.numero, 8) as programa_proyecto FROM ui_proyecto p
		inner join ui_subprograma s on s.idsubprograma = s.idsubprograma
		where s.idprograma = {$id} and p.estatus = 1 group by p.numero) info where info.programa_proyecto = '{$programa}'");
	}*/

	public static function getProyectosPbRMa($idy, $idac){
		return \DB::select("SELECT pi.idpdm_pilares as idpilar,pi.numero as no_pilar,pi.pilares as pilar,p.idprograma,p.numero as no_programa,p.descripcion as programa,p.tema_desarrollo as tema,p.objetivo,pr.idproyecto,pr.numero as no_proyecto,pr.descripcion as proyecto,re.idarea_coordinacion as idac FROM ui_pd_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
				inner join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
			inner join ui_pd_pbrm01a_reg re on re.idpd_pbrm01a = a.idpd_pbrm01a
				inner join ui_proyecto pr on pr.idproyecto = re.idproyecto
			where a.std_delete = 1 and a.idanio = {$idy} and re.idarea_coordinacion = {$idac} group by pr.idproyecto ORDER BY pr.numero ASC ");
	}
}
