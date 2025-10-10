@if($pagination->total() > 0)
  <table class="table table-hover table-bordered b-body table-ses">
      <thead>
        <tr class="t-tr-s12 c-text-alt">
              <th width="30">#</th>
              <th width="50">Estatus</th>
              <th>Municipio</th>
              <th>Institución</th>
              <th width="40"></th>
              <th width="40"></th>
              <th>Dependencia General</th>
              <th>Titular</th>
              <th>Cargo</th>
              <th width="80">Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pagination->items() as $v)
          <tr class="t-tr-s12 c-text-alt">
              <td class="text-center">{{ ++$j }}</td>
              <td>
                @if($v['std'] == 1)
                  <span class="badge badge-success full-width">Activo</span>
                @else
                  <span class="badge badge-danger full-width">Inactivo</span>
                @endif
              </td>
              <td>{{ $v['mun'] }}</td>
              <td>{{ $v['noi'].' '.$v['abr'] }}</td>
              <td class="text-center c-success">{{ $v['ndgr'] }}</td>
              <td class="text-center">{{ $v['ndg'] }}</td>
              <td>{{ $v['dg'] }}</td>
              <td class="fun">{{ $v['tl'] }}</td>
              <td>{{ $v['cg'] }}</td>
              <td class="text-center">
                @if($access['is_edit'] ==1)
                  <button type="button" name="button" class="btn btn-xs btn-ses btn-white btneditar fun" id="{{ $v['id'] }}" data-idtd="{{ $v['idtd'] }}"><i class="fa fa-edit "></i></button>
                @endif
                  @if($access['is_remove'] ==1)
                  <button type="button" name="button" class="btn btn-xs btn-ses btn-white btneliminar c-danger" id="{{ $v['id'] }}"><i class="fa fa-trash-o"></i></button>
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
