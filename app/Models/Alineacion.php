<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class alineacion extends Sximo  {
	
	protected $table = 'ui_pdm_pilares';
	protected $primaryKey = 'idpdm_pilares';

	public function __construct() {
		parent::__construct();	
	}
	public static function getExportarAlineacionMetas($idp, $ida, $idi,$tipo,$access=null){
		if($tipo == "admin"){
			$adicional = "";
		}elseif($tipo == "enlace"){
			$adicional = " and aco.idarea_coordinacion in ({$access}) ";
		}else{
			$adicional = "";
		}
		return DB::select("SELECT info.* FROM (SELECT l.idpdm_pilares_lineas_accion as id,l.clave as clave_lin,l.descripcion as linea_accion,e.clave as clave_est,e.descripcion as estrategia,
		o.clave as clave_obj,o.descripcion as objetivo,s.descripcion as subtema,t.descripcion as tema,p.pilares,pa.comentarios as informe_gobierno,
        reg.descripcion as meta,prog.numero as no_programa,prog.descripcion as programa,
        pro.numero no_proyecto,pro.descripcion as proyecto,aco.numero as no_dep_aux,aco.descripcion as dep_aux,ar.numero as no_dep_gen,ar.descripcion as dep_gen,uii.descripcion as institucion FROM ui_pdm_pilares_lineas_accion l
		inner join ui_pdm_pilares_estrategias e on e.idpdm_pilares_estrategias = l.idpdm_pilares_estrategias
		inner join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
		inner join ui_pdm_pilares_subtemas s on s.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		inner join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = s.idpdm_pilares_temas
		inner join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
        inner join ui_pdm_alineacion pa on pa.idpdm_pilares_lineas_accion = l.idpdm_pilares_lineas_accion
        inner join ui_reporte_reg reg on pa.idreporte_reg = reg.idreporte_reg
        inner join ui_reporte rep on rep.idreporte = reg.idreporte
        inner join ui_proyecto pro on pro.idproyecto = rep.idproyecto
        inner join ui_subprograma sub on sub.idsubprograma = pro.idsubprograma
        inner join ui_programa prog on prog.idprograma = sub.idprograma
        inner join ui_area_coordinacion aco on aco.idarea_coordinacion = rep.id_area_coordinacion
        inner join ui_area ar on ar.idarea = aco.idarea
        inner join ui_instituciones uii on uii.idinstituciones = ar.idinstituciones
		where p.idperiodo ={$idp} and rep.idanio={$ida} and uii.idinstituciones ={$idi}) info where info.informe_gobierno != ''");
	}
	public static function getExportarAlineacionActrelevantes($idp, $ida, $idi,$tipo,$iduser=null){
		if($tipo == "admin"){
			$adicional = "";
		}elseif($tipo == "enlace"){
			$adicional = " and aar.iduser_rg in ({$iduser}) ";
		}else{
			$adicional = " and aar.iduser_rg in ({$iduser}) ";
		}
		return DB::select("SELECT info.* FROM (SELECT l.idpdm_pilares_lineas_accion as id,l.clave as clave_lin,l.descripcion as linea_accion,e.clave as clave_est,e.descripcion as estrategia,
		o.clave as clave_obj,o.descripcion as objetivo,s.descripcion as subtema,t.descripcion as tema,p.pilares,
        uii.descripcion as institucion,aar.comentarios as informe_gobierno FROM ui_pdm_pilares_lineas_accion l
		inner join ui_pdm_pilares_estrategias e on e.idpdm_pilares_estrategias = l.idpdm_pilares_estrategias
		inner join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
		inner join ui_pdm_pilares_subtemas s on s.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		inner join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = s.idpdm_pilares_temas
		inner join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
        inner join ui_pdm_alineacion_ar aar on aar.idpdm_pilares_lineas_accion = l.idpdm_pilares_lineas_accion
        inner join ui_instituciones uii on uii.idinstituciones = aar.idinstituciones
		where p.idperiodo ={$idp} and aar.idanio={$ida} and aar.idinstituciones ={$idi} {$adicional}) info where info.informe_gobierno != ''");
	}
	/*public static function getMetasPorLineaAccion($id){
		return DB::select("SELECT p.numero as no_proyecto,p.descripcion as proyecto,pro.numero as no_programa,pro.descripcion as programa,reg.descripcion as meta,c.descripcion as dep_aux,area.descripcion as dep_gen FROM ui_pdm_alineacion a 
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		inner join ui_subprograma sub on sub.idsubprograma = p.idsubprograma
		inner join ui_programa pro on pro.idprograma = sub.idprograma
		left join ui_reporte_reg reg on reg.idreporte_reg = a.idreporte_reg
		left join ui_reporte r on r.idreporte = reg.idreporte
		left join ui_area_coordinacion c on c.idarea_coordinacion = r.id_area_coordinacion
		left join ui_area area on area.idarea = c.idarea
		where a.idpdm_pilares_lineas_accion={$id}");
	}*/
	public static function getPilaresPeriodo($idp){
		return DB::select("SELECT * FROM ui_pdm_pilares where idperiodo={$idp}");
	}
	public static function getPilares($idp,$idpilar){
		return DB::select("SELECT * FROM ui_pdm_pilares where idperiodo = {$idp} and idpdm_pilares = {$idpilar}");
	}
	public static function getPilaresTemasOld($id){
		return DB::select("SELECT idpdm_pilares_temas as id,descripcion as tema FROM ui_pdm_pilares_temas where idpdm_pilares={$id}");
	}
	public static function getPilaresSubTemas($id){
		return DB::select("SELECT idpdm_pilares_subtemas as id,descripcion as subtema FROM ui_pdm_pilares_subtemas where idpdm_pilares_temas={$id}");
	}
	public static function getPilaresSubTemasObj($id){
		return DB::select("SELECT idpilares_objetivos as id,clave,descripcion as objetivo FROM ui_pilares_objetivos where idpdm_pilares_subtemas={$id}");
	}
	public static function getPilaresTemasObjEst($id){
		return DB::select("SELECT idpdm_pilares_estrategias as id,clave,descripcion as estrategia FROM ui_pdm_pilares_estrategias where idpilares_objetivos={$id}");
	}
	public static function getPilaresTemasObjEstLinAccion($id){
		return DB::select("SELECT l.idpdm_pilares_lineas_accion as id,l.clave,l.descripcion as linea FROM ui_pdm_pilares_lineas_accion l where l.idpdm_pilares_estrategias={$id}");
	}
	public static function getMetasProyectos($idp,$idanio){
		return DB::select("SELECT reg.idreporte_reg as id,reg.descripcion as meta,reg.unidad_medida,c.descripcion as coordinacion,a.descripcion as area,IFNULL(al.idpdm_alineacion,0) as idpdm_alineacion,ui.descripcion as institucion,ui.logo FROM ui_reporte_reg reg
		inner join ui_reporte r on r.idreporte = reg.idreporte
		inner join ui_area_coordinacion c on r.id_area_coordinacion = c.idarea_coordinacion
		inner join ui_area a on a.idarea = c.idarea
        inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
        left join ui_pdm_alineacion al on al.idreporte_reg = reg.idreporte_reg
		where r.idanio={$idanio} and r.idproyecto={$idp} and r.type = 0 group by reg.idreporte_reg order by reg.descripcion asc");
	}
	public static function getMetaAlineacion($id,$idanio){
		return DB::select("SELECT a.idpdm_alineacion as id,p.numero as no_proyecto,p.descripcion as proyecto,reg.descripcion as meta,c.numero as no_coordinacion,
		c.descripcion as coordinacion,ar.numero as no_area,ar.descripcion as area,ui.descripcion as institucion,ui.logo,a.comentarios,
		a.paso1,a.paso2,a.paso3,a.paso4,a.paso6,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,a.fecha_rg,a.hora_rg,a.iduser_rg FROM ui_pdm_alineacion a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		left join ui_reporte_reg reg on reg.idreporte_reg = a.idreporte_reg
		left join ui_reporte r on r.idreporte = reg.idreporte
		left join ui_area_coordinacion c on r.id_area_coordinacion = c.idarea_coordinacion
		left join ui_area ar on ar.idarea = c.idarea
		left join ui_instituciones ui on ui.idinstituciones = ar.idinstituciones
		left join tb_users u on u.id = a.iduser_rg
		where a.idpdm_pilares_lineas_accion={$id} and a.idanio={$idanio}");
	}

	public static function getMetaAlineacionInstitucion($id,$idanio,$idi){
		return DB::select("SELECT a.idpdm_alineacion as id,p.numero as no_proyecto,p.descripcion as proyecto,reg.descripcion as meta,c.numero as no_coordinacion,
		c.descripcion as coordinacion,ar.numero as no_area,ar.descripcion as area,ui.descripcion as institucion,ui.logo,a.comentarios,a.paso1,a.paso2,
		a.paso3,a.paso4,a.paso6,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,a.fecha_rg,a.hora_rg,a.iduser_rg FROM ui_pdm_alineacion a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		left join ui_reporte_reg reg on reg.idreporte_reg = a.idreporte_reg
		left join ui_reporte r on r.idreporte = reg.idreporte
		left join ui_area_coordinacion c on r.id_area_coordinacion = c.idarea_coordinacion
		left join ui_area ar on ar.idarea = c.idarea
		left join ui_instituciones ui on ui.idinstituciones = ar.idinstituciones
		left join tb_users u on u.id = a.iduser_rg
		where a.idpdm_pilares_lineas_accion={$id} and a.idanio={$idanio} and ui.idinstituciones = {$idi}");
	}

	public static function getMetaAlineacionInstitucionEnlaces($id,$idanio,$access){
		return DB::select("SELECT a.idpdm_alineacion as id,p.numero as no_proyecto,p.descripcion as proyecto,reg.descripcion as meta,c.numero as no_coordinacion,c.descripcion as coordinacion,
		ar.numero as no_area,ar.descripcion as area,ui.descripcion as institucion,
		ui.logo,a.comentarios,a.paso1,a.paso2,a.paso3,a.paso4,a.paso6,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,a.fecha_rg,a.hora_rg,a.iduser_rg FROM ui_pdm_alineacion a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		left join ui_reporte_reg reg on reg.idreporte_reg = a.idreporte_reg
		left join ui_reporte r on r.idreporte = reg.idreporte
		left join ui_area_coordinacion c on r.id_area_coordinacion = c.idarea_coordinacion
		left join ui_area ar on ar.idarea = c.idarea
		left join ui_instituciones ui on ui.idinstituciones = ar.idinstituciones
		left join tb_users u on u.id = a.iduser_rg
		where a.idpdm_pilares_lineas_accion={$id} and a.idanio={$idanio} and c.idarea_coordinacion in ({$access})");
	}

	public static function getMetaAlineacionIndividual($id){
		return DB::select("SELECT a.idpdm_alineacion as id,p.numero as no_proyecto,p.descripcion as proyecto,reg.descripcion as meta,c.numero as no_coordinacion,c.descripcion as coordinacion,ar.numero as no_area,ar.descripcion as area,ui.descripcion as institucion,ui.logo,a.comentarios,a.paso1,a.paso2,a.paso3,a.paso4,a.paso6,c1,c2,c3,c4,c6 FROM ui_pdm_alineacion a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		left join ui_reporte_reg reg on reg.idreporte_reg = a.idreporte_reg
		left join ui_reporte r on r.idreporte = reg.idreporte
		left join ui_area_coordinacion c on r.id_area_coordinacion = c.idarea_coordinacion
		left join ui_area ar on ar.idarea = c.idarea
		left join ui_instituciones ui on ui.idinstituciones = ar.idinstituciones
		where a.idpdm_alineacion={$id}");
	}
	public static function getMetaAlineacionActRelevantes($id){
		return DB::select("SELECT * from ui_pdm_alineacion_ar where idpdm_alineacion_ar = {$id}");
	}
	public static function getAlineacionesDelegaciones($id){
		return DB::select("SELECT a.idpdm_alineacion_del as id,d.iddelegacion,d.descripcion as delegacion FROM ui_pdm_alineacion_del a
			inner join ac_delegacion d on d.iddelegacion = a.iddelegacion
			where a.idpdm_alineacion = {$id}");
	}	
	public static function getAlineacionesDelegacionesActRel($id){
		return DB::select("SELECT * FROM ui_pdm_alineacion_del_ar where idpdm_alineacion_ar={$id}");
	}
	public static function getMetaAlineacionReg($id,$idanio){
		return DB::select("SELECT a.idpdm_alineacion as id,p.numero as no_proyecto,p.descripcion as proyecto,pl.clave,pl.descripcion as linea_accion FROM ui_pdm_alineacion a
		inner join ui_proyecto p on p.idproyecto = a.idproyecto
		inner join ui_pdm_pilares_lineas_accion pl on pl.idpdm_pilares_lineas_accion = a.idpdm_pilares_lineas_accion
		where a.idreporte_reg={$id} and a.idanio={$idanio}");
	}
	public static function getTotalMetas($id,$idla){
		return DB::select("SELECT count(idpdm_alineacion) as total FROM ui_pdm_alineacion where idreporte_reg={$id} and idpdm_pilares_lineas_accion={$idla}");
	}	
	public static function getTotalProyectos($id,$idla){
		return DB::select("SELECT count(idpdm_alineacion) as total FROM ui_pdm_alineacion where idproyecto={$id} and idpdm_pilares_lineas_accion={$idla}");
	}	
	public static function getLineaAccion($id){
		return DB::select("SELECT l.clave as linea_clave,l.descripcion as linea_accion,e.clave as est_clave,e.descripcion as estrategia,o.clave as obj_clave,o.descripcion as objetivo,s.descripcion as subtema,t.descripcion as tema,p.pilares,p.color FROM ui_pdm_pilares_lineas_accion l 
		left join ui_pdm_pilares_estrategias e on e.idpdm_pilares_estrategias = l.idpdm_pilares_estrategias
		left join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
        left join ui_pdm_pilares_subtemas s on s.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = s.idpdm_pilares_temas
		left join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
		where l.idpdm_pilares_lineas_accion={$id}");
	}	
	static function getDelegaciones($id){
		return DB::select("SELECT d.*,IFNULL(a.total,0) as total FROM ac_delegacion d
		left join (select count(a1.idpdm_alineacion_del) as total, a1.iddelegacion from ui_pdm_alineacion_del a1 
		where a1.idpdm_alineacion = {$id} group by a1.iddelegacion) a on a.iddelegacion = d.iddelegacion");
	}
	static function getDelegacionesAll(){
		return DB::select("SELECT * FROM ac_delegacion");
	}
	static function getActividadesRelevantes($id,$idanio){
		return DB::select("SELECT p.idpdm_alineacion_ar as id,p.comentarios,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,p.fecha_rg,p.hora_rg,i.descripcion as institucion,p.iduser_rg FROM ui_pdm_alineacion_ar p 
		left join tb_users u on u.id = p.iduser_rg
		left join ui_instituciones i on i.idinstituciones = p.idinstituciones
		where p.idpdm_pilares_lineas_accion = {$id} and p.idanio={$idanio}");
	}
	static function getActividadesRelevantesEnlace($id,$idanio,$idi,$idu){
		return DB::select("SELECT p.idpdm_alineacion_ar as id,p.comentarios,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,p.fecha_rg,p.hora_rg,i.descripcion as institucion,p.iduser_rg FROM ui_pdm_alineacion_ar p 
		left join tb_users u on u.id = p.iduser_rg
		left join ui_instituciones i on i.idinstituciones = p.idinstituciones
		where p.idpdm_pilares_lineas_accion = {$id} and p.idanio={$idanio} and p.idinstituciones={$idi} and p.iduser_rg = {$idu}");
	}
	static function getDelegacionesActRelevantes($id){
		return DB::select("SELECT d.*,IFNULL(a.total,0) as total FROM ac_delegacion d
		left join (select count(a1.idpdm_alineacion_ar) as total, a1.iddelegacion from ui_pdm_alineacion_del_ar a1 
		where a1.idpdm_alineacion_ar = {$id} group by a1.iddelegacion) a on a.iddelegacion = d.iddelegacion");
	}
	static function getConectores(){
		return DB::select("SELECT * FROM ui_pdm_alineacion_conectores");
	}
	static function getComentariosImgs($id){
		return DB::select("SELECT * FROM ui_pdm_alineacion_img where idpdm_alineacion={$id}");
	}
	static function getComentariosImgsActRel($id){
		return DB::select("SELECT * FROM ui_pdm_alineacion_img_ar where idpdm_alineacion_ar={$id}");
	}
	static function getComentariosImagen($id){
		return DB::select("SELECT * FROM ui_pdm_alineacion_img where idpdm_alineacion_img={$id}");
	}
	static function getComentariosImagenar($id){
		return DB::select("SELECT * FROM ui_pdm_alineacion_img_ar where idpdm_alineacion_img_ar={$id}");
	}
	static function getPermisoAreaCoordinacion($idu,$idi){
		return DB::select(" SELECT IFNULL(group_concat(idarea_coordinacion),0) as permiso FROM(SELECT uc.idarea_coordinacion FROM ui_user_coordinacion uc 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
		inner join ui_area a1 on a1.idarea = ac.idarea
		where uc.iduser={$idu} and a1.idinstituciones = {$idi}) AS info");
	}


























	//NUEVO MODULO 10-06-2025, Ya no mezclar con lo de arriba
	static function getPilaresEjes($idy){
		return DB::select("SELECT pa.idpdm_pilares as id,pi.numero as no_pilar,pi.pilares,pi.color,t.idpdm_pilares_temas as idtema,t.numero as no_tema,t.descripcion as tema FROM ui_pdm_pilares_anio pa
		inner join ui_pdm_pilares pi on pi.idpdm_pilares = pa.idpdm_pilares
			left join ui_pdm_pilares_temas t on t.idpdm_pilares = pi.idpdm_pilares
		where pa.idanio = ?",[$idy]);
	}
	static function getPïlaresTema($id){
		return DB::select("SELECT idpdm_pilares_temas as id,numero as no_tema,descripcion as tema FROM ui_pdm_pilares_temas where idpdm_pilares_temas = ?",[$id]);
	}
	static function getPïlaresSubTema($id){
		return DB::select("SELECT idpdm_pilares_subtemas as id,descripcion as subtema FROM ui_pdm_pilares_subtemas where idpdm_pilares_temas = ?",[$id]);
	}
	static function getPïlaresObjetivos($id){
		return DB::select("SELECT idpilares_objetivos as id,clave as no_objetivo,descripcion as objetivo FROM ui_pilares_objetivos where idpdm_pilares_subtemas = ?",[$id]);
	}
	static function getPïlaresEstrategias($id){
		return DB::select("SELECT idpdm_pilares_estrategias as id,clave as no_est,descripcion as est FROM ui_pdm_pilares_estrategias where idpilares_objetivos = ?",[$id]);
	}
	static function getLineasAccion($id){
		return DB::select("SELECT idpdm_pilares_lineas_accion as id,clave as no_la,descripcion as la FROM ui_pdm_pilares_lineas_accion where idpdm_pilares_estrategias = ?",[$id]);
	}
	static function getPdmMetas($id){
		return DB::select("SELECT idpdm_pilares_metas as id,clave,descripcion as meta FROM ui_pdm_pilares_metas where idpdm_pilares_lineas_accion = ?",[$id]);
	}
	static function getPdmMetasPbrm($id,$idy){
		return DB::select("SELECT p.idpdm_pilares_pbrm as id,rr.no_accion,rr.descripcion as meta,p.trim1,p.trim2,p.trim3,p.trim4 FROM ui_pdm_pilares_pbrm p 
						inner join ui_reporte_reg rr on rr.idreporte_reg = p.idreporte_reg
						where p.idpdm_pilares_metas = ? and p.idanio = ?",[$id,$idy]);
	}
	public static function getSearchMetas($numero=null,$request=null,$idi){
		$no_proyecto = (empty($request->no_proyecto)) ? "" : " AND p.numero like '%{$request->no_proyecto}%'";
		$meta = (empty($request->meta)) ? "" : " AND rr.descripcion like '%{$request->meta}%'";
		$idproyecto = (empty($request->idproyecto)) ? "" : " AND r.idproyecto={$request->idproyecto}";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.*,rr.idreporte_reg,rr.no_accion,rr.unidad_medida,rr.descripcion as meta ";
		}else{
			return \DB::select("SELECT count(r.idreporte) as suma FROM ui_reporte r 
				inner join ui_proyecto p on p.idproyecto = r.idproyecto
					inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
						inner join ui_area a on a.idarea = ac.idarea
				inner join ui_instituciones ui on ui.idinstituciones = r.idinstituciones
				where r.idanio = {$request['idy']} and r.idinstituciones = {$idi} and r.type = 0 {$no_proyecto} {$idproyecto}");

		}
		$cad = " where info.id is not null {$meta} order by info.id asc ";

		if(!empty($request->meta)){
			$lc = "";
		}

		return \DB::select("SELECT {$dato} FROM (SELECT r.idreporte as id,p.numero as no_proyecto,p.descripcion as proyecto,a.numero as no_dep_gen,a.descripcion as dep_gen,
				ac.numero as no_dep_aux,ac.descripcion as dep_aux,ui.denominacion as no_institucion,ui.descripcion as institucion FROM ui_reporte r 
				inner join ui_proyecto p on p.idproyecto = r.idproyecto
					inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
						inner join ui_area a on a.idarea = ac.idarea
				inner join ui_instituciones ui on ui.idinstituciones = r.idinstituciones
				where r.idanio = {$request['idy']} and r.idinstituciones = {$idi} and r.type = 0 {$no_proyecto} {$idproyecto} order by a.numero,ac.numero asc {$lc} ) AS info
				inner join ui_reporte_reg rr on rr.idreporte = info.id
				{$cad} ");
	}
	static function getProyectoMetas($idy){
		return DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_reporte r
					inner join ui_proyecto p on p.idproyecto = r.idproyecto 
					where r.idanio = ? and r.type=0 group by p.idproyecto order by p.numero asc",[$idy]);
	}
}
