<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class estructuraprogramatica extends Sximo  {
	
	protected $table = 'ui_proyecto';
	protected $primaryKey = 'idproyecto';

	public function __construct() {
		parent::__construct();	
	}
	public static function getFinalidad(){
		return \DB::select("SELECT idfinalidad as id,numero as no_finalidad,descripcion as finalidad FROM ui_finalidad");
	}
	public static function getFuncion($id){
		return \DB::select("SELECT idfuncion as id,numero as no_funcion,descripcion as funcion FROM ui_funcion where idfinalidad = {$id}");
	}
	public static function getSubFuncion($id){
		return \DB::select("SELECT s.idsubfuncion as id,s.numero as no_subfuncion,s.descripcion as subfuncion FROM ui_subfuncion s where s.idfuncion= {$id}");
	}
	public static function getFinalidadFuncion($id){
		return \DB::select("SELECT fin.numero as no_finalidad,fin.descripcion as finalidad,fun.numero as no_funcion,fun.descripcion as funcion FROM ui_funcion fun
		inner join ui_finalidad fin on fin.idfinalidad = fun.idfinalidad
		where fun.idfuncion= {$id}");
	}	

}
