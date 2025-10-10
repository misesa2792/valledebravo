<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class periodo extends Sximo  {
	
	protected $table = 'ui_periodo';
	protected $primaryKey = 'idperiodo';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ui_periodo.* FROM ui_periodo  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ui_periodo.idperiodo IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
