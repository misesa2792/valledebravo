<?php
namespace App\Services\Presupuesto;

use App\Models\Transpasosinternos;
use App\Models\Access\Years;
use App\Models\Anios;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TranspasosService extends Controller
{
	protected $data = array();	
	protected $model;	
	protected $poaService;	

    public function __construct(Transpasosinternos $model)
	{
        $this->model = $model;
		$this->data = array(
			'pageTitle'	=> "Presupuesto",
			'pageNote'	=> "Lista de registros",
			'pageModule'=> 'transpasosinternos'
		);
		
	}
    public function index($type)
    {
        $idi = Auth::user()->idinstituciones;
		$this->data['rowsAnios'] = Years::getModuleAccessByYears(5, $idi);
		return view('transpasosinternos.index',$this->data);
    }
	public function proyectos(Request $request)
    {
		$this->data['idam'] = $request->idam;
		return view('transpasosinternos.proyectos',$this->data);
    }
	public function generate(Request $request)
    {
		$idam = 4;
		$this->data['idam'] = $request->idam;
		$this->data['id'] = $request->id;
		if($request->type == 1){
			$this->data['data'] = $this->infoTranspaso($request->id,$idam);
			return view('transpasosinternos.interno.generate',$this->data);
		}else{
			$this->data['data'] = $this->infoTranspaso($request->id,$idam);
			return view('transpasosinternos.externo.generate',$this->data);
		}
    }
	
	public function generatenote(Request $request)
    {
		$this->data['idam'] = $request->idam;
		$this->data['id'] = $request->id;
		$this->data['data'] = $this->infoTranspaso($request->id, $request->idam);
		return view('transpasosinternos.nota.generate',$this->data);
    }
	public function generaterec(Request $request)
    {
		$this->data['idam'] = $request->idam;
		$this->data['id'] = $request->id;
		$this->data['data'] = $this->infoTranspaso($request->id, $request->idam);
		return view('transpasosinternos.reconduccion.generate',$this->data);
    }
	private function getFirmas($idanio_info){
		$data =  ["logo_izq" 		=> '',
					"logo_der" 		=> '',
					"t_uippe" 		=> '',
					"t_tesoreria" 	=> '',
					"t_egresos" 	=> '',
					"t_prog_pres"	=> '',
					"t_secretario"	=> '',
					"c_uippe"		=> '',
					"c_tesoreria"	=> '',
					"c_egresos"		=> '',
					"c_prog_pres"	=> '',
					"c_secretario"	=> ''
			];
        $idi = Auth::user()->idinstituciones;
		$row = $this->model->getFirmas($idi,$idanio_info);
		$year = Anios::find($idanio_info,['leyenda']);
		if($row){
			$data['logo_izq'] 		= $row->logo_izq;
			$data['logo_der'] 		= $row->logo_der;
			$data['t_uippe']		= $row->t_uippe;
			$data['t_tesoreria'] 	= $row->t_tesoreria;
			$data['t_egresos'] 		= $row->t_egresos;
			$data['t_prog_pres']	= $row->t_prog_pres;
			$data['t_secretario'] 	= $row->t_secretario;
			$data['c_uippe'] 		= $row->c_uippe;
			$data['c_tesoreria'] 	= $row->c_tesoreria;
			$data['c_egresos'] 		= $row->c_egresos;
			$data['c_prog_pres'] 	= $row->c_prog_pres;
			$data['c_secretario'] 	= $row->c_secretario;
			$data['leyenda'] 		= $year->leyenda;
		}
		return $data;
	}
	private function getFecha($institucion){
		return $institucion.", MÉXICO A ".date('d')." ".$this->getDataMeses(date('n'))." DE ".date('Y');
	}
	private function infoTranspaso($id,$idam){
		//$module = Years::getIdModule($idam);
		$idanio_info = 4;
		$row = $this->model->getInfoTranspaso($id);
		$proy_int = $this->model->getPresupuestoProyecto($idam,$row->iddep_gen,$row->iddep_aux,$row->idproyecto);
		$pres_int = ($proy_int != null ? $proy_int->presupuesto : 0);

		$proy_ext = $this->model->getPresupuestoProyecto($idam,$row->iddep_gen_ext,$row->iddep_aux_ext,$row->idproyecto_ext);
		$pres_ext = ($proy_ext != null ? $proy_ext->presupuesto : 0);

		$registros = $this->getRowsTranspasoRegistros($id);
		$total = count($registros);

		$data = ['idi' 			  => 1,
				'no_institucion'  => 101,
				'institucion'     => 'Toluca',
				'anio'            => 2024,
				'fecha'           => $this->getFecha('101'),
				"dep_int" 		  => ["no_dep_gen" 	=> $row->no_dep_gen, 
									"dep_gen" 		=> $row->dep_gen,
									"no_dep_aux" 	=> $row->no_dep_aux,
									"dep_aux" 		=> $row->dep_aux,
									"no_proyecto" 	=> $row->no_proyecto,
									"proyecto" 		=> $row->proyecto,
									"no_programa" 	=> $row->no_programa,
									"programa" 		=> $row->programa,
									"obj_programa" 	=> $row->obj_programa,
									"clasificacion" => $row->clasificacion,
									"clave" => $row->no_dep_gen." ".$row->no_dep_aux." ".$row->no_proyecto." ".$row->clasificacion,
									"presupuesto" => $pres_int,
					],
				"dep_ext" 		=> ["no_dep_gen" 	=> $row->no_dep_gen_ext, 
							"dep_gen" 		=> $row->dep_gen_ext,
							"no_dep_aux" 	=> $row->no_dep_aux_ext,
							"dep_aux" 		=> $row->dep_aux_ext,
							"no_proyecto" 	=> $row->no_proyecto_ext,
							"proyecto" 		=> $row->proyecto_ext,
							"no_programa" 	=> $row->no_programa_ext,
							"programa" 		=> $row->programa_ext,
							"obj_programa" 	=> $row->obj_programa_ext,
							"clasificacion" => $row->clasificacion_ext,
							"clave" => $row->no_dep_gen_ext." ".$row->no_dep_aux_ext." ".$row->no_proyecto_ext." ".$row->clasificacion_ext,
							"presupuesto" => $pres_ext,
						],
				"justificacion" => $row->justificacion,
				"importe" 		=> $row->importe,
				"count" 		=> $total,
				"resta" 		=> ($total > 10 ? $total : 10 - $total),
				"rowsRegistros" => $registros,
				"footer" 		=> $this->getFirmas($idanio_info)
			];
		return $data;
	}
	private function getRowsTranspasoRegistros($id){
		$data = [];
		foreach ($this->model->getInfoTranspasoInternoReg($id) as $v) {
			$data[] = ['no_ff' 		=> $v->no_ff, 
						'ff' 		=> $v->ff, 
						'd_partida' => $v->d_partida, 
						'a_partida' => $v->a_partida,
						'd_mes' 	=> $v->d_mes,
						'a_mes' 	=> $v->a_mes,
						'importe' 	=> $v->importe
					];
			
		}
		return $data;
	}
	public function pdfti(Request $request)
	{
		$id = $request->id;
		$idam = $request->idam;
		$data = $this->infoTranspaso($id, $idam);
		$this->data['data'] = $data;
		$this->data['request'] = $request->all();
		//Se construye el nombre del PDF
		$number = $this->getBuildFilenamePDF("FSTI",$data['no_institucion'], $data['dep_int']['no_dep_gen'], $id);
		$filename = $number.".pdf";
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectory($data['no_institucion'], $data['anio'], 'tesoreria', 'fsti');
		$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
								'margin_top' => 35,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 40,
								]);
		//Construcción del PDF
		$mpdf->SetHTMLHeader(View::make("transpasosinternos.interno.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("transpasosinternos.interno.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('transpasosinternos.interno.pdf.body',$this->data));
		//Construcción del full path
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		$this->model->getUpdateTable(['number' => $number, 'oficio'=> $request->oficio], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->getInsertTablePlan($data['idi'], $number, $url, $result['directory']);
		return response()->json([
			'status'  => 'ok',
			'message' => 'PDF generado exitosamente.',
			'number'  => $number
		]);
	}
	public function pdfte(Request $request)
	{
		$id = $request->id;
		$idam = $request->idam;
		$data = $this->infoTranspaso($id, $idam);
		$this->data['data'] = $data;
		$this->data['request'] = $request->all();
		//Se construye el nombre del PDF
		$number = $this->getBuildFilenamePDF("FSTE",$data['no_institucion'], $data['dep_int']['no_dep_gen'], $id);
		$filename = $number.".pdf";
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectory($data['no_institucion'], $data['anio'], 'tesoreria', 'fste');
		$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
								'margin_top' => 40,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 40,
								]);
		//Construcción del PDF
		$mpdf->SetHTMLHeader(View::make("transpasosinternos.externo.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("transpasosinternos.externo.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('transpasosinternos.externo.pdf.body',$this->data));
		//Construcción del full path
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		$this->model->getUpdateTable(['number' => $number, 'oficio'=> $request->oficio], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->getInsertTablePlan($data['idi'], $number, $url, $result['directory']);
		return response()->json([
			'status'  => 'ok',
			'message' => 'PDF generado exitosamente.',
			'number'  => $number
		]);
	}
	public function pdfnote(Request $request)
	{
		$id = $request->id;
		$idam = $request->idam;
		$data = $this->infoTranspaso($id, $idam);
		$this->data['data'] = $data;
		$this->data['request'] = $request->all();
		//Se construye el nombre del PDF
		$number = $this->getBuildFilenamePDF("NOTA",$data['no_institucion'], $data['dep_int']['no_dep_gen'], $id);
		$filename = $number.".pdf";
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectory($data['no_institucion'], $data['anio'], 'tesoreria', 'nota');
		$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
								'margin_top' => 35,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 40,
								]);
		//Construcción del PDF
		$mpdf->SetHTMLHeader(View::make("transpasosinternos.nota.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("transpasosinternos.nota.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('transpasosinternos.nota.pdf.body',$this->data));
		//Construcción del full path
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		$this->model->getUpdateTable(['number_nota' => $number], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->getInsertTablePlan($data['idi'], $number, $url, $result['directory']);
		return response()->json([
			'status'  => 'ok',
			'message' => 'PDF generado exitosamente.',
			'number'  => $number
		]);
	}
	public function pdfreconduccion(Request $request)
	{
		$id = $request->id;
		$idam = $request->idam;
		$data = $this->infoTranspaso($id, $idam);
		$this->data['data'] = $data;
		$this->data['request'] = $request->all();
		//Se construye el nombre del PDF
		$number = $this->getBuildFilenamePDF("RECO",$data['no_institucion'], $data['dep_int']['no_dep_gen'], $id);
		$filename = $number.".pdf";
		//Construcción del directorio donde se va almacenar el PDF
		$result = $this->getBuildDirectory($data['no_institucion'], $data['anio'], 'tesoreria', 'reco');
		$mpdf = new \Mpdf\Mpdf(['format' => 'letter',
								'orientation' => 'L',
								'margin_top' => 26,
								'margin_left' => 5,
								'margin_right' => 5,
								'margin_bottom' => 40,
								]);
		//Construcción del PDF
		$mpdf->SetHTMLHeader(View::make("transpasosinternos.reconduccion.pdf.header", $this->data)->render());
		$mpdf->SetHTMLFooter(View::make("transpasosinternos.reconduccion.pdf.footer", $this->data)->render());
		$mpdf->WriteHTML(view('transpasosinternos.reconduccion.pdf.body',$this->data));
		//Construcción del full path
		$url = $result['full_path'].$filename;
		//Save PDF in directory
		$mpdf->Output($url, 'F');
		$this->model->getUpdateTable(['number_rec' => $number], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->getInsertTablePlan($data['idi'], $number, $url, $result['directory']);
		return response()->json([
			'status'  => 'ok',
			'message' => 'PDF generado exitosamente.',
			'number'  => $number
		]);
	}
	public function agregar(Request $request)
    {
		$type = $request->type;
		$idam = $request->idam;
		$this->data['idam'] = $idam;
		$this->data['type'] = $type;
		//$row = Years::getIdModule($idam);
		$idanio_info = 4;
		$idtipo_dependencias = 1;
			$this->data['data'] = [
								'year'        	 => 2024,
								'no_institucion' => '101',
								'institucion'    => 'Toluca',
								'rowsProjects'   => $this->model->getProyectos($idanio_info),
								'rowsDepGen'     => $this->model->getDepGen($idtipo_dependencias,$idanio_info),
								'rowsDepAux'     => $this->model->getDepAux($idtipo_dependencias,$idanio_info)
							];
		if($type == 1){
			return view('transpasosinternos.interno.add',$this->data);
		}else{
			return view('transpasosinternos.externo.add',$this->data);
		}
    }
	public function edit(Request $request)
    {
		$type = $request->type;
		$idam = $request->idam;
		$id = $request->id;
		$this->data['idam'] = $idam;
		$this->data['id'] = $id;
		$this->data['type'] = $type;
		$row = Years::getIdModule($idam);
		$this->data['data'] = [
								'year'        	 => $row->anio,
								'no_institucion' => $row->no_institucion,
								'institucion'    => $row->institucion,
								'rowsProjects'   => $this->model->getProyectos($row->idanio_info),
								'rowsDepGen'     => $this->model->getDepGen($row->idtipo_dependencias,$row->idanio_info),
								'rowsDepAux'     => $this->model->getDepAux($row->idtipo_dependencias,$row->idanio_info),
								'row'     		 => $this->model->getEditTraspaso($id),
								'rowReg'     	 => $this->model->getEditTraspasoReg($id)
							];
		$this->data['rowsFF'] = $this->model->getFuenteFinanciamiento($row->idanio_info);
		$this->data['rowsPartidas'] = $this->model->getPartidasEspecificas($row->idanio_info);
		$this->data['rowsMes'] = $this->model->getCatMeses();
		if($type == 1){
			return view('transpasosinternos.interno.edit',$this->data);
		}else{
			return view('transpasosinternos.externo.edit',$this->data);
		}
    }
	public function reverse(Request $request)
	{
		$params = $request->params;
		$id = $params['id'];
		$this->model->getUpdateTable(['number' => null, 'oficio'=> null], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->updatePlanPDFNew($params['number']);
		
		return response()->json([
			'status' => 'ok',
			'message' => 'PDF revertido correctamente!'
		]);
	}
	public function reversenote(Request $request)
	{
		$params = $request->params;
		$id = $params['id'];
		$this->model->getUpdateTable(['number_nota' => null], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->updatePlanPDFNew($params['number']);
		return response()->json([
			'status' => 'ok',
			'message' => 'PDF revertido correctamente!'
		]);
	}
	public function reverserec(Request $request)
	{
		$params = $request->params;
		$id = $params['id'];
		$this->model->getUpdateTable(['number_rec' => null], "ui_teso_trans_int", "idteso_trans_int", $id);
		$this->updatePlanPDFNew($params['number']);
		return response()->json([
			'status' => 'ok',
			'message' => 'PDF revertido correctamente!'
		]);
	}
	public function registro(Request $request)
	{
		$this->model->getDestroyTable("ui_teso_trans_int_reg", "idteso_trans_int_reg", $request->id);
		return response()->json([
			'status' => 'ok',
			'message' => 'Registro eliminado correctamente!'
		]);
	}
	public function tr(Request $request)
    {
		$this->data['idam'] = $request->idam;
		$this->data['time'] = rand(3,100).time();
		//$row = Years::getIdModule($request->idam);
		$idanio_info = 4;
		$this->data['rowsFF'] = $this->model->getFuenteFinanciamiento($idanio_info);
		$this->data['rowsPartidas'] = $this->model->getPartidasEspecificas($idanio_info);
		$this->data['rowsMes'] = $this->model->getCatMeses();
		return view('transpasosinternos.tr',$this->data);
    }
	public function saveti(Request $request)
	{
		$data = [
				'type' 					  => $request['type'],
				'idanio_module' 		  => $request['idam'], 
				'iddep_gen' 		 	  => $request['iddep_gen'], 
				'iddep_aux' 	  		  => $request['iddep_aux'],
				'idproyecto' 			  => $request['idproyecto'],
				'iddep_gen_ext' 		  => $request['iddep_gen'], 
				'iddep_aux_ext' 	      => $request['iddep_aux'],
				'idproyecto_ext' 		  => $request['idproyecto'],
				'justificacion' 		  => mb_strtoupper($this->getUnirTextoSaltosLinea($request['justificacion']), 'UTF-8'),
				'fecha_rg'				  => date('Y-m-d'),
				'hora_rg'				  => date('H:i:s A'),
				'iduser_rg' 			  => Auth::user()->id,
				'std_delete' 			  => 1
				];
		$id = $this->model->getInsertTable($data, "ui_teso_trans_int");
		
		for ($i=0; $i < count($request['d_ff']); $i++) { 
			$arr_reg[] = ['idteso_trans_int' 	=> $id, 
					'idteso_ff_n3' 			=> $request['d_ff'][$i],
					'd_idteso_partidas_esp' => $request['d_partida'][$i],
					'd_idmes' 				=> $request['d_mes'][$i],
					'importe' 				=> $this->getClearNumber($request['d_importe'][$i]),
					'a_idteso_partidas_esp' => $request['a_partida'][$i],
					'a_idmes' 				=> $request['a_mes'][$i]
					];
		}
		$this->model->getInsertTableData($arr_reg, "ui_teso_trans_int_reg");
		return response()->json([
			'status' => 'ok',
			'message' => 'Datos guardados correctamente'
		]);
	}
	public function editti(Request $request)
	{
		$id = $request->id;
		$data = [
				'iddep_gen' 		 	  => $request['iddep_gen'], 
				'iddep_aux' 	  		  => $request['iddep_aux'],
				'idproyecto' 			  => $request['idproyecto'],
				'iddep_gen_ext' 		  => $request['iddep_gen'], 
				'iddep_aux_ext' 	      => $request['iddep_aux'],
				'idproyecto_ext' 		  => $request['idproyecto'],
				'justificacion' 		  => mb_strtoupper($this->getUnirTextoSaltosLinea($request['justificacion']), 'UTF-8'),
				];
		$this->model->getUpdateTable($data, "ui_teso_trans_int","idteso_trans_int",$id);
		
		for ($i=0; $i < count($request['d_ff']); $i++) { 
			$idr = $request['idr'][$i];

			$arr_reg = ['idteso_trans_int' 	=> $id, 
					'idteso_ff_n3' 			=> $request['d_ff'][$i],
					'd_idteso_partidas_esp' => $request['d_partida'][$i],
					'd_idmes' 				=> $request['d_mes'][$i],
					'importe' 				=> $this->getClearNumber($request['d_importe'][$i]),
					'a_idteso_partidas_esp' => $request['a_partida'][$i],
					'a_idmes' 				=> $request['a_mes'][$i]
					];
			if($idr > 0){
				$this->model->getUpdateTable($arr_reg, "ui_teso_trans_int_reg","idteso_trans_int_reg",$idr);
			}else{
				$this->model->getInsertTable($arr_reg, "ui_teso_trans_int_reg");
			}
		}
		return response()->json([
			'status' => 'ok',
			'message' => 'Datos guardados correctamente'
		]);
	}
	public function editte(Request $request)
	{
		$id = $request->id;

		$data = [
				'iddep_gen' 		 	  => $request['iddep_gen'], 
				'iddep_aux' 	  		  => $request['iddep_aux'],
				'idproyecto' 			  => $request['idproyecto'],
				'iddep_gen_ext' 		  => $request['iddep_gen_ext'], 
				'iddep_aux_ext' 	      => $request['iddep_aux_ext'],
				'idproyecto_ext' 		  => $request['idproyecto_ext'],
				'justificacion' 		  => mb_strtoupper($this->getUnirTextoSaltosLinea($request['justificacion']), 'UTF-8'),
				];
		$this->model->getUpdateTable($data, "ui_teso_trans_int","idteso_trans_int",$id);
		
		for ($i=0; $i < count($request['d_ff']); $i++) { 
			$idr = $request['idr'][$i];
			
			$arr_reg = ['idteso_trans_int' 	=> $id, 
					'idteso_ff_n3' 			=> $request['d_ff'][$i],
					'd_idteso_partidas_esp' => $request['d_partida'][$i],
					'd_idmes' 				=> $request['d_mes'][$i],
					'importe' 				=> $this->getClearNumber($request['d_importe'][$i]),
					'a_idteso_partidas_esp' => $request['a_partida'][$i],
					'a_idmes' 				=> $request['a_mes'][$i]
					];
			if($idr > 0){
				$this->model->getUpdateTable($arr_reg, "ui_teso_trans_int_reg","idteso_trans_int_reg",$idr);
			}else{
				$this->model->getInsertTable($arr_reg, "ui_teso_trans_int_reg");
			}
		}
		return response()->json([
			'status' => 'ok',
			'message' => 'Datos guardados correctamente'
		]);
	}
	public function savete(Request $request)
	{
		$data = [
				'type' 					  => $request['type'],
				'idanio_module' 		  => $request['idam'], 
				'iddep_gen' 		 	  => $request['iddep_gen'], 
				'iddep_aux' 	  		  => $request['iddep_aux'],
				'idproyecto' 			  => $request['idproyecto'],
				'iddep_gen_ext' 		  => $request['iddep_gen_ext'], 
				'iddep_aux_ext' 	      => $request['iddep_aux_ext'],
				'idproyecto_ext' 		  => $request['idproyecto_ext'],
				'justificacion' 		  => mb_strtoupper($this->getUnirTextoSaltosLinea($request['justificacion']), 'UTF-8'),
				'fecha_rg'				  => date('Y-m-d'),
				'hora_rg'				  => date('H:i:s A'),
				'iduser_rg' 			  => Auth::user()->id,
				'std_delete' 			  => 1
				];
		$id = $this->model->getInsertTable($data, "ui_teso_trans_int");
		
		for ($i=0; $i < count($request['d_ff']); $i++) { 
			$arr_reg[] = ['idteso_trans_int' 	=> $id, 
					'idteso_ff_n3' 			=> $request['d_ff'][$i],
					'd_idteso_partidas_esp' => $request['d_partida'][$i],
					'd_idmes' 				=> $request['d_mes'][$i],
					'importe' 				=> $this->getClearNumber($request['d_importe'][$i]),
					'a_idteso_partidas_esp' => $request['a_partida'][$i],
					'a_idmes' 				=> $request['a_mes'][$i]
					];
		}
		$this->model->getInsertTableData($arr_reg, "ui_teso_trans_int_reg");
		return response()->json([
			'status' => 'ok',
			'message' => 'Datos guardados correctamente'
		]);
	}
	public function search(Request $request)
	{
		$params = $request->params;
		return response()->json([
			'status' => 'ok',
			'data' => $this->getRowsRegistros($params['idam'])
		]);
	}
	public function autorizar(Request $request)
	{
		$this->model->getUpdateTable(['std_delete' => $request->numero],'ui_teso_trans_int','idteso_trans_int', $request->id);
		if($request->numero == 2){
			$message = "Traspaso AUTORIZADO correctamente.";
		}else if($request->numero == 3){
			$message = "Traspaso CANCELADO correctamente.";
		}
		return response()->json([
			'status' => 'ok',
			'message' => $message
		]);
	}
	private function getRowsRegistros($idam){
		$data = [];
		foreach ($this->model->getSearch($idam) as $v) {
			$data[] = ['id' 			=> $v->id, 
						'type' 			=> $v->type,
						'fecha_rg' 		=> $v->fecha_rg,
						'hora_rg' 		=> $v->hora_rg,
						'std_delete' 	=> $v->std_delete,
						'no_dep_gen' 	=> $v->no_dep_gen,
						'dep_gen' 		=> $v->dep_gen,
						'no_dep_aux' 	=> $v->no_dep_aux,
						'dep_aux' 		=> $v->dep_aux,
						'no_proyecto' 	=> $v->no_proyecto,
						'proyecto' 		=> $v->proyecto,
						'justificacion' => $v->justificacion,
						'number' 		=> $v->number,
						'pdfnota' 		=> $v->number_nota,
						'pdfrec' 		=> $v->number_rec,
						'importe' 		=> number_format($v->importe, 2)
					];
		}
		return $data;
	}
}