<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="10%" class="text-center"></td>
            <td width="30%" class="text-center">
               <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">ELABORÓ</div>
                            <div class="font-bold" style="color:white">.</div>
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
            <td width="10%" class="text-center"></td>
            <td></td>
            <td width="30%" class="text-center">
                <table width="100%" class="my-table">
                    <tr>
                        <td>
                            <div class="font-bold">VALIDÓ</div>
                            <div class="font-bold">TITULAR DEPENDENCIA GENERAL</div>
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
            <td width="10%" class="text-center"></td>
        </tr>
    </table>
</div>