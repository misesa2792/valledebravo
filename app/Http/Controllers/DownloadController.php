<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class DownloadController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'download';
	static $per_page	= '10';

	public function __construct()
	{
		$this->model = new Download();
	}
	public function getPdf(Request $r ){
		try {
			$row = $this->model->getViewNumberPDF($r->number);
			if(count($row) > 0){
				$rutaArchivo = public_path($row[0]->url);
				if (file_exists($rutaArchivo))
					return redirect('/' . $row[0]->url);
				else
					return view('errors.414');
			}else{
				return view('errors.414');
			}
		} catch (\Exception $e) {
			return view('errors.414');
		}
	}

}