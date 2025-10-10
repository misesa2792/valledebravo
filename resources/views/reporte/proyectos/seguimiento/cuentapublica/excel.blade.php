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
      <th>PROGRAMA </th>
      <th>DEPENDENCIA GENERAL</th>
      <th>DEPENDENCIA AUXILIAR</th>
      <th>OBJETIVOS</th>
      <th>ESTRATEGIAS</th>
      <th>LÍNEAS DE ACCIÓN</th>
      <th>METAS PROGRAMADAS</th>
      <th>METAS EJECUTADAS</th>
    </tr>
  </thead>

  <tbody>
          
    @foreach (json_decode($rows) as $row)
      <tr>
        <td>{{ "'".$row->no_programa }}</td>
        <td>{{ $row->programa }}</td>
        <td>{{ $row->no_dep_gen }} {{ $row->dep_gen }}</td>
        <td>{{ $row->no_dep_aux }} {{ $row->dep_aux }}</td>
        <td>{{ $row->obj }}</td>
        <td>{{ $row->est }}</td>
        <td>{{ $row->linea }}</td>
        <td>{{ $row->anual }}</td>
        <td>{{ $row->cantidad }}</td>

      </tr>
    @endforeach
    
  </tbody>

</table>

