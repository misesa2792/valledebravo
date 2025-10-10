<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class subprograma extends Sximo  {
	
	protected $table = 'ui_subprograma';
	protected $primaryKey = 'idsubprograma';

	public function __construct() {
		parent::__construct();
	}
	public static function getSearch($numero=null, $request=null){
		$nosub = (empty($request->no_subprograma)) ? "" : " AND info.no_subprograma like '%{$request->no_subprograma}%'";
		$sub = (empty($request->subprograma)) ? "" : " AND info.subprograma like '%{$request->subprograma}%'";
		$estatus = (empty($request->estatus)) ? "" : " AND info.estatus = {$request->estatus} ";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$nosub.$sub.$estatus;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  info.* ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return \DB::select("SELECT {$dato} FROM (SELECT sp.idsubprograma as id,sp.estatus,p.numero as no_programa,sp.numero as no_subprograma,sp.descripcion as subprograma FROM ui_subprograma sp
				inner join ui_programa p on p.idprograma = sp.idprograma
				where sp.idanio = {$request->idy} order by sp.numero asc) AS info $cad {$lc}  ");
	}
	public static function getProgramaActiveForYears($idy){
		return \DB::select("SELECT idprograma as id,numero as no_programa,descripcion as programa FROM ui_programa where idanio = {$idy} and estatus = 1 order by numero asc");
	}

}
