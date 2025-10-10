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
                padding: 2px 2px;
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
            .my-table-blanco .blanco td,
            .my-table-blanco .blanco th {
                border-left:0px solid #000000;
                border-right:0px solid #000000;
                border-bottom:0px solid #000000;
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
            <table width="100%" class="my-table" >
                <tr class="t-tr-s16 c-text-alt">
                    <th rowspan="3" width="40" class="text-center">Código</th>
                    <th rowspan="3" width="40%" class="text-center">Descripción de las Metas de Actividad sustantivas relevantes</th>
                    <th colspan="4" class="text-center" >Metas de actividad</th>
                    <th colspan="2" class="text-center" >Variación</th>
                </tr>
                <tr class="t-tr-s16 c-text-alt">
                    <th rowspan="2" class="bg-gray text-center">Unidad de Medida</th>
                    <th colspan="2" class="bg-gray text-center">{{ $data['year'] - 1 }}</th>
                    <th class="bg-gray text-center">{{ $data['year'] }}</th>
                    <th rowspan="2" class="text-center" width="50">Absoluta</th>
                    <th rowspan="2" class="text-center" width="50">%</th>
                </tr>
                <tr class="t-tr-s16 c-text-alt">
                    <th class="bg-gray" class="text-center">Programado</th>
                    <th class="bg-gray" class="text-center">Alcanzado</th>
                    <th class="bg-gray" class="text-center">Programado</th>
                </tr>
                @foreach ($data['rowsMetas'] as $p)
                    <tr class="bg-white t-tr-s16 c-text-alt">
                        <td class="text-center">{{ $p->codigo }}</td>
                        <td>{{ $p->meta }}</td>
                        <td class="text-center">{{ $p->unidad_medida }}</td>
                        <td class="text-center">{{ SiteHelpers::getMassDecimales($p->programado) }}</td>
                        <td class="text-center">{{ SiteHelpers::getMassDecimales($p->alcanzado) }}</td>
                        <td class="text-center">{{ SiteHelpers::getMassDecimales($p->anual) }}</td>
                        <td class="text-center">{{ SiteHelpers::getMassDecimales($p->absoluta) }}</td>
                        <td class="text-center">{{ $p->porcentaje }}</td>
                    </tr>
                @endforeach

                @if(count($data['rowsMetas']) < 23)
                      @for ($i = 0; $i < 23 - count($data['rowsMetas']); $i++)
                        <tr class="t-tr-s16 c-text blanco-last" >
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                        </tr>
                    @endfor
                    <tr class="t-tr-s16 c-text blanco" >
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                    </tr>
                @endif
                
            </table>
            
            <div style="padding:2px;"></div>

            <table width="100%" cellspacing="0">
                <tr>
                    <td width="70%"></td>
                    <td>
                        <table  class="my-table" width="100%">
                            <tr>
                                <td class="text-right no-borders">Gasto estimado total:</td>
                                <th width="25%">$ {{ $data['presupuesto'] }}</th>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>