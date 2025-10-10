<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmdasignar extends Model {

    protected $table = 'ui_pd_pbrme_asignar'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme_asignar'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrme',
        'idarea_coordinacion',
        'idproyecto'
    ];
    
    public $timestamps = false;//Desactiva el created_at y updated_at

    public static function getValidatedRecord($id, $idac, $idproyecto){
		return DB::table('ui_pd_pbrme_asignar')
            ->where('idpd_pbrme', $id)
            ->where('idarea_coordinacion', $idac)
            ->where('idproyecto', $idproyecto)
            ->exists();
	}
}
