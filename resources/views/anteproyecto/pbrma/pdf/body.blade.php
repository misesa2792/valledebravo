        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .font-bold{font-weight: bold;}
            .f-12{font-size:8px;}
            .size-xs{font-size:7px;}
            .my-table {
                border: 0px solid #000000;
                border-collapse: collapse;
            }
            .my-table td,
            .my-table th {
                border: 1px solid #000000;
                border-collapse: collapse;
                padding: 2px 3px;
                font-family: Inter, sans-serif;
                font-size:7px;
            }
            .my-table .blanco td,
            .my-table .blanco th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:1px solid #000000;
                border-top:0px solid #000000;
            }
            .my-table .blanco-last td,
            .my-table .blanco-last th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .my-table .no-borders {
                border-left:0px solid #000000;
                border-right:0px solid#000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .color-white{color:#ffffff;}
        </style>

    <div>
        <table width="100%" class="my-table">
                <tr class="t-tr-s16 c-text-alt">
                    <th  class="text-center bg-white" rowspan="2" width="100">
                        <div>Código</div>
                        <div>Dependencia</div>
                        <div>Auxiliar</div>
                    </th>
                    <th  class="text-center bg-white" rowspan="2">Denominación Dependencia Auxiliar</th>
                    <th  class="text-center bg-white no-borders" rowspan="2" width="20"></th>
                    <th  class="text-center bg-white" colspan="2">Proyectos Ejecutados</th>
                    <th  class="text-center bg-white no-borders" rowspan="2" width="20"></th>
                    <th  class="text-center bg-white" rowspan="2" width="15%">Presupuesto autorizado por Proyecto</th>
                </tr>
                <tr class="t-tr-s16 c-text-alt">
                    <th class="text-center bg-white" width="130">Clave del Proyecto</th>
                    <th class="text-center bg-white">Denominación del Proyecto</th>
                </tr>
               
                @foreach ($data['data'] as $p)
                    <tr class="t-tr-s16 c-text">
                        <td class="bg-white text-center">{{ $p['no_dep_aux'] }}</td>
                        <td class="bg-white text-center">{{ $p['dep_aux'] }}</td>
                        <td class="no-borders"></td>
                        <td class="bg-white text-center">{{ $p['no_proyecto'] }}</td>
                        <td class="bg-white text-center">{{ $p['proyecto'] }}</td>
                        <td class="no-borders"></td>
                        <td class="bg-white text-center">{{ $p['presupuesto'] }}</td>
                    </tr>
                @endforeach

                @if(count($data['data']) < 28)
                    @for ($i = 0; $i < 28 - count($data['data']); $i++)
                        <tr class="t-tr-s16 c-text blanco-last" >
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="no-borders color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="no-borders color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                        </tr>
                    @endfor
                    <tr class="t-tr-s16 c-text blanco" >
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="no-borders color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="no-borders color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                    </tr>
                @endif
        </table>

        <div style="padding:2px;"></div>
        
        <table width="100%" cellspacing="0">
            <tr>
                <td width="65%"></td>
                <td>
                    <table  class="my-table" width="100%">
                        <tr>
                            <td class="no-borders text-right">Presupuesto Total:</td>
                            <th width="43%">$ {{ $data['total'] }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>