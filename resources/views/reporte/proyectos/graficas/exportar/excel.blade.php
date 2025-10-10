<style>
  th{font-size: 10px;}
  td{font-size: 10px;}
  .danger{background:#fddfe0;color:#000;}
  .success{background:#e5f8d0;color:#000;}
  .text-center{text-align: center;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<table border="1">
    <tr class="t-tr-s16">
      <th>DEPENDENCIA GENERAL</th>
      <th>TOTAL</th>
      <th>PORCENTAJE</th>
    </tr>
      @foreach (json_decode($rows) as $row)
        <tr class="t-tr-s16">
          <td>{{ $row->area }}</td>
          <td class="text-center">{{ $row->total }}</td>
          <td class="text-center">{{ number_format($row->porcentaje,2) }} %</td>
        </tr>
      @endforeach
  </table>

