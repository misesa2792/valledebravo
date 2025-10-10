<?php namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movil extends Model  {
	
	public static function getProyectos($idi, $idy, $type, $idarea){
		return DB::select("SELECT r.idreporte as idr,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_reporte r 
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
        inner join ui_proyecto p on p.idproyecto = r.idproyecto
        where r.idinstituciones = {$idi} and r.idanio = {$idy} and r.type = {$type} and idarea = {$idarea} order by ac.numero,p.numero asc");
	}
    public static function getEvidencia($id, $trim){
		return DB::select("SELECT rm.idreporte_mes as id,rm.idmes,m.mes,rm.cantidad, count(i.idreporte_mes) as total_img FROM ui_reporte_mes rm 
            inner join ui_mes m on m.idmes = rm.idmes
            left join ui_reporte_img i on i.idreporte_mes = rm.idreporte_mes
            where rm.idreporte_reg = {$id} and rm.idmes in ({$trim}) group by rm.idreporte_mes order by rm.idmes asc");
	}
    public static function getArchivos($id){
		return DB::select("SELECT idreporte_img as id,nombre,ext,
            CASE WHEN url LIKE './%'
                THEN SUBSTRING(url, 2)
                ELSE url
            END AS url FROM ui_reporte_img where idreporte_mes = {$id}");
	}
    public static function getMetas($idr,$idy,$idi){
		return DB::select("SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (SELECT rg.idreporte_reg as id,rg.no_accion,rg.unidad_medida,rg.descripcion as meta,rg.prog_anual as anual,rg.trim_1,rg.trim_2,rg.trim_3,rg.trim_4,m.cant_1,m.cant_2,m.cant_3,m.cant_4,rg.observaciones as obs1,rg.obs2,rg.obs3,rg.obs4 FROM ui_reporte r 
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
        where r.idreporte = {$idr} ) AS info");
	}

    public static function getProyectoID($idr){
		$result = DB::select("SELECT y.anio,a.numero as no_dep_gen,a.descripcion as dep_gen,a.titular,a.cargo,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,
        p.descripcion as proyecto,r.access_trim1 as a1,r.access_trim2 as a2, r.access_trim3 as a3,r.access_trim4 as a4 FROM ui_reporte r 
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
            inner join ui_area a on a.idarea = ac.idarea
        inner join ui_anio y on y.idanio = r.idanio
        inner join ui_proyecto p on p.idproyecto = r.idproyecto
        where r.idreporte = {$idr}");
        return reset($result);
	}
    public static function getYearID($idy){
		$result = DB::select("SELECT anio FROM ui_anio where idanio = {$idy}");
        return reset($result);
	}
    public static function getDepGenID($id){
		$result = DB::select("SELECT numero as no_dep_gen,descripcion as dep_gen,titular,cargo FROM ui_area where idarea = {$id}");
        return reset($result);
	}
    
}
