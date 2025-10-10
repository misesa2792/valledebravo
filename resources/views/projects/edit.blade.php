<section class="table-resp">
    <form id="saveInfo" method="post" class="form-horizontal">

       <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-4 text-right">Dependencia General:</div>
                <div class="col-md-8">
                    <select name="iddep_gen" class="mySelect full-width" required>
                        <option value="">--Select Please--</option>
                        @foreach ($rowsDepGen as $v)
                            <option value="{{ $v->id }}" @if($v->id == $row->iddep_gen) selected @endif>{{ $v->no_dep_gen.' '.$v->dep_gen }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 text-right">Dependencia Auxiliar:</div>
                <div class="col-md-8">
                    <select name="iddep_aux" class="mySelect full-width" required>
                        <option value="">--Select Please--</option>
                        @foreach ($rowsDepAux as $v)
                            <option value="{{ $v->id }}" @if($v->id == $row->iddep_aux) selected @endif>{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 text-right">Proyecto:</div>
                <div class="col-md-8">
                    <select name="idproyecto" class="mySelect full-width" required>
                        <option value="">--Select Please--</option>
                        @foreach ($rowsProyectos as $v)
                            <option value="{{ $v->idproyecto }}" @if($v->idproyecto == $row->idproyecto) selected @endif>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 text-right">Presupuesto:</div>
                <div class="col-md-8">
                    <input type="text" name="importe" value="{{ $row->presupuesto }}" placeholder="$" class="form-control" required>
                </div>
            </div>
        
            <div class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
                <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
            </div>
       </div>
	<style>
		.select2-container{width:100% !important;}
	</style>

    </form>
</section>
<script>
    $(".mySelect").select2();
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
      formData.append("idam", "{{ $idam }}");
      formData.append("id", "{{ $id }}");
        $.ajax("{{ URL::to($pageModule.'/update') }}", {
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
                    pbrma.rowsProjects();
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