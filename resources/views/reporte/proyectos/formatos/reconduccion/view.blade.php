<form id="formReconduccion" method="post" class="form-horizontal">

    <input type="hidden" name="json" value="{{ json_encode($json) }}">



    <style>

        .h-45{height:65px;}

        .c-white{color:white;}

        #table tr td,tr th{font-size:11px;padding:4px;}

        .border{border:1px solid #ececec;}

        .border-t{border-top:1px solid #ececec;}

        .s-8{font-size:10px;}

        .m-b-xs{margin-bottom:5px;}

        .m-t-sm{margin-top:10px;}

        .m-b-sm{margin-bottom:10px;}

        .text-top{vertical-align: text-top;}

        .p-2{padding-top:2px;padding-bottom:2px;}

    </style>





    <table id="table" width="100%" cellspacing="0">

        <tr>

            <td width="15%">

                @if(!empty($json['header']['row']['logo_izq'] ))

                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">

                @endif

            </td>

            <td>
                <h6 class="text-center">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</h6>
                <h6 class="text-center">DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL PARA RESULTADOS</h6>
            </td>

            <td width="15%" class="text-right">

                @if(!empty($json['header']['row']['logo_der'] ))

                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">

                @endif

            </td>

        </tr>

    </table>



    <table id="table" width="100%" cellspacing="0">

        <tr>

            <td width="50%"><strong class="c-text-alt">Tipo de Movimiento:</strong> MOVIMIENTO DE ADECUACIÓN PROGRAMÁTICA</td>

            <td width="50%">

                <table id="table" width="100%" cellspacing="0">

                    <tr>

                        <th class="c-text-alt">No. de Oficio:</th>

                        <td>

                            <input type="text" name="oficio" class="border-b-1-dashed form-control" placeholder="No. de Oficio" required> 

                        </td>

                    </tr>

                

                    <tr>

                        <th class="c-text-alt">Fecha:</th>

                        <td>

                            <input type="text" name="fecha" class="border-b-1-dashed form-control" placeholder="Fecha" value="{{ $json['fecha'] }}" required readonly> 

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>



    <table id="table" width="100%" cellspacing="0" class="m-t-sm">

        <tr>

            <th width="50%">

                <table width="100%">

                    <tr>

                        <th class="bg-title text-center">Identificación del Proyecto en el que se cancela o reduce</th>

                    </tr>

                </table>

            </th>

            <th width="50%">

                <table width="100%">

                    <tr>

                        <th class="bg-title text-center">Identificación del Proyecto en el que se asigna o amplia</th>

                    </tr>

                </table>

            </th>

        </tr>

    </table>



    <table id="table" width="100%">

        <tr>

            <td width="50%">

                <table id="table" width="100%" cellspacing="0" class="border bg-white">

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Dependencia General:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Dependencia Auxiliar:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Programa presupuestario:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>

                    </tr>

                    <tr>

                        <td width="100%" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Proyecto presupuestario:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>

                    </tr>

                </table>

            </td>

            <td width="50%">

                <table id="table" width="100%" cellspacing="0" class="border bg-white">

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Dependencia General:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Dependencia Auxiliar:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Programa presupuestario:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>

                    </tr>

                    <tr>

                        <td width="100%" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>

                    </tr>

                    <tr>

                        <td width="20%" class="border-t c-text-alt">Proyecto presupuestario:</td>

                        <td width="70%" class="border-t">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>

                    </tr>

                </table>

            </td>

        

        </tr>

    </table>



    <table id="table" width="100%" cellspacing="0" class="m-t-sm">

        <tr>

            <th width="50%">

                <table width="100%" cellspacing="0" class="border">

                    <tr>

                        <th class="bg-title text-center">Identificación de Recursos a nivel de Proyecto que se cancelan  o se reducen</th>

                    </tr>

                </table>

            </th>

            <th width="50%">

                <table width="100%" cellspacing="0" class="border">

                    <tr>

                        <th class="bg-title text-center">Identificación de Recursos a nivel de Proyecto que se amplian o se asignan</th>

                    </tr>

                </table>

            </th>

        </tr>

    </table>



    <table id="table" width="100%" cellspacing="0">

        <tr>

            <th width="50%">

                <table width="100%" cellspacing="0" class="border">

                    <tr>

                        <th class="bg-title text-center">Clave</th>

                        <th class="bg-title text-center">Denominación</th>

                        <th class="bg-title text-center" colspan="4">Presupuesto</th>

                    </tr>

                    <tr>

                        <th class="c-white bg-white" rowspan="2">.</th>

                        <th class="c-white bg-white" rowspan="2">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                    </tr>

                    <tr>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                    </tr>

                </table>

            </th>

            <th width="50%">

                <table width="100%" cellspacing="0" class="border">

                    <tr>

                        <th class="bg-title text-center">Clave</th>

                        <th class="bg-title text-center">Denominación</th>

                        <th class="bg-title text-center" colspan="4">Presupuesto</th>

                    </tr>

                    <tr>

                        <th class="c-white bg-white" rowspan="2">.</th>

                        <th class="c-white bg-white" rowspan="2">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                    </tr>

                    <tr>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                        <th class="c-white bg-white">.</th>

                    </tr>

                </table>

            </th>

        </tr>

    </table>



    <table id="table" width="100%" cellspacing="0" class="m-t-xs">

        <tr>

            <th width="50%">

                <table width="100%">

                    <tr>

                        <th class="text-center">Metas de Actividad  Programadas y alcanzadas del proyecto a cancelar o reducir</th>

                    </tr>

                </table>

            </th>

            <th width="50%">

                <table width="100%">

                    <tr>

                        <th class="text-center">Metas de Actividad Programadas y alcanzadas del proyecto que se crea o incrementa</th>

                    </tr>

                </table>

            </th>

        </tr>

    </table>



    <table id="table" width="100%" class="m-t-xs">

        <tbody>

            <tr>

                <td width="50%" class="text-top">

                    <table id="table" width="100%" cellspacing="0" class="border">

                        <tr>

                            <th class="bg-title" rowspan="2" style="height:80px;">Código</th>

                            <th class="bg-title" rowspan="2">Descripción</th>

                            <th class="bg-title" rowspan="2">Unidad de medida</th>

                            <th class="bg-title text-center" colspan="3">Cantidad Programada de la Meta de Actividad</th>

                            <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>

                        </tr>

                        <tr>

                            <th class="bg-title text-center">Inicial</th>

                            <th class="bg-title text-center">Avance</th>

                            <th class="bg-title text-center">Modificada</th>

                            <th class="bg-title text-center" width="50">1</th>

                            <th class="bg-title text-center" width="50">2</th>

                            <th class="bg-title text-center" width="50">3</th>

                            <th class="bg-title text-center" width="50">4</th>

                        </tr>

                        @foreach ($json['metas']['arr_reduce'] as $v)

                            <tr>

                                <td class="border-t bg-white s-10 text-center s-10">{{ $v['ico'] }}</td>

                                <td class="border-t bg-white s-10">{{ $v['ime'] }}</td>

                                <td class="border-t bg-white s-10">{{ $v['ium'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['iti'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['ita'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['itm'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it1'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it2'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it3'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it4'] }}</td>

                            </tr>

                        @endforeach

                    </table>

                </td>

                <td width="50%" class="text-top">

                    <table id="table" width="100%" cellspacing="0" class="border">

                        <tr>

                            <th class="bg-title" rowspan="2" style="height:80px;">Código</th>

                            <th class="bg-title" rowspan="2">Descripción</th>

                            <th class="bg-title" rowspan="2">Unidad de medida</th>

                            <th class="bg-title text-center" colspan="3">Cantidad Programada de la Meta de Actividad</th>

                            <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>

                        </tr>

                        <tr>

                            <th class="bg-title text-center">Inicial</th>

                            <th class="bg-title text-center">Avance</th>

                            <th class="bg-title text-center">Modificada</th>

                            <th class="bg-title text-center" width="50">1</th>

                            <th class="bg-title text-center" width="50">2</th>

                            <th class="bg-title text-center" width="50">3</th>

                            <th class="bg-title text-center" width="50">4</th>

                        </tr>

                        @foreach ($json['metas']['arr_amplia'] as $v)

                            <tr>

                                <td class="border-t bg-white s-10 text-center s-10">{{ $v['ico'] }}</td>

                                <td class="border-t bg-white s-10">{{ $v['ime'] }}</td>

                                <td class="border-t bg-white s-10">{{ $v['ium'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['iti'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['ita'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['itm'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it1'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it2'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it3'] }}</td>

                                <td class="border-t bg-white s-10 text-center">{{ $v['it4'] }}</td>

                            </tr>

                        @endforeach

                    </table>

                </td>

            </tr>

        </tbody>

    </table>



    <table id="table" width="100%" class="m-t-sm">

        <tr>

            <th width="20%" class="text-left bg-title">Justificación</th>

            <th></th>

        </tr>

    </table>



    <table id="table" width="100%" class="m-t-sm">

        <tr>

            <th class="text-left border bg-white p-xxs">De la cancelación o reducción de metas y/o recursos del proyecto (impacto o recuperación programática)</th>

        </tr>

            @foreach ($json['metas']['arr_reduce'] as $v)

                @if(!empty($v['iob']))

                    <tr>

                        <td class="text-left border bg-white">{{ $v['ico'] }} {{ $v['iob'] }}</td>

                    </tr>

                @else

                    <tr>

                        <td class="text-left border bg-white">

                            <div class="alert alert-danger fade in block-inner no-margins">

                                <i class="icon-cancel-circle"></i> La meta <string>{{ $v['ico'] }}</string> no tiene observaciones, por favor agregue una observación para continuar.

                            </div>

                        </td>

                    </tr>

                @endif

            @endforeach

    </table>

    <table id="table" width="100%" class="m-t-sm">

        <tr>

            <th class="text-left border bg-white p-xxs">De la creación o reasignación de metas y/o recurso al proyecto</th>

        </tr>

        @foreach ($json['metas']['arr_amplia'] as $v)

            @if(!empty($v['iob']))

                <tr>

                    <td class="text-left border bg-white p-xxs">{{ $v['ico'] }} {{ $v['iob'] }}</td>

                </tr>

            @else

                <tr>

                    <td class="text-left border bg-white">

                        <div class="alert alert-danger fade in block-inner no-margins">

                            <i class="icon-cancel-circle"></i> La meta <string>{{ $v['ico'] }}</string> no tiene observaciones, por favor agregue una observación para continuar.

                        </div>

                    </td>

                </tr>

            @endif

        @endforeach

    </table>



    <table id="table" width="100%" class="m-t-sm">

        <tr>

            <th class="text-left border bg-white">Identificación del Origen de los recursos.</th>

        </tr>

    </table>



    <br>





        <table class="table">

            <tr class="t-tr-s14 c-text">

                <td width="30%" class="text-center bg-white border-gray">

                    <div class="font-bold c-text-alt">Elabora (Dep. General)</div>

                    <br>

                    <br>

                    <input type="text" name="t_dep_gen" value="{{ $json['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TITULAR DE LA DEPENDENCIA" required>

                    <div class="col-md-12 c-text-alt">Nombre y Firma</div>

                </td>

                <th class="no-borders"></th>

                <td width="30%" class="text-center bg-white border-gray">

                    <div class="font-bold c-text-alt">Vo. Bo. (Tesorería)</div>

                    <br>

                    <br>

                    <input type="text" name="t_tesoreria" value="{{ $json['header']['row']['t_tesoreria'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TESORERO MUNICIPAL" required>

                    <div class="col-md-12 c-text-alt">Nombre y Firma</div>

                </td>

                <th class="no-borders"></th>

                <td width="30%" class="text-center bg-white border-gray">

                    <div class="font-bold c-text-alt">Autorizó (Titular de la UIPPE o equivalente)</div>

                    <br>

                    <br>

                    <input type="text" name="t_uippe" value="{{ $json['header']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="border-b-1-dashed form-control text-center c-blue" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>

                    <div class="col-md-12 c-text-alt">Nombre y Firma</div>

                </td>

        </tr>

        </table>



    <br>

    <div class="text-center s-8">CUANDO LAS ADECUACIONES APLIQUEN PARA MODIFICAR PRESUPUESTO, ESTAS SE DEBEN DEFINIR A NIVEL DE PARTIDA PRESUPUESTARIA Y CAPITULO DE GASTO</div>

    <div class="text-center s-8 m-b-md">EN RELACIÓN ANEXA, ESTO NO APLICA PARA ADECUACIONES PROGRAMATICAS, ES DECIR PARA MODIFICACION DE PROGRAMACION DE METAS DE ACTIVIDAD</div>



    @if($json['metas']['empty_obs'] > 0)

        <div class="alert alert-danger fade in block-inner m-t-md no-margins">

            <i class="icon-cancel-circle"></i> Se han registrado {{ $json['metas']['empty_obs'] }} metas sin observaciones. Te recomendamos revisar y solventar las observaciones pendientes para poder continuar.

        </div>

    @endif



    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">

        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>

        @if($json['metas']['empty_obs'] == 0)

            <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>

        @endif

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

                $.ajax("{{ URL::to('reporte/pdfreconduccion?k='.$token) }}", {

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

