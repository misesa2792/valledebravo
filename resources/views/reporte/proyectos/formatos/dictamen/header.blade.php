<div style="padding-top:-35px">
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="20%" style="text-align:center;border-right:1px solid #6e6e6e;">
                @if(!empty($json['header']['row']['logo_izq'] ))
                    <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td style="text-align:center;">
                <div style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $json['header']['row']['leyenda'] }}</div>
            </td>
            <td width="20%" style="text-align:center;">
                @if(!empty($json['header']['row']['logo_der'] ))
                    <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
    </table>
</div>