<form id="saveInfo" method="post" class="form-horizontal">
    <table class="table">
        <tr>
            <td class="no-borders" width="10%" rowspan="3">
                 @if(!empty($data['footer']['firmas']['logo_izq'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="no-borders text-center font-bold s-14 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td class="no-borders" width="10%" rowspan="3">
                @if(!empty($data['footer']['firmas']['logo_der'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['year'] }}</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>


<br>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $data['year'] }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">PbRM-01c</td>
                <th colspan="3" class="text-center">
                    <div>Programa Anual de Metas de Actividad por Proyecto</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-6 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Proyecto: </th>
                <td class="text-center">{{ $data['no_proyecto'] }}</td>
                <td>{{ $data['proyecto'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia Auxiliar:</th>
                <td class="text-center">{{ $data['no_dep_aux'] }}</td>
                <td>{{ $data['dep_aux'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td colspan="3">
                    <strong>Descripción del Proyecto: </strong> {{ $data['obj_proyecto'] }}
                </td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="3" width="40" class="text-center">Código</th>
            <th rowspan="3" width="30%" class="text-center">Descripción de las Metas de Actividad sustantivas relevantes</th>
            <th colspan="4" class="text-center">Metas de actividad</th>
            <th colspan="2" class="text-center">Variación</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="2" class="bg-gray text-center">Unidad de Medida</th>
            <th colspan="2" class="bg-gray text-center">{{ $data['year'] - 1 }}</th>
            <th rowspan="2" class="bg-gray text-center">
                <div>{{ $data['year'] }}</div>
                <div>Programado</div>
            </th>
            <th rowspan="2" class="text-center">Absoluta</th>
            <th rowspan="2" class="text-center">%</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th class="bg-gray text-center">Programado</th>
            <th class="bg-gray text-center">Alcanzado</th>
        </tr>
        @foreach ($data['rowsMetas'] as $p)
            <tr class="bg-white t-tr-s12 c-text-alt">
                <td class="text-center">{{ $p->codigo }}</td>
                <td>{{ $p->meta }}</td>
                <td class="text-center">{{ $p->unidad_medida }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->programado) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->alcanzado) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->anual) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->absoluta) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->porcentaje) }}</td>
            </tr>
        @endforeach
        
        @if(count($data['rowsMetas']) <= 10)
            @for ($i = 0; $i < 5; $i++)
            <tr class="bg-white t-tr-s12 c-white">
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
                <td class="no-borders">.</td>
            </tr>
            @endfor
        @endif
    </table>
</div>

<br>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text">
                <td>Presupuesto Total:</td>
                <th class="c-text">$ {{ $data['presupuesto'] }}</th>
            </tr>
        </table>
    </div>
</div>

    @if($view == 'pdf')
    <div class="col-md-12">
        <table class="table">
            <tr class="t-tr-s12 c-text">
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">ELABORÓ</div>
                    <div class="font-bold c-text-alt"></div>
                    <br>
                    <input type="text" name="titular1" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                    <input type="text" name="cargo1" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
                <th class="no-borders"></th>
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">Vo.Bo.</div>
                    <div class="font-bold c-text-alt">TESORERO MUNICIPAL</div>
                    <br>
                    <input type="text" name="titular2" value="{{$data['footer']['firmas']['t_tesoreria']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                    <input type="text" name="cargo2" value="{{$data['footer']['firmas']['c_tesoreria']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
                <th class="no-borders"></th>
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">AUTORIZÓ</div>
                    <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                    <br>
                    <input type="text" name="titular3" value="{{$data['footer']['firmas']['t_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                    <input type="text" name="cargo3" value="{{$data['footer']['firmas']['c_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
        </tr>
        </table>
    </div>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
    </article>
    @endif
</form>
<script>
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
            title : 'Estás seguro de generar el PDF?',
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
            text: "Sí, generar PDF",
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
                    formData.append('type', "{{ $type }}");
                    $.ajax("{{ URL::to('anteproyecto/pdfpbrmc?id='.$id) }}", {
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
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.data.number, '_blank');
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