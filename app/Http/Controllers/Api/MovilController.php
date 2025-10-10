<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Access\Years;
use App\Models\Api\Movil;
use App\Models\Reporte;
use App\User;

use App\Services\Audit\AuditService;
use App\Services\GeneralService;

use Illuminate\Support\Facades\DB;
use SiteHelpers;
use Illuminate\Support\Facades\File;

use App\Helpers\FunctionHelper;

class MovilController extends ApiBaseController{

    const MODULE = 5;
    const TYPE_APP = 2;

    protected $audit;
    protected $generalService;

    public function __construct(AuditService $audit, GeneralService $generalService)
    { 
        $this->audit = $audit;
        $this->generalService = $generalService;
    }

	public function getLogin(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('username', 'password');

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if($user->id != 1){
                $this->audit->touchLastActivity($user);
                $this->audit->logNavigation($request, $user->id, self::TYPE_APP);
            }

            return response()->json([
                'status' 	=> 'ok',
                'iduser' 	=> $user->id,
                'idnivel' 	=> $user->group_id,
                'username' 	=> $user->username." ".$user->first_name
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Credenciales inválidas'
        ]);
    }

    public function getYears(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }
                
                    $years = Years::getModuleAccessByYears(self::MODULE, $user['idinstituciones']);
                    return response()->json([
                        'status' => 'ok',
                        'data' => $years
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getDependencias(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','idy','type');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $year = Movil::getYearID($credentials['idy']);

                    $rows = $this->generalService->getAccessDepGenForUsersMovil($credentials['idy'], $credentials['type'], $user);

                    return response()->json([
                        'status' => 'ok',
                        'year' => $year,
                        'data' => $rows
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }
    
    public function getMetasproyectos(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','idy','type','idarea');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }
                    $year = Movil::getYearID($credentials['idy']);
                    $depgen = Movil::getDepGenID($credentials['idarea']);

                    $data = [];
                    foreach (Movil::getProyectos($user['idinstituciones'], $credentials['idy'], $credentials['type'], $credentials['idarea']) as $row) {   
                        if(!isset($data[$row->no_dep_aux])){
                            $data[$row->no_dep_aux] = [
                                'no_dep_aux' => $row->no_dep_aux,
                                'dep_aux' => $row->dep_aux,
                                'proyectos' => []
                            ];
                        }

                        $data[$row->no_dep_aux]['proyectos'][] = [
                            'idr' => $row->idr,
                            'no_proyecto' => $row->no_proyecto,
                            'proyecto' => $row->proyecto
                        ];
                    }
                    //Convierte tu $data (asociativo) a un array numerado antes de responder:
                    return response()->json([
                        'status' => 'ok',
                        'year' => $year,
                        'depgen' => $depgen,
                        'data' => array_values($data)
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getMetastrimestre(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','idr','idy');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $proyecto = Movil::getProyectoID($credentials['idr']);

                    $rows = $this->getRowsMetas($credentials['idr'],$credentials['idy'], $user['idinstituciones']);

                    //Convierte tu $data (asociativo) a un array numerado antes de responder:
                    return response()->json([
                        'status' => 'ok',
                        'proyecto' => $proyecto,
                        'data' => $rows
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getIndicadorestrimestre(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','idr','idy');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $proyecto = Movil::getProyectoID($credentials['idr']);

                    $rows = $this->getRowsIndicadores($credentials['idr']);
                    //Convierte tu $data (asociativo) a un array numerado antes de responder:
                    return response()->json([
                        'status' => 'ok',
                        'proyecto' => $proyecto,
                        'data' => array_values($rows)
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getSaveobservacion(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id','trim','obs');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    if($credentials['trim'] == 1){
                        $this->getInsertObs($credentials['id'], $credentials['obs'], 'observaciones');
                    } else if($credentials['trim'] == 2){
                        $this->getInsertObs($credentials['id'], $credentials['obs'], 'obs2');
                    } else if($credentials['trim'] == 3){
                        $this->getInsertObs($credentials['id'], $credentials['obs'], 'obs3');
                    } else if($credentials['trim'] == 4){
                        $this->getInsertObs($credentials['id'], $credentials['obs'], 'obs4');
                    }
                    
                    return response()->json([
                        'status' => 'ok'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getSaveavance(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id', 'idmes', 'trim','avance');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $newId = $this->getInsertAvance($credentials);

                    return response()->json([
                        'status' => 'ok',
                        'id' => $newId
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }
    public function getEvidencia(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id', 'trim');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $rows = $this->getDataEvidencia($credentials);

                    return response()->json([
                        'status' => 'ok',
                        'data' => array_values($rows)
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }
    public function getDestroyevidencia(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $rows = $this->getDestroyRegistro($request, $credentials['id']);
                    
                    return response()->json([
                        'status' => 'ok'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }
    public function getUpdateevidencia(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id','cant');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $this->getUpdateRegistro($credentials['id'], $credentials['cant']);
                    
                    return response()->json([
                        'status' => 'ok'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function getArchivos(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $credentials = $request->only('idu','id');

        $user = User::find($credentials['idu'],['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }

                    $rows = Movil::getArchivos($credentials['id']);
                    
                    return response()->json([
                        'status' => 'ok',
                        'data' => $rows
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'.$user
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
    }

    public function postSaveimg(Request $request)
    {
		header('Access-Control-Allow-Origin: *');

        $user = User::find($request->idu,['id','group_id', 'active', 'idinstituciones']);

        if($user){
            try {
                if($user['active'] == 1){

                    if($user['id'] != 1){
                        $this->audit->touchLastActivity($user);
                        $this->audit->logNavigation($request, $user['id'], self::TYPE_APP);
                    }
                    
                    $this->getInsertFilesMultiple($request->idrm, $request->idrr, $request->trim, $request->file);

                    return response()->json([
                        'status' => 'ok'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Usuario no activo'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no encontrado o no autorizado'
        ]);
	}
    private function getInsertFilesMultiple($id,$idrg, $trim, $file){
		$row = Reporte::getReporteRegistro($idrg);
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->generalService->getBuildDirectoryGallery($row[0]->no_institucion, $row[0]->anio, ($row[0]->type == 1 ? 'indicador' : 'meta'), 'files', $idrg);
		$url = "./".$result['directory'];
		$name_dir = ($row[0]->type == 1 ? 'IFF' : 'MFF');
        if(!empty($file)){
            $number = $this->generalService->getBuildFilenamePDF($name_dir.$trim,$row[0]->no_institucion,$row[0]->no_dep_gen,$idrg);
            $filename = $this->generalService->getInsertImgMssFiles($file, $url, $number);
            $full_dir = public_path($result['directory'].$filename['newfilename']);
            $size = $this->generalService->getSizeFiles($full_dir);
            $data_img = array("idreporte_mes"=>$id,
                            "url"=>$url,
                            "nombre"=>$number,
                            "ext"=>$filename['ext'],
                            "bytes"=>$size['bytes'],
                            "size"=>$size['size'],
                        );
		    DB::table('ui_reporte_img')->insertGetId($data_img);
        }
	}
   
    private function getInsertAvance($credentials){
        $data = ['idreporte_reg'    => $credentials['id'],
                'idmes'             => $credentials['idmes'],
                'cantidad'          => $credentials['avance'],
                'fecha_rg'          => date('Y-m-d'),
                'hora_rg'           => date('H:i:s'),
                'iduser_rg'         => $credentials['idu']
            ];
		$id = DB::table('ui_reporte_mes')->insertGetId($data);
        return $id;
    }
    private function getInsertObs($id, $obs, $field){
       DB::table('ui_reporte_reg')->where('idreporte_reg',$id)->update([$field => $obs]);
    }
    private function getUpdateRegistro($id, $cant){
       DB::table('ui_reporte_mes')->where('idreporte_mes',$id)->update(['cantidad' => $cant]);
    }
    private function getDestroyRegistro(Request $request, $id){
        
        try {
			foreach (Reporte::getGalleryMesImgs($id) as $v) {
				$url = $v->url.'/'.$v->nombre.'.'.$v->ext;
				$ruta = public_path($url);
				if (is_file($ruta)) {
					File::delete($ruta);
				}
		        DB::table('ui_reporte_img')->where('idreporte_img', $v->idri)->delete();
			}
		} catch (\Exception $e) {
		}

		DB::table('ui_reporte_mes')->where('idreporte_mes', $id)->delete();
    }
    private function getRowsMetas($idr, $idy, $idi){
        $data = [];
        foreach (Movil::getMetas($idr,$idy, $idi) as $v) {
            $data[] = [
                'id'    => $v->id,
                'no'    => $v->no_accion,
                'um'    => $v->unidad_medida,
                'meta'  => $v->meta,
                'anual' => $v->anual,
                't1'    => $v->trim_1,
                't2'    => $v->trim_2,
                't3'    => $v->trim_3,
                't4'    => $v->trim_4,
                'c1'    => FunctionHelper::replaceDobleCeros($v->cant_1),
                'c2'    => FunctionHelper::replaceDobleCeros($v->cant_2),
                'c3'    => FunctionHelper::replaceDobleCeros($v->cant_3),
                'c4'    => FunctionHelper::replaceDobleCeros($v->cant_4),
                'p1'    => $v->por_1,
                'p2'    => $v->por_2,
                'p3'    => $v->por_3,
                'p4'    => $v->por_4,
                'o1'    => empty($v->obs1) ? 'empty' : $v->obs1,
                'o2'    => empty($v->obs2) ? 'empty' : $v->obs2,
                'o3'    => empty($v->obs3) ? 'empty' : $v->obs3,
                'o4'    => empty($v->obs4) ? 'empty' : $v->obs4,
                's1'    => $this->getEstatusMeta($v->trim_1, $v->por_1),
                's2'    => $this->getEstatusMeta($v->trim_2, $v->por_2),
                's3'    => $this->getEstatusMeta($v->trim_3, $v->por_3),
                's4'    => $this->getEstatusMeta($v->trim_4, $v->por_4),
            ];
        }
        return $data;
    }
    private function getDataEvidencia($credentials){
        $data = [];
        foreach (Movil::getEvidencia($credentials['id'], $this->getTrimestreList($credentials['trim'])) as $row) {

             if(!isset($data[$row->idmes])){
                $data[$row->idmes] = [
                    'mes' => $row->mes,
                    'rows' => []
                ];
            }

            $data[$row->idmes]['rows'][] = [
                'id' => $row->id,
                'cant' => FunctionHelper::replaceDobleCeros($row->cantidad),
                'total' => $row->total_img
            ];
        }
        return $data;
    }
    private function getTrimestreList($trim)
    {
        if($trim == 1){
            return "1,2,3";
        }else if($trim == 2){
            return "4,5,6";
        }else if($trim == 3){
            return "7,8,9";
        }else if($trim == 4){
            return "10,11,12";
        }
        return "0";
    }
    private function getRowsIndicadores($idr){
        $data = [];
        foreach (Reporte::getReportesProyectosMIR($idr) as $row) {

             if(!isset($data[$row->idreporte_mir])){
                $data[$row->idreporte_mir] = [
                    'codigo' => $row->codigo,
                    'formula' => $row->formula,
                    'indicador' => $row->indicador,
                    'indicadores' => []
                ];
            }

            $data[$row->idreporte_mir]['indicadores'][] = [
                'id' => $row->id,
                'meta' => $row->meta,
                'um' => $row->unidad_medida,
                'fm' => $row->frecuencia_medicion,
                'anual' => $row->prog_anual,
                't1'    => $row->trim_1,
                't2'    => $row->trim_2,
                't3'    => $row->trim_3,
                't4'    => $row->trim_4,
                'c1'    => FunctionHelper::replaceDobleCeros($row->cant_1),
                'c2'    => FunctionHelper::replaceDobleCeros($row->cant_2),
                'c3'    => FunctionHelper::replaceDobleCeros($row->cant_3),
                'c4'    => FunctionHelper::replaceDobleCeros($row->cant_4),
                'p1'    => $row->por_1,
                'p2'    => $row->por_2,
                'p3'    => $row->por_3,
                'p4'    => $row->por_4,
                'o1'    => empty($row->obs_1) ? 'empty' : $row->obs_1,
                'o2'    => empty($row->obs_2) ? 'empty' : $row->obs_2,
                'o3'    => empty($row->obs_3) ? 'empty' : $row->obs_3,
                'o4'    => empty($row->obs_4) ? 'empty' : $row->obs_4,
                's1'    => $this->getEstatusMeta($row->trim_1, $row->por_1),
                's2'    => $this->getEstatusMeta($row->trim_2, $row->por_2),
                's3'    => $this->getEstatusMeta($row->trim_3, $row->por_3),
                's4'    => $this->getEstatusMeta($row->trim_4, $row->por_4),
            ];
        }
        return $data;
    }
    private function getEstatusMeta($trim, $por){
        if($trim > 0 && $por > 110){
            return "max";
        }else if($trim > 0 && $por <= 89.99){
            return "min";
        }else{
            return "ok";
        }
    }

	
}
