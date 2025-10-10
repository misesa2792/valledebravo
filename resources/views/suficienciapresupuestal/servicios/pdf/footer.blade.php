<table width="100%" class="my-table" >
    <tr>
        <td width="70%" class="text-center" style="padding:5px;">
                <div class="c-danger">DEPENDENCIA SOLICITANTE</div>

                <table width="100%" class="my-table" >
                    <tr>
                        <td width="50%" style="border:1px solid #C00000;">
                            <div class="text-center c-black">ÁREA USUARIA</div>
                            <br>
                            <br>
                            <div class=" c-black"> {{ $request['au_name'] }}</div>
                            <div class=" c-black"> {{ $request['au_puesto'] }}</div>
                        </td>
                        <td width="50%" style="border:1px solid #C00000;">
                            <div class="text-center c-black">VO. BO.</div>
                            <br>
                            <br>
                            <div class="c-black"> {{ $request['vo_bo_name'] }}</div>
                            <div class="c-black"> {{ $request['vo_bo_puesto'] }}</div>
                        </td>
                    </tr>
                </table>
        </td>
        <td width="30%" class="text-center " style="padding:5px;">
            <div class="c-danger">AUTORIZACIÓN PRESUPUESTAL</div>
            <table width="100%" class="my-table" >
                <tr>
                    <td style="border:1px solid #C00000;" class="text-center">
                        <br>
                        <br>
                        <br>
                        <div class="c-black">{{ $request['tesorero'] }}</div>
                        <div class="c-black">TESORERO MUNICIPAL</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<table width="100%" class="my-table" >
    <tr>
        <td class="text-center" style="padding:5px;">
            <div class="c-danger">VALIDACIÓN DE SUFICIENCIA PRESUPUESTAL</div>

            <table class="table">
                <tr>
                    <td width="33%" style="border:1px solid #C00000;">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="text-center c-black">SELLO</div>
                    </td>
                    <td width="33%" style="border:1px solid #C00000;">
                        <br>
                        <br>
                        <br>
                        <div class="c-black">{{ $request['prog_pres'] }}</div>
                        <div class="c-black">JEFA DEL DEPARTAMENTO DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL</div>
                    </td>
                    <td width="33%" style="border:1px solid #C00000;">
                        <br>
                        <br>
                        <br>
                        <div class="c-black">{{ $request['dir_egresos'] }}</div>
                        <div class="c-black">DIRECTORA DE EGRESOS</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>