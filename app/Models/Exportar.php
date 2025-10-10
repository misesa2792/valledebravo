<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class exportar extends Sximo  {
	
	public function __construct() {
		parent::__construct();
	}
	//FODA
	public static function getExportarFODA($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("indicadores.foda.registrar.excel",$data);
		return self::getReturnExcel($c, "FODA.xls");
	}
	//Seguimiento por Accion
	public static function getExportarSegMetas($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("reporte.proyectos.seguimiento.exportar.excel",$data);
		return self::getReturnExcel($c, "Seguimiento por accion.xls");
	}
	public static function getExportarCuentaPublica($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("reporte.proyectos.seguimiento.cuentapublica.excel",$data);
		return self::getReturnExcel($c, "Cuenta Publica 2024.xls");
	}
	//Calendarización de metas e Indicadores
	public static function getExportarCalMetas($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("reporte.proyectos.calendarizar.exportar.excel",$data);
		return self::getReturnExcel($c, "Calendarizacion.xls");
	}
	public static function getExportarGraficasMetas($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("reporte.proyectos.graficas.exportar.excel",$data);
		return self::getReturnExcel($c, "Graficas.xls");
	}
	public static function getExportarLineaAccion($rows=null,$act_rel=null){
		$data['rows'] = json_encode($rows);
		$data['act_rel'] = json_encode($act_rel);
		$data['j'] = 1;
		$c = view("alineacion.exportar.index",$data);
		return self::getReturnExcel($c, "Línea de Acción.xls");
	}
	public static function getExportarPDM($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("pdm.exportar.excel",$data);
		return self::getReturnExcel($c, "PDM.xls");
	}
	public static function getExportarProyectosPbRMaa($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("proyectopbrmaa.exportar.excel",$data);
		return self::getReturnExcel($c, "Proyecto PbRM-2a - Metas.xls");
	}
	public static function getExportarUsers($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("usuarios.exportar.excel",$data);
		return self::getReturnExcel($c, "Usuarios.xls");
	}
	public static function getExportarCalendarizacionMetas($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("graficas.plantillas.exportar.pbrmc",$data);
		return self::getReturnExcel($c, "Calendarización de Metas.xls");
	}
	public static function getExportarCalendarizacionMetasNew($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("graficas.plantillas.exportar.pbrmcnew",$data);
		return self::getReturnExcel($c, "Calendarización de Metas.xls");
	}
	public static function getExportarDescripcionPrograma($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("graficas.plantillas.exportar.pbrmb",$data);
		return self::getReturnExcel($c, "Descripción del Programa.xls");
	}
	public static function getExportarIndicadores($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("graficas.plantillas.exportar.pbrmd",$data);
		return self::getReturnExcel($c, "Indicadores.xls");
	}
	public static function getExportarIndicadoresMatriz($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("graficas.plantillas.exportar.pbrme",$data);
		return self::getReturnExcel($c, "Indicadores Matriz.xls");
	}
	public static function getExportarMetasDepGen($rows=null){
		$data['rows'] = json_encode($rows);
		$c = view("reporte.exportar.excel",$data);
		return self::getReturnExcel($c, "Metas por dependencia general.xls");
	}
	public static function getReturnExcel($c=null, $name){
		@header('Content-Encoding: UTF-8');
		@header('Content-type: application/ms-excel; charset=UTF-8');
		@header('Content-Length: '.strlen($c));
		@header('Content-disposition: inline; filename="'.$name.'"');
		echo $c;
		exit;
	}
}
