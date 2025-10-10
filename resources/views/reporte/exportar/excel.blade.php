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
      <th>DEP. GEN.</th>
      <th>DEP. AUX.</th>
      <th>NO. PROYECTO</th>
      <th colspan="2">METAS</th>
      <th>1°</th>
      <th>JUSTIFICACION</th>
      <th>2°</th>
      <th>JUSTIFICACION</th>
      <th>3°</th>
      <th>JUSTIFICACION</th>
      <th>4°</th>
      <th>JUSTIFICACION</th>
      <th>PORCENTAJE DE AVANCE SIN RECONDUCCIÓN</th>
    </tr>
      @foreach (json_decode($rows) as $key => $row)
        @foreach ($row->rowsMetas as $ke => $r)
            <tr>
              @if($ke == 0)
              <td rowspan="{{ count($row->rowsMetas) }}">{{ $row->no_dep_gen }}</td>
              <td rowspan="{{ count($row->rowsMetas) }}" class="text-center">{{ $row->no_dep_aux }}</td>
              <td rowspan="{{ count($row->rowsMetas) }}" class="text-center">{{ $row->nop }}</td>
              @endif
              <td>{{ $r->no_a }}</td>
              <td>{{ $r->meta }}</td>
              <td>{{ $r->rec1 }}</td>
              <td>{{ $r->obs1 }}</td>
              <td>{{ $r->rec2 }}</td>
              <td>{{ $r->obs2 }}</td>
              <td>{{ $r->rec3 }}</td>
              <td>{{ $r->obs3 }}</td>
              <td>{{ $r->rec4 }}</td>
              <td>{{ $r->obs4 }}</td>
              <td>{{ $r->porcentaje }}%</td>
            </tr>
        @endforeach
      @endforeach
  </table>

