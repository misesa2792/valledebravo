<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class municipios extends Sximo  {
	
	protected $table = 'ui_municipios';
	protected $primaryKey = 'idmunicipios';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_municipios.* FROM ui_municipios  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_municipios.idmunicipios IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
