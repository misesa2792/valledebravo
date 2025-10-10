<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class pbrmd extends Sximo  {
	
	protected $table = 'ui_ap_pbrm01d';
	protected $primaryKey = 'idap_pbrm01d';
	protected $moduleID = 4;//Módulo Presupuesto Definitivo, sirve para tomar los años del modulo

	/*
		1.- Presupuesto
		2.- Presupuesto Definitivo  (Programa Anual)
		3.- Proyectos 				(Programa Anual)
		4.- Ante Proyecto 			(Programa Anual)
		5.- PbRM
	*/
	public function __construct() {
		parent::__construct();
	}
	public static function getProyectosAnio($idac,$idanio){
		return \DB::select("SELECT a.idap_pbrm01d as id,p.numero as no_programa,p.descripcion as programa,a.url,a.nombre_indicador FROM ui_ap_pbrm01d a
		inner join ui_programa p on p.idprograma = a.idprograma
		where a.idanio={$idanio} and a.idarea_coordinacion={$idac}");
	}
	public static function getPilares($id){
		//para la parte de Ejes y Pilares no aplica el periodo
		return \DB::select("SELECT idpdm_pilares as id,pilares FROM ui_pdm_pilares WHERE estatus = 1");
		//return \DB::select("SELECT idpdm_pilares as id,pilares FROM ui_pdm_pilares where idperiodo={$id}");
	}
	
	//PDF
	public static function getPbrmd($id){
		return \DB::select("SELECT a.idap_pbrm01d as id,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo,a.temas_desarrollo,pi.pilares,a.idpdm_pilares,a.idprograma,
		a.nombre_indicador,a.formula,a.interpretacion,a.dimencion,a.frecuencia,a.factor,a.tipo,a.desc_factor,a.linea,a.descripcion_meta,
		a.medios_verificacion,a.metas_actividad,a.porc1,a.porc2,a.porc3,a.porc4,a.porc_anual FROM ui_ap_pbrm01d a
		inner join ui_programa pr on pr.idprograma = a.idprograma
		inner join ui_pdm_pilares pi on pi.idpdm_pilares = a.idpdm_pilares
		where a.idap_pbrm01d={$id}");
	}
	public static function getProyectosPbrmd($id){
		return \DB::select("SELECT * FROM ui_ap_pbrm01d_reg where idap_pbrm01d={$id}");
	}
	public static function getProgramas(){
		return \DB::select("SELECT idprograma,numero as no_programa,descripcion as programa FROM ui_programa where estatus = 1 ORDER BY numero ASC");
	}
	public static function getProgramasID($id){
		return \DB::select("SELECT numero as no_programa,objetivo FROM ui_programa where idprograma={$id}");
	}
}
