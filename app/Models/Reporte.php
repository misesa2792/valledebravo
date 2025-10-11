<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class reporte extends Sximo  {
	
	protected $table = 'ui_area';
	protected $primaryKey = 'idarea';
	protected $moduleID = 5;
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
	public static function getReporte($id,$idy,$type=0){
		return \DB::select("SELECT r.idreporte,a.anio,p.numero,p.descripcion as proyecto,p.idproyecto,pro.numero as no_programa,pro.descripcion as programa,r.access_trim1,r.access_trim2,r.access_trim3,r.access_trim4 
			FROM ui_reporte r 
				inner join ui_anio a on a.idanio = r.idanio
			left join ui_proyecto p on p.idproyecto = r.idproyecto
				left join ui_subprograma sub on sub.idsubprograma = p.idsubprograma
				left join ui_programa pro on pro.idprograma = sub.idprograma
			where r.id_area_coordinacion={$id} and r.idanio = {$idy} and r.type = {$type} ORDER BY r.idreporte ASC");
	}
	public static function getRowReporte($id){
		return \DB::select("SELECT r.idreporte,r.idproyecto,a.anio FROM ui_reporte r 
				inner join ui_anio a on a.idanio = r.idanio
			where r.idreporte={$id}");
	}
	public static function getMetas($id){
		return \DB::select("SELECT rg.*,a.anio,tp.descripcion as tipo_operacion,fm.descripcion as frec_medicion FROM ui_reporte_reg rg 
			inner join ui_reporte r on r.idreporte = rg.idreporte
					inner join ui_anio a on a.idanio = r.idanio
			left join ui_tipo_operacion tp on tp.idtipo_operacion = rg.idtipo_operacion
			left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = rg.idfrecuencia_medicion
		where rg.idreporte={$id}");
	}
	public static function getReporteRegistro($id){
		return \DB::select("SELECT r.type,r.id_area_coordinacion as idac,y.anio,i.denominacion as no_institucion,ar.numero as no_dep_gen FROM ui_reporte_reg rg
			inner join ui_reporte r on r.idreporte = rg.idreporte
				inner join ui_anio y on y.idanio = r.idanio
				inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area ar on ar.idarea = ac.idarea
			where rg.idreporte_reg={$id}");
	}


	public static function getReportePDF($idr,$trim,$type,$idanio){
		return \DB::select("SELECT r.* FROM ui_reporte_pdf r  where r.idreporte = {$idr} and r.trim={$trim} and r.type={$type} and r.idanio={$idanio}");
	}
	/*public static function getRowsReportePDF($id){
		return \DB::select("SELECT * FROM ui_reporte_pdf where idreporte_pdf={$id}");
	}
	public static function getRowPdfFoda($id){
		return \DB::select("SELECT idfoda_pdf,url FROM ui_foda_pdf where idfoda_pdf = {$id}");
	}	
	*/
	public static function getReportePDFURL($idrp){
		return \DB::select("SELECT url,type,trim FROM ui_reporte_pdf where idreporte_pdf={$idrp}");
	}
	
	public static function getRowsFoda($idr,$trim){
		return \DB::select("SELECT idfoda as id,descripcion as foda,type FROM ui_foda where idreporte = {$idr} and trimestre = {$trim}");
	}
	public static function getPdfReporte($idr,$trim,$type,$idanio){
		return \DB::select("SELECT r.idreporte_pdf as idrp,r.no_folio,r.no_oficio,r.url FROM ui_reporte_pdf r where r.idreporte = {$idr} and r.trim ={$trim} and r.type={$type} and r.idanio={$idanio} ORDER BY idreporte_pdf DESC");
	}
	public static function getPdfFoda($idr,$trim,$idanio){
		return \DB::select("SELECT idfoda_pdf,url FROM ui_foda_pdf where idreporte = {$idr} and trim = {$trim} and idanio={$idanio}");
	}
	public static function getFodaTema($id,$trim){
		return \DB::select("SELECT * FROM ui_foda_tema where idreporte={$id} and trimestre = {$trim}");
	}
	public static function getProject($idp){
		return \DB::select("SELECT p.idproyecto as idp,p.descripcion as proyecto,p.numero as proy_no,p.descripcion as proy_desc,sp.numero as subp_numero,sp.descripcion as subp_desc,
		pr.numero as pro_numero,pr.descripcion as pro_desc,sf.numero as sub_numero,sf.descripcion as sub_desc,
		f.numero as fun_numero,f.descripcion as fun_desc,fi.numero as fin_numero,fi.descripcion as fin_desc,pr.objetivo,p.objetivo as obj_proyecto FROM ui_proyecto p 
		left join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
		left join ui_programa pr on pr.idprograma = sp.idprograma
		left join ui_subfuncion sf on sf.idsubfuncion = pr.idsubfuncion
		left join ui_funcion f on f.idfuncion =sf.idfuncion
		left join ui_finalidad fi on fi.idfinalidad = f.idfinalidad
		where p.idproyecto={$idp}");
	}
	
	public static function getMetasMeses($id,$mes,$type="all"){
		$tipo = ($type == "all" ? " * " : "sum(cant) as total " );
		return \DB::select("SELECT {$tipo} FROM (SELECT m.idmes,m.mes,REPLACE(IFNULL(r.cant,'mass'),'.00','') as cant,IFNULL(r.total_img,0) as total_img FROM ui_mes m
		left join (select sum(r1.cantidad) as cant,r1.idmes,r1.idreporte_reg,r1.idreporte_mes,sum(i.total) as total_img from ui_reporte_mes r1 
			left join (select count(i1.idreporte_img) as total,i1.idreporte_mes from ui_reporte_img i1 group by i1.idreporte_mes) i on i.idreporte_mes = r1.idreporte_mes
		where r1.idreporte_reg={$id} group by r1.idmes) r on r.idmes = m.idmes) as info where info.idmes in ({$mes})");
	}
	public static function getMetasMesesTotalRegistros($id,$mes){
		return \DB::select("SELECT count(idreporte_mes) as total FROM ui_reporte_mes where idreporte_reg = {$id} and idmes in ({$mes})");
	}
	public static function getMes($id){
		return \DB::select("SELECT * FROM ui_mes where idmes={$id}");
	}
	public static function getRegistroReg($id){
		return \DB::select("SELECT rg.descripcion as meta,rg.unidad_medida,rg.observaciones as obs,rg.obs2,rg.obs3,rg.obs4,a.anio,r.access_trim1,r.access_trim2,r.access_trim3,r.access_trim4 FROM ui_reporte_reg rg 
				inner join ui_reporte r on r.idreporte = rg.idreporte
						inner join ui_anio a on a.idanio = r.idanio
				where rg.idreporte_reg = {$id}");
	}
	public static function getRegistrosMes($id,$idmes){
		return \DB::select("SELECT rm.idreporte_mes as idrm,rm.cantidad as cant,DATE_FORMAT(rm.fecha_rg, '%d-%m-%Y') as fecha_rg,rm.hora_rg,concat_ws(' ',u.username,u.first_name,u.last_name) as usuario FROM ui_reporte_mes rm 
			left join tb_users u on u.id = rm.iduser_rg
			where rm.idreporte_reg={$id} and rm.idmes={$idmes}");
	}
	public static function getRegMes($id){
		return \DB::select("SELECT cantidad as cant,idreporte_reg as idrg,idmes FROM ui_reporte_mes where idreporte_mes={$id}");
	}
	//Archivos del 2024 hacia abajo
	public static function getRegistrosMesImgs($id){
		return \DB::select("SELECT idreporte_img as idri,url,nombre,lower(SUBSTRING_INDEX(url,'.', -1)) as ext,REPLACE(url, './', '') as ruta FROM ui_reporte_img where idreporte_mes={$id}");
	}
	//Para archivos 2025
	public static function getGalleryMesImgs($id){
		return \DB::select("SELECT idreporte_img as idri,url,nombre,ext FROM ui_reporte_img where idreporte_mes={$id}");
	}
	public static function getRegistrosFile($id){
		return \DB::select("SELECT idreporte_img as idri,REPLACE(url, './', '') as ruta FROM ui_reporte_img where idreporte_img={$id}");
	}
	public static function getRegistrosFileID($id){
		return \DB::select("SELECT idreporte_img as idri,url,nombre,ext FROM ui_reporte_img where idreporte_img={$id}");
	}
	public static function getProyectos(){
		return \DB::select("SELECT idreporte,id_area_coordinacion,anio,proyecto,total,prog_anual,TRUNCATE((total*100)/prog_anual,2) AS procentaje,
		TRUNCATE(IFNULL((total1*100)/trim_1,0),2) as por1,TRUNCATE(IFNULL((total2*100)/trim_2,0),2) as por2,TRUNCATE(IFNULL((total3*100)/trim_3,0),2) as por3,TRUNCATE(IFNULL((total4*100)/trim_4,0),2) as por4,coordinacion,direccion
		FROM (SELECT r.idreporte,r.id_area_coordinacion,a.anio,p.descripcion as proyecto,IFNULL(rg2.total,0) as total,IFNULL(rg2.prog_anual,0) as prog_anual,
		rg2.trim_1,rg2.trim_2,rg2.trim_3,rg2.trim_4,rg2.total1,rg2.total2,rg2.total3,rg2.total4,ac.descripcion as coordinacion,ar.descripcion as direccion
		 FROM ui_reporte r
		left join (SELECT rg.idreporte,SUM(rg.prog_anual) as prog_anual,IFNULL(SUM(rm0.total),0) as total,SUM(rg.trim_1) as trim_1,SUM(rg.trim_2) as trim_2,SUM(rg.trim_3) as trim_3,SUM(rg.trim_4) as trim_4,
		SUM(IFNULL(rm11.total1,0)) as total1,SUM(IFNULL(rm12.total2,0)) as total2,SUM(IFNULL(rm13.total3,0)) as total3,SUM(IFNULL(rm14.total4,0)) as total4 FROM ui_reporte_reg rg 
		left join (select sum(rm1.cantidad) as total,rm1.idreporte_reg from ui_reporte_mes rm1 group by rm1.idreporte_reg) as rm0 on rm0.idreporte_reg = rg.idreporte_reg
		left join (select sum(rm1.cantidad) as total1,rm1.idreporte_reg from ui_reporte_mes rm1 where rm1.idmes in (1,2,3) group by rm1.idreporte_reg) as rm11 on rm11.idreporte_reg = rg.idreporte_reg
		left join (select sum(rm1.cantidad) as total2,rm1.idreporte_reg from ui_reporte_mes rm1 where rm1.idmes in (4,5,6) group by rm1.idreporte_reg) as rm12 on rm12.idreporte_reg = rg.idreporte_reg
		left join (select sum(rm1.cantidad) as total3,rm1.idreporte_reg from ui_reporte_mes rm1 where rm1.idmes in (7,8,9) group by rm1.idreporte_reg) as rm13 on rm13.idreporte_reg = rg.idreporte_reg
		left join (select sum(rm1.cantidad) as total4,rm1.idreporte_reg from ui_reporte_mes rm1 where rm1.idmes in (10,11,12) group by rm1.idreporte_reg) as rm14 on rm14.idreporte_reg = rg.idreporte_reg
		group by rg.idreporte) as rg2 on rg2.idreporte = r.idreporte
		 inner join ui_proyecto p on p.idproyecto = r.idproyecto
		 inner join ui_anio a on a.idanio = r.idanio
		 inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
		 inner join ui_area ar on ar.idarea = ac.idarea
		 where r.type = 0 ) AS info  order by procentaje desc");
	}
	public static function getExportMetas(){
		return \DB::select("SELECT r.idreporte as id,a.numero as no_dep_gen,ac.numero as no_dep_aux,p.numero as no_proyecto FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where r.type = 1 and r.idanio = 2 order by a.numero,ac.numero asc");
	}
	public static function getMirEstatus($idrm){
		return \DB::table('ui_reporte_mir as rm')
				->join('ui_programa_reg as pr', 'pr.idprograma_reg', '=', 'rm.idprograma_reg')
				->join('ui_ind_estrategicos as ie', 'ie.idind_estrategicos', '=', 'pr.idind_estrategicos')
				->select('ie.codigo as mir','ie.indicador', 'aplica1', 'aplica2', 'aplica3', 'aplica4')
				->where('rm.idreporte_mir', $idrm)
				->first();
	}
	public static function getVerificarIDReporte($idi, $idy, $idac, $idp, $type){
       return DB::table('ui_reporte')
			->where('idinstituciones', $idi)
			->where('idanio', $idy)
			->where('id_area_coordinacion', $idac)
			->where('idproyecto', $idp)
			->where('type', $type)
			->select('idreporte')
			->first();
	}
	public static function getIDprogramaProyecto($id){
       return DB::table('ui_proyecto as p')
		->join('ui_subprograma as sp', 'sp.idsubprograma', '=', 'p.idsubprograma')
		->join('ui_programa as pr', 'pr.idprograma', '=', 'sp.idprograma')
		->where('p.idproyecto', $id)
		->select('pr.idprograma', 'pr.numero', 'pr.descripcion')
		->first();
	}
	public static function getMatrices($id){
		return DB::select("SELECT idreporte_mir as id,ie.codigo as mir,ie.indicador,mf.formula,f.descripcion as frecuencia,rm.iddimension_atiende,rm.aplica1,rm.aplica2,rm.aplica3,rm.aplica4 FROM ui_reporte_mir rm 
		inner join ui_programa_reg pr on pr.idprograma_reg = rm.idprograma_reg
			inner join ui_ind_estrategicos ie on  ie.idind_estrategicos = pr.idind_estrategicos
			left join ui_mir_formula mf on mf.idmir_formula = pr.idmir_formula
			left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = pr.idfrecuencia_medicion
		where rm.idreporte = ?",[$id]);
	}















	/*
	 * 
	 * 
	 *Nuevo módulo 
	 * 
	 * 
	 */
	public static function getProjectsForYearsFull($idy,$type=0,$idi){//Revisado - 07-03-2025
		return \DB::select("SELECT r.idreporte as id,p.numero as no_proyecto,p.descripcion as proyecto,pro.numero as no_programa,pro.descripcion as programa,
		r.rec1,r.rec2,r.rec3,r.rec4,
		ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sub on sub.idsubprograma = p.idsubprograma
			inner join ui_programa pro on pro.idprograma = sub.idprograma
            inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idy} and r.type = {$type} and r.idinstituciones = {$idi} ORDER BY a.numero,ac.numero ASC");
	}
	public static function getProjectsForYears($idac,$idy,$type=0,$idi){//Revisado - 07-03-2025
		return \DB::select("SELECT r.idreporte as id,p.numero as no_proyecto,p.descripcion as proyecto,pro.numero as no_programa,pro.descripcion as programa,
		r.oficio1,r.oficio2,r.oficio3,r.oficio4,r.rec1,r.rec2,r.rec3,r.rec4,r.jus1,r.jus2,r.jus3,r.jus4,
		r.foda1,r.foda2,r.foda3,r.foda4 FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sub on sub.idsubprograma = p.idsubprograma
			inner join ui_programa pro on pro.idprograma = sub.idprograma
		where r.id_area_coordinacion = {$idac} and r.idanio = {$idy} and r.type = {$type} and r.idinstituciones = {$idi} ORDER BY p.numero ASC");
	}
	public static function getProjectsForYearsPbRMOchob($idam,$idi,$type=1,$ida){//Revisado - 07-03-2025
		$cad = ($ida > 0 ? ' and a.idarea = '.$ida : '');
		return \DB::select("SELECT r.idreporte as id,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sub on sub.idsubprograma = p.idsubprograma
				inner join ui_programa pro on pro.idprograma = sub.idprograma
            inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idam} and r.type = {$type} {$cad} and r.idinstituciones = {$idi} ORDER BY p.numero ASC");
	}
	public static function getReportesProyectosSeguimiento($idy,$type,$idi){//Revisado - 07-03-2025
		return \DB::select("SELECT sub2.*,sub2.prog_anual as inicial_1,sub2.mod_1 as inicial_2,sub2.mod_2 as inicial_3,sub2.mod_3 as inicial_4,ROUND(((sub2.total_realizado * 100)/sub2.prog_anual),2) as total_porcentaje,ROUND((100-((sub2.total_realizado * 100)/sub2.prog_anual)),2) as porcentaje_restante FROM (
					SELECT sub1.*,(sub1.cant_1 + sub1.cant_2 + sub1.cant_3 + sub1.cant_4) as total_realizado,sub1.cant_1  as avance_1,(sub1.cant_1 + sub1.cant_2) as avance_2,((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) as avance_3,(((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) + sub1.cant_4) as avance_4,
						(sub1.prog_anual + sub1.resta_1) as mod_1, ((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) as mod_2, (((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) as mod_3, ((((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) + sub1.resta_4) as mod_4 FROM (
						SELECT qry.*,(qry.cant_1 - qry.trim_1) as resta_1,(qry.cant_2 - qry.trim_2) as resta_2,(qry.cant_3 - qry.trim_3) as resta_3,(qry.cant_4 - qry.trim_4) as resta_4 FROM (
							SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (
								
								SELECT 
									r.idreporte_reg AS id,
									y.anio,
                                    a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,
									r.no_accion AS codigo,
									r.descripcion AS meta,
									r.unidad_medida,
									r.prog_anual,
									r.trim_1,
									r.trim_2,
									r.trim_3,
									r.trim_4,
									IFNULL(m.cant_1, 0) AS cant_1,
									IFNULL(m.cant_2, 0) AS cant_2,
									IFNULL(m.cant_3, 0) AS cant_3,
									IFNULL(m.cant_4, 0) AS cant_4,
									IFNULL(m.registros_1, 0) AS registros_1,
									IFNULL(m.registros_2, 0) AS registros_2,
									IFNULL(m.registros_3, 0) AS registros_3,
									IFNULL(m.registros_4, 0) AS registros_4
								FROM 
									ui_reporte_reg r
                                    inner join ui_reporte r2 on r2.idreporte = r.idreporte
										inner join ui_proyecto p on p.idproyecto = r2.idproyecto
										inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r2.id_area_coordinacion
											inner join ui_area a on a.idarea = ac.idarea
										inner join ui_anio y on y.idanio = r2.idanio
									LEFT JOIN (
										SELECT 
											m.idreporte_reg,
											SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
											SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
											SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
											SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4,
											COUNT(CASE WHEN m.idmes IN (1, 2, 3) THEN m.idreporte_mes END) AS registros_1,
											COUNT(CASE WHEN m.idmes IN (4, 5, 6) THEN m.idreporte_mes END) AS registros_2,
											COUNT(CASE WHEN m.idmes IN (7, 8, 9) THEN m.idreporte_mes END) AS registros_3,
											COUNT(CASE WHEN m.idmes IN (10, 11, 12) THEN m.idreporte_mes END) AS registros_4
										FROM 
											ui_reporte_mes m
											INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
												inner join ui_reporte r1 on r1.idreporte = g.idreporte
										WHERE 
											 r1.idanio = {$idy} and r1.type = {$type} and r1.idinstituciones = {$idi}
										GROUP BY 
											m.idreporte_reg
									) AS m ON m.idreporte_reg = r.idreporte_reg
								WHERE 
									 r2.idanio = {$idy} and r2.type = {$type} and r2.idinstituciones = {$idi}
				) AS info
			) AS qry
		) AS sub1
	) AS sub2 ORDER BY sub2.no_dep_gen,sub2.no_dep_aux,sub2.no_proyecto,sub2.codigo ASC");
	}
	//Para los idanio menor a 3 (16-03-2025)
	public static function getReportesProyectos($idr){//Revisado - 07-03-2025
		return \DB::select("SELECT sub2.*,sub2.prog_anual as inicial_1,sub2.mod_1 as inicial_2,sub2.mod_2 as inicial_3,sub2.mod_3 as inicial_4,ROUND(((sub2.total_realizado * 100)/sub2.prog_anual),2) as total_porcentaje,ROUND((100-((sub2.total_realizado * 100)/sub2.prog_anual)),2) as porcentaje_restante FROM (
					SELECT sub1.*,(sub1.cant_1 + sub1.cant_2 + sub1.cant_3 + sub1.cant_4) as total_realizado,sub1.cant_1  as avance_1,(sub1.cant_1 + sub1.cant_2) as avance_2,((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) as avance_3,(((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) + sub1.cant_4) as avance_4,
						(sub1.prog_anual + sub1.resta_1) as mod_1, ((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) as mod_2, (((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) as mod_3, ((((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) + sub1.resta_4) as mod_4 FROM (
						SELECT qry.*,(qry.cant_1 - qry.trim_1) as resta_1,(qry.cant_2 - qry.trim_2) as resta_2,(qry.cant_3 - qry.trim_3) as resta_3,(qry.cant_4 - qry.trim_4) as resta_4 FROM (
							SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (
								
								SELECT 
									r.idreporte_reg AS id,
									r.no_accion AS codigo,
									r.descripcion AS meta,
									tp.descripcion AS tipo_operacion,
									r.unidad_medida,
									r.observaciones AS obs_1,
									r.obs2 AS obs_2,
									r.obs3 AS obs_3,
									r.obs4 AS obs_4,
									r.prog_anual,
									r.trim_1,
									r.trim_2,
									r.trim_3,
									r.trim_4,
									IFNULL(m.cant_1, 0) AS cant_1,
									IFNULL(m.cant_2, 0) AS cant_2,
									IFNULL(m.cant_3, 0) AS cant_3,
									IFNULL(m.cant_4, 0) AS cant_4,
									IFNULL(m.registros_1, 0) AS registros_1,
									IFNULL(m.registros_2, 0) AS registros_2,
									IFNULL(m.registros_3, 0) AS registros_3,
									IFNULL(m.registros_4, 0) AS registros_4
								FROM 
									ui_reporte_reg r
									LEFT JOIN ui_tipo_operacion tp ON tp.idtipo_operacion = r.idtipo_operacion
									LEFT JOIN (
										SELECT 
											m.idreporte_reg,
											SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
											SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
											SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
											SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4,
											COUNT(CASE WHEN m.idmes IN (1, 2, 3) THEN m.idreporte_mes END) AS registros_1,
											COUNT(CASE WHEN m.idmes IN (4, 5, 6) THEN m.idreporte_mes END) AS registros_2,
											COUNT(CASE WHEN m.idmes IN (7, 8, 9) THEN m.idreporte_mes END) AS registros_3,
											COUNT(CASE WHEN m.idmes IN (10, 11, 12) THEN m.idreporte_mes END) AS registros_4
										FROM 
											ui_reporte_mes m
											INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
										WHERE 
											g.idreporte = {$idr}
										GROUP BY 
											m.idreporte_reg
									) AS m ON m.idreporte_reg = r.idreporte_reg
								WHERE 
									r.idreporte = {$idr}
								ORDER BY 
									r.no_accion ASC
											
				) AS info
			) AS qry
		) AS sub1
	) AS sub2");
	}
	//Para los idanio mayor o igual a 4 (16-03-2025)
	public static function getReportesProyectosMIR($id){//Revisado - 07-03-2025
		return \DB::select("SELECT sub2.*,sub2.prog_anual as inicial_1,sub2.mod_1 as inicial_2,sub2.mod_2 as inicial_3,sub2.mod_3 as inicial_4,ROUND(((sub2.total_realizado * 100)/sub2.prog_anual),2) as total_porcentaje,ROUND((100-((sub2.total_realizado * 100)/sub2.prog_anual)),2) as porcentaje_restante FROM (
						SELECT sub1.*,(sub1.cant_1 + sub1.cant_2 + sub1.cant_3 + sub1.cant_4) as total_realizado,sub1.cant_1  as avance_1,(sub1.cant_1 + sub1.cant_2) as avance_2,((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) as avance_3,(((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) + sub1.cant_4) as avance_4,
							(sub1.prog_anual + sub1.resta_1) as mod_1, ((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) as mod_2, (((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) as mod_3, ((((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) + sub1.resta_4) as mod_4 FROM (
							SELECT qry.*,(qry.cant_1 - qry.trim_1) as resta_1,(qry.cant_2 - qry.trim_2) as resta_2,(qry.cant_3 - qry.trim_3) as resta_3,(qry.cant_4 - qry.trim_4) as resta_4 FROM (
								SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (
									
									SELECT 
										r.idreporte_reg AS id,
										r.idreporte_mir,
										ie.codigo,
										pr.idmir_formula,
										mu.formula,
										r.descripcion AS meta,
										ie.indicador,
										tp.descripcion AS tipo_operacion,
										fm.descripcion AS frecuencia_medicion,
										r.unidad_medida,
										rm.rec1,rm.rec2,rm.rec3,rm.rec4,
										rm.aplica1,rm.aplica2,rm.aplica3,rm.aplica4,
										r.observaciones AS obs_1,r.obs2 AS obs_2,r.obs3 AS obs_3,r.obs4 AS obs_4,
										r.prog_anual,r.trim_1,r.trim_2,r.trim_3,r.trim_4,
										IFNULL(m.cant_1, 0) AS cant_1,IFNULL(m.cant_2, 0) AS cant_2,IFNULL(m.cant_3, 0) AS cant_3,IFNULL(m.cant_4, 0) AS cant_4,
										IFNULL(m.registros_1, 0) AS registros_1,IFNULL(m.registros_2, 0) AS registros_2,IFNULL(m.registros_3, 0) AS registros_3,IFNULL(m.registros_4, 0) AS registros_4
									FROM 
										ui_reporte_reg r
										INNER JOIN ui_reporte_mir rm ON rm.idreporte_mir = r.idreporte_mir
											INNER JOIN ui_programa_reg pr on pr.idprograma_reg = rm.idprograma_reg
												inner join ui_ind_estrategicos ie on ie.idind_estrategicos = pr.idind_estrategicos
												LEFT JOIN ui_mir_formula mu ON mu.idmir_formula = pr.idmir_formula
												LEFT JOIN ui_frecuencia_medicion fm ON fm.idfrecuencia_medicion = pr.idfrecuencia_medicion
											LEFT JOIN ui_tipo_operacion tp ON tp.idtipo_operacion = r.idtipo_operacion
										LEFT JOIN (
											SELECT 
												m.idreporte_reg,
												SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
												SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
												SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
												SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4,
												COUNT(CASE WHEN m.idmes IN (1, 2, 3) THEN m.idreporte_mes END) AS registros_1,
												COUNT(CASE WHEN m.idmes IN (4, 5, 6) THEN m.idreporte_mes END) AS registros_2,
												COUNT(CASE WHEN m.idmes IN (7, 8, 9) THEN m.idreporte_mes END) AS registros_3,
												COUNT(CASE WHEN m.idmes IN (10, 11, 12) THEN m.idreporte_mes END) AS registros_4
											FROM 
												ui_reporte_mes m
												INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
											WHERE 
												g.idreporte = {$id}
											GROUP BY 
												m.idreporte_reg
										) AS m ON m.idreporte_reg = r.idreporte_reg
									WHERE 
										r.idreporte = {$id}
									ORDER BY 
										r.no_accion ASC
												
					) AS info
				) AS qry
			) AS sub1
		) AS sub2");
	}
	public static function getReportesProyectosMIRRec($idrm){//Revisado - 07-03-2025
		return \DB::select("SELECT sub2.*,sub2.prog_anual as inicial_1,sub2.mod_1 as inicial_2,sub2.mod_2 as inicial_3,sub2.mod_3 as inicial_4,ROUND(((sub2.total_realizado * 100)/sub2.prog_anual),2) as total_porcentaje,ROUND((100-((sub2.total_realizado * 100)/sub2.prog_anual)),2) as porcentaje_restante FROM (
						SELECT sub1.*,(sub1.cant_1 + sub1.cant_2 + sub1.cant_3 + sub1.cant_4) as total_realizado,sub1.cant_1  as avance_1,(sub1.cant_1 + sub1.cant_2) as avance_2,((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) as avance_3,(((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) + sub1.cant_4) as avance_4,
							(sub1.prog_anual + sub1.resta_1) as mod_1, ((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) as mod_2, (((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) as mod_3, ((((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) + sub1.resta_4) as mod_4 FROM (
							SELECT qry.*,(qry.cant_1 - qry.trim_1) as resta_1,(qry.cant_2 - qry.trim_2) as resta_2,(qry.cant_3 - qry.trim_3) as resta_3,(qry.cant_4 - qry.trim_4) as resta_4 FROM (
								SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4 FROM (
									
									SELECT 
										r.idreporte_reg AS id,
										r.idreporte_mir,
										ie.codigo,
										pr.idmir_formula,
										r.descripcion AS meta,
										ie.indicador,
										tp.descripcion AS tipo_operacion,
										fm.descripcion AS frecuencia_medicion,
										r.unidad_medida,
										r.observaciones AS obs_1,
										r.obs2 AS obs_2,
										r.obs3 AS obs_3,
										r.obs4 AS obs_4,
										r.prog_anual,
										r.trim_1,
										r.trim_2,
										r.trim_3,
										r.trim_4,
										IFNULL(m.cant_1, 0) AS cant_1,
										IFNULL(m.cant_2, 0) AS cant_2,
										IFNULL(m.cant_3, 0) AS cant_3,
										IFNULL(m.cant_4, 0) AS cant_4,
										IFNULL(m.registros_1, 0) AS registros_1,
										IFNULL(m.registros_2, 0) AS registros_2,
										IFNULL(m.registros_3, 0) AS registros_3,
										IFNULL(m.registros_4, 0) AS registros_4
									FROM 
										ui_reporte_reg r
										INNER JOIN ui_reporte_mir rm ON rm.idreporte_mir = r.idreporte_mir
											INNER JOIN ui_programa_reg pr on pr.idprograma_reg = rm.idprograma_reg
													inner join ui_ind_estrategicos ie on ie.idind_estrategicos = pr.idind_estrategicos
													LEFT JOIN ui_frecuencia_medicion fm ON fm.idfrecuencia_medicion = pr.idfrecuencia_medicion
											LEFT JOIN ui_tipo_operacion tp ON tp.idtipo_operacion = r.idtipo_operacion
										LEFT JOIN (
											SELECT 
												m.idreporte_reg,
												SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
												SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
												SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
												SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4,
												COUNT(CASE WHEN m.idmes IN (1, 2, 3) THEN m.idreporte_mes END) AS registros_1,
												COUNT(CASE WHEN m.idmes IN (4, 5, 6) THEN m.idreporte_mes END) AS registros_2,
												COUNT(CASE WHEN m.idmes IN (7, 8, 9) THEN m.idreporte_mes END) AS registros_3,
												COUNT(CASE WHEN m.idmes IN (10, 11, 12) THEN m.idreporte_mes END) AS registros_4
											FROM 
												ui_reporte_mes m
												INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
											WHERE 
												g.idreporte_mir = {$idrm}
											GROUP BY 
												m.idreporte_reg
										) AS m ON m.idreporte_reg = r.idreporte_reg
									WHERE 
										r.idreporte_mir = {$idrm}
												
					) AS info
				) AS qry
			) AS sub1
		) AS sub2");
	}
	public static function getReporteYear($id){
		return \DB::select("SELECT idanio FROM ui_reporte r where idreporte = {$id}");
	}
	public static function getReporteRegMIR($id){
		return \DB::select("SELECT r.idreporte_reg as id,r.no_accion as mir,r.descripcion as indicador,r.unidad_medida,t.descripcion as tipo_operacion,r.prog_anual,
			r.trim_1,r.trim_2,r.trim_3,r.trim_4 FROM ui_reporte_reg r 
			left join ui_tipo_operacion t on t.idtipo_operacion = r.idtipo_operacion
			where r.idreporte_mir = {$id}");
	}
	
	public static function getMIRSemaforo(){
		return \DB::select("SELECT idmir_semaforo as id,semaforo,descripcion FROM ui_mir_semaforo");
	}
	public static function getMIRSemaforoID($id){
		return \DB::select("SELECT semaforo FROM ui_mir_semaforo where idmir_semaforo = {$id}");
	}
	public static function getReporteRegMIRCant($id){
		return \DB::select("SELECT 
							SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant1,
							SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant2,
							SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant3,
							SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant4
						FROM 
							ui_reporte_mes m
						WHERE 
							m.idreporte_reg = {$id}
							AND m.idmes BETWEEN 1 AND 12
						GROUP BY 
							m.idreporte_reg");
	}
	public static function getInfoReporteReconduccion($id){//Revisado - 07-03-2025
		return \DB::select("SELECT r.idreporte as id,r.type,y.idanio,y.anio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,
			pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,p.numero as no_proyecto,p.descripcion as proyecto,
			m.descripcion as municipio,i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,a.titular as t_dep_gen,
			a.cargo as c_dep_gen,
			r.oficio1,r.oficio2,r.oficio3,r.oficio4,pi.numero as no_pilar,pi.pilares as pilar,pr.tema_desarrollo,r.presupuesto FROM ui_reporte r 
				inner join ui_anio y on y.idanio = r.idanio
				inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
						inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			where r.idreporte = ?",[$id]);
	}
	public static function getInfoReporteReconduccionMIR($id){//Revisado - 07-03-2025
		return \DB::select("SELECT r.idreporte as id,ie.codigo as mir,preg.idmir_formula,ie.indicador as nombre_indicador,r.type,y.idanio,y.anio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,
			pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,p.numero as no_proyecto,p.descripcion as proyecto,
			m.descripcion as municipio,i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,a.titular as t_dep_gen,
			a.cargo as c_dep_gen,
			r.oficio1,r.oficio2,r.oficio3,r.oficio4,pi.numero as no_pilar,pi.pilares as pilar,pr.tema_desarrollo,r.presupuesto FROM ui_reporte_mir rm
            INNER JOIN ui_programa_reg preg on preg.idprograma_reg = rm.idprograma_reg
				inner join ui_ind_estrategicos ie on ie.idind_estrategicos =preg.idind_estrategicos
			inner join ui_reporte r on r.idreporte = rm.idreporte
			inner join ui_anio y on y.idanio = r.idanio
			inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			where rm.idreporte_mir = {$id}");
	}
	public static function getReporteDictamenInfo($idac){//Revisado - 07-03-2025
		return \DB::select("SELECT y.anio,y.idanio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,
		i.idinstituciones as idi,i.denominacion as no_institucion,i.descripcion as institucion,a.titular as t_dep_gen,a.cargo as c_dep_gen,m.descripcion as municipio FROM ui_area_coordinacion ac
		inner join ui_area a on a.idarea = ac.idarea
			inner join ui_anio y on y.idanio = a.idanio
			inner join ui_instituciones i on i.idinstituciones = a.idinstituciones
					inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where ac.idarea_coordinacion = {$idac}");
	}
	public static function getIndicadoresMIR($id){
		return \DB::select("SELECT m.idreporte_mir as id,m.aplica1,m.aplica2,m.aplica3,m.aplica4,g.codigo as cod_indicador,m.mir,m.nombre_indicador,f.descripcion as frecuencia,
		l.formula,m.rec1,m.rec2,m.rec3,m.rec4 FROM ui_reporte_mir m 
		left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
		left join ui_mir_formula l on l.idmir_formula = m.idmir_formula
        left join ui_ind_estrategicos g on g.idind_estrategicos = m.idind_estrategicos
		where m.idreporte = {$id}");
	}
	public static function getMirInformacion($id){
		return \DB::select("SELECT ie.codigo as mir,ie.indicador,
		m.aplica1,m.aplica2,m.aplica3,m.aplica4,
        mf.idmir_formula,preg.formula as form_larga,mf.formula,m.interpretacion,m.desc_factor,f.descripcion as frecuencia,ti.descripcion as tipo_indicador,m.iddimension_atiende,m.factor,
		m.linea,m.descripcion_meta,preg.medios,m.metas_actividad,
        p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pr.tema_desarrollo,pi.numero as no_pilar,pi.pilares as pilar,
        a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,m.ambito,m.cobertura FROM ui_reporte_mir m 
        inner join ui_programa_reg preg on preg.idprograma_reg = m.idprograma_reg
			inner join ui_ind_estrategicos ie on  ie.idind_estrategicos = preg.idind_estrategicos
			left join ui_mir_formula mf on mf.idmir_formula = preg.idmir_formula
			left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = preg.idfrecuencia_medicion
            left join ui_tipo_indicador ti on ti.idtipo_indicador = preg.idtipo_indicador
        inner join ui_reporte r on r.idreporte = m.idreporte
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where m.idreporte_mir = ?",[$id]);
		//old
		return \DB::select("SELECT m.mir,m.idind_estrategicos,m.nombre_indicador,m.aplica1,m.aplica2,m.aplica3,m.aplica4,m.idmir_formula,m.formula,m.interpretacion,m.desc_factor,m.idfrecuencia_medicion,m.iddimension_atiende,m.factor,m.idtipo_indicador,
		m.linea,m.descripcion_meta,m.medios_verificacion,m.metas_actividad,
        p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pr.tema_desarrollo,pi.numero as no_pilar,pi.pilares as pilar,
        a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,m.ambito,m.cobertura FROM ui_reporte_mir m 
        inner join ui_reporte r on r.idreporte = m.idreporte
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where m.idreporte_mir = {$id}");
	}
	public static function getMirReporteInformacion($id){
		return \DB::select("SELECT p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pr.tema_desarrollo,pi.numero as no_pilar,pi.pilares as pilar,
        a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux FROM ui_reporte r
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where r.idreporte = {$id}");
	}
	public static function getMirMetas($id){
		return \DB::select("SELECT r.idreporte_reg as id,r.idind_estrategicos_reg,g.nombre_corto,r.descripcion as meta,r.unidad_medida,r.idtipo_operacion,r.prog_anual,r.trim_1,r.trim_2,r.trim_3,r.trim_4 FROM ui_reporte_reg r 
				left join ui_ind_estrategicos_reg g on g.idind_estrategicos_reg = r.idind_estrategicos_reg
				where r.idreporte_mir = {$id}");
	}
	public static function getMirFormulas(){
		return \DB::select("SELECT idmir_formula as id,formula FROM ui_mir_formula");
	}
	public static function getMirEvaluacion($id){
		return \DB::select("SELECT idreporte_mir_eva as id,trim,idmir_semaforo as semaforo,status FROM ui_reporte_mir_eva where idreporte_mir = {$id} order by trim asc");
	}
	//Usando en indicadores PbRM-08b
	public static function getDependenciasGenerales($idy, $idi){
		return \DB::select("SELECT a.idarea as id,a.numero as no_dep_gen,a.descripcion as dep_gen FROM ui_area a
		where a.idanio = {$idy} and a.estatus = 1 and a.idinstituciones = {$idi} order by a.numero asc");
	}
	public static function getInfoReporteMIRAll($idy,$trim,$idi){
		return \DB::select("SELECT m.idreporte_mir as id,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux, 
		pi.numero as no_pilar,pi.pilares as pilar,pr.tema_desarrollo,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,p.numero as no_proyecto,p.descripcion as proyecto,
		m.mir,m.nombre_indicador,m.formula,m.interpretacion,d.descripcion as dimension_atiende,f.descripcion as frecuencia,m.factor,ti.descripcion as tipo_indicador,m.desc_factor,m.linea,
		a.titular as t_dep_gen,a.cargo as c_dep_gen,m.idmir_formula,m.aplica1,m.aplica2,m.aplica3,m.aplica4,m.ambito,m.cobertura,ms.semaforo,
        e.desc_meta,e.desc_res,e.evaluacion,e.meta_anual,e.programado,e.alcanzado,e.ef,e.a_programado,e.a_alcanzado,e.a_ef FROM ui_reporte_mir_eva e
		left join ui_mir_semaforo ms on ms.idmir_semaforo = e.idmir_semaforo
		inner join ui_reporte_mir m on m.idreporte_mir = e.idreporte_mir
			left join ui_dimension_atiende d on d.iddimension_atiende = m.iddimension_atiende
			left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
			left join ui_tipo_indicador ti on ti.idtipo_indicador = m.idtipo_indicador
			inner join ui_reporte r on r.idreporte = m.idreporte
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
		where r.idanio = {$idy} and r.idinstituciones = {$idi} and e.trim = {$trim} ORDER BY a.numero,ac.numero asc");//limit 10
	}
	public static function getInfoInstitucion($idi){
		return \DB::select("SELECT i.idinstituciones as idi,i.denominacion as no_institucion,m.descripcion as municipio FROM ui_instituciones i
			inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where i.idinstituciones = {$idi}");
	}
	public static function getInfoYear($idy){
		return \DB::select("SELECT anio FROM ui_anio where idanio = {$idy}");
	}
	public static function getInfoReporteMIREvaluacion($id){
		return \DB::select("SELECT m.aplica1,m.aplica2,m.aplica3,m.aplica4,m.ambito,m.cobertura,m.descripcion_meta,y.idanio,y.anio,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,i.idinstituciones as idi,i.denominacion as no_institucion,n.descripcion as municipio, 
		pi.numero as no_pilar,pi.pilares as pilar,pr.tema_desarrollo,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,p.numero as no_proyecto,p.descripcion as proyecto,
		m.mir,m.nombre_indicador,m.formula,m.interpretacion,d.descripcion as dimension_atiende,f.descripcion as frecuencia,m.factor,ti.descripcion as tipo_indicador,m.desc_factor,m.linea,
		a.titular as t_dep_gen,a.cargo as c_dep_gen,m.idmir_formula, 
        e.trim,e.idreporte_mir,e.status,e.desc_meta,e.desc_res,e.evaluacion,e.meta_anual,e.programado,e.alcanzado,e.ef,e.a_programado,e.a_alcanzado,e.a_ef,e.idmir_semaforo,ms.semaforo FROM ui_reporte_mir_eva e
		inner join ui_reporte_mir m on m.idreporte_mir = e.idreporte_mir
        left join ui_mir_semaforo ms on ms.idmir_semaforo = e.idmir_semaforo
		left join ui_dimension_atiende d on d.iddimension_atiende = m.iddimension_atiende
		left join ui_frecuencia_medicion f on f.idfrecuencia_medicion = m.idfrecuencia_medicion
		left join ui_tipo_indicador ti on ti.idtipo_indicador = m.idtipo_indicador
		inner join ui_reporte r on r.idreporte = m.idreporte
			inner join ui_anio y on y.idanio = y.idanio
			inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
				inner join ui_municipios n on n.idmunicipios = i.idmunicipios
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_pdm_pilares pi on pi.idpdm_pilares = pr.idpdm_pilares
		where e.idreporte_mir_eva = {$id}");
	}
	
	public static function getReporteDictamenPdf($idac, $type){
		return \DB::select("SELECT idreporte_dic as id,dic1,dic2,dic3,dic4 FROM ui_reporte_dic 
		where idarea_coordinacion = {$idac} and type = {$type}");
	}
	public static function getInfoReporte($id){
		return \DB::select("SELECT y.anio,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.numero as no_dep_gen,a.descripcion as dep_gen,i.denominacion as no_institucion,i.descripcion as institucion,
			pr.numero as no_programa,pr.descripcion as programa,
            sp.numero as no_subprograma,sp.descripcion as subprograma,
            p.numero as no_proyecto,p.descripcion as proyecto,
            sf.numero as no_subfuncion,sf.descripcion as subfuncion,
            f.numero as no_funcion,f.descripcion as funcion,
            fi.numero as no_finalidad,fi.descripcion as finalidad
		 FROM ui_reporte r 
				inner join ui_anio y on y.idanio = r.idanio
                inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_subfuncion sf on sf.idsubfuncion = pr.idsubfuncion
							left join ui_funcion f on f.idfuncion = sf.idfuncion
								left join ui_finalidad fi on fi.idfinalidad = f.idfinalidad
			where r.idreporte = {$id}");
	}
	public static function getReporteImg($id){
		return \DB::select("SELECT var.idmes,var.mes,var.trim,REPLACE(IFNULL(var.cant,'mass'),'.00','') as cant,IFNULL(var.total_img,0) as total_img from (
			SELECT m.idmes,m.mes,m.trim,sum(v.cant) as cant,sum(v.total_img) as total_img FROM ui_mes m 
			left join (
				select sum(info.cant) as cant,info.idmes,sum(info.total_img) as total_img from 
					(
						SELECT m1.idreporte_mes,m1.idmes,sum(m1.cantidad) as cant, IFNULL(i.total_img,0) as total_img FROM ui_reporte_mes m1
						left join (SELECT count(i1.idreporte_mes) as total_img,i1.idreporte_mes FROM ui_reporte_img i1
							inner join ui_reporte_mes m1 on m1.idreporte_mes = i1.idreporte_mes
							where m1.idreporte_reg = {$id} group by i1.idreporte_mes ) i on i.idreporte_mes = m1.idreporte_mes
						where m1.idreporte_reg = {$id} group by m1.idreporte_mes
					) as info group by info.idmes)
                    AS v on v.idmes = m.idmes group by m.idmes order by m.idmes asc
		) as var");
	}
	/*
    |--------------------------------------------------------------------------
    | INDICADOR FODA
    |--------------------------------------------------------------------------
    */
	public static function getInfoFODA($id){
		return \DB::select("SELECT pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,pr.tema_desarrollo,sp.numero as no_subprograma,sp.descripcion as subprograma,p.numero as no_proyecto,p.descripcion as proyecto,
				sf.numero as no_subfuncion,sf.descripcion as subfuncion,f.numero as no_funcion,f.descripcion as funcion,fi.numero as no_finalidad,fi.descripcion as finalidad,
				a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.titular as t_dep_gen,a.cargo as c_dep_gen,y.idanio,y.anio,i.idinstituciones as idi,i.denominacion as no_institucion FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
						left join ui_subfuncion sf on sf.idsubfuncion = pr.idsubfuncion
							left join ui_funcion f on f.idfuncion = sf.idfuncion
								left join ui_finalidad fi on fi.idfinalidad = f.idfinalidad
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			inner join ui_anio y on y.idanio = r.idanio
			inner join ui_instituciones i on i.idinstituciones = r.idinstituciones
			where r.idreporte = {$id}");
	}
	/*
    |--------------------------------------------------------------------------
    | PERMISOS, FODA
    |--------------------------------------------------------------------------
    */
	public static function getProjectpermitsbyarea($idy,$idi,$type){
		return \DB::select("SELECT r.idreporte as id,r.access_trim1 as a1,r.access_trim2 as a2,r.access_trim3 as a3,r.access_trim4 as a4,pr.numero as no_programa,pr.descripcion as programa,p.numero as no_proyecto,p.descripcion as proyecto,a.numero as no_dep_gen,a.descripcion as dep_gen,
			ac.numero as no_dep_aux,ac.descripcion as dep_aux FROM ui_reporte r 
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
			where r.idanio = {$idy} and r.type={$type} and a.estatus = 1 and r.idinstituciones={$idi} order by a.numero asc");
	}
	public static function getRowsFodaReporte($id, $trim){
		return \DB::select("SELECT descripcion as foda,type FROM ui_foda where idreporte = {$id} and trimestre = {$trim} order by type asc");
	}
	/*
    |--------------------------------------------------------------------------
    | SEGUIMIENTO
    |--------------------------------------------------------------------------
    */
	public static function getSeguimientoMetas($idy,$idi,$type){
		return \DB::select("SELECT info.*,(trim_1+trim_2+trim_3+trim_4) as programacion_anual from (SELECT r.idreporte,ar.descripcion as area,ar.numero as no_area,
			ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero no_proy,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,rr.no_accion,rr.descripcion as accion,rr.unidad_medida,rr.prog_anual,rr.trim_1,rr.trim_2,rr.trim_3,rr.trim_4,
			m1.cant_1,m2.cant_2,m3.cant_3,m4.cant_4 FROM ui_reporte r 
				inner join ui_reporte_reg rr on rr.idreporte = r.idreporte
					left join (select sum(rm.cantidad) as cant_1,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (1,2,3) group by rm.idreporte_reg) m1 on m1.idreporte_reg = rr.idreporte_reg
					left join (select sum(rm.cantidad) as cant_2,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (4,5,6) group by rm.idreporte_reg) m2 on m2.idreporte_reg = rr.idreporte_reg
					left join (select sum(rm.cantidad) as cant_3,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (7,8,9) group by rm.idreporte_reg) m3 on m3.idreporte_reg = rr.idreporte_reg
					left join (select sum(rm.cantidad) as cant_4,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (10,11,12) group by rm.idreporte_reg) m4 on m4.idreporte_reg = rr.idreporte_reg
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area ar on ar.idarea = ac.idarea
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
			where r.idanio = {$idy} and r.idinstituciones = {$idi} and r.type={$type} and ar.estatus = 1 order by ar.numero asc) as info order by info.no_area asc");
	}
	/*
    |--------------------------------------------------------------------------
    | CALENDARIZAR
    |--------------------------------------------------------------------------
    */
	public static function getCalendarizarMetas($idy,$idi,$type){
		return \DB::select("SELECT r.type,p.numero as no_proy,p.descripcion as proyecto,pr.numero as no_prog,ac.numero as no_aux,a.numero as dep_gen,rr.no_accion,rr.descripcion as meta,rr.unidad_medida,rr.prog_anual,rr.trim_1,rr.trim_2,rr.trim_3,rr.trim_4 FROM ui_reporte r
        inner join ui_reporte_reg rr on rr.idreporte = r.idreporte 
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
			inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idy} and r.type = {$type} and r.idinstituciones = {$idi} and a.estatus = 1 order by a.numero,ac.numero asc");
	}
	/*
    |--------------------------------------------------------------------------
    | GRÁFICAS
    |--------------------------------------------------------------------------
    */
	public static function getGraficasTotalMetas($idy,$idi,$type){
		return \DB::select("SELECT count(idr) as total FROM (SELECT DISTINCT rr.idreporte as idr,rr.no_accion FROM ui_reporte_reg rr
		inner join ui_reporte r on rr.idreporte = r.idreporte
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idy} and r.type = {$type} and a.estatus = 1 and r.idinstituciones = {$idi}) as info");
	}
	public static function getGraficasTotalMetasPorcentaje($idy,$idi,$type,$total){
		return \DB::select("SELECT  count(idr) as total,(count(idr) * 100)/{$total} as porcentaje,area,idarea FROM (SELECT DISTINCT rr.idreporte as idr,rr.no_accion,a.descripcion as area,a.idarea FROM ui_reporte_reg rr
		inner join ui_reporte r on rr.idreporte = r.idreporte
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
		inner join ui_area a on a.idarea = ac.idarea
		where r.idanio={$idy} and r.type = {$type} and a.estatus = 1 and r.idinstituciones = {$idi}) as info group by info.idarea order by porcentaje desc");
	}
	/*
    |--------------------------------------------------------------------------
    | PbRM-08c
    |--------------------------------------------------------------------------
    */
	public static function getProjectsOchoC($idy,$idi,$type,$ida){
		$cad = ($ida > 0 ? ' and a.idarea = '.$ida : '');
		return \DB::select("SELECT r.idreporte as id,a.numero as no_dep_gen,a.descripcion as dep_gen,ac.numero as no_dep_aux,ac.descripcion as dep_aux,p.numero as no_proyecto,p.descripcion as proyecto,r.presupuesto,
		r.foda1 as ocho1,r.foda2 as ocho2,r.foda3 as ocho3,r.foda4 as ocho4 FROM ui_reporte r
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
			inner join ui_area a on a.idarea = ac.idarea
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
		where r.idanio = {$idy} and r.idinstituciones = {$idi} {$cad} and r.type = {$type} order by a.numero,ac.numero asc");
	}
	public static function getProjectsOchoCTxt($idy,$idi){
		return \DB::select("SELECT info.*,IFNULL(ROUND(((info.cant_1 * 100)/info.trim_1),2),0) as por_1,IFNULL(ROUND(((info.cant_2 * 100)/info.trim_2),2),0) as por_2,IFNULL(ROUND(((info.cant_3 * 100)/info.trim_3),2),0) as por_3,IFNULL(ROUND(((info.cant_4 * 100)/info.trim_4),2),0) as por_4,
(info.cant_1 - info.trim_1) as resta_1,(info.cant_2 - info.trim_2) as resta_2,(info.cant_3 - info.trim_3) as resta_3,(info.cant_4 - info.trim_4) as resta_4 FROM (
		SELECT a.numero as no_dep_gen,ac.numero as no_dep_aux,
        SUBSTRING(p.numero, 1, 2) AS no1,
		SUBSTRING(p.numero, 3, 2) AS no2,
		SUBSTRING(p.numero, 5, 2) AS no3,
		SUBSTRING(p.numero, 7, 2) AS no4,
		SUBSTRING(p.numero, 9, 2) AS no5,
		SUBSTRING(p.numero, 11, 2) AS no6,
        reg.no_accion,reg.unidad_medida,reg.descripcion as meta,reg.prog_anual,reg.trim_1,reg.trim_2,reg.trim_3,reg.trim_4,
		IFNULL(m.cant_1,0) as cant_1,IFNULL(m.cant_2,0) as cant_2,IFNULL(m.cant_3,0) as cant_3,IFNULL(m.cant_4,0) as cant_4 FROM ui_reporte r 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
			inner join ui_area a on a.idarea = ac.idarea
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
		inner join ui_reporte_reg reg on reg.idreporte = r.idreporte
			LEFT JOIN (
						SELECT 
							m.idreporte_reg,
							SUM(CASE WHEN m.idmes IN (1, 2, 3) THEN m.cantidad ELSE 0 END) AS cant_1,
							SUM(CASE WHEN m.idmes IN (4, 5, 6) THEN m.cantidad ELSE 0 END) AS cant_2,
							SUM(CASE WHEN m.idmes IN (7, 8, 9) THEN m.cantidad ELSE 0 END) AS cant_3,
							SUM(CASE WHEN m.idmes IN (10, 11, 12) THEN m.cantidad ELSE 0 END) AS cant_4
						FROM 
							ui_reporte_mes m
							INNER JOIN ui_reporte_reg g ON g.idreporte_reg = m.idreporte_reg
								INNER JOIN ui_reporte r1 on r1.idreporte = g.idreporte
						WHERE r1.idanio = {$idy} and r1.type = 0 and r1.idinstituciones = {$idi}
						GROUP BY m.idreporte_reg
					) AS m ON m.idreporte_reg = reg.idreporte_reg
		where r.idanio = {$idy} and r.type = 0 and r.idinstituciones = {$idi} order by a.numero,ac.numero asc
    ) AS info order by info.no_dep_gen,info.no_dep_aux asc");
	}

	public static function getCatIndestrategicos($idy){
		return \DB::select("SELECT idind_estrategicos as id,codigo,indicador FROM ui_ind_estrategicos where idanio = {$idy}");
	}
	public static function getCatIndEstId($id){
		return \DB::select("SELECT idind_estrategicos_reg as id,nombre_corto,nombre_largo FROM ui_ind_estrategicos_reg where idind_estrategicos = {$id}");
	}
	
	/*
    |--------------------------------------------------------------------------
    | Metas
    |--------------------------------------------------------------------------
    */
	public static function getMetasProyectos($request,$idi){
		$query = DB::table('ui_reporte as r')
    		->join('ui_area_coordinacion as ac', 'ac.idarea_coordinacion', '=', 'r.id_area_coordinacion')
			->join('ui_area as a', 'a.idarea', '=', 'ac.idarea')
			->join('ui_proyecto as p', 'p.idproyecto', '=', 'r.idproyecto')
			->where('r.idanio', $request['idy'])
			->where('r.idinstituciones', $idi)
			->where('r.type', $request['type'])
			->orderBy('a.numero')
			->orderBy('ac.numero')
			->select(
				'r.idreporte as id',
				'a.numero as no_dep_gen',
				'a.descripcion as dep_gen',
				'ac.numero as no_dep_aux',
				'ac.descripcion as dep_aux',
				'p.numero as no_proyecto',
				'p.descripcion as proyecto'
			);
		if (!empty($request['nop'])) {
			$query->where('p.numero', 'like', "%{$request['nop']}%");
		}
		if (!empty($request['proy'])) {
			$query->where('p.descripcion', 'like', "%{$request['proy']}%");
		}
		if (!empty($request['dg'])) {
			$query->where('a.descripcion', 'like', "%{$request['dg']}%");
		}
		if (!empty($request['da'])) {
			$query->where('ac.descripcion', 'like', "%{$request['da']}%");
		}
		return $query->get();
		
	}
	public static function getMetaInformacion($id){
		return DB::table('ui_reporte as r')
			->join('ui_proyecto as p', 'p.idproyecto', '=', 'r.idproyecto')
			->join('ui_subprograma as sp', 'sp.idsubprograma', '=', 'p.idsubprograma')
			->join('ui_programa as pr', 'pr.idprograma', '=', 'sp.idprograma')
			->join('ui_area_coordinacion as ac', 'ac.idarea_coordinacion', '=', 'r.id_area_coordinacion')
			->join('ui_area as a', 'a.idarea', '=', 'ac.idarea')
			->where('r.idreporte', $id)
			->select(
				'p.idproyecto',
				'p.numero as no_proyecto',
				'p.descripcion as proyecto',
				'pr.numero as no_programa',
				'pr.descripcion as programa',
				'a.numero as no_dep_gen',
				'a.descripcion as dep_gen',
				'ac.numero as no_dep_aux',
				'ac.descripcion as dep_aux',
				'ac.idarea_coordinacion as idac',
				'r.presupuesto'
			)
			->first();  // si solo esperas un resultado
	}
	public static function getMetasEdit($id){
		return DB::table('ui_reporte_reg')
			->where('idreporte', $id)
			->select(
				'idreporte_reg as id',
				'no_accion',
				'unidad_medida',
				'descripcion as meta',
				'prog_anual',
				'trim_1 as t1',
				'trim_2 as t2',
				'trim_3 as t3',
				'trim_4 as t4'
			)
			->get();
	}
	//Eliminar todos las metas de un proyecto con el mismo ID
	public static function getDeleteMetasDelProyecto($id){
		return DB::table('ui_reporte_reg')
		->where('idreporte', $id)
		->delete();
	}
	//Eliminar indicadores con el mismo ID
	public static function getDeleteIndicadorDelProyecto($id){
		return DB::table('ui_reporte_reg')
		->where('idreporte_mir', $id)
		->delete();
	}
}
