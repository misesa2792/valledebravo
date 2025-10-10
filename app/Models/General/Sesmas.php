<?php namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sesmas extends Model {
  
    //Función principal para ver todas las dependencias
    public static function getDependenciasInstitucion($idi, $idy)
    {
        return DB::table('ui_area as a')
            ->join('ui_instituciones as ui', 'ui.idinstituciones', '=', 'a.idinstituciones')
            ->where('a.idinstituciones', $idi)
            ->where('a.idanio', $idy)
            ->where('a.estatus', 1)
            ->orderBy('a.numero', 'asc')
            ->select('a.idarea', 'a.numero as no_dep_gen', 'a.descripcion as dep_gen', 'a.titular')
            ->get();
    }
    //Lista de dependencias que puede ver un usuario Enlace
    public static function getDependenciasUsuario($idi, $idy, array $accessNumeros)
    {
        // Si llega vacío, evitamos whereIn con array vacío
        if (empty($accessNumeros)) {
            return [];
        }

        return DB::table('ui_area as a')
            ->join('ui_instituciones as ui', 'ui.idinstituciones', '=', 'a.idinstituciones')
            ->where('a.idinstituciones', $idi)
            ->where('a.idanio', $idy)
            ->where('a.estatus', 1)
            ->whereIn('a.numero', $accessNumeros) // <- parámetros binded, sin concatenar
            ->orderBy('a.numero', 'asc')
            ->select('a.idarea', 'a.numero as no_dep_gen', 'a.descripcion as dep_gen', 'a.titular')
            ->get();
    }
    //Ver que permisos puede ver un usuario enlace
    public static function getDependenciasPermisos($idu)
    {
        return DB::table('ui_user_area as u')
            ->join('ui_dep_gen as d', 'u.iddep_gen', '=', 'd.iddep_gen')
            ->where('u.iduser', $idu)
            ->lists('d.numero'); // Laravel 5.1 ->lists() devuelve array
    }

}
