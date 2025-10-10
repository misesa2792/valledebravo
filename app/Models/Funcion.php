<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class funcion extends Sximo  {
	
	protected $table = 'ui_funcion';
	protected $primaryKey = 'idfuncion';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null){
		$nofun = (empty($request->no_funcion)) ? "" : " AND info.no_funcion like '%{$request->no_funcion}%'";
		$fun = (empty($request->funcion)) ? "" : " AND info.funcion like '%{$request->funcion}%'";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$nofun.$fun;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT f.idfuncion as id,d.numero as no_finalidad,f.numero as no_funcion,f.descripcion as funcion,f.objetivo as obj_funcion FROM ui_funcion f 
			inner join ui_finalidad d on d.idfinalidad = f.idfinalidad
			where f.idanio = {$request->idy}) AS info $cad {$lc}  ");
	}
	public static function getFinalidadActiveForYears($idy){
		return \DB::select("SELECT idfinalidad as id,numero as no_finalidad,descripcion as finalidad FROM ui_finalidad where idanio = {$idy}");
	}

}
