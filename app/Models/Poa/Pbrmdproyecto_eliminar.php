<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmdproyecto extends Model {

    protected $table = 'ui_pd_pbrme_proyecto'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme_proyecto'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrme_asignar',
        'idpd_pbrme_matriz',
        'idarea_coordinacion',
        'idproyecto',
        'd_estatus',
        'd_url',
        'd_porc1',
        'd_porc2',
        'd_porc3',
        'd_porc4',
        'd_porc_anual',
        'd_interpretacion',
        'iddimension_atiende',
        'd_factor',
        'd_factor_desc',
        'd_linea_base',
        'd_descripcion_meta',
        'd_metas_actividad',
        'd_aplica1',
        'd_aplica2',
        'd_aplica3',
        'd_aplica4',
        'd_idpd_pbrma_metas'
    ];
    
    public $timestamps = false;//Desactiva el created_at y updated_at

}
