<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pilares extends Sximo  {
	
	protected $table = 'ui_pdm_pilares';
	protected $primaryKey = 'idpdm_pilares';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_pdm_pilares.*,ui_periodo.descripcion as periodo FROM ui_pdm_pilares LEFT JOIN ui_periodo on ui_periodo.idperiodo = ui_pdm_pilares.idperiodo ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_pdm_pilares.idpdm_pilares IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static function getTemas($id){
		return \DB::select("SELECT idpdm_pilares_temas as id,descripcion as tema FROM ui_pdm_pilares_temas where idpdm_pilares={$id}");
	}
	public static function getPilarTipo($id){
		return \DB::select("SELECT * FROM ui_pdm_pilares_tipo where idpdm_pilares_tipo={$id}");
	}

}
