{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th>Clasificación</th>
            <th>Programa</th>
            <th>Caracteristicas generales</th>
            <th width="30">Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt text-center">{{ $v->p_cla }}</td>
            <td class="c-text-alt">{{ $v->p_pro }}</td>
            <td class="c-text-alt">{{ $v->p_gen }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-xs btn-white btnedit" id="{{ $v->id }}" idy="{{ $idy }}" ><i class="fa fa-edit c-blue"></i></button>
            </td>
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
