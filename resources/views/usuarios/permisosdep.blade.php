<form id="saveInfo" method="post" class="form-horizontal">
  <div class="col-md-12">
	<input type="hidden" name="idy" value="{{ $idy }}">
	<section class="table-resp" style="min-height:300px;">
		<article class="col-sm-12 col-md-12 col-lg-12 m-b-md bg-white s-16 b-r-5 font-bold p-xs">
			<div class="col-sm-2 col-md-2 col-lg-2">Número</div>
			<div class="col-sm-3 col-md-3 col-lg-3">Dependencia General</div>
			<div class="col-sm-4 col-md-4 col-lg-4">Dependencia Auxiliar</div>
		</article>
		@foreach (json_decode($rows) as $row)
			<article class="col-sm-12 col-md-12 col-lg-12 m-b-md bg-white no-padding s-16 b-r-5">
				<div class="col-sm-2 col-md-2 col-lg-2">{{ $row->numero }}</div>
				<div class="col-sm-3 col-md-3 col-lg-3">{{ $row->dep_gen }}</div>
				<div class="col-sm-4 col-md-4 col-lg-4">
					<ul>
						@foreach ($row->dep_aux as $aux)
							<li class="s-16 c-text-alt m-b-xs m-t-xs" style="text-decoration: none;">
								<input type="checkbox" name="permiso[]" value="{{ $aux->idc }}" @if($aux->permiso > 0) checked @endif> {{ $aux->coordinacion }}
							</li>
						@endforeach
					</ul>
				</div>
			</article>
		@endforeach
	</section>

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
		<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
	</article>
</form>

 <script type="text/javascript">
$('input[type="checkbox"],input[type="radio"]').iCheck({
	checkboxClass: 'icheckbox_square-green',
	radioClass: 'iradio_square-green',
});

 $("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to('usuarios/permisosdep?k='.$k) }}", {
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
				user.rowsUser();
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
