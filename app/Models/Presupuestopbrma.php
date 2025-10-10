<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class presupuestopbrma extends Sximo  {
	
	protected $table = 'ui_pres_pbrm01a';
	protected $primaryKey = 'idpres_pbrm01a';
	protected $moduleID = 2;//Módulo Presupuesto Definitivo, sirve para tomar los años del modulo

	//Nueva tabla Presupuesto Definitivo 2025
	protected $tablePD = 'ui_pd_pbrm01a';
	protected $primaryPDKey = 'idpd_pbrm01a';
	protected $tablePDReg = 'ui_pd_pbrm01a_reg';
	protected $primaryPDKeyReg = 'idpd_pbrm01a_reg';
	protected $tablePDMeta = 'ui_pd_pbrm01a_metas';
	protected $primaryPDKeyMeta = 'idpd_pbrm01a_metas';

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
		return \DB::select("SELECT a.idpres_pbrm01a as id,p.numero as no_programa,p.descripcion as programa,a.total,a.url FROM ui_pres_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete=1");
	}
	public static function getProyectosDepAux($idarea,$idanio){
		return \DB::select("SELECT a.idpres_pbrm01a as id,ac.numero as no_dep_aux,ac.descripcion as dep_aux,pr.numero as no_proyecto,pr.descripcion as proyecto,r.presupuesto FROM ui_pres_pbrm01a a
			inner join ui_pres_pbrm01a_reg r on a.idpres_pbrm01a = r.idpres_pbrm01a
				inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				inner join ui_proyecto pr on pr.idproyecto = r.idproyecto
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete=1 order by ac.numero asc");
	}
	public static function getProyectosPbrmc($id){
		return \DB::select("SELECT idpres_pbrm01c as id FROM ui_pres_pbrm01a_reg where idpres_pbrm01a = {$id}");
	}
	public static function getProyectosRegPbrmc($id){
		return \DB::select("SELECT idpres_pbrm01c as id FROM ui_pres_pbrm01a_reg where idpres_pbrm01a_reg = {$id}");
	}
	public static function getProyectos($idp){
		return \DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proyecto p
			inner join ui_subprograma s on s.idsubprograma = p.idsubprograma
			where s.idprograma={$idp} AND p.estatus = 1 ORDER BY p.numero ASC");
	}
	public static function getDepAuxiliares($idp){
		return \DB::select("SELECT idarea_coordinacion as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_area_coordinacion where idarea={$idp}");
	}
	public static function getProyectosPbrma($id){
		return \DB::select("SELECT ar.idpres_pbrm01a_reg as id,ar.idarea_coordinacion,ar.idproyecto,ar.presupuesto,ac.descripcion as dep_aux,
		ac.numero as no_dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,ar.idpres_pbrm01c FROM ui_pres_pbrm01a_reg ar 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = ar.idarea_coordinacion
		inner join ui_proyecto p on p.idproyecto = ar.idproyecto 
		where ar.idpres_pbrm01a={$id}");
	}
	//PDF
	public static function getPbrma($id){
		return \DB::select("SELECT a.idpres_pbrm01a as id,a.idprograma,ar.titular as titular_dep_gen,p.numero as no_programa,p.descripcion as programa,a.total,ar.descripcion as dep_gen,ar.numero as no_dep_gen,
		i.descripcion as institucion,i.logo_izq,i.logo_der,i.titular_uippe,i.titular_tesoreria,m.descripcion as municipio,m.numero as no_municipio,a.url,y.idanio,y.anio,a.idarea FROM ui_pres_pbrm01a a
				inner join ui_programa p on p.idprograma = a.idprograma
				inner join ui_area ar on ar.idarea = a.idarea
					inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
							inner join ui_municipios m on m.idmunicipios = i.idmunicipios
				inner join ui_anio y on y.idanio = a.idanio
				where a.idpres_pbrm01a={$id}");
	}

	//Exportación del PROGRESS
	public static function getRowsCalendarizacionMetas(){
		return \DB::select("SELECT c.idpres_pbrm01c as id,c.total,ar.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto,reg.codigo as clave_accion,reg.meta as concepto,reg.unidad_medida,
			reg.programado,reg.alcanzado,reg.aa_trim1,reg.aa_trim2,reg.aa_trim3,reg.aa_trim4 FROM ui_pres_pbrm01c_reg reg 
		inner join ui_pres_pbrm01c c on c.idpres_pbrm01c = reg.idpres_pbrm01c
		inner join ui_proyecto p on p.idproyecto = c.idproyecto
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
			inner join ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones u on u.idinstituciones = ar.idinstituciones
		where c.std_delete=1 and c.idanio=2 order by ar.numero asc,ac.numero");
	}
	public static function getRowsDescripcionPrograma(){
		return \DB::select("SELECT b.idpres_pbrm01b as id,pr.numero as no_programa,ar.numero as no_dep_gen,b.objetivo_programa,b.estrategias_objetivo,b.pdm,b.ods FROM ui_pres_pbrm01b b 
		inner join ui_programa pr on pr.idprograma = b.idprograma
		inner join ui_area ar on ar.idarea = b.idarea
			inner join ui_instituciones u on u.idinstituciones = ar.idinstituciones
		where b.std_delete=1 and b.idanio=2 order by ar.numero asc");
	}
	public static function getRowsindicadores(){
		return \DB::select("SELECT d.idpres_pbrm01d as id, pi.tipo, pi.pilares,d.temas_desarrollo,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,
		pr.numero as no_programa,pr.descripcion as programa,su.numero as no_subfuncion,su.descripcion as subfuncion,f.numero as no_funcion,f.descripcion as funcion,
		ff.numero as no_finalidad,ff.descripcion as finalidad,d.nombre_indicador,ti.descripcion as tipo_indicador,d.formula as formula_calculo,d.interpretacion,da.descripcion as dimencion,
		d.factor as factor_comparacion,d.desc_factor,fm.descripcion as frecuencia, d.linea as linea_base,d.medios_verificacion,pro.numero as no_proyecto,pro.descripcion as proyecto,pro.objetivo as obj_proyecto,ss.numero as no_subprograma,ss.descripcion as subprograma FROM ui_pres_pbrm01d d
		inner join ui_pdm_pilares pi on pi.idpdm_pilares = d.idpdm_pilares
		left join ui_proyecto pro on pro.idproyecto = d.idproyecto
			left join ui_subprograma ss on ss.idsubprograma = pro.idsubprograma
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = d.idarea_coordinacion
			inner join ui_area a on a.idarea = ac.idarea
		inner join ui_programa pr on pr.idprograma = d.idprograma
			inner join ui_subfuncion su on su.idsubfuncion = pr.idsubfuncion
				inner join ui_funcion f on f.idfuncion = su.idfuncion
					inner join ui_finalidad ff on ff.idfinalidad = f.idfinalidad
		left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = d.idfrecuencia_medicion
        left join ui_tipo_indicador ti on ti.idtipo_indicador = d.idtipo_indicador
        left join ui_dimension_atiende da on da.iddimension_atiende = d.iddimension_atiende
		where d.idanio = 2 and d.std_delete = 1 order by a.numero,ac.numero asc");
	}
	public static function getRowsindicadoresRegistros($id){
		return \DB::select("SELECT r.indicador,r.unidad_medida,tp.descripcion as tipo_operacion,r.trim1,r.trim2,r.trim3,r.trim4,r.anual FROM ui_pres_pbrm01d_reg r 
		left join ui_tipo_operacion tp on tp.idtipo_operacion = r.idtipo_operacion
		where r.idpres_pbrm01d={$id}");
	}
	public static function getRowsDescripcionProgramaFODA($id,$type){
		return \DB::select("SELECT descripcion as foda FROM ui_pres_pbrm01b_foda f where f.idpres_pbrm01b = {$id} and f.type = {$type}");
	}
	public static function getRowsIndicadoresMatriz(){
		return \DB::select("SELECT e.idpres_pbrm01e as id,a.numero as no_dep_gen,
		pr.numero as no_programa,
		   ss.numero AS no_subfuncion,ss.descripcion as subfuncion,
			ff.numero AS no_funcion,ff.descripcion as funcion,
			fi.numero AS no_finalidad,fi.descripcion as finalidad,pr.descripcion as programa,pr.objetivo,pi.tipo,pi.pilares,e.tema,e.pilar FROM ui_pres_pbrm01e e
		inner join ui_area a on a.idarea = e.idarea
		inner join ui_programa pr on pr.idprograma = e.idprograma
			inner join ui_subfuncion ss on ss.idsubfuncion = pr.idsubfuncion
				inner join ui_funcion ff on ff.idfuncion = ss.idfuncion
					inner join ui_finalidad fi on fi.idfinalidad = ff.idfinalidad
		left join ui_pdm_pilares pi on pi.idpdm_pilares = e.idpdm_pilares
		where e.std_delete=1 and e.idanio=2
		");
	}
	public static function getRowsIndicadoresMatrizReg($tipo,$id){
		return \DB::select("SELECT * FROM ui_pres_pbrm01e_reg where idpres_pbrm01e_tipo={$tipo} and idpres_pbrm01e={$id}");
	}



	/*
	*
	*Nuevas funciones para el año 2025 en adelante
	*
	* 
	*/
	public static function getProyectosDepAuxNew($idarea,$idanio){
		return \DB::select("SELECT a.idpd_pbrm01a as id,ac.numero as no_dep_aux,ac.descripcion as dep_aux,pr.numero as no_proyecto,pr.descripcion as proyecto,r.presupuesto FROM ui_pd_pbrm01a a
			inner join ui_pd_pbrm01a_reg r on a.idpd_pbrm01a = r.idpd_pbrm01a
				inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
				inner join ui_proyecto pr on pr.idproyecto = r.idproyecto
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete=1 order by ac.numero asc");
	}
	public static function getProgramasAnioNew($idarea,$idanio){
		return \DB::select("SELECT a.idpd_pbrm01a as id,p.numero as no_programa,p.descripcion as programa,a.total,a.url FROM ui_pd_pbrm01a a
			inner join ui_programa p on p.idprograma = a.idprograma
			where a.idarea={$idarea} and a.idanio={$idanio} and a.std_delete=1");
	}
	//PDF New
	public static function getPbrmaNew($id){
		return \DB::select("SELECT a.idpd_pbrm01a as id,a.idprograma,ar.titular as t_dep_gen,ar.cargo as c_dep_gen,p.numero as no_programa,p.descripcion as programa,a.total,ar.descripcion as dep_gen,ar.numero as no_dep_gen,
		i.denominacion as no_institucion,i.descripcion as institucion,a.url,y.idanio,y.anio,a.idarea,ar.idinstituciones as idi FROM ui_pd_pbrm01a a
				inner join ui_programa p on p.idprograma = a.idprograma
				inner join ui_area ar on ar.idarea = a.idarea
					inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
				inner join ui_anio y on y.idanio = a.idanio
				where a.idpd_pbrm01a={$id}");
	}
	public static function getProyectosPbrmaNew($id){
		return \DB::select("SELECT ar.idpd_pbrm01a_reg as id,ar.idarea_coordinacion,ar.idproyecto,ar.presupuesto,ac.descripcion as dep_aux,
		ac.numero as no_dep_aux,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_pd_pbrm01a_reg ar 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = ar.idarea_coordinacion
		inner join ui_proyecto p on p.idproyecto = ar.idproyecto 
		where ar.idpd_pbrm01a={$id}");
	}
	/*
	 *
	 * Módulo PbRM-01c
	 *  
	 */
	public static function getProyectosAniosPbrmc($idac,$idy){
		return \DB::select("SELECT r.idpd_pbrm01a_reg as id,r.c_estatus,r.c_url,r.aa_estatus,r.aa_url,p.numero as no_proyecto,p.descripcion as proyecto,r.presupuesto as total,pr.idprograma,
		pr.numero as no_programa,pr.descripcion as programa FROM ui_pd_pbrm01a_reg r
		inner join ui_pd_pbrm01a a on a.idpd_pbrm01a = r.idpd_pbrm01a
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
			where a.idanio={$idy} and r.idarea_coordinacion={$idac} and a.std_delete = 1");
	}
	public static function getPbrmcNew($id){
		return \DB::select("SELECT r.idpd_pbrm01a_reg as id,r.presupuesto as total,y.idanio,y.anio,p.numero as no_proyecto,p.descripcion as proyecto,p.objetivo as obj_proyecto,pr.idprograma,pr.numero as no_programa,pr.descripcion as programa,
		ar.numero as no_dep_gen,ar.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,
		i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,ar.titular as t_dep_gen,ar.cargo as c_dep_gen FROM ui_pd_pbrm01a_reg r
		INNER JOIN ui_pd_pbrm01a a ON a.idpd_pbrm01a = r.idpd_pbrm01a
			INNER JOIN ui_anio y ON y.idanio = a.idanio
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
		INNER JOIN ui_area_coordinacion ac on ac.idarea_coordinacion = r.idarea_coordinacion
			INNER JOIN ui_area ar on ar.idarea = ac.idarea
				inner join ui_instituciones i on i.idinstituciones = ar.idinstituciones
		WHERE r.idpd_pbrm01a_reg = {$id}
		");
	}
	public static function getPbrmcNewReg($id){
		return \DB::select("SELECT m.idpd_pbrm01a_metas as id,m.codigo,m.meta,m.unidad_medida,m.c_programado as programado,m.c_alcanzado as alcanzado,m.c_anual as anual,m.c_absoluta as absoluta,m.c_porcentaje as porcentaje FROM ui_pd_pbrm01a_metas m
			where m.idpd_pbrm01a_reg = {$id}
		");
	}
	/*
	 *
	 * Módulo PbRM-02a
	 *  
	 */
	public static function getPbrmcNewMetas($id){
		return \DB::select("SELECT m.idpd_pbrm01a_metas as id,m.codigo,m.meta,m.unidad_medida,m.aa_loc_beneficiada,m.aa_pob_beneficiada,m.aa_anual,m.aa_trim1,m.aa_trim2,m.aa_trim3,m.aa_trim4,m.aa_porc1,m.aa_porc2,m.aa_porc3,m.aa_porc4 FROM ui_pd_pbrm01a_metas m
			where m.idpd_pbrm01a_reg = {$id}
		");
	}
}
