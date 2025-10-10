<?php

namespace App\Services;
use App\Models\Presupuestopbrme;
use App\Models\Sximo;

class PrespbrmeService
{
    public function getInfoPbrme($decoder){
		$proy = Presupuestopbrme::getPbrme($decoder['id']);
        $row = $proy[0];
        $data = [
			"header"		=> [
                                    "year"  		=> $row->anio,
                                    "no_institucion" => $row->no_institucion,
                                    "institucion"    => $row->institucion,
									"no_programa"   => $row->no_programa,
									"programa" 	    => $row->programa,
									"obj_programa" 	=> $row->objetivo,
									"no_dep_gen" 	=> $row->no_dep_gen,
									"dep_gen" 	    => $row->dep_gen,
									"idi" 	    	=> $row->idi,
									"tema" 	    	=> $row->tema,
									"pilar" 	    => $row->pilar,
									'row'           => $this->getTitularesLogosFormatos($row->idi, $row->idanio),
									't_dep_gen'     => $row->t_dep_gen,
									'c_dep_gen'     => $row->c_dep_gen
								],
			"rowsRegistros" => $this->getRowsRegPbrme($decoder['id'])
		];
		return $data;
    }
	private function getRowsRegPbrme($id){
		$data = [];
		foreach (Presupuestopbrme::getPbrmeReg($id) as $v) {
			$data[$v->tipo][] = ['id' 			=> $v->id, 
								'descripcion' 	=> $v->descripcion, 
								'nombre' 		=> $v->nombre, 
								'formula' 		=> $v->formula, 
								'idf' 			=> $v->idf, 
								'idt' 			=> $v->idt, 
								'frecuencia' 	=> $v->frecuencia, 
								'tipo_indicador'=> $v->tipo_indicador, 
								'medios' 		=> $v->medios, 
								'supuestos' 	=> $v->supuestos];
		}
		return $data;
	}
	private function getTitularesLogosFormatos($idi, $idy){
        $data = ['t_uippe'      => '',
                'c_uippe'       => '',
                't_tesoreria'   => '',
                'c_tesoreria'   => '',
                'leyenda'       => '',
                'logo_izq'      => null,
                'logo_der'      => null,
                ];
        $row = Sximo::getTitularesFirmas($idi, $idy);
        if(count($row) > 0){
            $data = ['t_uippe'  => $row[0]->t_uippe,
                'c_uippe'       => $row[0]->c_uippe,
                't_tesoreria'   => $row[0]->t_tesoreria,
                'c_tesoreria'   => $row[0]->c_tesoreria,
                'leyenda'       => $row[0]->leyenda,
                'logo_izq'      => 'mass/images/logos/101/'. $row[0]->logo_izq,
                'logo_der'      => 'mass/images/logos/101/'.$row[0]->logo_der,
                ];
        }
        return $data;
    }
}