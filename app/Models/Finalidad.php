<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class finalidad extends Sximo  {
	
	protected $table = 'ui_finalidad';
	protected $primaryKey = 'idfinalidad';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null){
		$nofin = (empty($request->no_finalidad)) ? "" : " AND info.no_finalidad like '%{$request->no_finalidad}%'";
		$fin = (empty($request->finalidad)) ? "" : " AND info.finalidad like '%{$request->finalidad}%'";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$nofin.$fin;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT idfinalidad as id,numero as no_finalidad,descripcion as finalidad,objetivo as obj_finalidad FROM ui_finalidad 
			where idanio = {$request->idy}) AS info $cad {$lc} ");
	}

}
