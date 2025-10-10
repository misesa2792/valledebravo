<tr id="tr_{{ $time }}" class="bg-white">
    <td>
        <input type="hidden" name="idrg[]" value="0">
        <input type="text" class="form-control no-borders" name="codigo[]" placeholder="#" readonly required>
    </td>
    <td>
        <input type="text" class="form-control no-borders" name="meta[]" placeholder="Meta" required>
    </td>
    <td>
        <button type="button" class="btn btn-xs btn-default btn-outline btn-ses btnagregarum" id="{{ $time }}"> <i class="fa fa-plus"></i> </button>
    </td>
    <td>
        <select name="um[]" id="sltum_{{$time}}" class="mySelectAc{{ $time }}" required>
            <option value="">--Unidad de medida--</option>
            @foreach($rowsUnidadMedida as $v)
                <option value="{{$v->um}}">{{$v->um}}</option>
            @endforeach
        </select>
         <script>
            $(".mySelectAc{{ $time }}").select2();
        </script>
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center" name="anual[]" id="anual_{{ $time }}" placeholder="Prog. Anual" required readonly>
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center" name="t1[]" id="t1_{{ $time }}" placeholder="Trim. #1" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center" name="t2[]" id="t2_{{ $time }}" placeholder="Trim. #2" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center" name="t3[]" id="t3_{{ $time }}" placeholder="Trim. #3" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control no-borders text-center" name="t4[]" id="t4_{{ $time }}" placeholder="Trim. #4" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-xs btn-white btndestroy" id="{{ $time }}"> <i class="fa fa-trash-o c-danger"></i> </button>
    </td>
</tr>
