<tr id="tr_{{ $time }}">
    <td colspan="2" class="no-borders">
        <input type="hidden" class="form-control" name="ida[]" value="0">
        <select name="iddep_aux[]" class="mySelectAc{{ $time }} full-width" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsDepAux as $p)
                <option value="{{ $p->id }}">{{ $p->no_dep_aux.' '.$p->dep_aux }}</option>
            @endforeach
        </select>
    </td>
    <td colspan="2" class="no-borders">
        <select name="idproyecto[]" class="mySelectProy{{ $time }} full-width" required>
            <option value="">--Select Please--</option>
            @foreach ($rowsProyectos as $p)
                 <option value="{{ $p->id }}">{{ $p->no_proyecto.' '.$p->proyecto }}</option>
            @endforeach
        </select>
        <script>
            $(".mySelectProy{{ $time }}").select2();
            $(".mySelectAc{{ $time }}").select2();
        </script>
    </td>
    <td class="no-borders">
        <input type="text" class="form-control c-text-alt no-borders" placeholder="Presupuesto" name="pres[]" onKeyUp="sumarTab()" required>
    </td>
    <td class="text-center no-borders">
        <i class="fa fa-trash-o c-danger s-14 cursor btndestroy" id="{{ $time }}"></i>
    </td>
</tr>
