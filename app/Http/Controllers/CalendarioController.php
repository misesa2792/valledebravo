<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;

use App\Models\Calendario;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Traits\JsonResponds;

class CalendarioController extends Controller {

	protected $data;	
    use JsonResponds;

	public function __construct()
	{
		
	}

	public function getEventos()
    {
		$rows = Calendario::getEventos(Auth::user()->idinstituciones);
        return response()->json($rows);
    }		
	public function getAgregar(Request $request)
	{
		$this->data['fecha'] = $request->fecha;
		return view('calendario.form',$this->data);
	}

	public function getVer($id = 0)
	{
		$this->data['row'] = Calendario::find($id);
		$this->data['id'] = $id;
		return view('calendario.view',$this->data);
	}

	public function postSave(Request $request)
	{
		 $data = [
				'idinstituciones'   => Auth::user()->idinstituciones,
				'evento'            => $request->evento,
				'descripcion'       => $request->descripcion,
				'fecha_inicio'      => $request->fi,
				'fecha_fin'      	=> $request->ff,
				'color'             => $request->color,
				'iduser_rg'         => Auth::user()->id
			];
        Calendario::create($data);
        
		return $this->success('Evento guardado correctamente');
	}
	public function deleteEvento(Request $request)
	{
		$row = Calendario::find($request->id);
		if($row){
			$row->delete();
            return $this->success('Evento eliminado correctamente!');
		}
        return $this->error('ID no encontrado!');
	}
}