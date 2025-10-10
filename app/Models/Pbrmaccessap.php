<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrmaccessap extends Sximo  {
	
	protected $table = 'ui_area';
	protected $primaryKey = 'idarea';

	public function __construct() {
		parent::__construct();
		
	}

	public static function getYears(){
		return \DB::select("SELECT idanio,anio FROM ui_anio");
	}
	public static function getAreasAP($idi){
		return \DB::select("SELECT idarea as ida,descripcion as area FROM ui_area where idinstituciones = {$idi}");
	}
	public static function getAccesosArea($ida, $idanio, $idi, $module){
		return \DB::select("SELECT idarea_accesos as id,accesos FROM ui_area_accesos 
		where idarea = {$ida} and idanio = {$idanio} and idinstituciones = {$idi} and module = {$module}");
	}
}
