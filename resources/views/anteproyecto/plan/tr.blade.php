<tr id="tr_{{ $time }}" class="bg-white">
    <td>
        <input type="text" class="form-control no-borders" style="background: transparent;" name="numero[]" placeholder="#" readonly required>
    </td>
    <td>
        <input type="hidden" class="form-control" name="idag[]" value="0">
        <input type="text" class="form-control no-borders" style="background: transparent;" name="meta[]" placeholder="Ingresa Meta por Actividad" required>
    </td>
    <td>
        <input type="text" class="form-control no-borders" style="background: transparent;" name="medida[]" placeholder="Ingresa Medida" required>
    </td>
    <td>
        <input type="text" class="form-control fun no-borders" id="presupuesto_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="Programado" name="programado[]" required readonly>
    </td>
    <td>
        <input type="text" class="form-control fun no-borders" id="total1_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total1[]" onKeyUp="totalMeta({{ $time }})" required>
    </td>
    <td>
        <input type="text" class="form-control fun no-borders" id="total2_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total2[]" onKeyUp="totalMeta({{ $time }})" required>
    </td>
    <td>
        <input type="text" class="form-control fun no-borders" id="total3_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total3[]" onKeyUp="totalMeta({{ $time }})" required>
    </td>

    <td class="text-center">
        <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
    </td>
</tr>
