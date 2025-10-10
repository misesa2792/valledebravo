<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class fuentefinanciamienton extends Sximo  {
	
	protected $table = 'ui_teso_ff_n1';
	protected $primaryKey = 'idteso_ff_n1';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_ff_n1.*,ui_anio.anio FROM ui_teso_ff_n1 LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_ff_n1.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_ff_n1.idteso_ff_n1 IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
