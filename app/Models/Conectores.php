<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class conectores extends Sximo  {
	
	protected $table = 'ui_pdm_alineacion_conectores';
	protected $primaryKey = 'idpdm_alineacion_conectores';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_pdm_alineacion_conectores.* FROM ui_pdm_alineacion_conectores  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_pdm_alineacion_conectores.idpdm_alineacion_conectores IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
