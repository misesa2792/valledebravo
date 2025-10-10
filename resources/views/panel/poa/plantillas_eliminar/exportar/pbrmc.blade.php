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
            PROYECTO 
            (12 dígitos)
        </th>
        <th class="background">DEPENDENCIA (Dep. gral y aux.) (6 dígitos)</th>
        <th class="background">CLAVE ACCIÓN</th>
        <th class="background">CONCEPTO</th>
        <th class="background">UNIDAD DE MEDIDA</th>
        <th class="background">PORCENTAJE POBLACIÓN BENEFICIADA</th>
        <th class="background">PROGRAMADO AÑO ANTERIOR</th>
        <th class="background">REAL AÑO ANTERIOR</th>
        <th class="background">TRIMESTRE 1</th>
        <th class="background">TRIMESTRE 2</th>
        <th class="background">TRIMESTRE 3</th>
        <th class="background">TRIMESTRE 4</th>
        <th class="background">LOCALIDADES BENEFICIADAS (claves segun catalogo)</th>
      </tr>
    </thead>
  
    <tbody>
        @foreach (json_decode($rows) as $row)
        <tr>
          <td>'{{ $row->no_proyecto }}</td>
          <td>{{ $row->no_dep_gen.$row->no_dep_aux }}</td>
          <td>{{ $row->clave_accion }}</td>
          <td>{{ $row->concepto }}</td>
          <td>{{ $row->unidad_medida }}</td>
          <td>0</td>
          <td>{{ $row->programado }}</td>
          <td>{{ $row->alcanzado }}</td>
          <td>{{ $row->aa_trim1 }}</td>
          <td>{{ $row->aa_trim2 }}</td>
          <td>{{ $row->aa_trim3 }}</td>
          <td>{{ $row->aa_trim4 }}</td>
          <td>100</td>
        </tr>
      @endforeach 
      
    </tbody>
  
  </table>
  
  