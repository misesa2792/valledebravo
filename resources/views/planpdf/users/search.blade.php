{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th>Nivel</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Fecha</th>
            <th>Activo</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt">{{ $v->nivel }}</td>
            <td class="c-text-alt">{{ $v->usuario }}</td>
            <td class="c-text-alt">{{ $v->email }}</td>
            <td class="c-text-alt">{{ $v->fecha }}</td>
            <td class="c-text-alt">{{ $v->minutos }}</td>
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
