<table width="100%" cellspacing="0">
    <tr>
        <td rowspan="2" width="15%" class="text-center no-borders">
            @if(!empty($data['footer']['logo_izq']))
                <img src="{{ asset($data['footer']['logo_izq']) }}" width="140" height="60">
            @endif
        </td>
        <th class="no-borders text-center">
            <div class="s-12 text-center m-b-xs"><strong>SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</strong></div>
            <div class="s-12 text-center"><strong>DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL PARA RESULTADOS</strong></div>
        </tn>
        <td width="10%" class="text-center no-borders">
            @if(!empty($data['footer']['logo_der']))
                <img src="{{ asset($data['footer']['logo_der']) }}" width="70" height="60">
            @endif
        </td>
    </tr>
</table>