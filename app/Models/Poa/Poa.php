<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class poa extends Model  {
	
	protected $table = 'ui_pd_pbrma';
	protected $primaryKey = 'idpd_pbrma';

	/*public static function getDepGen($idi, $idy){
		return DB::select("SELECT idarea as id,numero as no_dep_gen,descripcion as dep_gen,titular FROM ui_area where idinstituciones = ? and idanio = ? and estatus = 1",[$idi,$idy]);
	}*/
	public static function getDepAux($id){
		return DB::select("SELECT idarea_coordinacion as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_area_coordinacion where idarea = ? order by numero asc",[$id]);
	}
	public static function getProgramas($idy){
		return DB::select("SELECT p.idprograma as id, p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,pi.pilares,t.numero as no_tema,t.descripcion as tema_desarrollo,p.idpdm_pilares,pi.numero as no_pilar
		FROM ui_programa p
		left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		where p.idanio = ? and p.estatus = 1 order by p.numero asc",[$idy]);
	}
	public static function getProgramasMatricez($idy){
		return DB::select("SELECT p.idprograma as id,pm.no_matriz, p.numero as no_programa,p.descripcion as programa,p.objetivo as obj_programa,pi.pilares,t.numero as no_tema,t.descripcion as tema_desarrollo,p.idpdm_pilares,pi.numero as no_pilar
		FROM ui_programa p
        inner join ui_programa_matriz pm on pm.idprograma = p.idprograma
		left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		where p.idanio = ? and p.estatus = 1 order by p.numero asc",[$idy]);
	}
	public static function getProyectos($idy,$idp){
		return DB::select("SELECT p.idproyecto as id,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_proyecto as p
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
		where p.idanio = ? and p.estatus = 1 and sp.idprograma = ?",[$idy,$idp]);
	}
	public static function getTitularesFirmas($idi,$idy){
		$result = DB::select("SELECT i.logo_izq,i.logo_der,i.t_uippe,i.t_egresos,i.t_prog_pres,i.t_secretario,i.t_tesoreria,
			i.c_uippe,i.c_egresos,i.c_prog_pres,i.c_secretario,i.c_tesoreria,y.leyenda
			FROM ui_instituciones_info i 
			inner join ui_anio y on y.idanio = i.idanio
			where i.idinstituciones = {$idi} and i.idanio = {$idy}");
        return reset($result);
	}
	public static function getInfoModuleAnio($idi,$idy,$idm){
		$result = DB::select("SELECT i.denominacion as no_institucion, i.descripcion as institucion,y.anio,a.idanio_info,i.idtipo_dependencias FROM ui_anio_access a 
            inner join ui_anio y on y.idanio = a.idanio
            inner join ui_instituciones i on i.idinstituciones = a.idinstituciones
            where a.idinstituciones = ? and a.idanio = ? and a.idmodule = ? ", [$idi,$idy,$idm]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getCatTipoOperacion(){
		return DB::select("SELECT idtipo_operacion as id,descripcion as tipo_operacion FROM ui_tipo_operacion");
	}
	public static function getCatDimensionAtiende(){
		return DB::select("SELECT iddimension_atiende as id,descripcion as dimension FROM ui_dimension_atiende");
	}
	public static function getOds(){
		return DB::select("SELECT idods_metas as id,descripcion as meta FROM ui_ods_metas");
	}
	public static function getPlanDesarrolloMunicipal($idy, $idi){
		return DB::select("SELECT la.idpdm_pilares_lineas_accion as id,la.clave as no_linea_accion,la.descripcion as linea_accion FROM ui_pdm_pilares_anio pa
        inner join ui_pdm_pilares p on p.idpdm_pilares = pa.idpdm_pilares
            inner join ui_pdm_pilares_temas t on t.idpdm_pilares = p.idpdm_pilares
                inner join ui_pdm_pilares_subtemas s on s.idpdm_pilares_temas = t.idpdm_pilares_temas
                    inner join ui_pilares_objetivos o on o.idpdm_pilares_subtemas = s.idpdm_pilares_subtemas
                        inner join ui_pdm_pilares_estrategias e on e.idpilares_objetivos = o.idpilares_objetivos
                            inner join ui_pdm_pilares_lineas_accion la on la.idpdm_pilares_estrategias = e.idpdm_pilares_estrategias
        where pa.idanio = ? and s.idinstituciones = ? ", [$idy, $idi]);//and p.idpdm_pilares = ?
	}








	
	/*public static function getSearche($type,$idi,$idy){
		return DB::select("SELECT e.idpd_pbrme as id,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,e.url FROM ui_pd_pbrme e
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = e.idarea_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = e.idproyecto
		where e.type = {$type} and e.idinstituciones = {$idi} and e.idanio = {$idy} and e.std_delete = 1 order by a.numero,ac.numero asc ");
	}*/
	public static function getUsersActive($idi){
		return DB::select("SELECT u.id,g.name as nivel,u.username,u.first_name,u.last_name FROM tb_users u
		inner join tb_groups g on g.group_id = u.group_id
		where u.group_id in (2,3,4,5) and u.id NOT IN (100,2,62) and u.active = 1 and u.idinstituciones = ? order by u.group_id,u.username asc",[$idi]);
	}
	public static function getAccessUser($idmodule, $idy, $idu){
		return DB::table('ui_anio_permisos')
                    ->where('idmodule','=',$idmodule)
                    ->where('idanio','=',$idy)
                    ->where('iduser','=',$idu)
                    ->first();
	}
	public static function getUnidadMedidas(){
		return DB::table('ui_unidad_medida')
                    ->select('descripcion as um')
				->orderBy('descripcion', 'asc')
				->get();
	}
	public static function getUnidadMedidaExists($text){
		return DB::table('ui_unidad_medida')
        ->where('descripcion', $text)
        ->exists();
	}
	public static function getAccessDepGen($idu){
		return DB::table('ui_user_area as a')
		->join('ui_dep_gen as dg', 'dg.iddep_gen', '=', 'a.iddep_gen')
		->where('a.iduser', $idu)
		->select('dg.numero as no_dep_gen','dg.descripcion as dep_gen')
		->get();
	}



	public static function getTxtPbrma($type,$idy,$idi){
         return DB::select("CALL sp_pbrm_01a(?, ?, ?)", [$type, $idy, $idi]);
	}
	public static function getTxtPbrmc($type,$idy,$idi){
         return DB::select("CALL sp_pbrm_01c(?, ?, ?)", [$type, $idy, $idi]);
	}
    public static function getTxtPbrmb($type,$idy,$idi){
         return DB::select("CALL sp_pbrm_01b(?, ?, ?)", [$type, $idy, $idi]);
	}
	public static function getTxtPbrme($type,$idy,$idi){
         return DB::select("CALL sp_pbrm_01e(?, ?, ?)", [$type, $idy, $idi]);
	}
	public static function getTxtPbrmd($type,$idy,$idi){
         return DB::select("CALL sp_pbrm_01d(?, ?, ?)", [$type, $idy, $idi]);
	}
	public static function getTxtLineasAccion($ids){
		return DB::table('ui_pdm_pilares_lineas_accion as la')
			->join('ui_pdm_pilares_estrategias as e', 'e.idpdm_pilares_estrategias', '=', 'la.idpdm_pilares_estrategias')
				->join('ui_pilares_objetivos as o', 'o.idpilares_objetivos', '=', 'e.idpilares_objetivos')
			->whereIn('la.idpdm_pilares_lineas_accion', $ids)
			->select(
				'la.clave as no_la',
				'la.descripcion as name_la',
				'e.clave as no_est',
				'e.descripcion as name_est',
				'o.clave as no_obj',
				'o.descripcion as name_obj'
			)
			->get();
	}
	public static function getTxtOds($ids){
		return DB::table('ui_ods_metas as m')
			->join('ui_ods as o', 'o.idods', '=', 'm.idods')
			->whereIn('m.idods_metas', $ids)
			->select(
				'm.idods_metas',
				'o.idods',
				'm.descripcion as metas',
				'o.descripcion as objetivo'
			)
			->get();
	}




	//Catalogos generales para presupuesto
	public static function getDepGenGeneral($idtd, $idy){
		return DB::select("SELECT iddep_gen as id,numero as no_dep_gen,descripcion as dep_gen FROM ui_dep_gen where idtipo_dependencias = ? and idanio = ? order by numero asc",[$idtd, $idy]);
	}
	public static function getDepAuxGeneral($idtd, $idy){
		return DB::select("SELECT iddep_aux as id,numero as no_dep_aux,descripcion as dep_aux FROM ui_dep_aux where idtipo_dependencias = ? and idanio = ? order by numero asc",[$idtd, $idy]);
	}
	public static function getProyectosPorYear($idy){
		return DB::select("SELECT p.idproyecto as id,p.numero as no_proyecto,p.descripcion as proyecto,sp.idprograma FROM ui_proyecto as p
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
		where p.idanio = ? and p.estatus = 1 ORDER BY p.numero ASC",[$idy]);
	}
	public static function getFuenteFinanciamientoPorYear($idy){
		return DB::select("SELECT idteso_ff_n3 as id,clave,descripcion as financiamiento FROM ui_teso_ff_n3 where idanio = ? order by clave asc",[$idy]);
	}
	public static function getPartidasEspecificasPorYear($idy){
		return DB::select("SELECT idteso_partidas_esp as id, clave,nombre FROM ui_teso_partidas_esp where idanio = ? order by clave asc",[$idy]);
	}
}
