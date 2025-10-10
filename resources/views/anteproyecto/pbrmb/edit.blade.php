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
                   <th></th>
                   <th class="text-center">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td>{{ $data['no_programa'] }}</td>
                    <td>{{ $data['programa'] }}</td>
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
                            @foreach($data['fortalezas'] as $kfo => $value)
                                <tr id="tr_fo{{ $kfo }}">
                                    <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                    <td class="no-borders">
                                        <textarea name="foda[1][]" id="foda1" rows="1" class="form-control no-borders" placeholder="Fortaleza">{{ $value }}</textarea>
                                    </td>
                                    <td width="10" class="text-center">
                                        <i class="fa fa-trash-o var s-18 cursor btndestroy" id="fo{{ $kfo }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                            
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
                            @foreach($data['oportunidades'] as $kop => $value)
                                <tr id="tr_op{{ $kop }}">
                                    <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                    <td class="no-borders">
                                        <textarea name="foda[2][]" id="foda2" rows="1" class="form-control no-borders" placeholder="Oportunidad">{{ $value }}</textarea>
                                    </td>
                                    <td width="10" class="text-center">
                                        <i class="fa fa-trash-o var s-18 cursor btndestroy" id="op{{ $kop }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                           
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
                            @foreach($data['debilidades'] as $kde => $value)
                                <tr id="tr_de{{ $kde }}">
                                    <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                    <td class="no-borders">
                                        <textarea name="foda[3][]" id="foda3" rows="1" class="form-control no-borders" placeholder="Debilidad">{{ $value }}</textarea>
                                    </td>
                                    <td width="10" class="text-center">
                                        <i class="fa fa-trash-o var s-18 cursor btndestroy" id="de{{ $kde }}"></i>
                                    </td>
                                </tr>
                            @endforeach

                            <tbody id="_tbody3" class="no-borders"></tbody>
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
                            @foreach($data['amenazas'] as $kam => $value)
                                <tr id="tr_am{{ $kam }}">
                                    <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                    <td class="no-borders">
                                        <textarea name="foda[4][]" id="foda4" rows="1" class="form-control no-borders" placeholder="Amenaza">{{ $value }}</textarea>
                                    </td>
                                    <td width="10" class="text-center">
                                        <i class="fa fa-trash-o var s-18 cursor btndestroy" id="am{{ $kam }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                            
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
                        @foreach($data['estrategias'] as $ke => $value)
                            <tr id="tr_e{{ $ke }}">
                                <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <textarea name="estrategias[]" rows="1" class="form-control no-borders" placeholder="Estrategias para alcanzar el objetivo del Programa presupuestario">{{ $value }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o var s-18 cursor btndestroy" id="e{{ $ke }}"></i>
                                </td>
                            </tr>
                        @endforeach
                        
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
                        @foreach($data['lineas_accion'] as $kl => $value)
                            <tr id="tr_l{{ $kl }}">
                                <td width="10" class="text-centrar no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <select name="idlinea_accion[]" class="mySelect" required>
                                        <option value="">--Select Please--</option>
                                        @foreach ($data['rowsPDM'] as $v)
                                            <option value="{{ $v->id }}" @if($v->id == $value) selected @endif>{{ $v->no_linea_accion.' '.$v->linea_accion }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o var s-18 cursor btndestroy" id="l{{ $kl }}"></i>
                                </td>
                            </tr>
                        @endforeach

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
                        @foreach($data['ods'] as $ko => $value)
                            <tr id="tr_o{{ $ko }}">
                                <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td class="no-borders">
                                    <select name="idods[]" class="mySelect" required>
                                        <option value="">--Select Please--</option>
                                        @foreach ($data['rowsODS'] as $v)
                                            <option value="{{ $v->id }}" @if($v->id == $value) selected @endif>{{ $v->meta }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o var s-18 cursor btndestroy" id="o{{ $ko }}"></i>
                                </td>
                            </tr>
                        @endforeach

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


    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
            title : 'Estás seguro de editar el FODA?',
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
            text: "Sí, editar",
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
                    $.ajax("{{ URL::to('anteproyecto/updatepbrmb') }}", {
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