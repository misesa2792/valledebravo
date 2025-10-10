<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrme extends Model {

    protected $table = 'ui_pd_pbrme'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme'; // Clave primaria personalizada

    protected $fillable = [
        'type',
        'idinstituciones',
        'idanio',
        'idarea',
        'idarea_coordinacion',
        'idprograma',
        'idproyecto',
        'url',
        'iduser_rg',
        'std_delete',
        'no_matriz'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    public static function getMatrizPrograma($id, $no){
		return DB::select("SELECT r.*,f.descripcion as frecuencia,t.descripcion as tipo_indicador,SUBSTRING(ie.codigo,  9, 4) as mir,ie.indicador FROM ui_programa_reg r 
        left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = r.idfrecuencia_medicion
        left join ui_tipo_indicador t on t.idtipo_indicador = r.idtipo_indicador
        inner join ui_ind_estrategicos ie on ie.idind_estrategicos = r.idind_estrategicos
        where r.idprograma = ? and r.no_matriz = ?", [$id, $no]);
	}

    public static function getMatrizIds($id){
		return DB::select("SELECT r.idpd_pbrme_reg as id,m.idprograma_reg,m.tipo FROM ui_pd_pbrme_reg r
        inner join ui_programa_reg m on m.idprograma_reg = r.idprograma_reg
        where r.idpd_pbrme = ? and m.tipo in (3,4)", [$id]);
		//return DB::select("SELECT idpd_pbrme_matriz as id,idprograma_reg, tipo FROM ui_pd_pbrme_matriz where idpd_pbrme = ? and tipo in (3,4)", [$id]);
	}
    public static function getProgramaReg($id){
		$result = DB::select("SELECT r.*,ie.codigo,ie.indicador FROM ui_programa_reg r 
        inner join ui_ind_estrategicos ie on ie.idind_estrategicos = r.idind_estrategicos
        where r.idprograma_reg = ?", [$id]);
        return reset($result);
	}
    public static function getSearch($type, $id, $idy, $idi){
        return DB::select("SELECT idpd_pbrme as id,p.numero as no_programa,p.descripcion as programa,e.url FROM ui_pd_pbrme e
        inner join ui_programa p on p.idprograma = e.idprograma
        where e.type = ? and e.idinstituciones = ? and e.idanio = ? and e.idarea = ? and e.std_delete=1 order by p.numero asc",[$type, $idi, $idy, $id]);
        //old - se quita por que es por programa y no por proyecto
		return DB::select("SELECT idpd_pbrme as id,ac.numero as no_dep_aux,ac.descripcion as dep_aux,e.url,p.numero as no_programa,p.descripcion as programa,pr.numero as no_proyecto,pr.descripcion as proyecto FROM ui_pd_pbrme e
        inner join ui_proyecto pr on pr.idproyecto = e.idproyecto
            inner join ui_subprograma sp on sp.idsubprograma = pr.idsubprograma
                inner join ui_programa p on p.idprograma = sp.idprograma
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = e.idarea_coordinacion
        where e.type = ? and e.idinstituciones = ? and e.idanio = ? and ac.idarea = ? and e.std_delete=1 order by ac.numero,pr.numero asc",[$type, $idi, $idy, $id]);
	}
    public static function getSearchGeneral($type, $idy, $idi){
		return DB::select("SELECT idpd_pbrme as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,e.url,p.numero as no_programa,p.descripcion as programa,pr.numero as no_proyecto,pr.descripcion as proyecto FROM ui_pd_pbrme e
        inner join ui_proyecto pr on pr.idproyecto = e.idproyecto
            inner join ui_subprograma sp on sp.idsubprograma = pr.idsubprograma
                inner join ui_programa p on p.idprograma = sp.idprograma
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = e.idarea_coordinacion
			inner join ui_area dg on dg.idarea = ac.idarea
        where e.type = ? and e.idinstituciones = ? and e.idanio = ? and e.std_delete=1 order by dg.numero,ac.numero,pr.numero asc",[$type, $idi, $idy]);
	}
    public static function getSearchOld($idy, $ida){
		return DB::select("SELECT p.idproy_pbrm01e as id,g.numero as no_programa,g.descripcion as programa,p.url FROM ui_proy_pbrm01e p 
        inner join ui_programa g on g.idprograma = p.idprograma
        where p.idanio = ? and p.idarea = ? order by g.numero asc",[$idy, $ida]);
	}
    public static function getInfoRegistro($id){
		$result = DB::select("SELECT p.idprograma,a.numero as no_dep_gen,a.descripcion as dep_gen,
       p.idprograma,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,
        pi.pilares as pilar,pi.numero as no_pilar,t.numero as no_tema,t.descripcion as tema_desarrollo,i.denominacion as no_institucion,i.descripcion as institucion,
        a.titular,a.cargo,y.idanio,y.anio,e.no_matriz FROM ui_pd_pbrme e
		inner join ui_programa p on p.idprograma = e.idprograma
			left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
			left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		inner join ui_area a on a.idarea = e.idarea
        inner join ui_instituciones i on i.idinstituciones = e.idinstituciones
        inner join ui_anio y on y.idanio = e.idanio
        where e.idpd_pbrme = ?", [$id]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
    public static function getRowsMatrices($id){
        return DB::select("SELECT r.idpd_pbrme_reg as id,m.idprograma_reg,f.descripcion as frecuencia,t.descripcion as tipo_indicador,m.tipo,m.descripcion,SUBSTRING(ie.codigo,  9, 4) as mir,ie.indicador as nombre,m.formula,m.medios,m.supuestos FROM ui_pd_pbrme_reg r
        inner join ui_programa_reg m on m.idprograma_reg = r.idprograma_reg
			inner join ui_ind_estrategicos ie on ie.idind_estrategicos = m.idind_estrategicos
            left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
			left join ui_tipo_indicador t on t.idtipo_indicador = m.idtipo_indicador
        where r.idpd_pbrme = ?",[$id]);

		/*return DB::select("SELECT m.*,f.descripcion as frecuencia,t.descripcion as tipo_indicador FROM ui_pd_pbrme_matriz m
            inner join ui_pd_pbrme e on e.idpd_pbrme = m.idpd_pbrme
            left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
            left join ui_tipo_indicador t on t.idtipo_indicador = m.idtipo_indicador
        where m.idpd_pbrme = ? and e.no_matriz = ?",[$id, $no]);*/
	}
   /* public static function getIndicadoresReg($id){
		return DB::select("SELECT nombre_corto,nombre_largo FROM ui_ind_estrategicos_reg where idind_estrategicos = ?",[$id]);
	}*/
    /*public static function getSearchMatriz($id,$idpr){
		$result = DB::select("SELECT idpd_pbrme_matriz FROM ui_pd_pbrme_matriz where idpd_pbrme = ? and idprograma_reg = ?", [$id,$idpr]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
    public static function getSearchIndMatriz($id){
		return DB::select("SELECT idpd_pbrme_indicador FROM ui_pd_pbrme_indicador where idpd_pbrme_matriz = ?", [$id]);
	}*/
    public static function getValidatedRecord($type, $idi, $idy, $idarea, $idprograma){
		return DB::table('ui_pd_pbrme')
            ->where('type', $type)
            ->where('idinstituciones', $idi)
            ->where('idanio', $idy)
            ->where('idarea', $idarea)
            ->where('idprograma', $idprograma)
            ->where('std_delete', 1)
            ->exists();
	}
    
}
