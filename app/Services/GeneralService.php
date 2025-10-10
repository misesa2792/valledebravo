<?php

namespace App\Services;

use App\Models\Sximo;
use App\Models\General\Sesmas;
use App\Models\Seguimientoproyectos;

use Illuminate\Support\Facades\Auth;
use SiteHelpers;

class GeneralService
{
	//12-08-2025 Nuevo módulo de permisos por dependencia
	public function getAccessUserDependencias($idy){
		$user = Auth::user();

		$gp  = (int) $user->group_id;
		$idi = (int) $user->idinstituciones;
		$idu = (int) $user->id;

		//Por que toda la infomarción de ese año usa los mismos catalogos del año 2 (2024)
        $idy = ($idy == 1 ? 2 : $idy);

		//1.- Super admin
		//2.- Administrador
		//4.- UIPPE
		//5.- Consulta
		$adminGroups = [1, 2, 4, 5];

		//Sirve para saber si un valor ($needle) está dentro de un arreglo ($haystack)
		if (in_array($gp, $adminGroups, true)) {
			return Sesmas::getDependenciasInstitucion($idi, $idy);
		}

		//Para usuarios Enlace, cuando la condición de arriba no se cumple, tambien se normaliza a array ya que puede regresar un collection o null
		$depNumeros = (array) Sesmas::getDependenciasPermisos($idu);

		if (!empty($depNumeros)) {
			return Sesmas::getDependenciasUsuario($idi, $idy, $depNumeros);
		}

		//En caso de no encontrar nada regresa un array vacio
		return [];
    }







