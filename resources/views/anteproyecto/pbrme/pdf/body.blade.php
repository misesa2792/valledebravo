        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .text-left{text-align:left;}
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
            .font-bold{font-weight: bold;}
        </style>

    <div>
        <table width="100%" class="my-table">
        <tr>
            <th rowspan="2" width="50" class="no-borders"></th>
            <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
            <th colspan="3" class="text-center">Indicadores</th>
            <th rowspan="2"  class="text-center">Medios de verificación</th>
            <th rowspan="2"  class="text-center">Supuestos</th>
        </tr>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Fórmula</th>
            <th class="text-center">Frecuencia y Tipo</th>
        </tr>
        <tr>
            <th class="text-left">Fin</th>
            <td>{{ $data['rows']['fin']->descripcion }}</td>
            <td>{{ $data['rows']['fin']->nombre }}</td>
            <td>{{ $data['rows']['fin']->formula }}</td>
            <td class="text-center">
                {{ $data['rows']['fin']->frecuencia }}
                <br>
                {{ $data['rows']['fin']->tipo_indicador }}
            </td>
            <td>{{ $data['rows']['fin']->medios }}</td>
            <td>{{ $data['rows']['fin']->supuestos }}</td>
        </tr>

        <tr>
            <th class="text-left">Propósito</th>
            <td>{{ $data['rows']['proposito']->descripcion }}</td>
            <td>{{ $data['rows']['proposito']->nombre }}</td>
            <td>{{ $data['rows']['proposito']->formula }}</td>
            <td class="text-center">
                {{ $data['rows']['proposito']->frecuencia }}
                <br>
                {{ $data['rows']['proposito']->tipo_indicador }}
            </td>
            <td>{{ $data['rows']['proposito']->medios }}</td>
            <td>{{ $data['rows']['proposito']->supuestos }}</td>
        </tr>

        @foreach($data['rows']['componente'] as $kc => $c)
             @if($kc == 0)
                <tr>
                    <th rowspan="{{count($data['rows']['componente']) + 1}}" class="text-left">Componentes</th>
                </tr>
            @endif
            <tr>
                <td>{{ $c->descripcion }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->formula }}</td>
                <td class="text-center">
                    {{ $c->frecuencia }}
                    <br>
                    {{ $c->tipo_indicador }}
                </td>
                <td>{{ $c->medios }}</td>
                <td>{{ $c->supuestos }}</td>
            </tr>
        @endforeach
    
        @foreach($data['rows']['actividad'] as $ka => $c)
            @if($ka == 0)
                <tr>
                    <th rowspan="{{count($data['rows']['actividad']) + 1}}" class="text-left">Actividades</th>
                </tr>
            @endif
            <tr>
                <td>{{ $c->descripcion }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->formula }}</td>
                <td class="text-center">
                    {{ $c->frecuencia }}
                    <br>
                    {{ $c->tipo_indicador }}
                </td>
                <td>{{ $c->medios }}</td>
                <td>{{ $c->supuestos }}</td>
            </tr>
        @endforeach
    </table>

    </div>