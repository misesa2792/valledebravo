<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="20%">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <th class="text-center f-12">
                <div>SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</div>
                <div>MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN MUNICIPAL {{ $json['header']['year'] }}</div>
                <br>
                <div>PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</div> 
            </th>
            <td width="20%" style="text-align:right;">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>