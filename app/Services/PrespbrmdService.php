<?php

namespace App\Services;
use App\Models\Presupuestopbrmd;
use App\Http\Controllers\controller;

class PrespbrmdService extends Controller
{
    public function getInfoPbrmd($decoder){
		$proy = Presupuestopbrmd::getPbrmdNew($decoder['id']);
        $row = $proy[0];

		$data = [
			"header" => ["no_pilar" 	=> $row->no_pilar, 
						"pilar" 		=> $row->pilar,
						"tema" 			=> $row->tema,
						"no_proyecto" 	=> $row->no_proyecto,
						"no_programa" 	=> $row->no_programa,
						"programa" 		=> $row->programa,
						"obj_programa" 	=> $row->obj_programa,
						"year" 			=> $row->anio,
						"logo_izq" 		=> $row->logo_izq,
						"no_dep_gen" 	=> $row->no_dep_gen,
						"dep_gen" 		=> $row->dep_gen,
						"no_dep_aux" 	=> $row->no_dep_aux,
						"dep_aux" 		=> $row->dep_aux,
						"idi"			=> $row->idi,
						"no_institucion"=> $row->no_institucion
					],
			"indicador" => ["mir" 			=> $row->mir, 
						"nombre" 			=> $row->nombre_indicador,
						"formula" 			=> $row->formula,
						"interpretacion" 	=> $row->interpretacion,
						"dimension" 		=> $row->dimencion,
						"frecuencia" 		=> $row->frecuencia,
						"tipo_indicador" 	=> $row->tipo,
						"factor" => ["nombre" => $row->factor,
									 "descripcion" => $row->desc_factor
									],
						"linea" => $row->linea,
						"porcentaje" => [
											"trim1" => $row->porc1,
											"trim2" => $row->porc2,
											"trim3" => $row->porc3,
											"trim4" => $row->porc4,
											"anual" => $row->porc_anual
										]
					],
			"metas" => ["des" => $row->descripcion_meta, 
						"ver" => $row->medios_verificacion,
						"act" => $row->metas_actividad,
					],
			"registros"	=> $this->getRowsRegistrosPbrmd($row->id),
			"footer" => [
						"titular_dep_gen" => $row->titular_dep_gen
					]
			];
		return $data;
    }
	private function getRowsRegistrosPbrmd($id){
		$data = [];
		foreach (Presupuestopbrmd::getProyectosPbrmd($id) as $v) {
			$data[] = ['id'  => $v->indicador, 
						'um' => $v->unidad_medida, 
						'to' => $v->tipo_operacion,
						't1' => $this->getControllerMassDecimales($v->trim1),
						't2' => $this->getControllerMassDecimales($v->trim2),
						't3' => $this->getControllerMassDecimales($v->trim3),
						't4' => $this->getControllerMassDecimales($v->trim4),
						'ta' => $this->getControllerMassDecimales($v->anual)
					];
		}
		return $data;
	}
}