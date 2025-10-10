<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="10%" rowspan="3">
                @if(!empty($json['header']['logo_izq']))
                    <img src="{{ asset('mass/images/logos/'.$json['header']['logo_izq']) }}" width="70" height="60">
                @endif
            </td>
            <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td width="10%" rowspan="3"> </td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN MUNICIPAL {{ $json['header']['year'] }}</td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>
    
    <table width="100%" cellspacing="0">
        <tr>
            <td width="70%"></td>
            <td>
                <table  class="my-table" width="100%">
                    <tr>
                        <td>Ejercicio Fiscal</td>
                        <th>{{ $json['header']['year'] }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>