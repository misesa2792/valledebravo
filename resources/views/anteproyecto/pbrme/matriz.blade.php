<table class="table table-bordered bg-white">
    <tr class="t-tr-s14">
        <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
        <th colspan="3" class="text-center">Indicadores</th>
        <th rowspan="2"  class="text-center">Medios de verificación</th>
        <th rowspan="2"  class="text-center">Supuestos</th>
    </tr>
    <tr class="t-tr-s14">
        <th class="text-center">Nombre</th>
        <th class="text-center">Fórmula</th>
        <th class="text-center">Frecuencia y Tipo</th>
    </tr>
    <tr>
        <th colspan="7" class="bg-gray">Fin</th>
    </tr>
    <tr>
        <td>
            <input type="radio" name="fin" value="{{$rows['fin']->idprograma_reg}}" checked required>
            {{ $rows['fin']->descripcion }}</td>
        <td>{{ $rows['fin']->nombre }}
            <br>
            <div><strong>{{ $rows['fin']->codigo }}</strong></div>
            <div><i>{{ $rows['fin']->nombre }}</i></div>
        </td>
        <td>{{ $rows['fin']->formula }}</td>
        <td>
            <div class="font-bold">Frecuencia</div>
            {{ $rows['fin']->frecuencia }}
            <div class="font-bold">Tipo</div>
            {{ $rows['fin']->tipo_indicador }}
        </td>
        <td>{{ $rows['fin']->medios }}</td>
        <td>{{ $rows['fin']->supuestos }}</td>
    </tr>

    <tr class="t-tr-s14">
        <th colspan="7" class="bg-gray">Propósito</th>
    </tr>

    <tr>
        <td>
            <input type="radio" name="proposito" value="{{$rows['proposito']->idprograma_reg}}" checked required>
            {{ $rows['proposito']->descripcion }}</td>
        <td>{{ $rows['proposito']->nombre }}
            <br>
            <div><strong>{{ $rows['proposito']->codigo }}</strong></div>
            <div><i>{{ $rows['proposito']->nombre }}</i></div>
        </td>
        <td>{{ $rows['proposito']->formula }}</td>
        <td>
            <div class="font-bold">Frecuencia</div>
            {{ $rows['proposito']->frecuencia }}
            <div class="font-bold">Tipo</div>
            {{ $rows['proposito']->tipo_indicador }}
        </td>
        <td>{{ $rows['proposito']->medios }}</td>
        <td>{{ $rows['proposito']->supuestos }}</td>
    </tr>

    <tr class="t-tr-s14">
        <th colspan="7" class="bg-gray">Componentes</th>
    </tr>
    @foreach($rows['componente'] as $c)
        <tr>
            <td>
                <input type="checkbox" name="componentes[]" value="{{$c->idprograma_reg}}">
                {{ $c->descripcion }}</td>
            <td>{{ $c->nombre }}
                <br>
                <div><strong>{{ $c->codigo }}</strong></div>
                <div><i>{{ $c->nombre }}</i></div>
            </td>
            <td>{{ $c->formula }}</td>
            <td>
                <div class="font-bold">Frecuencia</div>
                {{ $c->frecuencia }}
                <div class="font-bold">Tipo</div>
                {{ $c->tipo_indicador }}
            </td>
            <td>{{ $c->medios }}</td>
            <td>{{ $c->supuestos }}</td>
        </tr>
    @endforeach

    <tr class="t-tr-s14">
        <th colspan="7" class="bg-gray">Actividades</th>
    </tr>

    @foreach($rows['actividad'] as $c)
        <tr>
            <td>
                <input type="checkbox" name="actividades[]" value="{{$c->idprograma_reg}}">
                {{ $c->descripcion }}</td>
            <td>{{ $c->nombre }}
                <br>
                <div><strong>{{ $c->codigo }}</strong></div>
                <div><i>{{ $c->nombre }}</i></div>
            </td>
            <td>{{ $c->formula }}</td>
            <td>
                <div class="font-bold">Frecuencia</div>
                {{ $c->frecuencia }}
                <div class="font-bold">Tipo</div>
                {{ $c->tipo_indicador }}
            </td>
            <td>{{ $c->medios }}</td>
            <td>{{ $c->supuestos }}</td>
        </tr>
    @endforeach
</table>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar </button>
    </article>