 <div class="col-md-12 m-t-md no-padding">
  <table class="table table-bordered no-margins bg-white">
    <thead>
      <tr class="t-tr-s12 c-text-alt">
            <th>Institución</th>
            <th>Dependencia General</th>
            <th>Dependencia Auxiliar</th>
            <th>Proyecto</th>
            <th>Alinear Meta PbRM</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pagination->items() as $v)
        <tr class="c-text-alt">
          <td>
            <div><strong>{{ $v['no_ins'] }}</strong></div>
            <i>{{ $v['ins'] }}</i>
          </td>
          <td>
            <div><strong>{{ $v['no_dep_gen'] }}</strong></div>
            <i>{{ $v['dep_gen'] }}</i>
          </td>
          <td>
            <div><strong>{{ $v['no_dep_aux'] }}</strong></div>
            <i>{{ $v['dep_aux'] }}</i>
          </td>
          <td>
            <div><strong>{{ $v['no_proyecto'] }}</strong></div>
            <i>{{ $v['proyecto'] }}</i>
          </td>
          <td width="50%">
            <table class="table no-margins">
              @foreach($v['metas'] as $m)
                <tr>
                  <td class="no-borders" width="30">
                    <input type="radio" name="idrg" value="{{ $m['id'] }}">
                  </td>
                  <td class="no-borders" width="5%">{{ $m['no'] }}</td>
                  <td class="no-borders" width="15%">{{ $m['um'] }}</td>
                  <td class="no-borders">{{ $m['meta'] }}</td>
                </tr>
              @endforeach
            </table>
          </td>
        </tr>
      @endforeach 
    </tbody>
  </table>
 </div>
<div class="col-md-12 no-padding">
    @include('footermisesa')
</div>
