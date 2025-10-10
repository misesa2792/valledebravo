<form id="saveInfo" method="post" class="form-horizontal">
  <div class="col-md-12">

    <div class="form-group">
        <label class="control-label col-md-4 text-left s-16 c-text-alt"> Estatus :</label>
        <div class="col-md-8">
          <label class="c-text-alt">
            @foreach ($estatus as $key => $v)
              <input type="radio" name="active" required  @if($key == $row->active) checked @endif value="{{ $key }}"> {{ $v }}
            @endforeach
          </label>
        </div>
    </div>

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
		<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
	</article>
</form>

 <script type="text/javascript">


 $("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to('usuarios/estatus?id='.$id) }}", {
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
