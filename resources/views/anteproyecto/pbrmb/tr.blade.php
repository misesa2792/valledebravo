@if($num == 1)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <textarea name="foda[1][]" id="foda1" rows="1" class="form-control no-borders" placeholder="Fortaleza"></textarea>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 2)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <textarea name="foda[2][]" id="foda2" rows="1" class="form-control no-borders" placeholder="Oportunidad"></textarea>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 3)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <textarea name="foda[3][]" id="foda3" rows="1" class="form-control no-borders" placeholder="Debilidad"></textarea>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 4)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <textarea name="foda[4][]" id="foda4" rows="1" class="form-control no-borders" placeholder="Amenaza"></textarea>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 5)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <textarea name="estrategias[]" rows="1" class="form-control no-borders" placeholder="Estrategias para alcanzar el objetivo del Programa presupuestario"></textarea>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 6)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <select name="idlinea_accion[]" class="mySelectProy{{ $time }} full-width" required>
                <option value="">--Select Please--</option>
                @foreach ($rowsPDM as $v)
                    <option value="{{ $v->id }}">{{ $v->no_linea_accion.' '.$v->linea_accion }}</option>
                @endforeach
            </select>
            <script>
                $(".mySelectProy{{ $time }}").select2();
            </script>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@elseif($num == 7)
    <tr id="tr_{{ $time }}">
        <td width="10" class="text-center no-borders"><i class="fa fa-circle c-text-alt s-10"></i></td>
        <td class="no-borders">
            <select name="idods[]" class="mySelectProy{{ $time }} full-width" required>
                <option value="">--Select Please--</option>
                @foreach ($rowsODS as $v)
                    <option value="{{ $v->id }}">{{ $v->meta }}</option>
                @endforeach
            </select>
            <script>
                $(".mySelectProy{{ $time }}").select2();
            </script>
        </td>
        <td width="10" class="text-center no-borders">
            <i class="fa fa-trash-o var s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@endif