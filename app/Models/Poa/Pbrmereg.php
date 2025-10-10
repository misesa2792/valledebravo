<?php namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pbrmereg extends Model {

    protected $table = 'ui_pd_pbrme_reg'; // Nombre de la tabla personalizada
    protected $primaryKey = 'idpd_pbrme_reg'; // Clave primaria personalizada

    protected $fillable = [
        'idpd_pbrme',
        'idprograma_reg'
    ]; 

    public $timestamps = false;
}
