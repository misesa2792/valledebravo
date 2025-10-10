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
                 padding: 2px 3px;
                font-family: Inter, sans-serif;
                font-size:8px;
            }
            
            .my-table .blanco td,
            .my-table .blanco th {
                border-left:1px solid #000000;
                border-right:1px solid #000000;
                border-bottom:0px solid #000000;
                border-top:0px solid #000000;
            }
            .tr_no_borders th{
                border: 0px solid #ffffff;
            }
            .color-white{color:#ffffff;}
        </style>

    <div>
        <table width="100%" cellspacing="0">
            <tr>
                <td width="70%"></td>
                <td>
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Fecha</td>
                            <th>{{ $txt_fecha }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="padding:4px;"></div>

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
                            <td>PbRM-01e</td>
                            <th colspan="3" class="text-center">
                                <div>Matriz de Indicadores para Resultads por</div>
                                <div>Programa presupuestario y Dependencia General</div>
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
                            <th>Obletivo del Programa Presupuestario:</th>
                            <td></td>
                            <td>{{ $proy->objetivo }}</td>
                        </tr>
                        <tr>
                             <th>Dependencia General o Auxiliar:</th>
                             <td>{{ $proy->no_dep_gen }}</td>
                             <td>{{ $proy->dep_gen }}</td>
                         </tr>
                         <tr>
                            <th>Eje de Cambio o Eje transversal:</th>
                            <td></td>
                            <td>{{ $proy->pilar }}</td>
                        </tr>
                         <tr>
                            <th>Tema de Desarrollo:</th>
                            <td></td>
                            <td>{{ $proy->tema }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>

        <table  class="my-table" width="100%">
            <tr>
                <th rowspan="2" width="35%">Objetivo o resumen narrativo</th>
                <th colspan="3" class="text-center">Indicadores</th>
                <th rowspan="2"  class="text-center">Medios de verificación</th>
                <th rowspan="2"  class="text-center">Supuestos</th>
            </tr>
            <tr>
                <th>Nombre</th>
                <th>Fórmula</th>
                <th>Frecuencia y Tipo</th>
            </tr>
            <tr class="tr_no_borders">
                <th colspan="6" class="text-left">Fin</th>
            </tr>
            @foreach($rows_projects1 as $r)
                <tr>
                    <td>{{ $r->descripcion }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->formula }}</td>
                    <td>{{ $r->frecuencia }}</td>
                    <td>{{ $r->medios }}</td>
                    <td>{{ $r->supuestos }}</td>
                </tr>
            @endforeach

            <tr class="tr_no_borders">
                <th colspan="6" class="text-left">Propósito</th>
            </tr>
            @foreach($rows_projects2 as $r)
                <tr>
                    <td>{{ $r->descripcion }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->formula }}</td>
                    <td>{{ $r->frecuencia }}</td>
                    <td>{{ $r->medios }}</td>
                    <td>{{ $r->supuestos }}</td>
                </tr>
            @endforeach

            <tr class="tr_no_borders">
                <th colspan="6" class="text-left">Componentes</th>
            </tr>
            @foreach($rows_projects3 as $r)
                <tr>
                    <td>{{ $r->descripcion }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->formula }}</td>
                    <td>{{ $r->frecuencia }}</td>
                    <td>{{ $r->medios }}</td>
                    <td>{{ $r->supuestos }}</td>
                </tr>
            @endforeach

            <tr class="tr_no_borders">
                <th colspan="6" class="text-left">Actividades</th>
            </tr>
            @foreach($rows_projects4 as $r)
                <tr>
                    <td>{{ $r->descripcion }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->formula }}</td>
                    <td>{{ $r->frecuencia }}</td>
                    <td>{{ $r->medios }}</td>
                    <td>{{ $r->supuestos }}</td>
                </tr>
            @endforeach
        </table>
        
    </div>