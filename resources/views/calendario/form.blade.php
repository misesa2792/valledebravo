<section class="table-resp">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        
		<div class="form-group m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Fecha Inicio: </label>
			<div class="col-md-9">
				{!! Form::text('fi', $fecha,array('class'=>'form-control', 'placeholder'=>'0000-00-00', 'required','readonly')) !!}
			</div>
		</div> 

		<div class="form-group m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Fecha Fin: </label>
			<div class="col-md-9">
				{!! Form::text('ff', $fecha,array('class'=>'form-control date', 'placeholder'=>'0000-00-00', 'required')) !!}
			</div>
		</div> 

		<div class="form-group m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Titulo del evento: </label>
			<div class="col-md-9">
				{!! Form::text('evento', '',array('class'=>'form-control', 'placeholder'=>'Ingresa título', 'required')) !!}
			</div>
		</div>

		<div class="form-group m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Descripción del evento: </label>
			<div class="col-md-9">
				{!! Form::textarea('descripcion', '',array('class'=>'form-control', 'placeholder'=>'Ingresa descripción', )) !!}
			</div>
		</div> 

		<div class="form-group m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Color del evento: </label>
			<div class="col-md-9">
				<select name="color" class="form-control">
					<option value="#ff4c51" selected>Rojo</option>
					<option value="#007BDF">Azul</option>
					<option value="#56ca00">Verde</option>
					<option value="#621132">Primary</option>
					<option value="#7900ac">Purpura</option>
					<option value="#929292">Gris</option>
				</select>
			</div>
		</div>

		@if(Auth::user()->group_id ==1 || Auth::user()->group_id == 2)
            <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
                <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
            </article>
        @endif
    </div>

    </form>
</section>
<script>
    $('.date').datepicker({format: 'yyyy-mm-dd'});

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de guardar?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
            if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    $.ajax("{{ URL::to('calendario/save') }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            //$(".btnsave").prop("disabled",true).html(btnSaveSpinner);
                        },success: function(res){
                            let row = JSON.parse(res);
                            if(row.status == 'ok'){
                                $("#sximo-modal").modal("toggle");
                                toastr.success(row.message);
		                        calendar.refetchEvents();
                            }else{
                                toastr.error(row.message);
                            }
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }, error : function(err){
                            toastr.error(mss_tmp.error);
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }
                    });
            }
        })
    });
</script>