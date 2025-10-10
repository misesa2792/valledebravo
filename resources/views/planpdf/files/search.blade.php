{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th width="20"></th>
            <th>Nombre</th>
            <th>URL</th>
            <th>Size</th>
            <th>Usuario</th>
            <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td>
               <a href="{{ URL::to($v->url) }}" target="_blank"><i class="c-blue fa fa-download s-12"></i></a>
            </td>
            <td class="c-text-alt">{{ $v->nombre }}</td>
            <td class="c-text-alt">{{ $v->url }}</td>
            <td class="c-text-alt">{{ $v->size }}</td>
            <td class="c-text-alt">{{ $v->usuario }}</td>
            <td class="c-text-alt">{{ $v->fecha }}</td>
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
