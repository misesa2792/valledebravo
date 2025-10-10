<?php namespace App\Http\Controllers;

class DashboardController extends Controller {

	protected $data = [];	

	public function __construct()
	{
		parent::__construct();
	}
	public function getIndex()
	{
		/*$this->data['menu'] = [
            ['title' => 'Gráficas',   					'icon' => 'fa fa-bar-chart-o', 	'color' => 'bg-ses-primary', 	'route' => 'panel/graficas'],
            ['title' => 'Generardor de .txt', 			'icon' => 'fa fa-file-text-o',  'color' => 'bg-ses-red',   		'route' => 'panel/generartxt'],
            ['title' => 'Titulares Dependencias',      	'icon' => 'fa fa-building-o',   'color' => 'bg-ses-orange', 	'route' => 'panel/titulares'],
            ['title' => 'Usuarios',  					'icon' => 'fa fa-users',        'color' => 'bg-ses-green',  	'route' => '#'],
            ['title' => 'Presupuesto Anual',  			'icon' => 'fa fa-money',        'color' => 'bg-ses-purple',    	'route' => 'panel/poa'],
        ];*/
		return view('dashboard.index',$this->data);
	}	
}