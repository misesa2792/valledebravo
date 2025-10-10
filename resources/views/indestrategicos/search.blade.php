{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
 
<table class="table table-hover table-responsive">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th width="20">#</th>
            <th>Programa</th>
            <th>MIR</th>
            <th>Código</th>
            <th width="20"></th>
            <th>Indicador</th>
            <th width="20"></th>
            <th></th>
            <th width="30">Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($row as $key => $v)
        <tr class="t-tr-s12">
            <td class="c-text-alt text-center">{{ ++$j }}</td>
            <td class="c-text-alt">{{ $v->pro }}</td>
            <td class="c-text-alt">{{ $v->mir }}</td>
            <td class="c-text-alt">{{ $v->cod }}</td>
            <td class="text-center">
              @if($v->idrel == 1)
                <i class="fa fa-circle c-success full-width tips" title="Indicador relacionado correctamente"></i>
              @else 
                <i class="fa fa-circle c-danger full-width tips" title="El indicador no esta relacionado con la matriz"></i>
              @endif
            </td>
            <td class="c-text-alt">{{ $v->ind }}
              <br>
              <span class="{{ $v->ind == $v->rel_indicador ? 'c-success' : 'c-danger' }}">{{ $v->rel_indicador }}</span>
            </td>
            <td class="c-text-alt">{{ count($v->rows) }}</td>
            <td class="c-text-alt">
              <table class="table">
                @foreach ($v->rows as $s)
                  <tr>
                    <td width="200">{{ $s->nc }}</td>
                    <td>{{ $s->nl }}</td>
                  </tr>
                @endforeach
              </table>
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
