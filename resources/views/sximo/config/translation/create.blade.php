 {!! Form::open(array('url'=>'sximo/config/addtranslation/', 'class'=>'form-horizontal ','parsley-validate'=>'','novalidate'=>' ')) !!}
 <div class="row">
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_langname') }} </label>
	<div class="col-md-8">
	<input name="name" type="text" id="name" class="form-control input-sm" value="" required="true" /> 
	 </div> 
  </div>   	
 
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_foldername') }} </label>
	<div class="col-md-8">
	<input name="folder" type="text" id="folder" class="form-control input-sm" value="" required /> 
	 </div> 
  </div>   	
  
   <div class="form-group">
    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.fr_author') }} </label>
	<div class="col-md-8">
	<input name="author" type="text" id="author" class="form-control input-sm" value="" required /> 
	 </div> 
  </div>   	
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">  </label>
	<div class="col-md-8">
		<button type="submit" name="submit" class="btn btn-info"> {{ Lang::get('core.btn_addlang') }}</button>
	</div> 
  </div>  
  </div> 	    
 
 {!! Form::close() !!}