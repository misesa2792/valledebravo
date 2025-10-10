<form id="saveInfo" method="post" class="form-horizontal">
		<div class="col-md-12">
			{!! Form::hidden('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 

			<div class="form-group  " >
				<label for="Group / Level" class=" control-label col-md-3 text-left s-16 c-text-alt"> Nivel <span class="var"> * </span></label>
				<div class="col-md-8">
					<select name='group_id' rows='5' id='group_id' class='select2 full-width' required>
					<option value="">--Select Please--</option>
						@foreach ($groups as $g)
							<option value="{{ $g->group_id }}" @if($g->group_id == $row['group_id']) selected @endif>{{ $g->name }}</option>
						@endforeach
					</select> 
				</div> 
			</div>
			
			<div class="form-group  " >
				<label for="Group / Level" class=" control-label col-md-3 text-left s-16 c-text-alt"> Institución <span class="var"> * </span></label>
				<div class="col-md-8">
					<select name='idinstitucion' id="sltidinstitucion" class='select2 full-width' required>
						<option value="">--Select Please--</option>
						@foreach ($instituciones as $i)
							<option value="{{ $i->id }}" @if($i->id == $row['idinstituciones']) selected @endif>{{ $i->no_institucion.'-'.$i->institucion }}</option>
						@endforeach
					</select> 
				</div> 
			</div>
								   					
			<div class="form-group  " >
				<label for="Username" class=" control-label col-md-3 text-left s-16 c-text-alt"> Nombre(s) <span class="var"> * </span></label>
				<div class="col-md-8">
					{!! Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'Ingresa Nombre(s)', 'required'=>'true'  )) !!} 
				</div> 
			</div> 

			<div class="form-group  " >
				<label for="First Name" class=" control-label col-md-3 text-left s-16 c-text-alt"> Apellido Paterno<span class="var"> * </span></label>
				<div class="col-md-8">
					{!! Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa Apellido Paterno', 'required'=>'true'  )) !!} 
				</div> 
			</div> 		

			<div class="form-group  " >
				<label for="Last Name" class=" control-label col-md-3 text-left s-16 c-text-alt"> Apellido Materno <span class="var"> * </span></label>
				<div class="col-md-8">
					{!! Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'Ingresa Apellido Materno', 'required'=>'true')) !!} 
				</div> 
			</div> 	

			<div class="form-group  " >
				<label for="Email" class=" control-label col-md-3 text-left s-16 c-text-alt"> Correo Electrónico <span class="var"> * </span></label>
				<div class="col-md-8">
					{!! Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'exmaple@gmail.com', 'required'=>'true', 'parsley-type'=>'email'   )) !!} 
				</div> 
			</div> 	
			
			<div class="form-group">
				<label for="ipt" class=" control-label col-md-3 s-16 c-text-alt"> Contraseña @if($row['id'] =='') <span class="var"> * </span> @endif</label>
				<div class="col-md-8">
					@if($row['id'] !='')
						<small class="var">Deja en blanco si no deseas cambiar tu contraseña actual </small>
					@endif
				<input name="password" type="password" id="password" class="form-control input-sm" value="" placeholder="***************"
				@if($row['id'] =='')
					required
				@endif
				 /> 
				 </div> 
			</div>  
					
			@if($estatus == 'new')
				<input type="hidden" name="active" value="1">
			@else
				<div class="form-group">
					<label for="Status" class=" control-label col-md-3 text-left s-16 c-text-alt"> Estatus <span class="var"> * </span></label>
					<div class="col-md-8">
						<label class='radio radio-inline'><input type='radio' name='active' value ='0' required @if($row['active'] == '0') checked="checked" @endif > Inactivo </label>
						<label class='radio radio-inline'><input type='radio' name='active' value ='1' required @if($row['active'] == '1') checked="checked" @endif > Activo </label> 
					</div> 
				</div> 
			@endif

			<div class="form-group  " >
				<label for="Avatar" class=" control-label col-md-3 text-left s-16 c-text-alt"> Avatar </label>
				<div class="col-md-8">
					<input  type='file' name='avatar' id='avatar' @if($row['avatar'] =='') class='required' @endif  class="form-control" accept="image/jpeg, image/png" />

					@if($estatus != 'new')
						<div>{!! SiteHelpers::showUploadedFile($row['avatar'],'/images/operadores/') !!}</div>		
					@endif			
				</div> 
			</div> 
		
		</div>

			
		<div style="clear:both"></div>	
				
		<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
			<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
			<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
		</article>
</form>
<script>
    function obtenerValorData() {
        var select = document.getElementById("sltidmunicipios");
        var opcionSeleccionada = select.options[select.selectedIndex];
		let id = opcionSeleccionada.getAttribute('value');
		if(id != ""){
			axios.get("{{ URL::to('core/users/instituciones') }}",{
				params : {id:id}
			}).then(response =>{
				let rows =response.data;
				
				$("#sltidinstitucion").empty().html('<option value="">--Select Please--</option>');
				for (let i = 0; i < rows.length; i++) {
					$("#sltidinstitucion").append('<option value="'+rows[i].id+'">'+rows[i].municipio+'-'+rows[i].institucion+'</option>');
				}
        		$("#sltidinstitucion").change();
				
			}).catch(error => {
				toastr.error("Error, vuelve a intentar!");
			})
		}
    }


$(".select2").select2();
$("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to('core/users/save') }}", {
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
			}else if(row.success == 'vacio'){
				toastr.warning("Selecciona permiso que se asignarán al usuario!");
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
