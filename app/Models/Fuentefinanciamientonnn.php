<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class fuentefinanciamientonnn extends Sximo  {
	
	protected $table = 'ui_teso_ff_n3';
	protected $primaryKey = 'idteso_ff_n3';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_ff_n3.*,ui_teso_ff_n2.clave as no_ff_n2,ui_teso_ff_n2.descripcion as ff_n2,ui_anio.anio FROM ui_teso_ff_n3
		INNER JOIN ui_teso_ff_n2 ON ui_teso_ff_n2.idteso_ff_n2 = ui_teso_ff_n3.idteso_ff_n2
		LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_ff_n3.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_ff_n3.idteso_ff_n3 IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function getFuenteFinanciamientoNN(){
		return \DB::select("SELECT idteso_ff_n2 as id,clave,descripcion as nombre FROM ui_teso_ff_n2");
	}
	

}
