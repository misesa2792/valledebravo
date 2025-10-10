<div>
    <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="10%" rowspan="5">
                @if(!empty($data['footer']['firmas']['logo_izq'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="text-center font-bold f-12">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td width="10%" rowspan="5">
                @if(!empty($data['footer']['firmas']['logo_der'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['anio'] }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td class="text-center font-bold f-12">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="80%"></td>
            <td>
                <table  class="my-table" width="100%">
                    <tr>
                        <td class="text-right">Ejercicio Fiscal:</td>
                        <th width="50%">{{ $data['anio'] }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="padding:4px;"></div>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="35%">
                <table  class="my-table" width="100%">
                    <tr>
                        <td>Municipio: </td>
                        <th class="text-center">{{ $data['institucion'] }}</th>
                        <td>No.</td>
                        <th class="text-center">{{ $data['no_institucion'] }}</th>
                    </tr>
                    <tr>
                        <td class="text-center">PbRM-01b</td>
                        <th colspan="3" class="text-center">
                            <div>Programa Anual</div>
                            <div>Descripción del programa presupuestario</div>
                        </th>
                    </tr>
                </table>
            </td>
            <td width="3%"></td>
            <td width="62%">
                <table  class="my-table" width="100%">
                    <tr>
                        <th class="no-borders" width="100"></th>
                        <th class="text-center no-borders" width="70">(Clave)</th>
                        <th class="text-center no-borders">(Denominación)</th>
                     </tr>
                    <tr>
                         <th class="text-right no-borders">Programa presupuestario: </th>
                         <td class="text-center">{{ $data['no_programa'] }}</td>
                         <td>{{ $data['programa'] }}</td>
                     </tr>
                    <tr>
                         <th class="text-right no-borders">Dependencia General:</th>
                         <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                         <td>{{ $data['dep_gen'] }}</td>
                     </tr>
                </table>
            </td>
        </tr>
    </table>
</div>