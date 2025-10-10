<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="30%" class="text-center">
               <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">PRESIDENTE MUNICIPAL</div>
                            <br>
                            <br>
                            <br>
                            <div>{{ $request['firma1'] }}</div>
                        </td>
                    </tr>
               </table>
            </td> 
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">SÍNDICO MUNICIPAL</div>
                            <br>
                            <br>
                            <br>
                            <div>{{ $request['firma2'] }}</div>
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">SECRETARIO DEL AYUNTAMIENTO</div>
                            <br>
                            <br>
                            <br>
                            <div>{{ $request['firma3'] }}</div>
                        </td>
                    </tr>
               </table>
            </td>
        </tr>

        <tr>
            <td colspan="4"></td>
        </tr>

        <tr>
            <td width="30%" class="text-center">
            </td> 
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">TESORERO MUNICIPAL</div>
                            <br>
                            <br>
                            <br>
                            <div>{{ $request['firma4'] }}</div>
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="30%" class="text-center">
               <br>
                <table width="100%" class="no_borders" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="f-10">FECHA DE ELABORACIÓN:</td>
                        <td>
                            <table width="100%" class="my-table" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="text-center">DÍA</td>
                                    <td class="text-center">MES</td>
                                    <td class="text-center">AÑO</td>
                                </tr>
                                <tr>
                                    <td>{{ $dia }}</td>
                                    <td>{{ $mes }}</td>
                                    <td>{{ $anio }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>