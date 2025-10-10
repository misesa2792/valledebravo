<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class area extends Sximo  {
	
	protected $table = 'ui_area';
	protected $primaryKey = 'idarea';

	//12-08-2025
	protected $fillable = [
        'iddep_gen',
        'idinstituciones',
        'idanio',
        'estatus',
        'numero',
        'descripcion',
        'titular',
        'cargo'
    ];

	public $timestamps = false;

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
                'dg.numero as no_dep_gen_rel',
                'a.numero as no_dep_gen',
                'a.descripcion as dep_gen',
                'a.titular',
                'a.cargo'
            ])
            ->where('a.idanio', $idy);

		 // Filtros opcionales (evita LIKE '%%')
		if (!empty($request['no']) && trim($request['no']) !== '') {
			$query->where('a.numero', 'like', '%'.trim($request['no']).'%');
		}
		if (!empty($request['dg']) && trim($request['dg']) !== '') {
			$query->where('a.descripcion', 'like', '%'.trim($request['dg']).'%');
		}
		if (!empty($request['titular']) && trim($request['titular']) !== '') {
			$query->where('a.titular', 'like', '%'.trim($request['titular']).'%');
		}
		if (!empty($request['idm'])) {
			$query->where('i.idmunicipios', '=', (int) $request['idm']);
		}
		if (!empty($request['idtd'])) {
			$query->where('i.idtipo_dependencias', '=', (int) $request['idtd']);
		}
		if (!empty($request['estatus'])) {
			$query->where('a.estatus', '=', (int) $request['estatus']);
		}

		$query->orderBy('i.denominacion')->orderBy('a.numero');
        // Paginar (LengthAwarePaginator con total)
		
		return $query->paginate($perPage);
	}

	public static function getDepGen($idy, $idtd){
        return DB::table('ui_dep_gen')
            ->select([
                'iddep_gen as id',
                'numero as no_dep_gen',
                'descripcion as dep_gen'
            ])
            ->where('idanio', $idy)
            ->where('idtipo_dependencias', $idtd)
            ->orderBy('numero')
			->get();
	}

    public static function getActiveInstitutions($idtd){
        return DB::table('ui_instituciones')
            ->select([
                'idinstituciones as id',
                'denominacion as no_institucion',
                'descripcion as institucion'
            ])
            ->where('active', 1)
            ->where('idtipo_dependencias', $idtd)
			->get();
	}
}
