<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="10%"></td>
            <td width="30%" class="text-center">
               <table width="100%">
                    <tr>
                        <td class="border-bottom">
                            <div class="font-bold f-9">ELABORÓ</div>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-9">{{ $json['footer']['t_dep_gen'] }}</div>
                        </td>
                    </tr>
               </table>
            </td> 
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%">
                    <tr>
                        <td class="border-bottom">
                            <div class="font-bold f-9">VO. BO.</div>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="f-9">{{ $title['header']['row']['t_uippe'] }}</div>
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="20%" class="text-right">
                <p class="f-6">FECHA DE ELABORACION: {{ $fecha }}</p>
            </td>
            <td width="10%" class="text-right">
                <p class="f-6">Hoja: {{ $hi }} de {{ $hf }}</p>
            </td>
        </tr>
    </table>
</div>