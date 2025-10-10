<form id="saveInfo" method="post" class="form-horizontal">
	<div class="col-md-12">
		{!! Form::hidden('idfuncion', $row['idfuncion'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		{!! Form::hidden('idy', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
									 
		<div class="form-group  m-t-md" >
			<label for="Idfinalidad" class=" control-label col-md-3 text-left s-16"> Finalidad </label>
			<div class="col-md-9">
				<select name="idfinalidad" class="mySelect2" required>
					<option value="">--Select Please--</option>
					@foreach ($rowsFinalidad as $p)
						<option value="{{ $p->id }}" @if($p->id == $row['idfinalidad']) selected @endif>{{ $p->no_finalidad }} - {{ $p->finalidad }}</option>
					@endforeach
				</select>
			</div>
		</div> 

		<div class="form-group  " >
			<label for="Numero" class=" control-label col-md-3 text-left s-16"> Número de función </label>
			<div class="col-md-9">
				{!! Form::text('numero', $row['numero'],array('class'=>'form-control', 'placeholder'=>'Ingresa número', 'required'  )) !!}
			</div>
		</div> 

		<div class="form-group  " >
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16"> Nombre de la función </label>
			<div class="col-md-9">
				{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa Nombre', 'required'  )) !!}
			</div>
		</div>

		<div class="form-group  " >
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16"> Objetivo </label>
			<div class="col-md-9">
				{!! Form::textarea('objetivo', $row['objetivo'],array('class'=>'form-control', 'placeholder'=>'Ingresa Objetivo', 'required'  )) !!}
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
$(".mySelect2").select2();

$("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to($pageModule.'/save?id='.$id) }}", {
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