<div style="padding-top:-17px">
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="20%">
                @if(!empty($header->logo_der ))
                    <img src="{{ asset($header->logo_der ) }}" width="70" height="60">
                @endif
            </td>
           
            <td style="text-align:center;">
            </td>
            <td width="20%" style="text-align:center;">
                @if(!empty($header->logo_izq ))
                    <img src="{{ asset($header->logo_izq ) }}" width="110" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>

