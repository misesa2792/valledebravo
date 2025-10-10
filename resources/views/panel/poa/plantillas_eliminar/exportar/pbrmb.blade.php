<style>
    th{font-size: 10px;}
    td{font-size: 10px;}
    .danger{background:#fddfe0;color:#000;}
    .success{background:#e5f8d0;color:#000;}
    .info{background:#c4e3f3;color:#000;}
    .text-center{text-align: center;}
    .background{background: #002060;color: white;}
  </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <table border="1">
    <thead>
      <tr >
        <th class="background">
        PROGRAMA (8 dígitos)
        </th>
        <th class="background">DEPENDENCIA GENERAL</th>
        <th class="background">Diagnóstico de Programa Presupuestario elaborado usando análisis FODA</th>
        <th class="background">Objetivo del Programa Presupuestario</th>
        <th class="background">Estrategias para alcanzar el objetivo del Programa Presupuestario</th>
        <th class="background">Objetivos, Estrategias y Lineas de Acción del PDM atendidas</th>
        <th class="background">Objetivos y Metas para el Desarrollo Sostenible (ODS) , atendidas por el Programa Presupuestario</th>
      </tr>
    </thead>
  
    <tbody>
        @foreach (json_decode($rows) as $row)
        <tr>
          <td>{{ $row->no_programa }}</td>
          <td>{{ $row->no_dep_gen }}</td>
          <td style='mso-data-placement:same-cell;'>
            <div>
              FORTALEZAS
              @foreach ($row->fortalezas as $f)
                •{{ $f->foda }}
              @endforeach
            </div>
            <div>
              OPORTUNIDADES
              @foreach ($row->oportunidades as $f)
                •{{ $f->foda }}
              @endforeach
            </div>
            <div>
              DEBILIDADES
              @foreach ($row->debilidades as $f)
                •{{ $f->foda }}
              @endforeach
            </div>
            <div>
              AMENAZAS
              @foreach ($row->amenazas as $f)
                •{{ $f->foda }}
              @endforeach
            </div>
          </td>
          <td>{{ $row->objetivo_programa }}</td>
          <td>{{ $row->estrategias_objetivo }}</td>
          <td>{{ $row->pdm }}</td>
          <td>{{ $row->ods }}</td>
        </tr>
      @endforeach 
      
    </tbody>
  
  </table>
  
  