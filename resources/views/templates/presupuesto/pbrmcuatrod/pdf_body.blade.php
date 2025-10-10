        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .text-left{text-align:left;}
            .font-bold{font-weight: bold;}
            .f-12{font-size:11px;}
            .f-10{font-size:10px;}
            .my-table {
                border: 1px solid #000000;
                border-collapse: collapse;
            }
            .my-table td,
            .my-table th {
                border: 1px solid #000000;
                border-collapse: collapse;
                padding: 4px 5px;
                font-size: 10px;
            }
            .my-table .blanco td,
            .my-table .blanco th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }

            .my-table .no_borders td,
            .my-table .no_borders th {
                border-left:0px solid #000000;
                border-right:0px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .color-white{color:#ffffff;}
        </style>

    <div>
        <table width="100%" class="my-table">

            <tr>
                <td colspan="6">
                    <table width="100%" class="no_borders" cellspacing="0">
                        <tr>
                            <td width="40%"></td>
                            <th width="10%">PROYECTO:</th>
                            <td>
                                <table width="20%" class="my-table" cellspacing="0">
                                    <tr>
                                        <th height="20" class="text-center">
                                            @if($row['header']['tipo'] == 2 || $row['header']['tipo'] == 3 )
                                            X
                                            @endif
                                        </th>
                                    </tr>
                                </table>
                            </td>
                            <th width="10%">DEFINITIVO:</th>
                            <td>
                                <table width="20%" class="my-table" cellspacing="0">
                                    <tr>
                                        <th height="20" class="text-center">
                                            @if($row['header']['tipo'] == 1 )
                                            X
                                            @endif
                                        </th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

                <tr>
                    <td colspan="6">
                        <table width="100%" class="no_borders" cellspacing="0">
                            <tr>
                                <th class="text-left" width="20%">ENTE PUBLICO:</th>
                                <th class="text-left">{{ $row['header']['municipio'] }}</th>
                                <th  width="5%">No.</th>
                                <th class="text-left">{{ $row['header']['no_municipio'] }}</th>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th class="text-center bg-white" colspan="2">CAPÍTULO</th>
                    <th class="text-center bg-white">CONCEPTO</th>
                    <th class="text-center bg-white">AUTORIZADO {{ $row['header']['anio'] -1 }}</th>
                    <th class="text-center bg-white">EJERCIDO {{ $row['header']['anio'] -1 }}</th>
                    <th class="text-center bg-white">PRESUPUESTADO {{ $row['header']['anio'] }}</th>
                </tr>

                <tr class="no-borders t-tr-s14 c-text-alt">
                    <td class="bg-white text-left" colspan="2">8210</td>
                    <td class="bg-white">PRESUPUESTO DE EGRESOS APROBADO</td>
                    <td class="text-center bg-white">{{ $row['autorizado'] }}</td>
                    <td class="text-center bg-white">{{ $row['ejercido'] }}</td>
                    <td class="text-right bg-white">{{ $row['presupuesto'] }}</td>
                </tr>

                @foreach ($row['rowsRegistros'] as $p)
                    <tr>
                        <td class="text-right bg-white" colspan="2">{{ $p['no_capitulo'] }}</td>
                        <td class="bg-white">{{ $p['capitulo'] }}</td>
                        <td class="text-center bg-white">{{ $p['autorizado'] }}</td>
                        <td class="text-center bg-white">{{ $p['ejercido'] }}</td>
                        <td class="text-right bg-white">{{ $p['presupuesto'] }}</td>
                    </tr>
                @endforeach
        </table>
    </div>