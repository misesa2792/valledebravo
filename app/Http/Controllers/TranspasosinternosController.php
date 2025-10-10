<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use App\Services\Presupuesto\TranspasosService;

class TranspasosinternosController extends Controller {

	protected $transpasosService;	

	public function __construct(TranspasosService $transpasosService)
	{
		$this->transpasosService = $transpasosService;
	}
	public function getIndex( Request $request )
	{
		return $this->transpasosService->index($request);
	}	
	public function getProyectos( Request $request )
	{
		return $this->transpasosService->proyectos($request);
	}
	public function getAgregar( Request $request )
	{
		return $this->transpasosService->agregar($request);
	}
	public function getTr( Request $request )
	{
		return $this->transpasosService->tr($request);
	}
	public function postSaveti( Request $request )
	{
		return $this->transpasosService->saveti($request);
	}
	public function postSavete( Request $request )
	{
		return $this->transpasosService->savete($request);
	}
	public function postSearch( Request $request )
	{
		return $this->transpasosService->search($request);
	}
	public function getGenerate( Request $request )
	{
		return $this->transpasosService->generate($request);
	}
	public function postGeneratepdfti( Request $request )
	{
		return $this->transpasosService->pdfti($request);
	}
	public function postGeneratepdfte( Request $request )
	{
		return $this->transpasosService->pdfte($request);
	}
	public function postReverse( Request $request )
	{
		return $this->transpasosService->reverse($request);
	}
	public function deleteTranspaso( Request $request )
	{
		return $this->transpasosService->autorizar($request);
	}
	public function getEdit( Request $request )
	{
		return $this->transpasosService->edit($request);
	}
	public function postEditti( Request $request )
	{
		return $this->transpasosService->editti($request);
	}
	public function postEditte( Request $request )
	{
		return $this->transpasosService->editte($request);
	}
	public function deleteRegistro( Request $request )
	{
		return $this->transpasosService->registro($request);
	}
	public function getGeneratenota( Request $request )
	{
		return $this->transpasosService->generatenote($request);
	}
	public function postGeneratepdfnota( Request $request )
	{
		return $this->transpasosService->pdfnote($request);
	}
	public function postReversenota( Request $request )
	{
		return $this->transpasosService->reversenote($request);
	}
	public function postReverserec( Request $request )
	{
		return $this->transpasosService->reverserec($request);
	}
	public function getGeneraterec( Request $request )
	{
		return $this->transpasosService->generaterec($request);
	}
	public function postGeneratepdfrec( Request $request )
	{
		return $this->transpasosService->pdfreconduccion($request);
	}
	
}