<form id="saveInfo" method="post" class="form-horizontal">
	<div class="col-md-12">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="idarea" value="{{ $idarea }}">
							
        <table class="table table-bordered table-ses bg-white">
            <tr>
                <th width="40"></th>
                <th width="40">#</th>
                <th>Dependencia auxiliar</th>
            </tr>
            @foreach($rowsDepAux as $v)
                <tr class="@if(in_array($v->id,$depaux)) success @endif">
                    <td class="text-center">
                        @if(!in_array($v->id,$depaux)) 
                        <input type="checkbox" name="ids[]" value="{{ $v->id }}">
                        @endif
                    </td>
                    <td class="text-center">{{ $v->no_dep_aux }}</td>
                    <td>{{ $v->dep_aux }}</td>
                </tr>
            @endforeach
        </table>
								
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