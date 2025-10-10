<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class suficienciapresupuestal extends Sximo  {
	
	protected $table = 'ui_teso_suficiencia_pres';
	protected $primaryKey = 'idteso_suficiencia_pres';
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
	public static function getRegistrosSolicitudPres($idac, $idy){
		return \DB::select("SELECT p.idteso_suficiencia_pres as id,p.type,p.fecha_elaboracion,pr.numero as no_proyecto,pr.descripcion as proyecto,
		p.observaciones,p.folio,p.fecha_requerida,p.number,f.clave as no_fuente,p.std_delete,p.fecha_rg FROM ui_teso_suficiencia_pres p 
		inner join ui_proyecto pr on pr.idproyecto = p.idproyecto
        inner join ui_teso_ff_n3 f on f.idteso_ff_n3 = p.idteso_ff_n3
		where p.idarea_coordinacion = {$idac} and p.idanio = {$idy}");
	}
	public static function getRegistrosSolicitudPresID($id){
		return \DB::select("SELECT ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,p.fecha_elaboracion,p.observaciones,
			p.subtotal,p.iva,p.total,pe.clave as no_partida,pe.nombre as partida,py.numero as no_proyecto,cp.clasificacion,ff.clave as no_fuente,ff.descripcion as fuente,p.fecha_requerida,
            i.titular_tesoreria,i.titular_egresos,i.titular_prog_pres,m.numero as no_municipio,aa.anio,p.fecha_servicio FROM ui_teso_suficiencia_pres p 
            inner join ui_anio aa on aa.idanio = p.idanio
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = p.idarea_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
					inner join ui_instituciones i on i.idinstituciones = a.idinstituciones
						inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			inner join ui_teso_partidas_esp pe on pe.idteso_partidas_esp = p.idteso_partidas_esp
			inner join ui_proyecto py on py.idproyecto = p.idproyecto
				inner join ui_clasificacion_programatica cp on cp.idclasificacion_programatica = py.idclasificacion_programatica
			inner join ui_teso_ff_n3 ff on ff.idteso_ff_n3 = p.idteso_ff_n3
			where p.idteso_suficiencia_pres = {$id}");
	}
	public static function getRegistrosSolicitudPresReg($id){
		return \DB::select("SELECT r.idteso_suficiencia_pres_reg as id,r.desc,r.unidad_medida,r.cantidad,r.costo,r.importe FROM ui_teso_suficiencia_pres_reg r where r.idteso_suficiencia_pres = {$id}");
	}
	public static function getListServicios(){
		return \DB::select("SELECT idteso_suficiencia_pres_ser as id,tipo,descripcion FROM ui_teso_suficiencia_pres_ser");
	}
	public static function getTiposServicios($id){
		return \DB::select("SELECT idteso_suficiencia_pres_veh as id,idteso_suficiencia_pres_ser as tipo,descripcion as servicios FROM ui_teso_suficiencia_pres_veh where idteso_suficiencia_pres = {$id}");
	}

	public static function getSuficienciaID($id){
		return \DB::select("SELECT y.anio,a.numero as no_dep_gen,a.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,m.numero as no_municipio,m.descripcion as municipio,
			p.fecha_requerida,p.fecha_servicio,p.observaciones as obs,p.idteso_ff_n3,p.idproyecto,p.idteso_partidas_esp,p.subtotal,p.iva,p.total,p.porc_iva FROM ui_teso_suficiencia_pres p
			inner join ui_area_coordinacion da on da.idarea_coordinacion = p.idarea_coordinacion
				inner join ui_area a on a.idarea = da.idarea
					inner join ui_municipios m on m.idmunicipios = a.idmunicipios
			inner join ui_anio y on y.idanio = p.idanio
		where p.idteso_suficiencia_pres = {$id}");
	}
	public static function getSuficienciaRegistrosID($id){
		return \DB::select("SELECT r.idteso_suficiencia_pres_reg as id,r.desc as nombre,r.unidad_medida,r.cantidad,r.costo, r.importe FROM ui_teso_suficiencia_pres_reg r
		where r.idteso_suficiencia_pres = {$id}");
	}

	public static function getSearchServicios($id, $ids){
		return \DB::select("SELECT idteso_suficiencia_pres_veh as id,descripcion FROM ui_teso_suficiencia_pres_veh 
		where idteso_suficiencia_pres = {$id} and idteso_suficiencia_pres_ser = {$ids}");
	}
}

