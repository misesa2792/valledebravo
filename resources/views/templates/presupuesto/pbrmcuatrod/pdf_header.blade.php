<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="10%" rowspan="3">
                @if(!empty($row['header']['logo_izq']))
                    <img src="{{ public_path('mass/images/logos/'.$row['header']['logo_izq']) }}" width="70" height="60">
                @endif
            </td>
            <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td width="10%" rowspan="3"> </td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN DE EGRESOS MUNICIPAL {{ $row['header']['anio'] }}</td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>

    <br>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="60%">
                <table  class="my-table" width="100%">
                    <tr>
                        <td>PbRM-04d</td>
                        <th class="text-center">CARATULA DE PRESUPUESTO DE EGRESOS</th>
                    </tr>
                </table>
            </td>
            <td width="20%"></td>
            <td>
            </td>
        </tr>
    </table>
    <br>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="60%"></td>
            <td class="f-12 text-right">
                DEL 01 DE ENERO AL 31 DE DICIEMBRE DE {{ $row['header']['anio'] }}
            </td>
        </tr>
    </table>
</div>