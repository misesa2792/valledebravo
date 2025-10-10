<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pdm extends Sximo  {
	
	protected $table = 'ui_pdm_pilares';
	protected $primaryKey = 'idpdm_pilares';

	public function __construct() {
		parent::__construct();
	}
	public static function getPilaresPeriodo($id){
		return \DB::select("SELECT * FROM ui_pdm_pilares where idperiodo={$id}");
	}
	public static function getTemas($id){
		return \DB::select("SELECT idpdm_pilares_temas as idtema,descripcion as tema FROM ui_pdm_pilares_temas where idpdm_pilares={$id}");
	}
	public static function getPilarTema($id){
		return \DB::select("SELECT p.pilares,t.descripcion as tema,p.color FROM ui_pdm_pilares_temas t 
			left join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
			where t.idpdm_pilares_temas ={$id}");
	}
	public static function getPilarTemaObjetivo($id){
		return \DB::select("SELECT o.descripcion as objetivo,ps.descripcion as subtema,t.descripcion as tema,p.pilares,p.color FROM ui_pilares_objetivos o 
		left join ui_pdm_pilares_subtemas ps on ps.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = ps.idpdm_pilares_temas
		left join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
		where o.idpilares_objetivos= {$id}");
	}
	public static function getPilarTemaObjetivoEstrategia($id){
		return \DB::select("SELECT e.descripcion as estrategia,o.descripcion as objetivo,ps.descripcion as subtema,t.descripcion as tema,p.pilares,p.color  FROM ui_pdm_pilares_estrategias e 
		left join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
        left join ui_pdm_pilares_subtemas ps on ps.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = ps.idpdm_pilares_temas
		left join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
		where e.idpdm_pilares_estrategias= {$id}");
	}
	public static function getPilarTemaObjetivoEstrategiaLineaAccion($id){
		return \DB::select("SELECT e.descripcion as estrategia,o.descripcion as objetivo,ps.descripcion as subtema,t.descripcion as tema,p.pilares,p.color,la.clave as no_la,la.descripcion as linea_accion  FROM ui_pdm_pilares_lineas_accion la
		left join ui_pdm_pilares_estrategias e on e.idpdm_pilares_estrategias = la.idpdm_pilares_estrategias
		left join ui_pilares_objetivos o on o.idpilares_objetivos = e.idpilares_objetivos
        left join ui_pdm_pilares_subtemas ps on ps.idpdm_pilares_subtemas = o.idpdm_pilares_subtemas
		left join ui_pdm_pilares_temas t on t.idpdm_pilares_temas = ps.idpdm_pilares_temas
		left join ui_pdm_pilares p on p.idpdm_pilares = t.idpdm_pilares
		where la.idpdm_pilares_lineas_accion= {$id}");
	}
	public static function getPilarSubtemas($id, $idi){
		return \DB::select("SELECT idpdm_pilares_subtemas as idps,descripcion FROM ui_pdm_pilares_subtemas where idpdm_pilares_temas=? and idinstituciones=?",[$id, $idi]);
	}
	public static function getPilarSubtema($id){
		return \DB::select("SELECT * FROM ui_pdm_pilares_subtemas where idpdm_pilares_subtemas = {$id}");
	}
	public static function getPilarTemaSubtema($id){
		return \DB::select("SELECT ps.descripcion as subtema,pt.descripcion as tema,pp.pilares,pp.color FROM ui_pdm_pilares_subtemas as ps 
		inner join ui_pdm_pilares_temas pt on ps.idpdm_pilares_temas = pt.idpdm_pilares_temas
		inner join ui_pdm_pilares pp on pp.idpdm_pilares = pt.idpdm_pilares
		where ps.idpdm_pilares_subtemas= {$id}");
	}
	public static function getPilarObjetivos($id){
		return \DB::select("SELECT idpilares_objetivos as idpo, clave,descripcion FROM ui_pilares_objetivos where idpdm_pilares_subtemas={$id}");
	}
	public static function getPilarLineasAccion($id){
		return \DB::select("SELECT idpdm_pilares_lineas_accion as idpla,clave,descripcion FROM ui_pdm_pilares_lineas_accion where idpdm_pilares_estrategias={$id}");
	}
	public static function getPdmMetas($id){
		return \DB::select("SELECT idpdm_pilares_metas as id,clave,descripcion as meta FROM ui_pdm_pilares_metas where idpdm_pilares_lineas_accion = {$id}");
	}
	public static function getPilarEstrategias($id){
		return \DB::select("SELECT idpdm_pilares_estrategias as idpe,clave,descripcion FROM ui_pdm_pilares_estrategias where idpilares_objetivos={$id}");
	}
	public static function getPilarObj($id){
		return \DB::select("SELECT * FROM ui_pilares_objetivos where idpilares_objetivos={$id}");
	}
	public static function getPilarEst($id){
		return \DB::select("SELECT * FROM ui_pdm_pilares_estrategias where idpdm_pilares_estrategias={$id}");
	}
	public static function getPilarLinAccion($id){
		return \DB::select("SELECT * FROM ui_pdm_pilares_lineas_accion where idpdm_pilares_lineas_accion = {$id}");
	}
	public static function getPDMMeta($id){
		$result = \DB::select("SELECT idpdm_pilares_metas as id,clave,descripcion as meta FROM ui_pdm_pilares_metas where idpdm_pilares_metas = {$id}");
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getPDM($id){
		return \DB::select("SELECT p.idpdm_pilares as id,p.pilares,pt.descripcion as temas,ps.descripcion as subtema,po.clave as clave_objetivos,po.descripcion as objetivos,pe.clave as clave_estrategicas,pe.descripcion as estrategias,pl.clave as clave_linea,pl.descripcion as linea FROM ui_pdm_pilares p
		inner join ui_pdm_pilares_temas pt on pt.idpdm_pilares = p.idpdm_pilares
		inner join ui_pdm_pilares_subtemas ps on ps.idpdm_pilares_temas = pt.idpdm_pilares_temas
		inner join ui_pilares_objetivos po on po.idpdm_pilares_subtemas = ps.idpdm_pilares_subtemas
		inner join ui_pdm_pilares_estrategias pe on pe.idpilares_objetivos = po.idpilares_objetivos
		inner join ui_pdm_pilares_lineas_accion pl on pl.idpdm_pilares_estrategias = pe.idpdm_pilares_estrategias
		where p.idperiodo={$id}");
	}
}
