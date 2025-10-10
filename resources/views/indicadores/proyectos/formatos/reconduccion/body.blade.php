
<style>
    .text-center{text-align:center;}
    .text-right{text-align:right;}
    .text-left{text-align:left;}
    .font-bold{font-weight: bold;}
    .f-12{font-size:9px;}
    .f-8{font-size:7px;}
    .my-table {
        border: 0.1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 0.1px solid #000000;
        border-collapse: collapse;
        padding: 3px;
        font-family: Inter, sans-serif;
        font-size: 7px;
    }
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .color-white{color:#ffffff;}
    .text-top{vertical-align: text-top;}
    .bg-yellow-meta { background: #ffc000;}
    .bg-green-meta { background: #92d050;}
    .bg-blue-meta { background: #9cc2e5;}
    .bg-red-meta { background: #df6b51;}
    #table2 tr td,#table tr th{font-size:7px;border: none;}
    .border-bottom{border-bottom:0.1px solid #000000;}
</style>
<div>
    <br>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <th class="f-8 text-right">Tipo de Movimiento:</th>
                        <td class="f-8 border-bottom">MOVIMIENTO DE ADECUACIÓN PROGRAMÁTICA</td>
                    </tr>
                </table>
            </td>

            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <th width="50%" class="text-right f-8">No. de Oficio:</th>
                        <td width="50%" class="text-left f-8 border-bottom">{{ $oficio }}</td>
                    </tr>
                    <tr>
                        <th width="50%" class="text-right f-8">Fecha:</th>
                        <td width="50%" class="text-left f-8 border-bottom">{{ $fecha }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="padding-top:5px;"></div>
        <table id="table" width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th>
                <table width="100%" class="my-table">
                    <tr>
                        <th class="bg-title text-left">Datos de identificación del indicador sujeto a modificación</th>
                    </tr>
                </table>
            </th>
        </tr>
        </table>
        
        <table id="table" width="100%" cellspacing="0">
        <tr>
            <td>
                <table class="my-table" width="100%" cellspacing="0" >
                    <tr>
                        <td width="20%">Dependencia General:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Dependencia Auxiliar:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Programa presupuestario:</td>
                        <td width="70%">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Clave y Denominación del Proyecto:</td>
                        <td width="70%">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>

       <br>
        
        <table id="table" width="100%" cellspacing="0">
            <tr>
                <th>
                    <table width="100%" cellspacing="0" class="my-table">
                        <tr>
                            <th class="bg-title text-left">Detalle de la modificación del indicador</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        
     <table id="table" width="100%" cellspacing="0">
            <tr>
                <th>
                    <table width="100%" cellspacing="0" class="my-table">
                        <tr>
                            <th class="bg-title text-center" rowspan="2" width="80">Nivel de <br> la MIR</th>
                            <th class="bg-title text-center" rowspan="2">Denominación del Indicador</th>
                            <th class="bg-title text-center" rowspan="2">Variables del Indicador</th>
                            <th class="bg-title text-center" rowspan="2">Unidad de medida</th>
                            <th class="bg-title text-center" rowspan="2">Tipo Operación</th>
                            <th class="bg-title text-center" colspan="3">Programación del Indicador</th>
                            <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                        </tr>
                        <tr>
                            <th class="bg-title text-center">Inicial <br> del indicador</th>
                            <th class="bg-title text-center">Avance <br> a la fecha</th>
                            <th class="bg-title text-center">Programación <br> Modificatoría </th>
                            <th class="bg-title text-center" width="50">1</th>
                            <th class="bg-title text-center" width="50">2</th>
                            <th class="bg-title text-center" width="50">3</th>
                            <th class="bg-title text-center" width="50">4</th>
                        </tr>
                            @foreach ($json['metas'] as $kke => $v)
                            <tr>
                                @if($kke == 0)
                                    <td class="border-t bg-white text-center s-10" rowspan="3" width="20">{{ $json['mir'] }}</td>
                                    <td class="border-t bg-white s-10 text-left" rowspan="3">{{ $json['ind'] }}</td>
                                @endif
                                <td class="border-t s-10 text-left">{{ $v['ime'] }}</td>
                                <td class="border-t s-10 text-center" width="50">{{ $v['ium'] }}</td>
                                <td class="border-t s-10 text-center" width="50">{{ $v['ito'] }}</td>
                                <td class="border-t text-center">{{ $v['iti'] }}</td>
                                <td class="border-t text-center">{{ $v['ita'] }}</td>
                                <td class="border-t text-center">{{ $v['itm'] }}</td>
                                <td class="border-t text-center">{{ $v['it1'] }}</td>
                                <td class="border-t text-center">{{ $v['it2'] }}</td>
                                <td class="border-t text-center">{{ $v['it3'] }}</td>
                                <td class="border-t text-center">{{ $v['it4'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-right" colspan="3">Resultado del indicador:</td>
                            <td>{{ $iti }}</td>
                            <td>{{ $ita }}</td>
                            <td>{{ $itm }}</td>
                            <td>{{ $it1 }}</td>
                            <td>{{ $it2 }}</td>
                            <td>{{ $it3 }}</td>
                            <td>{{ $it4 }}</td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%" cellspacing="0">
                        <tr>
                            <th width="100%" class="text-left">
                                <table width="100%" cellspacing="0" class="my-table">
                                    <tr>
                                        <th class="bg-title text-left">Justificación:</th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                    
                    <br>
            
                    <table width="100%" cellspacing="0">
                        <tr>
                            <td>
                                <table width="100%" cellspacing="0" class="my-table">
                                    <tr>
                                        <td class="text-left bg-title">Resumen sobre la cancelación o reducción de la programación de Indicadores estratégicos y/o de gestión</td>
                                    </tr>
                                    <tr>
                                        <td height="50" class="text-left">
                                            @foreach ($json['metas'] as $kke => $v)
                                                @if($v['std'] == 2)
                                                    <div class="f-8">{{ $v['iob'] }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-left bg-title">
                                            Resumen sobre la creación o incremento de programación de indicadores estratégicos y/o de gestión
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="50" class="text-left">
                                            @foreach ($json['metas'] as $kke => $v)
                                                @if($v['std'] == 1)
                                                    <div class="f-8">{{ $v['iob'] }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    
                                </table>
                            </td>
                        </tr>
                   </table>
            
                  

                </th>
            </tr>
        </table>

</div>