<style>
  th{font-size: 10px;}
  td{font-size: 10px;}
  .bg-danger{background:#fddfe0;color:#000;}
  .bg-success{background:#e5f8d0;color:#000;}
  .bg-blue{background:#d0d1f8;color:#000;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<table border="1">
  <tr>
      <th>#</th>
      <th>Tipo</th>
      <th>Institución</th>
      <th>Pilar</th>
      <th>Tema</th>
      <th>Subtema</th>
      <th>Clave Objetivo</th>
      <th>Objetivo</th>
      <th>Clave Estrategia</th>
      <th>Estrategia</th>
      <th>Clave Línea de Acción</th>
      <th>Línea de Acción</th>
      <th>Proyecto</th>
      <th>Programa</th>
      <th>Meta</th>
      <th>Dependencia General</th>
      <th>Dependencia Auxiliar</th>
      <th>Informe Gobierno</th>
    </tr>
      @foreach (json_decode($rows) as $p)
        <tr>
          <td>{{$j++}}</td>
          <td>Alineacion Metas</td>
          <td>{{ $p->institucion }}</td>
          <td>{{ $p->pilares }}</td>
          <td>{{ $p->tema }}</td>
          <td>{{ $p->subtema }}</td>
          <td>{{ $p->clave_obj }}</td>
          <td>{{ $p->objetivo }}</td>
          <td>{{ $p->clave_est }}</td>
          <td>{{ $p->estrategia }}</td>
          <td>{{ $p->clave_lin }}</td>
          <td>{{ $p->linea_accion }}</td>
          <td class="bg-success">{{ $p->no_proyecto.' '.$p->proyecto }}</td>
          <td class="bg-success">{{ $p->no_programa.' '.$p->programa }}</td>
          <td class="bg-success">{{ $p->meta }}</td>
          <td class="bg-success">{{ $p->no_dep_gen . ' ' . $p->dep_gen }}</td>
          <td class="bg-success">{{ $p->no_dep_aux . ' ' . $p->dep_aux }}</td>
          <td class="bg-danger" width="1000">{{ $p->informe_gobierno }}</td>
        </tr>
      @endforeach
      @foreach (json_decode($act_rel) as $p)
        <tr>
          <td>{{$j++}}</td>
          <td>Actividades Relevantes</td>
          <td>{{ $p->institucion }}</td>
          <td>{{ $p->pilares }}</td>
          <td>{{ $p->tema }}</td>
          <td>{{ $p->subtema }}</td>
          <td>{{ $p->clave_obj }}</td>
          <td>{{ $p->objetivo }}</td>
          <td>{{ $p->clave_est }}</td>
          <td>{{ $p->estrategia }}</td>
          <td>{{ $p->clave_lin }}</td>
          <td>{{ $p->linea_accion }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="bg-blue" width="1000">{{ $p->informe_gobierno }}</td>
        </tr>
      @endforeach
  </table>

