    <div id="header">
        <table id="table" width="100%" cellspacing="0">
            <tr>
                <td width="10%" rowspan="3">
                    @if(!empty($row['header']['row']['logo_izq'] ))
                        <img src="{{ asset($row['header']['row']['logo_izq'] ) }}" width="110" height="60">
                    @endif
                </td>
                <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
                <td width="10%" rowspan="3">
                    @if(!empty($row['header']['row']['logo_der'] ))
                        <img src="{{ asset($row['header']['row']['logo_der'] ) }}" width="70" height="60">
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center font-bold f-12">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN MUNICIPAL {{ $row['header']['anio'] }}</td>
            </tr>
            <tr>
                <td class="text-center font-bold f-12">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
            </tr>
        </table>
    
        <table width="100%" cellspacing="0">
            <tr>
                <td width="70%"></td>
                <td>
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Ejercicio Fiscal</td>
                            <th>{{ $row['header']['anio'] }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    
        <br>
    
        <table width="100%" cellspacing="0">
            <tr>
                <td width="35%">
                    <table  class="my-table" width="100%">
                        <tr>
                            <td>Municipio: </td>
                            <th class="text-center">{{ $row['header']['institucion'] }}</th>
                            <td>No.</td>
                            <th class="text-center">{{ $row['header']['no_institucion'] }}</th>
                        </tr>
                        <tr>
                            <td>PbRM-01c</td>
                            <th colspan="3" class="text-center">
                                <div>Programa Anual de Metas de Actividad por Proyecto</div>
                            </th>
                        </tr>
                    </table>
                </td>
                <td width="5%"></td>
                <td width="60%">
                    <table  class="my-table" width="100%">
                        <tr>
                            <th></th>
                            <th class="text-center">Clave</th>
                            <th class="text-center">Denominación</th>
                         </tr>
                        <tr>
                             <th>Programa presupuestario: </th>
                             <td>{{ $row['header']['no_programa'] }}</td>
                             <td>{{ $row['header']['programa'] }}</td>
                         </tr>
                         <tr>
                            <th>Proyecto: </th>
                            <td>{{ $row['header']['no_proyecto'] }}</td>
                            <td>{{ $row['header']['proyecto'] }}</td>
                        </tr>
                        <tr>
                             <th>Dependencia General:</th>
                             <td>{{ $row['header']['no_dep_gen'] }}</td>
                             <td>{{ $row['header']['dep_gen'] }}</td>
                         </tr>
                         <tr>
                            <th>Dependencia Auxiliar:</th>
                            <td>{{ $row['header']['no_dep_aux'] }}</td>
                            <td>{{ $row['header']['dep_aux'] }}</td>
                        </tr>
                    </table>
    
                    <table  class="my-table" width="100%">
                            <tr class="t-tr-s16">
                                <td><strong class="c-text-alt">Objetivo del Proyecto:</strong> <span class="c-text">{{ $row['header']['obj_proyecto'] }}</span></td>
                            </tr>
                    </table>
                </td>
            </tr>
        </table>
    
    </div>

    
   