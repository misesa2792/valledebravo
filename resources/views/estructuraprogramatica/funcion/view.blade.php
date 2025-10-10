@if(count($rows) > 0)
    <table class="table table-bordered">
        <tr>
            <th width="30">#</th>
            <th>Clave</th>
            <th>Función</th>
            <th width="30">Acción</th>
        </tr>
        @foreach ($rows as $v)
            <tr>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h font-bold" style="color:var(--color-blue-meta);"></span></button>
                        <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                            <li><a href="#" class="btnagregar" id="{{ $v->id }}"><i class="fa fa-edit fun"></i> Editar</a></li>
                            <li><a href="#" class="btndestroy" id="{{ $v->id }}"> <i class="fa fa-trash-o var"></i> Eliminar</a></li>
                        </ul>
                    </div>
                </td>
                <td class="c-text-alt s-16">{{ $v->no_funcion }}</td>
                <td class="c-text-alt s-16">{{ $v->funcion }}</td>
                <td class="text-center">
                    <a  href="{{ URL::to('estructuraprogramatica/subfuncion?idfinalidad='.$idfinalidad.'&idfuncion='.$v->id) }}" class="btn btn-xs btn-white no-borders" title="Abrir Objetivo"> 
                        <i class="fa icon-arrow-right5 s-20" style="color:var(--color-blue-meta);"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

@else
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h2 class="text-center com">No se encontraron resultados!</h2>
    </div>
@endif