<form id="saveInfo" method="post" class="form-horizontal">
	<div class="col-md-12">
		{!! Form::hidden('idfinalidad', $row['idfinalidad'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									
		<div class="form-group m-t-md" >
			<label for="Numero" class=" control-label col-md-4 text-left s-16 c-text-alt"> Número :</label>
			<div class="col-md-8">
				{!! Form::text('numero', $row['numero'],array('class'=>'form-control', 'placeholder'=>'Ingresa número','required'   )) !!}
			</div>
		</div> 

		<div class="form-group  " >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Finalidad :</label>
			<div class="col-md-8">
				{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa Nombre','required'   )) !!}
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
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to('estructuraprogramatica/savefin') }}", {
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