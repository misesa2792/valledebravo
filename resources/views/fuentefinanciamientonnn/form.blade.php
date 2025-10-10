@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
		</div>
	
		<ul class="breadcrumb bg-body s-20">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
			<li><a href="{{ URL::to('fuentefinanciamientonnn?return='.$return) }}">{{ $pageTitle }}</a></li>
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

		{!! Form::open(array('url'=>'fuentefinanciamientonnn/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
		<div class="col-md-12">
			{!! Form::hidden('idteso_ff_n3', $row['idteso_ff_n3'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}

			<div class="form-group m-t-md">
				<label for="Idteso Ff N2" class=" control-label col-md-4 text-left s-14 c-text"> Fuente Financiamiento N2: </label>
				<div class="col-md-6">
					<select name="idteso_ff_n2" class="select2">
						<option value="">--Select Please--</option>
						@foreach ($rowsFuentes as $c)
							<option value="{{ $c->id }}" @if($row['idteso_ff_n2'] == $c->id) selected @endif>{{ $c->clave }} {{ $c->nombre }}</option>
						@endforeach
					</select>
				</div>
			</div> 

			<div class="form-group  " >
				<label for="Clave" class=" control-label col-md-4 text-left s-14 c-text"> Clave: </label>
				<div class="col-md-6">
					{!! Form::text('clave', $row['clave'],array('class'=>'form-control', 'placeholder'=>'Clave', 'required'  )) !!}
				</div>
			</div> 

			<div class="form-group  " >
				<label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text"> Fuente Financiamiento N3: </label>
				<div class="col-md-6">
					{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Fuente Financiamiento N3', 'required' )) !!}
				</div>
			</div>

		</div>

		<div style="clear:both"></div>	
					
		<div class="form-group">
			<div class="col-sm-12 text-center m-t-lg m-b-lg">	
				<button type="button" onclick="location.href='{{ URL::to('fuentefinanciamientonnn?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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