<style>
  th{font-size: 10px;}
  td{font-size: 10px;}
  .danger{background:#fddfe0;color:#000;}
  .success{background:#e5f8d0;color:#000;}
  .text-center{text-align: center;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<table border="1">
  <tr>
      <th> 
        PROGRAMA 
        <div>(8 dígitos)</div>
      </th>
      <th>
        PROYECTO
        <div>(12 dígitos)</div>
      </th>
      <th>DEPENDENCIA
        <div>(Dep. gral y aux.) (6 dígitos)</div>
      </th>
      <th>
        CLAVE ACCIÓN
      </th>
      <th>DESCRIPCIÓN DE LA META</th>
      <th>UNIDAD DE MEDIDA</th>
      <th class="text-center">META ANUAL</th>
      <th class="text-center">TRIMESTRE 1</th>
      <th class="text-center">TRIMESTRE 2</th>
      <th class="text-center">TRIMESTRE 3</th>
      <th class="text-center">TRIMESTRE 4</th>
    </tr>
      @foreach (json_decode($rows) as $row)
        <tr>
          <td>{{ "'".$row->no_prog }}</td>
          <td>{{ "'".$row->no_proy }}</td>
          <td>{{ $row->dep_gen.''.$row->no_aux }}</td>
          <td class="text-center">{{ $row->no_accion }}</td>
          <td>{{ $row->meta }}</td>
          <td>{{ $row->unidad_medida }}</td>
          <th class="text-center {{ $row->prog_anual > 0 ? 'success' : 'danger' }}">{{  $row->prog_anual > 0 ? $row->prog_anual : '' }}</th>
          <th class="text-center {{ $row->trim_1 > 0 ? 'success' : 'danger' }}">{{ $row->trim_1 > 0 ? $row->trim_1 : '' }}</th>
          <th class="text-center {{ $row->trim_2 > 0 ? 'success' : 'danger' }}">{{ $row->trim_2 > 0 ? $row->trim_2 : '' }}</th>
          <th class="text-center {{ $row->trim_3 > 0 ? 'success' : 'danger' }}">{{ $row->trim_3 > 0 ? $row->trim_3 : '' }}</th>
          <th class="text-center {{ $row->trim_4 > 0 ? 'success' : 'danger' }}">{{ $row->trim_4 > 0 ? $row->trim_4 : '' }}</th>
        </tr>
      @endforeach
  </table>

