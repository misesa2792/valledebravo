<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Panel;
use App\Models\Access\Years;
use App\Models\Anios;
use App\Models\Area;
use App\Models\Sximo;
use App\Models\Instituciones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use SiteHelpers, Input;
use Excel;

use App\Traits\JsonResponds;

class PanelController extends Controller {

	protected $data;	
	protected $model;	
	protected $info;	
	public $module = 'panel';

    const MODULE = 5; // Modulo de acceso a años

    use JsonResponds;

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Panel();
		
		$this->data = array(
			'pageTitle'	=> 'Panel administrativo',
			'pageNote'	=> 'Lista de módulos',
			'pageModule'=> 'panel'
		);
		
	}

	public function getGraficas( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		if(isset($request->idy)){
			$this->data['row'] = Anios::find($request->idy,['idanio as idy','anio as year']);
			return view('panel.graficas.view',$this->data);
		}
		return view('panel.graficas.index',$this->data);
	}	

	public function getGenerartxt( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		return view('panel.generartxt.index',$this->data);
	}	
	public function postGenerartxt( Request $request )
	{
		try {
			$file= $request->archivos;
			if(empty($file)){
				return Redirect::to('panel/generartxt')->with('messagetext', 'Ingresa archivo .xlsx')->with('msgstatus','error');
			}

			$ext = $file->getClientOriginalExtension();

			if($ext == "xlsx" or $ext == "xls" or $ext == "XLSX" or $ext == "XLS"){
				//Obtengo el directorio del archivo
				$path = $file->getRealPath();

				$data = Excel::selectSheetsByIndex(0)->load($path, function($reader) { })->get();

				//Verificó que tenga datos el excel
				if(!empty($data) && $data->count()){
					//Recorro hasta las preguntas del excel
					$nombre_archivo = rand(5,99999).'_'.time();
					//Path donde estara el archivo .txt
					$archivo = public_path('archivos/101/txt/'.$nombre_archivo.'.txt');
					//Crea el archivo vacio
					touch($archivo);
					$manejador = "";
					$manejador = fopen($archivo, 'w+');

					// Obtener los encabezados del archivo Excel
					$encabezados = $data->first()->keys()->toArray();
					// Hacer lo que necesites con los encabezados, por ejemplo, imprimirlos
					$total = count($encabezados);
									
					for ($l=0; $l < count($data)  ; $l++) {
						$linea="";
						for ($i=0; $i < $total; $i++) { 
							$numero = $encabezados[$i];
							if($numero != "" && $numero != "0"){
								$remplazar = (!empty($data[$l][$numero]) ? trim(str_replace(["'","|", '"', "\n", "\r", "\r\n"], "", $data[$l][$numero])) : $data[$l][$numero]);
								$linea .= '"'.$remplazar.'"|';
							}
						}
						$nueva_cadena = substr($linea, 0, -1);
						/*$linea = '"'.$data[$l]['programa_8_digitos'].'"|'.
									'"'.$data[$l]['dependencia_general'].'"|'.
									'"'.$data[$l]['diagnostico_de_programa_presupuestario_elaborado_usando_analisis_foda'].'"|'.
									'"'.$data[$l]['objetivo_del_programa_presupuestario'].'"|'.
									'"'.$data[$l]['estrategias_para_alcanzar_el_objetivo_del_programa_presupuestario'].'"|'.
									'"'.$data[$l]['objetivos_estrategias_y_lineas_de_accion_del_pdm_atendidas'].'"|'.
									'"'.$data[$l]['objetivos_y_metas_para_el_desarrollo_sostenible_ods_atendidas_por_el_programa_presupuestario'];*/
							// Abrir el archivo en modo escritura ('w')
							fwrite($manejador, $nueva_cadena . PHP_EOL);
					}
					fclose($manejador);
					return response()->download($archivo, $nombre_archivo.'.txt');
				} 
			} 

			return Redirect::to('panel/generartxt')->with('messagetext', 'Extensión invalida')->with('msgstatus','error');

		} catch (\Exception $e) {
			
			SiteHelpers::auditTrail($request , 'Error: '.$e->getMessage());

			return Redirect::to('panel/generartxt')->with('messagetext', 'Error al generar el .txt')->with('msgstatus','error');
		}
	}

	public function getPoa( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2 && Auth::user()->id != 37){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		if(isset($request->idy)){
			$this->data['row'] = Anios::find($request->idy,['idanio as idy','anio as year']);
			if($request->idy >= 4){
				return view('panel.poa.view2',$this->data);
			}
			return view('panel.poa.view',$this->data);
		}
		return view('panel.poa.index',$this->data);
	}	

	public function getTitulares( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		//$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		$this->data['rowsAnios'] = \DB::select("SELECT idanio, anio FROM ui_anio WHERE idanio in (4,5)");
		if(isset($request->idy)){
			$this->data['row'] = Anios::find($request->idy,['idanio as idy','anio as year']);
			return view('panel.titulares.view',$this->data);
		}
		return view('panel.titulares.index',$this->data);
	}
	public function getDependencias( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		//$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		$this->data['rowsAnios'] = \DB::select("SELECT idanio, anio FROM ui_anio WHERE idanio in (4,5)");
		if(isset($request->idy)){
			$this->data['row'] = Anios::find($request->idy,['idanio as idy','anio as year']);
			$this->data['pages']	= $this->getNoPaginacion(); 
			return view('panel.dependencias.view',$this->data);
		}
		return view('panel.dependencias.index',$this->data);
	}
	public function getConfiguracion( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		//$this->data['rowsAnios'] = Years::getModuleAccessByYears(self::MODULE, Auth::user()->idinstituciones);
		$this->data['rowsAnios'] = \DB::select("SELECT idanio, anio FROM ui_anio WHERE idanio in (4,5)");
		if(isset($request->idy)){
			$this->data['row'] = Anios::find($request->idy,['idanio as idy','anio as year']);
			$this->data['pages'] = $this->getNoPaginacion(); 
			$this->data['rows'] = $this->model->getConfiguracion(Auth::user()->idinstituciones, $request->idy); 
			return view('panel.configuracion.view',$this->data);
		}
		return view('panel.configuracion.index',$this->data);
	}
	public function postSaveconfig( Request $request )
	{
		$data = ['t_uippe' => $request->t_uippe, 'c_uippe' => $request->c_uippe,
				't_tesoreria' => $request->t_tesoreria, 'c_tesoreria' => $request->c_tesoreria, 
		];
		Sximo::getUpdateTable($data, 'ui_instituciones_info', 'idinstituciones_info', $request->id);
		return Redirect::to('panel/configuracion?idy='.$request->idy)->with('messagetext', 'Información guardada correctamente!')->with('msgstatus','success');
	}
	public function getEnlaces( Request $request )
	{
		if(Auth::user()->group_id != 1 && Auth::user()->group_id != 2){
			return Redirect::to('dashboard')->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$idi = Auth::user()->idinstituciones;
		$row = Instituciones::find($idi,['idtipo_dependencias']);
		$this->data['idi'] = $idi; 
		$this->data['idtd'] = $row->idtipo_dependencias; 
		$this->data['pages'] = $this->getNoPaginacion(); 
		$this->data['rowsNivel'] = [];
		return view('usuarios.index',$this->data);	
	}
	public function getEditartitular( Request $request )
	{
		$this->data['row'] = Area::find($request->id,['numero as no_dep_gen','descripcion as dep_gen','titular','cargo']);
		$this->data['id'] = $request->id;
		return view('panel.titulares.edit',$this->data);
	}
	public function postUpdatetitular( Request $request )
	{
		$data = ['titular' => $request->titular, 'cargo' => $request->cargo ];
		$row = Area::find($request->id);
        $row->update($data);
        return $this->success('Datos actualizados correctamente!');
	}
	public function getSearchdepgen( Request $request )
	{
		$data = $this->model->getDepGen(Auth::user()->idinstituciones, $request->idy);
        return $this->success('Información', $data);
	}

}