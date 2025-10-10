@extends('layouts.app')

@section('content')

  <div class="page-content row" id="main-content">
    <!-- Page header -->
    <div class="page-header">

      <div class="page-title">
        <h3> Account  <small>View Detail My Info</small></h3>
      </div>

      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li class="active">Account</li>
      </ul>

	</div>  
		
	<div class="page-content-wrapper m-t">
		@if(Session::has('message'))	  
		   {!! Session::get('message') !!}
		@endif	
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	
		<ul class="nav nav-tabs" >
	  		<li class="active"><a href="#info" data-toggle="tab"> {{ Lang::get('core.personalinfo') }} </a></li>
	  		<li ><a href="#pass" data-toggle="tab">{{ Lang::get('core.changepassword') }} </a></li>
		</ul>	
	
	<div class="tab-content">
	  <div class="tab-pane active m-t" id="info">
		{!! Form::open(array('url'=>'user/saveprofileuser/', 'class'=>'form-horizontal ' ,'files' => true)) !!}  
		<input name="idusuario" style="display: none;" type="text"  class="form-control input-sm"  value="{{ $info->idusuario }}" />  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Usuario : </label>
			<div class="col-md-8">

			<input name="usuario" type="text" id="username" disabled="disabled" class="form-control input-sm" required  value="{{ $info->usuario }}" />  
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Nombre :</label>
			<div class="col-md-8">
			<input name="nombre" type="text" id="nombre" class="form-control input-sm" required value="{{ $info->nombre }}" /> 
			 </div> 
		  </div>

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Apellido Paterno :</label>
			<div class="col-md-8">
			<input name="appaterno" type="text" id="appaterno" class="form-control input-sm" required value="{{ $info->appaterno }}" /> 
			 </div> 
		  </div>  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Apellido Materno :</label>
			<div class="col-md-8">
			<input name="apmaterno" type="text" id="apmaterno" class="form-control input-sm" required value="{{ $info->apmaterno }}" /> 
			 </div> 
		  </div>    
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Email : </label>
			<div class="col-md-8">
			<input name="mail" type="text" id="mail" class="form-control input-sm" required value="{{ $info->mail }}" />  
			 </div> 
		  </div>

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Zona : </label>
			<div class="col-md-8">
			<input name="idzona" type="text" disabled="disabled" id="mail" class="form-control input-sm" required value="{{ $regiones->zona }}" />  
			 </div> 
		  </div>

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Nivel : </label>
			<div class="col-md-8">
			<input name="idnivel" type="text" disabled="disabled" id="mail" class="form-control input-sm" required value="{{ $niveles->nivel }}" />  
			 </div> 
		  </div> 
	
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-success" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
			 </div> 
		  </div> 	
		
		{!! Form::close() !!}	
	  </div>
  
	  <div class="tab-pane  m-t" id="pass">
		{!! Form::open(array('url'=>'user/savepassworduser/', 'class'=>'form-horizontal ')) !!}    
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }} </label>
			<div class="col-md-8">
			<input name="password" type="password" id="password" class="form-control input-sm" value="" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }}  </label>
			<div class="col-md-8">
			<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />  
			 </div> 
		  </div>    
		 
		
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-danger" type="submit"> {{ Lang::get('core.sb_savechanges') }} </button>
			 </div> 
		  </div>   
		{!! Form::close() !!}	
	  </div>







</div>
</div>
 
 </div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("empleados/multisearch")}}');
		$('#SximoTable').submit();
	});

});

</script>
<script type="text/javascript">

  new Vue({

      el: '#main-content',
      data: {
      },
      ready: function(){
      },

      methods : {

        sximoAddFiles: function(e){
          e.preventDefault();
          var url_to = $("#add-files").attr('href');

          $('.sximo-modal-add-files-content').html(' ....Loading content , please wait ...');
        	$('.sximo-modal-add-files-title').html("Archivos");
        	$('.sximo-modal-add-files-content').load(url_to,function(){

        		$('#sximo-modal-add-files').modal('show');

        	});
        }
      }

  });




</script>

@endsection