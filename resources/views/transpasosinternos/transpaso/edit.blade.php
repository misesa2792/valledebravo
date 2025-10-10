<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp" style="min-height:500px;" id="app_crear">

        <article class="col-md-12">
            <div class="col-md-8 no-padding"></div>
            <div class="col-md-4 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <td>Ejercicio Fiscal</td>
                        <th>{{ $row['anio'] }}</th>
                    </tr>
                </table>
            </div>
        </article>

        @if($row['type'] == 1)
            <article class="col-md-12">
                <div class="col-md-4 no-padding">
                    <table class="table table-bordered bg-white">
                        <tr class="t-tr-s14 c-text-alt">
                            <td>Municipio: </td>
                            <th class="text-center">{{ $row['municipio'] }}</th>
                            <td>No.</td>
                            <th class="text-center">{{ $row['no_municipio'] }}</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <td>FORMATO</td>
                            <th colspan="3" class="text-center">
                                <div class="c-blue">SOLICITUD DE TRASPASOS INTERNOS</div>
                            </th>
                        </tr>
                    </table>
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
                            <th>Dependencia General:</th>
                            <td>{{ $row['dep_int']['no_dep_gen'] }}</td>
                            <td>{{ $row['dep_int']['dep_gen'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Dependencia Auxiliar:</th>
                            <td>{{ $row['dep_int']['no_dep_aux'] }}</td>
                            <td>{{ $row['dep_int']['dep_aux'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Proyecto: </th>
                            <td>{{ $row['dep_int']['no_proyecto'] }}</td>
                            <td width="60%">{{ $row['dep_int']['proyecto'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Programa presupuestario: </th>
                            <td>{{ $row['dep_int']['no_programa'] }}</td>
                            <td>{{ $row['dep_int']['programa'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Objetivo: </th>
                            <td></td>
                            <td>{{ $row['dep_int']['obj_programa'] }}</td>
                        </tr>
                        
                    </table>
                </div>
            </article>
        @elseif($row['type'] == 2)
            <article class="col-md-12 no-padding">
                <div class="col-md-4">
                    <table class="table table-bordered bg-white">
                        <tr class="t-tr-s14 c-text-alt">
                            <td>Municipio: </td>
                            <th class="text-center">{{ $row['municipio'] }}</th>
                            <td>No.</td>
                            <th class="text-center">{{ $row['no_municipio'] }}</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <td>FORMATO</td>
                            <th colspan="3" class="text-center">
                                <div class="c-danger">SOLICITUD DE TRASPASOS EXTERNOS</div>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-8 no-padding"></div>
            </article>
            <article class="col-md-12 no-padding">
                <div class="col-md-6">
                    <table class="table table-bordered bg-white">
                        <tr class="t-tr-s14 c-text-alt">
                            <th colspan="3" class="text-center">DISMINUCIÓN</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th></th>
                            <th class="text-center">Clave</th>
                            <th class="text-center">Denominación</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Dependencia General:</th>
                            <td>{{ $row['dep_int']['no_dep_gen'] }}</td>
                            <td>{{ $row['dep_int']['dep_gen'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Dependencia Auxiliar:</th>
                            <td>{{ $row['dep_int']['no_dep_aux'] }}</td>
                            <td>{{ $row['dep_int']['dep_aux'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Proyecto: </th>
                            <td>{{ $row['dep_int']['no_proyecto'] }}</td>
                            <td width="60%">{{ $row['dep_int']['proyecto'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Programa presupuestario: </th>
                            <td>{{ $row['dep_int']['no_programa'] }}</td>
                            <td>{{ $row['dep_int']['programa'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Objetivo: </th>
                            <td></td>
                            <td>{{ $row['dep_int']['obj_programa'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered bg-white">
                        <tr class="t-tr-s14 c-text-alt">
                            <th colspan="3" class="text-center">AUMENTO</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th></th>
                            <th class="text-center">Clave</th>
                            <th class="text-center">Denominación</th>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Dependencia General:</th>
                            <td>{{ $row['dep_ext']['no_dep_gen'] }}</td>
                            <td>{{ $row['dep_ext']['dep_gen'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Dependencia Auxiliar:</th>
                            <td>{{ $row['dep_ext']['no_dep_aux'] }}</td>
                            <td>{{ $row['dep_ext']['dep_aux'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Proyecto: </th>
                            <td>{{ $row['dep_ext']['no_proyecto'] }}</td>
                            <td width="60%">{{ $row['dep_ext']['proyecto'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Programa presupuestario: </th>
                            <td>{{ $row['dep_ext']['no_programa'] }}</td>
                            <td>{{ $row['dep_ext']['programa'] }}</td>
                        </tr>
                        <tr class="t-tr-s14 c-text-alt">
                            <th>Objetivo: </th>
                            <td></td>
                            <td>{{ $row['dep_ext']['obj_programa'] }}</td>
                        </tr>
                    </table>
                </div>
            </article>
        @endif

        <input type="hidden" id="clave_programatica_int" value="{{ $row['dep_int']['clave_prog'] }}">
		<input type="hidden" id="clave_programatica_ext" value="{{ $row['dep_ext']['clave_prog'] }}">

        <article class="col-md-12">
            <table class="table">
                <tr class="t-tr-s14 c-text-alt">
                    <th colspan="5" width="49%" class="text-center bg-white">DISMINUCIÓN</th>
                    <th class="no-borders" width="5"></th>
                    <th colspan="5" width="49%" class="text-center bg-white">AUMENTO</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th class="bg-white">CLAVE PROGRAMATICA</th>
                    <th class="bg-white">F.F.</th>
                    <th class="bg-white">PARTIDA</th>
                    <th class="bg-white">MES</th>
                    <th class="bg-white">IMPORTE</th>
                    <th class="no-borders" width="5"></th>
                    <th class="bg-white">CLAVE <br> PROGRAMATICA</th>
                    <th class="bg-white">F.F.</th>
                    <th class="bg-white">PARTIDA</th>
                    <th class="bg-white">MES</th>
                    <th class="bg-white">IMPORTE</th>
                </tr>
                
                <tbody>
                    @foreach ($row['rowsRegistros'] as $h)

                        <tr id="tr_{{ $h['id'] }}">
                        {{--*/ $time = $h['id'] /*--}}

                            <td class="bg-white s-14">{{ $row['dep_int']['clave_prog'] }}</td>
                            <td class="bg-white" width="10%">
                                <input type="hidden" name="idr[]" value="{{ $time }}">
                                <select name="d_ff[]" class="mySelect full-width" required>
                                    <option value="">--Select Please--</option>
                                    @foreach ($rowsFF as $v)
                                        <option value="{{ $v->id }}" @if($v->id == $h['idteso_ff_n3']) selected @endif>{{ $v->no_fuente.' '.$v->fuente }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="bg-white" width="10%">
                                    <select name="d_partida[]" class="mySelect full-width" required>
                                        <option value="">--Select Please--</option>
                                        @foreach ($rowsPartidas as $v)
                                            <option value="{{ $v->id }}" @if($v->id == $h['d_idteso_partidas_esp']) selected @endif>{{ $v->no_partida.' '.$v->partida }}</option>
                                        @endforeach
                                    </select>
                            </td>
                            <td class="bg-white" width="5%">
                                    <select name="d_mes[]" class="form-control form-control-ses" required>
                                        <option value="">--Select Please--</option>
                                        @foreach ($rowsMes as $v)
                                        <option value="{{ $v->idmes }}" @if($v->idmes == $h['d_idmes']) selected @endif>{{ $v->mes }}</option>
                                        @endforeach
                                    </select>
                            </td>
                            <td class="bg-white">
                                <input type="text" value="{{ $h['importe'] }}" name="d_importe[]" class="form-control no-borders form-control-ses" placeholder="Importe" id="d_importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
                            </td>
                            
                            <td class="no-borders"></td>
                            
                            <td class="bg-white s-14" >{{ $row['dep_ext']['clave_prog'] }}</td>
                            <td class="bg-white" width="10%"></td>
                            <td class="bg-white" width="10%">
                                <select name="a_partida[]" class="mySelect full-width" required>
                                    <option value="">--Select Please--</option>
                                    @foreach ($rowsPartidas as $v)
                                        <option value="{{ $v->id }}" @if($v->id == $h['a_idteso_partidas_esp']) selected @endif>{{ $v->no_partida.' '.$v->partida }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="bg-white" width="5%">
                                    <select name="a_mes[]" class="form-control form-control-ses" required>
                                        <option value="">--Select Please--</option>
                                        @foreach ($rowsMes as $v)
                                        <option value="{{ $v->idmes }}" @if($v->idmes == $h['a_idmes']) selected @endif>{{ $v->mes }}</option>
                                        @endforeach
                                    </select>
                            </td>
                            <td class="bg-white">
                                <input type="text" value="{{ $h['importe'] }}" name="a_importe[]" class="form-control no-borders form-control-ses" id="a_importe{{ $time }}" placeholder="Importe" readonly>
                            </td>
                            
                            <td class="text-center no-borders">
                                <i class="fa fa-trash-o c-danger cursor btndestroyedit s-16" id="{{ $time }}"></i>
                            </td>
                        </tr>
                   @endforeach
                </tbody>
        
                <tbody id="_tbody" class="no-borders"></tbody>
            
                
                <tbody class="no-borders">
                    <tr class="t-tr-s14">
                        <td class="no-borders">
                            <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses btnagregar" > <i class="fa fa-plus"></i> Agregar</button>
                        </td>
                        <td></td>
                        <td></td>
                        <th class=" c-text-alt">Total:</th>
                        <td>
                            <input type="text" name="importe" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                        </td>
        
                        <td class="no-borders"></td>
        
                        <td></td>
                        <td></td>
                        <td></td>
                        <th class=" c-text-alt">Total:</th>
                        <td>
                            <input type="text" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </article>
        
        <article class="col-md-12 m-t-md">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s16">
                    <th width="60%" class="c-text-alt no-borders">JUSTIFICACIÓN</th>
                    <th class="text-right no-borders"><p id="contadorCaracteresJust" class="c-danger">Carácteres restantes: 500</p></th>
                </tr>
                <tr class="t-tr-s16">
                    <td colspan="2">
                        <div style="min-height: 80px;">
                            <textarea name="justificacion" id="txtjustificacion" rows="5" class="form-control no-borders bg-transparent" placeholder="Justificación" required>{{ $row['justificacion'] }}</textarea>
                        </div>
                    </td>
                </tr>
            </table> 
        </article>
        
        <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
        </article>

        

    </section>
</form>

<script>
    $(".mySelect").select2();
	
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
      formData.append("id", "{{ $id }}");
      formData.append("idyear", "{{ $idyear }}");
        $.ajax("{{ URL::to($pageModule.'/edit?k='.$token) }}", {
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
                    proyectos.rowsProjects();
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

    limitarCaracteres('txtjustificacion', 'contadorCaracteresJust', 500);

    $(".btnagregar").click(function(e){
    e.preventDefault();
        let clave_int = $("#clave_programatica_int").val();
        let clave_ext = $("#clave_programatica_ext").val();

        let btnagregar = '<i class="fa fa-plus"></i> Agregar';
        $(".btnagregar").prop("disabled",true).html(mss_spinner);
        axios.get('{{ URL::to("transpasosinternos/addtr") }}',{
            params : {clave_int:clave_int,clave_ext:clave_ext, idyear: "{{ $idyear }}", k:"{{ $token }}"},
        }).then(response => {
            var row = response.data;
            $("#_tbody").append(response.data);
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).catch(error => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).finally(() => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        });

    });

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
                sumarImporte();
            }
        })
    })

    $(document).on("click",".btndestroyedit",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willDelete) => {
            if(willDelete){

                axios.delete('{{ URL::to("transpasosinternos/transpasoreg") }}',{
                    params : { k: "{{ $token }}", id:time},
                }).then(response => {
                    var row = response.data;
                    if(row.status == "ok"){
                        $("#tr_"+time).remove();
                        sumarImporte();
                        toastr.success(row.message);
                    }
                });

               
            }
        })
    })

    function sumarImporte(){
        let cantidad = 0;
        var cant = document.getElementsByName('d_importe[]');
        for(key=0; key < cant.length; key++)  {
            if(cant[key].value != ''){
                var valor = cant[key].value;
                cantidad = cantidad + parseFloat(valor.replace(/[^0-9.]/g, ''));
            }
        }
        let numeroFormateadoMX = cantidad.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $(".txtimporte").val(numeroFormateadoMX);
    }

    function totalImporte(time) {
        let importe = $("#d_importe"+time).val();
        if (!/^([0-9\.,])*$/.test(importe)){
            toastr.error("Importe, No es un número!");
            $("#d_importe"+time).addClass("border-2-dashed-red");
            $("#d_importe"+time).removeClass("no-borders");
        }else{
            $("#d_importe"+time).addClass("no-borders");
            $("#d_importe"+time).removeClass("border-2-dashed-red");
        }
        let t1 = (importe == "" ? 0 : importe);
        $("#a_importe"+time).val(t1);
        sumarImporte();
    } 


    sumarImporte();

</script>