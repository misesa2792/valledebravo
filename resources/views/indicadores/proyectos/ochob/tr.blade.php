<tr id="tr_{{ $time }}" class="bg-white">
    <td>
        <input type="hidden" class="form-control" name="idad[]" value="0">
        <input type="text" class="form-control no-borders form-control-ses" name="meta[]" placeholder="Ingresa Descripción" required>
    </td>
    <td>
        <input type="text" class="form-control no-borders form-control-ses" name="unidad_medida[]" placeholder="Ingresa medida" required>
    </td>
    <td>
        <select name="idtipo_operacion[]" class="form-control form-control-ses"  id="tipo_{{ $time }}" onchange="totalMeta({{ $time }})" required>
            <option value="">--Select please--</option>
            @foreach ($rowsOperacion as $v)
                <option value="{{ $v->id }}">{{ $v->tipo }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control c-yellow-meta no-borders text-center form-control-ses" name="trim1[]" id="trim1_{{ $time }}" placeholder="Trim. #1" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control c-green-meta no-borders text-center form-control-ses" name="trim2[]" id="trim2_{{ $time }}" placeholder="Trim. #2" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control c-blue-meta no-borders text-center form-control-ses" name="trim3[]" id="trim3_{{ $time }}" placeholder="Trim. #3" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control c-red-meta no-borders text-center form-control-ses" name="trim4[]" id="trim4_{{ $time }}" placeholder="Trim. #4" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center form-control-ses" name="anual[]" id="anual_{{ $time }}" placeholder="Total" readonly>
    </td>
    <td class="text-center">
        <i class="fa fa-trash-o c-danger cursor s-18 btndestroy" id="{{ $time }}"></i>
    </td>
</tr>
