<?php namespace App\Models\Catalogos;

use App\Models\Sximo;
use Illuminate\Support\Facades\DB;

class depaux extends Sximo  {
	
	protected $table = 'ui_dep_aux';
	protected $primaryKey = 'iddep_aux';

	 protected $fillable = [
        'idtipo_dependencias',
        'idanio',
        'numero',
        'descripcion'
    ];

    public $timestamps = false;//Desactiva el created_at y updated_at

	public function __construct() {
		parent::__construct();
	}

	public static function getSearch($request){
        $idy = (int) $request['idy'];
		$perPage = (int) $request['nopagina'];
        $query = DB::table('ui_dep_aux as d')
            ->join('ui_tipo_dependencias as td', 'td.idtipo_dependencias', '=', 'd.idtipo_dependencias')
            ->select([
                'd.iddep_aux as id',
                'td.abreviatura',
                'd.numero as no_dep_aux',
                'd.descripcion as dep_aux',
            ])
            ->where('d.idanio', $idy);

		 // Filtros opcionales (evita LIKE '%%')
		if (!empty($request['nodg']) && trim($request['nodg']) !== '') {
			$query->where('d.numero', 'like', '%'.trim($request['nodg']).'%');
		}
		if (!empty($request['dg']) && trim($request['dg']) !== '') {
			$query->where('d.descripcion', 'like', '%'.trim($request['dg']).'%');
		}
		if (!empty($request['idtipo'])) {
			$query->where('d.idtipo_dependencias', '=', (int) $request['idtipo']);
		}

		$query->orderBy('td.clave_identidad')->orderBy('d.numero');
        // Paginar (LengthAwarePaginator con total)
		
		return $query->paginate($perPage);
	}

	

}
