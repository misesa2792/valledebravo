<div style="padding:10px;">
        
<style>
    .text-center{text-align:center;}
    .my-table {
        border: 1px solid #6e6e6e;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 1px solid #6e6e6e;
        border-collapse: collapse;
        padding: 3px;
        font-size: 10px;
    }
</style>



            <h3 class="text-center">Avance de Obras o Acciones Primer Trimestre</h3>

            <table class="my-table" width="100%">
                <tr>
                    <th width="20%">Concepto</th>
                    <th>Descripción</th>
                </tr>
                <tr>
                    <td>Año</td>
                    <td>{{ $data['year'] }}</td>
                </tr>
                <tr>
                    <td>Fecha de inicio</td>
                    <td>{{ $request['fi'] }}</td>
                </tr>
                <tr>
                    <td>Fecha de conclusión</td>
                    <td>{{ $request['ff'] }}</td>
                </tr>
                <tr>
                    <td>Municipio</td>
                    <td>{{ $request['municipio'] }}</td>
                </tr>
                <tr>
                    <td>Todo el municipio</td>
                    <td>{{ $request['todo_mun'] }}</td>
                </tr>
                <tr>
                    <td>Localidad</td>
                    <td>{{ $request['localidad'] }}</td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td>{{ $request['descripcion'] }}</td>
                </tr>
                <tr>
                    <td>Beneficiarios</td>
                    <td>{{ $request['beneficiarios'] }}</td>
                </tr>
                <tr>
                    <td>Costo</td>
                    <td>{{ $request['costo'] }}</td>
                </tr>
                <tr>
                    <td>Área ejecutora</td>
                    <td>{{ $request['area_eje'] }}</td>
                </tr>
                <tr>
                    <td>Tipo de actividad</td>
                    <td>{{ $request['tipo_act'] }}</td>
                </tr>
                <tr>
                    <td>Eje cambio/Eje transversal</td>
                    <td>{{ $data['pilares'] }}</td>
                </tr>
                <tr>
                    <td>Línea de acción</td>
                    <td>{{ $data['no_linea_accion'] }}: {{ $data['linea_accion'] }}</td>
                </tr>
                <tr>
                    <td>Meta PDM 25-27</td>
                    <td>{{ $data['no_meta_pdm'] }}: {{ $data['meta_pdm'] }}</td>
                </tr>
                <tr>
                    <td>Meta PbRM</td>
                    <td>Meta {{ $data['no_meta'] }}: {{ $data['meta'] }}</td>
                </tr>
                <tr>
                    <td>Cantidad realizada</td>
                    <td>{{ $request['cantidad_realizada'] }}</td>
                </tr>
            </table>

</div>