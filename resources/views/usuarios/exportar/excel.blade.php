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
      <th>USUARIOS</th>
      <th>ENLACE</th>
      <th>DEPENDENCIA GENERAL</th>
      <th>DEPENDENCIA AUXILIAR</th>
    </tr>
  </thead>

  <tbody>
          
    @foreach (json_decode($rows) as $row)
      <tr>
        <td>{{ $row->enlace }}</td>
        <td>{{ $row->email }}</td>
        <td>
          <table>
            @foreach ($row->rows as $item)
            <tr>
              <td>{{ $item->dep_gen }}</td>
              <td>{{ $item->dep_aux }}</td>
            </tr>
          @endforeach
          </table>
        </td>
      </tr>
      
    @endforeach
    
  </tbody>

</table>

