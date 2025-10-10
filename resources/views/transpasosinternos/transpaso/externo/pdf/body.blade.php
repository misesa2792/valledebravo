<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .text-justify{text-align:justify;}
    .text-right{text-align:right;}
    .font-bold{font-weight: bold;}
    .c-white{color:white;}
    .p-rel{position: relative;}
    .p-abs{position: absolute;}
    .s-10{font-size:10px;}
    .s-11{font-size:11px;}
    .s-12{font-size:12px;}
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
   
</style>

<table width="100%" cellspacing="0">
    <tr>
        <th width="40%" class="s-12 text-left">
            <br>
            L.C. JORGE FRANCISCO MAZA CERVANTES
            <div>
                TESORERO MUNICIPAL
            </div>
            <div>P R E S E N T E :</div>
        </th>
        <td></td>
        <td width="40%" class="s-12 text-left">
            <div>{{ $request['fecha'] }}</div>
            <div>Oficio: {{ $request['oficio'] }}</div>
        </td>
    </tr>
</table>

<p class="s-12 text-justify">Por este conducto, solicito a Usted sea tan gentil de efectuar los siguientes movimientos, mediante los traspasos presupuestarios correspondientes  y en su caso las ampliaciones presupuestarias correspondientes, de conformidad con lo establecido en los artículos 317, del Codigo Financiero del Estado de Mexico y Municipios vigente que a continuación se relacionan:</p>

<table width="100%" class="my-table" >
    <tr class="s-12">
        <th colspan="5" width="40%" class="text-center bg-white">DISMINUCIÓN</th>
        <th colspan="5" width="39%" class="text-center bg-white">AUMENTO</th>
        <th rowspan="2" width="20%" class="text-center bg-white">JUSTIFICACIÓN</th>
    </tr>
    <tr class="s-12">
        <th class="bg-white text-center" width="17%">CLAVE <br> PROGRAMATICA</th>
        <th class="bg-white text-center">F.F.</th>
        <th class="bg-white text-center">PARTIDA</th>
        <th class="bg-white text-center">MES</th>
        <th class="bg-white text-center">IMPORTE</th>
        <th class="bg-white text-center" width="17%">CLAVE <br> PROGRAMATICA</th>
        <th class="bg-white text-center">F.F.</th>
        <th class="bg-white text-center">PARTIDA</th>
        <th class="bg-white text-center">MES</th>
        <th class="bg-white text-center">IMPORTE</th>
    </tr>
    @if($row['count'] > 10)
        @foreach ($row['rowsRegistros'] as $key => $r)
            <tr class="s-10">
                <td class="text-center">{{ $row['dep_int']['clave_prog'] }}</td>
                <td class="text-center">{{ $r['no_ff'] }}</td>
                <td class="text-center">{{ $r['d_partida'] }}</td>
                <td class="text-center">{{ $r['d_mes'] }}</td>
                <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span>{{ $r['importe'] }}</td>
                <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                <td class="text-center">{{ $r['no_ff'] }}</td>
                <td class="text-center">{{ $r['a_partida'] }}</td>
                <td class="text-center">{{ $r['a_mes'] }}</td>
                <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span>{{ $r['importe'] }}</td>
                @if($key == 0)
                    <td class="text-justify" rowspan="{{ $row['count'] }}">{{ $row['justificacion'] }}</td>
                @endif
            </tr>
        @endforeach
    @else 
        @foreach ($row['rowsRegistros'] as $key => $r)
            <tr class="s-10">
                <td class="text-center">{{ $row['dep_int']['clave_prog'] }}</td>
                <td class="text-center">{{ $r['no_ff'] }}</td>
                <td class="text-center">{{ $r['d_partida'] }}</td>
                <td class="text-center">{{ $r['d_mes'] }}</td>
                <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span>{{ $r['importe'] }}</td>
                <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                <td class="text-center">{{ $r['no_ff'] }}</td>
                <td class="text-center">{{ $r['a_partida'] }}</td>
                <td class="text-center">{{ $r['a_mes'] }}</td>
                <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span>{{ $r['importe'] }}</td>
                @if($key == 0)
                 <td class="text-justify" rowspan="{{ $row['count'] + $row['resta'] }}">{{ $row['justificacion'] }}</td>
                @endif
            </tr>
        @endforeach
            @for ($i=0 ; $i < $row['resta']; $i++)
            <tr class="s-10">
                <td class="c-white">TE</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
    @endif
    <tr>
        <td colspan="3"></td>
        <th>Total:</th>
        <th> 
            <div class="p-rel text-right"><span class="p-abs" style="left:0px">$</span>{{ $row['importe'] }}</div>
        </th>
        <td colspan="3"></td>
        <th>Total:</th>
        <th class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span>{{ $row['importe'] }}</th>
    </tr>
</table>