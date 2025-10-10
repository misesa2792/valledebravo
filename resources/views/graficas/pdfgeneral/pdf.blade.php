<style>
    .text-center{text-align:center;}
    .font-bold{font-weight: bold;}
    .f-12{font-size:9px;}
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
        font-size: 9px;
    }
    .my-table .blanco td,
    .my-table .blanco th {
        border-left:1px solid #000000;
        border-right:1px solid #000000;
        border-bottom:0px solid #000000;
        border-top:0px solid #000000;
    }
    
    .color-white{color:#ffffff;}
</style>
<div style="padding: 20px;">
    <br>

    <img src="{{ public_path('archivos/graficas/'.$image_url) }}" width="100%" height="200">

    <table id="table" width="100%" class="m-t-sm bg-white my-table">
        <tr class="t-tr-s14">
            <th width="30">#</th>
            <th>Dependencias Generales</th>
            <th>Programado Anual</th>
            <th>Avance</th>
            <th>Porcentaje</th>
        </tr>
        @foreach (json_decode($info) as $row)
            <tr class="t-tr-s16" >
                <td class="c-text-alt">{{ $row->no }}</td>
                <td class="c-text-alt">{{ $row->dep_gen }}</td>
                <th class="fun text-right">{{ $row->prog_anual }}</th>
                <th class="c-success text-right">{{ $row->cantidad }}</th>
                <th class="c-app text-right">{{ $row->cant }}%</th>
            </tr>
        @endforeach
    </table>
</div>