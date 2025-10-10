<form id="saveInfoUm" method="post" class="form-horizontal">

	<div class="col-md-12">

        <div class="col-md-12">
            <div class="alert alert-danger fade in block-inner">
                <div class="s-10">
                    <i class="icon-warning"></i> Notas importantes:
                </div>
                <p class="c-text s-10">
                    Registra la unidad de medida iniciando con mayúscula y con la ortografía correcta. 
                    Recuerda que, una vez dada de alta, la unidad de medida será visible en todo el sistema 
                    y podrá ser utilizada por los usuarios que la requieran.
                </p>
            </div>
        </div>
	
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
							
        <table class="table table-bordered bg-white">
            <tr>
                <th width="40">#</th>
                <th width="40"></th>
                <th>Meta</th>
            </tr>
            @foreach($rowsMetas as $k => $v)
                <tr>
                    <td>{{ ++$k }}</td>
                    <td>
                        <input type="checkbox" value="{{ $v->id }}">
                    </td>
                    <td>{{ $v->codigo.'. '.$v->meta.' ( '.str_replace('0', '', $v->no_proyecto).'-'.$v->no_dep_aux.'-'.$v->no_dep_gen.' )' }}</td>
                </tr>
            @endforeach
        </table>

	</div>

	<div style="clear:both"></div>

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsaveum"><i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
<script>
    $("#saveInfoUm").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfoUm"));
        $.ajax("{{ URL::to('anteproyecto/unidadmedida') }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btnsaveum").prop("disabled",true).html(btnSaveSpinner);
            },success: function(res){
                let row = JSON.parse(res);
                if(row.status == 'ok'){
                    $("#modal_inventario").modal("toggle");
                    toastr.success(row.message);
                }else{
                    toastr.error(row.message);
                }
                $(".btnsaveum").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsaveum").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>