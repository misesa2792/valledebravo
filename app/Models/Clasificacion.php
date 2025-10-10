<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class clasificacion extends Sximo  {
	
	protected $table = 'ui_clasificacion_programatica';
	protected $primaryKey = 'idclasificacion_programatica';

	public function __construct() {
		parent::__construct();
		
	}
	public static function getSearch($numero=null, $request=null){
		$clasif = (empty($request->clasificacion)) ? "" : " AND info.clasificacion like '%{$request->clasificacion}%'";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$clasif;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT idclasificacion_programatica as id,clasificacion,programa,caracteristicas_generales as generales FROM ui_clasificacion_programatica 
		where idanio = {$request->idy}) AS info $cad {$lc}  ");
	}

}
