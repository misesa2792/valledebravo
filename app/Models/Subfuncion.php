<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class subfuncion extends Sximo  {
	
	protected $table = 'ui_subfuncion';
	protected $primaryKey = 'idsubfuncion';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null){
		$nosub = (empty($request->no_subfuncion)) ? "" : " AND info.no_subfuncion like '%{$request->no_subfuncion}%'";
		$sub = (empty($request->subfuncion)) ? "" : " AND info.subfuncion like '%{$request->subfuncion}%'";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$nosub.$sub;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT s.idsubfuncion as id,f.numero as no_funcion,s.numero as no_subfuncion,s.descripcion as subfuncion,s.objetivo as obj_subfuncion FROM ui_subfuncion s
		inner join ui_funcion f on f.idfuncion = s.idfuncion
		where s.idanio = {$request->idy}) AS info $cad {$lc}  ");
	}
	public static function getFuncionActiveForYears($idy){
		return \DB::select("SELECT idfuncion as id,numero as no_funcion,descripcion as funcion FROM ui_funcion where idanio = {$idy} order by numero asc ");
	}
}
