<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrma extends Model {
    
    protected $table = 'ui_pd_pbrma'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrma'; // Clave primaria personalizada

    protected $fillable = [
        'type',
        'idinstituciones',
        'idanio',
        'iddep_gen',
        'idarea',
        'idprograma',
        'presupuesto',
        'url',
        'iduser_rg',
        'std_delete'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    
    //Busqueda General
    public static function getSearchGeneral($type,$idy,$idi){
		return DB::select("SELECT d.idpd_pbrma as id,dg.idarea,dg.numero as no_dep_gen,dg.descripcion as dep_gen,p.numero as no_programa,p.descripcion as programa,sum(a.presupuesto) as total,d.url FROM ui_pd_pbrma d
        inner join ui_area dg on dg.idarea = d.idarea
        left join ui_pd_pbrma_aux a on a.idpd_pbrma = d.idpd_pbrma
            INNER JOIN ui_programa p on p.idprograma = d.idprograma
                where d.type = ? and d.idanio = ? and d.idinstituciones = ? and d.std_delete = 1 group by a.idpd_pbrma ORDER BY dg.numero,p.numero ASC",[$type,$idy,$idi]);
	}
    //Busqueda Individual
    public static function getSearch($type,$id,$idy,$idi){
		return DB::select("SELECT d.idpd_pbrma as id,p.numero as no_programa,p.descripcion as programa,sum(a.presupuesto) as total,d.url FROM ui_pd_pbrma d
        left join ui_pd_pbrma_aux a on a.idpd_pbrma = d.idpd_pbrma
            INNER JOIN ui_programa p on p.idprograma = d.idprograma
                where d.type = ? and d.idarea = ? and d.idanio = ? and d.idinstituciones = ? and d.std_delete = 1 group by a.idpd_pbrma ORDER BY p.numero ASC",[$type,$id,$idy,$idi]);
	}

    public static function getSearchOld($idy,$id){
		return DB::select("SELECT p.idproy_pbrm01a as id,g.numero as no_programa,g.descripcion as programa,p.total,p.url FROM ui_proy_pbrm01a p 
        inner join ui_programa g on g.idprograma = p.idprograma
        where p.idanio = ? and p.idarea = ? order by g.numero asc",[$idy,$id]);
	}
    public static function getInfoRegistro($id){
		$result = DB::select("SELECT p.idprograma,p.numero as no_programa,p.descripcion as programa,sum(ax.presupuesto) as total,d.numero as no_dep_gen,d.descripcion as dep_gen,i.denominacion as no_institucion,
        i.descripcion as institucion,y.idanio,y.anio,
        d.titular,d.cargo FROM ui_pd_pbrma a
        left join ui_pd_pbrma_aux ax on ax.idpd_pbrma = a.idpd_pbrma
        inner join ui_area d on d.idarea = a.idarea
		INNER JOIN ui_instituciones i on i.idinstituciones = a.idinstituciones
		INNER JOIN ui_anio y on y.idanio = a.idanio
		inner join ui_programa p on p.idprograma = a.idprograma
        where a.idpd_pbrma = ? group by a.idpd_pbrma", [$id]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
    public static function getInfoRegistroAux($id){
		return DB::select("SELECT a.idpd_pbrma_aux as id,a.idarea_coordinacion,a.idproyecto,
        da.numero as no_dep_aux,da.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,a.presupuesto FROM ui_pd_pbrma_aux a
        inner join ui_area_coordinacion da on da.idarea_coordinacion = a.idarea_coordinacion
        inner join ui_proyecto p on p.idproyecto = a.idproyecto
        where a.idpd_pbrma = ? order by da.numero,p.numero asc", [$id]);
	}
    public static function getProgramExists($type, $idi, $idy, $ida, $idp){
		return DB::table('ui_pd_pbrma')
        ->where('type', $type)
        ->where('idinstituciones', $idi)
        ->where('idanio', $idy)
        ->where('idarea', $ida)
        ->where('idprograma', $idp)
        ->where('std_delete', 1)
        ->exists();
	}
    public static function getDepAuxID($id){
		return DB::table('ui_area_coordinacion')
            ->where('idarea_coordinacion', $id)
            ->select('iddep_aux')
            ->first();
	}
    public static function getSumPresupuesto($id)
    {
        return DB::table('ui_pd_pbrma_aux')
            ->where('idpd_pbrma', $id)
            ->sum('presupuesto');
    }

   
}
