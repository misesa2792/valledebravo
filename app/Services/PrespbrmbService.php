<?php

namespace App\Services;
use App\Models\Presupuestopbrmb;

class PrespbrmbService
{
    public function getInfoPbrmb($decoder){
		$proy = Presupuestopbrmb::getPbrmb($decoder['id']);
        $row = $proy[0];
        $data = [
			"header"		=> [
									"logo_izq"      => $row->logo_izq,
                                    "anio"  		=> $row->anio,
                                    "no_institucion" => $row->no_institucion,
                                    "institucion"    => $row->institucion,
									"no_programa"   => $row->no_programa,
									"programa" 	    => $row->programa,
									"no_dep_gen" 	=> $row->no_dep_gen,
									"dep_gen" 	    => $row->dep_gen,
									"idi" 	    	=> $row->idi
								],
            "footer"		=> [
									"titular_dep_gen"   => $row->titular_dep_gen,
									"titular_uippe"     => $row->titular_uippe,
									"titular_tesoreria" => $row->titular_tesoreria
								],
			"body"		=> [
									"op"  => $row->objetivo_programa,
									"eo"  => $row->estrategias_objetivo,
									"pdm" => $row->pdm,
									"ods" => $row->ods
								],
			"rowsRegistros" => $this->getRowsRegFODA($decoder['id'])
		];
		return $data;
    }
	private function getRowsRegFODA($id){
		$data = [];
		foreach (Presupuestopbrmb::getPbrmbFodaType($id) as $v) {
			$arr = $v->foda;
			$data[$v->type][] = $arr;
		}
		return $data;
	}
   
}