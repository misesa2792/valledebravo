<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Planmetas extends Model {
    
    protected $table = 'ui_pd_plan_metas'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_plan_metas'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_plan',
        'numero',
        'meta',
        'unidad_medida',
        'total_programado',
        'total_year1',
        'total_year2',
        'total_year3',
        'total_programado'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

    public static function getMetas($id){
		return DB::select("SELECT idpd_plan_metas as id,numero,meta,unidad_medida,total_programado,total_year1,total_year2,total_year3 FROM ui_pd_plan_metas where idpd_plan = ?", [$id]);
	}
}
