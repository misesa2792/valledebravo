<?php
	if(Auth::user()->group_id == 1){
		$tabs = array(
			'' 		=> Lang::get('core.tab_siteinfo'),
			'email'			=> Lang::get('core.tab_email'),
			'security'		=> Lang::get('core.tab_loginsecurity') ,
			'translation'	=> Lang::get('core.tab_translation'),
			'log'			=> Lang::get('core.tab_clearcache')
		);
	}else{
		$tabs = array(
			'' 		=> Lang::get('core.tab_siteinfo'),
		);
	}
?>

<ul class="nav nav-tabs" >
@foreach($tabs as $key=>$val)
	<li  @if($key == $active) class="active" @endif><a href="{{ URL::to('sximo/config/'.$key)}}"> {{ $val }}  </a></li>
@endforeach

</ul>