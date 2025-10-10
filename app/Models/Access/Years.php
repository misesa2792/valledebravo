<?php namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Years extends Model  {
	
	protected $table = 'ui_anio_access';
	protected $primaryKey = 'idanio_access';

	//Esta función esta en sximo, checar para ir desplazandola por esta nueva y mejorada
	public static function getModuleAccessByYears($idm,$idi){
		$result = DB::table('ui_anio_access as m')
			->join('ui_anio as a', 'a.idanio', '=', 'm.idanio')
			->where("m.idmodule", $idm)
			->where("m.idinstituciones", $idi)
			->select(
				'a.idanio',
				'a.anio'
			)
			->orderBy('a.idanio', 'desc')
			->get();
		return $result;
	}
	public static function getModuleAccessByYearsID($idm,$idi,$idy){
		$result = DB::table('ui_anio_access as m')
			->join('ui_anio as a', 'a.idanio', '=', 'm.idanio')
			->join('ui_instituciones as i', 'i.idinstituciones', '=', 'm.idinstituciones')
			->join('ui_tipo_dependencias as c', 'c.idtipo_dependencias', '=', 'i.idtipo_dependencias')
			->where("m.idmodule", $idm)
			->where("m.idinstituciones", $idi)
			->where("m.idanio", $idy)
			->select(
				'm.idanio_info',
				'a.idanio',
				'a.anio',
				'i.denominacion as no_institucion',
				'c.clave_identidad as clave'
			)
			->get();
		return $result;
	}

	

}
