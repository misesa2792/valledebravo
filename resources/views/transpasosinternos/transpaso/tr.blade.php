<tr id="tr_{{ $time }}">
    <td class="bg-white s-14">{{ $clave_int }}</td>
   <td class="bg-white" width="10%">
        <input type="hidden" name="idr[]" value="0">
        <select name="d_ff[]" class="mySelect{{ $time }} full-width" required onchange="handleChangeNew(this, '{{ $time }}')">
            <option value="">--Select Please--</option>
            @foreach ($rowsFF as $v)
                <option value="{{ $v->id }}" data-texto="{{ $v->no_fuente.' '.$v->fuente }}">{{ $v->no_fuente.' '.$v->fuente }}</option>
            @endforeach
        </select>
   </td>
   <td class="bg-white" width="10%">
        <select name="d_partida[]" class="mySelect{{ $time }} full-width" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsPartidas as $v)
                <option value="{{ $v->id }}">{{ $v->no_partida.' '.$v->partida }}</option>
            @endforeach
        </select>
   </td>
   <td class="bg-white" width="5%">
        <select name="d_mes[]" class="form-control form-control-ses" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsMes as $r)
            <option value="{{ $r->idmes }}">{{ $r->mes }}</option>
            @endforeach
        </select>
   </td>
   <td class="bg-white">
    <input type="text" name="d_importe[]" class="form-control no-borders form-control-ses" placeholder="Importe" id="d_importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
   </td>

   <td class="no-borders"></td>
   
   <td class="bg-white s-14" >{{ $clave_ext }}</td>
   <td class="bg-white" width="10%" id="div_partida_{{ $time }}"></td>
   <td class="bg-white" width="10%">
        <select name="a_partida[]" class="mySelect{{ $time }} full-width" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsPartidas as $v)
                <option value="{{ $v->id }}">{{ $v->no_partida.' '.$v->partida }}</option>
            @endforeach
        </select>
   </td>
   <td class="bg-white" width="5%">
        <select name="a_mes[]" class="form-control form-control-ses" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsMes as $r)
            <option value="{{ $r->idmes }}">{{ $r->mes }}</option>
            @endforeach
        </select>
   </td>
   <td class="bg-white">
    <input type="text" name="a_importe[]" class="form-control no-borders form-control-ses" id="a_importe{{ $time }}" placeholder="Importe" readonly>
   </td>

   <td class="text-center no-borders">
        <script>
            $(".mySelect{{ $time }}").select2();
            function handleChangeNew(selectElement, time) {
                // Obtén el valor seleccionado
                const selectedValue = selectElement.value;

                // Obtén el texto del atributo `data-texto` del <option> seleccionado
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const dataTexto = selectedOption.getAttribute('data-texto');

                $("#div_partida_"+time).html(dataTexto);
            }
        </script>
        <i class="fa fa-trash-o c-danger cursor btndestroy s-16" id="{{ $time }}"></i>
    </td>
</tr>
