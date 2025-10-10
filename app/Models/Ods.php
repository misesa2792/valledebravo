<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ods extends Sximo  {
	
	protected $table = 'ui_ods';
	protected $primaryKey = 'idods';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_ods.* FROM ui_ods  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_ods.idods IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static function getMetas($id){
		return \DB::select("SELECT idods_metas as id,descripcion as meta FROM ui_ods_metas where idods = {$id}");
	}


}
