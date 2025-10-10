<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .text-right{text-align:right;}
    .font-bold{font-weight: bold;}
    .f-12{font-size:8px;}
    .f-9{font-size:8px;}
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
    .my-table .blanco td,
    .my-table .blanco th {
        border-left:1px solid #000000;
        border-right:1px solid #000000;
        border-bottom:0px solid #000000;
        border-top:0px solid #000000;
    }
    .my-table-blanco .blanco td,
    .my-table-blanco .blanco th {
        border-left:0px solid #000000;
        border-right:0px solid #000000;
        border-bottom:0px solid #000000;
        border-top:0px solid #000000;
    }
    .color-white{color:#ffffff;}
    .text-top{vertical-align: text-top;}
    .border-bottom{border-bottom:1px solid #000000;}
</style>

<table width="100%" cellspacing="0">
    <tr>
        <td width="70%"></td>
        <td>
            <table  class="my-table" width="100%">
                <tr>
                    <td>Trimestre</td>
                    <th>{{ $json['trimestre']['nombre']  }}</th>
                </tr>
            </table>
        </td>
        <td width="10%"></td>
    </tr>
</table>

<table width="100%" cellspacing="0">
    <tr>
        <td width="40%" class="text-top">
            <table  class="my-table" width="100%">
                <tr>
                    <td>PbRM-08c: </td>
                    <th class="text-center">
                        <div>AVANCE TRIMESTRAL DE METAS DE</div>
                        <div>ACTIVIDAD POR PROYECTO</div>
                    </th>
                </tr>
                <tr>
                    <td>ENTE PÚBLICO:</td>
                    <th class="text-center">
                        <div class="text-uppercase">{{ $json['header']['institucion']  }}</div>
                    </th>
                </tr>
            </table>
        </td>
        <td width="10%"></td>
        <td width="50%">
            <table  class="my-table" width="100%">
                <tr>
                    <th class="text-right"></th>
                    <th class="text-center">Identifiador</th>
                    <th class="text-center">Denominación</th>
                 </tr>
                <tr>
                     <th class="text-right">Programa presupuestario: </th>
                     <td>{{ $json['proyecto']['no_programa'] }}</td>
                     <td>{{ $json['proyecto']['programa'] }}</td>
                 </tr>
                 <tr>
                    <th class="text-right">Proyecto: </th>
                    <td>{{ $json['proyecto']['no_proyecto'] }}</td>
                    <td>{{ $json['proyecto']['proyecto'] }}</td>
                </tr>
                <tr>
                     <th class="text-right">Dependencia General:</th>
                     <td>{{ $json['proyecto']['no_dep_gen'] }}</td>
                     <td>{{ $json['proyecto']['dep_gen'] }}</td>
                 </tr>
                 <tr>
                    <th class="text-right">Dependencia Auxiliar:</th>
                    <td>{{ $json['proyecto']['no_dep_aux'] }}</td>
                    <td>{{ $json['proyecto']['dep_aux'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<table  class="my-table" width="100%">
    <tr>
        <th rowspan="3" width="40" class="text-center">ID</th>
        <th rowspan="3" width="30%" class="text-center">Nombre de la meta de actividad</th>
        <th colspan="2" class="text-center">Programación Anual </th>
        <th colspan="6" class="text-center">Avance Trimestral de Metas de Actividad</th>
        <th colspan="6" class="text-center">Avance Acumulado Anual de Metas de Actividad</th>
    </tr>
    <tr>
        <th rowspan="2" class="text-center">Unidad de 
            <div>Medida</div>
        </th>
        <th rowspan="2" class="text-center">Programada
            <div>{{ $json['year'] }}</div>
        </th>
        <th colspan="2" class="text-center">Programada</th>
        <th colspan="2" class="text-center">Alcanzada</th>
        <th colspan="2" class="text-center">Variación</th>
        <th colspan="2" class="text-center">Programada</th>
        <th colspan="2" class="text-center">Alcanzada</th>
        <th colspan="2" class="text-center">Variación</th>
    </tr>
    <tr>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
        <td class="text-center">Meta</td>
        <td class="text-center">%</td>
    </tr>
    @foreach ($json['metas'] as $v)
        <tr>
            <td class="text-center">{{ $v['codigo'] }}</td>
            <td>{{ $v['meta'] }}</td>
            <td class="text-center">{{ $v['unidad_medida'] }}</td>
            <td class="text-center">{{ $v['prog_anual'] }}</td>
            <td class="text-center">{{ $v['avance_programada'] }}</td>
            <td class="text-center">{{ $v['avance_programada_por'] }}</td>
            <td class="text-center">{{ $v['avance_alcazada'] }}</td>
            <td class="text-center">{{ $v['avance_alcazada_por'] }}</td>
            <td class="text-center">{{ $v['avance_variacion'] }}</td>
            <td class="text-center">{{ $v['avance_variacion_por'] }}</td>
            <td class="text-center">{{ $v['acumulado_programada'] }}</td>
            <td class="text-center">{{ $v['acumulado_programada_por'] }}</td>
            <td class="text-center">{{ $v['acumulado_alcazada'] }}</td>
            <td class="text-center">{{ $v['acumulado_alcazada_por'] }}</td>
            <td class="text-center">{{ $v['acumulado_variacion'] }}</td>
            <td class="text-center">{{ $v['acumulado_variacion_por'] }}</td>
        </tr>
    @endforeach
</table>



