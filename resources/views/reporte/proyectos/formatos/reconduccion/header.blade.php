<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="5%">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
             <td width="90%"  class="text-center">
                <div class="f-8"><strong>SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</strong></div>
                <div class="f-8"><strong>DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL PARA RESULTADOS</strong></div>
            </td>
            <td width="5%" class="text-right">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>