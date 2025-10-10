<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Validator, Input, Redirect ;


abstract class Controller extends BaseController {

	use DispatchesJobs, ValidatesRequests;

	public function __construct()
	{
		$this->middleware('ipblocked');

		$driver             = config('database.default');
		$database           = config('database.connections');

		$this->db           = $database[$driver]['database'];
		$this->dbuser       = $database[$driver]['username'];
		$this->dbpass       = $database[$driver]['password'];
		$this->dbhost       = $database[$driver]['host'];

		if(\Auth::check() == true)
		{
			if(!\Session::get('gid'))
			{
				\Session::put('uid', \Auth::user()->id);
				\Session::put('gid', \Auth::user()->group_id);
				\Session::put('eid', \Auth::user()->email);
				\Session::put('ll', \Auth::user()->last_login);
				\Session::put('fid', \Auth::user()->first_name.' '. \Auth::user()->last_name);
				\Session::put('themes', 'sximo-light-blue');
			}
		}
		if(!\Session::get('themes'))
		{
			\Session::put('themes', 'sximo');
		}
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == 1) {
			$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
			\App::setLocale($lang);
		}
	}


	function getComboselect( Request $request)
    {

        if($request->ajax() == true && \Auth::check() == true)
        {
            $param = explode(':',$request->input('filter'));
            $parent = (!is_null($request->input('parent'))) ? $request->input('parent') : null;
            $limit = (!is_null($request->input('limit'))) ? $request->input('limit') : null;
            $sort = (!is_null($request->input('sort'))) ? $request->input('sort') : null;
            $order = (!is_null($request->input('order'))) ? $request->input('order') : null;
            $_nw = trim($request->input('notwhere'),',');
            $_gluefields = (!is_null($request->input('gluefields'))) ? $request->input('gluefields'):' ';
            $notwhere = (!is_null($request->input('notwhere'))) ? $_nw : null;
            $rows = $this->model->getComboselect($param,$limit,$parent,$notwhere,$sort,$order);
            $items = array();

            $fields = explode("|",$param[2]);

            foreach($rows as $row)
            {
                $value = "";
                foreach($fields as $item => $val)
                {
                    if($row->$val != "") $value .= $row->$val . $_gluefields;
                }
                $value = substr_replace($value, '', -(strlen($_gluefields)));

                $items[] = array($row->$param['1'] , $value);

            }

            return json_encode($items);
        } else {
            return json_encode(array('OMG'=>" Ops .. Cant access the page !"));
        }
    }

	public function getCombotable( Request $request)
	{
		if(Request::ajax() == true && Auth::check() == true)
		{
			$rows = $this->model->getTableList($this->db);
			$items = array();
			foreach($rows as $row) $items[] = array($row , $row);
			return json_encode($items);
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}
	}

	public function getCombotablefield( Request $request)
	{
		if($request->input('table') =='') return json_encode(array());
		if(Request::ajax() == true && Auth::check() == true)
		{


			$items = array();
			$table = $request->input('table');
			if($table !='')
			{
				$rows = $this->model->getTableField($request->input('table'));
				foreach($rows as $row)
					$items[] = array($row , $row);
			}
			return json_encode($items);
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}
	}

	function postMultisearch( Request $request)
	{
		$post = $_POST;
		$items ='';
		foreach($post as $item=>$val):
			if($_POST[$item] !='' and $item !='_token' and $item !='md' && $item !='id'):
				$items .= $item.':'.trim($val).'|';
			endif;

		endforeach;

		$querystring = '';
		foreach($_GET as $get => $val):
			if($get != 'search' && $get != 'md'):
				$querystring .= '&' . $get .'=' . $val;
			endif;
		endforeach;

		return Redirect::to($this->module.'?search='.substr($items,0,strlen($items)-1).'&md='.Input::get('md') . $querystring);
	}

	function buildSearch( )
	{
		$keywords = ''; $fields = '';	$param ='';
		$allowsearch = $this->info['config']['forms'];
		foreach($allowsearch as $as) $arr[$as['field']] = $as ;
		if($_GET['search'] !='')
		{
			$type = explode("|",$_GET['search'] );
			if(count($type) >= 1)
			{
				foreach($type as $t)
				{
					$keys = explode(":",$t);

					if(in_array($keys[0],array_keys($arr))):
						if($arr[$keys[0]]['type'] == 'select' || $arr[$keys[0]]['type'] == 'radio' )
						{
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." = '".$keys[1]."' ";
						} else {
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." REGEXP '".$keys[1]."' ";
						}
					endif;
				}
			}
		}
		return $param;

	}

	function inputLogs(Request $request, $note = NULL)
	{
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);
		\DB::table( 'tb_logs')->insert($data);		;

	}

	function validateForm()
	{
		$forms = $this->info['config']['forms'];
		$rules = array();
		foreach($forms as $form)
		{
			if($form['required']== '' || $form['required'] !='0')
			{
				$rules[$form['field']] = 'required';
			} elseif ($form['required'] == 'alpa'){
				$rules[$form['field']] = 'required|alpa';
			} elseif ($form['required'] == 'alpa_num'){
				$rules[$form['field']] = 'required|alpa_num';
			} elseif ($form['required'] == 'alpa_dash'){
				$rules[$form['field']]='required|alpa_dash';
			} elseif ($form['required'] == 'email'){
				$rules[$form['field']] ='required|email';
			} elseif ($form['required'] == 'numeric'){
				$rules[$form['field']] = 'required|numeric';
			} elseif ($form['required'] == 'date'){
				$rules[$form['field']]='required|date';
			} else if($form['required'] == 'url'){
				$rules[$form['field']] = 'required|active_url';
			} else {

			}
		}
		return $rules ;
	}

	function validatePost(  $table )
	{
		$request = new Request;
	///	return json_encode($_POST);

		$str = $this->info['config']['forms'];
		$data = array();
		foreach($str as $f){
			$field = $f['field'];
			if($f['view'] ==1)
			{


				if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
				{
					$content = (isset($_POST[$field]) ? $_POST[$field] : '');
					 $data[$field] = $content;
				} else {


					if(isset($_POST[$field]))
					{
						$data[$field] = $_POST[$field];
					}
					// if post is file or image


					if($f['type'] =='file')
					{

						$files ='';
						if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
						{

							if(isset($_POST['curr'.$field]))
							{
								$curr =  '';
								for($i=0; $i<count($_POST['curr'.$field]);$i++)
								{
									$files .= $_POST['curr'.$field][$i].',';
								}
							}

							if(!is_null(Input::file($field)))
							{

								$destinationPath = '.'. $f['option']['path_to_upload'];
								foreach($_FILES[$field]['tmp_name'] as $key => $tmp_name ){
								 	$file_name = $_FILES[$field]['name'][$key];
									$file_tmp =$_FILES[$field]['tmp_name'][$key];
									if($file_name !='')
									{
										move_uploaded_file($file_tmp,$destinationPath.'/'.$file_name);
										$files .= $file_name.',';

									}

								}

								if($files !='')	$files = substr($files,0,strlen($files)-1);
							}
							$data[$field] = $files;


						} else {



							if(!is_null(Input::file($field)))
							{

								$file = Input::file($field);
							 	$destinationPath = '.'. $f['option']['path_to_upload'];
								$filename = $file->getClientOriginalName();
								$extension =$file->getClientOriginalExtension(); //if you need extension of the file
								$rand = rand(1000,100000000);
								$newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
								$uploadSuccess = $file->move($destinationPath, $newfilename);
								 if($f['option']['resize_width'] != '0' && $f['option']['resize_width'] !='')
								 {
								 	if( $f['option']['resize_height'] ==0 )
									{
										$f['option']['resize_height']	= $f['option']['resize_width'];
									}
								 	$orgFile = $destinationPath.'/'.$newfilename;
									 \SiteHelpers::cropImage($f['option']['resize_width'] , $f['option']['resize_height'] , $orgFile ,  $extension,	 $orgFile)	;
								 }

								if( $uploadSuccess ) {
								   $data[$field] = $newfilename;
								}
							} else {
								unset($data[$field]);
							}
						}
					}


					// if post is checkbox
					if($f['type'] =='checkbox')
					{
						if(!is_null($_POST[$field]))
						{
							$data[$field] = implode(",",$_POST[$field]);
						}
					}
					// if post is date
					if($f['type'] =='date')
					{
						$data[$field] = date("Y-m-d",strtotime($request->input($field)));
					}

					// if post is seelct multiple
					if($f['type'] =='select')
					{
						//echo '<pre>'; print_r( $_POST[$field] ); echo '</pre>';
						if( isset($f['option']['select_multiple']) &&  $f['option']['select_multiple'] ==1 )
						{
							$multival = (is_array($_POST[$field]) ? implode(",",$_POST[$field]) :  $_POST[$field]);
							$data[$field] = $multival;
						} else {
							$data[$field] = $_POST[$field];
						}
					}

				}

			}
		}
		 $global	= (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );

		if($global == 0 )
			$data['entry_by'] = \Session::get('uid');

		return $data;
	}

	function postFilter( Request $request)
	{
		$module = $this->module;
		$sort 	= (!is_null($request->input('sort')) ? $request->input('sort') : '');
		$order 	= (!is_null($request->input('order')) ? $request->input('order') : '');
		$rows 	= (!is_null($request->input('rows')) ? $request->input('rows') : '');
		$md 	= (!is_null($request->input('md')) ? $request->input('md') : '');
		$tipo 	= (isset($_GET['tipo']) ? $_GET['tipo'] : '');

		$filter = '?';
		if($sort!='') $filter .= '&sort='.$sort;
		if($order!='') $filter .= '&order='.$order;
		if($rows!='') $filter .= '&rows='.$rows;
		if($md !='') $filter .= '&md='.$md;
		if($tipo!='') $filter .= '&tipo='.$tipo;



		return Redirect::to($this->data['pageModule'] . $filter);

	}

	function injectPaginate()
	{

		$sort 	= (isset($_GET['sort']) 	? $_GET['sort'] : '');
		$order 	= (isset($_GET['order']) 	? $_GET['order'] : '');
		$rows 	= (isset($_GET['rows']) 	? $_GET['rows'] : '');
		$search 	= (isset($_GET['search']) ? $_GET['search'] : '');
		$tipo 	= (isset($_GET['tipo']) ? $_GET['tipo'] : '');

		$appends = array();
		if($sort!='') 	$appends['sort'] = $sort;
		if($order!='') 	$appends['order'] = $order;
		if($rows!='') 	$appends['rows'] = $rows;
		if($search!='') $appends['search'] = $search;
		if($tipo!='') $appends['tipo'] = $tipo;

		return $appends;

	}

	function returnUrl()
	{
		$pages 	= (isset($_GET['page']) ? $_GET['page'] : '');
		$sort 	= (isset($_GET['sort']) ? $_GET['sort'] : '');
		$order 	= (isset($_GET['order']) ? $_GET['order'] : '');
		$rows 	= (isset($_GET['rows']) ? $_GET['rows'] : '');
		$search 	= (isset($_GET['search']) ? $_GET['search'] : '');
		$tipo 	= (isset($_GET['tipo']) ? $_GET['tipo'] : '');

		$appends = array();
		if($pages!='') 	$appends['page'] = $pages;
		if($sort!='') 	$appends['sort'] = $sort;
		if($order!='') 	$appends['order'] = $order;
		if($rows!='') 	$appends['rows'] = $rows;
		if($search!='') $appends['search'] = $search;
		if($tipo!='') $appends['tipo'] = $tipo;

		$url = "";
		foreach($appends as $key=>$val)
		{
			$url .= "&".$key."=".$val;
		}
		return $url;

	}

	public function getRemovecurrentfiles( Request $request)
	{
		$id 	= $request->input('id');
		$field 	= $request->input('field');
		$file 	= $request->input('file');
		if(file_exists('./'.$file) && $file !='')
		{
			if(unlink('.'.$file))
			{
				\DB::table($this->info['table'])->where($this->info['key'],$id)->update(array($field=>''));
			}
			return Response::json(array('status'=>'success'));
		} else {
			return Response::json(array('status'=>'error'));
		}
	}

	function getDownload( Request $request)
	{

		if($this->access['is_excel'] ==0)
			return Redirect::to('')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');

		$info = $this->model->makeInfo( $this->module);
		// Take param master detail if any
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		$params = array(
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);

		$results 	= $this->model->getRows( $params );
		$fields		= $info['config']['grid'];
		$rows		= $results['rows'];

		$content = $this->data['pageTitle'];
		$content .= '<table border="1">';
		$content .= '<tr>';
		foreach($fields as $f )
		{
			if($f['download'] =='1') $content .= '<th style="background:#f9f9f9;">'. $f['label'] . '</th>';
		}
		$content .= '</tr>';

		foreach ($rows as $row)
		{
			$content .= '<tr>';
			foreach($fields as $f )
			{
				if($f['download'] =='1'):
					$conn = (isset($f['conn']) ? $f['conn'] : array() );
					$content .= '<td>'. \SiteHelpers::gridDisplay($row->$f['field'],$f['field'],$conn) . '</td>';
				endif;
			}
			$content .= '</tr>';
		}
		$content .= '</table>';

		@header('Content-Type: application/ms-excel');
		@header('Content-Length: '.strlen($content));
		@header('Content-disposition: inline; filename="'.$title.' '.date("d/m/Y").'.xls"');

		echo $content;
		exit;

	}


	function detailview( $model , $detail , $id )
	{

		$info = $model->makeInfo( $detail['module'] );
		$params = array(
			'params'	=> " And `".$detail['key']."` ='". $id ."'",
			'global'	=> 0
		);
		$results = $model->getRows( $params );
		$data['rowData']		= $results['rows'];
		$data['tableGrid'] 	= $info['config']['grid'];
		$data['tableForm'] 	= $info['config']['forms'];

		return $data;



	}

	function detailviewsave( $model ,$request , $detail , $id )
	{

		\DB::table($detail['table'])->where($detail['key'],$request[$detail['key']])->delete();
		$info = $model->makeInfo( $detail['module'] );
		$str = $info['config']['forms'];
		$data = array($detail['master_key'] => $id );
		$total = count($request['counter']);
		for($i=0; $i<$total;$i++)
		{
			foreach($str as $f){
				$field = $f['field'];
				if($f['view'] ==1)
				{
					//echo 'bulk_'.$field[$i]; echo '<br />';
					if(isset($request['bulk_'.$field][$i]))
					{
						$data[$f['field']] = $request['bulk_'.$field][$i];
					}
				}

			}

			\DB::table($detail['table'])->insert($data);
		}


	}

	function buildMasterDetail( $template = null)
	{
		// check if url contain $_GET['md'] , that mean master detail
		if(!is_null(Input::get('md')) and Input::get('md') != '' )
		{

			$values 				= array();
			$data 					= explode(" ", Input::get('md') );
			// Split all param get
			$master 				= ucwords($data[0]) ; $master_key = $data[1]; $module = $data[2]; $key = $data[3];  $val = $data[4];
			$val 					=  SiteHelpers::encryptID($val,true) ;
			$values['row'] 			= $master::getRow( $val );
			$loadInfo 				= $master::makeInfo( $master);
			$values['grid']         = $loadInfo ['config']['grid'];
			$filter 				= 	" AND  ".$this->info['table'].".".$key."='".$val."' ";
			if($template != null)
			{
				$view 					= View::make($template, $values);
			} else {
				$view 					= View::make('layouts/masterview', $values);
			}
			$result = array(
				'masterFilter' => $filter,
				'masterView'	=> $view
			);
			return $result;

		} else {
			$result = array(
				'masterFilter' => '',
				'masterView'	=> ''
			);
			return $result;
		}


	}

	public function masterDetailParam()
	{
		if(!is_null(Input::get('md')))
		{
			$data 	= explode(" ", Input::get('md') );
			$data = array(
				'filtermodule' 		=> (isset($data[2]) ? $data[2] : ''),
				'filterkey'			=> (isset($data[3]) ? $data[3] : ''),
				'filtervalue' 		=> (isset($data[4]) ? $data[4] : ''),
				'filtermd' 			=> str_replace(" ","+",Input::get('md')),

			);
		} else {
			$data = array(
				'filtermodule' 	=> '',
				'filterkey' 	=> '',
				'filtervalue' 	=> '',
				'filtermd' 		=> '',
			);
		}
		return $data;

	}


	public function getAddfiles($id, Request $request)
	{
		$data['parent_id'] = $id;
		$data['urlback'] = (!empty($request->input('urlback'))) ? $request->input('urlback') : $this->module;
		$data['module'] = $this->module;
		return view('layouts.gthres.modalAddFiles',$data);
	}

	public function getAddfiles2($id, Request $request)
	{
		$data['parent_id'] = $id;
		$data['urlback'] = (!empty($request->input('urlback'))) ? $request->input('urlback') : $this->module;
		$data['module'] = $this->module;
		return view('layouts.gthres.modalAddFiles2',$data);
	}

	public function postAddfiles(Request $request, $id)
	{
		if($this->access['is_add'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$return = $request->input('urlback');

		if($_FILES['archivos']['error'][0] != 0) return Redirect::to($return)->with('messagetext','Tienes que seleccionar al menos un archivo')->with('msgstatus','error')->with('tab','files');



		if(isset($_FILES['archivos']['name']) && !empty($_FILES['archivos']['name']))
		{
			// si no existe el directorio lo creamos
			$path = realpath("./../public/uploads/modulefiles/") . "/" . $this->module . "/" . date("Y/m") ."/";
			if(!file_exists($path))
				mkdir($path, 0775, true);

			// recorremos los archivos y creamos el objeto para guardar en la tabla
			$filestosave = [];
			foreach($_FILES['archivos']['name'] as $key => $file)
			{
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$_file = [];
				$_file['name'] = $file;
				// creamos la ruta con id unico para guardar el archivos
				$hmct = uniqid();
				//echo $mct . " - " . $hmct . " - ";
				$_file['url'] = $path . $hmct . "." . $ext;
				move_uploaded_file($_FILES['archivos']['tmp_name'][$key], $_file['url']);
				$filestosave[] = $_file;
			}
			$resp = $this->model->saveFiles($filestosave, $id, $this->module);

			return Redirect::to($return)->with('messagetext','Archivos Guardados')->with('msgstatus','success')->with('tab','files');
		}
		else
		{
			return Redirect::to($return)->with('messagetext','Ocurrio un error al intentar guardar lo archivos')->with('msgstatus','error')->with('tab','files');
		}

	}
	public function postAddfiles2(Request $request, $id)
	{
		if($this->access['is_add'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$return = "user/profile";

		if($_FILES['archivos']['error'][0] != 0) return Redirect::to($return)->with('messagetext','Tienes que seleccionar al menos un archivo')->with('msgstatus','error')->with('tab','files');



		if(isset($_FILES['archivos']['name']) && !empty($_FILES['archivos']['name']))
		{
			// si no existe el directorio lo creamos
			$path = realpath("./../public/uploads/modulefiles/") . "/" . $this->module . "/" . date("Y/m") ."/";
			if(!file_exists($path))
				mkdir($path, 0775, true);

			// recorremos los archivos y creamos el objeto para guardar en la tabla
			$filestosave = [];
			foreach($_FILES['archivos']['name'] as $key => $file)
			{
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$_file = [];
				$_file['name'] = $file;
				// creamos la ruta con id unico para guardar el archivos
				$hmct = uniqid();
				//echo $mct . " - " . $hmct . " - ";
				$_file['url'] = $path . $hmct . "." . $ext;
				move_uploaded_file($_FILES['archivos']['tmp_name'][$key], $_file['url']);
				$filestosave[] = $_file;
			}
			$resp = $this->model->saveFiles($filestosave, $id, $this->module);

			return Redirect::to($return)->with('messagetext','Archivos Guardados')->with('msgstatus','success')->with('tab','files');
		}
		else
		{
			return Redirect::to($return)->with('messagetext','Ocurrio un error al intentar guardar lo archivos')->with('msgstatus','error')->with('tab','files');
		}

	}

	public function getDeletefiles($parent_id, $id=null, Request $request)
	{
		$return = $this->module;

		if(!empty($request->input('urlback')))
			$return = $request->input('urlback');

		if(!is_null($id))
		{
			$data = [];
			$data[0]['id'] = $id;
			$this->model->deleteFiles($data, $parent_id);

			$archToDelete = $this->model->getFilesListById($id, $parent_id);
			foreach($archToDelete as $file)
			{
				unlink($file->url);
			}

			return Redirect::to($return)->with('messagetext','Se borraron lo archivos seleccionados')->with('msgstatus','success')->with('tab','files');
		}
		return Redirect::to($return)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')->with('tab','files');
	}

	public function postDeletefiles(Request $request, $parent_id)
	{
		$return = $this->module;

		if(!empty($request->input('urlback')))
			$return = $request->input('urlback');

		if(!empty($request->idfile) || is_array($request->idfile))
		{
			$data = [];
			foreach($request->idfile as $key => $idfile)
			{
				$data[$key]['id'] = $idfile;
			}
			$archToDelete = $this->model->getFilesListById($request->idfile, $parent_id);
			foreach($archToDelete as $file)
			{
				unlink($file->url);
			}

			$this->model->deleteFiles($data, $parent_id);
			return Redirect::to($return)->with('messagetext','Se borraron los archivos selecionados')->with('msgstatus','success')->with('tab','files');
		}
		return Redirect::to($return)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')->with('tab','files');
	}
	protected function getControllerFindLetras(){
		return array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ','Á','É','Í','Ó','Ú',"Â","Ê","Î","Ô","Û","Ã","Õ","Ç","Ñ","",'/','*','-','+','.',',',':',';','^','_','[',']','{','}','=','!','@','#','$','°','|','%','&','(',')','<','>','¿',"?",'`','´');
	}
	protected function getControllerRempLetras(){
		return array('a','e','i','o','u','a','e','i','o','u','a','o','c','n','A','E','I','O','U','A','E','I','O','U','A','O','C','N','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}
	//Se creo esta nueva ya que en elas metas si puede llevar la /
	protected function getControllerFindLetrasPbRM(){
		return array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','Á','É','Í','Ó','Ú',"Â","Ê","Î","Ô","Û","Ã","Õ","Ç","",'*','-','+','.',',',':',';','^','_','[',']','{','}','=','!','@','#','$','°','|','%','&','(',')','<','>','¿',"?",'`','´');
	}
	protected function getControllerRempLetrasPbRM(){
		return array('a','e','i','o','u','a','e','i','o','u','a','o','c','A','E','I','O','U','A','E','I','O','U','A','O','C','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	}
	public function getNoPaginacion(){
		return array("10","20","50","100","500");
	}
	//Eliminó el exceso de espacios en blanco de una cedana y aparte con trim le quito espacios en blanco del inicio y final ejemplo :  Hola   Miguel  Juan de 
	protected function getEliminarExcesosEspacios($folder){
		$name = preg_replace("/\s+/", " ", trim($folder));
		return $name;
	}
	public function getInsertImgMss($files,$ruta){
		$filename = $files->getClientOriginalName();
		$extension = $files->getClientOriginalExtension();
		$newfilename = rand(2,100).'_'.time().'.'.$extension;
		$files->move($ruta, $newfilename);
		return array("newfilename"=>$newfilename,"filename"=>$filename,"ext"=>strtolower($extension));
	}
	public function getInsertImgMssFiles($files, $ruta, $number){
		$filename = $files->getClientOriginalName();
		$extension = $files->getClientOriginalExtension();
		$newfilename = $number.'.'.$extension;
		$files->move($ruta, $newfilename);
		return array("newfilename"=>$newfilename,"filename"=>$filename,"ext"=>strtolower($extension));
	}
	public function getSizeFiles($url=null){
		$bytes = filesize($url);
		$size = $this->getFormatSizeFiles($bytes);//Mando los bytes del archivo parta que realice la converción adecuada
		return array("bytes"=>$bytes, "size"=>$size);
	}
	//Calculo el tamaño del archivo, le paso como parametros los bytes de un archivo
	protected function getFormatSizeFiles($bytes) { 
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB'; 
		} else if ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB'; 
		} elseif ($bytes >= 1024) { 
			$bytes = number_format($bytes / 1024, 2) . ' KB'; 
		} elseif ($bytes > 1) { 
			$bytes = $bytes . ' bytes'; 
		} elseif ($bytes == 1) { 
			$bytes = $bytes . ' byte'; 
		} else { 
			$bytes = '0 bytes'; 
		} 
		return $bytes; 
	}
	public function getRowsReporteTrim($row=array(),$trim=0,$inicial = 0,$avance=0){
		if($trim == 1){
			$inicial = $row->inicial_1;
			$avance = $row->avance_1;
			$mod = $row->mod_1;
		}elseif($trim == 2){
			$inicial = $row->inicial_2;
			$avance = $row->avance_2;
			$mod = $row->mod_2;
		}elseif($trim == 3){
			$inicial = $row->inicial_3;
			$avance = $row->avance_3;
			$mod = $row->mod_3;
		}elseif($trim == 4){
			$inicial = $row->inicial_4;
			$avance = $row->avance_4;
			$mod = $row->mod_4;
		}
		$data = array("idrr"=>$row->idreporte_reg,
			"des"=>$row->descripcion,
			"um"=>$row->unidad_medida,
			"no"=>$row->no_accion,
			"to"=>$row->tipo_operacion,
			"fm"=>$row->frec_medicion,
			"deno"=>$row->denominacion,
			"inicial"=>self::getQuitarDobleCeros($inicial),
			"avance"=>self::getQuitarDobleCeros($avance),
			"mod"=>self::getQuitarDobleCeros($mod),
			"trim_1"=>self::getQuitarDobleCeros($row->cant_1),
			"trim_2"=>self::getQuitarDobleCeros($row->cant_2),
			"trim_3"=>self::getQuitarDobleCeros($row->cant_3),
			"trim_4"=>self::getQuitarDobleCeros($row->cant_4),
			"obs1"=>$row->obs1,
			"obs2"=>$row->obs2,
			"obs3"=>$row->obs3,
			"obs4"=>$row->obs4,
			"tt_1"=>self::getQuitarDobleCeros($row->trim_1),
			"tt_2"=>self::getQuitarDobleCeros($row->trim_2),
			"tt_3"=>self::getQuitarDobleCeros($row->trim_3),
			"tt_4"=>self::getQuitarDobleCeros($row->trim_4),
		);
		return $data;
	}
	public function getRowNameTrim($trim=null){
		$data = array();
		switch ($trim) {
			case '1': $data = array("trim"=>"trim_1","cant"=>"cant_1","por"=>"por_1","obs"=>"obs1"); break;
			case '2': $data = array("trim"=>"trim_2","cant"=>"cant_2","por"=>"por_2","obs"=>"obs2"); break;
			case '3': $data = array("trim"=>"trim_3","cant"=>"cant_3","por"=>"por_3","obs"=>"obs3"); break;
			case '4': $data = array("trim"=>"trim_4","cant"=>"cant_4","por"=>"por_4","obs"=>"obs4"); break;
			default: $data = array("trim"=>"","cant"=>"");break;
		}
		return $data;
	}
	/*
		Este bloque se desarrollo 25-01-2024 con la finalidad de que me de la cantidad permitida que no exceda los 110% de reconducción,
		es muy práctico para la gráfica sin reconducción.
		FLOOR(LEAST(info.cant_1, info.trim_1 * 1.1)) AS limit_trim_1
	*/
	public function getReportesRegistrados($idr){
		return \DB::select("SELECT sub2.*,sub2.prog_anual as inicial_1,sub2.mod_1 as inicial_2,sub2.mod_2 as inicial_3,sub2.mod_3 as inicial_4,((sub2.total_realizado * 100)/sub2.prog_anual) as total_porcentaje,(100-((sub2.total_realizado * 100)/sub2.prog_anual)) as porcentaje_restante FROM (
			SELECT sub1.*,(sub1.cant_1 + sub1.cant_2 + sub1.cant_3 + sub1.cant_4) as total_realizado,
			sub1.cant_1  as avance_1,(sub1.cant_1 + sub1.cant_2) as avance_2,((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) as avance_3,(((sub1.cant_1 + sub1.cant_2) + sub1.cant_3) + sub1.cant_4) as avance_4
			,(sub1.prog_anual + sub1.resta_1) as mod_1, ((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) as mod_2, (((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) as mod_3, ((((sub1.prog_anual + sub1.resta_1) + sub1.resta_2) + sub1.resta_3) + sub1.resta_4) as mod_4 FROM(
				SELECT qry.idreporte_reg,qry.no_accion,qry.denominacion,qry.tipo_operacion,qry.frec_medicion,qry.descripcion,qry.unidad_medida,qry.obs1,qry.obs2,qry.obs3,qry.obs4,
					qry.prog_anual,qry.trim_1,qry.trim_2,qry.trim_3,qry.trim_4,qry.cant_1,qry.cant_2,qry.cant_3,qry.cant_4,qry.por_1,qry.por_2,qry.por_3,qry.por_4,
					(qry.cant_1 - qry.trim_1) as resta_1,(qry.cant_2 - qry.trim_2) as resta_2,(qry.cant_3 - qry.trim_3) as resta_3,(qry.cant_4 - qry.trim_4) as resta_4
					FROM (
						SELECT info.*,
							IFNULL(((info.cant_1 * 100)/info.trim_1),0) as por_1,IFNULL(((info.cant_2 * 100)/info.trim_2),0) as por_2,IFNULL(((info.cant_3 * 100)/info.trim_3),0) as por_3,IFNULL(((info.cant_4 * 100)/info.trim_4),0) as por_4 FROM 
							(SELECT r.idreporte_reg,tp.descripcion as tipo_operacion,fm.descripcion as frec_medicion,r.descripcion,r.unidad_medida,r.prog_anual,r.trim_1,r.trim_2,r.trim_3,r.trim_4,IFNULL(m1.cant_1,0) cant_1,IFNULL(m2.cant_2,0) cant_2,IFNULL(m3.cant_3,0) cant_3,IFNULL(m4.cant_4,0) cant_4,r.observaciones as obs1,r.obs2,r.obs3,r.obs4,r.no_accion,r.denominacion FROM ui_reporte re
								inner join ui_reporte_reg r  on r.idreporte = re.idreporte
									left join ui_tipo_operacion tp on tp.idtipo_operacion = r.idtipo_operacion
                                    left join ui_frecuencia_medicion fm on fm.idfrecuencia_medicion = r.idfrecuencia_medicion
								left join (select sum(rm.cantidad) as cant_1,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (1,2,3) group by rm.idreporte_reg) m1 on m1.idreporte_reg = r.idreporte_reg
								left join (select sum(rm.cantidad) as cant_2,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (4,5,6) group by rm.idreporte_reg) m2 on m2.idreporte_reg = r.idreporte_reg
								left join (select sum(rm.cantidad) as cant_3,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (7,8,9) group by rm.idreporte_reg) m3 on m3.idreporte_reg = r.idreporte_reg
								left join (select sum(rm.cantidad) as cant_4,rm.idreporte_reg from ui_reporte_mes rm where rm.idmes in (10,11,12) group by rm.idreporte_reg) m4 on m4.idreporte_reg = r.idreporte_reg
								where re.idreporte = {$idr}) AS info) AS qry
								) as sub1) AS sub2");
	}
	public function getRowsInfo($var_trim,$idr){
		$arr_reduce = array();
		$arr_amplia = array();
		$jus_reduce = array();
		$jus_amplia = array();
		$name = self::getRowNameTrim($var_trim);
		$trim = $name['trim'];
		$cant = $name['cant'];
		$por = $name['por'];
		$obs = $name['obs'];
		foreach (self::getReportesRegistrados($idr) as $v) {
			$trimestre = $v->$trim;
			$cantidad = $v->$cant;
			$porcentaje = $v->$por;
			$observacion = $v->$obs;
				if($trimestre == 0 && $cantidad > 0){
					$arr_amplia[] = self::getRowsReporteTrim($v,$var_trim,$trimestre,$cantidad);
					//Verifico que no venga vacio
					if(!empty($observacion)){
						$jus_amplia[] = array("no"=>$v->no_accion,"meta"=>$v->descripcion,"obs"=>$observacion);
					}
				}else if($porcentaje > 110){
					$arr_amplia[] = self::getRowsReporteTrim($v,$var_trim,$trimestre,$cantidad);
					//Verifico que no venga vacio
					if(!empty($observacion)){
						$jus_amplia[] = array("no"=>$v->no_accion,"meta"=>$v->descripcion,"obs"=>$observacion);
					}
				}else if($trimestre > 0 && $cantidad == 0){
					$arr_reduce[] = self::getRowsReporteTrim($v,$var_trim,$trimestre,$cantidad);
					//Verifico que no venga vacio
					if(!empty($observacion)){
						$jus_reduce[] = array("no"=>$v->no_accion,"meta"=>$v->descripcion,"obs"=>$observacion);
					}
				}else if($trimestre > 0 && $porcentaje <= 89.99){
					$arr_reduce[] = self::getRowsReporteTrim($v,$var_trim,$trimestre,$cantidad);
					//Verifico que no venga vacio
					if(!empty($observacion)){
						$jus_reduce[] = array("no"=>$v->no_accion,"meta"=>$v->descripcion,"obs"=>$observacion);
					}
				}
		}
		return array("total"=>count($arr_amplia) + count($arr_reduce),"arr_amplia"=>$arr_amplia,"arr_reduce"=>$arr_reduce,"jus_amplia"=>$jus_amplia,"jus_reduce"=>$jus_reduce);
	}
	public function getControllerCreateFolderGralDos($url){
		if(!is_dir($url)){
			$res = \File::makeDirectory($url, 0777,true);
			chmod($url, 0777);
		}
	}
	public function getQuitarDobleCeros($numero){
		if($numero == null || $numero == ''){
			return '';
		}else{
			return str_replace('.00','',number_format($numero,2));
		}
	}
	public function getNumberFormart($numero){
		if(empty($numero)){
			return '';
		}else{
			return number_format($numero,2);
		}
	}
	public function getCreateDirectoryGeneral($folder){
		if(!is_dir($folder)){ 
			mkdir($folder,0777, true); 
		}
	}
	// Remover letras, comas y otros caracteres no deseados, dejando solo números y puntos decimales
	protected function getClearNumber($entrada){
		 return preg_replace('/[^0-9.]/', '', $entrada);
	}
	public function getUnirTextoSaltosLinea($text){
		// Reemplaza todos los saltos de línea (Windows \r\n, Unix \n, Mac \r) por un espacio
		$cad = preg_replace("/\r\n|\r|\n/", " ", $text);
		// Reemplaza múltiples espacios por uno solo
		$cad = preg_replace("/\s+/", " ", $cad);
		// Quita espacios al inicio y final
		return trim($cad);
	}
	protected function getCatalogosGeneralPbrmd(){
		$frec_medicion = array("Anual","Trimestral","Semestral", "Mensual");
		$tipo_indicador = array("Estratégico","Gestión");
		$dim_atiende = array("Eficacia","Eficiencia","Economía","Calidad");
		$tipo_operacion = array("Sumable","No sumable","Constante","Valor Actual");
		return array("frec_medicion"=>$frec_medicion , "tipo_indicador"=> $tipo_indicador, "dim_atiende"=>$dim_atiende, "tipo_operacion"=>$tipo_operacion);
	}
	//Funcion agregada el 21-09-2024 para agregar 0 a la izquierda
	public function addCerosLEFT($numero, $longitud) {
		return str_pad($numero, $longitud, '0', STR_PAD_LEFT);
	}
	//Construcción del nombre del archivo
	public function getBuildFilenamePDF($abreviatura, $no_institucion, $no_dep_gen, $id){
		/*Se constuye el nombre del archivo:
			PD1A 00101 A00 1214 12863 0024 0000000001
			FSTI 00107 A00 0921 00660 0024 0000000004
			PD1A 		= Modulo
			107  		= Municipio o Institución
			A00  		= Dependencia General
			0921 		= Mes y Día que se genero el PDF
			00660  		= 5 digitos aleatorios
			0024 		= 2 digitos del año con 2 ceros a la izquierda
			0000000004 	= ID de la tabla del PDF, siempre se debe de cumplir 10 digitos
		*/
		$filename = $abreviatura.$this->addCerosLEFT($no_institucion,5).$no_dep_gen.date('md').$this->addCerosLEFT(rand(0, 99999), 5)."00".date('y').$this->addCerosLEFT($id,10);
		return $filename;
	}
	public function getBuildDirectory($no_municipio, $year, $folder1, $folder2){
		/*
			Esto lo realizo por que quiero manejar un estandar de digitos, ap si debe de permanecer por que así se llama la tabla y es muy práctico
			Ejemplo: 
					107/tesoreria/fsti/2025/
		*/
		$directory = "storage/{$no_municipio}/{$folder1}/{$folder2}/{$year}/";
		$full_path = public_path($directory);
		$this->getCreateDirectoryGeneral($full_path);//Create directory if not exist.
		$result = ['full_path' => $full_path, 'directory' => $directory];
		return $result;
	}
	public function getBuildDirectoryGallery($no_municipio, $year, $folder1, $folder2,$id){
		/*
			Esto lo realizo por que quiero manejar un estandar de digitos, ap si debe de permanecer por que así se llama la tabla y es muy práctico
			Ejemplo: 
					107/meta/files/2025/1/
			15-03-2025 Lo uso para poder dividir por trimestre
		*/
		$directory = "storage/{$no_municipio}/{$folder1}/{$folder2}/{$year}/{$id}/";
		$full_path = public_path($directory);
		$this->getCreateDirectoryGeneral($full_path);//Create directory if not exist.
		$result = ['full_path' => $full_path, 'directory' => $directory];
		return $result;
	}
	public function getInsertTablePlan($idinstitucion,$number,$full_path, $url){
		$size = $this->getSizeFiles($full_path);
		$data = ["idinstituciones"=>$idinstitucion, 
				"number"=>$number, 
				"url"=> $url,
				"ext"=> "pdf",
				"size" => $size['size'],
				"bytes" => $size['bytes'],
				"iduser"=> \Auth::user()->id,
				"std_delete" => 1
			];
		\DB::table("ui_plan_pdf")->insertGetId($data);
	}
	//Creado 05-06-2025, checar para eliminar el de sximo
	public  function updatePlanPDFNew($number)
	{
		$row = \DB::table('ui_plan_pdf')
			->where('number', $number)
			->update(['std_delete' => 2]);
	}
	public function getSplitDate($fecha){
		$dia = $mes = $year = "";
		if(!empty($fecha)){
			$fs = explode("-", $fecha);
			$dia = $fs[2];
			$mes = $fs[1];
			$year = $fs[0];
		}
		$data = ['dia' => $dia, 'mes' => $mes, 'year' => $year];
		return $data;
	}
	public function getEstatusGeneral(){
		return array("1" => "Activo", "2" => "Inactivo");
	}
	/* 
	 	*	
		Meses del año
	*/
	public function getDataMeses($idmes) {
		$data = [
			'1' => 'ENERO',
			'2' => 'FEBRERO',
			'3' => 'MARZO',
			'4' => 'ABRIL',
			'5' => 'MAYO',
			'6' => 'JUNIO',
			'7' => 'JULIO',
			'8' => 'AGOSTO',
			'9' => 'SEPTIEMBRE',
			'10' => 'OCTUBRE',
			'11' => 'NOVIEMBRE',
			'12' => 'DICIEMBRE'
		];
		return $data[$idmes];
	}
	public function getColorTrimestre($trim){
		$data = ['1'=>'bg-yellow-meta', '2'=>'bg-green-meta','3'=>'bg-blue-meta','4'=>'bg-red-meta'];
		return $data[$trim];
	}
	public function getControllerMassDecimales($numero=0) {
		if (strpos($numero, '.') !== false) {
			$numero_formateado = number_format($numero, 2);
		}else{
			$numero_formateado = number_format($numero, 0, '.', ',');
		}
		return $numero_formateado;
	}
	public static function getEliminarSaltosDeLinea($texto) {
		// Eliminar saltos de línea (\n, \r, \r\n)
		return trim(str_replace(["\r\n", "\n", "\r"], ' ', $texto));
	}
	function getGenerarColorAleatorio() {
		return '#' . str_pad(dechex(mt_rand(0, 16777215)), 6, '0', STR_PAD_LEFT);
	}
}
