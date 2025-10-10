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
        <th class="background">Dependencia General</th>
        <th class="background">Dependencia Auxiliar</th>
        <th class="background">Finalidad</th>
        <th class="background">Función</th>
        <th class="background">Subfunción</th>
        <th class="background">Programa</th>
        <th class="background">Nombre del Programa Presupuestario PDM</th>
        <th class="background">Objetivo</th>
        <th class="background">Pilar/Eje transversal</th>
        <th class="background">No. Pilar/Eje</th>
        <th class="background">Tema de Desarrollo</th>
        <th class="background">Indicador</th>
        <th class="background">Nombre del Indicador</th>
        <th class="background">Fin del Programa</th>
        <th class="background">Propósito del programa</th>
        <th class="background">Componentes del Programa</th>
        <th class="background">Actividades del Programa</th>
        <th class="background">Fórmula de Cálculo</th>
        <th class="background">Frecuencia</th>
        <th class="background">Tipo de Indicador</th>
        <th class="background">Medio de Verificación</th>
        <th class="background">Supuestos (Factores Externos)</th>
      </tr>
    </thead>
  
    <tbody>
        @foreach (json_decode($rows) as $row)
              <tr>
                <td>{{ $row->no_dep_gen }}</td>
                <td></td>
                <td>{{ $row->no_finalidad." ".$row->finalidad }}</td>
                <td>{{ $row->no_funcion." ".$row->funcion }}</td>
                <td>{{ $row->no_subfuncion." ".$row->subfuncion }}</td>
                <td>{{ $row->no_programa." ".$row->programa }}</td>
                <td>{{ $row->programa }}</td>
                <td>{{ $row->objetivo }}</td>
                <td></td>
                <td>{{ $row->pilar }}</td>
                <td>{{ $row->tema }}</td>
                <td></td>
                <td></td>
                <td>
                  @foreach ($row->rows_1 as $i)
                      {{ $i->descripcion }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_2 as $i)
                      {{ $i->descripcion }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_3 as $i)
                      {{ $i->descripcion }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_4 as $i)
                      {{ $i->descripcion }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_1 as $i)
                      {{ $i->formula }}
                  @endforeach
                  @foreach ($row->rows_2 as $i)
                      {{ $i->formula }}
                  @endforeach
                  @foreach ($row->rows_3 as $i)
                      {{ $i->formula }}
                  @endforeach
                  @foreach ($row->rows_4 as $i)
                      {{ $i->formula }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_1 as $i)
                      {{ $i->frecuencia }}
                  @endforeach
                  @foreach ($row->rows_2 as $i)
                      {{ $i->frecuencia }}
                  @endforeach
                  @foreach ($row->rows_3 as $i)
                      {{ $i->frecuencia }}
                  @endforeach
                  @foreach ($row->rows_4 as $i)
                      {{ $i->frecuencia }}
                  @endforeach
                </td>
                <td></td>
                <td>
                  @foreach ($row->rows_1 as $i)
                      {{ $i->medios }}
                  @endforeach
                  @foreach ($row->rows_2 as $i)
                      {{ $i->medios }}
                  @endforeach
                  @foreach ($row->rows_3 as $i)
                      {{ $i->medios }}
                  @endforeach
                  @foreach ($row->rows_4 as $i)
                      {{ $i->medios }}
                  @endforeach
                </td>
                <td>
                  @foreach ($row->rows_1 as $i)
                      {{ $i->supuestos }}
                  @endforeach
                  @foreach ($row->rows_2 as $i)
                      {{ $i->supuestos }}
                  @endforeach
                  @foreach ($row->rows_3 as $i)
                      {{ $i->supuestos }}
                  @endforeach
                  @foreach ($row->rows_4 as $i)
                      {{ $i->supuestos }}
                  @endforeach
                </td>
              </tr>
      @endforeach 
      
    </tbody>
  
  </table>
  
  