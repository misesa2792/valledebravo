<tr id="tr_{{ $time }}" class="bg-white btnmostrar">
    <td>
        <input type="text" class="form-control no-borders text-center" name="numero[]" placeholder="#" readonly required>
    </td>
    <td width="60%">
        <input type="hidden" class="form-control" name="idag[]" value="0">
        <div class="col-md-10 no-padding">
            <input type="text" class="form-control no-borders" name="meta[]" placeholder="Ingresa descripción de la meta" onkeyup="validarMetaCaracteres(this, {{ $time }})" required>
        </div>
        <div class="col-md-2 text-right">
             <small id="contador_{{ $time }}" class="text-muted"></small>
        </div>
    </td>
    <td width="40" class="text-center">
        <button type="button" class="btn btn-xs btn-default btn-outline btn-ses btnagregarum d-none btnhover" id="{{ $time }}"> <i class="fa fa-plus"></i> </button>
    </td>
    <td>
        <select name="medida[]" id="sltum_{{$time}}" class="mySelectAc{{ $time }}" required>
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
        <input type="text" class="form-control c-green-meta no-borders" name="programado[]" id="programado_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control c-green-meta no-borders" name="alcanzado[]" id="alcanzado_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td>
        <input type="text" class="form-control c-blue-meta no-borders" name="anual[]" id="anual_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
    </td>
    <td width="80">
        <input type="text" class="form-control c-green-meta no-borders" name="absoluta[]" id="absoluta_{{ $time }}" placeholder="0" readonly required>
    </td>
    <td width="80">
        <input type="text" class="form-control c-red-meta no-borders" name="porcentaje[]" id="porcentaje_{{ $time }}" placeholder="%" readonly required>
    </td>
    <td class="text-center">
       <i class="fa fa-trash-o c-danger s-14 cursor btndestroy d-none btnhover" id="{{ $time }}"></i>
    </td>
</tr>
