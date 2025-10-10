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
<br>

<table width="100%" cellspacing="0">
    <tr>
        <th class="text-left">
           <div class="s-10"> Tipo de Movimiento: Reconducción programático-presupuestal</div>
        </th>
        <td width="40%" class="s-10 text-left">
            <div class="s-10">No. de Oficio: {{ $request['oficio'] }}</div>
            <div class="s-10">Fecha: {{ $request['fecha'] }}</div>
        </td>
    </tr>
</table>

<br>

<table width="100%" class="my-table" >
    <tr class="s-12">
        <th class="bg-white text-center">CLAVE DEL PROYECTO</th>
        <th class="bg-white text-center">DENOMINACIÓN</th>
        <th class="bg-white text-center" width="23%">DE LA CANCELACIÓN O REDUCCIÓN DE METAS Y/O RECURSOS DEL PROYECTO (IMPACTO O RECUPERACIÓN PROGRAMÁTICA)</th>
        <th class="bg-white text-center" width="23%">DE LA CREACIÓN, REASIGNACIÓN DE METAS Y /O RECURSOS AL PROYECTO (BENEFICIO, IMPACTO, REPERCUCIÓN PROGRAMÁTICA)</th>
        <th class="bg-white text-center" width="23%">IDENTIFICACIÓN DEL ORIGEN DE LOS RECURSOS</th>
    </tr>
        @foreach ($row['rowsRegistros'] as $key => $r)
            <tr class="s-10">
                <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                <td class="text-left">{{ $row['dep_ext']['proyecto'] }}</td>
                <td class="text-left">{{ $request['texto1'] }}</td>
                <td class="text-left">{{ $request['texto2'] }}</td>
                <td class="text-left">{{ $request['identificacion'] }}</td>
            </tr>
        @endforeach
</table>