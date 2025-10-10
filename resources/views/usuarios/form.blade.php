<form id="saveInfo" method="post" class="form-horizontal">

  <article class="col-md-12">

      <div class="form-group">

        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Nivel<i class="var"> *</i> :</label>

        <div class="col-md-8">

          <select name="group_id" class="form-control" required>

            <option value="">--Select Please--</option>

            @foreach ($rowsNivel as $v)

              <option value="{{ $v->id }}">{{$v->nivel}}</option>

            @endforeach

          </select>

        </div>

      </div>



      <div class="form-group">

        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Nombre(s)<i class="var"> *</i> :</label>

        <div class="col-md-8">

          {!! Form::text('username', '',array('class'=>'form-control', 'placeholder'=>'Ingresa nombre','required','onkeyup'=>"mayus(this);" )) !!}

         </div>

      </div>

  

      <div class="form-group">

        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Apellido Paterno<i class="var"> *</i> :</label>

        <div class="col-md-8">

          {!! Form::text('first_name', '',array('class'=>'form-control', 'placeholder'=>'Ingresa apellido paterno','required','onkeyup'=>"mayus(this);")) !!}

         </div>

      </div>

  

  

      <div class="form-group">

        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Apellido Materno<i class="var"> *</i> :</label>

        <div class="col-md-8">

          {!! Form::text('last_name', '',array('class'=>'form-control', 'placeholder'=>'Ingresa apellido materno','onkeyup'=>"mayus(this);","required"  )) !!}

         </div>

      </div>

  

      <div class="form-group  " >

        <label class=" control-label col-md-4 text-left s-16 c-text-alt"> Correo Electrónico<i class="var"> *</i> : </label>

        <div class="col-md-8">

          {!! Form::text('email', '',array('class'=>'form-control', 'placeholder'=>'example@hotmail.com', 'required'  )) !!}

        </div>

      </div>

  

      <div class="form-group">

          <label for="Password" class=" control-label col-md-4 text-left s-16 c-text-alt"> Contraseña<i class="var"> *</i> : </label>

          <div class="col-md-6">

              <input type="password" class="form-control" placeholder="***************" name="password" required>

           </div>

      </div>



      <div class="form-group">

				<label for="Avatar" class=" control-label col-md-4 text-left s-16 c-text-alt"> Avatar </label>

				<div class="col-md-6">

					<input  type='file' name='avatar' id='avatar' class="form-control" accept=".jpg, .jpeg, .png" />

				</div> 

			</div> 

    </article>



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

    $.ajax("{{ URL::to($pageModule.'/save') }}", {

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

        if(row.success == 'ok'){

          $("#sximo-modal").modal("toggle");

          query();

          toastr.success(mss_tmp.success);

        }else if(row.success == 'duplicate'){

          toastr.error("El correo que intentas agregar ya existe!");

        }else if(row.success == 'institucion'){

          toastr.error("Selecciona acceso a una institución!");

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

