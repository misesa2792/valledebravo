

@if(count($rowRegistros) > 0)
 
<table class="table table-hover table-bordered">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th rowspan="2">Dependencia General</th>
            <th rowspan="2">Dependencia Auxiliar</th>
            <th rowspan="2">No. Proyecto</th>
            <th rowspan="2">Proyecto</th>
            <th rowspan="2" width="10"></th>
            <th rowspan="2">Presupuesto</th>
            <th rowspan="2">Transpaso Interno</th>
            <th colspan="2" class="text-center">Transpaso Externo</th>
            <th rowspan="2">Suficiencia Presupuestal</th>
            <th rowspan="2">Por Ejercer</th>
      </tr>
      <tr class="t-tr-s12 c-text-alt">
        <th>Disminución</th>
        <th>Aumento</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rowRegistros as $keys => $v)
        <tr class="t-tr-s14">
            <td rowspan="{{ count($v['rows']) + 1}}">
              {{ $v['no_dep_gen'] }} {{ $v['dep_gen'] }}
            </td>
		    </tr>
        @foreach ($v['rows'] as $d)
            <tr>
              <td>{{ $d['no_dep_aux'].' '.$d['dep_aux'] }}</td>
              <td>{{ $d['no_proyecto'] }}</td>
              <td>{{ $d['proyecto'] }}</td>
              <td class="text-right c-black">$</td>
              <td>{{ $d['importe'] }}</td>
            </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

<script>
	$(".tips").tooltip();
</script>
@else

<div class="col-md-12 m-t-lg">
    <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
    <h2 class="text-center com">No se encontraron Registros!</h2>
</div>

@endif
