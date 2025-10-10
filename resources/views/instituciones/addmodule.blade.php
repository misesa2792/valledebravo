<form id="saveInfo" method="post" class="form-horizontal">
	<section class="form-horizontal">
		<input type="hidden" name="module" value="{{ $no }}">
		<div class="form-group m-t-md" >
			<label for="Logo Izquierdo" class=" control-label col-md-4 text-left s-16"> Año: </label>
			<div class="col-md-6">
				<select name="idy" class="form-control">
					<option value="">--Select Please--</option>
					@foreach ($years as $y)
						<option value="{{ $y->idanio }}">{{ $y->anio }}</option>
					@endforeach
				</select>
			</div>
		</div> 

		<div style="clear:both"></div>	

		<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
			<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
			<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
		</article>
	</section>
</form>
<script>
	$("#saveInfo").on("submit", function(e){
		e.preventDefault();
		var formData = new FormData(document.getElementById("saveInfo"));
		$.ajax("{{ URL::to($pageModule.'/savemodule?idi='.$idi) }}", {
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
				years.rowsProjects();
				toastr.success(row.message);
			}else{
				toastr.error(row.message);
			}
			$(".btnsave").prop("disabled",false).html(btnSave);
		}, error : function(err){
			toastr.error(mss_tmp.error);
			$(".btnsave").prop("disabled",false).html(btnSave);
		}
	});
});
</script>