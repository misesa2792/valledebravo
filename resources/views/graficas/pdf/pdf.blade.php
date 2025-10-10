
<style>
    .text-center{text-align:center;}
    .text-right{text-align:right;}
    .my-table {
        border: 0.1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 0.1px solid #000000;
        border-collapse: collapse;
        padding: 2px;
        font-size: 7px;
    }
</style>
<div style="padding: 20px;">
    <br>

    <img src="{{ public_path('archivos/graficas/'.$image_url) }}" width="100%" height="200">

    <table id="table" width="100%" class="m-t-sm bg-white my-table">
        <tr class="t-tr-s14">
            <th rowspan="2" width="30">#</th>
            <th rowspan="2">Dependencias Auxiliar</th>
            <th rowspan="2">No. Proyecto</th>
            <th rowspan="2">Proyecto</th>
            <th rowspan="2">Programado Anual</th>
            <th rowspan="2">Avance Anual</th>
            <th rowspan="2">Modificada</th>
            <th colspan="4" class="text-center">Programado Trimestral</th>
            <th colspan="4" class="text-center">
                <div> {{ $no == 3 ? "Sin Reconducción" : "Con Reconducción" }}</div>
            </th>
            <th rowspan="2">Porcentaje</th>
        </tr>
        <tr class="t-tr-s14">
            <th class="text-center c-white bg-yellow-meta">1</th>
            <th class="text-center c-white bg-green-meta">2</th>
            <th class="text-center c-white bg-blue-meta">3</th>
            <th class="text-center c-white bg-red-meta">4</th>

            <th class="text-center c-white bg-yellow-meta">1</th>
            <th class="text-center c-white bg-green-meta">2</th>
            <th class="text-center c-white bg-blue-meta">3</th>
            <th class="text-center c-white bg-red-meta">4</th>
        </tr>
        @foreach ($info->rows as $row)
                <tr class="t-tr-s14">
                    <td class="c-text-alt">{{ $row->no }}</td>
                    <td class="c-text-alt">{{ $row->no_dep_aux }} {{ $row->dep_aux }}</td>
                    <td class="c-text-alt">{{ $row->no_proy }}</td>
                    <td class="c-text-alt">{{ $row->proyecto }}</td>
                    <th class="fun text-right">{{ $row->prog_anual }}</th>
                    <th class="c-success text-right">{{ $row->cantidad }}</th>
                    <th class="c-success text-right">{{ $row->modificada }}</th>
                    <td class="c-text text-right @if($no_tipo == 1) c-white bg-yellow-meta @endif">{{ $row->trim_1 }}</td>
                    <td class="c-text text-right @if($no_tipo == 2) c-white bg-green-meta @endif">{{ $row->trim_2 }}</td>
                    <td class="c-text text-right @if($no_tipo == 3) c-white bg-blue-meta @endif">{{ $row->trim_3 }}</td>
                    <td class="c-text text-right @if($no_tipo == 4) c-white bg-red-meta @endif">{{ $row->trim_4 }}</td>
                    <td class="c-text text-right @if($no_tipo == 1) c-white bg-yellow-meta @endif">{{ $row->avance_1 }}</td>
                    <td class="c-text text-right @if($no_tipo == 2) c-white bg-green-meta @endif">{{ $row->avance_2 }}</td>
                    <td class="c-text text-right @if($no_tipo == 3) c-white bg-blue-meta @endif">{{ $row->avance_3 }}</td>
                    <td class="c-text text-right @if($no_tipo == 4) c-white bg-red-meta @endif">{{ $row->avance_4 }}</td>
                    <th class="c-app text-right">{{ $row->cant }}%</th>
                </tr>
        @endforeach
    </table>
</div>