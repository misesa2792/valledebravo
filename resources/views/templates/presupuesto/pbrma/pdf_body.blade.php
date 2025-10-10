        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .font-bold{font-weight: bold;}
            .f-12{font-size:9px;}
            .my-table {
                border: 1px solid #000000;
                border-collapse: collapse;
            }
            .my-table td,
            .my-table th {
                border: 1px solid #000000;
                border-collapse: collapse;
                padding: 4px 5px;
            }
            .my-table td,
            .my-table th {
                font-size: 9px;
            }
            .my-table .blanco td,
            .my-table .blanco th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            
            .color-white{color:#ffffff;}
        </style>

    <div>
        <table width="100%" class="my-table">
                <tr class="no-borders t-tr-s16 c-text-alt">
                    <th  class="text-center bg-white" rowspan="2">Código Dependencia Auxiliar</th>
                    <th  class="text-center bg-white" rowspan="2">Denominación Dependencia Auxiliar</th>
                    <th  class="text-center bg-white" colspan="2">Proyectos Ejecutados</th>
                    <th  class="text-center bg-white" rowspan="2" width="15%">Presupuesto autorizado por Proyecto</th>
                </tr>
                <tr class="no-borders t-tr-s16 c-text-alt">
                    <th class="text-center bg-white">Clave del Proyecto</th>
                    <th class="text-center bg-white">Denominación del Proyecto</th>
                </tr>
               
                @if(count($rows_projects) > 12)
                    @foreach ($rows_projects as $p)
                        <tr class="t-tr-s16 c-text">
                            <td class="bg-white text-center">{{ $p->no_dep_aux }}</td>
                            <td class="bg-white text-center">{{ $p->dep_aux }}</td>
                            <td class="bg-white text-center">{{ $p->no_proyecto }}</td>
                            <td class="bg-white text-center">{{ $p->proyecto }}</td>
                            <td class="bg-white text-center">{{ SiteHelpers::getMassDecimales($p->presupuesto) }}</td>
                        </tr>
                    @endforeach
                @else 
                    @foreach ($rows_projects as $p)
                        <tr class="t-tr-s16 c-text">
                            <td class="bg-white text-center">{{ $p->no_dep_aux }}</td>
                            <td class="bg-white text-center">{{ $p->dep_aux }}</td>
                            <td class="bg-white text-center">{{ $p->no_proyecto }}</td>
                            <td class="bg-white text-center">{{ $p->proyecto }}</td>
                            <td class="bg-white text-center">{{ SiteHelpers::getMassDecimales($p->presupuesto) }}</td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < 12 - count($rows_projects); $i++)
                        <tr class="t-tr-s16 c-text blanco" >
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                        </tr>
                    @endfor
                @endif
               
        </table>
        
        <br>

        <table width="100%" cellspacing="0">
            <tr>
                <td width="65%"></td>
                <td>
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Presupuesto Total:</td>
                            <th width="43%">$ {{ SiteHelpers::getMassDecimales($proy->total) }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>