<form id="saveInfo" method="post" class="form-horizontal">

     <div class="form-group m-t-md" >
        <label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text-alt"> Dependencia: </label>
        <div class="col-md-8">{{ $row->no_dep_gen.' '.$row->dep_gen }}</div>
    </div> 

    <div class="form-group m-t-md" >
        <label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text-alt"> Nombre del Titular: </label>
        <div class="col-md-8">
            {!! Form::text('titular', $row->titular,array('class'=>'form-control', 'placeholder'=>'Ingresa nombre del titular','required'  )) !!}
        </div>
    </div> 

    <div class="form-group m-t-md" >
        <label for="Descripcion" class=" control-label col-md-4 text-left s-14 c-text-alt"> Cargo del titular: </label>
        <div class="col-md-8">
            {!! Form::text('cargo', $row->cargo,array('class'=>'form-control', 'placeholder'=>'Ingresa cargo del titular','required'  )) !!}
        </div>
    </div> 


<br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Editar </button>
    </article>
</form>
<script>

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
        var formData = new FormData(document.getElementById("saveInfo"));
            $.ajax("{{ URL::to('panel/updatetitular?id='.$id) }}", {
                type: 'post',
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                   // $(".btnsave").prop("disabled",true).html(mss_spinner + " Guardando...");
                },success: function(res){
                    let row = JSON.parse(res);

                    if(row.status == "ok"){
                        vm.loadTitulares();
                        $('#sximo-modal').modal("toggle");
                        toastr.success(row.message);
                    }else{
                        toastr.warning(row.message);
                    }
                    $(".btnsave").prop("disabled",false).html(btnSave);
                }, error : function(err){
                    toastr.error(mss_tmp.error);
                    $(".btnsave").prop("disabled",false).html(btnSave);
                }
            });
    });
</script>