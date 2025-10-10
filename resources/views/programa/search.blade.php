{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th width="50">Estatus</th>
            <th>No. Subfuncion</th>
            <th>No. Programa</th>
            <th width="140">Matriz</th>
            <th>Programa</th>
            <th>Objetivo</th>
            <th>Pilar</th>
            <th>Tema Desarrollo</th>
            <th width="30">Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s12">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt text-center">
              <span class="badge @if($v->estatus == 1) badge-success @else badge-danger @endif full-width">{{ $v->estatus == 1 ? 'Activo' : 'Inactivo' }}</span>
            </td>
            <td class="c-text-alt">{{ $v->no_subfuncion }}</td>
            <td class="c-text-alt">{{ $v->no_programa }}</td>
            <td class="text-center">
              <table class="table no-margins">
                @foreach($v->dataMatriz as $m)
                  <tr>
                    <td class="no-borders">Matriz #{{ $m->no_matriz }} </td>
                    <td class="no-borders">
                        <i class="fa fa-comment cursor btnmatriz {{ $m->total == 0 ? 'c-danger' : 'c-blue' }}"  id="{{ $v->id }}" idy="{{ $idy }}" no="{{ $m->no_matriz }}"></i>
                    </td>
                  </tr>
                @endforeach
              </table>
            </td>
            <td class="c-text-alt">{{ $v->programa }}</td>
            <td class="c-text-alt">{{ $v->objetivo }}</td>
            <td class="c-text-alt">{{ $v->pilar }}</td>
            <td class="c-text-alt">{{ $v->tema }}
              <div><span class="badge badge-primary">{{ $v->no_tema.' '.$v->tema_des }}</span></div>
            </td>
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
