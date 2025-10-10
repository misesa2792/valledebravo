<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class graficas extends Sximo  {
	
	protected $table = 'ui_reporte';
	protected $primaryKey = 'idreporte';

	public function __construct() {
		parent::__construct();
	}
	//consultas para la grafica general
	public static function getGraficaMetasGeneral($idy,$type,$idi){
		return \DB::select("SELECT info.idarea,info.dep_gen,IFNULL(info.prog_anual,0) as prog_anual,IFNULL(info.cantidad,0) as cantidad FROM (SELECT a.idarea,a.descripcion as dep_gen,sum(reg.prog_anual) as prog_anual,sum(m.cant) as cantidad FROM ui_reporte_reg reg
		left join (select sum(m1.cantidad) as cant,m1.idreporte_reg from ui_reporte_mes m1 
						inner join ui_reporte_reg reg1 on reg1.idreporte_reg = m1.idreporte_reg
						inner join ui_reporte r1 on reg1.idreporte = r1.idreporte
						inner join ui_area_coordinacion ac1 on ac1.idarea_coordinacion = r1.id_area_coordinacion
						inner join ui_area a1 on a1.idarea = ac1.idarea
						where r1.idanio={$idy} and r1.type = {$type} and a1.idinstituciones={$idi} group by m1.idreporte_reg) m on m.idreporte_reg = reg.idreporte_reg
		inner join ui_reporte r on r.idreporte = reg.idreporte
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where r.idanio={$idy} and r.type = {$type} and a.idinstituciones={$idi} group by a.idarea
		) AS info
		");
	}
	//consultas para la grafica proyecto
	public static function getGraficaMetasProyectos($ida,$idy,$idi,$type){
		return \DB::select("SELECT r.idreporte,a.idarea,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proy,p.descripcion as proyecto FROM ui_reporte r
		inner join ui_area_coordinacion ac on r.id_area_coordinacion = ac.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
		where r.idanio={$idy} and r.type={$type} and r.idinstituciones = {$idi} and a.idarea = {$ida} and a.estatus = 1 order by ac.numero asc");
	}
	
}
