<article class="col-sm-12 col-md-12 m-t-md no-padding">
    <table class="table table-bordered bg-white">
        <tr class="t-tr-s14">
            <th rowspan="2" class="c-text-alt" width="35%">Objetivo o resumen narrativo</th>
            <th colspan="3" class="c-text-alt text-center">Indicadores</th>
            <th rowspan="2" class="c-text-alt text-center">Medios de verificación</th>
            <th rowspan="2" class="c-text-alt text-center">Supuestos</th>
            <th rowspan="2" class="c-text-alt"></th>
        </tr>
        <tr class="t-tr-s14">
            <th class="c-text-alt">Nombre</th>
            <th class="c-text-alt">Fórmula</th>
            <th class="c-text-alt">Frecuencia y Tipo</th>
        </tr>
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Fin</th>
        </tr>
        @if(isset($rows[1]))
            @foreach ($rows[1] as $v)
                <tr class="bg-white" id="tr_{{ $v['id'] }}">
                    <td>
                        <input type="hidden" name="fin" value="{{ json_encode($v) }}">
                        {{ $v['descripcion'] }}
                    </td>
                    <td>{{ $v['nombre'] }}</td>
                    <td>{{ $v['formula'] }}</td>
                    <td>
                        <div>{{ $v['frecuencia'] }}</div>
                        <div>{{ $v['tipo_indicador'] }}</div>
                    </td>
                    <td>{{ $v['medios'] }}</td>
                    <td>{{ $v['supuestos'] }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Propósito</th>
        </tr>
        @if(isset($rows[2]))
            @foreach ($rows[2] as $v)
                <tr class="bg-white" id="tr_{{ $v['id'] }}">
                    <td>
                        <input type="hidden" name="proposito" value="{{ json_encode($v) }}">
                        {{ $v['descripcion'] }}
                    </td>
                    <td>{{ $v['nombre'] }}</td>
                    <td>{{ $v['formula'] }}</td>
                    <td>
                        <div>{{ $v['frecuencia'] }}</div>
                        <div>{{ $v['tipo_indicador'] }}</div>
                    </td>
                    <td>{{ $v['medios'] }}</td>
                    <td>{{ $v['supuestos'] }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Componentes</th>
        </tr>
        @if(isset($rows[3]))
            @foreach ($rows[3] as $v)
                <tr class="bg-white" id="tr_{{ $v['id'] }}">
                    <td>
                        <input type="hidden" name="componente[]" value="{{ json_encode($v) }}">
                        {{ $v['descripcion'] }}
                    </td>
                    <td>{{ $v['nombre'] }}</td>
                    <td>{{ $v['formula'] }}</td>
                    <td>
                        <div>{{ $v['frecuencia'] }}</div>
                        <div>{{ $v['tipo_indicador'] }}</div>
                    </td>
                    <td>{{ $v['medios'] }}</td>
                    <td>{{ $v['supuestos'] }}</td>
                    <td>
                        <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $v['id'] }}"></i>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Actividades</th>
        </tr>
        @if(isset($rows[4]))
            @foreach ($rows[4] as $v)
            <tr class="bg-white" id="tr_{{ $v['id'] }}">
                <td>
                    <input type="hidden" name="actividad[]" value="{{ json_encode($v) }}">
                    {{ $v['descripcion'] }}
                </td>
                <td>{{ $v['nombre'] }}</td>
                <td>{{ $v['formula'] }}</td>
                <td>
                    <div>{{ $v['frecuencia'] }}</div>
                    <div>{{ $v['tipo_indicador'] }}</div>
                </td>
                <td>{{ $v['medios'] }}</td>
                <td>{{ $v['supuestos'] }}</td>
                <td>
                    <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $v['id'] }}"></i>
                </td>
            </tr>
            @endforeach
        @endif
    </table>
</article>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>

