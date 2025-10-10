<html>
    <head>
        <title></title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .font-bold{font-weight: bold;}
            .f-12{font-size:8px;}
            .my-table {
                border: 1px solid #000000;
                border-collapse: collapse;
            }
            .my-table td,
            .my-table th {
                border: 1px solid #000000;
                border-collapse: collapse;
                padding: 4px 5px;
            }
            .my-table td,
            .my-table th {
                font-size: 8px;
            }
            .margin{margin-top:4px;margin-bottom:4px;}
        </style>

    </head>
    <body>

        <div class="text-center font-bold f-12 margin">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $json['header']['year'] }}</div>

        <table  class="my-table" width="100%">
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Pilar/Eje Transversal: </th>
                <td></td>
                <td>{{ $json['header']['pilar'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Tema de Desarrollo: </th>
                <td></td>
                <td>{{ $json['header']['tema'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td>{{ $json['header']['no_programa'] }}</td>
                <td>{{ $json['header']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Objetivo del programa presupuestario: </th>
                <td></td>
                <td>{{ $json['header']['obj_programa'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td>{{ $json['header']['no_dep_gen'] }}</td>
                <td>{{ $json['header']['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Dependencia Auxiliar:</th>
                <td>{{ $json['header']['no_dep_aux'] }}</td>
                <td>{{ $json['header']['dep_aux'] }}</td>
            </tr>
        </table>

        <div class="text-center font-bold f-12 margin">ESTRUCTURA DEL INDICADOR</div>

        <table  class="my-table" width="100%">
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Nombre del Indicador</th>
                <td colspan="3">{{ $json['indicador']['nombre'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Fórmula de Cálculo</th>
                <td colspan="3">{{ $json['indicador']['formula'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Interpretación</th>
                <td colspan="3">{{ $json['indicador']['interpretacion'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Dimención que Atiende</th>
                <td>{{ $json['indicador']['dimension'] }}</td>
                <th width="25%" class="text-right">Frecuencia de Medición</th>
                <td>{{ $json['indicador']['frecuencia'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Factor de Comparación</th>
                <td>{{ $json['indicador']['factor']['nombre'] }}</td>
                <th width="25%" class="text-right">Tipo de Indicador</th>
                <td>{{ $json['indicador']['tipo_indicador'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Descripción del Factor de Comparación</th>
                <td colspan="3">{{ $json['indicador']['factor']['descripcion'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Línea Base</th>
                <td colspan="3">{{ $json['indicador']['linea'] }}</td>
            </tr>
        </table>

        <div class="text-center font-bold f-12 margin">CALENDARIZACIÓN TRIMESTRAL</div>

        <table width="100%" class="my-table" >
            <tr class="t-tr-s16 c-text-alt">
                <th width="20%" class="text-center">Variables del Indicador</th>
                <th class="text-center">Unidad de Medida</th>
                <th class="text-center">Tipo de Operación</th>
                <th class="c-white bg-yellow-meta text-center" width="8%">Primer Trimestre</th>
                <th class="c-white bg-green-meta text-center" width="8%">Segundo Trimestre</th>
                <th class="c-white bg-blue-meta text-center" width="8%">Tercer Trimestre</th>
                <th class="c-white bg-red-meta text-center" width="8%">Cuarto Trimestre</th>
                <th class="c-white bg-red-meta text-center" width="8%">Total Anual</th>
            </tr>
          
            @foreach ($json['registros'] as $p)
                <tr class="t-tr-s16 c-text bg-white">
                    <td>{{ $p['id'] }}</td>
                    <td class="text-center">{{ $p['um'] }}</td>
                    <td class="text-center">{{ $p['to'] }}</td>
                    <td class="text-center c-yellow-meta">{{ $p['t1'] }}</td>
                    <td class="text-center c-green-meta">{{ $p['t2'] }}</td>
                    <td class="text-center c-blue-meta">{{ $p['t3'] }}</td>
                    <td class="text-center c-red-meta">{{ $p['t4'] }}</td>
                    <td class="text-center c-red-meta">{{ $p['ta'] }}</td>
                </tr>
            @endforeach
            <tr class="t-tr-s16 c-text-alt bg-white">
                <th class="text-right" colspan="3">Resultado Esperado:</th>
                <td class="text-center">{{ $json['indicador']['porcentaje']['trim1'] }}%</td>
                <td class="text-center">{{ $json['indicador']['porcentaje']['trim2'] }}%</td>
                <td class="text-center">{{ $json['indicador']['porcentaje']['trim3'] }}%</td>
                <td class="text-center">{{ $json['indicador']['porcentaje']['trim4'] }}%</td>
                <td class="text-center">{{ $json['indicador']['porcentaje']['anual'] }}%</td>
            </tr>
            
        </table>

        <div class="f-12 margin"> <strong>DESCRIPCIÓN DE LA META ANUAL:</strong> <span>{{ $json['metas']['des'] }}</span></div>
        <div class="f-12"> <strong>MEDIOS DE VERIFICACIÓN:</strong> <span>{{ $json['metas']['ver'] }}</span></div>
        <div class="f-12 margin"> <strong>METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong> <span>{{  $json['metas']['act'] }}</span></div>
    </body>
</html>