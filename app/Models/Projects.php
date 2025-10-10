<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class projects extends Sximo  {
	
	protected $table = 'ui_teso_proyectos';
	protected $primaryKey = 'idteso_proyectos';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

	public static function getSearch($idam){
		return DB::select("SELECT idteso_proyectos as id,dg.numero as no_dep_gen,dg.descripcion as dep_gen,da.numero as no_dep_aux,da.descripcion as dep_aux,pr.numero as no_proyecto,pr.descripcion as proyecto,tp.presupuesto FROM ui_teso_proyectos tp
		inner join ui_dep_gen dg on dg.iddep_gen = tp.iddep_gen
		inner join ui_dep_aux da on da.iddep_aux = tp.iddep_aux
		inner join ui_proyecto pr on pr.idproyecto = tp.idproyecto
		where tp.idanio_module = ? order by dg.numero,da.numero,pr.numero asc",[$idam]);
	}
}
