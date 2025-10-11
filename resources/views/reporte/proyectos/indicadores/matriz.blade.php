<div class="col-md-12">

    <h4>Matriz del Programa: <span class="c-blue">{{ $row->numero.' '.$row->descripcion }}</span></h4>

   <table class="table table-bordered bg-white">
        <tr>
            <th rowspan="2" width="100"></th>
            <th rowspan="2" width="30"><input type="checkbox" class="checkall"></th>
            <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
            <th colspan="4" class="text-center">Indicadores</th>
            <th rowspan="2"  class="text-center">Medios de verificación</th>
            <th rowspan="2"  class="text-center">Supuestos</th>
        </tr>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Fórmula</th>
            <th class="text-center">Frecuencia y Tipo</th>
        </tr>
        <tr>
            <td class="bg-white text-center-middle">Fin</td>
            <td><input type="checkbox" name="ids[]" class="ids" value="{{ $fin['row']->idprograma_reg }}"></td>
            <td>{{ $fin['row']->descripcion }}
            </td>
            <td class="text-center">{{ $fin['row']->mir }}</td>
            <td>{{ $fin['row']->nombre }}</td>
            <td>{{ $fin['row']->formula }}</td>
            <td class="text-center">
                <div>{{ $fin['row']->frecuencia }}</div>
                <div>{{ $fin['row']->tipo_indicador }}</div>
            </td>
            <td>{{ $fin['row']->medios }}</td>
            <td>{{ $fin['row']->supuestos }}</td>
        </tr>
        <tr>
            <td class="bg-white text-center-middle">Propósito</td>
            <td><input type="checkbox" name="ids[]" class="ids" value="{{ $proposito['row']->idprograma_reg }}"  ></td>
            <td>{{ $proposito['row']->descripcion }}
            </td>
            <td class="text-center">{{ $proposito['row']->mir }}</td>
            <td>{{ $proposito['row']->nombre }}</td>
            <td>{{ $proposito['row']->formula }}</td>
            <td class="text-center">
                <div>{{ $proposito['row']->frecuencia }}</div>
                <div>{{ $proposito['row']->tipo_indicador }}</div>
            </td>
            <td>{{ $proposito['row']->medios }}</td>
            <td>{{ $proposito['row']->supuestos }}</td>
        </tr>
        <tr>
            <td rowspan="{{ count($componente)+1 }}" class="text-center-middle">Componentes</td>
        </tr>
        @foreach($componente as $v)
            <tr>
            <td><input type="checkbox" name="ids[]" class="ids" value="{{ $v['row']->idprograma_reg }}"></td>
                <td>{{ $v['row']->descripcion }}
                </td>
                <td class="text-center">{{ $v['row']->mir }}</td>
                <td>{{ $v['row']->nombre }}</td>
                <td>{{ $v['row']->formula }}</td>
                <td class="text-center">
                    <div>{{ $v['row']->frecuencia }}</div>
                    <div>{{ $v['row']->tipo_indicador }}</div>
                </td>
                <td>{{ $v['row']->medios }}</td>
                <td>{{ $v['row']->supuestos }}</td>
            </tr>
        @endforeach
        <tr>
            <td rowspan="{{ count($actividad)+1 }}" class="text-center-middle">Actividades</td>
        </tr>
        @foreach($actividad as $v)
            <tr>
                <td><input type="checkbox" name="ids[]" class="ids" value="{{ $v['row']->idprograma_reg }}" ></td>
                <td>{{ $v['row']->descripcion }}
                </td>
                <td class="text-center">{{ $v['row']->mir }}</td>
                <td>{{ $v['row']->nombre }}</td>
                <td>{{ $v['row']->formula }}</td>
                <td class="text-center">
                    <div>{{ $v['row']->frecuencia }}</div>
                    <div>{{ $v['row']->tipo_indicador }}</div>
                </td>
                <td>{{ $v['row']->medios }}</td>
                <td>{{ $v['row']->supuestos }}</td>
            </tr>
        @endforeach
    </table>
</div>
<script>
    $(".checkall").click(function() {
		var cblist = $(".ids");
		if($(this).is(":checked"))
		{
			cblist.prop("checked", !cblist.is(":checked"));
		} else {
			cblist.removeAttr("checked");
		}
	});
</script>