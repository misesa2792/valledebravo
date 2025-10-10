<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmc extends Model {
    
    protected $table = 'ui_pd_pbrma_aux'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrma_aux'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrma',
        'iddep_aux',
        'idarea_coordinacion',
        'idproyecto',
        'presupuesto',
        'c_estatus',
        'c_url',
        'aa_estatus',
        'aa_url'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    public static function getSearch($type,$ida,$idy,$idi){
		return DB::select("SELECT c.idpd_pbrma_aux as id,da.numero as no_dep_aux,da.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.presupuesto,c.c_estatus,c.c_url FROM ui_pd_pbrma a 
        inner join ui_pd_pbrma_aux c on c.idpd_pbrma = a.idpd_pbrma
            inner join ui_area_coordinacion da on da.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where a.type = ? and a.idarea = ? and a.idanio = ? and a.idinstituciones = ? and a.std_delete = 1 order by da.numero,p.numero asc",[$type,$ida,$idy,$idi]);
	}
    public static function getSearchGeneral($type,$idy,$idi){
		return DB::select("SELECT c.idpd_pbrma_aux as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.presupuesto,c.c_estatus,c.c_url FROM ui_pd_pbrma a 
        inner join ui_area dg on dg.idarea = a.idarea
        inner join ui_pd_pbrma_aux c on c.idpd_pbrma = a.idpd_pbrma
            inner join ui_area_coordinacion da on da.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where a.type = ? and a.idanio = ? and a.idinstituciones = ? and a.std_delete = 1 order by dg.numero,da.numero,p.numero asc",[$type,$idy,$idi]);
	}
    public static function getSearchOld($idy,$ida){
		return DB::select("SELECT c.idproy_pbrm01c as id,a.idarea,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.total as presupuesto,c.url FROM ui_proy_pbrm01c c
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_area a on a.idarea = ac.idarea
        inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where c.idanio = ? and a.idarea = ? order by a.numero,ac.numero asc",[$idy,$ida]);
	}
    public static function getInfoPbrmC($id){
		$result = DB::select("SELECT dep.numero as no_dep_gen,dep.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,
            p.numero as no_proyecto,p.descripcion as proyecto,p.objetivo as obj_proyecto,pr.numero as no_programa,pr.descripcion as programa,aux.presupuesto,
            i.denominacion as no_institucion,i.descripcion as institucion,
            y.idanio,y.anio,dep.titular,dep.cargo FROM ui_pd_pbrma_aux aux
            inner join ui_proyecto p on p.idproyecto = aux.idproyecto
            inner join ui_area_coordinacion da on da.idarea_coordinacion = aux.idarea_coordinacion
            inner join ui_pd_pbrma pa on pa.idpd_pbrma = aux.idpd_pbrma
                inner join ui_area dep on dep.idarea = pa.idarea
				inner join ui_instituciones i on i.idinstituciones = pa.idinstituciones
				inner join ui_anio y on y.idanio = pa.idanio
                inner join ui_programa pr on pr.idprograma = pa.idprograma
        where aux.idpd_pbrma_aux  = ?", [$id]);
        return reset($result);
	}
    public static function getMetas($id){
		return DB::select("SELECT idpd_pbrma_metas as id,codigo,meta,unidad_medida,c_programado as programado,c_alcanzado as alcanzado,c_anual as anual,c_absoluta as absoluta,c_porcentaje as porcentaje FROM ui_pd_pbrma_metas
        where idpd_pbrma_aux = ?", [$id]);
	}
}
