<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class calendario extends Model  {
	
	protected $table = 'ui_events';
	protected $primaryKey = 'idevents';

 	protected $fillable = [
        'idinstituciones',
        'evento',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'color',
        'iduser_rg'
    ]; // Campos que se pueden llenar masivamente (mass assignable)

	public static function getEventos($idi){
		return DB::select("SELECT idevents as id,evento as title,fecha_inicio as start,fecha_fin as end,color FROM ui_events where idinstituciones = {$idi}");
	}

}
