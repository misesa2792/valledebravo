<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="70%"></td>
            <td>
                <table  class="my-table" width="100%">
                    <tr>
                        <td width="30%">Total:</td>
                        <th class="text-right">{{ $total }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td class="border-bottom">
                            <div class="font-bold f-9">ELABORÓ</div>
                            <br>
                            <div class="f-9">{{ $txt_elaboro }}</div>
                            <div class="f-9">{{ $txt_elaboro_cargo }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center f-9">
                            Nombre      Firma          Cargo
                        </td>
                    </tr>
               </table>
            </td> 
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td class="border-bottom">
                            <div class="font-bold f-9">REVISÓ</div>
                            <br>
                            <div class="f-9">{{ $txt_reviso }}</div>
                            <div class="f-9">{{ $txt_reviso_cargo }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center f-9">
                            Nombre      Firma          Cargo
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="33%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td class="border-bottom">
                            <div class="font-bold f-9">AUTORIZÓ</div>
                            <br>
                            <div class="f-9">{{ $txt_autorizo }}</div>
                            <div class="f-9">{{ $txt_autorizo_cargo }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center f-9">
                            Nombre      Firma          Cargo
                        </td>
                    </tr>
               </table>
            </td>
        </tr>
    </table>
</div>