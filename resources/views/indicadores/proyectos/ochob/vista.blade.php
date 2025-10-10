<form id="formOchob" method="post" class="form-horizontal">
<article class="col-md-12">
    <table class="table">
        <tr>
            <td class="no-borders text-left" width="10%" rowspan="3">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="no-borders text-center c-text-alt font-bold s-14" width="10%" rowspan="3">
                <div>MUNICIPIO DE:</div>
                <div>{{ $json['header']['municipio']  }}</div>
            </td>
            <td class="no-borders text-center font-bold s-14 c-text-alt">
                <div>ACUMULADOSISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</div>
                <div>GUIA METODOLÓGICA PARA EL SEGUIMIENTO Y EVALUACIÓN DEL PLAN DE DESARROLLO MUNICIPAL VIGENTE</div>
                <br>
                <div>PbRM-08b FICHA TÉCNICA DE SEGUIMIENTO DE INDICADORES {{ $json['year'] }} DE GESTIÓN O ESTRATÉGICO</div>
            </td>
            <td class="no-borders text-right" width="10%" rowspan="3">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</article>

<div class="col-md-12">
    <div class="col-md-9"></div>
    <div class="col-md-3 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>TIPO DE FICHA:</td>
                <th>OSFEM</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-12 no-padding">
        <table class="table bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders" width="20%">PILAR DE DESARROLLO / EJE TRANSVERSAL: </td>
                <td class="no-borders c-text">{{ $json['proyecto']['no_pilar'].' '.$json['proyecto']['pilar'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">TEMA DE DESARROLLO: </td>
                <td class="no-borders c-text">{{ $json['proyecto']['tema'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">PROGRAMA PRESUPUESTARIO:</td>
                <th class="no-borders c-text">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa']  }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">PROYECTO PRESUPUESTARIO:</td>
                <td class="no-borders c-text">{{ $json['proyecto']['no_proyecto']  }} {{ $json['proyecto']['proyecto']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">OBJETIVO DEL PROGRAMA PRESUPUESTARIO:</td>
                <td class="no-borders c-text">{{ $json['proyecto']['obj_programa']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">DEPENDENCIA GENERAL:</td>
                <td class="no-borders c-text">{{ $json['proyecto']['no_dep_gen']  }} {{ $json['proyecto']['dep_gen']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">DEPENDENCIA AUXILIAR:</td>
                <td class="no-borders c-text">{{ $json['proyecto']['no_dep_aux']  }} {{ $json['proyecto']['dep_aux']  }}</td>
            </tr>

        </table>

    </div>
</div>

<h3 class="text-center c-text-alt s-12">ESTRUCTURA DEL INDICADOR</h3>


<div class="col-md-12">
    <div class="col-md-12 no-padding">
        <table class="table bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders" width="15%">NOMBRE DEL INDICADOR:</td>
                <td class="no-borders c-text" colspan="3">{{ $json['indicador']['nom'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">FÓRMULA DEL CÁLCULO:</td>
                <td class="no-borders c-text" colspan="3">{{ $json['indicador']['for'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">INTERPRETACIÓN:</td>
                <td class="no-borders c-text" colspan="3">{{ $json['indicador']['int']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">DIMENSIÓN QUE ATIENDE:</td>
                <td class="no-borders c-text">{{ $json['indicador']['dim']  }}</td>
                <td class="no-borders" width="15%">FRECUENCIA DE MEDICIÓN:</td>
                <td class="no-borders c-text" width="20%">{{ $json['indicador']['fre']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">DESCRIPCIÓN DEL FACTOR DE COMPARACIÓN:</td>
                <td class="no-borders c-text" colspan="3">{{ $json['indicador']['fac']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">AMBITO GEOGRAFICO:</td>
                <td class="no-borders c-text" colspan="2">{{ $json['indicador']['ambito'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">COBERTURA:</td>
                <td class="no-borders c-text" colspan="2">{{ $json['indicador']['cobertura'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="no-borders">LINEA BASE:</td>
                <td class="no-borders c-text" colspan="3">{{ $json['indicador']['lin']  }} </td>
            </tr>
        </table>

        <div class="col-md-4 no-padding bg-white m-b-md">
            <div class="col-md-6 no-padding">
                <table class="table no-margins">
                    <tr class="t-tr-s12 c-text-alt">
                        <td class="no-borders" width="50">Numero:</td>
                        <td class="no-borders c-text">{{ $json['indicador']['mir']  }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 no-padding">
                <table class="table no-margins">
                    <tr class="t-tr-s12 c-text-alt">
                        <td class="no-borders c-text text-right">{{ $json['indicador']['aplica'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<div class="col-md-12">
    <h3 class="col-md-12 text-center c-text-alt s-12">COMPORTAMIENTO DE LAS VARIABLES DURANTE EL {{ $json['trimestre']['numero'] }} TRIMESTRE</h3>
    <table class="table table-bordered bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="2" width="30%" class="text-center">VARIABLE</th>
            <th rowspan="2" class="text-center">UNIDAD DE MEDIDA</th>
            <th rowspan="2" class="text-center">OPERACIÓN</th>
            <th rowspan="2" class="text-center">META ANUAL </th>
            <th colspan="4" class="text-center">AVANCE TRIMESTRAL</th>
            <th colspan="4" class="text-center">AVANCE ACUMULADO</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th class="text-center">PROGRAMADO</th>
            <th class="text-center">%</th>
            <th class="text-center">ALCANZADO</th>
            <th class="text-center">%</th>
            <th class="text-center">PROGRAMADO</th>
            <th class="text-center">%</th>
            <th class="text-center">ALCANZADO</th>
            <th class="text-center">%</th>
        </tr>
        @foreach ($json['indicadores'] as $m)
            <tr class="t-tr-s12 c-text">
                <td>{{ $m['ind'] }}</td>
                <td class="text-center">{{ $m['um'] }}</td>
                <td class="text-center">{{ $m['to'] }}</td>
                <td class="text-right">{{ $m['anual'] }}</td>
                <td class="text-right">{{ $m['prog'] }}</td>
                <td class="text-center">{{ $m['prog_pje'] }}</td>
                <td class="text-right">{{ $m['cant'] }}</td>
                <td class="text-center">{{ $m['cant_pje'] }}</td>
                <td class="text-right">{{ $m['a_prog'] }}</td>
                <td class="text-center">{{ $m['a_prog_pje'] }}</td>
                <td class="text-right">{{ $m['a_cant'] }}</td>
                <td class="text-center">{{ $m['a_cant_pje'] }}</td>
            </tr>
        @endforeach
    </table>
</div>

<dic class="col-md-12">
    <h3 class="text-center c-text-alt s-12">COMPORTAMIENTO DEL INDICADOR</h3>
    <h3 class="text-center c-text-alt s-12">DESCRIPCION DE LA META ANUAL</h3>
    <table class="table bg-white">
        <tr>
            <td class="no-borders">{{ $json['metas']['desc_meta'] }}</td>
        </tr>
    </table>
</dic>

<div class="col-md-12 m-t-md">
  
    <div class="col-md-10 no-padding">
        <table class="table table-bordered bg-white no-margins">
            <tr class="t-tr-s12 c-text-alt">
                <th rowspan="3" width="30%" class="text-center ">META ANUAL</th>
                <th colspan="8" class="text-center">TRIMESTRE: {{ $json['trimestre']['nombre']  }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th colspan="4" class="text-center">AVANCE TRIMESTRAL</th>
                <th colspan="4" class="text-center">AVANCE ACUMULADO</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-center">PROGRAMADO</th>
                <th class="text-center">ALCANZADO</th>
                <th class="text-center">EF%</th>
                <th class="text-center">SEMAFORO</th>
                <th class="text-center">PROGRAMADO</th>
                <th class="text-center">ALCANZADO</th>
                <th class="text-center">EF%</th>
                <th class="text-center">SEMAFORO</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">{{ $json['metas']['meta_anual'] }}</td>
                <td class="text-center">{{ $json['metas']['programado'] }}</td>
                <td class="text-center">{{ $json['metas']['alcanzado'] }}</td>
                <td class="text-center">{{ $json['metas']['ef'] }}</td>
                <td class="text-center">{{ $json['metas']['semaforo'] }}</td>
                <td class="text-center">{{ $json['metas']['a_programado'] }}</td>
                <td class="text-center">{{ $json['metas']['a_alcanzado'] }}</td>
                <td class="text-center">{{ $json['metas']['a_ef'] }}</td>
                <td class="text-center">{{ $json['metas']['semaforo'] }}</td>
            </tr>
        </table>
        <p class="s-12">DESCRIPCIÓN DE RESULTADOS Y JUSTIFICACIÓN EN CASO DE VARIACIÓN SUPERIOR A +- 10 POR CIENTO RESPECTO A LO PROGRAMADO</p>
        <table class="table bg-white">
            <tr>
                <td class="no-borders">{{ $json['metas']['desc_res'] }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-2"></div>
</div>

<div class="col-md-12 m-t-md m-b-md">
    <h3 class="text-center c-text-alt s-12">EVALUACION DEL INDICADOR</h3>
    <table class="table bg-white">
        <tr>
            <td class="no-borders">{{ $json['metas']['evaluacion'] }}</td>
        </tr>
    </table>
</div>

<div class="col-md-12">
        <table class="table">
            <tr class="t-tr-s12 c-text-alt">
                <th width="15%" class="no-borders">DEPENDENCIA GENERAL:</th>
                <td class="no-borders">{{ $json['proyecto']['no_dep_gen']  }} {{ $json['proyecto']['dep_gen']  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th width="15%" class="no-borders">DEPENDENCIA AUXILIAR:</th>
                <td class="no-borders">{{ $json['proyecto']['no_dep_aux']  }} {{ $json['proyecto']['dep_aux']  }}</td>
            </tr>
        </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="button" class="btn btn-sm btn-danger btnsaveeval"> <i class="fa fa-save"></i> Revertir evaluación</button>
</article>
</form>

<script>
    $('.date').datepicker({format: 'dd-mm-yyyy'});

    $(".btnsaveeval").click(function(e){
        e.preventDefault();

        swal({
            title : 'Revertir evaluación PbRM-08b',
            text: 'Estás seguro de revertir la evaluación del indicador?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formOchob"));
                $.ajax("{{ URL::to('indicadores/revertirochob?id='.$id) }}", {
                    type: 'post',
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                       $(".btnsaveeval").prop("disabled",true).html(mss_spinner + '...Revirtiendo...');
                    },success: function(res){
                        let row = JSON.parse(res);
                        if(row.status == 'ok'){
                            toastr.success(row.message);
                            $("#sximo-modal").modal("toggle");
                            pbrmb.rowsPbrmb();
                        }else{
                            toastr.error(row.message);
                        }
                        $(".btnsaveeval").prop("disabled",false).html('<i class="fa fa-save"></i> Revertir evaluación');
                    }, error : function(err){
                        toastr.error(mss_tmp.error);
                        $(".btnsaveeval").prop("disabled",false).html('<i class="fa fa-save"></i> Revertir evaluación');
                    }
                });
                        
            }
        })
    })

   
</script>