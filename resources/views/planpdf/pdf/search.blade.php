{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th width="50">Estatus</th>
            <th>Institución</th>
            <th width="20"></th>
            <th>PDF</th>
            <th>Tamaño</th>
            <th>URL</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt text-center">
              <i class="fa fa-circle @if($v->std == 1) c-success @else c-danger @endif full-width"></i>
            </td>
            <td class="c-text-alt">{{ $v->no_ins.' '.$v->ins }}</td>
            <td>
              <a href="{{ URL::to('download/pdf?number='.$v->number) }}" target="_blank"><i class="c-danger fa icon-file-pdf s-12"></i></a>
            </td>
            <td class="c-text-alt">{{ $v->number }}</td>
            <td class="c-text-alt">{{ $v->size }}</td>
            <td class="c-text-alt">{{ $v->url }}</td>
            <td class="c-text-alt">{{ $v->user }}</td>
            <td class="c-text-alt">{{ $v->fecha }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-xs btn-white btndelpdf" id="{{ $v->id }}"><i class="fa fa-trash-o c-danger"></i></button>
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
