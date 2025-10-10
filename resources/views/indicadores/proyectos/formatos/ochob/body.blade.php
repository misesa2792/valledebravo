<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .text-right{text-align:right;}
    .font-bold{font-weight: bold;}
    .f-12{font-size:9px;}
    .f-9{font-size:7px;}
    .f-6{font-size:7px;}
    .my-table {
        border: 1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 1px 2px;
        font-family: sans-serif;
    }
    .my-table td,
    .my-table th {
        font-size: 7px;
    }
    .my-table .blanco td,
    .my-table .blanco th {
        border-left:1px solid #000000;
        border-right:1px solid #000000;
        border-bottom:0px solid #000000;
        border-top:0px solid #000000;
    }
    .my-table-blanco td,
    .my-table-blanco th {
        font-size: 7px;
        padding: 1px 2px;
        font-family: sans-serif;
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
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
</style>

<table width="100%" cellspacing="0">
    <tr>
        <td width="80%"></td>
        <td>
            <table  class="my-table-blanco" width="100%">
                <tr>
                    <td>TIPO DE FICHA:</td>
                    <th>OSFEM</th>
                </tr>
            </table>
        </td>
        <td width="5%"></td>
    </tr>
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td width="20%">PILAR DE DESARROLLO / EJE TRANSVERSAL: </td>
        <td>{{ $json['proyecto']['no_pilar'].' '.$json['proyecto']['pilar'] }}</td>
    </tr>
    <tr>
        <td>TEMA DE DESARROLLO: </td>
        <td>{{ $json['proyecto']['tema'] }}</td>
    </tr>
    <tr>
        <td>PROGRAMA PRESUPUESTARIO:</td>
        <th class="text-left">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa']  }}</th>
    </tr>
    <tr>
        <td>PROYECTO PRESUPUESTARIO:</td>
        <td>{{ $json['proyecto']['no_proyecto']  }} {{ $json['proyecto']['proyecto']  }}</td>
    </tr>
    <tr>
        <td>OBJETIVO DEL PROGRAMA PRESUPUESTARIO:</td>
        <td>{{ $json['proyecto']['obj_programa']  }}</td>
    </tr>
    <tr>
        <td>DEPENDENCIA GENERAL:</td>
        <td>{{ $json['proyecto']['no_dep_gen']  }} {{ $json['proyecto']['dep_gen']  }}</td>
    </tr>
    <tr>
        <td>DEPENDENCIA AUXILIAR:</td>
        <td>{{ $json['proyecto']['no_dep_aux']  }} {{ $json['proyecto']['dep_aux']  }}</td>
    </tr>

</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td class="text-center">ESTRUCTURA DEL INDICADOR</td>
    </tr>
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td width="15%">NOMBRE DEL INDICADOR:</td>
        <td colspan="3">{{ $json['indicador']['nom'] }}</td>
    </tr>
    <tr>
        <td>FÓRMULA DEL CÁLCULO:</td>
        <td colspan="3">{{ $json['indicador']['for'] }}</td>
    </tr>
    <tr>
        <td>INTERPRETACIÓN:</td>
        <td colspan="3">{{ $json['indicador']['int']  }}</td>
    </tr>
    <tr>
        <td>DIMENSIÓN QUE ATIENDE:</td>
        <td>{{ $json['indicador']['dim']  }}</td>
        <td width="15%">FRECUENCIA DE MEDICIÓN:</td>
        <td width="20%">{{ $json['indicador']['fre']  }}</td>
    </tr>
    <tr>
        <td>DESCRIPCIÓN DEL FACTOR DE COMPARACIÓN:</td>
        <td colspan="3">{{ $json['indicador']['fac']  }}</td>
    </tr>
    <tr>
        <td>AMBITO GEOGRAFICO:</td>
        <td colspan="3">{{ $json['indicador']['ambito'] }}</td>
    </tr>
    <tr>
        <td>COBERTURA:</td>
        <td colspan="3">{{ $json['indicador']['cobertura']  }}</td>
    </tr>
    <tr>
        <td>LINEA BASE:</td>
        <td colspan="3">{{ $json['indicador']['lin']  }} </td>
    </tr>
</table>

<table  class="my-table-blanco" width="20%">
    <tr>
        <td width="50">Numero:</td>
        <td>{{ $json['indicador']['mir']  }}</td>
        <td width="80">{{ $json['indicador']['aplica'] }}</td>
    </tr>
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td class="text-center">COMPORTAMIENTO DE LAS VARIABLES DURANTE EL {{ $title['trimestre']['numero'] }} TRIMESTRE</td>
    </tr>
</table>

<table  class="my-table" width="100%">
    <tr>
        <td rowspan="2" class="text-center">VARIABLE</td>
        <td rowspan="2" class="text-center" width="100">UNIDAD DE MEDIDA</td>
        <td rowspan="2" class="text-center" width="100">OPERACIÓN</td>
        <td rowspan="2" class="text-center" width="100">META ANUAL </td>
        <td colspan="4" class="text-center">AVANCE TRIMESTRAL</td>
        <td colspan="4" class="text-center">AVANCE ACUMULADO</td>
    </tr>
    <tr>
        <td class="text-center" width="60">PROGRAMADO</td>
        <td class="text-center" width="30">%</td>
        <td class="text-center" width="60">ALCANZADO</td>
        <td class="text-center" width="30">%</td>
        <td class="text-center" width="60">PROGRAMADO</td>
        <td class="text-center" width="30">%</td>
        <td class="text-center" width="60">ALCANZADO</td>
        <td class="text-center" width="30">%</td>
    </tr>
    @foreach ($json['variables'] as $m)
        <tr>
            <td>{{ $m['ind'] }}</td>
            <td class="text-center">{{ $m['um'] }}</td>
            <td class="text-center">{{ $m['to'] }}</td>
            <td class="text-right">{{ $m['anual'] }}</td>
            <td class="text-right">{{ $m['prog'] }}</td>
            <td class="text-center">{{ $m['prog_pje'] }}</td>
            <td class="text-right">{{ $m['cant'] }}</td>
            <td class="text-center">{{ $m['cant_pje'] }}</td>
            <td class="text-right">{{ $m['a_prog'] }}</td>
            <td class="text-center">{{ $m['a_prog_pje'] }}</td>
            <td class="text-right">{{ $m['a_cant'] }}</td>
            <td class="text-center">{{ $m['a_cant_pje'] }}</td>
        </tr>
    @endforeach
 
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td class="text-center">COMPORTAMIENTO DEL INDICADOR</td>
    </tr>
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td class="text-center">DESCRIPCION DE LA META ANUAL</td>
    </tr>
    <tr>
        <td>{{ $json['evaluacion']['desc_meta'] }}</td>
    </tr>
</table>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td width="70%">
            <table  class="my-table" width="100%">
                <tr>
                    <td rowspan="3" width="30%" class="text-center ">META ANUAL</td>
                    <td colspan="8" class="text-center">TRIMESTRE: {{ $title['trimestre']['nombre']  }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center">AVANCE TRIMESTRAL</td>
                    <td colspan="4" class="text-center">AVANCE ACUMULADO</td>
                </tr>
                <tr>
                    <td class="text-center">PROGRAMADO</td>
                    <td class="text-center">ALCANZADO</td>
                    <td class="text-center">EF%</td>
                    <td class="text-center">SEMAFORO</td>
                    <td class="text-center">PROGRAMADO</td>
                    <td class="text-center">ALCANZADO</td>
                    <td class="text-center">EF%</td>
                    <td class="text-center">SEMAFORO</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="text-center">{{ $json['evaluacion']['meta_anual'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['programado'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['alcanzado'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['ef'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['semaforo'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['a_programado'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['a_alcanzado'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['a_ef'] }}</td>
                    <td class="text-center">{{ $json['evaluacion']['semaforo'] }}</td>
                </tr>
            </table>
            <p class="f-9">DESCRIPCIÓN DE RESULTADOS Y JUSTIFICACIÓN EN CASO DE VARIACIÓN SUPERIOR A ± 10 % RESPECTO A LO PROGRAMADO</p>
            <p class="f-9">{{ $json['evaluacion']['desc_res'] }}</p>
        </td>
        <td></td>
    </tr>
</table>

<p class="text-center f-9">EVALUACION DEL INDICADOR</p>
<p class="f-9">{{ $json['evaluacion']['evaluacion'] }}</p>

<table  class="my-table-blanco" width="100%">
    <tr>
        <td width="15%" class="text-left">DEPENDENCIA GENERAL:</td>
        <td>{{ $json['proyecto']['no_dep_gen']  }} {{ $json['proyecto']['dep_gen']  }}</td>
    </tr>
    <tr>
        <td width="15%" class="text-left">DEPENDENCIA AUXILIAR:</td>
        <td>{{ $json['proyecto']['no_dep_aux']  }} {{ $json['proyecto']['dep_aux']  }}</td>
    </tr>
</table>