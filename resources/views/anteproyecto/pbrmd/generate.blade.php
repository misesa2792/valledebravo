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
            <td class="no-borders text-center font-bold s-14 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['anio'] }}</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>

    <br>
        <h3 class="text-center c-text-alt">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $data['anio'] }}</h3>
    <br>

    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th>Pilar/Eje Transversal: </th>
                    <td class="text-center">{{ $data['no_pilar'] }}</td>
                    <td>{{ $data['pilar'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Tema de Desarrollo: </th>
                    <td class="text-center">{{ $data['no_tema'] }}</td>
                    <td>{{ $data['tema'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center">{{ $data['no_programa'] }}</td>
                    <td>{{ $data['programa'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto: </th>
                    <td class="text-center">{{ $data['no_proyecto'] }}</td>
                    <td>{{ $data['proyecto'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Objetivo del programa presupuestario: </th>
                    <td></td>
                    <td>{{ $data['obj_programa'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td class="text-center">{{ $data['no_dep_aux'] }}</td>
                    <td>{{ $data['dep_aux'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <br>
    <h3 class="text-center c-text-alt">ESTRUCTURA DEL INDICADOR</h3>
    <br>

    <table class="table table-bordered bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Nombre del Indicador</th>
            <td colspan="3">{{ $data['indicador'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Fórmula de Cálculo</th>
            <td colspan="3">{{ $data['formula'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Interpretación</th>
            <td colspan="3">{{ $data['interpretacion'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Dimensión que Atiende</th>
            <td>{{ $data['dimencion'] }}</td>
            <th width="15%" class="text-right">Frecuencia de Medición</th>
            <td>{{ $data['frecuencia'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Factor de Comparación</th>
            <td>{{ $data['factor'] }}</td>
            <th width="15%" class="text-right">Tipo de Indicador</th>
            <td>{{ $data['tipo_indicador'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Descripción del Factor de Comparación</th>
            <td colspan="3">{{ $data['factor_desc'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Línea Base</th>
            <td colspan="3">{{ $data['linea_base'] }}</td>
        </tr>
    </table>

    <br>
<h3 class="text-center c-text-alt">CALENDARIZACIÓN TRIMESTRAL</h3>
<br>

<div class="col-md-12 ">
    <table class="table table-bordered">
        <tr class="t-tr-s12 c-text-alt">
            <th width="20%" class="text-center">Variables del Indicador</th>
            <th class="text-center">Unidad de Medida</th>
            <th class="text-center">Tipo de Operación</th>
            <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            <th class="c-white bg-primary text-center">Total Anual</th>
        </tr>
        @foreach($data['rows'] as $keyv => $v)
            <tr class="t-tr-s12 c-text bg-white">
                <td>{{ $v->nombre_largo }}</td>
                <td class="text-center">{{ $v->unidad_medida }}</td>
                <td class="text-center">{{ $v->tipo_operacion }}</td>
                <td class="text-center c-yellow-meta">{{ $v->trim1 }}</td>
                <td class="text-center c-green-meta">{{ $v->trim2 }}</td>
                <td class="text-center c-blue-meta">{{ $v->trim3 }}</td>
                <td class="text-center c-red-meta">{{ $v->trim4 }}</td>
                <td class="text-center c-primary">{{ $v->anual }}</td>
            </tr>
        @endforeach
        <tr class="t-tr-s12 c-text-alt bg-white">
            <th class="text-right" colspan="3">Resultado Esperado:</th>
            <td class="text-center">{{ $data['porc1'] }}%</td>
            <td class="text-center">{{ $data['porc2'] }}%</td>
            <td class="text-center">{{ $data['porc3'] }}%</td>
            <td class="text-center">{{ $data['porc4'] }}%</td>
            <td class="text-center">{{ $data['porc_anual'] }}%</td>
        </tr>
    </table>

    <div class="m-b-md">
        <strong class="c-text-alt">DESCRIPCIÓN DE LA META ANUAL:</strong> <span>{{ $data['desc_meta'] }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">MEDIOS DE VERIFICACIÓN:</strong> <span>{{ $data['medios'] }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong> <span>{!! $data['metas_act'] !!}</span>
    </div>
</div>
    
@if($view == 'pdf')
    <div class="col-md-12">
        <table class="table no-borders">
            <tr class="t-tr-s14 c-text">
                <th width="10%" class="no-borders"></th>
                <td class="text-center bg-white">
                    <div class="font-bold c-text-alt">ELABORÓ</div>
                    <div class="font-bold c-white">.</div>
                    <br>
                    <input type="text" name="titular1" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-black" placeholder="ELABORÓ" style="border-bottom:1px dashed var(--text-color) !important;" required>
                    <input type="text" name="cargo1" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-black" placeholder="INGRESA CARGO" style="border-bottom:1px dashed var(--text-color) !important;">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
                <th width="20%" class="no-borders"></th>
                <td class="text-center bg-white">
                    <div class="font-bold c-text-alt">VALIDÓ</div>
                    <div class="font-bold c-text-alt">TITULAR DEPENDENCIA GENERAL</div>
                    <br>
                    <input type="text" name="titular2" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-black" placeholder="VALIDÓ" style="border-bottom:1px dashed var(--text-color) !important;" required>
                    <input type="text" name="cargo2" value="{{ $data['footer']['dg']['cargo'] }}" class="form-control text-center no-borders c-black" placeholder="INGRESA CARGO" style="border-bottom:1px dashed var(--text-color) !important;">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
                <th width="10%" class="no-borders"></th>
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

                    $.ajax("{{ URL::to('anteproyecto/pdfpbrmd?id='.$id) }}", {
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
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
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