@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('download?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
	<div class="sbox-content"> 	

		 {!! Form::open(array('url'=>'download/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Download PDF</legend>
				
								  <div class="form-group  " >
									<label for="Idplan Pdf" class=" control-label col-md-4 text-left"> Idplan Pdf </label>
									<div class="col-md-6">
									  {!! Form::text('idplan_pdf', $row['idplan_pdf'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Idinstituciones" class=" control-label col-md-4 text-left"> Idinstituciones </label>
									<div class="col-md-6">
									  {!! Form::text('idinstituciones', $row['idinstituciones'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Number" class=" control-label col-md-4 text-left"> Number </label>
									<div class="col-md-6">
									  {!! Form::text('number', $row['number'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Url" class=" control-label col-md-4 text-left"> Url </label>
									<div class="col-md-6">
									  {!! Form::text('url', $row['url'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Ext" class=" control-label col-md-4 text-left"> Ext </label>
									<div class="col-md-6">
									  {!! Form::text('ext', $row['ext'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Size" class=" control-label col-md-4 text-left"> Size </label>
									<div class="col-md-6">
									  {!! Form::text('size', $row['size'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Bytes" class=" control-label col-md-4 text-left"> Bytes </label>
									<div class="col-md-6">
									  {!! Form::text('bytes', $row['bytes'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Fecha" class=" control-label col-md-4 text-left"> Fecha </label>
									<div class="col-md-6">
									  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('fecha', $row['fecha'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Iduser" class=" control-label col-md-4 text-left"> Iduser </label>
									<div class="col-md-6">
									  {!! Form::text('iduser', $row['iduser'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Std Delete" class=" control-label col-md-4 text-left"> Std Delete </label>
									<div class="col-md-6">
									  {!! Form::text('std_delete', $row['std_delete'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> </fieldset></div>

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<div class="col-sm-12 text-center m-t-lg m-b-lg">	
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('download?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop