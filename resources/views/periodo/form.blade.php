@extends('layouts.app')

@section('content')

<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-primary s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
		<li><a href="{{ URL::to($pageModule.'?return='.$return) }}">{{ $pageTitle }}</a></li>
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

	{!! Form::open(array('url'=>'periodo/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
		<div class="col-md-12">
			{!! Form::hidden('idperiodo', $row['idperiodo'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									
			<div class="form-group m-t-md" >
				<label for="Descripcion" class=" control-label col-md-4 text-left"> Periodo: </label>
				<div class="col-md-6">
					{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'0000-0000', 'required')) !!}
				</div>
			</div> 
		</div>
		
		<div style="clear:both"></div>	
				
					
		<div class="form-group">
			<div class="col-sm-12 text-center m-t-lg m-b-lg">	
				<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				<button type="button" onclick="location.href='{{ URL::to('periodo?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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