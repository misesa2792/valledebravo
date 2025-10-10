<form id="saveInfo" method="post" class="form-horizontal">
    <div class="form-group">
        <label class=" control-label col-md-2 text-left s-16"> Clave: </label>
        <div class="col-md-10">
            {!! Form::text('clave', '',array('class'=>'form-control', 'placeholder'=>'Clave',   )) !!}
        </div>
    </div> 

    <div class="form-group">
        <label class=" control-label col-md-2 text-left s-16"> Meta: </label>
        <div class="col-md-10">
            <input type="text" name="descripcion" class="form-control" placeholder="Ingresa Meta" required>
        </div>
    </div> 

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
<script>
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to('pdm/savemeta?idpla='.$idpla) }}", {
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
                    toastr.success(row.message);
                    query();
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