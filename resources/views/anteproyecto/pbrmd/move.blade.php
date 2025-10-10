<form id="saveInfo" method="post" class="form-horizontal">
    <div class="col-md-12">
        <div class="col-md-6">
            <table class="table table-bordered bg-white">
                <tr>
                    <th colspan="3" class="text-center">Información del Indicador que alimenta proyecto</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Nombre del Indicador: </th>
                    <td class="text-center">{{ $data->mir }}</td>
                    <td>{{ $data->indicador }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data->no_dep_gen }}</td>
                    <td>{{ $data->dep_gen }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td class="text-center">{{ $data->no_dep_aux }}</td>
                    <td>{{ $data->dep_aux }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center">{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto Actual: </th>
                    <td class="text-center">{{ $data->no_proyecto }}</td>
                    <td>{{ $data->proyecto }}</td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-bordered bg-white">
                 <tr>
                    <th colspan="3" class="text-center">Información del Indicador</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Nombre del Indicador: </th>
                    <td class="text-center">{{ $data->mir }}</td>
                    <td>{{ $data->indicador }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data->no_dep_gen }}</td>
                    <td>{{ $data->dep_gen }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td class="text-center"></td>
                    <td>
                         <select name="idac" class="mySelect full-width" required>
                            <option value="">--Selecciona Dependencia Auxiliar--</option>
                            @foreach ($rowsDepAux as $v)
                            <option value="{{ $v->id }}" @if($v->id == $data->idac) selected @endif>{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center">{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Mover Indicador a nuevo proyecto: </th>
                    <td class="text-center"></td>
                    <td>
                        <select name="idproyecto" class="mySelect full-width" required>
                            <option value="">--Selecciona Proyecto--</option>
                            @foreach ($rowsProyectos as $v)
                            <option value="{{ $v->idproyecto }}" @if($v->idproyecto == $data->idproyecto) selected @endif>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Asignar a nuevo proyecto</button>
    </article>

</form>
<style>

.select2-container {
    z-index: 99999 !important;
}
</style>
<script>

    $('.mySelect').select2({
        dropdownParent: $('#sximo-modal')
    });
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de asignar el indicador a otro proyecto?',
        icon : 'warning',
        buttons: {
            cancel: {
            text: "No, Cancelar",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true,
            },
            confirm: {
            text: "Sí, asignar proyecto",
            value: true,
            visible: true,
            className: "btn btn-danger",
            closeModal: true
            }
        },
        dangerMode : true,
		closeOnClickOutside: false
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    $.ajax("{{ URL::to('anteproyecto/movepbrmd?id='.$id) }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".btnsave").prop("disabled",true).html(mss_spinner + " Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);

                            if(row.status == "ok"){
                                vm.$refs.componenteActivo?.rowsProjects();
                	            $('#sximo-modal').modal("toggle");
                            }else{
                                toastr.warning(row.message);
                            }
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }, error : function(err){
                            toastr.error(mss_tmp.error);
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }
                    });
            }
        })
    });
</script>