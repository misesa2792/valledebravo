<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use App\Services\Presupuesto\FinanciamientoService;

class FuentefinanciamientoController extends Controller 
{
	protected $financiamientoService;	

	public function __construct(FinanciamientoService $financiamientoService)
	{
		$this->financiamientoService = $financiamientoService;
	}
	public function getIndex( Request $request )
	{
		return $this->financiamientoService->index($request);
	}
	public function getRegistros( Request $request )
	{
		return $this->financiamientoService->registros($request);
	}
	public function getAdd( Request $request )
	{
		return $this->financiamientoService->agregar($request);
	}	
	public function postSave( Request $request)
	{
		return $this->financiamientoService->store($request);
	}
	public function getData(Request $request)
	{
		return $this->financiamientoService->search($request);
	}
	public function deleteFuente( Request $request )
	{
		return $this->financiamientoService->destroy($request);
	}
	public function getEdit( Request $request )
	{
		return $this->financiamientoService->edit($request);
	}		
	public function postUpdate( Request $request)
	{
		return $this->financiamientoService->update($request);
	}
	








	
	private function getRegistrosFF($idyear){
		$data = [];
		$m1 = 0;
		$m2 = 0;
		$m3 = 0;
		$m4 = 0;
		$m5 = 0;
		$m6 = 0;
		$m7 = 0;
		$m8 = 0;
		$m9 = 0;
		$m10 = 0;
		$m11 = 0;
		$m12 = 0;
		$total = 0;
		foreach ($this->model->getRegistrosFF($idyear) as $v) {
			$row = $this->getDisminuyeFuente($idyear,  $v->idteso_ff_n3);
			$row2 = $this->getAumentaFuente($idyear,  $v->idteso_ff_n3);
			$dis = $row['data'];
			$aum = $row2['data'];

			$m1 += $v->m1;
			$m2 += $v->m2;
			$m3 += $v->m3;
			$m4 += $v->m4;
			$m5 += $v->m5;
			$m6 += $v->m6;
			$m7 += $v->m7;
			$m8 += $v->m8;
			$m9 += $v->m9;
			$m10 += $v->m10;
			$m11 += $v->m11;
			$m12 += $v->m12;
			$total += $v->total;

			$data[] = ['id' => $v->id,
						'clave' => $v->clave,
						'fuente' => $v->fuente,
						'm1' => [
							'importe' 	=> number_format($v->m1,2),
							'disminuye' => number_format($dis[1],2),
							'aumenta' 	=> number_format($aum[1],2),
							'restante' 	=> number_format( ($v->m1 + $aum[1]) - $dis[1] ,2)
						],
						'm2' => [
							'importe' 	=> number_format($v->m2,2),
							'disminuye' => number_format($dis[2],2),
							'aumenta' 	=> number_format($aum[2],2),
							'restante' 	=> number_format( ($v->m2 + $aum[2]) - $dis[2] ,2)
						],
						'm3' => [
							'importe' 	=> number_format($v->m3,2),
							'disminuye' => number_format($dis[3],2),
							'aumenta' 	=> number_format($aum[3],2),
							'restante' 	=> number_format( ($v->m3 + $aum[3]) - $dis[3] ,2)
						],
						'm4' => [
							'importe' 	=> number_format($v->m4,2),
							'disminuye' => number_format($dis[4],2),
							'aumenta' 	=> number_format($aum[4],2),
							'restante' 	=> number_format( ($v->m4 + $aum[4]) - $dis[4] ,2)
						],
						'm5' => [
							'importe' 	=> number_format($v->m5,2),
							'disminuye' => number_format($dis[5],2),
							'aumenta' 	=> number_format($aum[5],2),
							'restante' 	=> number_format( ($v->m5 + $aum[5]) - $dis[5] ,2)
						],
						'm6' => [
							'importe' 	=> number_format($v->m6,2),
							'disminuye' => number_format($dis[6],2),
							'aumenta' 	=> number_format($aum[6],2),
							'restante' 	=> number_format( ($v->m6 + $aum[6]) - $dis[6] ,2)
						],
						'm7' => [
							'importe' 	=> number_format($v->m7,2),
							'disminuye' => number_format($dis[7],2),
							'aumenta' 	=> number_format($aum[7],2),
							'restante' 	=> number_format( ($v->m7 + $aum[7]) - $dis[7] ,2)
						],
						'm8' => [
							'importe' 	=> number_format($v->m8,2),
							'disminuye' => number_format($dis[8],2),
							'aumenta' 	=> number_format($aum[8],2),
							'restante' 	=> number_format( ($v->m8 + $aum[8]) - $dis[8] ,2)
						],
						'm9' => [
							'importe' 	=> number_format($v->m9,2),
							'disminuye' => number_format($dis[9],2),
							'aumenta' 	=> number_format($aum[9],2),
							'restante' 	=> number_format( ($v->m9 + $aum[9]) - $dis[9] ,2)
						],
						'm10' => [
							'importe' 	=> number_format($v->m10,2),
							'disminuye' => number_format($dis[10],2),
							'aumenta' 	=> number_format($aum[10],2),
							'restante' 	=> number_format( ($v->m10 + $aum[10]) - $dis[10] ,2)
						],
						'm11' => [
							'importe' 	=> number_format($v->m11,2),
							'disminuye' => number_format($dis[11],2),
							'aumenta' 	=> number_format($aum[11],2),
							'restante' 	=> number_format( ($v->m11 + $aum[11]) - $dis[11] ,2)
						],
						'm12' => [
							'importe' 	=> number_format($v->m12,2),
							'disminuye' => number_format($dis[12],2),
							'aumenta' 	=> number_format($aum[12],2),
							'restante' 	=> number_format( ($v->m12 + $aum[12]) - $dis[12] ,2)
						],
						'total' => [
							'importe' 	=>  number_format($v->total,2),
							'disminuye' =>  number_format($row['total'],2),
							'aumenta' 	=>  number_format($row2['total'],2),
							'restante' 	=> number_format( ($v->total + $row2['total']) - $row['total'] ,2)
						]
				];
		}
		return ['data' => $data, 
				'totales' => [
					'm1' => number_format($m1,2),
					'm2' => number_format($m2,2),
					'm3' => number_format($m3,2),
					'm4' => number_format($m4,2),
					'm5' => number_format($m5,2),
					'm6' => number_format($m6,2),
					'm7' => number_format($m7,2),
					'm8' => number_format($m8,2),
					'm9' => number_format($m9,2),
					'm10' => number_format($m10,2),
					'm11' => number_format($m11,2),
					'm12' => number_format($m12,2),
					'total' => number_format($total,2)
				]
			];
	}
	
	private function getDisminuyeFuente($idyear, $id){
		$data = [];
		$total = 0;
		foreach ( $this->model->getDisminuyeFF($idyear,  $id) as $v) {
			$total += $v->importe;
			$data[$v->idmes] = $v->importe;
		}
		return ['data' => $data, 'total' => $total];
	}
	private function getAumentaFuente($idyear, $id){
		$data = [];
		$total = 0;
		foreach ( $this->model->getAumentaFF($idyear,  $id) as $v) {
			$total += $v->importe;
			$data[$v->idmes] = $v->importe;
		}
		return ['data' => $data, 'total' => $total];
	}

}