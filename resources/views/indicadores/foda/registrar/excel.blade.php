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
      <th>NO.</th>
      <th>DEPENDENCIA GENERAL</th>
      <th>NO.</th>
      <th>DEPENDENCIA AUXILIAR</th>
      <th>NÚMERO PROGRAMA</th>
      <th>PROGRAMA</th>
      <th>FORTALEZAS</th>
      <th>OPORTUNIDADES</th>
      <th>DEBILIDADES</th>
      <th>AMENAZAS</th>
    </tr>
      @foreach (json_decode($rows) as $row)
        <tr>
          <td>{{ $row->no_dep_gen }}</td>
          <td>{{ $row->dep_gen }}</td>
          <td>{{ $row->no_dep_aux }}</td>
          <td>{{ $row->dep_aux }}</td>
          <td>{{ "'".$row->no_programa }}</td>
          <td>{{ $row->programa }}</td>
          <td>
            <ul class="no-padding">
              @foreach ($row->f1 as $f)
                <li>{{ $f }}</li>
              @endforeach
            </ul>
          </td>
          <td>
            <ul class="no-padding">
              @foreach ($row->f2 as $f)
                <li>{{ $f }}</li>
              @endforeach
            </ul>
          </td>
          <td>
            <ul class="no-padding">
              @foreach ($row->f3 as $f)
                <li>{{ $f }}</li>
              @endforeach
            </ul>
          </td>
          <td>
            <ul class="no-padding">
              @foreach ($row->f4 as $f)
                <li>{{ $f }}</li>
              @endforeach
            </ul>
          </td>
        </tr>
      @endforeach
  </table>

