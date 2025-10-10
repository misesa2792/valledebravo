<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td class="text-left" width="10%" rowspan="3">
                @if(!empty($json['footer']['row']['logo_izq'] ))
                    <img src="{{ asset($json['footer']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="text-center font-bold f-12" width="10%" rowspan="3">
                <div>MUNICIPIO DE:</div>
                <div>{{ $json['header']['municipio']  }}</div>
            </td>
            <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td class="text-right" width="10%" rowspan="3">
                @if(!empty($json['footer']['row']['logo_izq'] ))
                    <img src="{{ asset($json['footer']['row']['logo_der'] ) }}" width="60" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">GUÍA METODOLÓGICA PARA EL SEGUIMIENTO Y EVALUACIÓN DEL PLAN DE DESARROLLO MUNICIPAL VIGENTE</td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">SEGUIMIENTO Y EVALUACIÓN DEL PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>
</div>
  
