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
        <th class="background">Pilar/Eje transversal</th>
        <th class="background">No. Pilar/Eje</th>
        <th class="background">Tema de Desarrollo</th>
        <th class="background">Dependencia General</th>
        <th class="background">Dependencia Auxiliar</th>
        <th class="background">Finalidad</th>
        <th class="background">Función</th>
        <th class="background">Subfunción</th>
        <th class="background">Programa</th>
        <th class="background">Subprograma</th>
        <th class="background">Proyecto</th>
        <th class="background">Objetivo</th>
        <th class="background">Nombre del Indicador</th>
        <th class="background">Tipo de Indicador</th>
        <th class="background">Fórmula de Cálculo</th>
        <th class="background">Interpretación</th>
        <th class="background">Dimensión</th>
        <th class="background">Factor de Comparación</th>
        <th class="background">Descripción del factor de comparación</th>
        <th class="background">Línea Base</th>
        <th class="background">Frecuencia</th>
        <th class="background">Variable</th>
        <th class="background">Unidad de Medida</th>
        <th class="background">Tipo de Operación</th>
        <th class="background">Trimestre 1</th>
        <th class="background">Trimestre 2</th>
        <th class="background">Trimestre 3</th>
        <th class="background">Trimestre 4</th>
        <th class="background">Meta Anual</th>
        <th class="background">Medio de Verificación</th>
      </tr>
    </thead>
  
    <tbody>
        @foreach (json_decode($rows) as $row)
          @foreach ($row->info as $key => $v)
            @if($key == 0)
              <tr>
                <td rowspan="{{ $row->total }}">{{ $row->tipo }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->pilares }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->temas_desarrollo }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_dep_gen.' '.$row->dep_gen }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_dep_aux.' '.$row->dep_aux }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_finalidad.' '.$row->finalidad }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_funcion.' '.$row->funcion }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_subfuncion.' '.$row->subfuncion }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_programa.' '.$row->programa }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_subprograma.' '.$row->subprograma }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->no_proyecto.' '.$row->proyecto }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->obj_proyecto }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->nombre_indicador }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->tipo_indicador }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->formula_calculo }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->interpretacion }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->dimencion }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->factor_comparacion }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->desc_factor }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->linea_base }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->frecuencia }}</td>
                <td>{{ $v->indicador }}</td>
                <td>{{ $v->unidad_medida }}</td>
                <td>{{ $v->tipo_operacion }}</td>
                <td>{{ $v->trim1 }}</td>
                <td>{{ $v->trim2 }}</td>
                <td>{{ $v->trim3 }}</td>
                <td>{{ $v->trim4 }}</td>
                <td>{{ $v->anual }}</td>
                <td rowspan="{{ $row->total }}">{{ $row->medios_verificacion }}</td>
              </tr>
            @else
              <tr>
                <td>{{ $v->indicador }}</td>
                <td>{{ $v->unidad_medida }}</td>
                <td>{{ $v->tipo_operacion }}</td>
                <td>{{ $v->trim1 }}</td>
                <td>{{ $v->trim2 }}</td>
                <td>{{ $v->trim3 }}</td>
                <td>{{ $v->trim4 }}</td>
                <td>{{ $v->anual }}</td>
              </tr>
            @endif
          @endforeach
      @endforeach 
      
    </tbody>
  
  </table>
  
  