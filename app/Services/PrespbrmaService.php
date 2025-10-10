<?php

namespace App\Services;
use App\Models\Presupuestopbrma;
use App\Models\Sximo;

class PrespbrmaService
{
    public function getInfoPbrma($id){
		$proy = Presupuestopbrma::getPbrmaNew($id);
        $row = $proy[0];
        $data = [
			"header"		=> [
                                    "anio"  		=> $row->anio,
                                    "no_institucion" => $row->no_institucion,
                                    "institucion"    => $row->institucion,
									"no_programa"   => $row->no_programa,
									"programa" 	    => $row->programa,
									"no_dep_gen" 	=> $row->no_dep_gen,
									"dep_gen" 	    => $row->dep_gen,
									'row'           => $this->getTitularesLogosFormatos($row->idi, $row->idanio),
									't_dep_gen'     => $row->t_dep_gen,
									'c_dep_gen'     => $row->c_dep_gen
								],
            "id"		    => [
									"idi"   => $row->idi,
									"idp"   => $row->idprograma,
									"ida"   => $row->idarea,
									"idy"   => $row->idanio,
								],
			"presupuesto" => $row->total,
			"rowsRegistros" => self::getRowsPbrmaRegPDF($id)
		];
		return $data;
    }
	public function getInfoPbrmc($id){
		$proy = Presupuestopbrma::getPbrmcNew($id);
        $row = $proy[0];
        $data = [
			"header"		=> [
                                    "anio"  		=> $row->anio,
                                    "no_institucion" => $row->no_institucion,
                                    "institucion"    => $row->institucion,
									"no_programa"   => $row->no_programa,
									"programa" 	    => $row->programa,
									"no_proyecto" 	=> $row->no_proyecto,
									"proyecto" 	    => $row->proyecto,
									"obj_proyecto" 	=> $row->obj_proyecto,
									"no_dep_gen" 	=> $row->no_dep_gen,
									"dep_gen" 	    => $row->dep_gen,
									"no_dep_aux" 	=> $row->no_dep_aux,
									"dep_aux" 	    => $row->dep_aux,
									'row'           => $this->getTitularesLogosFormatos($row->idi, $row->idanio),
									't_dep_gen'     => $row->t_dep_gen,
									'c_dep_gen'     => $row->c_dep_gen
								],
            "id"		    => [
									"idi"   => $row->idi,
								],
			"presupuesto" => $row->total,
			"rowsRegistros" => Presupuestopbrma::getPbrmcNewReg($id)
		];
		return $data;
    }
	public function getInfoPbrmaa($id){
		$proy = Presupuestopbrma::getPbrmcNew($id);
        $row = $proy[0];
        $data = [
			"header"		=> [
                                    "anio"  		=> $row->anio,
                                    "no_institucion"  => $row->no_institucion,
                                    "institucion"     => $row->institucion,
									"no_programa"   => $row->no_programa,
									"programa" 	    => $row->programa,
									"no_proyecto" 	=> $row->no_proyecto,
									"proyecto" 	    => $row->proyecto,
									"obj_proyecto" 	=> $row->obj_proyecto,
									"no_dep_gen" 	=> $row->no_dep_gen,
									"dep_gen" 	    => $row->dep_gen,
									"no_dep_aux" 	=> $row->no_dep_aux,
									"dep_aux" 	    => $row->dep_aux,
									'row'           => $this->getTitularesLogosFormatos($row->idi, $row->idanio),
									't_dep_gen'     => $row->t_dep_gen,
									'c_dep_gen'     => $row->c_dep_gen
								],
            "id"		    => [
									"idi"   => $row->idi,
								],
			"presupuesto" => $row->total,
			"rowsRegistros" => Presupuestopbrma::getPbrmcNewMetas($id)
		];
		return $data;
    }
    private function getRowsPbrmaRegPDF($id){
        $data = [];
        foreach (Presupuestopbrma::getProyectosPbrmaNew($id) as $v) {
           $data[] = ['no_dep_aux'  => $v->no_dep_aux, 
                        'dep_aux'       => $v->dep_aux,
                        'no_proyecto'   => $v->no_proyecto,
                        'proyecto'      => $v->proyecto,
                        'presupuesto'   => $v->presupuesto,
                        'id'            => ['id' => $v->id, 'idp' => $v->idproyecto, 'idac' => $v->idarea_coordinacion]
                    ];
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