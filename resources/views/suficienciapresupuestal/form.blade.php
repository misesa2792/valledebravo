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
		<li><a href="{{ URL::to('suficienciapresupuestal?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		 {!! Form::open(array('url'=>'suficienciapresupuestal/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Solicitud de suficiencia presupuestal</legend>
				
								  <div class="form-group  " >
									<label for="Idteso Suficiencia Pres" class=" control-label col-md-4 text-left"> Idteso Suficiencia Pres </label>
									<div class="col-md-6">
									  {!! Form::text('idteso_suficiencia_pres', $row['idteso_suficiencia_pres'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Type" class=" control-label col-md-4 text-left"> Type </label>
									<div class="col-md-6">
									  {!! Form::text('type', $row['type'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Fecha Elaboracion" class=" control-label col-md-4 text-left"> Fecha Elaboracion </label>
									<div class="col-md-6">
									  {!! Form::text('fecha_elaboracion', $row['fecha_elaboracion'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Folio" class=" control-label col-md-4 text-left"> Folio </label>
									<div class="col-md-6">
									  {!! Form::text('folio', $row['folio'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Idarea Coordinacion" class=" control-label col-md-4 text-left"> Idarea Coordinacion </label>
									<div class="col-md-6">
									  {!! Form::text('idarea_coordinacion', $row['idarea_coordinacion'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Idproyecto" class=" control-label col-md-4 text-left"> Idproyecto </label>
									<div class="col-md-6">
									  {!! Form::text('idproyecto', $row['idproyecto'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Tipo Recurso" class=" control-label col-md-4 text-left"> Tipo Recurso </label>
									<div class="col-md-6">
									  {!! Form::text('tipo_recurso', $row['tipo_recurso'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Observaciones" class=" control-label col-md-4 text-left"> Observaciones </label>
									<div class="col-md-6">
									  {!! Form::text('observaciones', $row['observaciones'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Fecha Requerida" class=" control-label col-md-4 text-left"> Fecha Requerida </label>
									<div class="col-md-6">
									  {!! Form::text('fecha_requerida', $row['fecha_requerida'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 </div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div> </fieldset></div>

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<div class="col-sm-12 text-center m-t-lg m-b-lg">	
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('suficienciapresupuestal?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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