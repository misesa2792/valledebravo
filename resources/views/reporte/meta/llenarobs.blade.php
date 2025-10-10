<form id="saveMetaMes" method="post" class="form-horizontal">
    <input type="hidden" name="typeobs" value="{{ $obs }}">

  

    <div class="row m-t-md">

        @if($access_trim == 1)
                <div class="alert alert-danger fade in block-inner">
                    <i class="icon-cancel-circle"></i> El periodo establecido para realizar la captura de avance ha finalizado.
                </div>
        @endif

        <table class="table table-bordered">
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Descripción de acción : </td>
                <td class="c-text">{{ $row->meta }}</td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Unidad de medida : </td>
                <td class="c-text">{{ $row->unidad_medida }}</td>
            </tr>
            <tr>
                <td class="s-16 text-right c-text-alt">Justificación : </td>
                <td>
                    @if($obs == "obs1")
                        <textarea name="obs" rows="8" class="form-control" placeholder="Justificación" @if($access_trim == 1) disabled @endif required>{{ $row->obs }}</textarea>
                    @elseif($obs == "obs2")
                        <textarea name="obs" rows="8" class="form-control" placeholder="Justificación" @if($access_trim == 1) disabled @endif required>{{ $row->obs2 }}</textarea>
                    @elseif($obs == "obs3")
                        <textarea name="obs" rows="8" class="form-control" placeholder="Justificación" @if($access_trim == 1) disabled @endif required>{{ $row->obs3 }}</textarea>
                    @elseif($obs == "obs4")
                        <textarea name="obs" rows="8" class="form-control" placeholder="Justificación" @if($access_trim == 1) disabled @endif required>{{ $row->obs4 }}</textarea>
                    @endif
                </td>
            </tr>
        </table>

        {{-- 1 indica que ya no se puede modificar nada --}}
        @if($access_trim == 0)
            <div class="col-md-4 text-left m-t-md m-b-md">
                <button type="button" name="danger" class="btn btn-danger btn-sm btndestroyjust"><i class="fa fa-trash-o"></i> Eliminar Justificación</button>
            </div>
            <div class="col-md-8 text-right m-t-md m-b-md">
                <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline" ><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            </div>
        @endif
       
    </div>
</form>
<script>
     $("#saveMetaMes").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveMetaMes"));
        $.ajax("{{ URL::to('reporte/savemetaobs?idrg='.$idrg) }}", {
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
                    metas.rowsMetas();
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
    $(".btndestroyjust").click(function(e){
        e.preventDefault();

        
        swal({
            title : 'Eliminar Justificación',
            text: 'Estás seguro de eliminar la justificación?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){
                destroyJust();
            }
        })
       
    });
    const btnJust = '<i class="fa fa-trash-o"></i> Eliminar Justificación';
    function destroyJust(){
        var formData = new FormData(document.getElementById("saveMetaMes"));
        $.ajax("{{ URL::to('reporte/destroymetaobs?idrg='.$idrg) }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btndestroyjust").prop("disabled",true).html(btnSaveSpinner);
            },success: function(res){
                let row = JSON.parse(res);
                if(row.success == 'ok'){
                    $("#sximo-modal").modal("toggle");
                    metas.rowsMetas();
                    toastr.success(mss_tmp.success);
                }else{
                    toastr.error(mss_tmp.error);
                }
                $(".btndestroyjust").prop("disabled",false).html(btnJust);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btndestroyjust").prop("disabled",false).html(btnJust);
            }
        });
    }
</script>