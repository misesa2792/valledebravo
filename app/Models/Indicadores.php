<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class indicadores extends Sximo  {
	
	protected $table = 'ui_area';
	protected $primaryKey = 'idarea';
	protected $moduleID = 5;
	/*
		1.- Presupuesto
		2.- Presupuesto Definitivo  (Programa Anual)
		3.- Proyectos 				(Programa Anual)
		4.- Ante Proyecto 			(Programa Anual)
		5.- PbRM
	*/
	public function __construct() {
		parent::__construct();
		
	}
}
