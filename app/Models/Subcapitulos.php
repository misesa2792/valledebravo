<?php namespace App\Models;

class subcapitulos extends Sximo  {
	
	protected $table = 'ui_teso_subcapitulos';
	protected $primaryKey = 'idteso_subcapitulos';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		return " SELECT ui_teso_subcapitulos.*,ui_teso_capitulos.clave as no_capitulo,ui_teso_capitulos.descripcion as capitulo,ui_anio.anio FROM ui_teso_subcapitulos  
		INNER JOIN ui_teso_capitulos ON ui_teso_capitulos.idteso_capitulos = ui_teso_subcapitulos.idteso_capitulos
		LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_subcapitulos.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_subcapitulos.idteso_subcapitulos IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static function getCapitulos(){
		return \DB::select("SELECT idteso_capitulos as id,clave,descripcion as capitulo FROM ui_teso_capitulos");
	}

}
