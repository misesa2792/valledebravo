<form id="saveInfo" method="post" class="form-horizontal">

	<div class="col-md-12">
				
	{!! Form::hidden('idy', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
	{!! Form::hidden('id', $id,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
							
        <div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Estatus: </label>
			<div class="col-md-8">
                <select name="estatus" class="form-control" required>
                    <option value="">--Select Please--</option>
                    @foreach ($rowsEstatus as $kk => $v)
                         <option value="{{ $kk }}" @if($kk == $row['estatus']) selected @endif>{{ $v }}</option>
                    @endforeach
                </select>
			</div>
		</div> 

        <div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Dependencia: </label>
			<div class="col-md-8">
                <select name="iddep_gen" class="select2">
                    <option value="">--Select Please--</option>
                    @foreach ($rowsDepGen as $v)
                         <option value="{{ $v->id }}" @if($v->id == $row['iddep_gen']) selected @endif>{{ $v->no_dep_gen.' '.$v->dep_gen }}</option>
                    @endforeach
                </select>
			</div>
		</div> 


        <div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Denominación: </label>
			<div class="col-md-8">
				{!! Form::text('numero', $row['numero'],array('class'=>'form-control', 'placeholder'=>'Ingresa Denominación', )) !!}
			</div>
		</div> 


		<div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Nombre de Área: </label>
			<div class="col-md-8">
				{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa área', 'required'  )) !!}
			</div>
		</div> 

		<div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Nombre del Titular: </label>
			<div class="col-md-8">
				{!! Form::text('titular', $row['titular'],array('class'=>'form-control', 'placeholder'=>'Ingresa nombre del titular'  )) !!}
			</div>
		</div> 

        <div class="form-group m-t-md" >
			<label for="Descripcion" class=" control-label col-md-4 text-left s-16 c-text-alt"> Cargo del titular: </label>
			<div class="col-md-8">
				{!! Form::text('cargo', $row['cargo'],array('class'=>'form-control', 'placeholder'=>'Ingresa cargo del titular'  )) !!}
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
    $(".select2").select2();
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