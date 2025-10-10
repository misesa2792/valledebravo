<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp">


        <table class="table">
            <tr>
                <td width="15%" class="text-center no-borders">
                    <img src="{{ asset('mass/images/tesoreria.png') }}" alt="Tesorería" width="90">
                </td>
                <td class="no-borders text-center c-white" style="background: #C00000;">
                    <div style="font-size:25px;margin-top:12px;" class="font-bold">TESORERÍA MUNICIPAL</div>
                    <div class="font-bold text-center s-18">DEPARTAMENTO DE PROGRAMACION Y CONTROL PRESUPUESTAL</div>
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td class="no-borders text-center c-white" style="background: #C00000;">
                    <div class="p-xs font-bold">SOLICITUD DE SUFICIENCIA PRESUPUESTAL DE SERVICIO</div>
                </td>
            </tr>
        </table>


        <article class="col-md-12 m-t-xs no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s16">
                    <td width="20%"><span class="c-text-alt"> FECHA DE ELABORACION:</span></td>
                    <td>{{ $row['fecha_elaboracion'] }}</td>
                    <td width="50"><span class="c-text-alt"> FOLIO:</span> </td>
                    <td width="15%">
                        <input type="text" name="folio" class="form-control border-b-1-dashed" placeholder="Ingresa folio" required>
                    </td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt"> DEPENDENCIA:</span></td>
                    <td colspan="3">{{ $row['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt"> UNIDAD SOLICITANTE:</span></td>
                    <td colspan="3">{{ $row['dep_aux'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt"> CLAVE PROGRAMÁTICA:</span></td>
                    <td colspan="3">{{ $row['no_dep_gen'].' '.$row['no_dep_aux'].' '.$row['no_proyecto'].' '.$row['clasificacion'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt"> TIPO DE RECURSO:</span></td>
                    <td colspan="3">{{ $row['fuente'] }}</td>
                </tr>
            </table>
        </article>

        <article class="col-md-12 m-t-xs no-padding">
			<table class="table table-bordered">
				<tr class="t-tr-s14 c-text-alt ">
					<th class="text-center c-white bg-tesoreria" width="100">PARTIDA</th>
					<th class="text-center c-white bg-tesoreria" colspan="3">DESCRIPCIÓN Y CARACTERÍSTICAS</th>
					<th class="text-center c-white bg-tesoreria">IMPORTE</th>
				</tr>
                @if($row['count'] > 10)
                    @foreach ($row['rowsRegistros'] as $key => $v)
                        <tr class="bg-white t-tr-s14 c-text-alt ">
                            @if($key == 0)
                                <th rowspan="{{ $row['count'] }}">{{ $row['no_partida'] }}</th>
                            @endif
                            <td colspan="3">{{ $v['desc'] }}</td>
                            <td class="text-right">{{ $v['importe'] }}</td>
                        </tr>
                    @endforeach
                @else 
                        @foreach ($row['rowsRegistros'] as $key => $v)
                            <tr class="bg-white t-tr-s14 c-text-alt ">
                                @if($key == 0)
                                    <th rowspan="{{ $row['count'] + $row['resta'] }}" class="text-center">{{ $row['no_partida'] }}</th>
                                @endif
                                <td colspan="3">{{ $v['desc'] }}</td>
                                <td class="text-right">{{ $v['importe'] }}</td>
                            </tr>
                        @endforeach
                         @for ($i=0 ; $i < $row['resta']; $i++)
                            <tr class="t-tr-s14 c-text-alt bg-white">
                                <td class="text-center c-white" colspan="3">{{  $row['no_partida'] }}</td>
                                <td></td>
                            </tr>
                        @endfor
                @endif

                <tr>
                    <td colspan="5" class="no-padding bg-white">
                        <div class="font-bold">O B S E R V A C I O N E S</div>
                        <p>{{ $row['obs'] }}</p>
                    </td>
                </tr>

				<tr class="t-tr-s14 c-text-alt bg-white">
                    <td rowspan="4" colspan="3" class="no-padding">

                        <table class="table table-bordered no-margins">
                            <tr>
                                <th colspan="2" class="bg-tesoreria c-white">DATOS DEL VEHÍCULO</th>
                                <th colspan="4" class="bg-tesoreria c-white">SERVICIO Y/O REPARACIÓN</th>
                            </tr>
                            <tr>
                                <td width="80">Marca:</td>
                                <td>{{ isset($servicios[1]) ? $servicios[1] : '' }}</td>
                                <td width="80">Afinación:</td>
                                <td>{{ isset($servicios[8]) ? $servicios[8] : '' }}</td>
                                <td width="80">Sistema de Enfriamiento:</td>
                                <td>{{ isset($servicios[15]) ? $servicios[15] : '' }}</td>
                            </tr>

                            <tr>
                                <td>No. Placas:</td>
                                <td>{{ isset($servicios[2]) ? $servicios[2] : '' }}</td>
                                <td>Frenos:</td>
                                <td>{{ isset($servicios[9]) ? $servicios[9] : '' }}</td>
                                <td>Sistema Eléctrico:</td>
                                <td>{{ isset($servicios[16]) ? $servicios[16] : '' }}</td>
                            </tr>

                            <tr>
                                <td>No. Económico:</td>
                                <td>{{ isset($servicios[3]) ? $servicios[3] : '' }}</td>
                                <td>Clutch:</td>
                                <td>{{ isset($servicios[10]) ? $servicios[10] : '' }}</td>
                                <td>Hojalatería</td>
                                <td>{{ isset($servicios[17]) ? $servicios[17] : '' }}</td>
                            </tr>

                            <tr>
                                <td>Modelo:</td>
                                <td>{{ isset($servicios[4]) ? $servicios[4] : '' }}</td>
                                <td>Trasmisión:</td>
                                <td>{{ isset($servicios[11]) ? $servicios[11] : '' }}</td>
                                <td>Pintura:</td>
                                <td>{{ isset($servicios[18]) ? $servicios[18] : '' }}</td>
                            </tr>

                            <tr>
                                <td>Combustible:</td>
                                <td>{{ isset($servicios[5]) ? $servicios[5] : '' }}</td>
                                <td>Suspensión:</td>
                                <td>{{ isset($servicios[12]) ? $servicios[12] : '' }}</td>
                                <td>Otro:</td>
                                <td>{{ isset($servicios[19]) ? $servicios[19] : '' }}</td>
                            </tr>

                            <tr>
                                <td>No. Motor:</td>
                                <td>{{ isset($servicios[6]) ? $servicios[6] : '' }}</td>
                                <td>Dirección:</td>
                                <td>{{ isset($servicios[13]) ? $servicios[13] : '' }}</td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Otro:</td>
                                <td>{{ isset($servicios[7]) ? $servicios[7] : '' }}</td>
                                <td>Motor:</td>
                                <td>{{ isset($servicios[14]) ? $servicios[14] : '' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                      
                    </td>
                    <th class="bg-white text-right" width="110">Sub-total:</th>
                    <th class="p-rel text-right bg-white" width="200"> <span class="p-abs" style="left:0px">$</span> {{ $row['subtotal'] }}</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th class="bg-white text-right" width="110">IVA:</th>
                    <th class="p-rel text-right bg-white" width="200"> <span class="p-abs" style="left:0px">$</span> {{ $row['iva'] }}</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th class="bg-white text-right" width="110">Total:</th>
                    <th class="p-rel text-right bg-white" width="200"> <span class="p-abs" style="left:0px">$</span> {{ $row['total'] }}</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <td class="no-borders bg-white" colspan="2">
                        <div class="text-center c-tesoreria s-12">FECHA REQUERIDA</div>
                        <table class="table table-bordered no-margins">
                            <tr>
                                <th class="text-center c-white bg-tesoreria">DÍA</th>
                                <th class="text-center c-white bg-tesoreria">MES</th>
                                <th class="text-center c-white bg-tesoreria">AÑO</th>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $row['fecha_requerida']['dia'] }}</td>
                                <td class="text-center">{{ $row['fecha_requerida']['mes'] }}</td>
                                <td class="text-center">{{ $row['fecha_requerida']['year'] }}</td>
                            </tr>
                        </table>

                        <div class="text-center c-tesoreria s-12">FECHA DEL SERVICIO</div>

                        <table class="table table-bordered no-margins">
                            <tr>
                                <th class="text-center c-white bg-tesoreria">DÍA</th>
                                <th class="text-center c-white bg-tesoreria">MES</th>
                                <th class="text-center c-white bg-tesoreria">AÑO</th>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $row['fecha_servicio']['dia'] }}</td>
                                <td class="text-center">{{ $row['fecha_servicio']['mes'] }}</td>
                                <td class="text-center">{{ $row['fecha_servicio']['year'] }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
			</table>

            <table class="table">
                <tr>
                    <td width="70%">
                        <div class="p-xs bg-white" style="border:1px solid black;border-radius:10px;">
                            <div class="text-center c-danger">DEPENDENCIA SOLICITANTE</div>

                            <table class="table">
                                <tr>
                                    <td width="50%" style="border:1px solid #C00000;">
                                        <div class="text-center">ÁREA USUARIA</div>
                                        <br>
                                        <br>
                                        <div>
                                            <input type="text" name="au_name" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa nombre..." required>
                                            <input type="text" name="au_puesto" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa puesto..." required>
                                        </div>
                                    </td>
                                    <td width="50%" style="border:1px solid #C00000;">
                                        <div class="text-center">VO. BO.</div>
                                        <br>
                                        <br>
                                        <div>
                                            <input type="text" name="vo_bo_name" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa nombre..." required>
                                            <input type="text" name="vo_bo_puesto" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa puesto..." required>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="30%">
                        <div class="p-xs bg-white" style="border:1px solid black;border-radius:10px;">
                            <div class="text-center c-danger">AUTORIZACIÓN PRESUPUESTAL</div>
                            <table class="table">
                                <tr>
                                    <td style="border:1px solid #C00000;">
                                        <br>
                                        <br>
                                        <br>
                                        <div>
                                            <input type="text" value="{{ $row['footer']['tesorero'] }}" name="tesorero" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa nombre..." required>
                                            <div class="text-center p-xs">TESORERO MUNICIPAL</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="table">
                <tr>
                    <td>
                        <div class="p-xs bg-white" style="border:1px solid black;border-radius:10px;">
                            <div class="text-center c-danger">VALIDACIÓN DE SUFICIENCIA PRESUPUESTAL</div>

                            <table class="table">
                                <tr>
                                    <td width="33%" style="border:1px solid #C00000;">
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="text-center">SELLO</div>
                                    </td>
                                    <td width="33%" style="border:1px solid #C00000;">
                                        <br>
                                        <br>
                                        <br>
                                        <div>
                                            <input type="text" value="{{ $row['footer']['prog_pres'] }}" name="prog_pres" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa nombre..." required>
                                            <div class="text-center">JEFA DEL DEPARTAMENTO DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL</div>
                                        </div>
                                    </td>
                                    <td width="33%" style="border:1px solid #C00000;">
                                        <br>
                                        <br>
                                        <br>
                                        <div>
                                            <input type="text" value="{{ $row['footer']['egresos'] }}" name="dir_egresos" class="form-control border-b-1-dashed text-center c-black" placeholder="Ingresa nombre..." required>
                                            <div class="text-center">DIRECTORA DE EGRESOS</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
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
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de generar el PDF?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                formData.append("id", "{{ $id }}");
                    $.ajax("{{ URL::to($pageModule.'/generateserviciospdf?k='.$token) }}", {
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
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
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