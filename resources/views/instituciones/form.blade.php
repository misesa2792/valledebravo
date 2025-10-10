<form id="saveInfo" method="post" class="form-horizontal" files="true">
	<div class="form-group m-t-md" >
		<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Tipo de organismo: </label>
		<div class="col-md-6">
			<select name="idtipo_dependencias" class="select2 full-width" required>
				<option value="">--Select Please--</option>
				@foreach ($rowsOrganismos as $m)
					<option value="{{ $m->id }}" @if($m->id == $row['idtipo_dependencias']) selected @endif>{{ $m->nombre }}</option>
				@endforeach
			</select>
		</div>
	</div> 

	<div class="form-group m-t-md" >
		<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Denóminación: </label>
		<div class="col-md-6">
			{!! Form::text('denominacion', $row['denominacion'],array('class'=>'form-control', 'placeholder'=>'Denóminación', 'required')) !!}
		</div>
	</div> 

	<div class="form-group m-t-md" >
		<label for="Descripcion" class=" control-label col-md-4 text-left s-16"> Nombre del organismo: </label>
		<div class="col-md-6">
			{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa nombre del organismo para Formatos PbRM','required')) !!}
		</div>
	</div> 

	<div style="clear:both"></div>

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
		<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
	</article>
</form>

<script>
	$(".select2").select2();
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to($pageModule.'/save?idm='.$idm) }}", {
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