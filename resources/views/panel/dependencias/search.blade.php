@if($pagination->total() > 0)
  <table class="table table-hover table-bordered b-body table-ses">
      <thead>
        <tr class="t-tr-s12 c-text-alt">
              <th width="30">#</th>
              <th width="50">Estatus</th>
              <th>Municipio</th>
              <th>Institución</th>
              <th width="40"></th>
              <th>Dependencia General</th>
              <th width="40"></th>
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
              <td class="text-center">{{ $v['ndg'] }}</td>
              <td>{{ $v['dg'] }}</td>
              <th>
	              @if($access['is_add'] ==1)
                  <button type="button" name="button" class="btn btn-xs btn-ses btn-white btnagregar c-blue" id="{{ $v['id'] }}" data-idtd="{{ $v['idtd'] }}" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                @endif
              </th>
              <td>
                @if(count($v['rows']) > 0)
                  <table class="table table-striped border-gray no-margins table-ses">
                    @foreach($v['rows'] as $da)
                      <tr>
                        <td width="40" class="c-success">{{ $da->no_dep_aux_rel }}</td>
                        <td width="40">{{ $da->no_dep_aux }}</td>
                        <td>{{ $da->dep_aux }}</td>
                      </tr>
                    @endforeach
                  </table>
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
