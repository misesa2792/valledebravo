<div style="padding:10px;">
        
<style>
    .text-center{text-align:center;}
    .text-right{text-align:right;}
    .text-left{text-align:left;}
    .font-14{font-size:14px;}
    .font-10{font-size:10px;}
    .font-8{font-size:8px;}
    .my-table {
        border: 1px solid #6e6e6e;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 1px solid #6e6e6e;
        border-collapse: collapse;
        padding: 3px;
        font-size: 9px;
    }
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .text-uppercase { text-transform: uppercase; }
	.bg-body{background: #f8f8f8;}
</style>

    <div class="text-center font-14"><strong>MUNICIPIO DE <span class="text-uppercase">{{ $json['header']['municipio'] }}</span></strong></div>
    <div class="text-center font-14"><strong>TARJETA DE JUSTIFICACIÓN DE RECONDUCCIÓN</strong></div>

    <br>

<table id="table" width="100%" cellspacing="0">
    <tr>
        <td width="20%"></td>
		<td width="80%">
			<table width="100%" cellspacing="0" class="my-table">
				<tr>
					<td class="text-right bg-body">Fecha:</td>
					<td width="60%">{{ $fecha }}</td>
				</tr>
				<tr>
					<td class="text-right bg-body">Número de folio de reconducción:</td>
					<td>{{ $folio_reconduccion }}</td>
				</tr>
				<tr>
					<td class="text-right bg-body">Programa presupuestario:</td>
					<td>{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
				</tr>
				<tr>
					<td class="text-right bg-body">Proyecto:</td>
					<td>{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
				</tr>
				<tr>
					<td class="text-right bg-body">Area:</td>
					<th class="text-left">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</th>
				</tr>
				<tr>
					<td class="text-right bg-body">Tipo de Reconducción:</td>
					<th class="text-left">Movimiento de adecuación programática</th>
				</tr>
				<tr>
					<td class="text-right bg-body">Folio:</td>
					<td>{{ $folio }}</td>
				</tr>
			</table>
        </td>
    </tr>
</table>

<p class="font-10">Por este conducto me permito enviar las justificaciones, referentes a la reconducción realizada:</p>

<div style="width:100%;padding:20px;border:1px solid #6e6e6e;">

    <table id="table" width="100%" class="m-t-sm bg-white my-table">
        <tr>
            <th class="font-8">JUSTIFICACIÓN:</th>
        </tr>
    </table>

    <table width="100%" cellspacing="0" class="my-table">
        <tr>
            <th class="bg-body font-8" width="50%">Meta de Actividad Sustantiva</th>
            <th class="bg-body font-8" width="50%">Justificación</th>
        </tr>
    </table>

    @foreach ($json['metas'] as $v)
        <table width="100%" cellspacing="0" class="my-table">
            <tr>
                <td class="font-8" width="50%">{{ $v['ico'] }} {{ $v['ime'] }}</td>
                <td class="font-8" width="50%">{{ $v['iob'] }}</td>
            </tr>
        </table>
    @endforeach

    <table width="100%" cellspacing="0" class="my-table">
        <tr>
            <th class="font-8 text-left">OBSERVACIONES:</th>
        </tr>
    </table>

    <table width="100%" cellspacing="0" class="my-table">
        <tr>
            <td colspan="2" class="font-8">
             El detalle de las metas inicial y modificada se adjunta en el formato DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL {{ $json['year'] }}, adjunto a esta tarjeta.
            </td>
        </tr>
    </table>

</div>

    <br>

    <table width="100%">
        <tr>
            <td width="30%"></td>
            <td width="30%" class="text-center">

                <table width="100%" class="my-table">
                    <tr>
                        <th>
                            A T E N T A M E N T E
                            <br><br><br><br>
                            <div class="p-2">{{ $t_dep_gen }}</div>
                        </th>
                    </tr>
                    <tr>
                        <th>{{ $c_dep_gen }}</th>
                    </tr>
                </table>

            </td>
            <td width="30%" class="text-center"></td>
        </tr>
    </table>
</div>