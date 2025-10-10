<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmdindicador extends Model {

    protected $table = 'ui_pd_pbrme_indicador'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme_indicador'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrme_matriz',
        'idind_estrategicos_reg',
        'nombre_corto',
        'nombre_largo',
        'unidad_medida',
        'idtipo_operacion',
        'trim1',
        'trim2',
        'trim3',
        'trim4',
        'anual'
    ];
    
    public $timestamps = false;//Desactiva el created_at y updated_at

}
