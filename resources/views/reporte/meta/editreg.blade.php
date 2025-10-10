
<form id="editRegMes" method="post" class="form-horizontal">
    <section class="col-sm-12 col-md-12 m-t-md">
        <input type="hidden" name="idrg" value="{{ $row->idrg }}">
        <input type="hidden" name="idmes" value="{{ $row->idmes }}">
        <table class="table table-bordered">
            <tr>
                <td class="s-16 text-right c-text-alt">Cantidad : </td>
                <td>
                    <input type="text" name="cantidad" class="form-control" placeholder="Ingresa Cantidad" value="{{ $row->cant }}" required>
                </td>
            </tr>
            <tr>
                <td class="s-16 text-right c-text-alt">Evidencia : </td>
                <td>
                    <input type="file" name="evidencia[]" class="form-control" accept=".jpeg,.jpg,.png,.xlsx,.xls,.pdf,.txt,.ppt,.pptx,.doc,.docx,.csv" multiple>
                </td>
            </tr>
        </table>

        <div class="col-md-12 text-center m-t-md m-b-md">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-primary btn-sm btnedit"><i class="fa fa-save"></i> Guardar</button>
        </div>
    </section>
</form>

<script>
     $("#editRegMes").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("editRegMes"));
        $.ajax("{{ URL::to('reporte/editmetames?idrm='.$idrm) }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btnedit").prop("disabled",true).html(btnSaveSpinner);
            },success: function(res){
                let row = JSON.parse(res);
                if(row.success == 'ok'){
                    $("#modal_inventario").modal("toggle");
                    meses.rowsMeses();
                    metas.rowsMetas();
                    toastr.success(mss_tmp.success);
                }else{
                    toastr.error(mss_tmp.error);
                }
                $(".btnedit").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnedit").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>