<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class capitulos extends Sximo  {
	
	protected $table = 'ui_teso_capitulos';
	protected $primaryKey = 'idteso_capitulos';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_capitulos.*,ui_anio.anio FROM ui_teso_capitulos LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_capitulos.idanio ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_capitulos.idteso_capitulos IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
