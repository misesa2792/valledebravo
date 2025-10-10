@extends('layouts.app')


@section('content')

  <div class="page-content row bg-body">
    <!-- Page header -->
    <div class="page-header bg-body">
      <div class="page-title">
        <h3 class="fun"> {{ CNF_APPNAME }}  <small>{{ Lang::get('core.t_generalsettingsmall') }}</small></h3>
      </div>
	  
	 
	  <ul class="breadcrumb bg-body">
		<li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li>{{ Lang::get('core.t_generalsetting') }}</li>
	  </ul>	  
	 
    </div>
 	<div class="page-content-wrapper">   
	@if(Session::has('message'))
	  
		   {{ Session::get('message') }}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		
<div class="block-content">
	@include('sximo.config.tab')	
<div class="tab-content m-t">
  <div class="tab-pane active use-padding" id="info">	
  <div class="sbox  "> 
  <div class="sbox-title"></div>
  <div class="sbox-content"> 
		 {!! Form::open(array('url'=>'sximo/config/save/', 'class'=>'form-horizontal row', 'files' => true)) !!}

		<div class="col-sm-6 animated fadeInRight ">
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appname') }} </label>
			<div class="col-md-8">
			<input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm" required  value="{{ CNF_APPNAME }}" />  
			 </div> 
		  </div>  
		  
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appdesc') }} </label>
			<div class="col-md-8">
			<input name="cnf_appdesc" type="text" id="cnf_appdesc" class="form-control input-sm" value="{{ CNF_APPDESC }}" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_comname') }} </label>
			<div class="col-md-8">
			<input name="cnf_comname" type="text" id="cnf_comname" class="form-control input-sm" value="{{ CNF_COMNAME }}" />  
			 </div> 
		  </div>  
		  
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">Nombre responsable de tesorería</label>
			<div class="col-md-8">
				<input name="cnf_tesoreria" type="text" id="cnf_tesoreria" class="form-control input-sm" required  value="{{ UIPPE_SECRETARIO }}" />  
			 </div> 
		  </div>  
		  
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">Nombre de titular de la UIPPE o equivalente</label>
			<div class="col-md-8">
			<input name="cnf_uippe" type="text" id="cnf_uippe" class="form-control input-sm" value="{{ UIPPE_TITULAR }}" required/> 
			 </div> 
		  </div>  

		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_emailsys') }} </label>
			<div class="col-md-8">
			<input name="cnf_email" type="text" id="cnf_email" class="form-control input-sm" value="{{ CNF_EMAIL }}" /> 
			 </div> 
		  </div>   
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4"> Muliti language <br /> <small> Only Layout Interface </small> </label>
			<div class="col-md-8">
				<div class="checkbox">
					<input name="cnf_multilang" type="checkbox" id="cnf_multilang" value="1"
					@if(CNF_MULTILANG ==1) checked @endif
					  />  {{ Lang::get('core.fr_enable') }} 
				</div>	
			 </div> 
		  </div> 
		     
		   <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_mainlanguage') }} </label>
			<div class="col-md-8">

					<select class="form-control" name="cnf_lang">

					@foreach(SiteHelpers::langOption() as $lang)
						<option value="{{  $lang['folder'] }}"
						@if(CNF_LANG ==$lang['folder']) selected @endif
						>{{  $lang['name'] }}</option>
					@endforeach
				</select>
			 </div> 
		  </div>   
		      

		   <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_fronttemplate') }} </label>
			<div class="col-md-8">

					<select class="form-control" name="cnf_theme">
					@foreach(SiteHelpers::themeOption() as $t)
						<option value="{{  $t['folder'] }}"
						@if(CNF_THEME ==$t['folder']) selected @endif
						>{{  $t['name'] }}</option>
					@endforeach
				</select>
			 </div> 
		  </div> 

		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_develmode') }}   </label>
			<div class="col-md-8">
				<div class="checkbox">
					<input name="cnf_mode" type="checkbox" id="cnf_mode" value="1"
					@if (defined('CNF_MODE') &&  CNF_MODE =='production') checked @endif
					  />  {{ Lang::get('core.fr_production') }}
				</div>
				<small> {{ Lang::get('core.fr_debugmsg') }} </small>	
			 </div> 
		  </div> 		  
		  
		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }} </button>
			 </div> 
		  </div> 
		</div>

		<div class="col-sm-6 animated fadeInRight ">

		  <div class="form-group">
		    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_metakey') }} </label>
			<div class="col-md-8">
				<textarea class="form-control input-sm" name="cnf_metakey">{{ CNF_METAKEY }}</textarea>
			 </div> 
		  </div> 

		   <div class="form-group">
		    <label  class=" control-label col-md-4">{{ Lang::get('core.fr_metadesc') }}</label>
			<div class="col-md-8">
				<textarea class="form-control input-sm"  name="cnf_metadesc">{{ CNF_METADESC }}</textarea>
			 </div> 
		  </div>  

		   <div class="form-group">
		    <label  class=" control-label col-md-4">Logo</label>
			<div class="col-md-8">
				<input type="file" name="logo">
				<p> <i>Please use image dimension 155px * 30px </i> </p>
				<div style="padding:5px;width:auto;" class="bg-white">
				 	@if(file_exists(public_path().'/sximo/images/'.CNF_LOGO) && CNF_LOGO !='')
				 		<img src="{{ asset('sximo/images/'.CNF_LOGO)}}" alt="{{ CNF_APPNAME }}" />
				 	@else
						<img src="{{ asset('images/no-image.png')}}" alt="{{ CNF_APPNAME }}" />
					@endif	
				</div>				
			 </div> 
		  </div>  		  

		</div>  
		 {!! Form::close() !!}
	</div>
	</div>	 
</div>
</div>
</div>
</div>








@stop