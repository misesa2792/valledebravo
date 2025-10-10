<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp" style="min-height:500px;" id="app_crear">

        <article class="col-md-12">
            <div class="col-md-8 no-padding"></div>
            <div class="col-md-4 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <td>Ejercicio Fiscal</td>
                        <th>{{ $row->anio }}</th>
                    </tr>
                </table>
            </div>
        </article>

        <article class="col-md-12">
            <div class="col-md-4 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <td>Municipio: </td>
                        <th class="text-center">{{ $row->municipio }}</th>
                        <td>No.</td>
                        <th class="text-center">{{ $row->no_municipio }}</th>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <td>FORMATO</td>
                        <th colspan="3" class="text-center">
                            <div>SOLICITUD DE SUFICIENCIA PRESUPUESTAL DE SERVICIO</div>
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
                        <td>{{ $row->no_dep_gen }}</td>
                        <td>{{ $row->dep_gen }}</td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Dependencia Auxiliar:</th>
                        <td>{{ $row->no_dep_aux }}</td>
                        <td>{{ $row->dep_aux }}</td>
                    </tr>
					<tr class="t-tr-s14 c-text-alt">
                        <th>Clave Programatica: </th>
                        <td id="clave_programatica"></td>
                        <td width="60%">
							<select name="idproyecto" class="mySelect full-width" onchange="obtenerValorData()" id="sltproject" required>
								<option value="">--Select Please--</option>
								@foreach ($rows_projects as $v)
									<option value="{{ $v->id }}" 
										data-no_proyecto="{{ $v->no_proyecto }}" 
										data-clasificacion="{{ $v->clasificacion }}" 
                                        @if($row->idproyecto == $v->id) selected @endif
											>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
								@endforeach
							</select>
						</td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Tipo de Recurso:</th>
                        <td></td>
                        <td>
                            <select name="idteso_ff_n3" class="mySelect full-width" required>
                                <option value="">--Select Please--</option>
                                @foreach ($rowsFF as $v)
                                    <option value="{{ $v->id }}" 
                                        @if($row->idteso_ff_n3 == $v->id) selected @endif
                                        >{{ $v->no_fuente.' '.$v->fuente }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Fecha Requerida:</th>
                        <td></td>
                        <td>
                            <input type="text" value="{{ $row->fecha_requerida }}" name="fecha_requerida" class="form-control date" placeholder="0000-00-00" required>
                        </td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Fecha Servicio:</th>
                        <td></td>
                        <td>
                            <input type="text" value="{{ $row->fecha_servicio }}" name="fecha_servicio" class="form-control date" placeholder="0000-00-00" required>
                        </td>
                    </tr>
                </table>
            </div>
        </article>

        <div class="col-md-12 bg-white">
            <div class="col-md-3 ">
                <table class="table">
                    <tr class="t-tr-s14 c-text-alt">
                        <th class="bg-white">PARTIDA (S)</th>
                    </tr>
                    <tr>
                       <td>
                        <select name="idesp" class="mySelect full-width" required>
                            <option value="">--Select Please--</option>
                            @foreach ($rowsPartidas as $v)
                                <option value="{{ $v->id }}" 
                                    @if($row->idteso_partidas_esp == $v->id) selected @endif
                                    >{{ $v->no_partida.' '.$v->partida }}</option>
                            @endforeach
                        </select>
                       </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-9">
                <table class="table">
                    <tr class="t-tr-s14 c-text-alt">
                        <th class="bg-white" colspan="2">DESCRIPCIÓN Y CARACTERÍSTICAS</th>
                        <th width="60"></th>
                        <th class="bg-white" width="140">IMPORTE</th>
                        <th class="bg-white" width="30">ACCIÓN</th>
                    </tr>
                    @foreach ($rowsRegistros as $kreg => $v)
                        <tr id="tr_{{ $v->id }}">
                            <td class="bg-white" colspan="2">
                            <input type="hidden" name="idr[]" value="{{ $v->id }}">
                                <input type="text" value="{{ $v->nombre }}" name="desc[]" class="form-control no-borders form-control-ses" placeholder="DESCRIPCIÓN Y CARACTERÍSTICAS DEL (OS)  BIEN (ES)" required>
                            </td>
                            <td></td>
                            <td class="bg-white">
                                <input type="text" value="{{ $v->importe }}" name="importe[]" class="form-control no-borders form-control-ses" placeholder="IMPORTE" id="importe{{ $v->id }}" onKeyUp="totalImporte({{ $v->id }})" required>
                            </td>
                            <td class="text-center no-borders">
                                @if($kreg > 0)
                                    <i class="fa fa-trash-o c-danger cursor btndestroyedit s-16" id="{{ $v->id }}"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    <tbody id="_tbody" class="no-borders"></tbody>

                    <tr class="t-tr-s14">
                        <td class="no-borders">
                            <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses btnagregar" > <i class="fa fa-plus"></i> Agregar</button>
                        </td>
                        <td class="text-right no-borders">SUBTOTAL:</td>
                        <td></td>
                        <td>
                            <input type="text" value="{{ $row->subtotal }}" name="subtotal" class="form-control no-borders form-control-ses" placeholder="SUBTOTAL" id="txtsubtotal" readonly required>
                        </td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td colspan="2" class="text-right no-borders">I.V.A:</td>
                        <td>
                            <select name="porc_iva" class="form-control" style="height:25px;padding:2px;" id="sltiva" required>
                                <option value="16" @if($row->porc_iva == "16") selected @endif>Si</option>
                                <option value="0" @if($row->porc_iva == "0") selected @endif>No</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="{{ $row->iva }}" name="iva" class="form-control no-borders form-control-ses" placeholder="I.V.A" id="txtiva" readonly required>
                        </td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td colspan="2" class="text-right no-borders">TOTAL:</td>
                        <td></td>
                        <td>
                            <input type="text" value="{{ $row->total }}" name="total" class="form-control no-borders form-control-ses" placeholder="TOTAL" id="txttotal" readonly required>
                        </td>
                    </tr>
                </table>
            </div>
            
        </div>

        <div class="col-md-12 bg-white m-t-md no-padding">
            <div class="col-md-6">
                <div class="col-md-12 s-14 c-text-alt text-center p-xs font-bold">DATOS DEL VEHÍCULO</div>

                <table class="table table-bordered">
            
                    @foreach ($rowsServicios as $v)
                        @if($v->tipo == 1)
                            <tr class="t-tr-s14">
                                <td width="30%">{{ $v->descripcion }}</td>
                                <td>
                                    <input type="text" value="{{ isset($servicios[$v->id]) ? $servicios[$v->id] : '' }}" name="idser[{{ $v->id }}]" class="form-control no-borders form-control-ses" placeholder="{{ $v->descripcion }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>

            <div class="col-md-6 ">
                <div class="col-md-12 s-14 c-text-alt text-center p-xs font-bold">SERVICIO Y/O REPARACIÓN</div>

                <table class="table table-bordered">
            
                    @foreach ($rowsServicios as $v)
                        @if($v->tipo == 2)
                            <tr class="t-tr-s14">
                                <td width="30%">{{ $v->descripcion }}</td>
                                <td>
                                    <input type="text" value="{{ isset($servicios[$v->id]) ? $servicios[$v->id] : '' }}" name="idser[{{ $v->id }}]" class="form-control no-borders form-control-ses" placeholder="{{ $v->descripcion }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>


        <article class="col-md-12 m-t-md no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s16">
                    <th width="60%" class="c-text-alt no-borders">OBSERVACIONES</th>
                    <th class="text-right no-borders"><p id="contadorCaracteresJust" class="c-danger">Carácteres restantes: 500</p></th>
                </tr>
                <tr class="t-tr-s16">
                    <td colspan="2">
                        <div style="min-height: 80px;">
                            <textarea name="obs" id="txtjustificacion" rows="5" class="form-control no-borders bg-transparent" placeholder="OBSERVACIONES" required>{{ $row->obs }}</textarea>
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
    limitarCaracteres('txtjustificacion', 'contadorCaracteresJust', 500);
    $('.date').datepicker({format: 'yyyy-mm-dd'});

	function obtenerValorData() {
        var select = document.getElementById("sltproject");
        var opcionSeleccionada = select.options[select.selectedIndex];
        var no_proyecto = opcionSeleccionada.getAttribute("data-no_proyecto");
        var clasificacion = opcionSeleccionada.getAttribute("data-clasificacion");
        $("#td_no_proyecto").html(no_proyecto);
		let clave = "{{ $row->no_dep_gen }} " + "{{ $row->no_dep_aux }} " + no_proyecto +" "+ clasificacion;
		$("#clave_programatica").html(clave);
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
                getTotales();
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
                
                axios.delete('{{ URL::to($pageModule."/serviciosbienes") }}',{
                    params : { k: "{{ $token }}", id:time},
                }).then(response => {
                    var row = response.data;
                    if(row.status == "ok"){
                        $("#tr_"+time).remove();
                        getTotales();
                        toastr.success(row.message);
                    }
                });

            }
          })
    })

    

    $(".btnagregar").click(function(e){
    e.preventDefault();
        agregarTR();
    });

    function agregarTR(){
        let btnagregar = '<i class="fa fa-plus"></i> Agregar';

        $(".btnagregar").prop("disabled",true).html(mss_spinner);

        axios.get('{{ URL::to($pageModule."/addtrservicios") }}',{
            params : {k:"{{ $token }}"},
        }).then(response => {

            var row = response.data;
            $("#_tbody").append(response.data);

            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).catch(error => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).finally(() => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        });
    }

    function totalImporte(time) {
        let importe = $("#importe"+time).val();

        if (!/^([0-9\.,])*$/.test(importe)){
            toastr.error("Importe, No es un número!");
            $("#importe"+time).addClass("border-2-dashed-red");
            $("#importe"+time).removeClass("no-borders");
        }else{
            $("#importe"+time).addClass("no-borders");
            $("#importe"+time).removeClass("border-2-dashed-red");
        }
        getTotales();
    } 

    $("#sltiva").on("change", function(e) {
        e.preventDefault();
        getTotales();
    })

    function getTotales(){
        let sltiva = $("#sltiva").val();

        let cantidad = 0;
        var cant = document.getElementsByName('importe[]');
        for(key=0; key < cant.length; key++)  {
            if(cant[key].value != ''){
                var valor = cant[key].value;
                cantidad = cantidad + parseFloat(valor.replace(/[^0-9.]/g, ''));
            }
        }

        if(sltiva > 0){
            let iva = cantidad * 0.16;

            let total = cantidad + iva;
            $("#txtsubtotal").val(cantidad.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $("#txtiva").val(iva.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $("#txttotal").val(total.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }else{
            $("#txtsubtotal").val(cantidad.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $("#txtiva").val('0.00');
            $("#txttotal").val(cantidad.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
     
    }

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
      formData.append("id", "{{ $id }}");
        $.ajax("{{ URL::to($pageModule.'/editservicios?k='.$token) }}", {
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
</script>