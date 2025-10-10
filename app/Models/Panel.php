<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class panel extends Model  {
	
	protected $table = 'ui_anio';
	protected $primaryKey = 'idanio';

	public static function getDepGen($idi, $idy){
		return DB::select("SELECT a.idarea as id,a.numero as no_dep_gen,a.descripcion as dep_gen,a.titular,a.cargo FROM ui_area a where a.idinstituciones = {$idi} and a.idanio = {$idy} and a.estatus = 1 order by a.numero asc ");
	}

}
