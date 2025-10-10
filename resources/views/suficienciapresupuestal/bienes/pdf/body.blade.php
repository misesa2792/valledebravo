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
        <th class="text-center c-white bg-danger">PARTIDA (S)</th>
        <th class="text-center c-white bg-danger">DESCRIPCIÓN Y CARACTERÍSTICAS DEL (OS)  BIEN (ES)</th>
        <th class="text-center c-white bg-danger">UNIDAD DE MEDIDA</th>
        <th class="text-center c-white bg-danger">CANTIDAD SOLICITADA</th>
        <th class="text-center c-white bg-danger">COSTO UNITARIO</th>
        <th class="text-center c-white bg-danger">IMPORTE</th>
    </tr>
    @if($row['count'] > 10)
        @foreach ($row['rowsRegistros'] as $key => $v)
            <tr>
                @if($key == 0)
                    <th rowspan="{{ $row['count'] }}">{{ $row['no_partida'] }}</th>
                @endif
                    <td>{{ $v['desc'] }}</td>
                    <td>{{ $v['um'] }}</td>
                    <td class="text-center">{{ $v['cant'] }}</td>
                    <td class="text-right">{{ $v['costo'] }}</td>
                    <td class="text-right">{{ $v['importe'] }}</td>
            </tr>
        @endforeach
    @else 
            @foreach ($row['rowsRegistros'] as $key => $v)
                <tr>
                    @if($key == 0)
                        <th rowspan="{{ $row['count'] + $row['resta'] }}" class="text-center">{{ $row['no_partida'] }}</th>
                    @endif
                        <td>{{ $v['desc'] }}</td>
                        <td>{{ $v['um'] }}</td>
                        <td class="text-center">{{ $v['cant'] }}</td>
                        <td class="text-right">{{ $v['costo'] }}</td>
                        <td class="text-right">{{ $v['importe'] }}</td>
                </tr>
            @endforeach
             @for ($i=0 ; $i < $row['resta']; $i++)
                <tr>
                    <td class="text-center c-white">{{  $row['no_partida'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
    @endif
   
    <tr>
        <td rowspan="4" colspan="4">
            <div class="font-bold">O B S E R V A C I O N E S</div>
            <p>{{ $row['obs'] }}</p>
        </td>
        <th class="bg-white text-right">Sub-total:</th>
        <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span>{{ $row['subtotal'] }}</th>
    </tr>
    <tr>
        <th class="bg-white text-right">IVA:</th>
        <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span>{{ $row['iva'] }}</th>
    </tr>
    <tr>
        <th class="bg-white text-right">Total:</th>
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
        </th>
    </tr>
</table>