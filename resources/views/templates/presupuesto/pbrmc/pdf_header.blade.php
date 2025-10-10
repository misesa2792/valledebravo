    <div id="header">
        <table id="table" width="100%" cellspacing="0">
            <tr>
                <td width="10%" rowspan="3">
            <img src="{{ asset('mass/images/logo_toluca_tl.png') }}" width="130" height="60">
                </td>
                <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
                <td width="10%" rowspan="3">
                    <img src="{{ asset('mass/images/logos/tl2527.png') }}" width="70" height="60">
                </td>
            </tr>
            <tr>
                <td class="text-center font-bold f-12">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $proy->anio }}</td>
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
                            <th>{{ $proy->anio }}</th>
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
                            <th class="text-center">{{ $proy->municipio }}</th>
                            <td>No.</td>
                            <th class="text-center">{{ $proy->no_municipio }}</th>
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
                             <td>{{ $proy->no_programa }}</td>
                             <td>{{ $proy->programa }}</td>
                         </tr>
                         <tr>
                            <th>Proyecto: </th>
                            <td>{{ $proy->no_proyecto }}</td>
                            <td>{{ $proy->proyecto }}</td>
                        </tr>
                        <tr>
                             <th>Dependencia General:</th>
                             <td>{{ $proy->no_dep_gen }}</td>
                             <td>{{ $proy->dep_gen }}</td>
                         </tr>
                         <tr>
                            <th>Dependencia Auxiliar:</th>
                            <td>{{ $proy->no_dep_aux }}</td>
                            <td>{{ $proy->dep_aux }}</td>
                        </tr>
                    </table>
    
                    <table  class="my-table" width="100%">
                            <tr class="t-tr-s16">
                                <td><strong class="c-text-alt">Descripción del Proyecto:</strong> <span class="c-text">{{ $proy->obj_proyecto }}</span></td>
                            </tr>
                    </table>
                </td>
            </tr>
        </table>
    
    </div>

    
   