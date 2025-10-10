<form id="formOchoc" method="post" class="form-horizontal">
    
<input type="hidden" name="json" value="{{ json_encode($json) }}">

<article class="col-md-12">
    <table class="table">
        <tr>
            <td class="no-borders text-left" width="10%" rowspan="3">
                @if(!empty($json['footer']['row']['logo_izq'] ))
                    <img src="{{ asset($json['footer']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="no-borders text-center c-text-alt font-bold s-12" width="10%" rowspan="3">
                <div>MUNICIPIO DE:</div>
                <div>{{ $json['header']['municipio']  }}</div>
            </td>
            <td class="no-borders text-center font-bold s-12 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td class="no-borders text-right" width="10%" rowspan="3">
                @if(!empty($json['footer']['row']['logo_der'] ))
                    <img src="{{ asset($json['footer']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-12 c-text-alt">GUÍA METODOLÓGICA PARA EL SEGUIMIENTO Y EVALUACIÓN DEL PLAN DE DESARROLLO MUNICIPAL VIGENTE</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-12 c-text-alt">SEGUIMIENTO Y EVALUACIÓN DEL PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>
</article>

<div class="col-md-12">
    <div class="col-md-8"></div>
    <div class="col-md-3 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Trimestre</td>
                <th>{{ $json['trimestre']['nombre']  }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>PbRM-08c: </td>
                <th class="text-center">
                    <div>AVANCE TRIMESTRAL DE METAS DE</div>
                    <div>ACTIVIDAD POR PROYECTO</div>
                </th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td>ENTE PÚBLICO:</td>
                <th class="text-center">
                    <div class="text-uppercase">{{ $json['header']['institucion']  }}</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table">
            <tr class="t-tr-s12 c-text-alt">
               <th class="no-borders"></th>
               <th class="text-center no-borders bg-white">Identifiador</th>
               <th class="text-center no-borders bg-white">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Programa presupuestario: </th>
                <td class="bg-white no-borders">{{ $json['proyecto']['no_programa'] }}</td>
                <td class="bg-white no-borders">{{ $json['proyecto']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Proyecto: </th>
                <td class="bg-white no-borders">{{ $json['proyecto']['no_proyecto'] }}</td>
                <td class="bg-white no-borders">{{ $json['proyecto']['proyecto'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia General:</th>
                <td class="bg-white no-borders">{{ $json['proyecto']['no_dep_gen'] }}</td>
                <td class="bg-white no-borders">{{ $json['proyecto']['dep_gen']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia Auxiliar:</th>
                <td class="bg-white no-borders">{{ $json['proyecto']['no_dep_aux']  }}</td>
                <td class="bg-white no-borders">{{ $json['proyecto']['dep_aux']  }}</td>
            </tr>
        </table>
    </div>
</div>

<br>

<div class="col-md-12">
    <table class="table table-bordered bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="3" width="40" class="text-center">ID</th>
            <th rowspan="3" width="30%" class="text-center">Nombre de la meta de actividad</th>
            <th colspan="2" class="text-center">Programación Anual </th>
            <th colspan="6" class="text-center">Avance Trimestral de Metas de Actividad</th>
            <th colspan="6" class="text-center">Avance Acumulado Anual de Metas de Actividad</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="2" class="text-center">Unidad de 
                <div>Medida</div>
            </th>
            <th rowspan="2" class="text-center">Programada
                <div>{{ $json['year'] }}</div>
            </th>
            <th colspan="2" class="text-center">Programada</th>
            <th colspan="2" class="text-center">Alcanzada</th>
            <th colspan="2" class="text-center">Variación</th>
            <th colspan="2" class="text-center">Programada</th>
            <th colspan="2" class="text-center">Alcanzada</th>
            <th colspan="2" class="text-center">Variación</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
            <td class="text-center">Meta</td>
            <td class="text-center">%</td>
        </tr>
        @foreach ($json['metas'] as $v)
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">{{ $v['codigo'] }}</td>
                <td>{{ $v['meta'] }}</td>
                <td class="text-center">{{ $v['unidad_medida'] }}</td>
                <td class="text-center">{{ $v['prog_anual'] }}</td>
                <td class="text-center">{{ $v['avance_programada'] }}</td>
                <td class="text-center">{{ $v['avance_programada_por'] }}</td>
                <td class="text-center">{{ $v['avance_alcazada'] }}</td>
                <td class="text-center">{{ $v['avance_alcazada_por'] }}</td>
                <td class="text-center">{{ $v['avance_variacion'] }}</td>
                <td class="text-center">{{ $v['avance_variacion_por'] }}</td>
                <td class="text-center">{{ $v['acumulado_programada'] }}</td>
                <td class="text-center">{{ $v['acumulado_programada_por'] }}</td>
                <td class="text-center">{{ $v['acumulado_alcazada'] }}</td>
                <td class="text-center">{{ $v['acumulado_alcazada_por'] }}</td>
                <td class="text-center">{{ $v['acumulado_variacion'] }}</td>
                <td class="text-center">{{ $v['acumulado_variacion_por'] }}</td>
            </tr>
        @endforeach
    </table>
</div>

<br>

<div class="col-md-12">
    <div class="col-md-8"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Total</td>
                <th>
                    <input type="text" name="total" value="{{  $json['proyecto']['pres'] }}" class="border-b-1-dashed form-control c-blue bg-white text-right" placeholder="$" readonly required>
                </th>
            </tr>
        </table>
    </div>
</div>
<br>

<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s12 c-text">
            <td width="30%" class="text-center bg-white">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <br>
                <br>
                <input type="text" value="{{ $json['footer']['t_dep_gen'] }}" name="txt_elaboro" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="ELABORÓ" required>
                <input type="text" value="{{ $json['footer']['c_dep_gen'] }}" name="txt_elaboro_cargo" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="INGRESA CARGO" required>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white">
                <div class="font-bold c-text-alt">REVISÓ</div>
                <br>
                <br>
                <input type="text"  name="txt_reviso" value="{{ $json['footer']['row']['t_tesoreria'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="REVISÓ" required>
                <input type="text"  name="txt_reviso_cargo" value="{{ $json['footer']['row']['c_tesoreria'] }}" onkeyup="MassMayusculas(this);" value="TESORERO MUNICIPAL" class="border-b-1-dashed form-control text-center c-blue" placeholder="INGRESA CARGO" required>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white">
                <div class="font-bold c-text-alt">AUTORIZÓ</div>
                <br>
                <br>
                <input type="text"  name="txt_autorizo" value="{{ $json['footer']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>
                <input type="text" name="txt_autorizo_cargo" value="{{ $json['footer']['row']['c_uippe'] }}" onkeyup="MassMayusculas(this);" value="TITULAR DE LA UIPPE" class="border-b-1-dashed form-control text-center c-blue" placeholder="INGRESA CARGO" required>
            </td>
       </tr>
    </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>
</article>
</form>

<script>
    $(".btnexportar").click(function(e){
        e.preventDefault();

        swal({
            title : 'PDF PbRM-08c',
            text: 'Estás seguro de generar el PDF PbRM-08c?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formOchoc"));
                $.ajax("{{ URL::to('reporte/generatepdfeightc?k='.$token) }}", {
                    type: 'post',
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".btnexportar").prop("disabled",true).html(mss_spinner + '...Generado PDF...');
                    },success: function(res){
                        let row = JSON.parse(res);
                        if(row.status == 'ok'){
                            toastr.success(row.message);
                            $("#sximo-modal").modal("toggle");
                            pbrmc.rowsPbrmc();
                            window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                        }else{
                            toastr.error(row.message);
                        }
                        $(".btnexportar").prop("disabled",false).html('<i class="fa icon-file-pdf"></i> Convertir a PDF');
                    }, error : function(err){
                        toastr.error(mss_tmp.error);
                        $(".btnexportar").prop("disabled",false).html('<i class="fa icon-file-pdf"></i> Convertir a PDF');
                    }
                });
                        
            }
        })
    })
</script>