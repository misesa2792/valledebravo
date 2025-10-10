<form id="saveInfo" method="post" class="form-horizontal">
    <input type="hidden" name="json" value="{{ json_encode($json) }}">

    <table class="table">
    <tr>
        <td class="no-borders" width="10%" rowspan="3">
            <img src="{{ asset('mass/images/logo_toluca_tl.png') }}" width="130" height="60">
        </td>
        <td class="no-borders text-center font-bold s-16 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
        <td class="no-borders" width="10%" rowspan="3">
            <img src="{{ asset('mass/images/logos/tl2527.png') }}" width="70" height="60">
        </td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESO MUNICIPAL {{ $json['header']['year'] }}</td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
    </tr>
</table>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $json['header']['year'] }}</th>
            </tr>
        </table>
    </div>
</div>

<br>
<h3 class="text-center c-text-alt">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $json['header']['year'] }}</h3>
<br>

<div class="col-md-12">
    <div class="col-md-12 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <th>Pilar/Eje Transversal: </th>
                <td></td>
                <td>{{ $json['header']['pilar'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Tema de Desarrollo: </th>
                <td></td>
                <td>{{ $json['header']['tema'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Programa presupuestario: </th>
                <td>{{ $json['header']['no_programa'] }}</td>
                <td>{{ $json['header']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Objetivo del programa presupuestario: </th>
                <td></td>
                <td>{{ $json['header']['obj_programa'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $json['header']['no_dep_gen'] }}</td>
                <td>{{ $json['header']['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Dependencia Auxiliar:</th>
                <td>{{ $json['header']['no_dep_aux'] }}</td>
                <td>{{ $json['header']['dep_aux'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<h3 class="text-center c-text-alt">ESTRUCTURA DEL INDICADOR</h3>
<br>

<table class="table table-bordered bg-white">
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Nombre del Indicador</th>
        <td colspan="3">{{ $json['indicador']['nombre'] }}</td>
    </tr>
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Fórmula de Cálculo</th>
        <td colspan="3">{{ $json['indicador']['formula'] }}</td>
    </tr>
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Interpretación</th>
        <td colspan="3">{{ $json['indicador']['interpretacion'] }}</td>
    </tr>
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Dimención que Atiende</th>
        <td>{{ $json['indicador']['dimension'] }}</td>
        <th width="15%" class="text-right">Frecuencia de Medición</th>
        <td>{{ $json['indicador']['frecuencia'] }}</td>
    </tr>
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Factor de Comparación</th>
        <td>{{ $json['indicador']['factor']['nombre'] }}</td>
        <th width="15%" class="text-right">Tipo de Indicador</th>
        <td>{{ $json['indicador']['tipo_indicador'] }}</td>
    </tr>
     <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Descripción del Factor de Comparación</th>
        <td colspan="3">{{ $json['indicador']['factor']['descripcion'] }}</td>
    </tr>
    <tr class="t-tr-s14 c-text-alt">
        <th width="15%" class="text-right">Línea Base</th>
        <td colspan="3">{{ $json['indicador']['linea'] }}</td>
    </tr>
</table>

<br>
<h3 class="text-center c-text-alt">CALENDARIZACIÓN TRIMESTRAL</h3>
<br>

<div class="col-md-12 ">
    <table class="table table-bordered">
        <tr class="t-tr-s14 c-text-alt">
            <th width="20%" class="text-center">Variables del Indicador</th>
            <th class="text-center">Unidad de Medida</th>
            <th class="text-center">Tipo de Operación</th>
            <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            <th class="c-white bg-primary text-center">Total Anual</th>
        </tr>
      
        @foreach ($json['registros'] as $p)
            <tr class="t-tr-s14 c-text bg-white">
                <td>{{ $p['id'] }}</td>
                <td class="text-center">{{ $p['um'] }}</td>
                <td class="text-center">{{ $p['to'] }}</td>
                <td class="text-center c-yellow-meta">{{ $p['t1'] }}</td>
                <td class="text-center c-green-meta">{{ $p['t2'] }}</td>
                <td class="text-center c-blue-meta">{{ $p['t3'] }}</td>
                <td class="text-center c-red-meta">{{ $p['t4'] }}</td>
                <td class="text-center c-red-meta">{{ $p['ta'] }}</td>
            </tr>
        @endforeach
        @for ($i = 0; $i < 5; $i++)
        <tr class="bg-white t-tr-s16 c-white">
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
        </tr>
        @endfor
        <tr class="t-tr-s14 c-text-alt bg-white">
            <th class="text-right" colspan="3">Resultado Esperado:</th>
            <td class="text-center">{{ $json['indicador']['porcentaje']['trim1'] }}%</td>
            <td class="text-center">{{ $json['indicador']['porcentaje']['trim2'] }}%</td>
            <td class="text-center">{{ $json['indicador']['porcentaje']['trim3'] }}%</td>
            <td class="text-center">{{ $json['indicador']['porcentaje']['trim4'] }}%</td>
            <td class="text-center">{{ $json['indicador']['porcentaje']['anual'] }}%</td>
        </tr>
    </table>

    <div class="m-b-md">
        <strong class="c-text-alt">DESCRIPCIÓN DE LA META ANUAL:</strong> <span>{{ $json['metas']['des'] }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">MEDIOS DE VERIFICACIÓN:</strong> <span>{{ $json['metas']['ver'] }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong> <span>{{ $json['metas']['act'] }}</span>
    </div>
</div>

<br>
<div class="col-md-12">
    <table class="table no-borders">
        <tr class="t-tr-s14 c-text">
            <th width="10%" class="no-borders"></th>
            <td class="text-center bg-white">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <div class="font-bold c-text-alt">.</div>
                <br>
                <input type="text" name="footer1" value="" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="ELABORÓ" style="border-bottom:1px dashed var(--text-color) !important;" required>
                <input type="text" name="cargo1" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="INGRESA CARGO" style="border-bottom:1px dashed var(--text-color) !important;">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th width="20%" class="no-borders"></th>
            <td class="text-center bg-white">
                <div class="font-bold c-text-alt">VALIDÓ</div>
                <div class="font-bold c-text-alt">TITULAR DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" name="footer2" value="{{ $json['footer']['titular_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="VALIDÓ" style="border-bottom:1px dashed var(--text-color) !important;" required>
                <input type="text" name="cargo2" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue" placeholder="INGRESA CARGO" style="border-bottom:1px dashed var(--text-color) !important;">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th width="10%" class="no-borders"></th>
    </tr>
    </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
</article>

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
                    $.ajax("{{ URL::to($pageModule.'/generarpdf?k='.$token) }}", {
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
                                toastr.success(row.message);
                                pbrmd.rowsProjects();
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