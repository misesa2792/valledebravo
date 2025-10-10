@if($pagination->total() > 0)
 
<table class="table table-hover table-bordered b-body table-ses">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="30">#</th>
            <th width="100">Institución</th>
            <th width="100">Denominación</th>
            <th>Dependencia General</th>
            <th colspan="2">Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pagination->items() as $v)
        <tr class="t-tr-s14 c-text-alt">
            <td class="text-center">{{ ++$j }}</td>
            <td>{{ $v['ab'] }}</td>
            <td class="text-center">{{ $v['ndg'] }}</td>
            <td>{{ $v['dg'] }}</td>
            <td class="text-center" width="40">
              @if($access['is_edit'] ==1)
                <button type="button" name="button" class="tips btn btn-xs btn-white btnagregar fun" id="{{ $v['id'] }}" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></button>
              @endif
            </td>
            <td class="text-center" width="40">
              @if($access['is_remove'] ==1)
                <button type="button" name="button" class="tips btn btn-xs btn-white btneliminar c-danger" id="{{ $v['id'] }}"><i class="fa fa-trash-o"></i></button>
              @endif
            </td>
		    </tr>
      @endforeach
    </tbody>
  </table>

  <div class="col-md-12 no-padding">
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
