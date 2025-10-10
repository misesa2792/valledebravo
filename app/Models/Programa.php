<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class programa extends Sximo  {
	
	protected $table = 'ui_programa';
	protected $primaryKey = 'idprograma';

	public function __construct() {
		parent::__construct();
		
	}
	public static function getSearch($numero=null, $request=null){
		$no_programa = (empty($request->no_programa)) ? "" : " AND info.no_programa like '%{$request->no_programa}%'";
		$programa = (empty($request->programa)) ? "" : " AND info.programa like '%{$request->programa}%'";
		$pilar = (empty($request->idpdm_pilares)) ? "" : " AND info.idpdm_pilares = {$request->idpdm_pilares} ";
		$page = $request->page;
		$limit = $request->nopagina;
		$offset = ($page-1) * $limit ;
		$cad= " where info.id is not null ".$pilar.$no_programa.$programa;
		if($numero == 1){
			$lc = ($page !=0 && $limit !=0) ? " LIMIT  $offset , $limit" : '';
			$dato = "  * ";
		}else{
			$dato = " count(info.id) as suma ";
			$lc = "";
		}
		return DB::select("SELECT {$dato} FROM (SELECT p.idprograma as id,p.estatus,s.numero as no_subfuncion,p.numero as no_programa,
		p.descripcion as programa,p.tema_desarrollo as tema,p.objetivo,p.idpdm_pilares,pi.pilares,t.numero as no_tema,t.descripcion as tema_des FROM ui_programa p
		left join ui_subfuncion s on s.idsubfuncion = p.idsubfuncion
		left join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = p.idpdm_pilares_temas
		where p.idanio = {$request->idy} ) as info $cad {$lc}  ");
	}
	public static function getProgramaReg($id, $no){
		return DB::select("SELECT p.idprograma_reg as id,p.tipo,p.descripcion,p.nombre,p.formula,p.idfrecuencia_medicion as idf,p.idtipo_indicador as idt,
		p.medios,p.supuestos,f.descripcion as frecuencia,t.descripcion as tipo_indicador,p.idmir_formula,p.idind_estrategicos,idprograma_reg_rel as idrel FROM ui_programa_reg p
		left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = p.idfrecuencia_medicion
		left join ui_tipo_indicador t on t.idtipo_indicador = p.idtipo_indicador
		where p.idprograma = ? and p.no_matriz = ?",[$id, $no]);
	}
	public static function getProgramaRegComponentes($id, $no){
		return DB::table('ui_programa_reg')
			->select('idprograma_reg as id', 'descripcion as componente')
			->where('idprograma', $id)
			->where('no_matriz', $no)
			->where('tipo', 3)
			->get();
	}
	public static function getProgramaNoMatriz($id){
		return DB::table('ui_programa_matriz')
			->where('idprograma', $id)
			->get();
	}
	public static function getProgramaRegTotal($id, $no){
		return DB::table('ui_programa_reg')
			->where('idprograma', $id)
			->where('no_matriz', $no)
			->count('idprograma_reg');
	}
	public static function getMirFormula(){
		return DB::table('ui_mir_formula')
			->select('idmir_formula as id', 'formula')
			->get();
	}
	public static function getIndEstrategicos($idp, $idy){
		return DB::table('ui_ind_estrategicos')
			->select('idind_estrategicos as id', 'codigo', 'indicador')
			->where('idprograma', $idp)
			->where('idanio', $idy)
			->get();
	}
}
