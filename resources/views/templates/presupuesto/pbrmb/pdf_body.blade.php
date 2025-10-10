        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .text-center{text-align:center;}
            .text-left{text-align:left;}
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

        <table width="100%" cellspacing="0">
            <tr>
                <td width="70%"></td>
                <td>
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Ejercicio Fiscal</td>
                <th>{{ $proy->anio }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        <table width="100%" cellspacing="0">
            <tr>
                <td width="40%">
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Municipio: </td>
                            <th class="text-center">{{ $proy->municipio }}</th>
                            <td>No.</td>
                            <th class="text-center">{{ $proy->no_municipio }}</th>
                        </tr>
                        <tr>
                            <td>PbRM-01b</td>
                            <th colspan="3" class="text-center">
                                <div>Programa Anual</div>
                                <div>Descripción del programa presupuestario</div>
                            </th>
                        </tr>
                    </table>
                </td>
                <td width="10%"></td>
                <td width="50%">
                    <table  class="my-table" width="100%">
                        <tr>
                            <th></th>
                            <th class="text-center">Clave</th>
                            <th class="text-center">Denominación</th>
                         </tr>
                        <tr>
                             <th>Programa presupuestario: </th>
                             <td>{{ $proy->no_programa }}</td>
                            <td>{{ $proy->programa }}</td>
                         </tr>
                        <tr>
                             <th>Dependencia General:</th>
                             <td>{{ $proy->no_dep_gen }}</td>
                             <td>{{ $proy->dep_gen }}</td>
                         </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>
        <table  class="my-table" width="100%">
            <tr>
                <th class="text-left">Diagnóstico de Programa presupuestario elaborado usando análisis FODA </th>
            </tr>
            <tr>
                <td>
                    <div>FORTALEZAS</div>
                    <div>
                        @foreach ($foda1 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                    </div>
                    <div>OPORTUNIDADES</div>
                    <div>
                        @foreach ($foda2 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                    </div>
                    <div>DEBILIDADES</div>
                    <div>
                        @foreach ($foda3 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                    </div>
                    <div>AMENAZAS</div>
                    <div>
                        @foreach ($foda4 as $f)
                            <div>
                                <ul>
                                    <li class="s-16">
                                    {{ $f->foda }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
        </table> 

        <br>
        <table  class="my-table" width="100%">
            <tr>
                <th class="text-left">Objetivo del Programa presupuestario </th>
            </tr>
            <tr>
             <td>{{ $proy->objetivo_programa }}</td>
            </tr>
        </table> 

        <br>
        <table  class="my-table" width="100%">
            <tr>
                <th class="text-left">Estrategias para alcanzar el objetivo del Programa presupuestario </th>
            </tr>
            <tr>
             <td>{{ $proy->estrategias_objetivo }}</td>
            </tr>
        </table> 

        <br>
        <table  class="my-table" width="100%">
            <tr>
                <th class="text-left">Objetivo, Estrategias y Líneas de Acción del PDM atendidas </th>
            </tr>
            <tr>
             <td>{{ $proy->pdm }}</td>
            </tr>
        </table> 

        <br>
        <table  class="my-table" width="100%">
            <tr>
                <th class="text-left">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario </th>
            </tr>
            <tr>
             <td>{{ $proy->ods }}</td>
            </tr>
        </table> 