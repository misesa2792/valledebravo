<?php
namespace App\Services\Poa;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\controller;

use App\Models\Poa\Poa;
use App\Models\Access\Years;
use App\Models\Anios;
use App\Models\Area;

use App\Services\GeneralService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Traits\JsonResponds;

class PoaService extends Controller
{
	protected $data = array();	
	protected $model;	
	protected $generalService;	

    use JsonResponds;

    public function __construct(Poa $model, GeneralService $generalService)
	{
		$this->model = $model;
		$this->generalService = $generalService;

		$this->data = array(
			'pageTitle'	=> "Presupuesto Operativo Anual",
			'pageNote'	=> "",
		);
		
	}
    public function index($type, $idmodule)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears($idmodule, $idi);
        $this->data['type'] = $type;
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['pageNote'] = $this->getPageNote($type);
        return view('anteproyecto.index',$this->data);
    }
    public function poa(Request $request)
    {
        $idu = Auth::user()->id;
        $type = $request->type;
        $idarea = $request->id;
        $idy = $request->idy;
        $this->data['idy'] = $idy;
        $this->data['type'] = $type;
        $this->data['id'] = $idarea;
        $idmodule = $this->getTypeModuleNumber($type);
        $this->data['access'] = $this->getDataUserAccess($idmodule, $idy, $idu);
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['data'] = $this->getDataInfo($type, $idy, $idarea);
        //modulo
        $this->data['modulo'] = $request->module;
        return view('anteproyecto.poa',$this->data);
    }
    public function getDataUserAccess($idmodule, $idy, $idu){
        $row = $this->model->getAccessUser($idmodule, $idy, $idu);
        if($row){
			return json_decode($row->access_data,true);
        }else{
            return false;
        }
    }
    public function unidadmedida(Request $request)
    {
        $this->data['id'] = $request->id;
        return view('anteproyecto.unidadmedida',$this->data);
    }
    public function saveum(Request $request)
    {
        $texto = ucfirst($request->descripcion);
        $row = $this->model->getUnidadMedidaExists($texto);
        if($row){
           return $this->error("La unidad de medida {$texto} ya se encuentra registrada. Por favor, verifica para evitar duplicados.");
        }
        $data = ["descripcion" => $texto ];
        \DB::table('ui_unidad_medida')->insert($data);
        return $this->success("Nueva unidad de medida agregada correctamente.",['text' => $texto ]);
    }
    public function dependencias(Request $request)
    {
        $type = $request->type;
        $idy = $request->idy;
        $this->data['rowYear'] = Anios::find($idy,['anio']);
        $this->data['rowsDepGen'] = $this->generalService->getAccessUserDependencias($idy);
        $this->data['idy'] = $idy;
        $this->data['type'] = $type;
        $this->data['active'] = 1;//POA
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['pageNote'] = $this->getPageNote($type);
        return view('anteproyecto.dependencias',$this->data);
    }
    public function permisos(Request $request)
    {
        $type = $request->type;
        $idy = $request->idy;
        $this->data['rowYear'] = Anios::find($idy,['anio']);
        $this->data['rowsUser'] = $this->getAccessUsers($type, $idy);
        $this->data['idy'] = $idy;
        $this->data['type'] = $type;
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['idmodule'] = $this->getTypeModuleNumber($type);
        $this->data['pageNote'] = $this->getPageNote($type);
        return view('anteproyecto.permisos.index',$this->data);
    }
    public function getAccessUsers($type, $idy){
        $idi = Auth::user()->idinstituciones;
        $idmodule = $this->getTypeModuleNumber($type);
        $data = [];
        foreach ($this->model->getUsersActive($idi) as $v) {
            $data[] = ['id'         => $v->id, 
                        'nivel'     => $v->nivel, 
                        'user'      => $v->username.' '.$v->first_name.' '.$v->last_name, 
                        'access'    => $this->getDataUserAccess($idmodule, $idy, $v->id),
                        'dep_gen'   => $this->model->getAccessDepGen($v->id) 
                    ];
        }
        return $data;
    }
    public function savepermisos(Request $request)
    {
        $idi = Auth::user()->idinstituciones;
        $idmodule = $request->idmodule;
        $idy = $request->idy;
        $tasks = array(
            'is_view'        => 'View ',
            'is_add'         => 'Add ',
            'is_edit'        => 'Edit ',
            'is_remove'      => 'Remove ',
            'is_generate'    => 'Generate ',
            'is_reverse'     => 'Reverse ',
            'is_download'    => 'Download ',
            //Modulos PbRM
            'is_01a'         => '01a ',
            'is_01b'         => '01b ',
            'is_01c'         => '01c ',
            'is_01d'         => '01d ',
            'is_01e'         => '01e ',
            'is_02a'         => '02a '
        );

        $this->getInsertAccessSuperAdmin($tasks, $idmodule, $idy);

        foreach ($request->ids as $idu) {
            //Se elimina el usuario con sus permisos
            \DB::table('ui_anio_permisos')
                    ->where('idmodule','=',$idmodule)
                    ->where('idanio','=',$idy)
                    ->where('iduser','=',$idu)
                    ->delete();

            $arr = [];
            foreach($tasks as $t=>$v){
                $value = $request->$t;
                $arr[$t] = (isset($value[$idu]) ? "1" : "0" );
            }
            //Se insertán los nuevos permisos
            $permissions = json_encode($arr);
            $data = ["idmodule"   => $idmodule,
                    "idanio"      => $idy,
                    "iduser"      => $idu,
                    "access_data" => $permissions
                ];
            \DB::table('ui_anio_permisos')->insert($data);
        }
        return $this->success("Permisos actualizados correctamente");
    } 
    private function getInsertAccessSuperAdmin($tasks, $idmodule, $idy){
        $idu = 1;
        \DB::table('ui_anio_permisos')
                    ->where('idmodule','=',$idmodule)
                    ->where('idanio','=',$idy)
                    ->where('iduser','=',$idu)
                    ->delete();
        $arr = [];
        foreach($tasks as $t=>$v){
            $arr[$t] = "1";
        }
        $permissions = json_encode($arr);
        $data = ["idmodule"   => $idmodule,
                "idanio"      => $idy,
                "iduser"      => $idu,
                "access_data" => $permissions
            ];
        \DB::table('ui_anio_permisos')->insert($data);
    }
    public function getDataInfo($type,$idy,$ida){
        $year = Anios::find($idy,['anio']);
        $dep_gen = Area::find($ida,['numero as no_dep_gen','descripcion as dep_gen','iddep_gen']);

        $data = [ 
                 'pageNote'     => $this->getPageNote($type),
                 'year'         => $year['anio'],
                 'iddep_gen'    => $dep_gen['iddep_gen'],
                 'no_dep_gen'   => $dep_gen['no_dep_gen'],
                 'dep_gen'      => $dep_gen['dep_gen'],
                ];
        return $data;
    }

    public function getPageNote($type){
        $note = '';
        if($type == "PA"){
            $note = 'Anteproyecto';
        }else if($type == "PP"){
            $note = 'Proyecto';
        }else if($type == "PD"){
            $note = 'Presupuesto Definitivo';
        }
        return $note;
    }  
    public function general(Request $request)
    {
        $type = $request->type;
        $idu = Auth::user()->id;
        $idy = $request->idy;
        $this->data['rowYear'] = Anios::find($request->idy,['anio']);
        $this->data['idy'] = $idy;
        $this->data['type'] = $type;
        $this->data['modulo'] = $request->module;
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['pageNote'] = $this->getPageNote($type);
        $idmodule = $this->getTypeModuleNumber($type);
        $this->data['access'] = $this->getDataUserAccess($idmodule, $idy, $idu);
        return view('anteproyecto.general.index',$this->data);
    } 
    public function getTypeModuleNumber($type){
        $module = 0;
        if($type == "PA"){
            $module = 4;
        }else if($type == "PP"){
            $module = 3;
        }else if($type == "PD"){
            $module = 2;
        }
        return $module;
    }
    public function getTypeModule($type){
        $module = "otro";
        if($type == "PA"){
            $module = 'anteproyecto';
        }else if($type == "PP"){
            $module = 'proyectos';
        }else if($type == "PD"){
            $module = 'definitivo';
        }
        return $module;
    }
    public function getTypeFolder($type){
        $folder = "otro";
        if($type == "PA"){
            $folder = 'anteproyecto';
        }else if($type == "PP"){
            $folder = 'proyecto';
        }else if($type == "PD"){
            $folder = 'definitivo';
        }
        return $folder;
    }
    public function getTypeNumber($type){
        $number = 0;
        if($type == "PA"){
            $number = 1;
        }else if($type == "PP"){
            $number = 2;
        }else if($type == "PD"){
            $number = 3;
        }
        return $number;
    }
    public function getModuleNumber($type){
        $number = 0;
        if($type == "PA"){
            $number = 4;
        }else if($type == "PP"){
            $number = 3;
        }else if($type == "PD"){
            $number = 2;
        }
        return $number;
    }
    public function getTitularesLogosFormatos($idi, $idy){
        $data = ['t_uippe'          => '',
                'c_uippe'           => '',
                't_tesoreria'       => '',
                'c_tesoreria'       => '',
                't_egresos'         => '',
                'c_egresos'         => '',
                't_secretario'      => '',
                'c_secretario'      => '',
                't_prog_pres'       => '',
                'c_prog_pres'       => '',
                'leyenda'           => '',
                'logo_izq'          => null,
                'logo_der'          => null,
                ];
        $row = $this->model->getTitularesFirmas($idi, $idy);
        if($row){
            $data = ['t_uippe'  => $row->t_uippe,
                'c_uippe'       => $row->c_uippe,
                't_tesoreria'   => $row->t_tesoreria,
                'c_tesoreria'   => $row->c_tesoreria,
                't_egresos'     => $row->t_egresos,
                'c_egresos'     => $row->c_egresos,
                't_secretario'  => $row->t_secretario,
                'c_secretario'  => $row->c_secretario,
                't_prog_pres'   => $row->t_prog_pres,
                'c_prog_pres'   => $row->c_prog_pres,
                'leyenda'       => $row->leyenda,
                'logo_izq'      => $row->logo_izq,
                'logo_der'      => $row->logo_der
                ];
        }
        return $data;
    }
    public function txt(Request $request)
    {
        $type = $request->type;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $this->data['rowYear'] = Anios::find($request->idy,['anio']);
        $this->data['idy'] = $idy;
        $this->data['type'] = $type;
        $this->data['modulo'] = $request->module;
        $this->data['pageModule'] = $this->getTypeModule($type);
        $this->data['pageNote'] = $this->getPageNote($type);
        return view('anteproyecto.txt.index',$this->data);
    } 
    public function txtpbrma(Request $request)
    {
        $data = $this->fetchDataPbrma($request);
        return $this->success("PbRM-01a", $data);
    } 
    public function txtpbrmc(Request $request)
    {
        $data = $this->fetchDataPbrmc($request);
        return $this->success("PbRM-01c", $data);
    } 
    public function txtpbrmaa(Request $request)
    {
        $data = $this->fetchDataPbrmaa($request);
        return $this->success("PbRM-02a", $data);
    }
    public function txtpbrmb(Request $request)
    {
        $data = $this->fetchDataPbrmb($request);
        return $this->success("PbRM-01b", $data);
    }
    public function txtpbrme(Request $request)
    {
        $data = $this->fetchDataPbrme($request);
        return $this->success("PbRM-01e", $data);
    }
    public function txtpbrmd(Request $request)
    {
        $data = $this->fetchDataPbrmd($request);
        return $this->success("PbRM-01d", $data);
    }
    public function txtpadag(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrma($request);
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['sp'].'"|'.'"'.$v['py'].'"|'.'"'.$v['pre'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    } 
    public function txtpamap(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrmc($request);
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['sp'].'"|'.'"'.$v['py'].'"|'.'"'.$v['co'].'"|'.'"'.$v['me'].'"|'.'"'.$v['um'].'"|'.'"'.$v['cpro'].'"|'.'"'.$v['calc'].'"|'.'"'.$v['canu'].'"|'.'"'.$v['cabs'].'"|'.'"'.$v['cpor'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    }
    public function txtcmap(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrmaa($request);
        $loc = 0;
        $ben = 100;
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$loc.'"|'.'"'.$ben.'"|'.'"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['sp'].'"|'.'"'.$v['py'].'"|'.'"'.$v['co'].'"|'.'"'.$v['me'].'"|'.'"'.$v['um'].'"|'.'"'.$v['anual'].'"|'.'"'.$v['t1'].'"|'.'"'.$v['p1'].'"|'.'"'.$v['t2'].'"|'.'"'.$v['p2'].'"|'.'"'.$v['t3'].'"|'.'"'.$v['p3'].'"|'.'"'.$v['t4'].'"|'.'"'.$v['p4'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    }
    public function txtpadpp(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrmb($request);
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$v['dg'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['prog'].'"|'.'"'.$v['fort'].'"|'.'"'.$v['opo'].'"|'.'"'.$v['deb'].'"|'.'"'.$v['ame'].'"|'.'"'.$v['ob_prog'].'"|'.'"'.$v['est'].'"|'.'"'.$v['la_obj'].'"|'.'"'.$v['la_est'].'"|'.'"'.$v['la_la'].'"|'.'"'.$v['ods_obj'].'"|'.'"'.$v['ods_metas'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    } 
    public function txtmirppdg(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrme($request);
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['prog'].'"|'.'"'.$v['obj_prog'].'"|'.'"'.$v['tipo_pilar'].'"|'.'"'.$v['no_pilar'].'"|'.'"'.$v['tema'].'"|'.'"'.$v['indicador'].'"|'.'"'.$v['nombre_indicador'].'"|'.'"'.$v['fin'].'"|'.'"'.$v['proposito'].'"|'.'"'.$v['componente'].'"|'.'"'.$v['actividad'].'"|'.'"'.$v['formula'].'"|'.'"'.$v['frecuencia'].'"|'.'"'.$v['tipo_indicador'].'"|'.'"'.$v['medios'].'"|'.'"'.$v['supuestos'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    }
    public function txtftdieg(Request $request)
    {
        $filename = $request->name;
        $archivo = $this->getGenerarPathTxt($request->idy, $filename);
        //Crea el archivo vacio
        touch($archivo);
        $manejador = "";
        $manejador = fopen($archivo, 'w+');
        $rowsData = $this->fetchDataPbrmd($request);
        foreach ($rowsData['data'] as $v) {
            $linea = '"'.$v['tp'].'"|'.'"'.$v['np'].'"|'.'"'.$v['nt'].'"|'.'"'.$v['dg'].'"|'.'"'.$v['da'].'"|'.'"'.$v['fi'].'"|'.'"'.$v['fu'].'"|'.'"'.$v['sf'].'"|'.'"'.$v['pr'].'"|'.'"'.$v['sp'].'"|'.'"'.$v['py'].'"|'.'"'.$v['op'].'"|'.'"'.$v['ni'].'"|'.'"'.$v['ti'].'"|'.'"'.$v['fl'].'"|'.'"'.$v['d_i'].'"|'.'"'.$v['d_d'].'"|'.'"'.$v['d_f'].'"|'.'"'.$v['d_fd'].'"|'.'"'.$v['d_lb'].'"|'.'"'.$v['fre'].'"|'.'"'.$v['vari'].'"|'.'"'.$v['um'].'"|'.'"'.$v['to'].'"|'.'"'.$v['t1'].'"|'.'"'.$v['t2'].'"|'.'"'.$v['t3'].'"|'.'"'.$v['t4'].'"|'.'"'.$v['al'].'"|'.'"'.$v['mv'].'"';
            fwrite($manejador, $linea . PHP_EOL);
        }
        fclose($manejador);
        return response()->download($archivo, $filename);
    } 
    private function getGenerarPathTxt($idanio, $filename){
		$full_path = 'storage/txt/'.$idanio.'/'.Auth::user()->idinstituciones.'/'.time().'/';
		$this->getCreateDirectoryGeneral($full_path);
		$archivo = public_path($full_path.$filename);
		return $archivo;
	}
    private function fetchDataPbrma(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        $total = 0;
        foreach ($this->model->getTxtPbrma($type, $idy, $idi) as $v) {
            $amount = FunctionHelper::centsBigIntToMoney($v->presupuesto);
            $data[] = ['dg' => $v->no_dep_gen,
                        'da' => $v->no_dep_aux,
                        'fi' => $v->fin,
                        'fu' => $v->fun,
                        'sf' => $v->subfun, 
                        'pr' => $v->prog, 
                        'sp' => $v->subprog, 
                        'py' => $v->proy, 
                        'pre' => number_format($amount,2), 
                    ];
            $total = $total + $v->presupuesto;
        }
        $totalGen = FunctionHelper::centsBigIntToMoney($total);
        return ['data' => $data, 'total' => number_format($totalGen,2)];
    }
    private function fetchDataPbrmc(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        foreach ($this->model->getTxtPbrmc($type, $idy, $idi) as $v) {
            $data[] = ['dg'     => $v->no_dep_gen,
                        'da'    => $v->no_dep_aux,
                        'fi'    => $v->fin,
                        'fu'    => $v->fun,
                        'sf'    => $v->subfun, 
                        'pr'    => $v->prog, 
                        'sp'    => $v->subprog, 
                        'py'    => $v->proy, 
                        'co'    => $v->codigo, 
                        'me'    => $v->meta, 
                        'um'    => $v->unidad_medida, 
                        'cpro'  => $v->c_programado, 
                        'calc'  => $v->c_alcanzado, 
                        'canu'  => $v->c_anual, 
                        'cabs'  => $v->c_absoluta, 
                        'cpor'  => $v->c_porcentaje
                    ];
        }
        return ['data' => $data];
    }
    private function fetchDataPbrmaa(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        foreach ($this->model->getTxtPbrmc($type, $idy, $idi) as $v) {
            $data[] = ['dg'     => $v->no_dep_gen,
                        'da'    => $v->no_dep_aux,
                        'fi'    => $v->fin,
                        'fu'    => $v->fun,
                        'sf'    => $v->subfun, 
                        'pr'    => $v->prog, 
                        'sp'    => $v->subprog, 
                        'py'    => $v->proy, 
                        'co'    => $v->codigo, 
                        'me'    => $v->meta, 
                        'um'    => $v->unidad_medida, 
                        'anual' => $v->aa_anual, 
                        't1'    => $v->aa_trim1, 
                        't2'    => $v->aa_trim2, 
                        't3'    => $v->aa_trim3, 
                        't4'    => $v->aa_trim4, 
                        'p1'    => $v->aa_porc1, 
                        'p2'    => $v->aa_porc2, 
                        'p3'    => $v->aa_porc3, 
                        'p4'    => $v->aa_porc4 
                    ];
        }
        return ['data' => $data];
    }
    private function fetchDataPbrmb(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        foreach ($this->model->getTxtPbrmb($type, $idy, $idi) as $v) {
            $data_la = $this->getRowsLineasAccion($v->lineas_accion);
            $data_ods = $this->getRowsOds($v->ods);
            $data[] = ['dg'             => $v->no_dep_gen,
                        'fi'            => $v->fin,
                        'fu'            => $v->fun,
                        'sf'            => $v->subfun, 
                        'pr'            => $v->prog, 
                        'prog'          => $v->programa, 
                        'ob_prog'       => $v->obj_programa, 
                        'fort'          => $this->getRowJsonDecode($v->fortalezas), 
                        'opo'           => $this->getRowJsonDecode($v->oportunidades), 
                        'deb'           => $this->getRowJsonDecode($v->debilidades), 
                        'ame'           => $this->getRowJsonDecode($v->amenazas), 
                        'est'           => $this->getRowJsonDecode($v->estrategias), 
                        'la_obj'        => $data_la['obj'], 
                        'la_est'        => $data_la['est'], 
                        'la_la'         => $data_la['la'],
                        'ods_obj'       => $data_ods['obj'],
                        'ods_metas'     => $data_ods['metas']
                    ];
        }
        return ['data' => $data];
    }
    private function fetchDataPbrme(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        foreach ($this->model->getTxtPbrme($type, $idy, $idi) as $v) {
            $fin = $proposito = $comp = $act = "";
            if($v->tipo == 1){
                $fin = $v->indicador;
            }else if($v->tipo == 2){
                $proposito = $v->indicador;
            }else if($v->tipo == 3){
                $comp = $v->indicador;
            }else if($v->tipo == 4){
                $act = $v->indicador;
            }
            $data[] = ['dg'                 => $v->no_dep_gen,
                        'da'                => $v->no_dep_aux,
                        'fi'                => $v->fin,
                        'fu'                => $v->fun,
                        'sf'                => $v->subfun, 
                        'pr'                => $v->prog, 
                        'prog'              => $v->programa, 
                        'obj_prog'          => $v->obj_programa, 
                        'tipo_pilar'        => $v->tipo_pilar, 
                        'no_pilar'          => $v->no_pilar, 
                        'tema'              => $this->getReplacePbrme($v->tema), 
                        'indicador'        => $v->indicador, 
                        'nombre_indicador' => $v->nombre_indicador, 
                        'fin'              => $fin,
                        'proposito'        => $proposito,
                        'componente'       => $comp,
                        'actividad'        => $act,
                        'formula'          => $v->formula, 
                        'frecuencia'       => $v->frecuencia, 
                        'tipo_indicador'   => $v->tipo_indicador, 
                        'medios'           => $v->medios, 
                        'supuestos'        => $v->supuestos
                    ];
        }
        return ['data' => $data];
    }
    private function getReplacePbrme($texto){
        return str_replace(['"','“', '”'], '', trim($texto));
    }
    private function fetchDataPbrmd(Request $request){
        $type = 3;
        $idi = Auth::user()->idinstituciones;
        $idy = $request->idy;
        $data = [];
        foreach ($this->model->getTxtPbrmd($type, $idy, $idi) as $v) {
            $data[] = ['tp'    => $v->tipo_pilar, 
                        'np'   => $v->no_pilar, 
                        'nt'   => $v->no_tema, 
                        'dg'   => $v->no_dep_gen,
                        'da'   => $v->no_dep_aux,
                        'fi'   => $v->fin,
                        'fu'   => $v->fun,
                        'sf'   => $v->subfun, 
                        'pr'   => $v->prog, 
                        'sp'   => $v->subprog, 
                        'py'   => $v->proy, 
                        'op'   => $v->obj_proyecto, 
                        'ni'   => $v->nombre_indicador, 
                        'ti'   => $v->tipo_indicador, 
                        'fl'  => $v->formula, 
                        'd_i'  => $v->d_interpretacion, 
                        'd_d'  => $v->d_dimencion, 
                        'd_f'  => $v->d_factor,
                        'd_fd' => $v->d_factor_desc,
                        'd_lb' => $v->d_linea_base,
                        'fre'  => $v->frecuencia,
                        'vari' => $v->variable,
                        'um'   => $v->unidad_medida,
                        'to'   => $v->tipo_operacion,
                        't1'   => $v->trim1,
                        't2'   => $v->trim2,
                        't3'   => $v->trim3,
                        't4'   => $v->trim4,
                        'al'   => $v->anual,
                        'mv'   => $v->medios_verificacion
                    ];
        }
        return ['data' => $data];
    }
    private function getRowsOds($id){
        $ids = json_decode($id,true);
        $metas = [];
        $objetivo = [];
        $str_metas = "";
        $str_obj = "";
        foreach ($this->model->getTxtOds($ids) as $v) {
            //in_array valida que un dato ya esta presente en el array, devuelve true.
            if(!in_array($v->metas, $metas)){
                $metas[] = $v->metas;
                $str_metas .= $v->metas . " ";
            }

            if(!in_array($v->objetivo, $objetivo)){
                $objetivo[] = $v->objetivo;
                $str_obj .= $v->objetivo . " ";
            }
        }
        return ['obj' => trim($str_obj), 'metas' => trim($str_metas) ];
    }
    private function getRowsLineasAccion($id){
        $ids = json_decode($id,true);
        $objetivo = [];
        $estrategias = [];
        $lineas_accion = [];
        $str_obj = "";
        $str_est = "";
        $str_la = "";
        foreach ($this->model->getTxtLineasAccion($ids) as $v) {
            
            $txt_obj = $v->no_obj . " " . $v->name_obj;
            if(!in_array($txt_obj, $objetivo)){
                $objetivo[] = $txt_obj;
                $str_obj .= $txt_obj . " ";
            }

            $txt_est = $v->no_est . " " . $v->name_est;
            if(!in_array($txt_est, $estrategias)){
                $estrategias[] = $txt_est;
                $str_est .= $txt_est . " ";
            }

            $txt_la = $v->no_la . " " . $v->name_la;
            if(!in_array($txt_la, $lineas_accion)){
                $lineas_accion[] = $txt_la;
                $str_la .= $txt_la . " ";
            }
        }
        return ['obj' => trim($str_obj), 'est' => trim($str_est), 'la' => trim($str_la) ];
    }
    private function getRowJsonDecode($rows){
        $cad = "";
        $j = 1;
        foreach (json_decode($rows) as $v) {
            $cad = $cad ."". $j++ .".".$v." ";
        }
        return $cad;
    }
}