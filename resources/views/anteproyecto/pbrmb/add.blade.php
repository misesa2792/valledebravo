<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-8 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data['year'] }}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                    <td>Municipio: </td>
                    <th class="text-center">{{ $data['no_institucion'] }}</th>
                    <td>No.</td>
                    <th class="text-center">{{ $data['institucion'] }}</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <td>PbRM-01b</td>
                    <th colspan="3" class="text-center">
                        <div>Programa Anual</div>
                        <div>Descripción del programa presupuestario</div>
                    </th>
                </tr>
            </table>

            <div class="alert alert-danger" role="alert">

                <strong>Notas importantes</strong>

                <h5 style="margin:10px 0 6px;"><span class="text-danger">FODA</span></h5>
                <ul style="margin-bottom:8px;" class="c-text-alt s-10">
                    <li>Redacta en oración normal: <em>Mayúscula inicial y resto en minúsculas</em> (no todo en MAYÚSCULAS).</li>
                </ul>
            </div>
           
        </div>
        <div class="col-md-1 no-padding"></div>
        <div class="col-md-7 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                   <th width="20%"></th>
                   <th class="text-center" width="40">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td id="proy_no"></td>
                    <td>
                        <select name="idprograma" class="mySelect full-width" id="sltprograma" required>
                            <option value="">--Selecciona Programa--</option>
                            @foreach ($rowsPogramas as $v)
                            <option value="{{ $v->id }}" data-obj="{{ $v->obj_programa }}">{{ $v->no_programa.' '.$v->programa }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th>Dependencia General:</th>
                    <td>{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <article class="col-md-12 m-b-md">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th width="60%" class="c-text-alt no-borders">Diagnóstico de Programa presupuestario elaborado usando análisis FODA </th>
                <th class="text-right no-borders"></th>
            </tr>
            <tr class="t-tr-s14">
                <td colspan="2">
                    <div>FORTALEZAS</div>
                    <div>
                        <table class="table">
                            <tr>
                                <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <textarea name="foda[1][]" id="foda1" rows="1" class="form-control no-borders" placeholder="Fortaleza"></textarea>
                                </td>
                                <td width="10" class="text-center no-borders"></td>
                            </tr>

                            <tbody id="_tbody1" class="no-borders"></tbody>
                            <tbody class="no-borders">
                                <tr>
                                    <td class="no-borders" colspan="3">
                                        <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses" id="btnadd1" data-num="1"> <i class="fa fa-plus"></i> Agregar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>OPORTUNIDADES</div>
                    <div>
                        <table class="table">
                            <tr>
                                <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <textarea name="foda[2][]" id="foda2" rows="1" class="form-control no-borders" placeholder="Oportunidad"></textarea>
                                </td>
                                <td width="10" class="text-center no-borders"></td>
                            </tr>

                            <tbody id="_tbody2" class="no-borders"></tbody>
                            <tbody class="no-borders">
                                <tr>
                                    <td class="no-borders" colspan="3">
                                        <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses" id="btnadd2" data-num="2"> <i class="fa fa-plus"></i> Agregar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>DEBILIDADES</div>
                    <div>
                        <table class="table">
                            <tr>
                                <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <textarea name="foda[3][]" id="foda3" rows="1" class="form-control no-borders" placeholder="Debilidad"></textarea>
                                </td>
                                <td width="10" class="text-center"></td>
                            </tr>

                            <tbody id="_tbody3" class="text-center no-borders"></tbody>
                            <tbody class="no-borders">
                                <tr>
                                    <td class="no-borders" colspan="3">
                                        <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses" id="btnadd3" data-num="3"> <i class="fa fa-plus"></i> Agregar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>AMENAZAS</div>
                    <div>
                        <table class="table">
                            <tr>
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <textarea name="foda[4][]" id="foda4" rows="1" class="form-control no-borders" placeholder="Amenaza"></textarea>
                                </td>
                                <td width="10" class="text-center"></td>
                            </tr>
                            <tbody id="_tbody4" class="no-borders"></tbody>
                            <tbody class="no-borders">
                                <tr>
                                    <td class="no-borders" colspan="3">
                                        <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses" id="btnadd4" data-num="4"> <i class="fa fa-plus"></i> Agregar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table> 
    </article>

    <article class="col-md-12 m-b-md">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th width="60%" class="c-text-alt no-borders">Estrategias para alcanzar el objetivo del Programa presupuestario</th>
                <th class="text-right no-borders"></th>
            </tr>
            <tr class="t-tr-s14">
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                            <td class="no-borders">
                                <textarea name="estrategias[]" rows="1" class="form-control no-borders" placeholder="Estrategias para alcanzar el objetivo del Programa presupuestario"></textarea>
                            </td>
                            <td width="10" class="text-center no-borders"></td>
                        </tr>

                        <tbody id="_tbody5" class="no-borders"></tbody>

                        <tbody class="no-borders">
                            <tr>
                                <td class="no-borders" colspan="3">
                                    <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses btnadd" id="btnadd5" data-num="5"> <i class="fa fa-plus"></i> Agregar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            </tr>
        </table> 
    </article>

    <article class="col-md-12 m-b-md">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th width="60%" class="c-text-alt no-borders">Objetivo, Estrategias y Líneas de Acción del PDM atendidas</th>
                <th class="text-right no-borders"></th>
            </tr>
            <tr class="t-tr-s14">
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                            <td class="no-borders">
                                <select name="idlinea_accion[]" class="mySelect" required>
                                    <option value="">--Select Please--</option>
                                    @foreach ($rowsPDM as $v)
                                        <option value="{{ $v->id }}">{{ $v->no_linea_accion.' '.$v->linea_accion }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td width="10" class="text-center no-borders"></td>
                        </tr>

                        <tbody id="_tbody6" class="no-borders"></tbody>

                        <tbody class="no-borders">
                            <tr>
                                <td class="no-borders" colspan="3">
                                    <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses btnadd" id="btnadd6" data-num="6"> <i class="fa fa-plus"></i> Agregar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            </tr>
        </table> 
    </article>

    <article class="col-md-12 m-b-md">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th width="60%" class="c-text-alt no-borders">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario</th>
                <th class="text-right no-borders"></th>
            </tr>
            <tr class="t-tr-s14">
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                            <td class="no-borders">
                                <select name="idods[]" class="mySelect" required>
                                    <option value="">--Select Please--</option>
                                    @foreach ($rowsODS as $v)
                                        <option value="{{ $v->id }}">{{ $v->meta }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td width="10" class="text-center no-borders"></td>
                        </tr>

                        <tbody id="_tbody7" class="no-borders"></tbody>

                        <tbody class="no-borders">
                            <tr>
                                <td class="no-borders" colspan="3">
                                    <button type="button" class="btn btn-xs btn-primary btn-outline b-r-30 btn-ses btnadd" id="btnadd7" data-num="7"> <i class="fa fa-plus"></i> Agregar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            </tr>
        </table> 
    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>

    </form>
</section>
<script>
    $(".mySelect").select2();

    function agregarTr(text,num){
		$("#"+text).prop("disabled",true).html(mss_spinner);
        axios.get('{{ URL::to("anteproyecto/addpbrmbtr") }}',{
            params : {num:num,idy:"{{ $idy }}"}
        }).then(response => {
			$("#"+text).prop("disabled",false).html('<i class="fa fa-plus"></i> Agregar');
            $("#_tbody"+num).append(response.data);
        })
    }

    $(document).on("click",".btndestroy",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                $("#tr_"+time).remove();
            }
          })
    })

    $("#btnadd1").click(function(e){
        e.preventDefault();
        agregarTr("btnadd1",1);
    })
    $("#btnadd2").click(function(e){
        e.preventDefault();
        agregarTr("btnadd2",2);
    })
    $("#btnadd3").click(function(e){
        e.preventDefault();
        agregarTr("btnadd3",3);
    })
    $("#btnadd4").click(function(e){
        e.preventDefault();
        agregarTr("btnadd4",4);
    })

    $(".btnadd").click(function(e){
        e.preventDefault();
        let num = $(this).data("num");
        agregarTr("btnadd"+num,num);
    })

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
            title : 'Estás seguro de guardar?',
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
                    $.ajax("{{ URL::to('anteproyecto/savepbrmb') }}", {
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