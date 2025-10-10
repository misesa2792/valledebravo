<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class coordinaciones extends Sximo  {
	
	protected $table = 'ui_area_coordinacion';
	protected $primaryKey = 'idarea_coordinacion';

	public function __construct() {
		parent::__construct();
	}

	public static function getSearch($request){
		 $idy = (int) $request['idy'];
		$perPage = (int) $request['nopagina'];
        $query = DB::table('ui_area as a')
            ->leftjoin('ui_dep_gen as dg', 'dg.iddep_gen', '=', 'a.iddep_gen')
            ->join('ui_instituciones as i', 'i.idinstituciones', '=', 'a.idinstituciones')
            	->join('ui_municipios as m', 'm.idmunicipios', '=', 'i.idmunicipios')
            	->join('ui_tipo_dependencias as tp', 'tp.idtipo_dependencias', '=', 'i.idtipo_dependencias')
            ->select([
                'a.idarea as id',
                'm.descripcion as municipio',
                'tp.idtipo_dependencias as idtd',
                'tp.abreviatura',
                'i.denominacion as no_institucion',
                'i.descripcion as institucion',
                'a.estatus',
                'a.numero as no_dep_gen',
                'a.descripcion as dep_gen'
            ])
            ->where('a.estatus', 1)
            ->where('a.idanio', $idy);

		if (!empty($request['no']) && trim($request['no']) !== '') {
			$query->where('a.numero', 'like', '%'.trim($request['no']).'%');
		}
		if (!empty($request['dg']) && trim($request['dg']) !== '') {
			$query->where('a.descripcion', 'like', '%'.trim($request['dg']).'%');
		}
		if (!empty($request['idm'])) {
			$query->where('i.idmunicipios', '=', (int) $request['idm']);
		}
		if (!empty($request['idtd'])) {
			$query->where('i.idtipo_dependencias', '=', (int) $request['idtd']);
		}
		$query->orderBy('i.denominacion')->orderBy('a.numero');
        // Paginar (LengthAwarePaginator con total)
		
		return $query->paginate($perPage);
	}
	public static function getDepAuxRel($ida){
        return DB::table('ui_area_coordinacion as ac')
            ->leftjoin('ui_dep_aux as da', 'da.iddep_aux', '=', 'ac.iddep_aux')
            ->select([
                'ac.idarea_coordinacion as id',
                'ac.iddep_aux',
                'da.numero as no_dep_aux_rel',
                'ac.numero as no_dep_aux',
                'ac.descripcion as dep_aux'
            ])
            ->where('ac.idarea', $ida)
			->orderBy('ac.numero')
			->get();
	}
	public static function getDepAux($idy, $idtd){
        return DB::table('ui_dep_aux')
            ->select([
                'iddep_aux as id',
                'numero as no_dep_aux',
                'descripcion as dep_aux'
            ])
            ->where('idtipo_dependencias', $idtd)
            ->where('idanio', $idy)
			->orderBy('numero')
			->get();
	}
	public static function getDepAuxID($id){
        return DB::table('ui_dep_aux')
            ->select([
                'iddep_aux as id',
                'numero as no_dep_aux',
                'descripcion as dep_aux'
            ])
            ->where('iddep_aux', $id)
			->first();
	}
}
