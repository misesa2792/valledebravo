<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class partidasgenericas extends Sximo  {
	
	protected $table = 'ui_teso_partidas_gen';
	protected $primaryKey = 'idteso_partidas_gen';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_partidas_gen.*,ui_teso_subcapitulos.clave as no_subcapitulo,ui_teso_subcapitulos.descripcion as subcapitulo,ui_anio.anio FROM ui_teso_partidas_gen
		INNER JOIN ui_teso_subcapitulos ON ui_teso_subcapitulos.idteso_subcapitulos = ui_teso_partidas_gen.idteso_subcapitulos
		LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_partidas_gen.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_partidas_gen.idteso_partidas_gen IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function getSubCapitulos(){
		return \DB::select("SELECT idteso_subcapitulos as id,clave,descripcion as subcapitulo FROM ui_teso_subcapitulos");
	}
	

}
