<div>


<table id="table" width="100%" cellspacing="0" >
    <tr>
        <td width="40%" class="text-center">
            <h1>AYUNTAMIENTO DE</h1>
            <h1>{{ $ins->municipio }}</h1>
            <br>
            <table width="100%" cellspacing="0"  class="my-table">
                <tr>
                    <th class="text-center bg-body">Reporte de Avance de Metas</th>
                </tr>
                <tr>
                    <td>{{ $row->area }}</td>
                </tr>
                <tr>
                    <td>{{ $rows->pro_desc }}</td>
                </tr>
            </table>
        </td>
        <td width="1%"></td>
        <td width="59%">
            <table width="100%" cellspacing="0"  class="my-table">
                <tr>
                    <th colspan="3" class="text-center bg-body">Identificador</th>
                </tr>
                <tr>
                    <td class="text-right bg-body">Finalidad:</td>
                    <td>{{ $rows->fin_numero }}</td>
                    <td width="60%">{{ $rows->fin_desc }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Función:</td>
                    <td>{{ $rows->fun_numero }}</td>
                    <td>{{ $rows->fun_desc }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Subfunción:</td>
                    <td>{{ $rows->sub_numero }}</td>
                    <td>{{ $rows->sub_desc }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Programa:</td>
                    <td>{{ $rows->pro_numero }}</td>
                    <td>{{ $rows->pro_desc }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Subprograma:</td>
                    <td>{{ $rows->subp_numero }}</td>
                    <td>{{ $rows->subp_desc }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Proyecto:</td>
                    <td>{{ $rows->proy_no }}</td>
                    <td><strong>{{ $rows->proy_desc }}</strong></td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Dependencia General:</td>
                    <td>{{ $row->numero }}</td>
                    <td>{{ $row->area }}</td>
                </tr>
                <tr>
                    <td class="text-right bg-body">Dependencia Auxiliar:</td>
                    <td>{{ $row->no_coord }}</td>
                    <td>{{ $row->coordinacion }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>