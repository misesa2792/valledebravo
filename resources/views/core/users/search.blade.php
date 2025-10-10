{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-bordered table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th width="50">Avatar</th>
            <th width="50">Estatus</th>
            <th>Nivel</th>
            <th>Nombre completo</th>
            <th>Email</th>
            <th width="30"></th>
            <th>Institución</th>
            <th width="40">Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s14">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt">
              {!! SiteHelpers::avatarUser($v->id,40) !!}
            </td>
            <td class="c-text-alt text-center">
              <span class="badge @if($v->active == 1) badge-success @else badge-danger @endif full-width">{{ $v->active == 1 ? 'Activo' : 'Inactivo' }}</span>
            </td>
            <td class="c-text-alt">{{ $v->nivel }}</td>
            <td class="fun">{{ $v->name }}</td>
            <td class="c-text-alt">{{ $v->email }}</td>
            <td class="c-text-alt">{{ $v->no_institucion }}</td>
            <td class="c-text-alt">{{ $v->institucion }}</td>
            <td class="text-center">
              @if($access['is_edit'] ==1)
                  <button type="button" name="button" class="tips btn btn-xs btn-white btnagregar fun" id="{{ $v->id }}" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></button>
              @endif
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
    <h2 class="text-center com">No se encontraron registros!</h2>
</div>

@endif
