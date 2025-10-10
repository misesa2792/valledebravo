<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class proyecto extends Sximo  {
	
	protected $table = 'ui_proyecto';
	protected $primaryKey = 'idproyecto';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null){
		$noproy = (empty($request->no_proyecto)) ? "" : " AND info.no_proyecto like '%{$request->no_proyecto}%'";
		$proy = (empty($request->proyecto)) ? "" : " AND info.proyecto like '%{$request->proyecto}%'";
		$idconag = (empty($request->idconag)) ? "" : " AND info.idconag = {$request->idconag} ";
		$estatus = (empty($request->estatus)) ? "" : " AND info.estatus = {$request->estatus} ";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$noproy.$proy.$idconag.$estatus;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} from (SELECT p.idproyecto as id,p.estatus,p.numero as no_proyecto,p.descripcion as proyecto,
			p.objetivo as obj_proyecto,sp.numero as no_subprograma,cp.clasificacion,p.idclasificacion_programatica as idconag FROM ui_proyecto p
			left join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			left join ui_clasificacion_programatica cp on cp.idclasificacion_programatica = p.idclasificacion_programatica
			where p.idanio = {$request->idy} order by p.numero asc) as info $cad {$lc}  ");
	}
	public static function getSubprogramaActiveForYears($idy){
		return \DB::select("SELECT idsubprograma as id,numero as no_subprograma,descripcion as subprograma FROM ui_subprograma where idanio = {$idy} and estatus = 1");
	}
	public static function getConagActiveForYears($idy){
		return \DB::select("SELECT idclasificacion_programatica as id,clasificacion FROM ui_clasificacion_programatica where idanio = {$idy} order by clasificacion asc");
	}
}
