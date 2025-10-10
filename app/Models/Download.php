<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class download extends Sximo  {
	
	protected $table = 'ui_plan_pdf';
	protected $primaryKey = 'idplan_pdf';

	public function __construct() {
		parent::__construct();
		
	}
	public static function getViewNumberPDF($number){
		return \DB::select("SELECT idplan_pdf as id,CONCAT(p.url,p.number,'.',p.ext) as url FROM ui_plan_pdf p where p.number = '".$number."' ");
	}
}
