<form id="saveInfo" method="post" class="form-horizontal">
	<input type="hidden" name="modulo" value="{{ $modulo }}">
	<div class="form-group">
		<label class=" control-label col-md-4 text-left s-16 c-text-alt"> No. Dependencia:</label>
		<div class="col-md-8">{{ $row->no_dep_gen }}</div>
	</div>

	<div class="form-group">
		<label class=" control-label col-md-4 text-left s-16 c-text-alt"> Dependencia General :</label>
		<div class="col-md-8">{{ $row->dep_gen }}</div>
	</div>

	<div class="form-group">
		<label class=" control-label col-md-4 text-left s-16 c-text-alt"> 
			@if($modulo == 1) Anteproyecto
			@elseif($modulo == 2) Proyecto
			@elseif($modulo == 3) Presupuesto Definitivo
			@endif
		</label>
		<div class="col-md-8">
			{!! Form::text('presupuesto',$pres,array('class'=>'form-control', 'placeholder'=>'Ingresa presupuesto','required' )) !!}
		</div>
	</div>
  
	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
		<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
	</article>
</form>

<script>
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to($pageModule.'/savepres?id='.$row->id) }}", {
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
                if(row.response == 'ok'){
                    $("#sximo-modal").modal("toggle");
                    proyectos.rowsProjects();
                    toastr.success(mss_tmp.success);
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