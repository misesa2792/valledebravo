{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th width="50">Avatar</th>
            <th width="10"></th>
            <th>Nivel</th>
            <th>Institución</th>
            <th>Nombre completo</th>
            <th>Email</th>
            <th width="5"></th>
            <th>Accesos</th>
            <th width="30">Acción</th>
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
              <i class="fa fa-circle @if($v->active == 1) c-success @else c-danger @endif"></i>
            </td>
            <td class="c-text-alt">{{ $v->nivel }}</td>
            <td class="c-text-alt">{{ $v->institucion }}</td>
            <td class="c-text">{{ $v->name }}</td>
            <td class="c-text-alt">{{ $v->email }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-xs btn-white btnaccesos" id="{{ $v->id }}">
                <i class="fa fa-cogs c-blue"></i>
              </button>
            </td>
            <td>
              <ul>
                @foreach ($v->rowsAccess as $t)
                  <li class="c-text-alt">{{ $t->no_dep_gen.' '.$t->dep_gen }}</li>
                @endforeach
              </ul>
            </td>
            <td class="text-center">
              <a href="{{ URL::to('usuarios/vista?k='.$v->id_token) }}">
                <i class="fa icon-arrow-right5 s-18 tips c-blue"></i>
              </a>
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
