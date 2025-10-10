@if($num == 1)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td>
            <input type="hidden" name="idfoda1[]">
            <textarea name="foda1[]" rows="3" class="form-control" placeholder="Fortaleza"></textarea>
        </td>
        <td width="10" class="text-center">
            <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 2)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td>
            <input type="hidden" name="idfoda2[]">
            <textarea name="foda2[]" rows="3" class="form-control" placeholder="Oportunidad"></textarea>
        </td>
        <td width="10" class="text-center">
            <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 3)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td>
            <input type="hidden" name="idfoda3[]">
            <textarea name="foda3[]" rows="3" class="form-control" placeholder="Debilidad"></textarea>
        </td>
        <td width="10" class="text-center">
            <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 4)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td>
            <input type="hidden" name="idfoda4[]">
            <textarea name="foda4[]" rows="3" class="form-control" placeholder="Amenaza"></textarea>
        </td>
        <td width="10" class="text-center">
            <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@endif