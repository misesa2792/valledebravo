@extends('layouts.app')

@section('content')
	<main class="page-content row bg-body">

		<section class="page-header bg-body">
			<div class="page-title">
			  <h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
			</div>
	  
			<ul class="breadcrumb bg-body s-20">
				  <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
				  <li><a href="{{ URL::to('subcapitulos?return='.$return) }}">{{ $pageTitle }}</a></li>
				  <li class="active">{{ Lang::get('core.addedit') }} </li>
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

	{!! Form::open(array('url'=>'subcapitulos/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
		<div class="col-md-12">
			{!! Form::hidden('idteso_subcapitulos', $row['idteso_subcapitulos'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
				
			<div class="form-group m-t-md">
				<label for="Idteso Capitulos" class=" control-label col-md-4 text-left s-14 c-text"> Capítulo: </label>
				<div class="col-md-6">
					<select name="idteso_capitulos" class="form-control">
						<option value="">--Select Please--</option>
						@foreach ($capitulos as $c)
							<option value="{{ $c->id }}" @if($row['idteso_capitulos'] == $c->id) selected @endif>{{ $c->clave }} {{ $c->capitulo }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="Clave" class=" control-label col-md-4 text-left s-14 c-text"> Clave: </label>
				<div class="col-md-6">
					{!! Form::text('clave', $row['clave'],array('class'=>'form-control', 'placeholder'=>'Clave', 'required')) !!}
				</div>
			</div> 

			<div class="form-group">
				<label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text"> Subcapítulo: </label>
				<div class="col-md-6">
					{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Subcapítulo', 'required')) !!}
				</div>
			</div> 

			<div class="form-group">
				<label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text"> Objetivo: </label>
				<div class="col-md-6">
					{!! Form::text('objetivo', $row['objetivo'],array('class'=>'form-control', 'placeholder'=>'objetivo', )) !!}
				</div>
			</div> 
		</div>

		<div style="clear:both"></div>	
					
		<div class="form-group">
			<div class="col-sm-12 text-center m-t-lg m-b-lg">	
				<button type="button" onclick="location.href='{{ URL::to('subcapitulos?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
				<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
			</div>	  
		</div> 
	{!! Form::close() !!}

	</div>
</div>		 
</div>	
</main>			 
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