<?php
namespace App\Services;
use App\Http\Controllers\controller;
use App\Models\Reporte;
use App\Models\Sximo;
use SiteHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Poa\Poa;
use App\Traits\JsonResponds;

class MetasService extends Controller
{
    use JsonResponds;
	protected $data;	

    public function viewFormatoReconduccion($decoder, $request){
        $row = Reporte::getInfoReporteReconduccion($decoder['id']);
        $info = $row[0];
		$mes = $request['trim'] * 3;//Esto es para que me de 3,6,9,12 los meses del trimestre y sacar la fecha
		$rowsMetas = Reporte::getReportesProyectos($decoder['id']);
		//Armado del JSON
		$json = ['header' => ['idi'             => $info->idi,
                            'no_institucion'    => $info->no_institucion,
                            'institucion'       => strtoupper($info->institucion),
                            'row'               => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                            't_dep_gen'         => $info->t_dep_gen,
                            'c_dep_gen'         => $info->c_dep_gen
                        ],
            'trimestre' => ['numero' => $request['trim']],
            'year' => $info->anio,
            'fecha' => cal_days_in_month(CAL_GREGORIAN,$mes, $info->anio) ." de ".ucfirst(strtolower($this->getDataMeses($mes)))." de ".$info->anio,
            'proyecto' => [
                'no_dep_gen'    => $info->no_dep_gen,
                'dep_gen'       => $info->dep_gen,
                'no_dep_aux'    => $info->no_dep_aux,
                'dep_aux'       => $info->dep_aux,
                'no_programa'   => $info->no_programa,
                'programa'      => $info->programa,
                'obj_programa'  => $info->obj_programa,
                'no_proyecto'   => $info->no_proyecto,
                'proyecto'      => $info->proyecto
            ],
            'metas' => $this->getTrimestreMetas($rowsMetas, $request['trim'])
        ];
        return $json;
    }
    public function viewFormatoJustificacion($decoder, $request){
        $row = Reporte::getInfoReporteReconduccion($decoder['id']);
        $info = $row[0];
		$trimeste = 'oficio'.$request['trim'];
		$mes = $request['trim'] * 3;//Esto es para que me de 3,6,9,12 los meses del trimestre y sacar la fecha
		$rowsMetas = Reporte::getReportesProyectos($decoder['id']);
        $justificaciones = $this->getTrimestreMetas($rowsMetas, $request['trim']);
        //Armado del JSON
		$json = ['header' => ['idi'                 => $info->idi,
								'municipio'         => $info->municipio,
								'no_institucion'    => $info->no_institucion,
								'institucion'       => strtoupper($info->institucion),
                				'folio'             => $info->$trimeste,
                                'row'               => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                                't_dep_gen'         => $info->t_dep_gen,
                                'c_dep_gen'         => $info->c_dep_gen
                            ],
            'trimestre' => ['numero' => $request['trim']],
            'year' => $info->anio,
            'type' => $info->type,
            'fecha' => cal_days_in_month(CAL_GREGORIAN,$mes, $info->anio) ." de ".ucfirst(strtolower($this->getDataMeses($mes)))." de ".$info->anio,
            'proyecto' => [
                'no_programa'   => $info->no_programa,
                'programa'      => $info->programa,
                'no_proyecto'   => $info->no_proyecto,
                'proyecto'      => $info->proyecto,
                'no_dep_gen'    => $info->no_dep_gen,
                'dep_gen'       => $info->dep_gen,
				'folio'         => $request['no']
            ],
            'metas' => array_merge($justificaciones['arr_reduce'], $justificaciones['arr_amplia'])
        ];
        return $json;
    }
    public function viewFormatoDictamen($decoder, $request){
        $row = Reporte::getReporteDictamenInfo($decoder['idac']);
        $info = $row[0];
		$mes = $request['trim'] * 3;//Esto es para que me de 3,6,9,12 los meses del trimestre y sacar la fecha
        //Armado del JSON
		$json = ['header' => ['idi'             => $info->idi,
                                'no_institucion'    => $info->no_institucion,
                                'institucion'       => $info->institucion,
                                'no_dep_gen'        => $info->no_dep_gen,
                                'row'               => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                                't_dep_gen'         => $info->t_dep_gen,
                                'c_dep_gen'         => $info->c_dep_gen
                            ],
            'trimestre' => ['numero' => $request['trim']],
            'year' => $info->anio,
            'idanio' => $info->idanio,
            'type' => $decoder['type'],
            'fecha' => ucfirst(strtolower($info->municipio)).", México a,".cal_days_in_month(CAL_GREGORIAN,$mes, $info->anio) ." de ".ucfirst(strtolower($this->getDataMeses($mes)))." de ".$info->anio,
            'projects' => $this->projectsDictamen($decoder['idac'], $info->idanio, $decoder['type'], $request['trim'])
        ];
        return $json;
    }
    public function viewFormatoOchoc($decoder, $request){
        $row = Reporte::getInfoReporteReconduccion($decoder['id']);
        $info = $row[0];
		$rowsMetas = Reporte::getReportesProyectos($decoder['id']);
        //Armado del JSON
		$json = ['header' => ['idi'             => $info->idi,
                            'municipio'         => $info->municipio,
                            'no_institucion'    => $info->no_institucion,
                            'institucion'       => strtoupper($info->institucion),
                        ],
            'trimestre' => ['numero' => $request['trim'], 
                            'nombre' => $this->getDataTrimestre($request['trim'])
                            ],
            'year' => $info->anio,
            'proyecto' => [
                'no_programa'   => $info->no_programa,
                'programa'      => $info->programa,
                'no_proyecto'   => $info->no_proyecto,
                'proyecto'      => $info->proyecto,
                'no_dep_gen'    => $info->no_dep_gen,
                'dep_gen'       => $info->dep_gen,
                'no_dep_aux'    => $info->no_dep_aux,
                'dep_aux'       => $info->dep_aux,
                'pres'          => ($info->presupuesto != "" ? number_format($info->presupuesto, 2) : $info->presupuesto)
            ],
            'footer' => [
                'row' => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                't_dep_gen' => $info->t_dep_gen,
                'c_dep_gen' => $info->c_dep_gen
            ],
            'metas' => $this->rowsMetasOchoc($rowsMetas, $request['trim'])
        ];
        return $json;
    }
    public function viewFormatoOchob($request){
		$idi = \Auth::user()->idinstituciones;
        $json = [];
        $aplica = 'aplica'.$request['trim'];
        $header = $this->viewInfoAnioModule($request['idy'], $request['trim']);
        foreach (Reporte::getInfoReporteMIRAll($request['idy'], $request['trim'], $idi) as $info) {
            $json[] = ['footer' => [
                                    't_dep_gen' => $info->t_dep_gen,
                                    'c_dep_gen' => $info->c_dep_gen
                                ],
                        'proyecto' => [
                                    'no_pilar'      => $info->no_pilar,
                                    'pilar'         => $info->pilar,
                                    'tema'          => $info->tema_desarrollo,
                                    'no_programa'   => $info->no_programa,
                                    'programa'      => $info->programa,
                                    'no_proyecto'   => $info->no_proyecto,
                                    'proyecto'      => $info->proyecto,
                                    'obj_programa'  => $info->obj_programa,
                                    'no_dep_gen'    => $info->no_dep_gen,
                                    'dep_gen'       => $info->dep_gen,
                                    'no_dep_aux'    => $info->no_dep_aux,
                                    'dep_aux'       => $info->dep_aux
                                ],
                        'indicador' => [
                                        'nom'   => $info->nombre_indicador,
                                        'for'   => $info->formula,
                                        'int'   => $info->interpretacion,
                                        'dim'   => $info->dimension_atiende,
                                        'fre'   => $info->frecuencia,
                                        'fac'   => $info->factor,
                                        'des'   => $info->desc_factor,
                                        'lin'   => $info->linea,
                                        'mir'   => $info->mir,
                                        'aplica' => $info->$aplica == 2 ? 'No Aplica' : '',
                                        'ambito' => $info->ambito,
                                        'cobertura' => $info->cobertura
                                    ],
                        'variables' => $this->getVariablesMIR($info->id, $request['trim']),
                        'evaluacion' => [
                                        'meta_anual'        => $info->meta_anual, 
                                        'programado'        => $info->programado, 
                                        'alcanzado'         => $info->alcanzado, 
                                        'ef'                => $info->ef,
                                        'a_programado'      => $info->a_programado,
                                        'a_alcanzado'       => $info->a_alcanzado,
                                        'a_ef'              => $info->a_ef,
                                        'desc_res'          => $info->desc_res,
                                        'desc_meta'         => $info->desc_meta,
                                        'evaluacion'        => $info->evaluacion,
                                        'semaforo'          => $info->semaforo
                                    ]

                    ];
        }
        $response = ['data' => $header,
                    'info' => $json];
        return $response;
    }
    private function viewInfoAnioModule($idy,$trim){
		$idi = \Auth::user()->idinstituciones;
        $trim_name = $this->getDataTrimestre($trim);
        $row = Reporte::getInfoInstitucion($idy);
        $info = $row[0];
        $year = Reporte::getInfoYear($idy);
        $data = ['header' => ['idi'             => $idi,
                            'municipio'         => $info->municipio,
                            'no_institucion'    => $info->no_institucion,
                            'row' => $this->getTitularesLogosFormatos($idi, $idy)
                        
                ],
            'trimestre' => ['numero' => $trim, 
                            'nombre' => $trim_name
                            ],
            'year' => $year[0]->anio
       ];
       return $data;
    }
    public function viewFormatoOchobEvaluacion($request){
        $row = Reporte::getInfoReporteMIREvaluacion($request['id']);
        $info = $row[0];
        if($info->status == 1){
            $json = $this->viewOchob($info);
        }else{
            $json = $this->viewOchobEvaluacion($info);
        }
       return $json;
    }
    private function viewOchobEvaluacion($info){
        $indicadores = $this->getVariablesMIR($info->idreporte_mir,$info->trim);
        $formula = $this->getAplicarFormula($indicadores, $info->idmir_formula);
        $texto = $this->rowsTextoMIR($indicadores);
        $aplica = 'aplica'.$info->trim;
        $json = ['status' => $info->status,
                    'header' => [
                                'idi'             => $info->idi,
                                'municipio'       => $info->municipio,
                                'no_institucion'  => $info->no_institucion,
                                'row'             => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                                't_dep_gen'       => $info->t_dep_gen,
                                'c_dep_gen'       => $info->c_dep_gen
                            ],
                    'trimestre' => [
                                    'numero' => $info->trim, 
                                    'nombre' => $this->getDataTrimestre($info->trim)
                                ],
                    'year' => $info->anio,
                    'proyecto' => [
                                    'no_pilar'      => $info->no_pilar,
                                    'pilar'         => $info->pilar,
                                    'tema'          => $info->tema_desarrollo,
                                    'no_programa'   => $info->no_programa,
                                    'programa'      => $info->programa,
                                    'no_proyecto'   => $info->no_proyecto,
                                    'proyecto'      => $info->proyecto,
                                    'obj_programa'  => $info->obj_programa,
                                    'no_dep_gen'    => $info->no_dep_gen,
                                    'dep_gen'       => $info->dep_gen,
                                    'no_dep_aux'    => $info->no_dep_aux,
                                    'dep_aux'       => $info->dep_aux
                                ],
                    'indicador' => [
                                    'nom'   => $info->nombre_indicador,
                                    'for'   => $info->formula,
                                    'int'   => $info->interpretacion,
                                    'dim'   => $info->dimension_atiende,
                                    'fre'   => $info->frecuencia,
                                    'fac'   => $info->factor,
                                    'des'   => $info->desc_factor,
                                    'lin'   => $info->linea,
                                    'mir'   => $info->mir,
                                    'aplica' => ($info->$aplica == 2 ? 'No Aplica' : ''),
                                    'ambito' => $info->ambito,
                                    'cobertura' => $info->cobertura
                                ],
                    'indicadores' => $indicadores,
                    'metas' => [
                                'meta_anual'        => $formula['meta_anual'], 
                                'programado'        => $formula['programado'], 
                                'alcanzado'         => $formula['alcanzado'], 
                                'ef'                => $formula['ef'],
                                'a_programado'      => $formula['a_programado'],
                                'a_alcanzado'       => $formula['a_alcanzado'],
                                'a_ef'              => $formula['a_ef'],
                                'ids'               => $formula['ids'],
                                'desc_meta'         => $info->descripcion_meta,
                                'desc_res'          => $texto['res'],
                                'evaluacion'        => $texto['eva']
                            ],
                    'rowsSemaforos' => Reporte::getMIRSemaforo()
                    ];
        return $json;
    }
    private function viewOchob($info){
        $aplica = 'aplica'.$info->trim;
        $json = ['status' => $info->status,
                    'header' => [
                                'idi'             => $info->idi,
                                'municipio'       => $info->municipio,
                                'no_institucion'  => $info->no_institucion,
                                'row'             => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                                't_dep_gen'       => $info->t_dep_gen,
                                'c_dep_gen'       => $info->c_dep_gen
                            ],
                    'trimestre' => [
                                    'numero' => $info->trim, 
                                    'nombre' => $this->getDataTrimestre($info->trim)
                                ],
                    'year' => $info->anio,
                    'proyecto' => [
                                    'no_pilar'      => $info->no_pilar,
                                    'pilar'         => $info->pilar,
                                    'tema'          => $info->tema_desarrollo,
                                    'no_programa'   => $info->no_programa,
                                    'programa'      => $info->programa,
                                    'no_proyecto'   => $info->no_proyecto,
                                    'proyecto'      => $info->proyecto,
                                    'obj_programa'  => $info->obj_programa,
                                    'no_dep_gen'    => $info->no_dep_gen,
                                    'dep_gen'       => $info->dep_gen,
                                    'no_dep_aux'    => $info->no_dep_aux,
                                    'dep_aux'       => $info->dep_aux
                                ],
                    'indicador' => [
                                    'nom'   => $info->nombre_indicador,
                                    'for'   => $info->formula,
                                    'int'   => $info->interpretacion,
                                    'dim'   => $info->dimension_atiende,
                                    'fre'   => $info->frecuencia,
                                    'fac'   => $info->factor,
                                    'des'   => $info->desc_factor,
                                    'lin'   => $info->linea,
                                    'mir'   => $info->mir,
                                    'aplica' => ($info->$aplica == 2 ? 'No Aplica' : ''),
                                    'ambito' => $info->ambito,
                                    'cobertura' => $info->cobertura
                                ],
                    'indicadores' => $this->getVariablesMIR($info->idreporte_mir,$info->trim),
                    'metas' => [
                                'meta_anual'        => $info->meta_anual, 
                                'programado'        => $info->programado, 
                                'alcanzado'         => $info->alcanzado, 
                                'ef'                => $info->ef,
                                'a_programado'      => $info->a_programado,
                                'a_alcanzado'       => $info->a_alcanzado,
                                'a_ef'              => $info->a_ef,
                                'desc_res'          => $info->desc_res,
                                'desc_meta'         => $info->desc_meta,
                                'evaluacion'        => $info->evaluacion,
                                'semaforo'          => $info->semaforo
                            ]
                    ];
        return $json;
    }
    private function rowsTextoMIR($data){
        if($data[0]['cant_pje'] > 110 || $data[1]['cant_pje'] > 110){
            $resultado = 'Se obtiene un resultado por arriba de la meta programada. Se reconduce';
            $evaluacion = 'Se recomienda a la unidad responsable implementar las estrategias pertinentes que permitan mejorar los procesos de planeación y programación.';
        }else if($data[0]['cant_pje'] <= 89.99 || $data[1]['cant_pje'] <= 89.99){
            $resultado = 'Se obtiene un resultado a la baja de la meta programada. Se reconduce';
            $evaluacion = 'Se recomienda a la unidad responsable implementar las estrategias pertinentes que permitan mejorar los procesos de planeación y programación.';
        }else{
            $resultado = 'Se mantiene un resultado dentro de lo programado.';
            $evaluacion = 'Se recomienda a la unidad responsable continuar con las estrategias establecidas que permitan obtener un buen desempeño con relación a los procesos de planeación y programación.';
        }
        return ['res' => $resultado, 'eva' => $evaluacion];
    }
    private function getVariablesMIR($id,$trim){
        $data = [];
        $amplia = $reduce = [];
        foreach (Reporte::getReporteRegMIR($id) as $v) {
            $row = $this->getReporteRegMIRCantidades($v->id);
            $aux_prog = 'trim_'.$trim;
            $aux_cant = 'c'.$trim;
            $programado = $v->$aux_prog;
            $cantidad = $row[$aux_cant];
            //Acumulado
            if($trim == 1){
                $sum_trim = $v->trim_1;
                $sum_cant = $row['c1'];
            }else if($trim == 2){
                $sum_trim = ($v->trim_1 + $v->trim_2);
                $sum_cant = ($row['c1'] + $row['c2']);
            }else if($trim == 3){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3);
                $sum_cant = ($row['c1'] + $row['c2'] + $row['c3']);
            }else if($trim == 4){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3 + $v->trim_4);
                $sum_cant = ($row['c1'] + $row['c2'] + $row['c3'] + $row['c4']);
            }
            $data[] = ['ind'         => $v->indicador, 
                        'um'         => $v->unidad_medida,
                        'to'         => $v->tipo_operacion,
                        'anual'      => $v->prog_anual,
                        'prog'       => $programado,
                        'cant'       => $cantidad,
                        'prog_pje'   => $this->getDataPorcentaje($v->prog_anual, $programado),
                        'cant_pje'   => $this->getDataPorcentaje($programado, $cantidad),
                        'a_prog'     => $sum_trim,
                        'a_cant'     => $sum_cant,
                        'a_prog_pje' => $this->getDataPorcentaje($v->prog_anual, $sum_trim),
                        'a_cant_pje' => $this->getDataPorcentaje($sum_trim, $sum_cant)
                    ];
        }
        return $data;
    }
    private function getAplicarFormula($row,$idformula){
        $data = [];
        $anual = $prog = $cant = $cant_pje = 0;
        $a_prog = $a_cant = $a_cant_pje = 0;
        if(count($row) == 2){
            if($idformula == 1 || $idformula == 4 || $idformula == 5){
                $multi = 100;
                if($idformula == 4){
                    $multi = 1000;
                }elseif($idformula == 5){
                    $multi = 10000;
                }
                $anual = $this->getFormula1($row[0]['anual'], $row[1]['anual'],$multi);
                $prog = $this->getFormula1($row[0]['prog'], $row[1]['prog'],$multi);
                $cant = $this->getFormula1($row[0]['cant'], $row[1]['cant'],$multi);
                $cant_pje = $this->getFormula1($row[0]['cant_pje'], $row[1]['cant_pje'],$multi);
                //Acumulado Trimestral
                $a_prog = $this->getFormula1($row[0]['a_prog'], $row[1]['a_prog'], $multi);
                $a_cant = $this->getFormula1($row[0]['a_cant'], $row[1]['a_cant'], $multi);
                $a_cant_pje = $this->getFormula1($row[0]['a_cant_pje'], $row[1]['a_cant_pje'], $multi);
            }else if($idformula == 2){//((A/B)-1) *100
                $multi = 100;
                $anual = $this->getFormula2($row[0]['anual'], $row[1]['anual'], $multi);
                $prog = $this->getFormula2($row[0]['prog'], $row[1]['prog'], $multi);
                $cant = $this->getFormula2($row[0]['cant'], $row[1]['cant'], $multi);
                $cant_pje = $this->getFormula2($row[0]['cant_pje'], $row[1]['cant_pje'], $multi);
                //Acumulado Trimestral
                $a_prog = $this->getFormula2($row[0]['a_prog'], $row[1]['a_prog'], $multi);
                $a_cant = $this->getFormula2($row[0]['a_cant'], $row[1]['a_cant'], $multi);
                $a_cant_pje = $this->getFormula2($row[0]['a_cant_pje'], $row[1]['a_cant_pje'], $multi);
            }else if($idformula == 3){//(A/B)
                $anual = $this->getFormula3($row[0]['anual'], $row[1]['anual']);
                $prog = $this->getFormula3($row[0]['prog'], $row[1]['prog']);
                $cant = $this->getFormula3($row[0]['cant'], $row[1]['cant']);
                $cant_pje = $this->getDataPorcentaje($prog, $cant);
                //Acumulado Trimestral
                $a_prog = $this->getFormula3($row[0]['a_prog'], $row[1]['a_prog']);
                $a_cant = $this->getFormula3($row[0]['a_cant'], $row[1]['a_cant']);
                $a_cant_pje =$this->getDataPorcentaje($a_prog, $a_cant);
            }
        }
        return ['meta_anual'        => $this->getNumberFormat($anual), 
                'programado'        => $this->getNumberFormat($prog), 
                'alcanzado'         => $this->getNumberFormat($cant), 
                'ef'                => $this->getNumberFormat($cant_pje),
                'ids'               => 1,
                'a_programado'      => $this->getNumberFormat($a_prog),
                'a_alcanzado'       => $this->getNumberFormat($a_cant),
                'a_ef'              => $this->getNumberFormat($a_cant_pje),
            ];
    }
    private function getFormula1($a,$b,$multi){
        if($b == 0){ return $b; }
        //if($a == 0 && $b > 0){ return 100; }//Esto es para que salga el 100%
        $result = ($a/$b)*$multi;
        $result = $this->getDataFloorDosDecimales($result);
        return $result;
    }
    private function getFormula2($a,$b,$multi){
        if($b == 0){ return $b; }
        $result = (($a/$b)-1) * $multi;
        $result = $this->getDataFloorDosDecimales($result);
        return $result;
    }
    private function getFormula3($a,$b){
        if($b == 0){ return $b; }
        $result = ($a/$b);
        $result = $this->getDataFloorDosDecimales($result);
        return $result;
    }
    private function getColocarDobleCero($c){
        return ($c == '0' ? '0.00' : $c);
    }
    private function getReporteRegMIRCantidades($id){
        $data = ['c1' => 0, 'c2' => 0 , 'c3' => 0, 'c4' => 0];
        $row = Reporte::getReporteRegMIRCant($id);
        if(count($row) > 0){
            $data = ['c1' => $row[0]->cant1, 'c2' => $row[0]->cant2, 'c3' => $row[0]->cant3, 'c4' => $row[0]->cant4];
        }
        return $data;
    }
    public function viewSeguimientoMetas($request){
		$data = [];
		$j = 1;
        $idi =  \Auth::user()->idinstituciones;
        $type = $request['type'];
        $trim = $request['trim'];
		foreach (Reporte::getReportesProyectosSeguimiento($request['idy'], $type, $idi) as $v) {
           
            if($trim == 1){
                $cant1 = $v->cant_1;
                $cant2 = $v->trim_2;
                $cant3 = $v->trim_3;
                $cant4 = $v->trim_4;

                $por1 = $v->por_1;
                $por2 = 100;
                $por3 = 100;
                $por4 = 100;
            }else if($trim == 2){
                $cant1 = $v->cant_1;
                $cant2 = $v->cant_2;
                $cant3 = $v->trim_3;
                $cant4 = $v->trim_4;

                $por1 = $v->por_1;
                $por2 = $v->por_2;
                $por3 = 100;
                $por4 = 100;
            }else if($trim == 3){
                $cant1 = $v->cant_1;
                $cant2 = $v->cant_2;
                $cant3 = $v->cant_3;
                $cant4 = $v->trim_4;

                $por1 = $v->por_1;
                $por2 = $v->por_2;
                $por3 = $v->por_3;
                $por4 = 100;
            }else if($trim == 4){
                $cant1 = $v->cant_1;
                $cant2 = $v->cant_2;
                $cant3 = $v->cant_3;
                $cant4 = $v->cant_4;

                $por1 = $v->por_1;
                $por2 = $v->por_2;
                $por3 = $v->por_3;
                $por4 = $v->por_4;
            }

			$data[] = array("j"=>$j++,
                    "idrg"          => $v->id,
                    "no_dep_gen"    => $v->no_dep_gen,
                    "dep_gen"       => $v->dep_gen,
                    "no_dep_aux"    => $v->no_dep_aux,
                    "dep_aux"       => $v->dep_aux,
                    "no_proyecto"   => $v->no_proyecto,
                    "proyecto"      => $v->proyecto,
                    "no_a"          => $v->codigo,
                    "meta"          => $v->meta,
                    "um"            => $v->unidad_medida,
                    "pa"            => $v->prog_anual,
                    "mod"           => ($cant1 + $cant2 + $cant3 + $cant4),
                    "t1"=>$this->getQuitarDobleCeros($v->trim_1),
                    "t2"=>$this->getQuitarDobleCeros($v->trim_2),
                    "t3"=>$this->getQuitarDobleCeros($v->trim_3),
                    "t4"=>$this->getQuitarDobleCeros($v->trim_4),
                    "tt1"=>$this->getQuitarDobleCeros($cant1),
                    "tt2"=>$this->getQuitarDobleCeros($cant2),
                    "tt3"=>$this->getQuitarDobleCeros($cant3),
                    "tt4"=>$this->getQuitarDobleCeros($cant4),
                    "std1"=>$this->getEstatusMeta($v->trim_1, $por1, 1, $trim),
                    "std2"=>$this->getEstatusMeta($v->trim_2, $por2, 2, $trim),
                    "std3"=>$this->getEstatusMeta($v->trim_3, $por3, 3, $trim),
                    "std4"=>$this->getEstatusMeta($v->trim_4, $por4, 4, $trim),
                );
		}
		return ['status' => 'ok',
                'rowsData'  => $data, 
				'total'     => count($data)
			];
    }
    private function getEstatusMeta($cant, $por, $no, $trim){
        if($cant > 0 && $por > 110){
            if($no <= $trim){
                return "max";
            }else{
                return "ok";
            }
        }else if($cant > 0 && $por <= 89.99){
            if($no <= $trim){
                return "min";
            }else{
                return "ok";
            }
        }else{
            return "ok";
        }
    }
    public function viewMetasReconduccion($request){
		$data = [];
		$numero = 0;
		$no_aplica = "no_aplica";
        $total1 = $total2 = $total3 = $total4 = 0;
        $t1 = $t2 = $t3 = $t4 = 0;
        $idi =  \Auth::user()->idinstituciones;
        $type = $request['type'];
		foreach (Reporte::getProjectsForYearsFull($request['idy'], $type, $idi) as $v) {
			//Formato reconducción
            $url1 = $url2 = $url3 = $url4 = "empty";

			$rowsMetas = Reporte::getReportesProyectos($v->id);

			$trim1 = $this->getTrimestreMetas($rowsMetas,1); 
            $trim2 = $this->getTrimestreMetas($rowsMetas,2);
            $trim3 = $this->getTrimestreMetas($rowsMetas,3);
            $trim4 = $this->getTrimestreMetas($rowsMetas,4);
			//Totales para sacar los formatos dictamen de reconduccion
			$total1 += $trim1['total'];
            $total2 += $trim2['total'];
            $total3 += $trim3['total'];
            $total4 += $trim4['total'];

			if($trim1['total'] > 0){
				$url1 = 'empty';
			}else{
				$url1 = $no_aplica;
			}

			if($trim2['total'] > 0){
				$url2 = 'empty';
			}else{
				$url2 = $no_aplica;
			}

			if($trim3['total'] > 0){
				$url3 = 'empty';
			}else{
				$url3 = $no_aplica;
			}

			if($trim4['total'] > 0){
				$url4 = 'empty';
			}else{
				$url4 = $no_aplica;
			}
			//PDF Reconduccion
			if($url1 != $no_aplica && !empty($v->rec1)){ $url1 = $v->rec1; $t1++; }
			if($url2 != $no_aplica && !empty($v->rec2)){ $url2 = $v->rec2; $t2++; }
			if($url3 != $no_aplica && !empty($v->rec3)){ $url3 = $v->rec3; $t3++; }
			if($url4 != $no_aplica && !empty($v->rec4)){ $url4 = $v->rec4; $t4++; }

            $numero++;

            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }

			$data[$v->no_dep_gen]['data'][] = ['id' => $v->id,
                                            'no_proyecto' => $v->no_proyecto,
                                            'proyecto' => $v->proyecto, 
                                            'no_dep_aux' => $v->no_dep_aux, 
                                            'dep_aux' => $v->dep_aux, 
                                            'url1' => $url1, 
                                            'url2' => $url2, 
                                            'url3' => $url3, 
                                            'url4' => $url4
                                        ];
		}
		return ['status' => 'ok',
                'rowsData'  => array_values($data), 
                't1'  => $t1, 
                't2'  => $t2, 
                't3'  => $t3, 
                't4'  => $t4, 
				'total'     => count($data)
			];
    }
    public function viewMetas($decoder){
		$data = [];
		$numero = 0;
		$no_aplica = "no_aplica";
        $total1 = $total2 = $total3 = $total4 = 0;
        $idi =  \Auth::user()->idinstituciones;
		foreach (Reporte::getProjectsForYears($decoder['idac'], $decoder['idy'], $decoder['type'], $idi) as $v) {
			//Formato reconducción
            $url1 = $url2 = $url3 = $url4 = "empty";
            $jus1 = $jus2 = $jus3 = $jus4 = "empty";

			$rowsMetas = Reporte::getReportesProyectos($v->id);

			$trim1 = $this->getTrimestreMetas($rowsMetas,1); 
            $trim2 = $this->getTrimestreMetas($rowsMetas,2);
            $trim3 = $this->getTrimestreMetas($rowsMetas,3);
            $trim4 = $this->getTrimestreMetas($rowsMetas,4);
			//Totales para sacar los formatos dictamen de reconduccion
			$total1 += $trim1['total'];
            $total2 += $trim2['total'];
            $total3 += $trim3['total'];
            $total4 += $trim4['total'];

			if($trim1['total'] > 0){
				$url1 = 'empty';
				$jus1 = 'empty';
			}else{
				$url1 = $no_aplica;
				$jus1 = $no_aplica;
			}

			if($trim2['total'] > 0){
				$url2 = 'empty';
				$jus2 = 'empty';
			}else{
				$url2 = $no_aplica;
				$jus2 = $no_aplica;
			}

			if($trim3['total'] > 0){
				$url3 = 'empty';
				$jus3 = 'empty';
			}else{
				$url3 = $no_aplica;
				$jus3 = $no_aplica;
			}

			if($trim4['total'] > 0){
				$url4 = 'empty';
				$jus4 = 'empty';
			}else{
				$url4 = $no_aplica;
				$jus4 = $no_aplica;
			}
			//PDF Reconduccion
			if($url1 != $no_aplica && !empty($v->rec1)){ $url1 = $v->rec1; }
			if($url2 != $no_aplica && !empty($v->rec2)){ $url2 = $v->rec2; }
			if($url3 != $no_aplica && !empty($v->rec3)){ $url3 = $v->rec3; }
			if($url4 != $no_aplica && !empty($v->rec4)){ $url4 = $v->rec4; }
			//PDF Justificación
			if($jus1 != $no_aplica && !empty($v->jus1)){ $jus1 = $v->jus1; }
			if($jus2 != $no_aplica && !empty($v->jus2)){ $jus2 = $v->jus2; }
			if($jus3 != $no_aplica && !empty($v->jus3)){ $jus3 = $v->jus3; }
			if($jus4 != $no_aplica && !empty($v->jus4)){ $jus4 = $v->jus4; }

            $numero++;
			$data[] = ['id' => SiteHelpers::CF_encode_json(['id' => $v->id]),
						'idreporte' => $v->id,
						'numero' => ($numero < 10 ? '0'.$numero : $numero),
						'no_proyecto' => $v->no_proyecto,
						'proyecto' => $v->proyecto, 
						'url1' => $url1, 
						'url2' => $url2, 
						'url3' => $url3, 
						'url4' => $url4,
						'jus1' => $jus1, 
						'jus2' => $jus2, 
						'jus3' => $jus3, 
						'jus4' => $jus4
					];
		}
		//dicatem de reconducción
		$dic1 = ($total1 > 0 ? 'empty' : $no_aplica);
        $dic2 = ($total2 > 0 ? 'empty' : $no_aplica);
        $dic3 = ($total3 > 0 ? 'empty' : $no_aplica);
        $dic4 = ($total4 > 0 ? 'empty' : $no_aplica);
		
		//Primero se valida si la URL contiene información
		$dictamen = Reporte::getReporteDictamenPdf($decoder['idac'], $decoder['type']);
		if(count($dictamen) > 0){
            if($dic1 != $no_aplica && !empty($dictamen[0]->dic1))
                $dic1 = $dictamen[0]->dic1;
            if($dic2 != $no_aplica && !empty($dictamen[0]->dic2))
                $dic2 = $dictamen[0]->dic2;
            if($dic3 != $no_aplica && !empty($dictamen[0]->dic3))
                $dic3 = $dictamen[0]->dic3;
            if($dic4 != $no_aplica && !empty($dictamen[0]->dic4))
                $dic4 = $dictamen[0]->dic4;
        }
		return ['rowsData'  => $data, 
				'total'     => count($data),
				"dic1"      => $dic1,
				"dic2"      => $dic2,
				"dic3"      => $dic3,
				"dic4"      => $dic4,
				'access'    => $this->getRowsAccessPDF($decoder['year'])
			];
    }
    public function viewIndicadoresFull($request){
		$data = [];
		$numero = 0;
		$no_aplica = "no_aplica";
        $total1 = $total2 = $total3 = $total4 = 0;
        $idi =  \Auth::user()->idinstituciones;
		foreach (Reporte::getProjectsForYearsFull($request['idy'], $request['type'], $idi) as $v) {
            $jus1 = $jus2 = $jus3 = $jus4 = "empty";

			$rowsMetas = Reporte::getReportesProyectos($v->id);

			$trim1 = $this->getTrimestreMetas($rowsMetas,1); 
            $trim2 = $this->getTrimestreMetas($rowsMetas,2);
            $trim3 = $this->getTrimestreMetas($rowsMetas,3);
            $trim4 = $this->getTrimestreMetas($rowsMetas,4);
			//Totales para sacar los formatos dictamen de reconduccion
			$total1 += $trim1['total'];
            $total2 += $trim2['total'];
            $total3 += $trim3['total'];
            $total4 += $trim4['total'];

			if($trim1['total'] > 0){
				$url1 = 'empty';
				$jus1 = 'empty';
			}else{
				$url1 = $no_aplica;
				$jus1 = $no_aplica;
			}

			if($trim2['total'] > 0){
				$url2 = 'empty';
				$jus2 = 'empty';
			}else{
				$url2 = $no_aplica;
				$jus2 = $no_aplica;
			}

			if($trim3['total'] > 0){
				$url3 = 'empty';
				$jus3 = 'empty';
			}else{
				$url3 = $no_aplica;
				$jus3 = $no_aplica;
			}

			if($trim4['total'] > 0){
				$url4 = 'empty';
				$jus4 = 'empty';
			}else{
				$url4 = $no_aplica;
				$jus4 = $no_aplica;
			}

            $rowsMetas = Reporte::getReportesProyectosMIR($v->id);
            $indicadores = $this->getGroupByMIRReconduccion($rowsMetas);
			$data[] = ['id'             => $v->id,
						'no_proyecto'   => $v->no_proyecto,
						'proyecto'      => $v->proyecto, 
						'no_dep_gen'    => $v->no_dep_gen, 
						'dep_gen'       => $v->dep_gen, 
						'no_dep_aux'    => $v->no_dep_aux, 
						'dep_aux'       => $v->dep_aux, 
						'indicadores'   => $indicadores['data']
					];
		}
		return ['status' => 'ok',
                'rowsData' => $data, 
				'total' => count($data)
			];
    }
    public function viewIndicadores($decoder){

		$data = [];
		$numero = 0;
		$no_aplica = "no_aplica";
        $total1 = $total2 = $total3 = $total4 = 0;
        $idi =  \Auth::user()->idinstituciones;
		foreach (Reporte::getProjectsForYears($decoder['idac'], $decoder['idy'], $decoder['type'], $idi) as $v) {
            $jus1 = $jus2 = $jus3 = $jus4 = "empty";

			$rowsMetas = Reporte::getReportesProyectos($v->id);

			$trim1 = $this->getTrimestreMetas($rowsMetas,1); 
            $trim2 = $this->getTrimestreMetas($rowsMetas,2);
            $trim3 = $this->getTrimestreMetas($rowsMetas,3);
            $trim4 = $this->getTrimestreMetas($rowsMetas,4);
			//Totales para sacar los formatos dictamen de reconduccion
			$total1 += $trim1['total'];
            $total2 += $trim2['total'];
            $total3 += $trim3['total'];
            $total4 += $trim4['total'];

			if($trim1['total'] > 0){
				$url1 = 'empty';
				$jus1 = 'empty';
			}else{
				$url1 = $no_aplica;
				$jus1 = $no_aplica;
			}

			if($trim2['total'] > 0){
				$url2 = 'empty';
				$jus2 = 'empty';
			}else{
				$url2 = $no_aplica;
				$jus2 = $no_aplica;
			}

			if($trim3['total'] > 0){
				$url3 = 'empty';
				$jus3 = 'empty';
			}else{
				$url3 = $no_aplica;
				$jus3 = $no_aplica;
			}

			if($trim4['total'] > 0){
				$url4 = 'empty';
				$jus4 = 'empty';
			}else{
				$url4 = $no_aplica;
				$jus4 = $no_aplica;
			}
			//PDF Justificación
			if($jus1 != $no_aplica && !empty($v->jus1)){ $jus1 = $v->jus1; }
			if($jus2 != $no_aplica && !empty($v->jus2)){ $jus2 = $v->jus2; }
			if($jus3 != $no_aplica && !empty($v->jus3)){ $jus3 = $v->jus3; }
			if($jus4 != $no_aplica && !empty($v->jus4)){ $jus4 = $v->jus4; }

            $foda1 = (empty($v->foda1) ? 'empty' : $v->foda1);
            $foda2 = (empty($v->foda2) ? 'empty' : $v->foda2);
            $foda3 = (empty($v->foda3) ? 'empty' : $v->foda3);
            $foda4 = (empty($v->foda4) ? 'empty' : $v->foda4);
            $numero++;

            $rowsMetas = Reporte::getReportesProyectosMIR($v->id);
            $indicadores = $this->getGroupByMIRReconduccion($rowsMetas);
			$data[] = ['id' => SiteHelpers::CF_encode_json(['id' => $v->id]),
						'idreporte' => $v->id, 
						'numero' => ($numero < 10 ? '0'.$numero : $numero),
						'no_proyecto' => $v->no_proyecto,
						'proyecto' => $v->proyecto, 
						'jus1' => $jus1, 
						'jus2' => $jus2, 
						'jus3' => $jus3, 
						'jus4' => $jus4,
						'foda1' => $foda1,
						'foda2' => $foda2,
						'foda3' => $foda3,
						'foda4' => $foda4,
						'indicadores' => $indicadores['data']
					];
		}
		//dicatem de reconducción
		$dic1 = ($total1 > 0 ? 'empty' : $no_aplica);
        $dic2 = ($total2 > 0 ? 'empty' : $no_aplica);
        $dic3 = ($total3 > 0 ? 'empty' : $no_aplica);
        $dic4 = ($total4 > 0 ? 'empty' : $no_aplica);
		
		//Primero se valida si la URL contiene información
		$dictamen = Reporte::getReporteDictamenPdf($decoder['idac'], $decoder['type']);
		if(count($dictamen) > 0){
            if($dic1 != $no_aplica && !empty($dictamen[0]->dic1))
                $dic1 = $dictamen[0]->dic1;
            if($dic2 != $no_aplica && !empty($dictamen[0]->dic2))
                $dic2 = $dictamen[0]->dic2;
            if($dic3 != $no_aplica && !empty($dictamen[0]->dic3))
                $dic3 = $dictamen[0]->dic3;
            if($dic4 != $no_aplica && !empty($dictamen[0]->dic4))
                $dic4 = $dictamen[0]->dic4;
        }
		return ['status' => 'ok',
                'rowsData' => $data, 
				'total' => count($data),
				"dic1" => $dic1,
				"dic2" => $dic2,
				"dic3" => $dic3,
				"dic4" => $dic4,
				'access'    => $this->getRowsAccessPDF($decoder['year'])
			];
    }
    private function getValidarRecInd($v,$no_trim){
        $estatus = 0;

        $trim = "trim_".$no_trim;
        $cant = "cant_".$no_trim;
        $por = "por_".$no_trim;
        $obs = "obs_".$no_trim;

        $trimestre = $v->$trim; 
        $cantidad = $v->$cant;
        $porcentaje = $v->$por;
        $observacion = $v->$obs;
        if($trimestre == 0 && $cantidad > 0){
            $estatus = 1;
        }else if($porcentaje > 110){
            $estatus = 1;
        }else if($trimestre > 0 && $cantidad == 0){
            $estatus = 2;
        }else if($trimestre > 0 && $porcentaje <= 89.99){
            $estatus = 2;
        }
        return $estatus;
    }
    private function getGroupByMIRReconduccion($rows ){
        $data = [];
        foreach ($rows as $v) {
            $arr = array(
                      't1' => $this->getValidarRecInd($v,1),
                      't2' => $this->getValidarRecInd($v,2),
                      't3' => $this->getValidarRecInd($v,3),
                      't4' => $this->getValidarRecInd($v,4)
		        );
            if(!isset($data[$v->idreporte_mir])){
                $data[$v->idreporte_mir] = ['id'           => SiteHelpers::CF_encode_json(['id' => $v->idreporte_mir]), 
                                            'mir'           => $v->codigo, 
                                            'ind'           => $v->indicador, 
                                            "fre"           => $v->frecuencia_medicion,
                                            'fla'           => $v->formula, 
                                            'url1'          => $v->rec1, 
                                            'url2'          => $v->rec2, 
                                            'url3'          => $v->rec3, 
                                            'url4'          => $v->rec4, 
                                            'rowsInd'       => [$arr] 
                                            ];
            }else{
                $data[$v->idreporte_mir]['rowsInd'][] = $arr;
            }
        }
        $newData = [];
        $std_rec1 = $std_rec2 = $std_rec3 = $std_rec4 = 1;
        foreach ($data as $v) {
            /*if($v['aplica'] == 2){
                $v['url1'] = 'no_aplica';
                $v['url2'] = 'no_aplica';
                $v['url3'] = 'no_aplica';
                $v['url4'] = 'no_aplica';
            }else{*/
                $rec = $this->rowsReconducionesIndMIR($v);
                //Se reemplazan los nuevos valores
                $v['url1'] = $rec['t1'];
                $v['url2'] = $rec['t2'];
                $v['url3'] = $rec['t3'];
                $v['url4'] = $rec['t4'];
            //}
            $newData[] = $v;
            /*if($rec['t1'] == 'no_aplica'){
                $std_rec1 = 1;
            }
            if($rec['t2'] == 'no_aplica'){
                $std_rec2 = 1;
            }
            if($rec['t3'] == 'no_aplica'){
                $std_rec3 = 1;
            }
            if($rec['t4'] == 'no_aplica'){
                $std_rec4 = 1;
            }*/
        }
        return ['data' => $newData];
      //  return ['data' => $newData, 'std_rec1' => $std_rec1, 'std_rec2' => $std_rec2, 'std_rec3' => $std_rec4, 'std_rec4' => $std_rec4 ];
    }
    private function rowsReconducionesIndMIR($rows){
        $t1 = $t2 = $t3 = $t4 = 'no_aplica';
        foreach ($rows['rowsInd'] as $v) {
            //cambio el esatus a 2 para indicar que si aplica reconduccion (amplia o reduce), empty quiere decir que si aplica reconduccion
            if($v['t1'] == 1 || $v['t1'] == 2){
                $t1 = 'empty';
            }
            if($v['t2'] == 1 || $v['t2'] == 2){
                $t2 = 'empty';
            }
            if($v['t3'] == 1 || $v['t3'] == 2){
                $t3 = 'empty';
            }
            if($v['t4'] == 1 || $v['t4'] == 2){
                $t4 = 'empty';
            }
        }
		if($t1 != 'no_aplica' && !empty($rows['url1'])){ $t1 = $rows['url1']; }
		if($t2 != 'no_aplica' && !empty($rows['url2'])){ $t2 = $rows['url2']; }
		if($t3 != 'no_aplica' && !empty($rows['url3'])){ $t3 = $rows['url3']; }
		if($t4 != 'no_aplica' && !empty($rows['url4'])){ $t4 = $rows['url4']; }
        return ['t1' => $t1, 't2' => $t2, 't3' => $t3, 't4' => $t4];
    }
    private function getRowsAccessPDF($year){
        if(\Auth::user()->id == 1){
            $data['t1'] = 'si';
            $data['t2'] = 'si';
            $data['t3'] = 'si';
            $data['t4'] = 'si';
            return $data;
        }

		$month_current = date("n");
        $data = ['t1' => 'no', 
                't2' => 'no',
                't3' => 'no',
                't4' => 'no',
            ];
        if($year >= date('Y')){
            if(($month_current > 2))//2
                $data['t1'] = 'si';
            if($month_current > 5)//5
                $data['t2'] = 'si';
            if($month_current > 8)//8
                $data['t3'] = 'si';
            if($month_current > 11)//11
                $data['t4'] = 'si';
        }else{
            $data['t1'] = 'si';
            $data['t2'] = 'si';
            $data['t3'] = 'si';
            $data['t4'] = 'si';
        }
        return $data;
    }
	public function getTrimestreMetas($rowsMetas,$var_trim){
		$arr_reduce = array();
		$arr_amplia = array();
		$jus_reduce = array();
		$jus_amplia = array();
        $empty_obs = 0;
		foreach ($rowsMetas as $v) {
			$trim = "trim_".$var_trim;
			$cant = "cant_".$var_trim;
			$por = "por_".$var_trim;
			$obs = "obs_".$var_trim;
			
			$trimestre = $v->$trim; 
			$cantidad = $v->$cant;
			$porcentaje = $v->$por;
			$observacion = $v->$obs;

			if($trimestre == 0 && $cantidad > 0){
				$arr_amplia[] = $this->rowsReconduciones($v,$var_trim,$trimestre,$cantidad);
                if(empty($observacion) || $observacion == null){$empty_obs++; }
			}else if($porcentaje > 110){
				$arr_amplia[] = $this->rowsReconduciones($v,$var_trim,$trimestre,$cantidad);
                if(empty($observacion) || $observacion == null){$empty_obs++; }
			}else if($trimestre > 0 && $cantidad == 0){
				$arr_reduce[] = $this->rowsReconduciones($v,$var_trim,$trimestre,$cantidad);
                if(empty($observacion) || $observacion == null){$empty_obs++; }
			}else if($trimestre > 0 && $porcentaje <= 89.99){
				$arr_reduce[] = $this->rowsReconduciones($v,$var_trim,$trimestre,$cantidad);
                if(empty($observacion) || $observacion == null){$empty_obs++; }
			}
		}
		return ["total"=>count($arr_amplia) + count($arr_reduce),
                "arr_amplia"=>$arr_amplia,
                "arr_reduce"=>$arr_reduce,
                "empty_obs"=>$empty_obs,
            ];
	}
	private function rowsReconduciones($row=array(),$trim=0,$inicial = 0,$avance=0){
		if($trim == 1){
			$inicial = $row->inicial_1;
			$avance = $row->avance_1;
			$mod = $row->mod_1;

            $t1 = $this->getQuitarDobleCerosNew($row->cant_1);
            $t2 = $this->getQuitarDobleCerosNew($row->trim_2);
            $t3 = $this->getQuitarDobleCerosNew($row->trim_3);
            $t4 = $this->getQuitarDobleCerosNew($row->trim_4);

            $obs = $row->obs_1;
		}elseif($trim == 2){
			$inicial = $row->inicial_2;
			$avance = $row->avance_2;
			$mod = $row->mod_2;

            $t1 = $this->getQuitarDobleCerosNew($row->cant_1);
            $t2 = $this->getQuitarDobleCerosNew($row->cant_2);
            $t3 = $this->getQuitarDobleCerosNew($row->trim_3);
            $t4 = $this->getQuitarDobleCerosNew($row->trim_4);

            $obs = $row->obs_2;
		}elseif($trim == 3){
			$inicial = $row->inicial_3;
			$avance = $row->avance_3;
			$mod = $row->mod_3;

            $t1 = $this->getQuitarDobleCerosNew($row->cant_1);
            $t2 = $this->getQuitarDobleCerosNew($row->cant_2);
            $t3 = $this->getQuitarDobleCerosNew($row->cant_3);
            $t4 = $this->getQuitarDobleCerosNew($row->trim_4);

            $obs = $row->obs_3;
		}elseif($trim == 4){
			$inicial = $row->inicial_4;
			$avance = $row->avance_4;
			$mod = $row->mod_4;

            $t1 = $this->getQuitarDobleCerosNew($row->cant_1);
            $t2 = $this->getQuitarDobleCerosNew($row->cant_2);
            $t3 = $this->getQuitarDobleCerosNew($row->cant_3);
            $t4 = $this->getQuitarDobleCerosNew($row->cant_4);
            $obs = $row->obs_4;
		}
		$data = array(
                      "ico" => $row->codigo,
                      "ime" => $row->meta,
                      "ito" => $row->tipo_operacion,
                      "ium" => $row->unidad_medida,
                      "iti" => $this->getQuitarDobleCerosNew($inicial), //total inicial
                      "ita" => $this->getQuitarDobleCerosNew($avance),  //total avance
                      "itm" => $this->getQuitarDobleCerosNew($mod),     //total modificasda
                      'it1' => $t1, 
                      'it2' => $t2, 
                      'it3' => $t3, 
                      'it4' => $t4, 
                      'iob' => $obs
		        );
		return $data;
	}
    public function getQuitarDobleCerosNew($numero){
		if($numero == null || $numero == ''){
			return '0';
		}else{
			return str_replace('.00','',number_format($numero,2));
		}
	}
    private function rowsMetasOchoc($rows, $var_trim){
        $data = [];

        foreach ($rows as $v) {

            if($var_trim == 1){
                $sum_trim = $v->trim_1;
                $sum_cant = $v->cant_1;
            }else if($var_trim == 2){
                $sum_trim = ($v->trim_1 + $v->trim_2);
                $sum_cant = ($v->cant_1 + $v->cant_2);
            }else if($var_trim == 3){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3);
                $sum_cant = ($v->cant_1 + $v->cant_2 + $v->cant_3);
            }else if($var_trim == 4){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3 + $v->trim_4);
                $sum_cant = ($v->cant_1 + $v->cant_2 + $v->cant_3 + $v->cant_4);
            }
            $suma_resta = ($sum_trim - $sum_cant);

            $trim = "trim_".$var_trim;//programado
            $cant = "cant_".$var_trim;//Avanve
            $resta = "resta_".$var_trim;//Resta
            $por = "por_".$var_trim;//Porcentaje
            
            $trimestre = $v->$trim; 
            $cantidad = $v->$cant;
            $resta = $v->$resta;
            $porcentaje = $v->$por;
            $data[] = ['codigo' => $v->codigo, 
                    'meta' => $v->meta,
                    'unidad_medida' => $v->unidad_medida,
                    'prog_anual' => $v->prog_anual,
                    'avance_programada' => $trimestre,
                    'avance_programada_por' => $this->getDataPorcentaje($v->prog_anual, $trimestre),
                    'avance_alcazada' => $cantidad,
                    'avance_alcazada_por' =>  $this->getDataPorcentaje($v->prog_anual, $cantidad),
                    'avance_variacion' => $resta,
                    'avance_variacion_por' =>  $this->getDataPorcentaje($v->prog_anual, $resta),
                    'acumulado_programada' => $sum_trim,
                    'acumulado_programada_por' => $this->getDataPorcentaje($v->prog_anual, $trimestre),
                    'acumulado_alcazada' => $sum_cant,
                    'acumulado_alcazada_por' =>  $this->getDataPorcentaje($v->prog_anual, $cantidad),
                    'acumulado_variacion' => $suma_resta,
                    'acumulado_variacion_por' =>  $this->getDataPorcentaje($v->prog_anual, $resta)
                    ];
        }
        return $data;
    }
    public function viewFormatoReconduccionIndicador($decoder, $request){
        $row = Reporte::getInfoReporteReconduccionMIR($decoder['id']);
        $info = $row[0];
		$mes = $request['trim'] * 3;//Esto es para que me de 3,6,9,12 los meses del trimestre y sacar la fecha
        $metas = $this->getMetasIndicadoresMIR($decoder['id'], $request['trim'],$info->idmir_formula);
		//Armado del JSON
		$json = ['header' => ['idi' => $info->idi,
                            'no_institucion' => $info->no_institucion,
                            'institucion' => strtoupper($info->institucion),
                            'row' => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                            't_dep_gen' => $info->t_dep_gen,
                            'c_dep_gen' => $info->c_dep_gen
                        ],
            'trimestre' => ['numero' => $request['trim']],
            'year' => $info->anio,
            'fecha' => cal_days_in_month(CAL_GREGORIAN,$mes, $info->anio) ." de ".ucfirst(strtolower($this->getDataMeses($mes)))." de ".$info->anio,
            'proyecto' => [
                'no_dep_gen' => $info->no_dep_gen,
                'dep_gen' => $info->dep_gen,
                'no_dep_aux' => $info->no_dep_aux,
                'dep_aux' => $info->dep_aux,
                'no_programa' => $info->no_programa,
                'programa' => $info->programa,
                'obj_programa' => $info->obj_programa,
                'no_proyecto' => $info->no_proyecto,
                'proyecto' => $info->proyecto
            ],
            'mir' => $info->mir,
            'ind' => $info->nombre_indicador,
            'metas' => $metas['indicadores'],
            'resultados' => $metas['res']

        ];
        return $json;
    }
    private function getMetasIndicadoresMIR($id, $trim, $idmir_formula){
		$rowsMetas = Reporte::getReportesProyectosMIRRec($id);
        $indicadores = $this->getValidateRecInd($rowsMetas,$trim);
        $aux = $this->getAplicarFormulaFormatoRec($indicadores,$idmir_formula);
        return ['indicadores' => $indicadores, 
                'res' => $aux
            ];
    }
    private function getAplicarFormulaFormatoRec($row,$idformula){
        $data = [];
        $iti = $ita = $itm = $it1 = $it2 = $it3 = $it4 = 0;
        if(count($row) == 2){
            if($idformula == 1 || $idformula == 4 || $idformula == 5){
                $multi = 100;
                if($idformula == 4){
                    $multi = 1000;
                }elseif($idformula == 5){
                    $multi = 10000;
                }
                $iti = $this->getFormula1($row[0]['iti'], $row[1]['iti'],$multi);
                $ita = $this->getFormula1($row[0]['ita'], $row[1]['ita'],$multi);
                $itm = $this->getFormula1($row[0]['itm'], $row[1]['itm'],$multi);
                $it1 = $this->getFormula1($row[0]['it1'], $row[1]['it1'],$multi);
                $it2 = $this->getFormula1($row[0]['it2'], $row[1]['it2'],$multi);
                $it3 = $this->getFormula1($row[0]['it3'], $row[1]['it3'],$multi);
                $it4 = $this->getFormula1($row[0]['it4'], $row[1]['it4'],$multi);
            }else if($idformula == 2){
                $multi = 100;
                $iti = $this->getFormula2($row[0]['iti'], $row[1]['iti'],$multi);
                $ita = $this->getFormula2($row[0]['ita'], $row[1]['ita'],$multi);
                $itm = $this->getFormula2($row[0]['itm'], $row[1]['itm'],$multi);
                $it1 = $this->getFormula2($row[0]['it1'], $row[1]['it1'],$multi);
                $it2 = $this->getFormula2($row[0]['it2'], $row[1]['it2'],$multi);
                $it3 = $this->getFormula2($row[0]['it3'], $row[1]['it3'],$multi);
                $it4 = $this->getFormula2($row[0]['it4'], $row[1]['it4'],$multi);
            }else if($idformula == 3){
                $iti = $this->getFormula3($row[0]['iti'], $row[1]['iti']);
                $ita = $this->getFormula3($row[0]['ita'], $row[1]['ita']);
                $itm = $this->getFormula3($row[0]['itm'], $row[1]['itm']);
                $it1 = $this->getFormula3($row[0]['it1'], $row[1]['it1']);
                $it2 = $this->getFormula3($row[0]['it2'], $row[1]['it2']);
                $it3 = $this->getFormula3($row[0]['it3'], $row[1]['it3']);
                $it4 = $this->getFormula3($row[0]['it4'], $row[1]['it4']);
            }
        }
        return ['iti'   => $this->getColocarDobleCero($iti), 
                'ita'   => $this->getColocarDobleCero($ita), 
                'itm'   => $this->getColocarDobleCero($itm), 
                'it1'   => $this->getColocarDobleCero($it1),
                'it2'   => $this->getColocarDobleCero($it2),
                'it3'   => $this->getColocarDobleCero($it3),
                'it4'   => $this->getColocarDobleCero($it4)
            ];
    }
    private function getValidateRecInd($rows = [],$no_trim){
        $data = [];
        foreach ($rows as $v) {
            $estatus = 0;//No aplica reconduccion
           
            $trim = "trim_".$no_trim;
            $cant = "cant_".$no_trim;
            $por = "por_".$no_trim;
            $obs = "obs_".$no_trim;

            $trimestre = $v->$trim; 
            $cantidad = $v->$cant;
            $porcentaje = $v->$por;
            $observacion = $v->$obs;

            if($trimestre == 0 && $cantidad > 0){
                $estatus = 1;//Amplia
            }else if($porcentaje > 110){
                $estatus = 1;//Amplia
            }else if($trimestre > 0 && $cantidad == 0){
                $estatus = 2;//Reduce
            }else if($trimestre > 0 && $porcentaje <= 89.99){
                $estatus = 2;//Reduce
            }
            
            if($no_trim == 1){
                $inicial = $v->inicial_1;
                $avance = $v->avance_1;
                $mod = $v->mod_1;
                $t1 = $this->getQuitarDobleCerosNew($v->cant_1);
                $t2 = $this->getQuitarDobleCerosNew($v->trim_2);
                $t3 = $this->getQuitarDobleCerosNew($v->trim_3);
                $t4 = $this->getQuitarDobleCerosNew($v->trim_4);
            }elseif($no_trim == 2){
                $inicial = $v->inicial_2;
                $avance = $v->avance_2;
                $mod = $v->mod_2;
                $t1 = $this->getQuitarDobleCerosNew($v->cant_1);
                $t2 = $this->getQuitarDobleCerosNew($v->cant_2);
                $t3 = $this->getQuitarDobleCerosNew($v->trim_3);
                $t4 = $this->getQuitarDobleCerosNew($v->trim_4);
            }elseif($no_trim == 3){
                $inicial = $v->inicial_3;
                $avance = $v->avance_3;
                $mod = $v->mod_3;
                $t1 = $this->getQuitarDobleCerosNew($v->cant_1);
                $t2 = $this->getQuitarDobleCerosNew($v->cant_2);
                $t3 = $this->getQuitarDobleCerosNew($v->cant_3);
                $t4 = $this->getQuitarDobleCerosNew($v->trim_4);
            }elseif($no_trim == 4){
                $inicial = $v->inicial_4;
                $avance = $v->avance_4;
                $mod = $v->mod_4;
                $t1 = $this->getQuitarDobleCerosNew($v->cant_1);
                $t2 = $this->getQuitarDobleCerosNew($v->cant_2);
                $t3 = $this->getQuitarDobleCerosNew($v->cant_3);
                $t4 = $this->getQuitarDobleCerosNew($v->cant_4);
            }

            $data[] = array(
                      "ime" => $v->meta,
                      "ito" => $v->tipo_operacion,
                      "ium" => $v->unidad_medida,
                      "iti" => $this->getQuitarDobleCerosNew($inicial), //total inicial
                      "ita" => $this->getQuitarDobleCerosNew($avance),  //total avance
                      "itm" => $this->getQuitarDobleCerosNew($mod),     //total modificasda
                      'it1' => $t1, 
                      'it2' => $t2, 
                      'it3' => $t3, 
                      'it4' => $t4, 
                      'iob' => $v->$obs,
                      'std' => $estatus
		        );
        }
        return $data;
    }
	private function projectsDictamen($idac, $idanio, $type, $trim){
        $data = [];
        $j = 1;
        $idi =  \Auth::user()->idinstituciones;
		foreach (Reporte::getProjectsForYears($idac, $idanio, $type, $idi) as $v) {
		    $rowsMetas = Reporte::getReportesProyectos($v->id);
            $justificaciones = $this->getTrimestreMetas($rowsMetas, $trim);
            if($justificaciones['total'] > 0){
                $data[] = ['no' => $j, 
                            'folio' => '0'.$j++,
                            'no_programa' => $v->no_programa,
                            'programa' => $v->programa,
                            'no_proyecto' => $v->no_proyecto,
                            'proyecto' => $v->proyecto
                        ];
            }
        }
        return $data;
    }
    public function viewInforReporte($decoder, $request){
        $row = Reporte::getInfoReporte($decoder['id']);
        $info = $row[0];
        //Armado del JSON
		$json = ['header' => ['no_dep_gen'  => $info->no_dep_gen,
                            'dep_gen'       => $info->dep_gen,
                            'no_dep_aux'    => $info->no_dep_aux,
                            'dep_aux'       => $info->dep_aux,
                            'no_proyecto'   => $info->no_proyecto,
                            'proyecto'      => $info->proyecto,
                            'no_subprograma'=> $info->no_subprograma,
                            'subprograma'   => $info->subprograma,
                            'no_programa'   => $info->no_programa,
                            'programa'      => $info->programa,
                            'no_subfuncion' => $info->no_subfuncion,
                            'subfuncion'    => $info->subfuncion,
                            'no_funcion'    => $info->no_funcion,
                            'funcion'       => $info->funcion,
                            'no_finalidad'  => $info->no_finalidad,
                            'finalidad'     => $info->finalidad,
                            'anio'          => $info->anio,
                            'no_institucion'=> $info->no_institucion,
                            'institucion'   => $info->institucion
                            ]
                    ];
        return $json;
    }
    public function viewInforMetas($decoder, $request){
        $json = [];
        $j = 0;
        foreach (Reporte::getReportesProyectos($decoder['id']) as $v) {
            $json[] = array("j"=>$j++,
                    "idrg"  =>$v->id,
                    "no_a"  =>$v->codigo,
                    "meta"  =>$v->meta,
                    "to"    =>$v->tipo_operacion,
                    "um"    =>$v->unidad_medida,
                    "obs"   =>$v->obs_1,
                    "obs2"  =>$v->obs_2,
                    "obs3"  =>$v->obs_3,
                    "obs4"  =>$v->obs_4,
                    "pa"    =>$v->prog_anual,
                    "mod"=>$v->mod_4,
                    "t1"=>$this->getQuitarDobleCeros($v->trim_1),
                    "total_m1"=> $this->getCalcularPorcentaje($v->cant_1, $v->trim_1),
                    "t2"=>$this->getQuitarDobleCeros($v->trim_2),
                    "total_m2"=> $this->getCalcularPorcentaje($v->cant_2, $v->trim_2),
                    "t3"=>$this->getQuitarDobleCeros($v->trim_3),
                    "total_m3"=> $this->getCalcularPorcentaje($v->cant_3, $v->trim_3),
                    "t4"=>$this->getQuitarDobleCeros($v->trim_4),
                    "total_m4"=> $this->getCalcularPorcentaje($v->cant_4, $v->trim_4),
                    "tt1"=>$this->getQuitarDobleCeros($v->cant_1),
                    "tt2"=>$this->getQuitarDobleCeros($v->cant_2),
                    "tt3"=>$this->getQuitarDobleCeros($v->cant_3),
                    "tt4"=>$this->getQuitarDobleCeros($v->cant_4),
                    "resta1"=>$this->getQuitarDobleCeros($v->resta_1),
                    "resta2"=>$this->getQuitarDobleCeros($v->resta_2),
                    "resta3"=>$this->getQuitarDobleCeros($v->resta_3),
                    "resta4"=>$this->getQuitarDobleCeros($v->resta_4),
                    "tr1"=>$this->getQuitarDobleCeros($v->registros_1),
                    "tr2"=>$this->getQuitarDobleCeros($v->registros_2),
                    "tr3"=>$this->getQuitarDobleCeros($v->registros_3),
                    "tr4"=>$this->getQuitarDobleCeros($v->registros_4),
					"reg"=>$this->getRowsMeses($v->id)
                );
        }
       
        return $json;
    }
    public function viewInforMetasIndicadores($decoder, $request){
        $json = [];
        $j = 0;
        foreach (Reporte::getReportesProyectosMIR($decoder['id']) as $v) {
            $indicador = array(
                    "idrg"  =>$v->id,
                    "ind"   =>$v->meta,
                    "to"    =>$v->tipo_operacion,
                    "fm"    =>$v->frecuencia_medicion,
                    "um"    =>$v->unidad_medida,
                    "obs"   =>$v->obs_1,
                    "obs2"  =>$v->obs_2,
                    "obs3"  =>$v->obs_3,
                    "obs4"  =>$v->obs_4,
                    "pa"    =>$v->prog_anual,
                    "mod"=>$v->mod_4,
                    "t1"=>$v->trim_1,
                    "total_m1"=> $this->getCalcularPorcentaje($v->cant_1, $v->trim_1),
                    "t2"=>$v->trim_2,
                    "total_m2"=> $this->getCalcularPorcentaje($v->cant_2, $v->trim_2),
                    "t3"=>$v->trim_3,
                    "total_m3"=> $this->getCalcularPorcentaje($v->cant_3, $v->trim_3),
                    "t4"=>$v->trim_4,
                    "total_m4"=> $this->getCalcularPorcentaje($v->cant_4, $v->trim_4),
                    "tt1"=>$this->getQuitarDobleCeros($v->cant_1),
                    "tt2"=>$this->getQuitarDobleCeros($v->cant_2),
                    "tt3"=>$this->getQuitarDobleCeros($v->cant_3),
                    "tt4"=>$this->getQuitarDobleCeros($v->cant_4),
                    "resta1"=>$this->getQuitarDobleCeros($v->resta_1),
                    "resta2"=>$this->getQuitarDobleCeros($v->resta_2),
                    "resta3"=>$this->getQuitarDobleCeros($v->resta_3),
                    "resta4"=>$this->getQuitarDobleCeros($v->resta_4),
                    "tr1"=>$this->getQuitarDobleCeros($v->registros_1),
                    "tr2"=>$this->getQuitarDobleCeros($v->registros_2),
                    "tr3"=>$this->getQuitarDobleCeros($v->registros_3),
                    "tr4"=>$this->getQuitarDobleCeros($v->registros_4),
                    "reg"=>$this->getRowsMeses($v->id)
                );

                if(!isset($json[$v->idreporte_mir])){
                    $json[$v->idreporte_mir] = ["j"         => ++$j,
                                                "idrm"      => $v->idreporte_mir,
                                                "no_a"      => $v->codigo,
                                                "meta"      => $v->indicador, 
                                                "a1"    =>$v->aplica1,
                                                "a2"    =>$v->aplica2,
                                                "a3"    =>$v->aplica3,
                                                "a4"    =>$v->aplica4,
                                                'rowsInd'   => [$indicador] ];
                }else{
                    $json[$v->idreporte_mir]['rowsInd'][] = $indicador;
                }
        }

        $data = [];
        foreach ($json as $v) {
            $data[] = ['j'=>$v['j'], 
                        'idrm' => $v['idrm'], 
                        'no_a' => $v['no_a'], 
                        'meta' => $v['meta'], 
                        'total' => count($v['rowsInd']), 
                        'a1' => $v['a1'],
                        'a2' => $v['a2'],
                        'a3' => $v['a3'],
                        'a4' => $v['a4'],
                        'rowsInd' => $v['rowsInd'], 
                    ];
        }
        return $data;
    }
    public function getRowsProjectsOchoc($idy,$type, $year,$ida){
        $data = array();
		foreach (Reporte::getProjectsOchoC($idy, \Auth::user()->idinstituciones, $type,$ida) as $v) {
            $ocho1 = $ocho2 = $ocho3 = $ocho4 = "empty";
         //PDF PbRM-08c
            if(!empty($v->ocho1)){ $ocho1 = $v->ocho1; }
			if(!empty($v->ocho2)){ $ocho2 = $v->ocho2; }
			if(!empty($v->ocho3)){ $ocho3 = $v->ocho3; }
			if(!empty($v->ocho4)){ $ocho4 = $v->ocho4; }

			$arr = ['id' => SiteHelpers::CF_encode_json(['id' => $v->id]), 
					'idk' => $v->id,
					'nop' => $v->no_proyecto,
					'pro' => $v->proyecto,
					'nda' => $v->no_dep_aux,
					'da' => $v->dep_aux,
					'pre' => ($v->presupuesto != "" ? number_format($v->presupuesto, 2) : $v->presupuesto),
					'ocho1' => $ocho1,
					'ocho2' => $ocho2,
					'ocho3' => $ocho3,
					'ocho4' => $ocho4
				];
			if(isset($data[$v->no_dep_gen])){
				$data[$v->no_dep_gen]['rows'][] = $arr;
			}else{
				$data[$v->no_dep_gen] = ['nodg' => $v->no_dep_gen, 'dg' => $v->dep_gen, 'rows' =>[ $arr]];
			}
		}
        return ['rowsData'  => $data, 
				'total'     => count($data),
				'access'    => $this->getRowsAccessPDF($year)
			];
    }
    public function getRowsMetasProyectos(Request $request){
        $data = [];
        $idi = Auth::user()->idinstituciones;
		foreach (Reporte::getMetasProyectos($request->all(), $idi) as $v) {

            if(!isset($data[$v->no_dep_gen])){
                $data[$v->no_dep_gen]=['no_dep_gen' => $v->no_dep_gen, 'dep_gen' => $v->dep_gen];
            }

			$data[$v->no_dep_gen]['rows'][] = [
				'id' => $v->id,
				'no_dep_aux' => $v->no_dep_aux,
				'dep_aux' => $v->dep_aux,
				'no_proyecto' => $v->no_proyecto,
				'proyecto' => $v->proyecto
			];
		}
        return ['status' => 'ok', 'data' => array_values($data)];
    }
    public function getRowsIndicadoresProyectos(Request $request){
        $data = [];
        $idi = Auth::user()->idinstituciones;
		foreach (Reporte::getMetasProyectos($request->all(), $idi) as $v) {
			$data[] = [
				'id' => $v->id,
				'no_dep_gen' => $v->no_dep_gen,
				'dep_gen' => $v->dep_gen,
				'no_dep_aux' => $v->no_dep_aux,
				'dep_aux' => $v->dep_aux,
				'no_proyecto' => $v->no_proyecto,
				'proyecto' => $v->proyecto,
				'mirs' => Reporte::getMatrices($v->id)
			];
		}
        return ['status' => 'ok', 'data' => array_values($data)];
    }
    public function getRowsProjectsOchocTxt($idy,$var_trim){
        $data = array();
		foreach (Reporte::getProjectsOchoCTxt($idy, \Auth::user()->idinstituciones) as $v) {

            if($var_trim == 1){
                $sum_trim = $v->trim_1;
                $sum_cant = $v->cant_1;
            }else if($var_trim == 2){
                $sum_trim = ($v->trim_1 + $v->trim_2);
                $sum_cant = ($v->cant_1 + $v->cant_2);
            }else if($var_trim == 3){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3);
                $sum_cant = ($v->cant_1 + $v->cant_2 + $v->cant_3);
            }else if($var_trim == 4){
                $sum_trim = ($v->trim_1 + $v->trim_2 + $v->trim_3 + $v->trim_4);
                $sum_cant = ($v->cant_1 + $v->cant_2 + $v->cant_3 + $v->cant_4);
            }
            $suma_resta = ($sum_trim - $sum_cant);

            $trim = "trim_".$var_trim;//programado
            $cant = "cant_".$var_trim;//Avanve
            $resta = "resta_".$var_trim;//Resta
            $por = "por_".$var_trim;//Porcentaje
            
            $trimestre = $v->$trim; 
            $cantidad = $v->$cant;
            $resta = $v->$resta;
            $porcentaje = $v->$por;

            $data[] = ['lb' => 0,//Localidad Beneficiada
                    'pb' => 100,//Población Beneficiada
                    'dg' => $v->no_dep_gen,
                    'da'    => $v->no_dep_aux,  
                    'no1'   => $v->no1,  
                    'no2'   => $v->no2,  
                    'no3'   => $v->no3,  
                    'no4'   => $v->no4,  
                    'no5'   => $v->no5,  
                    'no6'   => $v->no6,  
                    'ac'    => $v->no_accion,
                    'me'    => $v->meta,
                    'um'    => $v->unidad_medida,
                    'pa'    => $v->prog_anual,//prog_anual
                    'vp'    => $this->getReemplazarDobleCeros($trimestre),//avance_programada
                    'vpp'   => $this->getDataPorcentaje($v->prog_anual, $trimestre),//avance_programada_por
                    'va'    => $this->getReemplazarDobleCeros($cantidad),//avance_alcazada 
                    'vap'   =>  $this->getDataPorcentaje($v->prog_anual, $cantidad),//avance_alcazada_por
                    'vv'    => $resta,//avance_variacion (Variación Absoluta)
                    'vvp'   =>  $this->getDataPorcentaje($v->prog_anual, $resta),//avance_variacion_por
                    'ap'    => $sum_trim,//acumulado_programada
                    'app'   => $this->getDataPorcentaje($v->prog_anual, $trimestre),//acumulado_programada_por
                    'aa'    => $sum_cant,//acumulado_alcazada
                    'aap'   =>  $this->getDataPorcentaje($v->prog_anual, $cantidad),//acumulado_alcazada_por
                    'av'    => $suma_resta,//acumulado_variacion
                    'avp'   =>  $this->getDataPorcentaje($v->prog_anual, $resta)//acumulado_variacion_por
                    ];
			
		}
        return ['status'  => 'ok',
                'rowsData'  => $data
			];
    }
    public function getRowsProjectsOchob($idy,$type, $year,$ida){
        $data = array();
		foreach (Reporte::getProjectsForYearsPbRMOchob($idy, \Auth::user()->idinstituciones, $type, $ida) as $v) {
			$arr = ['id' => SiteHelpers::CF_encode_json(['id' => $v->id]), 
					'nop' => $v->no_proyecto,
					'pro' => $v->proyecto,
					'nda' => $v->no_dep_aux,
					'da' => $v->dep_aux,
					'mirs' => $this->getRowsIndicadoresMIR($v->id)
				];
			if(isset($data[$v->no_dep_gen])){
				$data[$v->no_dep_gen]['rows'][] = $arr;
			}else{
				$data[$v->no_dep_gen] = ['nodg' => $v->no_dep_gen, 'dg' => $v->dep_gen, 'rows' =>[ $arr]];
			}
		}
        return ['status'  => "ok", 
                'rowsData'  => $data, 
				'total'     => count($data),
				'access'    => $this->getRowsAccessPDF($year)
			];
    }
    private function getRowsIndicadoresMIR($id){
        $data = [];
        foreach (Reporte::getIndicadoresMIR($id) as $v) {
            $data[] = ['id' => SiteHelpers::CF_encode_json(['id' => $v->id]),
                        'ci' => $v->cod_indicador, 
                        'mir' => $v->mir, 
                        'a1' => $v->aplica1, 
                        'a2' => $v->aplica2, 
                        'a3' => $v->aplica3, 
                        'a4' => $v->aplica4, 
                        'ind' => $v->nombre_indicador,
                        'fre' => $v->frecuencia,
                        'fla' => $v->formula,
                        'eva' => Reporte::getMirEvaluacion($v->id)
                    ];
        }
        return $data;
    }
    public function getRowsEditIndicador($id){
        $data = Reporte::getMirInformacion($id);
        return $data[0];
    }
    public function addMeta(Request $request){
        $idi = Auth::user()->idinstituciones;
		$this->data['idy'] = $request->idy;
		$this->data['rowsDepGen'] = Sximo::getCatDepGeneralNew($idi, $request->idy);
		$this->data['rowsProyectos'] = Sximo::getProjectsActive($request->idy);
		return view("reporte.proyectos.metas.add",$this->data);
    }
    public function addIndicador(Request $request){
        $idi = Auth::user()->idinstituciones;
		$this->data['idy'] = $request->idy;
		$this->data['rowsDepGen'] = Sximo::getCatDepGeneralNew($idi, $request->idy);
		$this->data['rowsProyectos'] = Sximo::getProjectsActive($request->idy);
		return view("reporte.proyectos.indicadores.add",$this->data);
    }
    public function trMeta(Request $request){
        $this->data['time'] = rand(3,100).time();
        $this->data['rowsUnidadMedida'] = Poa::getUnidadMedidas();
		return view("reporte.proyectos.metas.tr",$this->data);
    }
    public function loadMatriz(Request $request){
        $fin = [];
        $proposito = [];
        $componente = [];
        $actividad = [];
        $info = Reporte::getIDprogramaProyecto($request->idp);
        if($info){
            foreach (Poa::getRowsMatricesIndicadores($info->idprograma) as $row) {
                //validamos que este asignado a un proyecto
                if($row->tipo == 1){
                    $fin = ['row' => $row];
                } elseif($row->tipo == 2){
                    $proposito = ['row' => $row];
                } elseif($row->tipo == 3){
                    $componente[] = ['row' => $row];
                } elseif($row->tipo == 4){
                    $actividad[] = ['row' => $row];
                } 
            }
            $this->data['row'] = $info;
            $this->data['fin'] = $fin;
            $this->data['proposito'] = $proposito;
            $this->data['componente'] = $componente;
            $this->data['actividad'] = $actividad;
		    return view("reporte.proyectos.indicadores.matriz",$this->data);
        }
    }
    public function editMeta(Request $request){
		$this->data['row'] = Reporte::getMetaInformacion($request->id);
		$this->data['rowsMetas'] = Reporte::getMetasEdit($request->id);
		$this->data['id'] = $request->id;
		return view("reporte.proyectos.metas.edit",$this->data);
    }
    public function moveMeta(Request $request){
        $this->data['row'] = Reporte::getMetaInformacion($request->id);
		$this->data['id'] = $request->id;
		$this->data['rowsMetas'] = Reporte::getMetasEdit($request->id);
        $idi = Auth::user()->idinstituciones;
		$this->data['idy'] = $request->idy;
		$this->data['rowsDepGen'] = Sximo::getCatDepGeneralNew($idi, $request->idy);
		$this->data['rowsProyectos'] = Sximo::getProjectsActive($request->idy);
		return view("reporte.proyectos.metas.move",$this->data);
    }
    public function loadDepAux(Request $request){
        $data = Reporte::getDepAuxPorArea($request->idda);
        return $this->success("Busqueda Ok",$data);
    }
    public function getRowsEditMeta($decoder){
        $data = Reporte::getMetaInformacion($decoder['id']);
        return $data[0];
    }
    public function getRowsAddIndicador($decoder){
        $data = Reporte::getMirReporteInformacion($decoder['id']);
        return $data[0];
    }
    protected function getCalcularPorcentaje($total = 0,$trim=0){
		if($trim == 0 && $total == 0){
			$cant = "100";
		}elseif($total == 0 && $trim != 0){
			$cant = "-100";
		}elseif($trim == 0){
			$cant = "-100";
		}else{
			$cant = ($total * 100)/$trim;
        }
		return str_replace(",", "", $this->getQuitarDobleCeros($cant));
	}
    public function getRowsMeses($id){
		$mes = [];
		foreach (Reporte::getReporteImg($id) as $v) {
			$mes[$v->trim][$v->idmes] = ['idmes'=>$v->idmes,'cant'=>$v->cant, 'total_img' => $v->total_img];
		}
		return $mes;
	}
    public function viewInfoFODA($decoder, $request){
        $row = Reporte::getInfoFODA($decoder['id']);
        $info = $row[0];
        //Armado del JSON
		$json = ['header' => ['idi'         => $info->idi,
                            'no_institucion'=> $info->no_institucion,
                            'no_dep_gen'    => $info->no_dep_gen,
                            'dep_gen'       => $info->dep_gen,
                            'no_dep_aux'    => $info->no_dep_aux,
                            'dep_aux'       => $info->dep_aux,
                            'no_finalidad'  => $info->no_finalidad,
                            'finalidad'     => $info->finalidad,
                            'no_funcion'    => $info->no_funcion,
                            'funcion'       => $info->funcion,
                            'no_subfuncion' => $info->no_subfuncion,
                            'subfuncion'    => $info->subfuncion,
                            'no_programa'   => $info->no_programa,
                            'programa'      => $info->programa,
                            'obj_programa'  => $info->obj_programa,
                            'no_subprograma' => $info->no_subprograma,
                            'subprograma'   => $info->subprograma,
                            'no_proyecto'   => $info->no_proyecto,
                            'proyecto'      => $info->proyecto,
                            'tema'          => $info->tema_desarrollo,
                            'row'           => $this->getTitularesLogosFormatos($info->idi, $info->idanio),
                            't_dep_gen'     => $info->t_dep_gen,
                            'c_dep_gen'     => $info->c_dep_gen
                            ],
            'trimestre' => ['numero' => $request['trim']],
            'year' => $info->anio,
            'rowsReg' => $this->getRowsRegFoda($decoder['id'], $request['trim'])
        ];
        return $json;
    }
    private function getRowsRegFoda($id, $trim){
        $data = [];
        foreach (Reporte::getRowsFoda($id, $trim) as $v) {
            $data[$v->type][] = ['id' => $v->id ,'foda' => $v->foda];
        }
        return $data;
    }
    /*
		* 	Usado en PbRM-08c
		Sirve para obtener el porcentaje
	*/
    public function getDataPorcentaje($prog_anual, $numero){
        $value = '';
        if($numero != 0 && $prog_anual != 0){
            $value = ($numero * 100) / $prog_anual;
        }
        return $this->getDataFloorDosDecimales($value);
    }

    public function getDataFloorDosDecimales($value){
        $no = '0';
        if($value != ''){
            /* floor
                25.6789 * 100 = 2567.89
                floor(2567.89) = 2567 (si fuera round() sería 2568)
                2567 / 100 = 25.67 (resultado truncado)
             */
           $no = floor($value * 100) / 100;
        }
        return $no;
    }
    /* 
	 	*	Usado en PbRM-08c
		Obtiene los nombres de los meses por trimestre
	*/
    public function getDataTrimestre($trim) {
		$data = [
			'1' => 'ENERO-MARZO',
			'2' => 'ABRIL-JUNIO',
			'3' => 'JULIO-SEPTIEMBRE',
			'4' => 'OCTUBRE-DICIEMBRE'
		];
		return $data[$trim];
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
                'logo_izq'      => $row[0]->logo_izq,
                'logo_der'      => $row[0]->logo_der
                ];
        }
        return $data;
    }
    public function getReemplazarDobleCeros($numero){
		if($numero != null && $numero != ''){
			return str_replace('.00','',number_format($numero,2));
		}
	}
    private function getNumberFormat($value){
        $no = '0.00';
		if($value != null && $value != ''){
            $no = number_format($value,2);
        }
        return $no;
    }
}