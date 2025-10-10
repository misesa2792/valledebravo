<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class transpasosinternos extends Sximo  {
	
	protected $table = 'ui_teso_trans_int';
	protected $primaryKey = 'idteso_trans_int';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

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
	
	public static function getRegistrosFF($idac, $idy){
		return DB::select("SELECT i.idteso_trans_int as id,i.type,p.numero as no_proyecto,p.descripcion as proyecto,i.justificacion,
					i.number,i.number_nota,i.number_rec,i.oficio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,ar.numero as no_dep_gen,i.std_delete,i.fecha_rg,
					sum(r.importe) as importe
					FROM ui_teso_trans_int i
					inner join ui_proyecto p on p.idproyecto = i.idproyecto
					left join ui_area_coordinacion ac on ac.idarea_coordinacion = i.idarea_coordinacion_ext
						left join ui_area ar on ar.idarea = ac.idarea
					inner join ui_teso_trans_int_reg r on r.idteso_trans_int=i.idteso_trans_int
					where i.idanio = {$idy} and i.idarea_coordinacion = {$idac} group by r.idteso_trans_int order by r.idteso_trans_int desc");
	}
	public static function getInfoTranspasoInternoID($id){
		return DB::select("SELECT 
							-- Type 1 (Traspaso Interno), Type 2 (Traspaso Externo)
							i.type,
							i.oficio,
							aa.anio,
							aa.leyenda,
							i.justificacion,
							i.std_delete,
							-- Información necesaria para hacer el calculo de presupuesto para la reconduccion
							i.idarea_coordinacion as idac_int,
							i.idarea_coordinacion_ext as idac_ext,
							i.idproyecto as idp_int,
							i.idproyecto_ext as idp_ext,
							i.idanio,
							-- Traspaso Interno
							ac.numero AS no_dep_aux_int,
							ac.descripcion AS dep_aux_int,
							ar.numero AS no_dep_gen_int,
							ar.descripcion AS dep_gen_int,
							p.numero AS no_proyecto_int,
							p.descripcion AS proyecto_int,
							pr.numero AS no_programa_int,
							pr.descripcion AS programa_int,
							pr.objetivo AS obj_programa_int,
							cp.clasificacion as clasificacion_int,
							-- Traspaso Externo
							arext.numero AS no_dep_gen_ext,
							arext.descripcion AS dep_gen_ext,
							acext.numero AS no_dep_aux_ext,
							acext.descripcion AS dep_aux_ext,
							pext.numero AS no_proyecto_ext,
							pext.descripcion AS proyecto_ext,
							prext.numero AS no_programa_ext,
							prext.descripcion AS programa_ext,
							prext.objetivo AS obj_programa_ext,
							cpext.clasificacion AS clasificacion_ext,
							-- Datos Principales
							mm.numero AS no_municipio,
							mm.descripcion AS municipio,
							iu.logo_izq,
							iu.titular_uippe,
							iu.titular_tesoreria,
							iu.titular_egresos,
							iu.titular_prog_pres,
							iu.titular_secretario,
							ar.titular AS titular_dep_gen
						FROM 
							ui_teso_trans_int i
							-- Relaciones Transpaso Interno
							INNER JOIN ui_anio aa ON aa.idanio = i.idanio
							INNER JOIN ui_proyecto p ON p.idproyecto = i.idproyecto
								INNER JOIN ui_subprograma sp ON sp.idsubprograma = p.idsubprograma
								INNER JOIN ui_programa pr ON pr.idprograma = sp.idprograma
								INNER JOIN ui_clasificacion_programatica cp ON cp.idclasificacion_programatica = p.idclasificacion_programatica
							INNER JOIN ui_area_coordinacion ac ON ac.idarea_coordinacion = i.idarea_coordinacion
								INNER JOIN ui_area ar ON ar.idarea = ac.idarea
									INNER JOIN ui_instituciones iu ON iu.idinstituciones = ar.idinstituciones
										INNER JOIN ui_municipios mm ON mm.idmunicipios = iu.idmunicipios
							-- Relaciones Transpaso Externos
							INNER JOIN ui_proyecto pext ON pext.idproyecto = i.idproyecto_ext
								INNER JOIN ui_subprograma spext ON spext.idsubprograma = pext.idsubprograma
									INNER JOIN ui_programa prext ON prext.idprograma = spext.idprograma
								INNER JOIN ui_clasificacion_programatica cpext ON cpext.idclasificacion_programatica = pext.idclasificacion_programatica
							INNER JOIN ui_area_coordinacion acext ON acext.idarea_coordinacion = i.idarea_coordinacion_ext
								INNER JOIN ui_area arext ON arext.idarea = acext.idarea
						WHERE 
							i.idteso_trans_int = {$id}");
	}
	public static function getInfoTranspasoInternoIDRegistros($id){
		return DB::select("SELECT 
							f.clave AS no_ff,
							f.descripcion AS ff,
							e.clave AS d_partida,
							e2.clave AS a_partida,
							m.mes AS d_mes,
							m2.mes AS a_mes,
							r.importe
						FROM 
							ui_teso_trans_int_reg r
							-- Relación con fuentes de financieros (ff)
							INNER JOIN ui_teso_ff_n3 f ON f.idteso_ff_n3 = r.idteso_ff_n3
							-- Relación con partidas específicas (disminusion)
							INNER JOIN ui_teso_partidas_esp e ON e.idteso_partidas_esp = r.d_idteso_partidas_esp
							-- Relación con el mes (disminusion)
							INNER JOIN ui_mes m ON m.idmes = r.d_idmes
							-- Relación con partidas específicas (aumenta)
							INNER JOIN ui_teso_partidas_esp e2 ON e2.idteso_partidas_esp = r.a_idteso_partidas_esp
							-- Relación con el mes (aumenta)
							INNER JOIN ui_mes m2 ON m2.idmes = r.a_idmes
						WHERE 
							r.idteso_trans_int = {$id}");
	}
	public static function getRegistrosTranspasoInternoEdit($id){
		return DB::select("SELECT idteso_trans_int_reg as id, idteso_ff_n3, d_idteso_partidas_esp, d_idmes,importe, a_idteso_partidas_esp,a_idmes FROM ui_teso_trans_int_reg where idteso_trans_int = {$id}");
	}
	public static function getDepGenTranspasoExt($idi){
		return DB::select("SELECT ac.idarea_coordinacion as idac,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen FROM ui_area_coordinacion ac
		inner join ui_area a on a.idarea = ac.idarea
		where a.estatus = 1 and a.idinstituciones = {$idi} order by a.numero asc");
	}
	
	//Proyectoas activos de presupuesto definitivo, solo aplica para transpasos externos
	public static function getProyectosPresDefDepAuxExternos($idanio){
		return DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,c.clasificacion,r.idarea_coordinacion as idac FROM ui_pres_pbrm01a_reg r
		inner join ui_pres_pbrm01a pa on pa.idpres_pbrm01a = r.idpres_pbrm01a
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
		inner join ui_clasificacion_programatica c on c.idclasificacion_programatica = p.idclasificacion_programatica
		where pa.std_delete = 1 and r.idanio = {$idanio} order by p.numero asc");
	}




































	//16-06-2025
	public static function getProyectos($idy){
		return DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto,cp.clasificacion,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa FROM ui_proyecto p
		left join ui_clasificacion_programatica cp on cp.idclasificacion_programatica = p.idclasificacion_programatica
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			inner join ui_programa pr on pr.idprograma = sp.idprograma
		where p.idanio = ? and p.estatus = 1",[$idy]);
	}
	public static function getDepGen($idtd,$idy){
		return DB::select("SELECT iddep_gen as id,numero as no_dep_gen,descripcion as dep_gen FROM ui_dep_gen where idtipo_dependencias = ? and idanio = ?",[$idtd,$idy]);
	}
	public static function getDepAux($idtd,$idy){
		return DB::select("SELECT iddep_aux as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_dep_aux where idtipo_dependencias = ? and idanio = ?",[$idtd,$idy]);
	}
	public static function getFuenteFinanciamiento($idy){
		return DB::select("SELECT idteso_ff_n3 as id,clave,descripcion FROM ui_teso_ff_n3 where idanio = ? order by clave asc",[$idy]);
	}
	public static function getPartidasEspecificas($idy){
		return DB::select("SELECT idteso_partidas_esp as id,clave,nombre FROM ui_teso_partidas_esp where idanio = ?",[$idy]);
	}
	public static function getSearch($idam){
		return DB::select("SELECT ti.idteso_trans_int as id,ti.type,dg.numero as no_dep_gen,dg.descripcion as dep_gen,p.numero as no_proyecto,p.descripcion as proyecto,ti.justificacion,ti.fecha_rg,ti.hora_rg,
		ti.std_delete,da.numero as no_dep_aux,da.descripcion as dep_aux,i.importe,ti.number,ti.number_nota,ti.number_rec FROM ui_teso_trans_int ti
        inner join ui_dep_gen dg on dg.iddep_gen = ti.iddep_gen
		inner join ui_proyecto p on p.idproyecto = ti.idproyecto
		inner join ui_dep_aux da on da.iddep_aux = ti.iddep_aux
		left join (select sum(i1.importe) as importe,i1.idteso_trans_int from ui_teso_trans_int_reg i1 group by i1.idteso_trans_int) as i on i.idteso_trans_int = ti.idteso_trans_int
		where ti.idanio_module = ? order by ti.idteso_trans_int desc",[$idam]);
	}
	public static function getInfoTranspaso($idam){
		$result = DB::select("SELECT ti.iddep_gen,ti.iddep_aux,ti.idproyecto,ti.iddep_gen_ext,ti.iddep_aux_ext,ti.idproyecto_ext,
			dg.numero as no_dep_gen,dg.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,i.importe,p.numero as no_proyecto,p.descripcion as proyecto,ti.justificacion,
			pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,cp.clasificacion,
			dge.numero as no_dep_gen_ext,dge.descripcion as dep_gen_ext,dae.numero as no_dep_aux_ext,dae.descripcion as dep_aux_ext,pe.numero as no_proyecto_ext,pe.descripcion as proyecto_ext,
			pre.numero as no_programa_ext,pre.descripcion as programa_ext,pre.objetivo as obj_programa_ext,cpe.clasificacion as clasificacion_ext
				 FROM ui_teso_trans_int ti
				inner join ui_dep_gen dg on dg.iddep_gen = ti.iddep_gen
				inner join ui_proyecto p on p.idproyecto = ti.idproyecto
					inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
						inner join ui_programa pr on pr.idprograma = sp.idprograma
					left join ui_clasificacion_programatica cp on cp.idclasificacion_programatica = p.idclasificacion_programatica
				inner join ui_dep_aux da on da.iddep_aux = ti.iddep_aux
                
                inner join ui_dep_gen dge on dge.iddep_gen = ti.iddep_gen_ext
				inner join ui_proyecto pe on pe.idproyecto = ti.idproyecto_ext
					inner join ui_subprograma spe on spe.idsubprograma = pe.idsubprograma
						inner join ui_programa pre on pre.idprograma = spe.idprograma
					left join ui_clasificacion_programatica cpe on cpe.idclasificacion_programatica = pe.idclasificacion_programatica
				inner join ui_dep_aux dae on dae.iddep_aux = ti.iddep_aux_ext
                
				left join (select sum(i1.importe) as importe,i1.idteso_trans_int from ui_teso_trans_int_reg i1
				where i1.idteso_trans_int = {$idam} group by i1.idteso_trans_int) as i on i.idteso_trans_int = ti.idteso_trans_int
				where ti.idteso_trans_int = {$idam}");
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getInfoTranspasoInternoReg($idam){
		return DB::select("SELECT r.importe,n.clave no_ff,n.descripcion as ff,de.clave as d_partida,ae.clave as a_partida,md.mes as d_mes,ma.mes as a_mes FROM ui_teso_trans_int_reg r
		inner join ui_teso_ff_n3 n on n.idteso_ff_n3 = r.idteso_ff_n3
		inner join ui_teso_partidas_esp de on de.idteso_partidas_esp = r.d_idteso_partidas_esp
		inner join ui_teso_partidas_esp ae on ae.idteso_partidas_esp = r.a_idteso_partidas_esp
		inner join ui_mes md on md.idmes = d_idmes 
		inner join ui_mes ma on ma.idmes = a_idmes 
		where r.idteso_trans_int = ?",[$idam]);
	}
	public static function getEditTraspaso($id){
		$result = DB::select("SELECT iddep_gen,iddep_aux,idproyecto,iddep_gen_ext,iddep_aux_ext,idproyecto_ext,justificacion FROM ui_teso_trans_int where idteso_trans_int = ?",[$id]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getEditTraspasoReg($id){
		return DB::select("SELECT idteso_trans_int_reg as id,idteso_ff_n3,d_idteso_partidas_esp,d_idmes,a_idteso_partidas_esp,a_idmes,importe FROM ui_teso_trans_int_reg where idteso_trans_int = ?",[$id]);
	}
	public static function getPresupuestoProyecto($idam,$iddg,$idda,$idp){
		$result = DB::select("SELECT presupuesto FROM ui_teso_proyectos where idanio_module = ? and iddep_gen = ? and iddep_aux = ? and idproyecto = ?",[$idam,$iddg,$idda,$idp]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getFirmas($idi,$idy){
		$result = DB::select("SELECT logo_izq,logo_der,t_uippe,t_tesoreria,t_egresos,t_prog_pres,t_secretario,c_uippe,c_tesoreria,c_egresos,c_prog_pres,c_secretario FROM ui_instituciones_info where idinstituciones = ? and idanio = ?",[$idi,$idy]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
}
