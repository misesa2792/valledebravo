<tr id="tr_{{ $time }}">
    
    <td>
        <select name="idla[]" class="mySelect{{$time}} full-width" required>
            <option value="">--Selecciona línea de acción--</option>
            @foreach($rowsPDM as $l)
                <option value="{{ $l->id }}">{{ $l->no_linea_accion.' '.$l->linea_accion }}</option>
            @endforeach
        </select>

        <script>
        $(".mySelect{{$time}}").select2();
        </script>
    </td>

    <td class="text-center">
        <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
    </td>
</tr>
