<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class fuentefinanciamiento extends Sximo  {
	
	protected $table = 'ui_teso_ff';
	protected $primaryKey = 'idteso_ff';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

	public static function getFFN3($idy){
		return DB::select("SELECT idteso_ff_n3 as id,clave,descripcion as nombre FROM ui_teso_ff_n3 where idanio = ?",[$idy]);
	}
	public static function getValidarFF($idam, $idff){
		$result = DB::select("SELECT idteso_ff as id FROM ui_teso_ff where idanio_module = {$idam} and idteso_ff_n3={$idff}");
        return reset($result); // Devuelve solo el primer (y único) objeto
	}
	public static function getRegistrosFF($idam){
		return DB::select("SELECT a.idteso_ff as id,n.idteso_ff_n3,n.clave,n.descripcion as fuente,a.m1,a.m2,a.m3,a.m4,a.m5,a.m6,a.m7,a.m8,a.m9,a.m10,a.m11,a.m12,a.total FROM ui_teso_ff a
		INNER JOIN ui_teso_ff_n3 n ON n.idteso_ff_n3 = a.idteso_ff_n3
		where a.idanio_module = ? order by n.clave asc",[$idam]);
	}
	public static function getFuenteFinID($id){
		$result = DB::select("SELECT n.clave,n.descripcion as fuente,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,total FROM ui_teso_ff f
		inner join ui_teso_ff_n3 n on n.idteso_ff_n3 = f.idteso_ff_n3
		where f.idteso_ff = ?",[$id]);
        return reset($result); // Devuelve solo el primer (y único) objeto
	}





	
	
	public static function getDisminuyeFF($idy, $idff){
		return DB::select("SELECT m.*,IFNULL(info.importe, 0) as importe FROM ui_mes m
		left join (SELECT r.d_idmes as idmes,sum(r.importe) as importe FROM ui_teso_trans_int i
			inner join ui_teso_trans_int_reg r on r.idteso_trans_int = i.idteso_trans_int
			where i.idanio = {$idy} and i.std_delete=2 and r.idteso_ff_n3 = {$idff} group by r.d_idmes) as info on info.idmes = m.idmes");
	}
	public static function getAumentaFF($idy, $idff){
		return DB::select("SELECT m.*,IFNULL(info.importe, 0) as importe FROM ui_mes m
		left join (SELECT r.a_idmes as idmes,sum(r.importe) as importe FROM ui_teso_trans_int i
			inner join ui_teso_trans_int_reg r on r.idteso_trans_int = i.idteso_trans_int
			where i.idanio = {$idy} and i.std_delete=2 and r.idteso_ff_n3 = {$idff} group by r.a_idmes) as info on info.idmes = m.idmes");
	}
}
