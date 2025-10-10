@extends('layouts.app')

@section('content')

<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary"> {{ $pageTitle }} <small class="s-12"> <i>{{ $pageNote }} </i></small></h3>
		</div>

		<ul class="breadcrumb bg-body s-14">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-16"></i> </a></li>
			<li><a href="{{ URL::to($pageModule.'?return='.$return) }}"><i>{{ $pageTitle }}</i></a></li>
        	<li class="active"><i>{{ Lang::get('core.addedit') }}</i></li>
		</ul>		  
	</section>


 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
	<div class="sbox-content"> 	

	{!! Form::open(array('url'=>'municipios/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
	<div class="col-md-12 m-t-md">
		{!! Form::hidden('idmunicipios', $row['idmunicipios'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									
		<div class="form-group  " >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Municipio: </label>
			<div class="col-md-6">
				<input type="text" name="descripcion" value="{{ $row['descripcion'] }}" id="textoInput" class="form-control" placeholder="Ingresa nombre del municipio" required oninput="convertirAMayusculas()">
			</div>
		</div>


		<div class="form-group">
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Número: </label>
			<div class="col-md-6">
				<input type="text" name="numero" value="{{ $row['numero'] }}" class="form-control" placeholder="Número" required>
			</div>
		</div>

		<div class="form-group">
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Estatus: </label>
			<div class="col-md-6">
				<select name="active" class="form-control" required>
					<option value="">--Select Please--</option>
					@foreach ($estatus as $key => $e)
						<option value="{{ $key }}" @if($row['active'] == $key) selected @endif>{{ $e }}</option>
					@endforeach
				</select>
			</div>
		</div>

	</div>
		
	<div style="clear:both"></div>	
				
	<div class="form-group">
		<div class="col-sm-12 text-center m-t-lg m-b-lg">	
			<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
			<button type="button" onclick="location.href='{{ URL::to('municipios?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
		</div>	  
	</div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
<style>

</style>
</main>			 
   <script type="text/javascript">
   function convertirAMayusculas() {
		let input = document.getElementById("textoInput");
		input.value = input.value.toUpperCase();
	}
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