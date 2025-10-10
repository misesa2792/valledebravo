<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;

class avanceacciones extends Sximo  {
	
	protected $table = 'ui_pdm_pilares_pbrm';
	protected $primaryKey = 'idpdm_pilares_pbrm';

	
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

	static function getInfoMeta($id){
		$result = DB::select("SELECT rr.no_accion as no_meta,rr.descripcion as meta,pm.clave as no_meta_pdm,pm.descripcion as meta_pdm,la.clave as no_linea_accion,la.descripcion as linea_accion,pi.pilares FROM ui_pdm_pilares_pbrm pb
		inner join ui_pdm_pilares_metas pm on pm.idpdm_pilares_metas = pb.idpdm_pilares_metas
			inner join ui_pdm_pilares_lineas_accion la on la.idpdm_pilares_lineas_accion = pm.idpdm_pilares_lineas_accion
				inner join ui_pdm_pilares_estrategias pe on pe.idpdm_pilares_estrategias = la.idpdm_pilares_estrategias
					inner join ui_pilares_objetivos po on po.idpilares_objetivos = pe.idpilares_objetivos
						inner join ui_pdm_pilares_subtemas ps on ps.idpdm_pilares_subtemas = po.idpdm_pilares_subtemas
							inner join ui_pdm_pilares_temas pt on pt.idpdm_pilares_temas = ps.idpdm_pilares_temas
								inner join ui_pdm_pilares pi on pi.idpdm_pilares = pt.idpdm_pilares
		inner join ui_reporte_reg rr on rr.idreporte_reg = pb.idreporte_reg
		where pb.idpdm_pilares_pbrm = ?",[$id]);
		return reset($result);
	}
	
}
