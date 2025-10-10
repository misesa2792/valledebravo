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
                    <th rowspan="3" width="40" class="text-center" width="40">Código</th>
                    <th rowspan="3" width="40%" class="text-center">Descripción de las Metas de Actividad </th>
                    <th rowspan="3" class="text-center" width="100">Unidad de Medida </th>
                    <th rowspan="3" class="text-center" width="50">Cantidad Programada Anual</th>
                    <th colspan="8" class="text-center">Calendarización de Metas Físicas</th>
                </tr>
                <tr class="t-tr-s16 c-text-alt">
                    <th colspan="2" class="c-white bg-yellow-meta text-center" width="100">Primer Trimestre</th>
                    <th colspan="2" class="c-white bg-green-meta text-center" width="100">Segundo Trimestre</th>
                    <th colspan="2" class="c-white bg-blue-meta text-center" width="100">Tercer Trimestre</th>
                    <th colspan="2" class="c-white bg-red-meta text-center" width="100">Cuarto Trimestre</th>
                </tr>
                <tr class="t-tr-s16 c-text-alt">
                    <th class="bg-gray text-center">Abs.</th>
                    <th class="bg-gray text-center">%</th>
                    <th class="bg-gray text-center">Abs.</th>
                    <th class="bg-gray text-center">%</th>
                    <th class="bg-gray text-center">Abs.</th>
                    <th class="bg-gray text-center">%</th>
                    <th class="bg-gray text-center">Abs.</th>
                    <th class="bg-gray text-center">%</th>
                </tr>
            
                @foreach ($data['rowsMetas'] as $p)
                    <tr class="t-tr-s16 c-text bg-white">
                        <td class="text-center">{{ $p->codigo }}</td>
                        <td>{{ $p->meta }}</td>
                        <td class="text-center">{{ $p->unidad_medida }}</td>
                        <td class="text-center fun">{{ SiteHelpers::getMassDecimales($p->aa_anual) }}</td>
                        <td class="text-center c-yellow-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim1) }}</td>
                        <td class="text-center c-yellow-meta">{{ $p->aa_porc1 }}</td>
                        <td class="text-center c-green-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim2) }}</td>
                        <td class="text-center c-green-meta">{{ $p->aa_porc2 }}</td>
                        <td class="text-center c-blue-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim3) }}</td>
                        <td class="text-center c-blue-meta">{{ $p->aa_porc3 }}</td>
                        <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim4) }}</td>
                        <td class="text-center c-red-meta">{{ $p->aa_porc4 }}</td>
                    </tr>
                @endforeach

                @if(count($data['rowsMetas']) < 25)
                    @for ($i = 0; $i < 25 - count($data['rowsMetas']); $i++)
                         <tr class="t-tr-s16 c-text blanco-last" >
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
                            <td class="bg-white text-center color-white">.</td>
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
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                        <td class="bg-white text-center color-white">.</td>
                    </tr>
                @endif
            </table>
        </div>