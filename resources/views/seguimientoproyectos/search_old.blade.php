{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-bordered">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th rowspan="2"  width="20">#</th>
            <th rowspan="2">Año</th>
            <th rowspan="2"  width="20"></th>
            <th rowspan="2">Dependencia General</th>
            <th rowspan="2"  width="20"></th>
            <th rowspan="2">Dependencia Auxiliar</th>
            <th rowspan="2" width="60"></th>
            <th rowspan="2">Proyecto</th>
            <th rowspan="2">Presupuesto</th>
            <th rowspan="2">Transpaso Interno</th>
            <th colspan="2" class="text-center">Transpaso Externo</th>
            <th rowspan="2">Suficiencia Presupuestal</th>
            <th rowspan="2">Nómina</th>
            <th rowspan="2">Por Ejercer</th>
      </tr>
      <tr class="t-tr-s12 c-text-alt">
        <th>Disminución</th>
        <th>Aumento</th>
      </tr>

    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text text-center">{{ ++$j }}

              {{--*/ 
                $pres = $v->totales;
            /*--}}
            </td>
            <td class="c-text">{{ $v->anio }}</td>
            <td class="c-text">{{ $v->no_dep_gen }}</td>
            <td class="c-text">{{ $v->dep_gen }}</td>
            <td class="c-text">{{ $v->no_dep_aux }}</td>
            <td class="c-text">{{ $v->dep_aux }}</td>
            <td class="c-text">{{ $v->no_proyecto }}</td>
            <td class="c-text">{{ $v->proyecto }}</td>
            <td class="c-text text-right c-black">{{ $pres->presupuesto }}</td>
            <td class="c-text text-right c-text-alt">{{ $pres->tra_int }}</td>
            <td class="c-text text-right c-danger">{{ $pres->tra_ext_d }}</td>
            <td class="c-text text-right c-success">{{ $pres->tra_ext_a }}</td>
            <td class="c-text text-right c-danger">{{ $pres->suf_pres }}</td>
            <td class="c-text text-right c-danger">-</td>
            <td class="c-text text-right c-blue">{{ $pres->x_ejercer }}</td>
		</tr>
      @endforeach
    </tbody>
  </table>
<div class="col-md-12 no-padding" style="margin-bottom:70px;">
    @include('footermisesa')
</div>
<script>
	$(".tips").tooltip();
</script>
@else

<div class="col-md-12 m-t-lg">
    <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
    <h2 class="text-center com">No se encontraron Registros!</h2>
</div>

@endif
