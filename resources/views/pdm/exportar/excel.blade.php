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
      <th>PDM</th>
      <th>TEMA</th>
      <th>SUBTEMA</th>
      <th>CLAVE</th>
      <th>OBJETIVO</th>
      <th>CLAVE</th>
      <th>ESTRATEGIAS</th>
      <th>CLAVE</th>
      <th>LINEAS DE ACCION</th>
    </tr>
      @foreach (json_decode($rows) as $row)
        <tr>
          <td>{{ $row->pilares }}</td>
          <td>{{ $row->temas }}</td>
          <td>{{ $row->subtema }}</td>
          <td>{{ $row->clave_objetivos }}</td>
          <td>{{ $row->objetivos }}</td>
          <td>{{ $row->clave_estrategicas }}</td>
          <td>{{ $row->estrategias }}</td>
          <td>{{ $row->clave_linea }}</td>
          <td>{{ $row->linea }}</td>
        </tr>
      @endforeach
  </table>

