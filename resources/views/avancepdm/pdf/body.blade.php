<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-justify{text-align:justify;}
    .text-right{text-align:right;}
    .text-left{text-align:left;}
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    #table tr td,#table tr th{font-size:9px;}
    .text-top{vertical-align: text-top;}
	.my-table {
        border: 1px solid #000000;
        border-collapse: collapse;
        width: 100%;
        page-break-inside: auto;
	}
	.my-table td,
	.my-table th {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px 3px;
        vertical-align: top;
        page-break-inside: auto;
	}
    .my-table-no td,
	.my-table-no th {
        border: 0px solid #ffffff;
        padding: 0;
        margin: 0;
	}
</style>

<div>
    @foreach ($rows as $v)
    <h4>{{ $v['pilar'] }}</h4>
    
      @foreach ($v['info'] as $r)
        <table id="table" width="100%" cellspacing="0" class="my-table">
            <tr>
                <th class="bg-title" width="50%">Programa presupuestario:</th>
                <td class="bg-title" width="50%">{{ $r['no'] }} {{ $r['pro'] }}</td>
            </tr>
            <tr>
                <td>Objetivo del Programa Presupuestario:</td>
                <td>{{ $r['obj'] }}</td>
            </tr>
            <tr>
                <th class="bg-title">Descripción de logros y avances de los indicadores de la MIR{{ $r['li'] }}</th>
                <th class="bg-title">Descripción de logros y avances de metas físicas por proyecto</th>
            </tr>
            <tr>
                <td style="padding:10px">
                    <ul>
                        @foreach ($r['indicador'] as $v)
                            <li>{{ $v['text'] }}</li>
                        @endforeach
                    </ul>

                    <br>

                    <div>
                        @if($r['li'] == 1)
                        Alcanzando un óptimo desempeño, en el cumplimiento de los indicadores Estratégicos de Gestión del Programa Presupuestario.
                        @endif
                    </div>
                </td>
                <td style="padding:10px">
                    <ul>
                        @foreach ($r['meta'] as $v)
                            <li>{{ $v['text'] }}</li>
                        @endforeach
                    </ul>

                    <br>

                    <div>
                        @if($r['lm'] == 1)
                        Alcanzando un cumplimiento satisfactorio en las metas de actividades sustantivas relevantes del Programa Presupuestario.
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <br>
    @endforeach
   
  @endforeach

</div>
