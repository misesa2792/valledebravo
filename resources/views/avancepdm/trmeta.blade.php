    <tr id="tr_{{ $time }}">
        <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td width="90%">
            <input type="hidden" name="idmeta[]" value="0">
            <textarea name="meta[]" rows="3" class="form-control" placeholder="Descripción"></textarea>
        </td>
        <td width="10" class="text-center">
            <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
