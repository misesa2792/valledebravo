<style>
  th{font-size: 10px;}
  td{font-size: 10px;}
  .danger{background:#fddfe0;color:#000;}
  .success{background:#e5f8d0;color:#000;}
  .info{background:#c4e3f3;color:#000;}
  .text-center{text-align: center;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<table border="1">
  <thead>
    <tr>
      <th>No.</th>
      <th>DEPENDENCIA GENERAL</th>
      <th>No.</th>
      <th>DEPENDENCIA AUXILIAR</th>
      <th>No. PROYECTO </th>
      <th>PROYECTO </th>
      <th>No. PROGRAMA </th>
      <th>PROGRAMA </th>
      <th>NOMBRE DE LA ACCIÓN</th>
      <th>UNIDAD DE MEDIDA</th>
      <th class="c-white text-center bg-pink">PROGRAMACIÓN ANUAL</th>
      <th class="c-white text-center bg-yellow-meta">PROG. 1ER TRIMESTRE</th>
      <th class="c-white text-center bg-yellow-meta">AVANCE 1ER TRIMESTRE</th>
      <th class="c-white text-center bg-green-meta">PROG. 2DO TRIMESTRE</th>
      <th class="c-white text-center bg-green-meta">AVANCE 2DO TRIMESTRE</th>
      <th class="c-white text-center bg-blue-meta">PROG. 3ER TRIMESTRE</th>
      <th class="c-white text-center bg-blue-meta">AVANCE 3ER TRIMESTRE</th>
      <th class="c-white text-center bg-red-meta">PROG. 4TO TRIMESTRE</th>
      <th class="c-white text-center bg-red-meta">AVANCE 4TO TRIMESTRE</th>
    </tr>
  </thead>

  <tbody>
          
    @foreach (json_decode($rows) as $row)
      <tr>
        <td>{{ $row->no_area }}</td>
        <td>{{ $row->area }}</td>
        <td>{{ $row->no_dep_aux }}</td>
        <td>{{ $row->dep_aux }}</td>
        <td>{{ "'".$row->no_proy }}</td>
        <td>{{ $row->proyecto }}</td>
        <td>{{ "'".$row->no_programa }}</td>
        <td>{{ $row->programa }}</td>
        <td>{{ $row->accion }}</td>
        <td>{{ $row->unidad_medida }}</td>
        <th class="text-center {{ $row->programacion_anual > 0 ? 'success' : 'danger' }}">{{  $row->programacion_anual > 0 ? $row->programacion_anual : '' }}</th>
        <th class="text-center {{ $row->trim_1 > 0 ? 'success' : 'danger' }}">{{ $row->trim_1 > 0 ? $row->trim_1 : '' }}</th>
        <th class="text-center {{ $row->cant_1 > 0 ? 'info' : 'danger' }}">{{ $row->cant_1 > 0 ? $row->cant_1 : '' }}</th>
        <th class="text-center {{ $row->trim_2 > 0 ? 'success' : 'danger' }}">{{ $row->trim_2 > 0 ? $row->trim_2 : '' }}</th>
        <th class="text-center {{ $row->cant_2 > 0 ? 'info' : 'danger' }}">{{ $row->cant_2 > 0 ? $row->cant_2 : '' }}</th>
        <th class="text-center {{ $row->trim_3 > 0 ? 'success' : 'danger' }}">{{ $row->trim_3 > 0 ? $row->trim_3 : '' }}</th>
        <th class="text-center {{ $row->cant_3 > 0 ? 'info' : 'danger' }}">{{ $row->cant_3 > 0 ? $row->cant_3 : '' }}</th>
        <th class="text-center {{ $row->trim_4 > 0 ? 'success' : 'danger' }}">{{ $row->trim_4 > 0 ? $row->trim_4 : '' }}</th>
        <th class="text-center {{ $row->cant_1 > 0 ? 'info' : 'danger' }}">{{ $row->cant_4 > 0 ? $row->cant_4 : '' }}</th>
      </tr>
    @endforeach
    
  </tbody>

</table>

