<div >
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="20%" style="text-align:center;border-right:1px solid #621132;">
                 @if(!empty($data['footer']['firmas']['logo_izq'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td style="text-align:center;color:#621132;">
                <h2 class="text-center">UNIDAD DE INFORMACIÓN, PLANEACIÓN</h2>
                <h2 class="text-center">PROGRAMACIÓN Y EVALUACIÓN</h2>
            </td>
            <td width="20%" style="text-align:center;">
                @if(!empty($data['footer']['firmas']['logo_der'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>