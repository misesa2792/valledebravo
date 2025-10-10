@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li class="active">{{ $pageTitle }}</li>
      </ul>	  
	  
    </div>
	
	
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
	   		<a href="{{ URL::to('ods/update') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa fa-plus-circle fun"></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>
			@endif  
			@if($access['is_remove'] ==1)
			<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
			<i class="fa fa-minus-circle var"></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
			@endif 		
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('ods/download') }}" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-download str"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
			@endif			
		 
		</div> 		

	
	
	 {!! Form::open(array('url'=>'ods/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
		<thead>
			<tr class="t-tr-s14">
				<th class="number"> No </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th>Imagen</th>
				<th>ODS</th>
				<th width="70" >{{ Lang::get('core.btn_action') }}</th>
			  </tr>
        </thead>

        <tbody>
            @foreach ($rowData as $row)
				<tr class="t-tr-s14">
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->idods }}" />  </td>									
					<td>
						<img src="{{ asset('images/ods/'.$row->avatar) }}" alt="{{ $row->descripcion }}" width="40" height="40">
					</td>
					<td>{{ $row->descripcion }}</td>
					<td>
						@if($access['is_edit'] ==1)
							<a  href="{{ URL::to('ods/update/'.$row->idods.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
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
</div>	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("ods/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		
@stop