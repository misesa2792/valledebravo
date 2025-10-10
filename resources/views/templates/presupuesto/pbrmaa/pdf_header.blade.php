<div>
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
                        <td>Fecha</td>
                        <th>{{ $txt_fecha }}</th>
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
                        <td>PbRM-02a</td>
                        <th colspan="3" class="text-center">
                            <div>Calendarización de Metas</div>
                            <div>de Actividad por Proyecto</div>
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
            </td>
        </tr>
    </table>
</div>
