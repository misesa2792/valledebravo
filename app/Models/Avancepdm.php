<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class avancepdm extends Sximo  {
	
	protected $table = 'ui_reporte';
	protected $primaryKey = 'idreporte';
	protected $moduleID = 5;
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
	
	public static function getProgramas($idy,$trim, $idi){
		return \DB::select("SELECT r.idreporte_programa as id,pr.idprograma,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pi.idpdm_pilares,pi.pilares,r.li_{$trim} as leyenda_indicador, r.lm_{$trim} as leyenda_meta FROM ui_reporte_programa r 
				inner join ui_programa pr on pr.idprograma = r.idprograma
					left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
		where r.idanio = {$idy} and r.idinstituciones = {$idi} order by pi.idpdm_pilares,pr.numero asc  ");
	}
	public static function getPeriodoAnio($idy){
		return \DB::select("SELECT p.descripcion as periodo FROM ui_anio a
		left join ui_periodo p on p.idperiodo = a.idperiodo
		where a.idanio = {$idy}");
	}
	public static function getProgramasID($id,$trim){
		return \DB::select("SELECT pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pi.pilares,r.li_{$trim} as leyenda_indicador, r.lm_{$trim} as leyenda_meta FROM ui_reporte_programa r 
			inner join ui_programa pr on pr.idprograma = r.idprograma
				left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
		where r.idreporte_programa = {$id}");
	}
	public static function getMetasPrograma($idy,$idp, $idi){
		return \DB::select("SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (SELECT r.idreporte,r.type,pr.idprograma,rg.no_accion,rg.unidad_medida,rg.descripcion as meta,rg.prog_anual,rg.trim_1,rg.trim_2,rg.trim_3,rg.trim_4,m.cant_1,m.cant_2,m.cant_3,m.cant_4 FROM ui_reporte r 
	inner join ui_proyecto p on p.idproyecto = r.idproyecto
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			inner join ui_programa pr on pr.idprograma = sp.idprograma
	inner join ui_reporte_reg rg on rg.idreporte = r.idreporte
	LEFT JOIN (
				SELECT 
					m.idreporte_reg,
					SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
					SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
					SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
					SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4
				FROM 
					ui_reporte_mes m
					INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
						INNER JOIN ui_reporte r1 on r1.idreporte = g.idreporte
				WHERE 
					r1.idanio = {$idy} and r1.idinstituciones = {$idi}
				GROUP BY 
					m.idreporte_reg
			) AS m ON m.idreporte_reg = rg.idreporte_reg
	where r.idanio = {$idy} and r.idinstituciones = {$idi} and pr.idprograma = {$idp} order by pr.numero asc ) AS info ");
	}

	public static function getRegPrograma($id, $trim){
		return \DB::select("SELECT idreporte_programa_reg as id,type,descripcion FROM ui_reporte_programa_reg where idreporte_programa = {$id} and trim = {$trim} order by type asc");
	}
	/*
		public static function getProgramaSincronizar($idy){
			return \DB::select("SELECT pr.idprograma,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pi.idpdm_pilares,pi.pilares FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			where r.idanio = {$idy} group by pr.idprograma order by pi.idpdm_pilares,pr.numero asc ");
		}
	*/
}
