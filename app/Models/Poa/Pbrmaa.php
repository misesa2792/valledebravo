<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmaa extends Model {
    
    protected $table = 'ui_pd_pbrma_metas'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrma_metas'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrma_aux',
        'codigo',
        'meta',
        'unidad_medida',
        'c_programado',
        'c_alcanzado',
        'c_anual',
        'c_absoluta',
        'c_porcentaje',
        'aa_anual',
        'aa_trim1',
        'aa_trim2',
        'aa_trim3',
        'aa_trim4',
        'aa_porc1',
        'aa_porc2',
        'aa_porc3',
        'aa_porc4'
    ]; // Campos que se pueden llenar masivamente (mass assignable)
    public static function getSearchGeneral($type,$idy,$idi){
		return DB::select("SELECT c.idpd_pbrma_aux as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.c_estatus,c.aa_estatus,c.aa_url FROM ui_pd_pbrma a 
	    inner join ui_area dg on dg.idarea = a.idarea
        inner join ui_pd_pbrma_aux c on c.idpd_pbrma = a.idpd_pbrma
            inner join ui_area_coordinacion da on da.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where a.type = ? and a.idanio = ? and a.idinstituciones = ? and a.std_delete = 1 order by dg.numero,da.numero,p.numero asc",[$type,$idy,$idi]);
	}
    public static function getSearch($type,$ida,$idy,$idi){
		return DB::select("SELECT c.idpd_pbrma_aux as id,da.numero as no_dep_aux,da.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.c_estatus,c.aa_estatus,c.aa_url FROM ui_pd_pbrma a 
        inner join ui_pd_pbrma_aux c on c.idpd_pbrma = a.idpd_pbrma
            inner join ui_area_coordinacion da on da.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where a.type = ? and a.idarea = ? and a.idanio = ? and a.idinstituciones = ? and a.std_delete = 1 order by da.numero,p.numero asc",[$type,$ida,$idy,$idi]);
	}
    public static function getSearchOld($idy,$ida){
		return DB::select("SELECT c.idproy_pbrm02a as id,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,c.url FROM ui_proy_pbrm02a c
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
            inner join ui_area a on a.idarea = ac.idarea
        inner join ui_proyecto p on p.idproyecto = c.idproyecto
        where c.idanio = ? and a.idarea = ? order by a.numero,ac.numero asc",[$idy,$ida]);
	}
    public static function getMetas($id){
		return DB::select("SELECT idpd_pbrma_metas as id,codigo,meta,unidad_medida,c_anual,aa_anual,aa_trim1,aa_trim2,aa_trim3,aa_trim4,aa_porc1,aa_porc2,aa_porc3,aa_porc4 FROM ui_pd_pbrma_metas
        where idpd_pbrma_aux = ?", [$id]);
	}
}
