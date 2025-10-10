<form id="saveInfo" method="post" class="form-horizontal">
   

    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th width="15%">Programa presupuestario: </th>
                    <td class="text-center" width="100">{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto: </th>
                    <td></td>
                    <td>
                        <select name="idproyecto" class="mySelect full-width" required>
                            <option value="">--Selecciona Proyecto--</option>
                            @foreach ($rowsProyectos as $v)
                            <option value="{{ $v->idproyecto }}">{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
              
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data->no_dep_gen }}</td>
                    <td>{{ $data->dep_gen }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td></td>
                    <td>
                         <select name="idac" class="mySelect full-width" required>
                            <option value="">--Selecciona Dependencia Auxiliar--</option>
                            @foreach ($rowsDepAux as $v)
                            <option value="{{ $v->id }}">{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12">
    <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <th rowspan="2"></th>
                <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
                <th colspan="3" class="text-center">Indicadores</th>
                <th rowspan="2"  class="text-center">Medios de verificación</th>
                <th rowspan="2"  class="text-center">Supuestos</th>
            </tr>
            <tr class="c-text-alt">
                <th class="text-center">Nombre</th>
                <th class="text-center">Fórmula</th>
                <th class="text-center">Frecuencia y Tipo</th>
            </tr>
        
            <tr class="c-text-alt">
                <td class="text-center-middle s-10">Fin</td>
                <td class="s-10">
                    <input type="checkbox" name="idmatriz[]" value="{{ $dataMatriz['fin']->idpd_pbrme_matriz }}" checked>
                    {{ $dataMatriz['fin']->descripcion }}</td>
                <td class="s-10">{{ $dataMatriz['fin']->indicador }}</td>
                <td class="s-10">{{ $dataMatriz['fin']->formula }}</td>
                <td class="s-10 text-center">
                    {{ $dataMatriz['fin']->frecuencia }}
                    <br>
                    {{ $dataMatriz['fin']->tipo_indicador }}
                </td>
                <td class="s-10">{{ $dataMatriz['fin']->medios }}</td>
                <td class="s-10">{{ $dataMatriz['fin']->supuestos }}</td>
            </tr>

            <tr class="c-text-alt">
                <td class="text-center-middle s-10">Propósito</td>
                <td class="s-10">
                    <input type="checkbox" name="idmatriz[]" value="{{ $dataMatriz['proposito']->idpd_pbrme_matriz }}" checked>
                    {{ $dataMatriz['proposito']->descripcion }}</td>
                <td class="s-10">{{ $dataMatriz['proposito']->indicador }}</td>
                <td class="s-10">{{ $dataMatriz['proposito']->formula }}</td>
                <td class="s-10 text-center">
                    {{ $dataMatriz['proposito']->frecuencia }}
                    <br>
                    {{ $dataMatriz['proposito']->tipo_indicador }}
                </td>
                <td class="s-10">{{ $dataMatriz['proposito']->medios }}</td>
                <td class="s-10">{{ $dataMatriz['proposito']->supuestos }}</td>
            </tr>

            @foreach($dataMatriz['componente'] as $ca => $c)
                @if($ca == 0)
                    <tr class="c-text-alt s-10">
                        <td rowspan="{{ count($dataMatriz['componente']) + 1 }}" class="text-center-middle">Componentes</td>
                    </tr>
                @endif

                <tr class="c-text-alt">
                    <td class="s-10">
                        <input type="checkbox" name="idmatriz[]" value="{{ $c->idpd_pbrme_matriz }}" checked>
                        {{ $c->descripcion }}</td>
                    <td class="s-10">{{ $c->indicador }}</td>
                    <td class="s-10">{{ $c->formula }}</td>
                    <td class="s-10 text-center">
                        {{ $c->frecuencia }}
                        <br>
                        {{ $c->tipo_indicador }}
                    </td>
                    <td class="s-10">{{ $c->medios }}</td>
                    <td class="s-10">{{ $c->supuestos }}</td>
                </tr>
            @endforeach
        
            @foreach($dataMatriz['actividad'] as $ka => $c)
                @if($ka == 0)
                    <tr class="c-text-alt s-10">
                        <td rowspan="{{ count($dataMatriz['actividad']) + 1 }}" class="text-center-middle">Actividades</td>
                    </tr>
                @endif
                <tr class="c-text-alt">
                    <td class="s-10">
                        <input type="checkbox" name="idmatriz[]" value="{{ $c->idpd_pbrme_matriz }}" checked>
                        {{ $c->descripcion }} </td>
                    <td class="s-10">{{ $c->indicador }}</td>
                    <td class="s-10">{{ $c->formula }}</td>
                    <td class="s-10 text-center">
                        {{ $c->frecuencia }}
                        <br>
                        {{ $c->tipo_indicador }}
                    </td>
                    <td class="s-10">{{ $c->medios }}</td>
                    <td class="s-10">{{ $c->supuestos }}</td>
                </tr>
            @endforeach
    </table>
    </div>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa icon-file-pdf"></i> Guardar información</button>
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
        title : 'Estás seguro de asignar proyecto con indicadores?',
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

                    $.ajax("{{ URL::to('anteproyecto/saveproyectopbrmd?id='.$id) }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                           // $(".btnsave").prop("disabled",true).html(mss_spinner + " Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);

                            if(row.status == "ok"){
                                vm.$refs.componenteActivo?.rowsProjects();
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
            }
        })
    });
</script>