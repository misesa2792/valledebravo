        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-left{text-align:left;}
            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .font-bold{font-weight: bold;}
            .f-12{font-size:8px;}
            .size-xs{font-size:7px;}
            .my-table {
                border: 0px solid #000000;
                border-collapse: collapse;
            }
            .my-table td,
            .my-table th {
                border: 1px solid #000000;
                border-collapse: collapse;
                padding: 2px 2px;
                font-family: Inter, sans-serif;
                font-size:7px;
            }
            .my-table .blanco td,
            .my-table .blanco th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:1px solid #000000;
                border-top:0px solid #000000;
            }
            .my-table .blanco-last td,
            .my-table .blanco-last th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .my-table .no-borders {
                border-left:0px solid #000000;
                border-right:0px solid#000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .p-l-10{padding-left:10px;}
            .color-white{color:#ffffff;}
        </style>

<div>
    
    <table  class="my-table" width="100%">
        <tr>
            <th width="40%" class="text-left">Diagnóstico de Programa presupuestario elaborado usando análisis FODA: </th>
            <th class="no-borders"></th>
        </tr>
        <tr>
            <td colspan="2">
                <div>FORTALEZAS</div>
                    <ul>
                    @foreach ($data['fortalezas'] as $fk => $f)
                        <li><span class="p-l-10">{{ $f }}</span></li>
                    @endforeach
                    </ul>
                 <div>OPORTUNIDADES</div>
                 <ul>
                    @foreach ($data['oportunidades'] as $fo => $o)
                        <li><span class="p-l-10">{{ $o }}</span></li>
                    @endforeach
                </ul>
                 <div>DEBILIDADES</div>
                 <ul>
                    @foreach ($data['debilidades'] as $fd => $d)
                        <li><span class="p-l-10">{{ $d }}</span></li>
                    @endforeach
                </ul>
                 <div>AMENAZAS</div>
                 <ul>
                    @foreach ($data['amenazas'] as $fa => $a)
                        <li><span class="p-l-10">{{ $a }}</span></li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table> 

    <div style="padding:4px;"></div>
    
    <table  class="my-table" width="100%">
        <tr>
            <th width="40%" class="text-left">Objetivo del Programa presupuestario: </th>
            <th class="no-borders"></th>
        </tr>
        <tr>
         <td colspan="2">{{ $data['obj_programa'] }}</td>
        </tr>
    </table> 

    <div style="padding:4px;"></div>
    
    <table  class="my-table" width="100%">
        <tr>
            <th width="40%" class="text-left">Estrategias para alcanzar el objetivo del Programa presupuestario: </th>
            <th class="no-borders"></th>
        </tr>
        <tr>
         <td colspan="2">
            @foreach ($data['estrategias'] as $f)
                <ul><li class="s-14">{{ $f }}</li></ul>
            @endforeach
         </td>
        </tr>
    </table> 

    <div style="padding:4px;"></div>

    <table  class="my-table" width="100%">
        <tr>
            <th width="40%" class="text-left">Objetivo, Estrategias y Líneas de Acción del PDM atendidas: </th>
            <th class="no-borders"></th>
        </tr>
        <tr>
         <td colspan="2">
            @foreach ($data['lineas_accion'] as $k1 => $l1)
                <ul>
                    <li>{{ $k1.' '.$l1['objetivo'] }}</li>
                    @foreach ($l1['estrategias'] as $k2 => $l2)
                        <ul>
                            <li>{{ $k2.' '.$l2['estrategia'] }}</li>
                            @foreach ($l2['lineas_accion'] as $l3)
                                <ul>
                                    <li>{{ $l3['no_linea_accion'].' '.$l3['linea_accion'] }}</li>
                                </ul>
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
            @endforeach
         </td>
        </tr>
    </table> 

    <div style="padding:4px;"></div>

    <table  class="my-table" width="100%">
        <tr>
            <th width="40%" class="text-left">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario: </th>
            <th class="no-borders"></th>
        </tr>
        <tr>
         <td colspan="2">
            @foreach ($data['ods'] as $l1)
                <ul>
                    <li>{{ $l1['ods'] }}</li>
                    @foreach ($l1['metas'] as $l2)
                        <ul>
                            <li>{{ $l2 }}</li>
                        </ul>
                    @endforeach
                </ul>
            @endforeach
         </td>
        </tr>
    </table> 
</div>