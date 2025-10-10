<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sximo extends Model {


	public static function getRows( $args )
	{
     	$table = with(new static)->table;
	  	$key = with(new static)->primaryKey;

        extract( array_merge( array(
			'page' 		=> '0' ,
			'limit'  	=> '0' ,
			'sort' 		=> '' ,
			'order' 	=> '' ,
			'params' 	=> '' ,
			'global'	=> 1
        ), $args ));

		$offset = ($page-1) * $limit ;
		$limitConditional = ($page !=0 && $limit !=0) ? "LIMIT  $offset , $limit" : '';
		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 ){
			$params .= " AND {$table}.entry_by ='".\Session::get('uid')."'";
		}

		// End Update permission global / own access new ver 1.1

		$rows = array();
	    $result = \DB::select( self::querySelect() . self::queryWhere(). "
				{$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");

		if($key =='' ) { $key ='*'; } else { $key = $table.".".$key ; }
		$counter_select = preg_replace( '/[\s]*SELECT(.*)FROM/Usi', 'SELECT count('.$key.') as total FROM', self::querySelect() );
		//echo 	$counter_select; exit;
		$res = \DB::select( $counter_select . self::queryWhere()." {$params} ". self::queryGroup());
		$total = $res[0]->total;


		return $results = array('rows'=> $result , 'total' => $total);

	}
	public static function getRow( $id )
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

		$result = \DB::select(
				self::querySelect() .
				self::queryWhere().
				" AND ".$table.".".$key." = '{$id}' ".
				self::queryGroup()
			);
		if(count($result) <= 0){
			$result = array();
		} else {

			$result = $result[0];
		}
		return $result;
	}

	public  function insertRow( $data , $id)
	{
   		$table = with(new static)->table;
	   	$key = with(new static)->primaryKey;
	    if($id == NULL )
        {
			//agrega el valor en el campo entry_by si existe en la tabla
			$fields_in_table = \Schema::getColumnListing($table);
			if(in_array('entry_by', $fields_in_table)){
				$data['entry_by'] = \Auth::user()->id;
			}
			// Insert Here
			if(isset($data['createdOn'])) $data['createdOn'] = date("Y-m-d H:i:s");
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");
			 $id = \DB::table( $table)->insertGetId($data);
        } else {
            // Update here
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");
			 \DB::table($table)->where($key,$id)->update($data);
        }
        return $id;
	}
	//Me lo lleve para el Controller
	public  function updatePlanPDF($number)
	{
		\DB::table('ui_plan_pdf')
			->where('number', $number)
			->update(['std_delete' => 2]);
	}
	static function makeInfo( $id )
	{
		$row =  \DB::table('tb_module')->where('module_name', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$data['id']		= $r->module_id;
			$data['title'] 	= $r->module_title;
			$data['note'] 	= $r->module_note;
			$data['table'] 	= $r->module_db;
			$data['key'] 	= $r->module_db_key;
			$data['config'] = \SiteHelpers::CF_decode_json($r->module_config);
			$field = array();
			foreach($data['config']['grid'] as $fs)
			{
				foreach($fs as $f)
					$field[] = $fs['field'];

			}
			$data['field'] = $field;
		}
		return $data;
	}
	//Una nueva función de sesmas 04-12-2024
	static function makeInfoSesmas( $id )
	{
		$row =  \DB::table('tb_module')->where('module_name', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$data['id']		= $r->module_id;
			$data['title'] 	= $r->module_title;
			$data['note'] 	= $r->module_note;
		}
		return $data;
	}
    static function getComboselect( $params , $limit =null, $parent = null, $notwhere = null, $sort = null, $order = null)
    {
    	$table = $params[0];
        $limit = explode(':',$limit);
        $parent = explode('|',$parent);
        $notwhere = explode('|',$notwhere);
        $fields = explode("|",$params[2]);
        $cols = $params[1] . ", ";
        $cols .= implode(", ", $fields);
        $fields = explode(", ",$cols);
        $not_null = [];

        foreach ($fields as $v) {
        	$not_null[] = $v . " IS NOT NULL";
        }

        $qry = "SELECT DISTINCT $cols FROM " . $table ." WHERE " . implode(" AND ", $not_null);

        if(!is_null($parent) && !empty($parent) && !empty($parent[0]))
        {
        	foreach ($parent as $key => $value) {
        		$pr = explode(':',$value);
        		$qry .= " AND ".$pr[0]." = '".$pr[1]."'";
        	}
        }

        if(!is_null($notwhere) && !empty($notwhere) && !empty($notwhere[0]))
        {
           foreach ($notwhere as $key => $value) {
        		$pr = explode(':', $value);
        		$inpr = explode(',', $pr[1]);
        		$qry .= " AND ".$pr[0]." NOT IN ('". implode("','",$inpr) ."')";
        	}
        }

		if(!is_null($sort) && !empty($sort))
        {
        	$qry .= " ORDER BY $sort ";
        	$qry .= (!is_null($order) && $order == 'asc')?'asc':'desc';
        }

        if(count($limit) >=3)
        {
            $condition = $limit[0]." `".$limit[1]."` ".$limit[2]." ".$limit[3]." ";
            $qry .= $condition;
        }

        $row =  \DB::select($qry);
        //echo $qry;
        return $row;
    }

	public static function getColoumnInfo( $result )
	{
		$pdo = \DB::getPdo();
		$res = $pdo->query($result);
		$i =0;	$coll=array();
		while ($i < $res->columnCount())
		{
			$info = $res->getColumnMeta($i);
			$coll[] = $info;
			$i++;
		}
		return $coll;

	}
	function validAccess( $id)
	{
		$row = \DB::table('tb_groups_access')->where('module_id','=', $id)
				->where('group_id','=', \Session::get('gid'))
				->get();
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
			} else {
				$data = array();
			}
			return $data;
		} else {
			return false;
		}
	}
	//Inserta los datos masicos en un array - 26-09-2024
	static function getInsertTableData($data, $table){
		return \DB::table($table)->insert($data);
	}
	static function getInsertTable($data, $table)
	{
		  return \DB::table($table)->insertGetId($data);
	}
	static function getUpdateTable($data, $table, $key, $id)
	{
			return \DB::table($table)->where($key, $id)->update($data);
	}
	static function getDestroyTable($table,$key,$id)
	{
		\DB::table($table)->where($key, $id)->delete();
		return true;
	}
	static function getColumnTable( $table )
	{
    $columns = array();
	  foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
    {
		  $columns[$column->Field] = '';
    }
    return $columns;
	}

	static function getTableList( $db )
	{
	 	$t = array();
		$dbname = 'Tables_in_'.$db ;
		foreach(\DB::select("SHOW TABLES FROM {$db}") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }
		return $t;
	}
	static function getRowsTrimestre(){
		return array("1"=>"Primer Trimestre","2"=>"Segundo Trimestre","3"=>"Tercer Trimestre","4"=>"Cuarto Trimestre");
	}
	static function getTableField( $table )
	{
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
		    $columns[$column->Field] = $column->Field;
        return $columns;
	}

	/* 
		Name 		= Catálogos Municipios
		Fecha		= 11-02-2024
	*/
	static function getCatMunicipios(){
		return \DB::select("SELECT * FROM ui_municipios where active = 1");//Solo mostrar a municipios activos
	}
	static function getCatMunicipiosID($id){
		return \DB::select("SELECT * FROM ui_municipios where idmunicipios= {$id}");
	}
	/* 
		Name 		= Catálogos Instituciones
		Fecha		= 11-02-2024
	*/
	static function getCatInstitucionesMunicipio($id){
		return \DB::select("SELECT * FROM ui_instituciones where idmunicipios= {$id}");
	}
	static function getCatInstituciones(){
		return \DB::select("SELECT * FROM ui_instituciones");
	}
	static function getCatInstitucionesID($id){
		return \DB::select("SELECT * FROM ui_instituciones where idinstituciones = {$id}");
	}
	public static function getInstitucion($id){
		return \DB::select("SELECT i.idinstituciones,i.descripcion as institucion,i.logo,i.logo_izq,i.logo_der,m.descripcion as municipio,i.titular_uippe,i.titular_tesoreria FROM ui_instituciones i 
		inner join ui_municipios m on m.idmunicipios = i.idmunicipios
		where i.idinstituciones={$id}");
	}
	/* 
		Fin
	*/
	static function getCatAnios(){
		return \DB::select("SELECT * FROM ui_anio order by anio desc");
	}
	static function getCatGenAnios(){
		return \DB::select("SELECT idanio,anio,descripcion FROM ui_anio order by idanio desc");
	}
	static function getCatPilar(){
		return \DB::select("SELECT * FROM ui_pilar");
	}
	static function getCatAreas(){
		return \DB::select("SELECT * FROM ui_area");
	}
	static function getCatFinalidad(){
		return \DB::select("SELECT * FROM ui_finalidad");
	}
	static function getCatFuncion(){
		return \DB::select("SELECT * FROM ui_funcion");
	}
	static function getCatSubfuncion(){
		return \DB::select("SELECT * FROM ui_subfuncion");
	}
	static function getCatPrograma(){
		return \DB::select("SELECT * FROM ui_programa WHERE estatus = 1");
	}
	static function getCatTipoDependencia(){
		return \DB::table('ui_tipo_dependencias')->select(['idtipo_dependencias as id','abreviatura','descripcion as dependencia'])->get();
	}
	static function getCatMeses(){
		return \DB::select("SELECT * FROM ui_mes");
	}
	static function getCatSubprograma(){
		return \DB::select("SELECT * FROM ui_subprograma");
	}
	static function getCatPeriodos(){
		return \DB::select("SELECT * FROM ui_periodo order by idperiodo desc");
	}
	static function getCatColores(){
		return \DB::select("SELECT * FROM ui_colores");
	}
	static function getCatPilaresTipo(){
		return \DB::select("SELECT * FROM ui_pdm_pilares_tipo");
	}
	static function getCatPilaresActive(){
		return \DB::select("SELECT idpdm_pilares as id,pilares as pilar FROM ui_pdm_pilares where estatus = 1");
	}
	static function getCatPilaresTemasActive(){
		return \DB::select("SELECT t.idpdm_pilares_temas as id,pi.numero as no_pilar,t.numero as no_tema,t.descripcion as tema FROM ui_pdm_pilares pi
				inner join ui_pdm_pilares_temas t on t.idpdm_pilares = pi.idpdm_pilares
				where pi.estatus = 1");
	}
	//Eliminar ya no se usa municipio
	static function getCatDepGen($id){
		return \DB::select("SELECT a.numero as noa,a.descripcion as area,ui.descripcion as institucion,a.titular,ui.logo_izq,m.numero as no_municipio,m.descripcion as municipio FROM ui_area a 
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
			inner join ui_municipios m on m.idmunicipios = ui.idmunicipios
		where a.idarea = {$id}");
	}
	static function getCatDepGenNew($id){
		return \DB::select("SELECT a.numero as noa,a.descripcion as area,ui.denominacion as no_institucion,ui.descripcion as institucion,a.titular,ui.logo_izq FROM ui_area a 
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
		where a.idarea = {$id}");
	}
	public static function getCatPeriodoAnios($idp){
		return \DB::select("SELECT idanio,anio FROM ui_anio where idperiodo={$idp} order by anio desc");
	}
	//checar para eliminar 13032025
	public static function getCatDepGeneral($id){
		return \DB::select("SELECT idarea,descripcion as area FROM ui_area where idinstituciones={$id} and estatus = 1");
	}
	//Nuevo catalogo por año
	public static function getCatDepGeneralNew($idi, $idy){
		return \DB::select("SELECT idarea,descripcion as area,numero as no_dep_gen FROM ui_area where idinstituciones={$idi} and idanio = {$idy} and estatus = 1");
	}
	static function getAccessUserInst($id){
		return \DB::select("SELECT idusers_access as id FROM ui_users_access where iduser= {$id}");
	}
	static function getCatMunicipioSearch($id){
		return \DB::select("SELECT idmunicipios,descripcion as municipio FROM ui_municipios where idmunicipios = {$id}");
	}
	//F
	public static function getProjects($idanio){
		return \DB::select("SELECT * FROM ui_proyecto WHERE idanio = {$idanio} and estatus = 1 order by numero asc");
	}
	public static function getProjectsProgram(){
		return \DB::select("SELECT p.idproyecto as id,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,cp.clasificacion FROM ui_proyecto p
		INNER JOIN ui_subprograma sp on sp.idsubprograma = p.idsubprograma
			INNER JOIN ui_programa pr on pr.idprograma = sp.idprograma
		LEFT JOIN ui_clasificacion_programatica cp on cp.idclasificacion_programatica = p.idclasificacion_programatica
		WHERE p.estatus = 1 order by p.numero asc");
	}
	//05-03-2025 Ya no se va a usar
	public static function getPermisoCoordinacion($id,$ida,$idi){
		return \DB::select("SELECT IFNULL(group_concat(idarea_coordinacion),0) as permiso FROM(SELECT uc.idarea_coordinacion FROM ui_user_coordinacion uc 
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
			inner join ui_area a1 on a1.idarea = ac.idarea
			where uc.iduser={$id} and ac.idarea={$ida} and a1.idinstituciones = {$idi}) AS info");
	}
	//05-03-2025 Ya no se va a usar
	public static function getCoordinacionesPermisosGeneral($ida,$idac,$idi){
		return \DB::select("SELECT c.idarea_coordinacion as id,c.descripcion,c.numero FROM ui_area_coordinacion c 
		inner join ui_area a on a.idarea = c.idarea
		where c.idarea={$ida} and c.idarea_coordinacion in ({$idac}) and a.idinstituciones = {$idi}");
	}
	public static function getDepAuxPorArea($id){
		return \DB::select("SELECT idarea_coordinacion as id,descripcion, numero FROM ui_area_coordinacion where idarea = {$id}");
	}
	//Checar para eliminar 11-12-2024 cambio por getAreasGeneralForYear
	public static function getAreasGeneral($idi){
		return \DB::select("SELECT a.*,ui.descripcion as institucion,ui.logo FROM ui_area a
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
	 	where a.idinstituciones ={$idi} and a.estatus = 1");
	}
	//Checar para eliminar 11-12-2024 cambio por getPermisoAreaForYear
	public static function getPermisoArea($id){
		return \DB::select("SELECT IFNULL(group_concat(idarea),0) as permiso FROM(SELECT ac.idarea FROM ui_user_coordinacion uc 
			inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
			where uc.iduser={$id} group by ac.idarea) AS info");
	}
	//Nuevo cambio 11-12-2024 por el cambio de Gaceta 2025 - eliminar, cambio por getPermisoAreaForYearDenGen(05-03-2025)
	public static function getPermisoAreaForYear($idu, $idy){
		return \DB::select("SELECT IFNULL(group_concat(idarea),0) as permiso FROM(SELECT ac.idarea FROM ui_user_coordinacion uc 
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = uc.idarea_coordinacion
			inner join ui_area a on a.idarea = ac.idarea
		where uc.iduser={$idu} and a.idanio = {$idy} group by ac.idarea) AS info");
	}
	//Checar para eliminar 11-12-2024 cambio por getAreasEnlacesGeneralForYear
	public static function getAreasEnlacesGeneral($ida,$idi){
		return \DB::select("SELECT a.*,ui.descripcion as institucion,ui.logo FROM ui_area a
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
		where a.idarea in ({$ida}) and a.estatus = 1 and ui.idinstituciones = {$idi}");
	}
	//Checar para eliminar ya no se usa 05-03-2025
	public static function getAreasEnlacesGeneralForYear($ida,$idi){
		return \DB::select("SELECT a.idarea,a.numero as no_dep_gen,a.descripcion as dep_gen,a.titular FROM ui_area a
		inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
		where a.idarea in ({$ida}) and a.estatus = 1 and ui.idinstituciones = {$idi}");
	}
	static function getUserProfile($id){
		return \DB::select("SELECT u.id,u.username as nombre,u.first_name as ap,u.last_name as am,u.avatar,u.email,g.name as nivel,u.active FROM tb_users u
		inner join tb_groups g on g.group_id = u.group_id
		where u.id ={$id}");
	}
	//Eliminar cambio por getInformationDepAuxID 07-03-2025
	public static function getAreaCoordinacion($id){
		return \DB::select("SELECT c.idarea_coordinacion as idac,c.numero as no_coord,c.descripcion as coordinacion,a.numero,a.descripcion as area,a.titular,u.descripcion as institucion,u.logo_izq,m.numero as no_municipio,m.descripcion as municipio FROM ui_area_coordinacion c 
		inner join ui_area a on a.idarea = c.idarea
			inner join ui_instituciones u on u.idinstituciones = a.idinstituciones
				inner join ui_municipios m on m.idmunicipios = u.idmunicipios
		where c.idarea_coordinacion={$id}");
	}
	public static function getPermisosInstitucionUser($idu,$access){
		return \DB::select("SELECT i.idinstituciones as id,i.descripcion,i.logo,IFNULL(u.total,0) as permiso FROM ui_instituciones i
		left join (select count(u1.idusers_access) as total,u1.idinstituciones from ui_users_access u1 where u1.iduser={$idu} group by u1.idinstituciones) u on u.idinstituciones = i.idinstituciones
		where i.idinstituciones in ({$access})");
	}
	static function getPermisosUserMunicipio(){
		return \DB::select("SELECT u.idmunicipios,m.descripcion as municipio FROM tb_users u
			inner join ui_municipios m on u.idmunicipios = m.idmunicipios
			where u.id = ".\Auth::user()->id);
	}
	static function getPermisosUserInstituciones(){
		if(\Auth::user()->group_id == 1){
			return \DB::select("SELECT idmunicipios,descripcion as municipio FROM ui_municipios");
		}else{
			return \DB::select("SELECT u.idmunicipios,m.descripcion as municipio FROM tb_users u
			inner join ui_municipios m on u.idmunicipios = m.idmunicipios
			where u.id = ".\Auth::user()->group_id);
		}
	}
	static function getReturnExcel($c=null, $name){
		@header('Content-Type: application/ms-excel; charset=utf-8');
		@header('Content-Length: '.strlen($c));
		@header('Content-disposition: inline; filename="'.$name.'"');
		echo $c;
		exit;
	}
	static function getAvatarUser($avatar=null){
		$img = 'images/operadores/no-avatar.jpg';
		if(!empty($avatar) and $avatar != null){
			$ruta = public_path("{$avatar}");
			$img = (is_file($ruta) ? $avatar : $img);
		}
		return $img;
	}
	public static function getClasificacionProgramatica(){
		return \DB::select("SELECT idclasificacion_programatica as id,clasificacion FROM ui_clasificacion_programatica ORDER BY clasificacion ASC");
	}
	//Eliminar cambio por getModuleAccessByYears
	public static function getModuleYears(){
		$moduleID = with(new static)->moduleID;
		$result = \DB::table('ui_module_anio as m')
			->join('ui_anio as a', 'a.idanio', '=', 'm.idanio')
			->where("m.module", $moduleID)
			->select(
				'a.idanio',
				'a.anio',
				'a.descripcion'
			)
			->orderBy('a.idanio', 'desc')
			->get();
		return $result;
	}
	public static function getAreaCoordinacionID($idac){
		return \DB::table('ui_area_coordinacion as ac')
			->where("ac.idarea_coordinacion", $idac)
			->select(
				'ac.idarea'
			)
			->first();
	}
	public static function getPilaresActivos(){
		return \DB::select("SELECT idpdm_pilares as id,pilares FROM ui_pdm_pilares WHERE estatus = 1");
	}
	public static function getProgramasActivos($idanio){
		return \DB::select("SELECT idprograma,numero as no_programa,descripcion as programa,objetivo FROM ui_programa where estatus = 1 AND idanio = {$idanio} ORDER BY numero ASC");
	}
	public static function getPartidasEspecificas($id){
		return \DB::select("SELECT e.idteso_partidas_esp as id, e.clave as no_partida,e.nombre as partida FROM ui_teso_partidas_esp e
		inner join ui_teso_partidas_gen g on g.idteso_partidas_gen = e.idteso_partidas_gen
			inner join ui_teso_subcapitulos ts on ts.idteso_subcapitulos = g.idteso_subcapitulos
				inner join ui_teso_capitulos tc on tc.idteso_capitulos = ts.idteso_capitulos
		WHERE tc.idteso_capitulos in ({$id}) ORDER BY e.clave ASC");
	}
	public static function getFuentesFinanciamiento($idi, $idanio){
		return \DB::select("SELECT fu.idteso_ff_n3 as id, n.clave as no_fuente,n.descripcion as fuente FROM ui_teso_ff fu
		inner join ui_teso_ff_n3 n on n.idteso_ff_n3 = fu.idteso_ff_n3
		where fu.idinstituciones = {$idi} and fu.idanio = {$idanio} ORDER BY n.clave ASC");
	}

	//Presupuesto Definitivo PbRM-01a
	public static function getProgramasPbRMa($idanio, $idarea){
		return \DB::select("SELECT p.idprograma,p.numero as no_programa,p.descripcion as programa,p.objetivo,pi.idpdm_pilares as idpilar,pi.numero as no_pilar,pi.pilares as pilar,p.tema_desarrollo as tema FROM ui_pd_pbrm01a a
		inner join ui_programa p on p.idprograma = a.idprograma
			inner join ui_pdm_pilares pi on pi.idpdm_pilares = p.idpdm_pilares
		where a.std_delete = 1 and a.idanio = {$idanio} and a.idarea = {$idarea} GROUP BY a.idprograma ORDER BY p.numero ASC");
	}
	public static function getPilaresTemas(){
		return \DB::select("SELECT t.idpdm_pilares_temas as idtema,t.numero as no_tema,p.idpdm_pilares as idpilar,t.descripcion as tema FROM ui_pdm_pilares p
			inner join ui_pdm_pilares_temas t on p.idpdm_pilares = t.idpdm_pilares
			where p.estatus = 1");
	}

	/*
	*Traspaso Interno
	*Proyectos activos de presupuesto definitivo
	*/
	public static function getProyectosPresDefDepAux($idy, $idac){
		return \DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,c.clasificacion FROM ui_pres_pbrm01a_reg r
		inner join ui_pres_pbrm01a pa on pa.idpres_pbrm01a = r.idpres_pbrm01a
		inner join ui_proyecto p on p.idproyecto = r.idproyecto
			inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
				inner join ui_programa pr on pr.idprograma = sp.idprograma
		inner join ui_clasificacion_programatica c on c.idclasificacion_programatica = p.idclasificacion_programatica
		where pa.std_delete = 1 and r.idanio = {$idy} and r.idarea_coordinacion = {$idac} order by p.numero asc");
	}
	public static function getProyectosPresDefDepAuxNew($idy, $idac){
		return \DB::select("SELECT p.idproyecto,p.numero as no_proyecto,p.descripcion as proyecto,pr.numero as no_programa,pr.descripcion as programa,pr.objetivo as obj_programa,c.clasificacion FROM ui_pd_pbrm01a_reg r
			inner join ui_pd_pbrm01a pa on pa.idpd_pbrm01a = r.idpd_pbrm01a
			inner join ui_proyecto p on p.idproyecto = r.idproyecto
				inner join ui_subprograma sp on sp.idsubprograma = p.idsubprograma
					inner join ui_programa pr on pr.idprograma = sp.idprograma
			inner join ui_clasificacion_programatica c on c.idclasificacion_programatica = p.idclasificacion_programatica
		where pa.std_delete = 1 and pa.idanio = {$idy} and r.idarea_coordinacion = {$idac} order by p.numero asc");
	}
	//Checar para eliminar ya no se va a usar
	public static function getCoordinacionesGeneral($ida,$idi){
		return \DB::select("SELECT c.idarea_coordinacion as id,c.numero,c.descripcion FROM ui_area_coordinacion c 
		inner join ui_area a on a.idarea = c.idarea
		where c.idarea={$ida} and a.idinstituciones = {$idi} ORDER BY c.numero ASC");
	}
	//14-02-2025 ahorita solo se usa en proyectopbrmd
	public static function getProjectsActive($idy){
		return \DB::select("SELECT idproyecto as id,numero as no_proyecto,descripcion as proyecto FROM ui_proyecto where idanio = {$idy} and estatus = 1 order by numero asc");
	}

















	






	/*
		----------------- Mejora 07-03-3025 -----------------
	*/
	// OK - Nuevo cambio 11-12-2024 por el cambio de Gaceta 2025 - Para administradores
	public static function getAreasGeneralForYear($idi, $idy){
		return \DB::select("SELECT a.idarea,a.numero as no_dep_gen,a.descripcion as dep_gen,a.titular FROM ui_area a
			inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
			where a.idinstituciones = ? and a.idanio = ? and a.estatus = 1 ORDER BY a.numero ASC",[$idi, $idy]);
	}
	//OK - Nuevo cambio 11-12-2024 por el cambio de Gaceta 2025 - Para enlaces
	public static function getAreasGeneralForYearDepGen($idi, $idy, $access){
		return \DB::select("SELECT a.idarea,a.numero as no_dep_gen,a.descripcion as dep_gen,a.titular FROM ui_area a
			inner join ui_instituciones ui on ui.idinstituciones = a.idinstituciones
			where a.idinstituciones ={$idi} and a.idanio = {$idy} and a.estatus = 1 and a.numero in ({$access}) ORDER BY a.numero ASC");
	}
	public static function getPermisoAreaForYearDenGen($idu){
		return \DB::select("SELECT GROUP_CONCAT(CONCAT('\"', d.numero, '\"') SEPARATOR ', ') AS dep_gen FROM ui_user_area u
		inner join ui_dep_gen d on u.iddep_gen = d.iddep_gen
		where u.iduser = ? ",[$idu]);
	}
	//OK
	public static function getRowsDepAuxiliares($idi, $idy, $type,$ida){
		return \DB::select("SELECT ac.idarea_coordinacion as idac,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.idarea  FROM ui_reporte r
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idy} and r.idinstituciones = {$idi} and r.type = {$type} and a.estatus = 1 and a.idarea = {$ida}  group by r.id_area_coordinacion order by ac.numero asc");
	}
	public static function getRowsDepAuxGeneral($idi, $idy, $type){
		return \DB::select("SELECT ac.idarea_coordinacion as idac,ac.numero as no_dep_aux,ac.descripcion as dep_aux,a.idarea,count(r.idreporte) as total  FROM ui_reporte r
		inner join ui_area_coordinacion ac on ac.idarea_coordinacion = r.id_area_coordinacion
				inner join ui_area a on a.idarea = ac.idarea
		where r.idanio = {$idy} and r.idinstituciones = {$idi} and r.type = {$type} and a.estatus = 1 group by r.id_area_coordinacion order by ac.numero asc");
	}
	public static function getInformationDepAuxID($id){
		return \DB::select("SELECT c.idarea_coordinacion as idac,c.numero as no_dep_aux,c.descripcion as dep_aux,
			a.numero as no_dep_gen,a.descripcion as dep_gen,
			u.descripcion as institucion,y.idanio,y.anio FROM ui_area_coordinacion c 
			inner join ui_area a on a.idarea = c.idarea
					inner join ui_anio y on y.idanio = a.idanio
					inner join ui_instituciones u on u.idinstituciones = a.idinstituciones
			where c.idarea_coordinacion = {$id}");
	}
	//checar para eliminar, ya que lo translade a PoaService
	public static function getTitularesFirmas($idi,$idy){
		return \DB::select("SELECT i.logo_izq,i.logo_der,i.t_uippe,i.t_egresos,i.t_prog_pres,i.t_secretario,i.t_tesoreria,
			i.c_uippe,i.c_egresos,i.c_prog_pres,i.c_secretario,i.c_tesoreria,y.leyenda
			FROM ui_instituciones_info i 
			inner join ui_anio y on y.idanio = i.idanio
			where i.idinstituciones = {$idi} and i.idanio = {$idy}");
	}



	/*
	* Catalogos validados y que son importantes 16-03-2025
	*/
	static function getCatFrecuenciaMedicion(){
		return \DB::select("SELECT idfrecuencia_medicion as id, descripcion as frec_medicion FROM ui_frecuencia_medicion");
	}
	static function getCatDimensionAtiende(){
		return \DB::select("SELECT iddimension_atiende as id,descripcion as dimension_atiende FROM ui_dimension_atiende");
	}
	static function getCatTipoIndicador(){
		return \DB::select("SELECT idtipo_indicador as id,descripcion as tipo_indicador FROM ui_tipo_indicador");
	}
	static function getCatTipoOperacion(){
		return \DB::select("SELECT idtipo_operacion as id,descripcion as tipo FROM ui_tipo_operacion");
	}
}
