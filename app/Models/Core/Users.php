<?php namespace App\Models\Core;

use App\Models\Sximo;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Sximo  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
	}
	public static function querySelect(  ){
		return " SELECT  tb_users.*,  tb_groups.name as nivel
				FROM tb_users LEFT JOIN tb_groups ON tb_groups.group_id = tb_users.group_id ";
	}	
	public static function queryWhere(  ){
		return " WHERE tb_users.id !='' and tb_users.group_id!=1 and tb_users.group_id!=3 ";
	}
	public static function queryGroup(){
		return "      ";
	}
	public static function getGrupos(){
		return \DB::select("SELECT * FROM tb_groups where group_id!=1 and group_id!=3");
	}
	public static function getSearch($numero=null,$request=null){
		$name = (empty($request->name)) ? "" : " AND info.name like '%{$request->name}%'";
		$nivel = (empty($request->nivel)) ? "" : " AND info.group_id = {$request->nivel}";
		$municipio = (empty($request->idmunicipio)) ? "" : " AND info.idmunicipios = {$request->idmunicipio}";
		if($request->active == 1){
			$active = " and info.active = 1";
		}else{
			$active = " and info.active = 0";
		}
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " WHERE id IS NOT NULL ".$name.$nivel.$active.$municipio;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = " info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT u.id,u.username as name,u.first_name as ap,u.last_name as am,u.avatar,u.active,u.group_id,g.name as nivel,u.email,i.denominacion as no_institucion,i.descripcion as institucion,m.idmunicipios FROM tb_users u
		inner join tb_groups g  on u.group_id = g.group_id
		inner join ui_instituciones i on i.idinstituciones = u.idinstituciones
		inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where u.group_id != 1 and u.group_id != 3) as info {$cad} {$lc}");
	}	
	public static function getInstituciones(){
		return \DB::select("SELECT i.idinstituciones as id,i.denominacion as no_institucion,i.descripcion as institucion FROM ui_instituciones i
		inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		");
	}

}
