<form id="saveInfo" method="post" class="form-horizontal">

  <div class="col-md-12">

      <div class="form-group">
        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Nombre(s) :</label>
        <div class="col-md-8">
          {!! Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'Ingresa nombre','required','onkeyup'=>"mayus(this);" )) !!}
         </div>
      </div>
  
      <div class="form-group">
        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Apellido Paterno :</label>
        <div class="col-md-8">
          {!! Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa apellido paterno','required','onkeyup'=>"mayus(this);")) !!}
         </div>
      </div>
  
  
      <div class="form-group">
        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Apellido Materno :</label>
        <div class="col-md-8">
          {!! Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa apellido materno','onkeyup'=>"mayus(this);","required"  )) !!}
         </div>
      </div>

      <div class="form-group  " >
        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Correo Electrónico : </label>
        <div class="col-md-8">
          {!! Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'example@hotmail.com', 'required'  )) !!}
        </div>
      </div>
  
      <div class="form-group">
          <label for="Password" class=" control-label col-md-4 text-left s-16 c-text-alt"> Contraseña : </label>
          <div class="col-md-8">
              <small class="var">Deja en blanco si no quieres cambiar tu contraseña actual </small>
              <input type="password" class="form-control" placeholder="***************" name="password">
           </div>
      </div>

		<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
			<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
			<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
		</article>
</form>

 <script type="text/javascript">
 function mayus(e) {
    e.value = e.value.toUpperCase();
 }
 
 $(".mySelect2").select2();
 $("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to('usuarios/informacion?id='.$id) }}", {
		type: 'post',
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){
			$(".btnsave").prop("disabled",true).html(btnSaveSpinner);
		},success: function(res){
			let row = JSON.parse(res);
			if(row.status == 'ok'){
				$("#sximo-modal").modal("toggle");
				query();
				toastr.success(row.message);
			}else{
				toastr.error(mss_tmp.error);
			}
			$(".btnsave").prop("disabled",false).html(btnSave);
		}, error : function(err){
			toastr.error(mss_tmp.error);
			$(".btnsave").prop("disabled",false).html(btnSave);
		}
	});
});
 </script>
