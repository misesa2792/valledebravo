<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class planpdf extends Sximo  {
	
	protected $table = 'ui_plan_pdf';
	protected $primaryKey = 'idplan_pdf';

	public function __construct() {
		parent::__construct();
		
	}
	public static function getSearch($numero=null, $request=null){
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$std = (empty($request->estatus)) ? "" : " AND p.std_delete = {$request->estatus} ";
		$cad= " where p.idplan_pdf is not null {$std} order by p.idplan_pdf desc ";
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = " p.idplan_pdf as id,i.denominacion as no_institucion,i.descripcion as institucion,p.number,p.url,p.size,p.fecha,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,p.std_delete ";
		}else{
			$dato = " count(p.idplan_pdf) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM ui_plan_pdf p
		left join ui_instituciones i on i.idinstituciones = p.idinstituciones
		left join tb_users u on u.id = p.iduser
		 {$cad} {$lc}  ");
	}
	
	public static function getSearchFile($numero=null, $request=null){
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where i.idreporte_img is not null order by i.idreporte_img desc ";
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = " i.idreporte_img as id,i.url,i.nombre,i.ext,i.size,m.fecha_rg,m.hora_rg,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario ";
		}else{
			$dato = " count(i.idreporte_img) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM ui_reporte_img i 
		inner join ui_reporte_mes m on m.idreporte_mes = i.idreporte_mes
			left join tb_users u on u.id = m.iduser_rg
		{$cad} {$lc}  ");
	}
	public static function getSearchNavigation($numero=null, $request=null){
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$tipo = (empty($request->tipo)) ? "" : " AND v.type = {$request->tipo} ";
		$cad= " where idusers_navegation is not null {$tipo} order by idusers_navegation desc ";
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = " v.idusers_navegation as id,v.url,v.metodo,v.created_at,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,v.user_agent,v.ip_address,v.type ";
		}else{
			$dato = " count(v.idusers_navegation) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM tb_users_navegation v
			left join tb_users u on u.id = v.iduser
		{$cad} {$lc}  ");
	}
	public static function getSearchUsers($numero=null, $request=null){
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where u.id != 1 and u.active = 1 order by u.last_activity desc ";
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = " u.id,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario,u.email,g.name as nivel,u.last_activity ";
		}else{
			$dato = " count(u.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM tb_users u 
		inner join tb_groups g on g.group_id = u.group_id
		{$cad} {$lc}  ");
	}
	public static function getValidarDepGenAux($no_dep_gen,$no_dep_aux){
		return \DB::select("SELECT ac.idarea_coordinacion as idac,a.idarea as iddep_gen,a.descripcion as dep_gen,ac.idarea_coordinacion as iddep_aux,ac.descripcion as dep_aux,ac.numero FROM ui_area_coordinacion ac 
		inner join ui_area a on a.idarea = ac.idarea
		where a.idanio = 3 and a.estatus = 1 and a.idinstituciones = 1 and a.numero = '{$no_dep_gen}' and ac.numero = '{$no_dep_aux}' ");
	}
	public static function getValidarProyectos($no_proy){
		return \DB::select("SELECT p.idproyecto,p.descripcion as proyecto,sp.idprograma FROM ui_proyecto p 
		inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
		where p.idanio = 3 and p.estatus = 1 and p.numero = '{$no_proy}' ");
	}
}
