<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan extends Model {
    
    protected $table = 'ui_pd_plan'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_plan'; // Clave primaria personalizada

    protected $fillable = [
        'type',
        'idinstituciones',
        'idanio',
        'idarea',
        'idprograma',
        'total_year1',
        'total_year2',
        'total_year3',
        'total_presupuesto',
        'std_apdm',
        'std_arpppdm',
        'std_pmpdm',
        'a_idods',
        'a_meta_nacional',
        'a_obj_plan_nacional',
        'a_obj_plan_estado',
        'a_estrategias',
        'a_idlineas_accion',
        'iduser_rg',
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    public static function getProgramasARPPDM($type, $idi, $idy){
		return DB::select("SELECT a.idpd_pbrma as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,p.numero as no_programa,p.descripcion as programa,a.presupuesto FROM ui_pd_pbrma a
        inner join ui_area dg on dg.idarea = a.idarea
        inner join ui_programa p on p.idprograma = a.idprograma
        where a.type = ? and a.idinstituciones = ? and a.idanio = ? and a.std_delete = 1 order by dg.numero asc", [$type, $idi, $idy]);
	}
    public static function getProgramasPMPDM($type, $idi, $idy){
		return DB::select("SELECT m.idpd_pbrma_metas as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,p.numero as no_programa,p.descripcion as programa,m.codigo,m.meta,aa_anual FROM ui_pd_pbrma a
        inner join ui_area dg on dg.idarea = a.idarea
        inner join ui_programa p on p.idprograma = a.idprograma
        inner join ui_pd_pbrma_aux pa on pa.idpd_pbrma = a.idpd_pbrma
			inner join ui_pd_pbrma_metas m on m.idpd_pbrma_aux = pa.idpd_pbrma_aux
        where a.type =? and a.idinstituciones = ? and a.idanio = ? and a.std_delete = 1 order by dg.numero,p.numero asc", [$type, $idi, $idy]);
	}



    public static function getProgramas($type, $idi, $idy, $ida){
		return DB::select("SELECT p.idpd_plan as id,p.idprograma,pr.numero as no_programa,pr.descripcion as programa,p.std_apdm,
        p.std_arpppdm,p.std_pmpdm FROM ui_pd_plan p
        inner join ui_programa pr on pr.idprograma = p.idprograma
        where p.type = ? and p.idinstituciones = ? and p.idanio = ? and p.idarea = ?", [$type, $idi, $idy, $ida]);
	}
    public static function getRegistros($id, $idi){
		$result = DB::select("SELECT pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pi.pilares as pilar,
        pi.no_tipo as tipo_pilar,y.anio,i.denominacion as no_institucion,i.descripcion as institucion,a.numero as no_dep_gen,a.descripcion as dep_gen,
        p.total_year1,p.total_year2,p.total_year3,p.total_presupuesto,
        p.a_idods,p.a_meta_nacional,p.a_obj_plan_nacional,p.a_obj_plan_estado,p.a_estrategias,p.a_idlineas_accion FROM ui_pd_plan p
        inner join ui_programa pr on pr.idprograma = p.idprograma
            left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
        inner join ui_anio y on y.idanio = p.idanio
        inner join ui_instituciones i on i.idinstituciones = p.idinstituciones
        inner join ui_area a on a.idarea = p.idarea
        where p.idpd_plan = ? and p.idinstituciones = ?", [$id, $idi]);
         return reset($result); 
	}
}
