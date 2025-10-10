<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;

use App\Services\Presupuesto\ProjectsService;

class ProjectsController extends Controller 
{
	protected $projectsService;	

	public function __construct(ProjectsService $projectsService)
	{
		$this->projectsService = $projectsService;
	}
	public function getIndex( Request $request )
	{
		return $this->projectsService->index($request);
	}	
	public function getProyectos( Request $request )
	{
		return $this->projectsService->proyectos($request);
	}
	public function postSearch( Request $request )
	{
		return $this->projectsService->search($request);
	}
	public function getAdd( Request $request )
	{
		return $this->projectsService->add($request);
	}
	public function postSave( Request $request)
	{
		return $this->projectsService->store($request);
	}	
	public function deleteProyecto( Request $request )
	{
		return $this->projectsService->destroy($request);
	}
	public function getEdit( Request $request )
	{
		return $this->projectsService->edit($request);
	}
	public function postUpdate( Request $request)
	{
		return $this->projectsService->update($request);
	}
}