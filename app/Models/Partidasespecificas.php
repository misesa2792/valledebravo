<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class partidasespecificas extends Sximo  {
	
	protected $table = 'ui_teso_partidas_esp';
	protected $primaryKey = 'idteso_partidas_esp';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		return " SELECT ui_teso_partidas_esp.*,ui_teso_partidas_gen.clave as no_partida_generica,ui_teso_partidas_gen.nombre as partida_generica,ui_anio.anio FROM ui_teso_partidas_esp
			INNER JOIN ui_teso_partidas_gen ON ui_teso_partidas_gen.idteso_partidas_gen = ui_teso_partidas_esp.idteso_partidas_gen
			LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_partidas_esp.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_partidas_esp.idteso_partidas_esp IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	public static function getPartidasGenericas(){
		return \DB::select("SELECT idteso_partidas_gen as id,clave,nombre  FROM ui_teso_partidas_gen");
	}
	

}
