{!! Form::open(array('url'=>'usuarios/save?return='.$return, 'class'=>'form-horizontal','files' => true ,"autocomplete"=>"off")) !!}
  <div class="col-md-12">
    {!! Form::hidden('id', $row['id'],array('class'=>'form-control',)) !!}
    {!! Form::hidden('group_id', 3,array('class'=>'form-control')) !!}
    <div class="form-group">
			<div class="col-md-12 text-center m-b">
        {!! SiteHelpers::avatarUser($row['id'],150) !!}
			 </div>
       <div class="col-md-3"></div>
       <div class="col-md-6">
         <div class="fileinput fileinput-new full-width" data-provides="fileinput">
             <div class="btn btn-primary btn-file full-width" style="background:transparent;color:#5e40b8;border-radius:5px;">
               <span class="fileinput-new"> <i class="icon-images"></i> &nbsp; Agregar avatar</span><span class="fileinput-exists">Cambiar</span>
             <input type="file" name="avatar">
           </div>
             <span class="fileinput-filename"></span>
             <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
         </div>
       </div>
       <div class="col-md-3"></div>
		</div>

    <div class="col-md-6">
      <div class="form-group">
        <label class=" control-label col-md-4 text-left"> Nombre </label>
        <div class="col-md-8">
          {!! Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'Ingresa nombre','required','onkeyup'=>"mayus(this);" )) !!}
         </div>
      </div>
  
      <div class="form-group">
        <label class=" control-label col-md-4 text-left"> Apellido paterno </label>
        <div class="col-md-8">
          {!! Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa apellido paterno','required','onkeyup'=>"mayus(this);")) !!}
         </div>
      </div>
  
  
      <div class="form-group">
        <label class=" control-label col-md-4 text-left"> Apellido Materno </label>
        <div class="col-md-8">
          {!! Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa apellido materno','onkeyup'=>"mayus(this);"  )) !!}
         </div>
      </div>
  
      <div class="form-group">
        <label class="control-label col-md-4 text-left"> Estatus </label>
        <div class="col-md-8">
            <select class="form-control" name="active" required>
              <option value="1"  @if(1 == $row['active']) selected @endif >Activo</option>
              <option value="0"  @if(0 == $row['active']) selected @endif >Inactivo</option>
            </select>
        </div>
      </div>
  
      <div class="form-group  " >
        <label class=" control-label col-md-4 text-left "> Email </label>
        <div class="col-md-8">
          {!! Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'example@hotmail.com', 'required'  )) !!}
        </div>
      </div>
  
      <div class="form-group">
          <label for="Password" class=" control-label col-md-4 text-left "> Contraseña </label>
          <div class="col-md-8">
              <input type="password" class="form-control" placeholder="***************" name="password">
           </div>
      </div>
    </div>

    <div class="col-md-6 table-resp" style="height:450px;">
      <table class="table table-bordered">
        <tr>
          <th width="30">#</th>
          <th width="30"></th>
          <th>Área</th>
          <th>Coordinación</th>
        </tr>
        @foreach($enlace as $g)
          <tr>
            <td>{{ $j++ }}</td>
            <td>
              <input type="checkbox" name="idac[]" value="{{ $g->idac }}" @if($g->total > 0) checked @endif>
            </td>
            <td>{{$g->area}}</td>
            <td>{{ $g->coordinacion }}</td>
          </tr>
        @endforeach
      </table>
    </div>

    <div class="form-group">
      <div class="col-sm-12 text-center">
          <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
          <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
      </div>
    </div>

	</div>

	<div style="clear:both"></div>
 {!! Form::close() !!}

 <script type="text/javascript">
 function mayus(e) {
    e.value = e.value.toUpperCase();
 }
 $(".mySelect").select2();
 $(".sltnivel").click(function(e){
    e.preventDefault();
    let id = $(this).val();
    if(id == 3){
      $(".div_enlace").css({"display":"block"});
    }else{
      $(".div_enlace").css({"display":"none"});
    }
 })
 </script>
