<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmb extends Model {
    
    protected $table = 'ui_pd_pbrmb'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrmb'; // Clave primaria personalizada

    protected $fillable = [
        'type',
        'idinstituciones',
        'idanio',
        'idarea',
        'idprograma',
        'fortalezas',
        'oportunidades',
        'debilidades',
        'amenazas',
        'estrategias',
        'lineas_accion',
        'ods',
        'url',
        'iduser_rg',
        'std_delete'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    public static function getSearch($type, $ida, $idy, $idi){
		return DB::select("SELECT b.idpd_pbrmb as id,p.numero as no_programa,p.descripcion as programa,b.url FROM ui_pd_pbrmb b
            INNER JOIN ui_programa p on p.idprograma = b.idprograma
            where b.type = ? and b.idarea = ? and b.idanio = ? and b.idinstituciones = ? and b.std_delete = 1 ORDER BY p.numero ASC ",[$type, $ida, $idy, $idi]);
	}
    public static function getSearchGeneral($type, $idy, $idi){
		return DB::select("SELECT b.idpd_pbrmb as id,a.numero as no_dep_gen,a.descripcion as dep_gen,p.numero as no_programa,p.descripcion as programa,b.url FROM ui_pd_pbrmb b
            INNER JOIN ui_programa p on p.idprograma = b.idprograma
            INNER JOIN ui_area a on a.idarea = b.idarea
            where b.type = ? and b.idanio = ? and b.idinstituciones = ? and b.std_delete = 1 ORDER BY a.numero,p.numero ASC ",[$type, $idy, $idi]);
	}
    public static function getSearchOld($idy, $ida){
		return DB::select("SELECT p.idproy_pbrm01b as id,g.numero as no_programa,g.descripcion as programa,p.url FROM ui_proy_pbrm01b p 
            inner join ui_programa g on g.idprograma = p.idprograma
            where p.idanio = ? and p.idarea = ? order by g.numero asc ",[$idy, $ida]);
	}
    public static function getInfoRegistro($id){
		$result = DB::select("SELECT d.numero as no_dep_gen, d.descripcion as dep_gen, i.denominacion as no_institucion, i.descripcion as institucion,y.idanio, y.anio,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,
        b.fortalezas,b.oportunidades,b.debilidades,b.amenazas,b.estrategias,b.lineas_accion,b.ods,d.titular,d.cargo
        FROM ui_pd_pbrmb b 
        inner join ui_programa pr on pr.idprograma = b.idprograma
        inner join ui_area d on d.idarea = b.idarea
		INNER JOIN ui_instituciones i on i.idinstituciones = b.idinstituciones
		INNER JOIN ui_anio y on y.idanio = b.idanio
        WHERE b.idpd_pbrmb = ?", [$id]);
        return reset($result);
	}
    public static function getLineasAccion($id){
		return DB::select("SELECT la.clave as no_linea_accion,la.descripcion as linea_accion,e.clave as no_estrategia,e.descripcion as estrategia,
        o.clave as no_objetivo,o.descripcion as objetivo FROM ui_pdm_pilares_lineas_accion la 
        inner join ui_pdm_pilares_estrategias e on e.idpdm_pilares_estrategias = la.idpdm_pilares_estrategias
            inner join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
        where la.idpdm_pilares_lineas_accion in ({$id})");
	}
    public static function getMetasODS($id){
		return DB::select("SELECT m.descripcion as meta,o.descripcion as ods,o.idods,m.idods_metas FROM ui_ods_metas m
        inner join ui_ods o on o.idods = m.idods
        where m.idods_metas in ({$id})");
	}
    public static function getValidatedRecord($type, $idi, $idy, $ida, $idp){
		return DB::table('ui_pd_pbrmb')
            ->where('type', $type)
            ->where('idinstituciones', $idi)
            ->where('idanio', $idy)
            ->where('idarea', $ida)
            ->where('idprograma', $idp)
            ->where('std_delete', 1)
            ->exists();
	}
}
