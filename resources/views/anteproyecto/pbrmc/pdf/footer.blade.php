<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="33%" class="text-center">
               <table width="100%" class="my-table">
                    <tr>
                        <th>ELABORÓ</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-bold"></div>
                            <br>
                            <br>
                            <div>{{ $request['titular1'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['cargo1'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="my-table" width="100%" cellspacing="0">
                                <tr>
                                    <th class="text-center no-borders size-xs" width="33%">Nombre</th>
                                    <th class="text-center no-borders size-xs" width="33%">Firma</th>
                                    <th class="text-center no-borders size-xs" width="33%">Cargo</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>
            </td> 
            <td></td>
            <td width="33%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <th>Vo.Bo.</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-bold">TESORERO MUNICIPAL</div>
                            <br>
                            <br>
                            <div>{{ $request['titular2'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['cargo2'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="my-table" width="100%" cellspacing="0">
                                <tr>
                                    <th class="text-center no-borders size-xs" width="33%">Nombre</th>
                                    <th class="text-center no-borders size-xs" width="33%">Firma</th>
                                    <th class="text-center no-borders size-xs" width="33%">Cargo</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>
            </td>
            <td></td>
            <td width="33%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <th>AUTORIZÓ</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-bold"></div>
                            <div class="font-bold">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                            <br>
                            <br>
                            <div>{{ $request['titular3'] }}</div>
                            <div><span style="color:white">.</span>{{ $request['cargo3'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="my-table" width="100%" cellspacing="0">
                                <tr>
                                    <th class="text-center no-borders size-xs" width="33%">Nombre</th>
                                    <th class="text-center no-borders size-xs" width="33%">Firma</th>
                                    <th class="text-center no-borders size-xs" width="33%">Cargo</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>
            </td>
        </tr>
    </table>
</div>