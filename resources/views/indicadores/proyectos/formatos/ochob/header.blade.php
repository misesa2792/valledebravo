<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td class="text-left" width="10%" rowspan="3">
                @if(!empty($title['header']['row']['logo_izq'] ))
                    <img src="{{ asset($title['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="text-center font-bold f-12" width="10%" rowspan="3">
                <div>MUNICIPIO DE:</div>
                <div>{{ $title['header']['municipio']  }}</div>
            </td>
            <td class="text-center font-bold f-12">
                <div>ACUMULADOSISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</div>
                <div>GUIA METODOLÓGICA PARA EL SEGUIMIENTO Y EVALUACIÓN DEL PLAN DE DESARROLLO MUNICIPAL VIGENTE</div>
                <br>
                <div>PbRM-08b FICHA TÉCNICA DE SEGUIMIENTO DE INDICADORES {{ $title['year'] }} DE GESTIÓN O ESTRATÉGICO</div>
            </td>
            <td class="text-right" width="10%" rowspan="3">
                @if(!empty($title['header']['row']['logo_der'] ))
                    <img src="{{ asset($title['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>
  
