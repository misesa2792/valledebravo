<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class usuarios extends Sximo  {

	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null, $idi){
		if(empty($request->active)){
			$active = "";
		}else if($request->active == 1){
			$active = " AND info.active = 1";
		}else{
			$active = " AND info.active = 0";
		}
		$name = (empty($request->name)) ? "" : " AND info.nombre_completo like '%{$request->name}%'";
		$group_id = (empty($request->group_id)) ? "" : " AND info.group_id = {$request->group_id} ";
		$ins = " and info.idinstituciones = {$idi}";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " WHERE info.id IS NOT NULL ".$name.$ins.$active.$group_id;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  * ";
		}else{
			$dato = " count(id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT u.id, concat_ws(' ', u.username, u.first_name, u.last_name) as nombre_completo,u.avatar,u.active,u.group_id,g.name as nivel,u.email,u.idinstituciones,i.descripcion as institucion FROM tb_users u
			inner join tb_groups g  on u.group_id = g.group_id
			left join ui_instituciones i on u.idinstituciones = i.idinstituciones
			where u.group_id in (3,9)) as info {$cad} order by info.id desc {$lc}");
	}
	public static function getValidarCorreo($email){
		return \DB::select("SELECT email FROM tb_users where email='{$email}' limit 1");
	}
	public static function getPermisos($idu){
		return \DB::select("SELECT i.idinstituciones as id,i.descripcion,i.logo,u.idinstituciones as permiso FROM ui_instituciones i
		left join (select u1.id,u1.idinstituciones from tb_users u1 where u1.id={$idu}) u on u.idinstituciones = i.idinstituciones");
	}
	public static function getInstituciones($id){
		return \DB::select("SELECT i.idinstituciones as id,i.descripcion as institucion FROM tb_users u 
		inner join ui_instituciones i on i.idinstituciones = u.idinstituciones
		where id={$id}");
	}
	public static function getOperador($id){
		return \DB::select("SELECT u.id,u.username as nombre,u.first_name as ap,u.last_name as am,u.email,u.avatar,u.active,m.descripcion as municipio,i.descripcion as institucion,g.name as nivel,m.idmunicipios FROM tb_users u
		inner join tb_groups g on g.group_id = u.group_id
		left join ui_instituciones i on i.idinstituciones = u.idinstituciones
				inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where u.id = {$id}");
	}
	public static function getEnlace(){
		return \DB::select("SELECT c.idarea_coordinacion as idac,a.descripcion as area,c.descripcion as coordinacion FROM ui_area_coordinacion c
		inner join ui_area a on a.idarea = c.idarea ");
	}
	public static function getGruposUser(){
		return \DB::select("SELECT group_id as id,name as nivel FROM tb_groups where group_id in (3,9)");
	}
	public static function getEnlaceUser($id){
		return \DB::select("SELECT c.idarea_coordinacion as idac,a.descripcion as area,c.descripcion as coordinacion,IFNULL(a.total,0) as total FROM ui_area_coordinacion c
		inner join ui_area a on a.idarea = c.idarea
        left join (select count(a1.iduser_coordinacion) as total,a1.idarea_coordinacion from ui_user_coordinacion a1 where a1.iduser={$id} group by a1.iduser_coordinacion) a on a.idarea_coordinacion = c.idarea_coordinacion");
	}
	public static function getLocalidades($cad = null){
		return \DB::select("SELECT d.iddelegaciones as idd,d.descripcion as des,d.total_poblacion as t_pob,d.total_hombres as t_hom,
		d.total_mujeres as t_muj,d.total_ninos,d.total_ninas,IFNULL(r.total,0) as total FROM pre_delegaciones d
		left join (select count(rp.idregistro_proyectos) as total,rp.iddelegaciones from pre_registro_proyectos rp group by rp.iddelegaciones) r on r.iddelegaciones = d.iddelegaciones {$cad}");
	}
	public static function getTotalesProyectos($id){
		return \DB::select("SELECT count(r.idregistro_proyectos) as total,p.descripcion as proyecto FROM pre_registro_proyectos r 
			inner join pre_proyectos p on p.idproyectos = r.idproyectos
			where r.iddelegaciones={$id} group by r.idproyectos");
	}

	public static function getDependenciasForYears($idi,$idy){
		return \DB::select("SELECT a.idarea as id,a.descripcion as dep_gen,a.numero FROM ui_area a 
		inner join ui_anio y on y.idanio = a.idanio
		where a.idinstituciones = {$idi} and a.idanio = {$idy} order by a.numero asc");
	}
	public static function getUserAreasCoordinaciones($ida,$idu){
		return \DB::select("SELECT c.idarea_coordinacion as idc,descripcion as coordinacion,c.numero,IFNULL(uc.permiso,0) as permiso FROM ui_area_coordinacion c 
		left join (select count(uc1.iduser_coordinacion) as permiso,uc1.idarea_coordinacion from ui_user_coordinacion uc1 where uc1.iduser={$idu} group by uc1.idarea_coordinacion) uc on uc.idarea_coordinacion = c.idarea_coordinacion
		where c.idarea={$ida}");
	}
	public static function getUserAreasCoordinacionesAccess($idu, $idy){
		return \DB::select("SELECT uc.iduser_coordinacion as iduc,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen FROM ui_user_coordinacion uc 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where uc.iduser={$idu} and a.idanio = {$idy}  order by a.numero,ac.numero asc");
	}
	//Se obtienes las Dependencias Generales que se asignaron al usuario y que venga agrupado por area
	public static function getDepGenPerUserGroupByArea($iduser){
		return \DB::select("SELECT a.idarea as id,a.descripcion as dep_gen,a.numero as no_dep_gen FROM ui_user_coordinacion uc
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where uc.iduser = {$iduser} group by a.idarea");
	}
	//Se obtienen las Dependencias Auxiliares de los usuarios por area
	public static function getDepAuxPerUserPerArea($iduser,$idarea){
		return \DB::select("SELECT a.idarea as id,ac.descripcion as dep_aux,ac.numero as no_dep_aux FROM ui_user_coordinacion uc
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where uc.iduser = {$iduser} and a.idarea={$idarea}");
	}
	public static function getUserActive($gp){
		return \DB::select("SELECT id,concat_ws(' ',username,first_name,last_name) as enlace,email FROM tb_users where group_id={$gp} and active=1");
	}
	public static function getUserDependencias($id){
		return \DB::select("SELECT ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen FROM ui_user_coordinacion c
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = c.idarea_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where c.iduser={$id} order by a.numero,ac.numero asc");
	}
	public static function getAcccessUserDepGen($idu){
		return \DB::select("SELECT u.iduser_area as id,d.numero as no_dep_gen,d.descripcion as dep_gen,u.dep_aux FROM ui_user_area u
		inner join ui_dep_gen d on u.iddep_gen = d.iddep_gen
		where u.iduser = {$idu} order by d.numero asc");
	}
	public static function getDepGen($idtd){
		return \DB::select("SELECT iddep_gen as id,numero as no_dep_gen,descripcion as dep_gen FROM ui_dep_gen where idanio = 4 and idtipo_dependencias = {$idtd} order by numero asc");
	}
	public static function getDepAuxPorDepGen($idi, $dg){
		return \DB::select("SELECT info.* FROM (SELECT ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen FROM ui_reporte r
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where r.idinstituciones = {$idi} group by r.id_area_coordinacion) AS info 
			where info.no_dep_gen='".$dg."'");
	}
	public static function getDepAuxView($access){
		return \DB::select("SELECT numero,descripcion FROM ui_dep_aux where numero in ({$access}) group by numero");
	}
	public static function getPermisoAux($id){
		return \DB::table('ui_user_area as u')
			->where('u.iduser_area', $id)
			->select('u.dep_aux')
			->first();
	}
}
