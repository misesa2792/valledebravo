<?php namespace App\Http\Controllers;

use App\Services\Pdm\AccionesService;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;

class AvanceaccionesController extends Controller {

	protected $alineacionservice;	

	public function __construct(AccionesService $accionesservice)
	{
		$this->accionesservice = $accionesservice;
	}

	public function getIndex( Request $request )
	{
		return $this->accionesservice->index($request);
	}	
	public function getEjes( Request $request )
	{
		return $this->accionesservice->ejes($request);
	}
	public function getMetas( Request $request )
	{
		return $this->accionesservice->metas($request);
	}
	public function getLoadpdm( Request $request )
	{
		return $this->accionesservice->loadpdm($request);
	}
	public function getGenerate( Request $request )
	{
		return $this->accionesservice->generate($request);
	}
	public function postPdf( Request $request )
	{
		return $this->accionesservice->pdf($request);
	}
}