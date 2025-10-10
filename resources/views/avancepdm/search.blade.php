<div class="col-md-12">

  <table class="table table-hover bg-white">
    <tr>
      <td colspan="4" class="text-right">
        <a href="{{ URL::to($pageModule.'/pdf?idy='.$idy.'&t='.$trim) }}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="c-blue fa icon-file-pdf s-12"></i> Generar PDF</a>
      </td>
      @if($trim == 1)
        <td colspan="3" class="text-center c-white bg-yellow-meta">Trimestre #{{ $trim }}</td>
      @elseif($trim == 2)
        <td colspan="3" class="text-center c-white bg-green-meta">Trimestre #{{ $trim }}</td>
      @elseif($trim == 3)
        <td colspan="3" class="text-center c-white bg-blue-meta">Trimestre #{{ $trim }}</td>
      @elseif($trim == 4)
        <td colspan="3" class="text-center c-white bg-red-meta">Trimestre #{{ $trim }}</td>
      @endif
    </tr>
    <tr>
      <th>Pilar</th>
      <th>#</th>
      <th>No. Programa</th>
      <th>Programa</th>
      <th>Indicadores</th>
      <th>Metas</th>
      <th>Acción</th>
    </tr>
    @foreach ($rows as $v)
      <tr>
        <th colspan="7">{{ $v['pilar'] }}</th>
      </tr>
      @foreach ($v['info'] as $r)
        <tr>
          <td></td>
          <td>{{ $j++ }}</td>
          <td>{{ $r['no'] }}</td>
          <td>{{ $r['pro'] }}</td>
          <td>
            <ul style="margin-bottom:0px;">
              @foreach ($r['indicador'] as $v)
                  <li>{{ $v['text'] }}</li>
              @endforeach
            </ul>
          </td>
          <td>
            <ul style="margin-bottom:0px;">
              @foreach ($r['meta'] as $v)
                  <li>{{ $v['text'] }}</li>
              @endforeach
            </ul>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-xs btn-white btnprograma" id="{{ $r['idp'] }}" data-id="{{ $r['id'] }}" >
              <i class="fa fa-edit"></i>
            </button>
          </td>
        </tr>
      @endforeach
    @endforeach
  </table>

</div>
