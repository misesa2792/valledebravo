{{--*/ $info = json_decode($rows_metas); /*--}}
@if(count($info) > 0)
    <div class="col-sm-12 col-md-12 col-lg-12">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16">
                <th class="text-center">#</th>
                <th width="30"></th>
                <th>Institución</th>
                <th>Alineación</th>
                <th>Meta</th>
                <th>Unidad Medida</th>
                <th>Dependencia General</th>
                <th>Depencia Auxiliar</th>
            </tr>
            @foreach ($info as $m)
                <tr class="t-tr-s16">
                    <td class="text-center">
                        <input type="checkbox" name="idreg[]" value="{{ $m->id }}">
                    </td>
                    <td class="text-center">
                        <img src="{{ asset('images/icons/'.$m->logo) }}" width="25" height="25">
                    </td>
                    <td>{{ $m->institucion }}</td>
                    <td>
                        <table class="table table-bordered">
                            @foreach ($m->rows as $item)
                                <tr class="t-tr-s16">
                                    <td><label class="badge badge-success">Alineado</label></td>
                                    <td>{{ $item->clave }}</td>
                                    <td>{{ $item->linea_accion }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>{{ $m->meta }}</td>
                    <td>{{ $m->unidad_medida }}</td>
                    <td>{{ $m->coordinacion }}</td>
                    <td>{{ $m->area }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@else
    <div class="col-sm-12 col-md-12 col-lg-12 m-t-lg m-b-lg">
        <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-30"></i> </h1>
        <h2 class="text-center com">No se encontraron metas!</h2>
    </div>
@endif