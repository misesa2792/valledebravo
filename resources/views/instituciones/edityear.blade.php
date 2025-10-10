<form id="saveInfo" method="post" class="form-horizontal">

	<input type="hidden" name="no_institucion" value="{{ $row->no_institucion }}">
	<section class="form-horizontal"> 
	<div class="form-group m-t-md" >
		<label for="Logo Izquierdo" class=" control-label col-md-4 text-left s-16"> Logo Izquierdo: </label>
		<div class="col-md-6">
			<input type="file" name="logo_izq" class="form-control">
			<p>
				<i>Please use image dimension 120px * 70px</i>
			</p>
		</div>
	</div> 

	<div class="form-group m-t-md" >
		<label for="Logo Derecho" class=" control-label col-md-4 text-left s-16"> Logo Derecho: </label>
		<div class="col-md-6">
			<input type="file" name="logo_der" class="form-control">
			<p>
				<i>Please use image dimension 70px * 70px</i>
			</p>
		</div>
	</div> 

	<div class="col-md-6">
		<table class="table no-borders">
			<tr class="t-tr-s16 c-text">
				<td class="text-center bg-white">
					<div class="font-bold c-text-alt">UIPPE</div>
					<br>
					<input type="text" name="t_uippe" value="{{ $row->t_uippe }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa nombre" style="border-bottom:2px solid var(--border-color) !important;" >
					<input type="text" name="c_uippe" value="{{ $row->c_uippe }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa cargo" style="border-bottom:2px solid var(--border-color) !important;">
				</td>
		   </tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table no-borders">
			<tr class="t-tr-s16 c-text">
				<td class="text-center bg-white">
					<div class="font-bold c-text-alt">TESORERÍA</div>
					<br>
					<input type="text" name="t_tesoreria" value="{{ $row->t_tesoreria }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa nombre" style="border-bottom:2px solid var(--border-color) !important;" >
					<input type="text" name="c_tesoreria" value="{{ $row->c_tesoreria }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa cargo" style="border-bottom:2px solid var(--border-color) !important;">
				</td>
		   </tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table no-borders">
			<tr class="t-tr-s16 c-text">
				<td class="text-center bg-white">
					<div class="font-bold c-text-alt">EGRESOS</div>
					<br>
					<input type="text" name="t_egresos" value="{{ $row->t_egresos }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa nombre" style="border-bottom:2px solid var(--border-color) !important;" >
					<input type="text" name="c_egresos" value="{{ $row->c_egresos }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa cargo" style="border-bottom:2px solid var(--border-color) !important;">
				</td>
		   </tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table no-borders">
			<tr class="t-tr-s16 c-text">
				<td class="text-center bg-white">
					<div class="font-bold c-text-alt">SECRETARIO(A)</div>
					<br>
					<input type="text" name="t_secretario" value="{{ $row->t_secretario }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa nombre" style="border-bottom:2px solid var(--border-color) !important;" >
					<input type="text" name="c_secretario" value="{{ $row->c_secretario }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa cargo" style="border-bottom:2px solid var(--border-color) !important;">
				</td>
		   </tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table no-borders">
			<tr class="t-tr-s16 c-text">
				<td class="text-center bg-white">
					<div class="font-bold c-text-alt">PROGRAMA PRESUPUESTAL</div>
					<br>
					<input type="text" name="t_prog_pres" value="{{ $row->t_prog_pres }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa nombre" style="border-bottom:2px solid var(--border-color) !important;" >
					<input type="text" name="c_prog_pres" value="{{ $row->c_prog_pres }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="Ingresa cargo" style="border-bottom:2px solid var(--border-color) !important;">
				</td>
		   </tr>
		</table>
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
		$.ajax("{{ URL::to($pageModule.'/saveyears?id='.$id) }}", {
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
			years.rowsProjects();
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