    //Permiso para ver las dependencias mejorado para el app movil - 08-08-2025
    public function getAccessDepGenForUsersMovil($idy,$type,$user){
        $rowsDepGen = [];
        $data = [];
        $depaux = [];
        $gp = $user['group_id'];
		$idi = $user['idinstituciones'];
        $idy = ($idy == 1 ? 2 : $idy);
        if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
            $rowsDepGen = Sximo::getAreasGeneralForYear($idi, $idy);
        }else{
		    $idu = $user['id'];
            $access = Sximo::getPermisoAreaForYearDenGen($idu);
            if($access[0]->dep_gen != null){
                $replace = str_replace('"',"'",$access[0]->dep_gen);
                $rowsDepGen = Sximo::getAreasGeneralForYearDepGen($idi, $idy, $replace);
            }
        }
        $depaux = $this->getRowsDepAux($idi, $idy, $type);
        foreach ($rowsDepGen as $v) {
            if(isset($depaux[$v->idarea])){
                $data[] = array("ida"		=> $v->idarea,
                                "no"		=> $v->no_dep_gen,
                                "area"		=> $v->dep_gen,
                                "titular"	=> $v->titular,
                                "rows_coor" => $depaux[$v->idarea]
                            );
            }
        }
        return $data;
    }

	//Permiso para ver Dependencias 
    public function getAccessDepGenForUsers($idy,$type){
        $rowsDepGen = [];
        $data = [];
        $depaux = [];
        $gp = Auth::user()->group_id;
		$idi = Auth::user()->idinstituciones;
        $idy = ($idy == 1 ? 2 : $idy);
        if($gp == 1 || $gp == 2 || $gp == 4 || $gp == 5){
            $rowsDepGen = Sximo::getAreasGeneralForYear($idi, $idy);
        }else{
		    $idu = Auth::user()->id;
            $access = Sximo::getPermisoAreaForYearDenGen($idu);
            if($access[0]->dep_gen != null){
                $replace = str_replace('"',"'",$access[0]->dep_gen);
                $rowsDepGen = Sximo::getAreasGeneralForYearDepGen($idi, $idy, $replace);
            }
        }
        $depaux = $this->getRowsDepAux($idi, $idy, $type);
        foreach ($rowsDepGen as $v) {
            if(isset($depaux[$v->idarea])){
                $data[] = array("ida"		=> $v->idarea,
                                "no"		=> $v->no_dep_gen,
                                "area"		=> $v->dep_gen,
                                "titular"	=> $v->titular,
                                "rows_coor" => $depaux[$v->idarea]
                            );
            }
        }
        return $data;
    }
	protected function getRowsDepAux($idi, $idy, $type){
        $data = [];
        foreach (Sximo::getRowsDepAuxGeneral($idi, $idy, $type) as $v) {
            $data[$v->idarea][] = ['idac'       => $v->idac, 
                                'no_dep_aux'    => $v->no_dep_aux, 
                                'dep_aux'       => $v->dep_aux,
                                'total'         => $v->total
                            ];
        }
        return $data;
    }
	public function getAccessDepGenForUsersView($decoder){
        $data = [];
        $row = Sximo::getAreaCoordinacionID($decoder['idac']);
        if($row){
            $data = $this->getRowsDepAuxiliares($decoder,$row->idarea);
        }
        return $data;
    }
	protected function getRowsDepAuxiliares($decoder,$ida){
		$idi = Auth::user()->idinstituciones;
        $data = [];
        foreach (Sximo::getRowsDepAuxiliares($idi, $decoder['idy'], $decoder['type'],$ida) as $v) {
            $keyid = SiteHelpers::CF_encode_json(['idac'=>$v->idac, 'type' =>  $decoder['type'], 'year' => $decoder['year'], 'idy' => $decoder['idy']]);
            $data[] = ['id'             => $keyid,
                        'idac'          => $v->idac,  
                        'no_dep_aux'    => $v->no_dep_aux, 
                        'dep_aux'       => $v->dep_aux
                    ];
        }
        return $data;
    }
    //Funciones para guardar archivos general, checar para dejar de usar lo del controller
    public function getBuildFilenamePDF($abreviatura, $no_institucion, $no_dep_gen, $id){
		/*Se constuye el nombre del archivo:
			PD1A 00101 A00 1214 12863 0024 0000000001
			FSTI 00107 A00 0921 00660 0024 0000000004
			PD1A 		= Modulo
			107  		= Municipio o Institución
			A00  		= Dependencia General
			0921 		= Mes y Día que se genero el PDF
			00660  		= 5 digitos aleatorios
			0024 		= 2 digitos del año con 2 ceros a la izquierda
			0000000004 	= ID de la tabla del PDF, siempre se debe de cumplir 10 digitos
		*/
		$filename = $abreviatura.$this->addCerosLEFT($no_institucion,5).$no_dep_gen.date('md').$this->addCerosLEFT(rand(0, 99999), 5)."00".date('y').$this->addCerosLEFT($id,10);
		return $filename;
	}
    public function addCerosLEFT($numero, $longitud) {
		return str_pad($numero, $longitud, '0', STR_PAD_LEFT);
	}
    public function getBuildDirectoryGallery($no_municipio, $year, $folder1, $folder2,$id){
		/*
			Esto lo realizo por que quiero manejar un estandar de digitos, ap si debe de permanecer por que así se llama la tabla y es muy práctico
			Ejemplo: 
					107/meta/files/2025/1/
			15-03-2025 Lo uso para poder dividir por trimestre
		*/
		$directory = "storage/{$no_municipio}/{$folder1}/{$folder2}/{$year}/{$id}/";
		$full_path = public_path($directory);
		$this->getCreateDirectoryGeneral($full_path);//Create directory if not exist.
		$result = ['full_path' => $full_path, 'directory' => $directory];
		return $result;
	}
    public function getCreateDirectoryGeneral($folder){
		if(!is_dir($folder)){ 
			mkdir($folder,0777, true); 
		}
	}
    public function getInsertImgMssFiles($files, $ruta, $number){
		$filename = $files->getClientOriginalName();
		$extension = $files->getClientOriginalExtension();
		$newfilename = $number.'.'.$extension;
		$files->move($ruta, $newfilename);
		return array("newfilename"=>$newfilename,"filename"=>$filename,"ext"=>strtolower($extension));
	}
    public function getSizeFiles($url=null){
		$bytes = filesize($url);
		$size = $this->getFormatSizeFiles($bytes);//Mando los bytes del archivo parta que realice la converción adecuada
		return array("bytes"=>$bytes, "size"=>$size);
	}
	//Calculo el tamaño del archivo, le paso como parametros los bytes de un archivo
	protected function getFormatSizeFiles($bytes) { 
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB'; 
		} else if ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB'; 
		} elseif ($bytes >= 1024) { 
			$bytes = number_format($bytes / 1024, 2) . ' KB'; 
		} elseif ($bytes > 1) { 
			$bytes = $bytes . ' bytes'; 
		} elseif ($bytes == 1) { 
			$bytes = $bytes . ' byte'; 
		} else { 
			$bytes = '0 bytes'; 
		} 
		return $bytes; 
	}

















    

    public function getSesTotalesProyecto($presupuesto,$idanio, $iddep_aux, $idproyecto, $importe, $std_delete){
		$sp = Seguimientoproyectos::getTotalSuficienciaPresupuestal($idanio, $iddep_aux, $idproyecto);
		$ti = Seguimientoproyectos::getTotalTraspaso(1,$idanio, $iddep_aux, $idproyecto);
		$d_te = Seguimientoproyectos::getTotalTraspaso(2,$idanio, $iddep_aux, $idproyecto);//Transpaso Externo disminuye
		$a_te = Seguimientoproyectos::getTotalTraspasoExterno(2,$idanio, $iddep_aux, $idproyecto);//Traspaso externo aumenta.
		//Autorizado
			$t_sp = (count($sp) > 0 ? $sp[0]->importe : 0);//Suficiencia presupuestal
			$t_ti = (count($ti) > 0 ? $ti[0]->importe : 0);//Transpaso Interno
			$t_d_te = (count($d_te) > 0 ? $d_te[0]->importe : 0);//Transpaso Externo Disminuye
			$t_a_te = (count($a_te) > 0 ? $a_te[0]->importe : 0);//Transpaso Externo Aumenta
			$d_x_ejercer = ($presupuesto - ($t_d_te + $t_sp)) + $t_a_te;
			return array("presupuesto"  =>number_format($presupuesto,2),
						"tra_int"       =>number_format($t_ti,2),
						"tra_ext_d"     =>number_format($t_d_te,2),
						"tra_ext_a"     =>number_format($t_a_te,2),
						"suf_pres"      =>number_format($t_sp,2),
						"x_ejercer"   =>number_format($d_x_ejercer,2),
					);
	}
	public function getSesTotalesProyectoReconduccion($presupuesto,$idanio, $iddep_aux, $idproyecto, $importe, $std_delete){
		$sp = Seguimientoproyectos::getTotalSuficienciaPresupuestal($idanio, $iddep_aux, $idproyecto);
		$ti = Seguimientoproyectos::getTotalTraspaso(1,$idanio, $iddep_aux, $idproyecto);
		$d_te = Seguimientoproyectos::getTotalTraspaso(2,$idanio, $iddep_aux, $idproyecto);//Transpaso Externo disminuye
		$a_te = Seguimientoproyectos::getTotalTraspasoExterno(2,$idanio, $iddep_aux, $idproyecto);//Traspaso externo aumenta.
		//Autorizado
			$t_sp = (count($sp) > 0 ? $sp[0]->importe : 0);//Suficiencia presupuestal
			$t_ti = (count($ti) > 0 ? $ti[0]->importe : 0);//Transpaso Interno
			$t_d_te = (count($d_te) > 0 ? $d_te[0]->importe : 0);//Transpaso Externo Disminuye
			$t_a_te = (count($a_te) > 0 ? $a_te[0]->importe : 0);//Transpaso Externo Aumenta
			$d_x_ejercer = ($presupuesto - ($t_d_te + $t_sp)) + $t_a_te;
			if($std_delete == 2){
				$d_x_ejercer = ($d_x_ejercer +  $importe);
				$modificado_d = ($d_x_ejercer -  $importe);
				$modificado_a = $d_x_ejercer;
			}else{
				$modificado_d = ($d_x_ejercer -  $importe);
				$modificado_a = ($d_x_ejercer +  $importe);
			}
			return array("presupuesto"  =>number_format($presupuesto,2),
						"tra_int"       =>number_format($t_ti,2),
						"tra_ext_d"     =>number_format($t_d_te,2),
						"tra_ext_a"     =>number_format($t_a_te,2),
						"suf_pres"      =>number_format($t_sp,2),
						"d_x_ejercer"   =>number_format($d_x_ejercer,2),
						"mod_d"         =>number_format($modificado_d,2),
						"mod_a"         =>number_format($modificado_a,2)
					);
	}
}