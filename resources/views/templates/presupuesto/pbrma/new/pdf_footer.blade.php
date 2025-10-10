<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="30%" class="text-center">
               <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">REVISÓ</div>
                            <div class="font-bold">TITULAR DE LA DEPENDENCIA GENERAL</div>
                            <br>
                            <br>
                            <div>{{ $request['txt_titular_dep'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['txt_titular_dep_cargo'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            Nombre   Firma   Cargo
                        </td>
                    </tr>
               </table>
            </td> 
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">Vo.Bo.</div>
                            <div class="font-bold">TESORERO MUNICIPAL</div>
                            <br>
                            <br>
                            <div>{{ $request['txt_tesorero'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['txt_tesorero_cargo'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            Nombre   Firma   Cargo
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">AUTORIZÓ</div>
                            <div class="font-bold">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                            <br>
                            <br>
                            <div>{{ $request['txt_titular_uippe'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['txt_titular_uippe_cargo'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            Nombre   Firma   Cargo
                        </td>
                    </tr>
               </table>
            </td>
        </tr>
    </table>
</div>