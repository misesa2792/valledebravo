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
            .margin{margin-top:4px;margin-bottom:4px;}
        </style>

    </head>
    <body>

        <div style="padding:4px;"></div>
        <div class="text-center font-bold f-12 margin">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $data['anio'] }}</div>
        <div style="padding:4px;"></div>

        <table  class="my-table" width="100%">
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Eje de Cambio/Eje Transversal: </th>
                <td class="text-center">{{ $data['no_pilar'] }}</td>
                <td>{{ $data['pilar'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Tema de Desarrollo: </th>
                <td class="text-center">{{ $data['no_tema'] }}</td>
                <td>{{ $data['tema'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Proyecto: </th>
                <td class="text-center">{{ $data['no_proyecto'] }}</td>
                <td>{{ $data['proyecto'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Objetivo del programa presupuestario: </th>
                <td></td>
                <td>{{ $data['obj_programa'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th class="text-right">Dependencia Auxiliar:</th>
                <td class="text-center">{{ $data['no_dep_aux'] }}</td>
                <td>{{ $data['dep_aux'] }}</td>
            </tr>
        </table>

        <div style="padding:4px;"></div>
        <div class="text-center font-bold f-12 margin">ESTRUCTURA DEL INDICADOR</div>
        <div style="padding:4px;"></div>

        <table  class="my-table" width="100%">
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Nombre del Indicador</th>
                <td colspan="3">{{ $data['indicador'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Fórmula de Cálculo</th>
                <td colspan="3">{{ $data['formula'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Interpretación</th>
                <td colspan="3">{{ $data['interpretacion'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Dimensión que Atiende</th>
                <td>{{ $data['dimencion'] }}</td>
                <th width="25%" class="text-right">Frecuencia de Medición</th>
                <td>{{ $data['frecuencia'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Factor de Comparación</th>
                <td>{{ $data['factor'] }}</td>
                <th width="25%" class="text-right">Tipo de Indicador</th>
                <td>{{ $data['tipo_indicador'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Descripción del Factor de Comparación</th>
                <td colspan="3">{{ $data['factor_desc'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th width="25%" class="text-right">Línea Base</th>
                <td colspan="3">{{ $data['linea_base'] }}</td>
            </tr>
        </table>

        <div style="padding:4px;"></div>
        <div class="text-center font-bold f-12 margin">CALENDARIZACIÓN TRIMESTRAL</div>
        <div style="padding:4px;"></div>

        <table width="100%" class="my-table" >
            <tr class="t-tr-s16 c-text-alt">
                <th width="20%" class="text-center">Variables del Indicador</th>
                <th class="text-center" width="100">Unidad de Medida</th>
                <th class="text-center" width="100">Tipo de Operación</th>
                <th class="c-white bg-yellow-meta text-center" width="60">Trim. 1</th>
                <th class="c-white bg-green-meta text-center" width="60">Trim. 2</th>
                <th class="c-white bg-blue-meta text-center" width="60">Trim. 3</th>
                <th class="c-white bg-red-meta text-center" width="60">Trim. 4</th>
                <th class="c-white bg-red-meta text-center" width="60">Meta Anual</th>
            </tr>
          
            @foreach($data['rows'] as $keyv => $p)
                <tr class="t-tr-s16 c-text bg-white">
                    <td>{{ $p->nombre_largo }}</td>
                    <td class="text-center">{{ $p->unidad_medida }}</td>
                    <td class="text-center">{{ $p->tipo_operacion }}</td>
                    <td class="text-center c-yellow-meta">{{ SiteHelpers::getMassDecimales($p->trim1) }}</td>
                    <td class="text-center c-green-meta">{{ SiteHelpers::getMassDecimales($p->trim2) }}</td>
                    <td class="text-center c-blue-meta">{{ SiteHelpers::getMassDecimales($p->trim3) }}</td>
                    <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->trim4) }}</td>
                    <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->anual) }}</td>
                </tr>
            @endforeach
            <tr class="t-tr-s16 c-text-alt bg-white">
                <th class="text-right no-borders" colspan="3">Resultado Esperado:</th>
                <td class="text-center">{{ $data['porc1'] }}%</td>
                <td class="text-center">{{ $data['porc2'] }}%</td>
                <td class="text-center">{{ $data['porc3'] }}%</td>
                <td class="text-center">{{ $data['porc4'] }}%</td>
                <td class="text-center">{{ $data['porc_anual'] }}%</td>
            </tr>
            
        </table>

        <div class="f-12 margin"> <strong>DESCRIPCIÓN DE LA META ANUAL:</strong> <span>{{ $data['desc_meta'] }}</span></div>
        <br>
        <div class="f-12"> <strong>MEDIOS DE VERIFICACIÓN:</strong> <span>{{ $data['medios'] }}</span></div>
        <br>
        <div class="f-12 margin"> <strong>METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong> <span>{{ $data['metas_act'] }}</span></div>
        
        
    </body>
</html>