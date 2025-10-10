<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class caratulapresegreso extends Sximo  {
	
	protected $table = 'ui_pd_pbrm04d';
	protected $primaryKey = 'idpd_pbrm04d';
	protected $moduleID = 1;//Módulo Presupuesto, sirve para tomar los años del modulo

	public function __construct() {
		parent::__construct();
		
	}
	public static function getInfoPdf($id){
		return \DB::select("SELECT d.tipo,a.anio,i.denominacion as no_institucion,i.descripcion as institucion,i.titular_secretario,i.titular_tesoreria,i.logo_izq,d.idinstituciones as idi FROM ui_pd_pbrm04d d
			inner join ui_anio a on a.idanio = d.idanio
			inner join ui_instituciones i on i.idinstituciones = d.idinstituciones
			where d.idpd_pbrm04d = {$id}");
	}
	public static function getInformacionEdit($id){
		return \DB::select("SELECT r.idpd_pbrm04d_reg as id,t.clave as no_capitulo,t.descripcion as capitulo,r.autorizado,r.ejercido,r.presupuesto FROM ui_pd_pbrm04d_reg r
		inner join ui_teso_capitulos t on t.idteso_capitulos = r.idteso_capitulos
		inner join ui_pd_pbrm04d a on a.idpd_pbrm04d = r.idpd_pbrm04d
		where r.idpd_pbrm04d = {$id}");
	}
	public static function getCapitulos(){
		return \DB::select("SELECT idteso_capitulos as id FROM ui_teso_capitulos");
	}
	public static function getExisteRegistro($type, $idi, $idy){
		return \DB::select("SELECT idpd_pbrm04d as id,url FROM ui_pd_pbrm04d where tipo = {$type} and idanio = {$idy} and idinstituciones= {$idi}");
	}
	public static function getValidarReg($idc, $id){
		return \DB::select("SELECT idpd_pbrm04d_reg as id FROM ui_pd_pbrm04d_reg where idpd_pbrm04d = {$id} and idteso_capitulos = {$idc}");
	}
}
