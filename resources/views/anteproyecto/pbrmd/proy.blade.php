<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">
    <div class="col-md-12 no-padding">
        <div class="col-md-12 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th width="15%">Programa presupuestario: </th>
                    <td class="text-center" width="80">{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto: </th>
                    <td class="text-center"></td>
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
                    <td class="text-center"></td>
                    <td>
                        <select name="idac" class="mySelect full-width" required>
                            <option value="">--Selecciona dependencia auxiliar--</option>
                            @foreach ($rowsDepAux as $v)
                                <option value="{{ $v->id }}">{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12 no-padding">
            <div class="alert alert-danger" role="alert">
                <strong>Notas importantes</strong>
                <ul class="c-text-alt s-10" style="margin-bottom:8px;">
                    <li>
                        <strong>Personalización independiente de indicadores</strong>
                        <ul>
                            <li>
                            Ahora puedes <u>personalizar cada indicador por proyecto y dependencia auxiliar</u>.
                            </li>
                            <li>
                            Incluso si ya fue asignado a otro proyecto o dependencia, aquí podrá configurarse de manera independiente.
                            </li>
                            <li>
                            El sistema validará automáticamente que <strong>no se duplique en el mismo proyecto y dependencia auxiliar</strong> con el mismo indicador, garantizando consistencia.
                            </li>
                        </ul>
                        <strong>Eliminar indicador</strong>
                        <ul>
                            <li>Ahora en la pantalla principal ya es posible eliminar indicadores asignados a un proyecto y dependencia auxiliar.</li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>


         <table class="table table-bordered bg-white">
                <tr>
                    <th rowspan="2" width="100"></th>
                    <th rowspan="2" width="30"><input type="checkbox" class="checkall"></th>
                    <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
                    <th colspan="4" class="text-center">Indicadores</th>
                    <th rowspan="2"  class="text-center">Medios de verificación</th>
                    <th rowspan="2"  class="text-center">Supuestos</th>
                </tr>
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Fórmula</th>
                    <th class="text-center">Frecuencia y Tipo</th>
                </tr>
                <tr>
                    <td class="bg-white text-center-middle">Fin</td>
                    <td><input type="checkbox" name="ids[]" class="ids" value="{{ $matriz['fin']['row']->idprograma_reg }}" @if(!$matriz['fin']['validate']) checked @endif></td>
                    <td>{{ $matriz['fin']['row']->descripcion }}

                        <div>
                            @if($matriz['fin']['validate'])
                                <span class="c-success">Asignado a proyecto</span>
                            @else
                                <span class="c-danger">Pendiente por asignar a proyecto</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">{{ $matriz['fin']['row']->mir }}</td>
                    <td>{{ $matriz['fin']['row']->nombre }}</td>
                    <td>{{ $matriz['fin']['row']->formula }}</td>
                    <td class="text-center">
                        <div>{{ $matriz['fin']['row']->frecuencia }}</div>
                        <div>{{ $matriz['fin']['row']->tipo_indicador }}</div>
                    </td>
                    <td>{{ $matriz['fin']['row']->medios }}</td>
                    <td>{{ $matriz['fin']['row']->supuestos }}</td>
                </tr>
                <tr>
                    <td class="bg-white text-center-middle">Propósito</td>
                    <td><input type="checkbox" name="ids[]" class="ids" value="{{ $matriz['proposito']['row']->idprograma_reg }}"  @if(!$matriz['proposito']['validate']) checked @endif></td>
                    <td>{{ $matriz['proposito']['row']->descripcion }}

                        <div>
                            @if($matriz['proposito']['validate'])
                                <span class="c-success">Asignado a proyecto</span>
                            @else
                                <span class="c-danger">Pendiente por asignar a proyecto</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">{{ $matriz['proposito']['row']->mir }}</td>
                    <td>{{ $matriz['proposito']['row']->nombre }}</td>
                    <td>{{ $matriz['proposito']['row']->formula }}</td>
                    <td class="text-center">
                        <div>{{ $matriz['proposito']['row']->frecuencia }}</div>
                        <div>{{ $matriz['proposito']['row']->tipo_indicador }}</div>
                    </td>
                    <td>{{ $matriz['proposito']['row']->medios }}</td>
                    <td>{{ $matriz['proposito']['row']->supuestos }}</td>
                </tr>
                <tr>
                    <td rowspan="{{ count($matriz['componente'])+1 }}" class="text-center-middle">Componentes</td>
                </tr>
                @foreach($matriz['componente'] as $v)
                    <tr>
                    <td><input type="checkbox" name="ids[]" class="ids" value="{{ $v['row']->idprograma_reg }}" @if(!$v['validate']) checked @endif></td>
                        <td>{{ $v['row']->descripcion }}

                            <div>
                                @if($v['validate'])
                                    <span class="c-success">Asignado a proyecto</span>
                                @else
                                    <span class="c-danger">Pendiente por asignar a proyecto</span>
                                @endif
                           </div>
                        </td>
                        <td class="text-center">{{ $v['row']->mir }}</td>
                        <td>{{ $v['row']->nombre }}</td>
                        <td>{{ $v['row']->formula }}</td>
                        <td class="text-center">
                            <div>{{ $v['row']->frecuencia }}</div>
                            <div>{{ $v['row']->tipo_indicador }}</div>
                        </td>
                        <td>{{ $v['row']->medios }}</td>
                        <td>{{ $v['row']->supuestos }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td rowspan="{{ count($matriz['actividad'])+1 }}" class="text-center-middle">Actividades</td>
                </tr>
                @foreach($matriz['actividad'] as $v)
                    <tr>
                        <td><input type="checkbox" name="ids[]" class="ids" value="{{ $v['row']->idprograma_reg }}" @if(!$v['validate']) checked @endif></td>
                        <td>{{ $v['row']->descripcion }}

                            <div>
                                @if($v['validate'])
                                    <span class="c-success">Asignado a proyecto</span>
                                @else
                                    <span class="c-danger">Pendiente por asignar a proyecto</span>
                                @endif
                           </div>
                        </td>
                        <td class="text-center">{{ $v['row']->mir }}</td>
                        <td>{{ $v['row']->nombre }}</td>
                        <td>{{ $v['row']->formula }}</td>
                        <td class="text-center">
                            <div>{{ $v['row']->frecuencia }}</div>
                            <div>{{ $v['row']->tipo_indicador }}</div>
                        </td>
                        <td>{{ $v['row']->medios }}</td>
                        <td>{{ $v['row']->supuestos }}</td>
                    </tr>
                @endforeach
            </table>

    </div>
    

    <br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar </button>
    </article>

    </form>
</section>
<style>
    .btnmostrar:hover .btnhover{
        display: block;
    }
    .btnmostrar:hover tr{
        border-left:4px solid var(--ses-color-orange) !important;
    }
</style>
<script>
    $(".checkall").click(function() {
		var cblist = $(".ids");
		if($(this).is(":checked"))
		{
			cblist.prop("checked", !cblist.is(":checked"));
		} else {
			cblist.removeAttr("checked");
		}
	});
    $(".mySelect").select2();

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de guardar la información?',
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
            text: "Sí, guardar",
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
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    formData.append('type', "{{ $type }}");
                    formData.append('idy', "{{ $idy }}");
                    formData.append('id', "{{ $id }}");
                    $.ajax("{{ URL::to('anteproyecto/saveproy') }}", {
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
                                vm.$refs.componenteActivo?.rowsProjects();
                            }else{
                                toastr.error(row.message);
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