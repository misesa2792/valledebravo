<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class fuentefinanciamientonn extends Sximo  {
	
	protected $table = 'ui_teso_ff_n2';
	protected $primaryKey = 'idteso_ff_n2';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_teso_ff_n2.*,ui_teso_ff_n1.clave as no_ff_n1,ui_teso_ff_n1.descripcion as ff_n1,ui_anio.anio FROM ui_teso_ff_n2
 			INNER JOIN ui_teso_ff_n1 ON ui_teso_ff_n1.idteso_ff_n1 = ui_teso_ff_n2.idteso_ff_n1
			 LEFT JOIN ui_anio on ui_anio.idanio = ui_teso_ff_n1.idanio  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_teso_ff_n2.idteso_ff_n2 IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function getFuenteFinanciamientoN(){
		return \DB::select("SELECT idteso_ff_n1 as id,clave,descripcion as nombre FROM ui_teso_ff_n1");
	}
	

}
