<form id="formReconduccion" method="post" class="form-horizontal">
    <input type="hidden" name="json" value="{{ json_encode($json) }}">

    <style>
        .h-45{height:65px;}
        .c-white{color:white;}
        #table tr td,tr th{font-size:12px;padding:6px;}
        .border{border:1px solid #ececec;}
        .border-t{border-top:1px solid #ececec;}
        .s-8{font-size:12px;}
        .m-b-xs{margin-bottom:5px;}
        .m-t-sm{margin-top:10px;}
        .m-b-sm{margin-bottom:10px;}
        .p-2{padding-top:2px;padding-bottom:2px;}
    </style>

    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="20%">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td width="60%">
                <h3 class="text-center s-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MEXICO CON SUS MUNICIPIOS</h3>
                <h3 class="text-center s-12">FORMATO DE RECONDUCCIÓN DE INDICADORES ESTRATÉGICOS Y/O DE GESTIÓN</h3>
            </td>
            <td width="20%" class="text-right">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>

    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="50%"><strong>Tipo de Movimiento:</strong> MOVIMIENTO DE ADECUACIÓN PROGRAMÁTICA</td>
            <td width="50%">
                <table id="table" width="100%" cellspacing="0">
                    <tr>
                        <th>No. de Oficio:</th>
                        <td>
                            <input type="text" name="oficio" class="border-b-1-dashed form-control" placeholder="No. de Oficio" required> 
                        </td>
                    </tr>
                
                    <tr>
                        <th>Fecha:</th>
                        <td>
                            <input type="text" name="fecha" class="border-b-1-dashed form-control" placeholder="Fecha" value="{{ $json['fecha'] }}" required> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table id="table" width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th>
                <table width="100%">
                    <tr>
                        <th class="bg-title">Datos de identificación del indicador sujeto a modificación</th>
                    </tr>
                </table>
            </th>
        </tr>
    </table>

    <table id="table" width="100%">
        <tr>
            <td>
                <table id="table" width="100%" cellspacing="0" class="border bg-white">
                    <tr class="t-tr-s12">
                        <td width="20%" class="border-t c-text-alt">Dependencia General:</td>
                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>
                    </tr>
                    <tr class="t-tr-s12">
                        <td width="20%" class="border-t c-text-alt">Dependencia Auxiliar:</td>
                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>
                    </tr>
                    <tr class="t-tr-s12">
                        <td width="20%" class="border-t c-text-alt">Programa presupuestario:</td>
                        <td width="70%" class="border-t">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
                    </tr>
                    <tr class="t-tr-s12">
                        <td width="100%" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>
                    </tr>
                    <tr class="t-tr-s12">
                        <td width="20%" class="border-t c-text-alt">Clave y Denominación del Proyecto:</td>
                        <td width="70%" class="border-t">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table id="table" width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th>
                <table width="100%" cellspacing="0" class="border">
                    <tr>
                        <th class="bg-title">Detalle de la modificación del indicador</th>
                    </tr>
                </table>
            </th>
        </tr>
    </table>
    <table id="table" width="100%" class="m-t-sm">
        <tr>
            <td width="100%" class="text-top">
                <table class="table table-bordered">
                    <tr class="t-tr-s12">
                        <th class="bg-title text-center" rowspan="2" width="80">Nivel de <br> la MIR</th>
                        <th class="bg-title text-center" rowspan="2">Denominación del Indicador</th>
                        <th class="bg-title text-center" rowspan="2">Variables del Indicador</th>
                        <th class="bg-title text-center" rowspan="2">Unidad de medida</th>
                        <th class="bg-title text-center" rowspan="2">Tipo Operación</th>
                        <th class="bg-title text-center" colspan="3">Programación del Indicador</th>
                        <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                    </tr>
                    <tr class="t-tr-s12">
                        <th class="bg-title text-center">Inicial <br> del indicador</th>
                        <th class="bg-title text-center">Avance <br> a la fecha</th>
                        <th class="bg-title text-center">Programación <br> Modificatoría </th>
                        <th class="bg-title text-center">1</th>
                        <th class="bg-title text-center">2</th>
                        <th class="bg-title text-center">3</th>
                        <th class="bg-title text-center">4</th>
                    </tr>
                    
                    @foreach ($json['metas'] as $kke => $v)
                        <tr class="t-tr-s12">
                            @if($kke == 0)
                                <td class="border-t bg-white text-center s-10" rowspan="3">{{ $json['mir'] }}</td>
                                <td class="border-t bg-white s-10" rowspan="3">{{ $json['ind'] }}</td>
                            @endif
                            <td class="border-t bg-white s-10">{{ $v['ime'] }}</td>
                            <td class="border-t bg-white s-10 text-center">{{ $v['ium'] }}</td>
                            <td class="border-t bg-white s-10 text-center">{{ $v['ito'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['iti'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['ita'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['itm'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['it1'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['it2'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['it3'] }}</td>
                            <td class="border-t bg-white text-center">{{ $v['it4'] }}</td>
                        </tr>
                    @endforeach
                        <tr class="t-tr-s12">
                            <td class="text-right bg-white" colspan="3">Resultado del indicador:</td>
                            <td class="bg-white">
                                <input type="text" name="iti" value="{{ $json['resultados']['iti'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="ita" value="{{ $json['resultados']['ita'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="itm" value="{{ $json['resultados']['itm'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="it1" value="{{ $json['resultados']['it1'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="it2" value="{{ $json['resultados']['it2'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="it3" value="{{ $json['resultados']['it3'] }}%" class="form-control text-center">
                            </td>
                            <td class="bg-white">
                                <input type="text" name="it4" value="{{ $json['resultados']['it4'] }}%" class="form-control text-center">
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
    </table>

    <table id="table" width="100%" class="m-t-sm m-b-sm">
        <tr>
            <th colspan="3" class="text-left bg-title">Justificación</th>
        </tr>
    </table>

    <div class="col-md-12 no-padding bg-white" style="min-height:120px;">
        <table id="table" width="100%">
            <tr>
                <th class="text-left border bg-title p-xxs">Resumen sobre la cancelación o reducción de la programación de Indicadores estratégicos y/o de gestión</th>
            </tr>
                @foreach ($json['metas'] as $kke => $v)
                    @if($v['std'] == 2 && !empty($v['iob']))
                        <tr>
                            <td class="text-left border bg-white p-xxs">{{ $json['mir'] }} {{ $v['iob'] }}</td>
                        </tr>
                    @endif
                @endforeach
        </table>
    </div>

    <div class="col-md-12 no-padding bg-white m-b-md" style="min-height:120px;">
        <table id="table" width="100%">
            <tr>
                <th class="text-left border bg-title p-xxs">Resumen sobre la creación o incremento de programación de indicadores estratégicos y/o de gestión</th>
            </tr>
                @foreach ($json['metas'] as $kke => $v)
                    @if($v['std'] == 1 && !empty($v['iob']))
                        <tr>
                            <td class="text-left border bg-white p-xxs">{{ $json['mir'] }} {{ $v['iob'] }}</td>
                        </tr>
                    @endif
                @endforeach
        </table>
    </div>

    <br>

    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="15%" class="no-borders"></td>
            <td width="30%" class="text-center bg-white border-gray no-borders">
                <div class="font-bold c-text-alt">Solicitó</div>
                <br>
                <br>
                <input type="text" name="titular_dep_gen"value="{{ $json['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TITULAR DE LA DEPENDENCIA" required>
                <div class="col-md-12 c-text-alt">Titular de la Dependencia u Organismo</div>
                <div class="col-md-12 c-text-alt">Nombre y Firma</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white border-gray no-borders">
                <div class="font-bold c-text-alt">Autorizó</div>
                <br>
                <br>
                <input type="text" name="titular_uippe" value="{{ $json['header']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>
                <div class="col-md-12 c-text-alt">Titular de la UIPPE o equivalente</div>
                <div class="col-md-12 c-text-alt">Nombre y Firma</div>
            </td>
            <td width="15%" class="no-borders"></td>
        </tr>
    </table>

    <article class="col-sm-12 col-md-12 text-center m-t-sm m-b-sm">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>
    </article>

</form>
<script>
      $(".btnexportar").click(function(e){
        e.preventDefault();

        swal({
            title : 'PDF Reconducción',
            text: 'Estás seguro de generar el PDF de Reconducción?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formReconduccion"));
                $.ajax("{{ URL::to('indicadores/pdfreconduccion?k='.$token) }}", {
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
                            pbrmc.rowsProjects();
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
