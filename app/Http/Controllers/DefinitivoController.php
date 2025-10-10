<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Services\Poa\PoaService;
use App\Services\Poa\PbrmaService;
use App\Services\Poa\PbrmcService;
use App\Services\Poa\PbrmaaService;
use App\Services\Poa\PbrmbService;
use App\Services\Poa\PbrmeService;
use App\Services\Poa\PbrmdService;
use App\Services\Poa\PlanService;

use Illuminate\Http\Request;

class DefinitivoController extends Controller
{
	protected $poaservice;	
	protected $pbrmaservice;	
	protected $pbrmcservice;	
	protected $pbrmaaservice;	
	protected $pbrmbservice;	
	protected $pbrmeservice;	
	protected $pbrmdservice;	
	protected $planservice;	

	const MODULE = 2;

	public function __construct(PoaService $poaservice, 
								PbrmaService $pbrmaservice,
								PbrmcService $pbrmcservice,
								PbrmaaService $pbrmaaservice,
								PbrmbService $pbrmbservice,
								PbrmeService $pbrmeservice,
								PbrmdService $pbrmdservice,
								PlanService $planservice
								)
	{
		$this->poaservice = $poaservice;
		$this->pbrmaservice = $pbrmaservice;
		$this->pbrmcservice = $pbrmcservice;
		$this->pbrmaaservice = $pbrmaaservice;
		$this->pbrmbservice = $pbrmbservice;
		$this->pbrmeservice = $pbrmeservice;
		$this->pbrmdservice = $pbrmdservice;
		$this->pbrmdservice = $pbrmdservice;
		$this->planservice = $planservice;
	}

	public function getIndex(Request $request)
	{
		return $this->poaservice->index('PD',self::MODULE);
	}
	public function getDependencias(Request $request)
	{
		return $this->poaservice->dependencias($request);
	}
	public function getGeneral(Request $request)
	{
		return $this->poaservice->general($request);
	}
	public function getPoa(Request $request)
	{
		return $this->poaservice->poa($request);
	}
	public function getPermisos(Request $request)
	{
		return $this->poaservice->permisos($request);
	}



	public function getTxt(Request $request)
	{
		return $this->poaservice->txt($request);
	}
	public function getTxtpbrma(Request $request)
	{
		return $this->poaservice->txtpbrma($request);
	}
	public function getTxtpadag(Request $request)
	{
		return $this->poaservice->txtpadag($request);
	}
	public function getTxtpbrmc(Request $request)
	{
		return $this->poaservice->txtpbrmc($request);
	}
	public function getTxtpamap(Request $request)
	{
		return $this->poaservice->txtpamap($request);
	}
	public function getTxtpbrmaa(Request $request)
	{
		return $this->poaservice->txtpbrmaa($request);
	}
	public function getTxtcmap(Request $request)
	{
		return $this->poaservice->txtcmap($request);
	}
	public function getTxtpbrmb(Request $request)
	{
		return $this->poaservice->txtpbrmb($request);
	}
	public function getTxtpadpp(Request $request)
	{
		return $this->poaservice->txtpadpp($request);
	}
	public function getTxtpbrme(Request $request)
	{
		return $this->poaservice->txtpbrme($request);
	}
	public function getTxtmirppdg(Request $request)
	{
		return $this->poaservice->txtmirppdg($request);
	}
	public function getTxtpbrmd(Request $request)
	{
		return $this->poaservice->txtpbrmd($request);
	}
	public function getTxtftdieg(Request $request)
	{
		return $this->poaservice->txtftdieg($request);
	}
	
}