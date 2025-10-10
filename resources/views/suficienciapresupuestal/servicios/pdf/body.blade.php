<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .text-justify{text-align:justify;}
    .text-right{text-align:right;}
    .font-bold{font-weight: bold;}
    .c-white{color:white;}
    .c-danger{color:#C00000;}
    .c-black{color:#000000;}
    .p-rel{position: relative;}
    .p-abs{position: absolute;}
    .s-10{font-size:10px;}
    .s-11{font-size:11px;}
    .s-12{font-size:12px;}
    .s-16{font-size:16px;}
    .p-xs{padding: 5px;}
    .my-table {
        border: 1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px 3px;
    }
    .my-table td,
    .my-table th {
        font-size: 7px;
    }
    .my-table .blanco,
    .my-table .blanco {
        border-bottom:1px solid #ffffff;
    }
    .color-white{color:#ffffff;}
    .color-gray{color:#adadad;}
   .bg-danger{background: #C00000;}
</style>
<table width="100%" class="my-table" >
    <tr>
        <td width="20%"><span> FECHA DE ELABORACION:</span></td>
        <td>{{ $row['fecha_elaboracion'] }}</td>
        <td width="50"><span> FOLIO:</span> </td>
        <td width="25%">{{ $request['folio'] }}</td>
    </tr>
    <tr>
        <td><span> DEPENDENCIA:</span></td>
        <td colspan="3">{{ $row['dep_gen'] }}</td>
    </tr>
    <tr>
        <td><span> UNIDAD SOLICITANTE:</span></td>
        <td colspan="3">{{ $row['dep_aux'] }}</td>
    </tr>
    <tr>
        <td><span> CLAVE PROGRAMÁTICA:</span></td>
        <td colspan="3">{{ $row['no_dep_gen'].' '.$row['no_dep_aux'].' '.$row['no_proyecto'].' '.$row['clasificacion'] }}</td>
    </tr>
    <tr>
        <td><span> TIPO DE RECURSO:</span></td>
        <td colspan="3">{{ $row['fuente'] }}</td>
    </tr>
</table>

<br>

<table width="100%" class="my-table" >
    <tr>
        <th class="text-center c-white bg-danger" width="50">PARTIDA</th>
        <th class="text-center c-white bg-danger" colspan="3">DESCRIPCIÓN Y CARACTERÍSTICAS</th>
        <th class="text-center c-white bg-danger" width="100">IMPORTE</th>
    </tr>
    @if($row['count'] > 10)
        @foreach ($row['rowsRegistros'] as $key => $v)
            <tr>
                @if($key == 0)
                    <th rowspan="{{ $row['count'] }}">{{ $row['no_partida'] }}</th>
                @endif
                    <td colspan="3">{{ $v['desc'] }}</td>
                    <td class="text-right">{{ $v['importe'] }}</td>
            </tr>
        @endforeach
    @else 
            @foreach ($row['rowsRegistros'] as $key => $v)
                <tr>
                    @if($key == 0)
                        <th rowspan="{{ $row['count'] + $row['resta'] }}" class="text-center">{{ $row['no_partida'] }}</th>
                    @endif
                        <td colspan="3">{{ $v['desc'] }}</td>
                        <td class="text-right">{{ $v['importe'] }}</td>
                </tr>
            @endforeach
             @for ($i=0 ; $i < $row['resta']; $i++)
                <tr>
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

    <tr>
        <td rowspan="4" colspan="3" class="no-padding">
            <table width="100%" class="my-table" >
                <tr>
                    <th colspan="2" class="bg-danger c-white">DATOS DEL VEHÍCULO</th>
                    <th colspan="4" class="bg-danger c-white">SERVICIO Y/O REPARACIÓN</th>
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

        <th class="bg-white text-right" width="50">Sub-total:</th>
        <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span>{{ $row['subtotal'] }}</th>
    </tr>
    <tr>
        <th class="bg-white text-right" width="50">IVA:</th>
        <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span>{{ $row['iva'] }}</th>
    </tr>
    <tr>
        <th class="bg-white text-right" width="50">Total:</th>
        <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span>{{ $row['total'] }}</th>
    </tr>
    <tr>
        <th colspan="2" class=" text-left">
            <div class="c-danger">FECHA REQUERIDA </div>
            <table width="100%" class="my-table" >
                <tr>
                    <th class="text-center c-white bg-danger">DÍA</th>
                    <th class="text-center c-white bg-danger">MES</th>
                    <th class="text-center c-white bg-danger">AÑO</th>
                </tr>
                <tr>
                    <td class="text-center">{{ $row['fecha_requerida']['dia'] }}</td>
                    <td class="text-center">{{ $row['fecha_requerida']['mes'] }}</td>
                    <td class="text-center">{{ $row['fecha_requerida']['year'] }}</td>
                </tr>
            </table>

            <div class="c-danger">FECHA DEL SERVICIO</div>
            <table width="100%" class="my-table" >
                <tr>
                    <th class="text-center c-white bg-danger">DÍA</th>
                    <th class="text-center c-white bg-danger">MES</th>
                    <th class="text-center c-white bg-danger">AÑO</th>
                </tr>
                <tr>
                    <td class="text-center">{{ $row['fecha_servicio']['dia'] }}</td>
                    <td class="text-center">{{ $row['fecha_servicio']['mes'] }}</td>
                    <td class="text-center">{{ $row['fecha_servicio']['year'] }}</td>
                </tr>
            </table>
        </th>
    </tr>
</table>