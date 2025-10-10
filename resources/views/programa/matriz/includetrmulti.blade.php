@if($tr_tmp == "ok")
    @foreach($tr_rows as $v)
        <tr class="bg-white" id="tr_{{ $v['id'] }}">
            <td>
                <input type="hidden" name="idprograma_reg{{ $tr_no }}[]" value="{{ $v['id'] }}">
                <textarea name="tipo{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll" required placeholder="{{ $tr_name }}" required>{{ $v['descripcion'] }}</textarea>
           
                <br>
                <div>
                    <select name="idrel{{ $tr_no }}[]" class="mySelect2 form-control-ses">
                        <option value="">--Select please--</option>
                        @foreach ($rowsComponent as $item)
                            <option value="{{ $item->id }}" @if($item->id == $v['idrel']) selected @endif>{{ $item->componente }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td><textarea name="nombre{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Nombre" required>{{ $v['nombre'] }}</textarea>
                <div>
                    <select name="idind{{ $tr_no }}[]" class="mySelect2 form-control-ses">
                        <option value="">--Select please--</option>
                        @foreach ($rowsIndEst as $item)
                            <option value="{{ $item->id }}" @if($item->id == $v['idindicador']) selected @endif>{{ $item->codigo.' '.$item->indicador }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td><textarea name="formula{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Fórmula" required>{{ $v['formula'] }}</textarea>
                <div>
                    <select name="idformula{{ $tr_no }}[]" class="mySelect2 form-control-ses">
                        <option value="">--Select please--</option>
                        @foreach ($rowsFormulas as $item)
                            <option value="{{ $item->id }}" @if($item->id == $v['idformula']) selected @endif>{{ $item->formula }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div>
                    <strong>Frecuencia</strong>
                    <select name="fi{{ $tr_no }}[]" class="form-control form-control-ses" required>
                        <option value="">--Select please--</option>
                        @foreach ($rows_frec_medicion as $item)
                            <option value="{{ $item->id }}" @if($item->id == $v['idf']) selected @endif>{{ $item->frec_medicion }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <strong>Tipo</strong>
                    <select name="ti{{ $tr_no }}[]" class="form-control form-control-ses" required>
                        <option value="">--Select please--</option>
                        @foreach ($rows_tipo_indicador as $item)
                            <option value="{{ $item->id }}" @if($item->id == $v['idt']) selected @endif>{{ $item->tipo_indicador }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td><textarea name="medios{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll" placeholder="Medios de verificación" required>{{ $v['medios'] }}</textarea></td>
            <td><textarea name="supuestos{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Supuestos" required>{{ $v['supuestos'] }}</textarea></td>
            <td>
                <i class="fa fa-trash-o c-danger s-18 cursor btndestroyprogreg" id="{{ $v['id'] }}"></i>
            </td>
        </tr>
    @endforeach
@else 
    <tr class="bg-white" id="tr_{{ $time }}">
        <td>
            <input type="hidden" name="idprograma_reg{{ $tr_no }}[]" value="0">
            <textarea name="tipo{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll" required placeholder="{{ $tr_name }}" required></textarea>
        </td>
        <td><textarea name="nombre{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Nombre" required></textarea></td>
        <td><textarea name="formula{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Fórmula" required></textarea></td>
        <td>
            <div>
                <strong>Frecuencia</strong>
                <select name="fi{{ $tr_no }}[]" class="form-control form-control-ses" required>
                    <option value="">--Select please--</option>
                    @foreach ($rows_frec_medicion as $item)
                        <option value="{{ $item->id }}">{{ $item->frec_medicion }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <strong>Tipo</strong>
                <select name="ti{{ $tr_no }}[]" class="form-control form-control-ses" required>
                    <option value="">--Select please--</option>
                    @foreach ($rows_tipo_indicador as $item)
                        <option value="{{ $item->id }}">{{ $item->tipo_indicador }}</option>
                    @endforeach
                </select>
            </div>
        </td>
        <td><textarea name="medios{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll" placeholder="Medios de verificación" required></textarea></td>
        <td><textarea name="supuestos{{ $tr_no }}[]" rows="4" class="form-control no-borders scroll"  placeholder="Supuestos" required></textarea></td>
        <td>
         <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $time }}"></i>
        </td>
    </tr>
@endif