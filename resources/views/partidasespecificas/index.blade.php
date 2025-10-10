@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
		  <h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
		</div>
  
		<ul class="breadcrumb bg-body s-20">
		  <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
		  <li> {{ $pageTitle }} </li>
		</ul>	  
	</section>
	
	
	<div class="page-content-wrapper m-t">	 	

<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h5> <i class="fa fa-table"></i> {{ $pageTitle }}</h5>
<div class="sbox-tools" >
		@if(Session::get('gid') ==1)
			<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
		@endif 
		</div>
	</div>
	<div class="sbox-content"> 	
	    <div class="toolbar-line ">
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('partidasespecificas/update') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa fa-plus-circle fun"></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-minus-circle var"></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
			@endif 		
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('partidasespecificas/download') }}" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-download str"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
			@endif			
		 
		</div> 		

	
	
	 {!! Form::open(array('url'=>'partidasespecificas/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
        <thead>
			<tr class="t-tr-s14" >
				<th class="number"> No </th>
				<th><input type="checkbox" class="checkall" /></th>
				<th>Año</th>
				<th>Partida Generica</th>
				<th>Clave</th>
				<th>Partida Específica</th>
				<th>Descripción</th>
				<th width="70" >{{ Lang::get('core.btn_action') }}</th>
			  </tr>
        </thead>

        <tbody>
			<tr class="t-tr-s14" id="sximo-quick-search" >
				<td class="number"> # </td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<input type="hidden"  value="Search">
					<button type="button"  class=" do-quick-search btn btn-xs btn-info"> GO</button>
				</td>
			 </tr>	        
						
            @foreach ($rowData as $row)
                <tr class="t-tr-s14">
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->idteso_partidas_esp }}" />  </td>									
					<td>{{ $row->anio }}</td>
					<td>{{ $row->no_partida_generica }} {{ $row->partida_generica }}</td>
					<td>{{ $row->clave }}</td>
					<td>{{ $row->nombre }}</td>
					<td>{{ $row->descripcion }}</td>
					<td>
						@if($access['is_edit'] ==1)
							<a  href="{{ URL::to('partidasespecificas/update/'.$row->idteso_partidas_esp.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
						@endif
					</td>				 
                </tr>
				
            @endforeach
              
        </tbody>
      
    </table>
	<input type="hidden" name="md" value="" />
	</div>
	{!! Form::close() !!}
	@include('footer')
	</div>
</div>	
	</div>	  
</main>	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("partidasespecificas/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		
@stop