<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmd extends Model {

    protected $table = 'ui_pd_pbrme_matriz'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme_matriz'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrme',
        'idarea_coordinacion',
        'idproyecto',
        'idprograma_reg',
        'tipo',
        'descripcion',
        'mir',
        'nombre',
        'formula',
        'idfrecuencia_medicion',
        'idtipo_indicador',
        'medios',
        'supuestos',
        'idmir_formula',
        //PbRM-01d
        'd_estatus',
        'd_url',
        'd_porc1',
        'd_porc2',
        'd_porc3',
        'd_porc4',
        'd_porc_anual',
        'd_interpretacion',
        'iddimension_atiende',
        'd_factor',
        'd_factor_desc',
        'd_linea_base',
        'd_descripcion_meta',
        'd_metas_actividad',
        'd_aplica1',
        'd_aplica2',
        'd_aplica3',
        'd_aplica4',
        'd_idpd_pbrma_metas'
    ];
    
    public $timestamps = false;//Desactiva el created_at y updated_at

    //Eliimnar Indicadores
    public static function getDeleteIndicador($id){
        DB::table('ui_pd_pbrme_indicador')->where('idpd_pbrme_matriz', $id)->delete();
        return true;
	}
    public static function getIndicadores($id){
        return DB::select("SELECT m.idpd_pbrme_matriz as id,m.idprograma_reg,r.tipo,SUBSTRING(ie.codigo, 9, 4) as no_mir,ie.indicador,f.descripcion as frecuencia,
        fr.formula,m.d_estatus as estatus,m.d_url as url,m.d_aplica1 as aplica1,m.d_aplica2 as aplica2,m.d_aplica3 as aplica3,m.d_aplica4 as aplica4,
        p.numero as no_proyecto,p.descripcion as proyecto,ac.numero as no_dep_aux,ac.descripcion as dep_aux FROM ui_pd_pbrme_matriz m
           inner join ui_programa_reg r on r.idprograma_reg = m.idprograma_reg
				inner join ui_ind_estrategicos ie on ie.idind_estrategicos = r.idind_estrategicos
				inner join ui_frecuencia_medicion f on f.idfrecuencia_medicion = r.idfrecuencia_medicion
				left join ui_mir_formula fr on fr.idmir_formula = r.idmir_formula
            left join ui_proyecto p on p.idproyecto = m.idproyecto
            left join ui_area_coordinacion ac on ac.idarea_coordinacion = m.idarea_coordinacion
            where m.idpd_pbrme = ? order by r.tipo,ac.numero,p.numero asc",[$id]);

        //old
		return DB::select("SELECT m.idpd_pbrme_matriz as id,m.tipo,m.mir,SUBSTRING(m.mir, 9, 4) as no_mir,m.nombre as indicador,f.descripcion as frecuencia,
        fr.formula,m.d_estatus as estatus,m.d_url as url,m.d_aplica1 as aplica1,m.d_aplica2 as aplica2,m.d_aplica3 as aplica3,m.d_aplica4 as aplica4,p.numero as no_proyecto,ac.numero as no_dep_aux FROM ui_pd_pbrme_matriz m
            inner join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
            left join ui_mir_formula fr on fr.idmir_formula = m.idmir_formula
            left join ui_proyecto p on p.idproyecto = m.idproyecto
            left join ui_area_coordinacion ac on ac.idarea_coordinacion = m.idarea_coordinacion
            where m.idpd_pbrme = ?",[$id]);
	}
    public static function getInfoRegistro($id){
        $result = DB::select("SELECT m.idpd_pbrme_matriz as id,i.denominacion as no_institucion,i.descripcion as institucion,y.idanio,y.anio,m.idarea_coordinacion as idac,ac.numero as no_dep_aux,ac.descripcion as dep_aux,
        a.numero as no_dep_gen,a.descripcion as dep_gen,
        e.idprograma,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,t.numero as no_tema,t.descripcion as tema_desarrollo,pi.numero as no_pilar,pi.pilares as pilar,
        ind.codigo mir,ind.indicador,reg.idmir_formula as idformula,reg.formula,fr.formula as formula_corta,fe.descripcion as frecuencia,ti.descripcion as tipo_indicador,reg.medios,
        m.d_porc1,m.d_porc2,m.d_porc3,m.d_porc4,m.d_porc_anual,m.d_interpretacion,da.iddimension_atiende,da.descripcion as d_dimencion,m.d_factor,
        m.d_factor_desc,m.d_linea_base,m.d_descripcion_meta,m.d_metas_actividad,
        a.titular,a.cargo,m.idproyecto,pr.numero as no_proyecto,pr.descripcion as proyecto,
        m.d_aplica1,m.d_aplica2,m.d_aplica3,m.d_aplica4,d_idpd_pbrma_metas FROM ui_pd_pbrme_matriz m
        left join ui_dimension_atiende da on da.iddimension_atiende = m.iddimension_atiende
        inner join ui_pd_pbrme e on e.idpd_pbrme = m.idpd_pbrme
			inner join ui_area a on a.idarea = e.idarea	
            inner join ui_instituciones i on i.idinstituciones = e.idinstituciones
            inner join ui_anio y on y.idanio = e.idanio
            inner join ui_programa p on p.idprograma = e.idprograma
				left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
				left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = m.idarea_coordinacion
		left join ui_proyecto pr on pr.idproyecto = m.idproyecto
        inner join ui_programa_reg reg on reg.idprograma_reg  = m.idprograma_reg
			inner join ui_ind_estrategicos ind on ind.idind_estrategicos = reg.idind_estrategicos
			left join ui_mir_formula fr on fr.idmir_formula = reg.idmir_formula
			left join ui_frecuencia_medicion fe on fe.idfrecuencia_medicion = reg.idfrecuencia_medicion
            left join ui_tipo_indicador ti on ti.idtipo_indicador = reg.idtipo_indicador
        where m.idpd_pbrme_matriz = ?", [$id]);
		/*$result = DB::select("SELECT m.idpd_pbrme_matriz as id,i.denominacion as no_institucion,i.descripcion as institucion,y.idanio,y.anio,m.idarea_coordinacion as idac,ac.numero as no_dep_aux,ac.descripcion as dep_aux,
        a.numero as no_dep_gen,a.descripcion as dep_gen,
        e.idprograma,p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,t.numero as no_tema,t.descripcion as tema_desarrollo,pi.numero as no_pilar,pi.pilares as pilar,
        m.mir,m.nombre as indicador,m.idmir_formula as idformula,m.formula,fr.formula as formula_corta,fe.descripcion as frecuencia,ti.descripcion as tipo_indicador,m.medios,
        m.d_porc1,m.d_porc2,m.d_porc3,m.d_porc4,m.d_porc_anual,m.d_interpretacion,da.iddimension_atiende,da.descripcion as d_dimencion,m.d_factor,
        m.d_factor_desc,m.d_linea_base,m.d_descripcion_meta,m.d_metas_actividad,
        a.titular,a.cargo,m.idproyecto,pr.numero as no_proyecto,pr.descripcion as proyecto,
        m.d_aplica1,m.d_aplica2,m.d_aplica3,m.d_aplica4,d_idpd_pbrma_metas FROM ui_pd_pbrme_matriz m
        left join ui_dimension_atiende da on da.iddimension_atiende = m.iddimension_atiende
        inner join ui_pd_pbrme e on e.idpd_pbrme = m.idpd_pbrme
			inner join ui_area a on a.idarea = e.idarea	
            inner join ui_instituciones i on i.idinstituciones = e.idinstituciones
            inner join ui_anio y on y.idanio = e.idanio
            inner join ui_programa p on p.idprograma = e.idprograma
				left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
				left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		left join ui_area_coordinacion ac on ac.idarea_coordinacion = m.idarea_coordinacion
		left join ui_proyecto pr on pr.idproyecto = m.idproyecto
        left join ui_mir_formula fr on fr.idmir_formula = m.idmir_formula
        left join ui_frecuencia_medicion fe on fe.idfrecuencia_medicion = m.idfrecuencia_medicion
        left join ui_tipo_indicador ti on ti.idtipo_indicador = m.idtipo_indicador
        where m.idpd_pbrme_matriz = ?", [$id]);*/
        return reset($result);
	}
    public static function getSearchOld($idy, $ida){
		return DB::select("SELECT d.idproy_pbrm01d as id,ac.idarea,ac.numero as no_dep_aux,ac.descripcion as dep_aux,pr.numero as no_programa,pr.descripcion as programa,d.mir,d.nombre_indicador,d.frecuencia,p.numero as no_proyecto,p.descripcion as proyecto,d.url FROM ui_proy_pbrm01d d 
        inner join ui_area_coordinacion ac on ac.idarea_coordinacion = d.idarea_coordinacion
        left join ui_programa pr on pr.idprograma = d.idprograma
        left join ui_proyecto p on p.idproyecto = d.idproyecto
        where d.idanio = ? and ac.idarea = ? order by ac.numero asc",[$idy, $ida]);
	}
    public static function getIndicadoresMatriz($id){
		return DB::select("SELECT i.idpd_pbrme_indicador as id,i.nombre_corto,i.nombre_largo,i.unidad_medida,i.idtipo_operacion,i.trim1,i.trim2,i.trim3,i.trim4,i.anual,t.descripcion as tipo_operacion FROM ui_pd_pbrme_indicador i 
        left join ui_tipo_operacion t on t.idtipo_operacion = i.idtipo_operacion
        where i.idpd_pbrme_matriz = ?",[$id]);
	}
    public static function getMetas($type, $idi, $idy){
		return DB::select("SELECT m.idpd_pbrma_metas as id,dg.numero as no_dep_gen,p.numero as no_proyecto,ac.numero as no_dep_aux,m.codigo,m.meta FROM ui_pd_pbrma a
		inner join ui_area dg on dg.idarea = a.idarea
        inner join ui_pd_pbrma_aux x on x.idpd_pbrma = a.idpd_pbrma
            inner join ui_pd_pbrma_metas m on m.idpd_pbrma_aux = x.idpd_pbrma_aux
            inner join ui_area_coordinacion ac on ac.idarea_coordinacion = x.idarea_coordinacion
            inner join ui_proyecto p on p.idproyecto = x.idproyecto
        where a.type = ? and a.idinstituciones = ? and a.idanio = ? and a.std_delete = 1 order by dg.numero,p.numero,m.codigo asc",[$type, $idi, $idy]);
	}
    public static function getInfoPbrmd($id){
		$result = DB::select("SELECT SUBSTRING(ie.codigo, 9, 4) as mir,ie.indicador,e.idprograma,ac.idarea_coordinacion as idac,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.idproyecto,p.numero as no_proyecto,
        p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa FROM ui_pd_pbrme_matriz m
        inner join ui_programa_reg reg on reg.idprograma_reg = m.idprograma_reg
			inner join ui_ind_estrategicos ie on ie.idind_estrategicos = reg.idind_estrategicos
        inner join ui_pd_pbrme e on e.idpd_pbrme = m.idpd_pbrme
            inner join ui_programa pr on pr.idprograma = e.idprograma
			inner join ui_area a on a.idarea = e.idarea 
        left join ui_area_coordinacion ac on ac.idarea_coordinacion = m.idarea_coordinacion
        left join ui_proyecto p on p.idproyecto = m.idproyecto
        where m.idpd_pbrme_matriz = ?", [$id]);
        return reset($result);
	}
    public static function getRowsProyectosPrograma($id){
		return DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proyecto p
            inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
            where sp.idprograma = ?", [$id]);
	}
    public static function getRowsIndicadores($id){
		return DB::select("SELECT ind.idind_estrategicos_reg as id,ind.nombre_corto,ind.nombre_largo FROM ui_programa_reg r 
        inner join ui_ind_estrategicos ie on ie.idind_estrategicos = r.idind_estrategicos
            inner join ui_ind_estrategicos_reg ind on ind.idind_estrategicos = ie.idind_estrategicos
        where r.idprograma_reg = ?", [$id]);
	}
    public static function getValidatedRecordProject($id, $idpr){
		return DB::table('ui_pd_pbrme_matriz')
            ->where('idpd_pbrme', $id)
            ->where('idprograma_reg', $idpr)
            ->exists();
	}
    public static function getValidatedRecordMatriz($id, $idpr){
		return DB::table('ui_pd_pbrme_reg')
            ->where('idpd_pbrme', $id)
            ->where('idprograma_reg', $idpr)
            ->exists();
	}
    public static function getValidatedRecordMatrizProject($id, $idpr, $idp, $idac){
		return DB::table('ui_pd_pbrme_matriz')
            ->where('idpd_pbrme', $id)
            ->where('idarea_coordinacion', $idac)
            ->where('idproyecto', $idp)
            ->where('idprograma_reg', $idpr)
            ->exists();
	}
}