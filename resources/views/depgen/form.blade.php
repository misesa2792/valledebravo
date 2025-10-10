<form id="saveInfo" method="post" class="form-horizontal">
	<div class="col-md-12">
		{!! Form::hidden('iddep_gen', $row['iddep_gen'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		{!! Form::hidden('idanio', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
					
		<div class="form-group">
			<label for="Idtipo Dependencias" class=" control-label col-md-4 text-left s-14 c-text-alt"> Tipo de Dependencia: </label>
			<div class="col-md-6">
				<select name="idtipo_dependencias" class="form-control" required>
					<option value="">--Select please--</option>
					@foreach($rowsTipo as $v)
						<option value="{{ $v->id }}" @if($v->id == $row['idtipo_dependencias']) selected @endif>{{ $v->abreviatura }}</option>
					@endforeach
				</select>
			</div>
		</div> 

		<div class="form-group">
			<label for="Numero" class=" control-label col-md-4 text-left s-14 c-text-alt"> No. Dependencia: </label>
			<div class="col-md-6">
				{!! Form::text('numero', $row['numero'],array('class'=>'form-control', 'placeholder'=>'No. Dependencia','required' )) !!}
			</div>
		</div> 

		<div class="form-group">
			<label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text-alt"> Dependencia: </label>
			<div class="col-md-6">
				{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Dependencia', 'required')) !!}
			</div>
		</div>
				
	</div>

	<div style="clear:both"></div>	

	<div class="form-group">
		<div class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
			<button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
			<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
		</div>
	</div> 
</form>

<script>
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