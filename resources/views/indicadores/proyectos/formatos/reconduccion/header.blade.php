<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="5%">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td width="90%" class="text-center">
                <div class="font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MEXICO CON SUS MUNICIPIOS</div>
                <div class="font-bold f-12">FORMATO DE RECONDUCCIÓN DE INDICADORES ESTRATÉGICOS Y/O DE GESTIÓN</div>
            </td>
            <td width="5%" class="text-right">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>