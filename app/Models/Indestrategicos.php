<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class indestrategicos extends Sximo  {
	
	protected $table = 'ui_ind_estrategicos';
	protected $primaryKey = 'idind_estrategicos';

	public function __construct() {
		parent::__construct();
	}
	public static function getProgramas($idy){
		return DB::select("SELECT idprograma,numero as no_programa,descripcion as programa FROM ui_programa where idanio = {$idy} and estatus = 1 order by numero asc");
	}
	public static function getSearch($numero=null, $request=null){
		$ind = (empty($request->indicador)) ? "" : " AND i.indicador like '%{$request->indicador}%'";
		$no_programa = (empty($request->no_programa)) ? "" : " AND p.numero = {$request->no_programa}";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where i.idanio = {$request->idy} and i.idind_estrategicos is not null ".$ind.$no_programa;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  i.idind_estrategicos as id,p.descripcion as programa,i.codigo,i.indicador,SUBSTRING(codigo,  9, 4) as mir ";
		}else{
			$dato = " count(i.idind_estrategicos) as suma ";
			$lc = "";
		}
		return DB::select("SELECT {$dato} FROM ui_ind_estrategicos i 
							inner join ui_programa p on p.idprograma = i.idprograma
							 $cad order by p.numero asc {$lc}");
	}
	public static function getIndVariables($id){
		return DB::select("SELECT idind_estrategicos_reg as id,nombre_corto,nombre_largo FROM ui_ind_estrategicos_reg where idind_estrategicos = {$id}");
	}
	public static function getSearchIndi($text){
		return DB::select("SELECT info.* from (SELECT idreporte_mir,LOWER(nombre_indicador) as nombre_indicador FROM ui_reporte_mir ) as info where info.nombre_indicador like '%{$text}%'");
	}
	public static function getVariables($id){
		return DB::select("SELECT idind_estrategicos_reg as id,nombre_corto, nombre_largo FROM ui_ind_estrategicos_reg where idind_estrategicos = ?",[$id]);
	}
	public static function getIndEstrategicoRelacion($id){
		return DB::table('ui_programa_reg')
        ->select('nombre as indicador')
        ->where('idind_estrategicos', $id)
        ->first();
	}
	
}
