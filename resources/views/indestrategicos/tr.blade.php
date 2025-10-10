<tr id="tr_{{ $time }}">
    <td class="no-borders">
        <input type="hidden" value="0" class="form-control c-text-alt no-borders" name="idreg[]" required>
        <input type="text" class="form-control c-text-alt no-borders" placeholder="Nombre corto" name="nombre_corto[]" required>
    </td>

    <td class="no-borders">
        <input type="text" class="form-control c-text-alt no-borders" placeholder="Nombre largo" name="nombre_largo[]"required>
    </td>

    <td class="text-center no-borders">
        <i class="fa fa-trash-o c-danger s-14 cursor btndestroy" id="{{ $time }}"></i>
    </td>
</tr>
