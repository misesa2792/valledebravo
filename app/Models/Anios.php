<?php namespace App\Models;

class anios extends Sximo  {
	
	protected $table = 'ui_anio';
	protected $primaryKey = 'idanio';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_anio.*,ui_periodo.descripcion as periodo FROM ui_anio left join ui_periodo on ui_periodo.idperiodo = ui_anio.idperiodo ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_anio.idanio IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
}
