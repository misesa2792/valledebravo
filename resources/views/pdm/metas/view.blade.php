@if(count($rows) > 0)
    <table class="table table-bordered">
        <tr>
            <th width="30">#</th>
            <th>Clave</th>
            <th>Meta</th>
        </tr>
        @foreach ($rows as $v)
            <tr>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h" ></span></button>
                        <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                            <li><a href="#" class="btnedit" id="{{ $v->id }}"><i class="fa fa-edit fun"></i> Editar</a></li>
                            <li><a href="#" class="btndestroy" id="{{ $v->id }}"> <i class="fa fa-trash-o var"></i> Eliminar</a></li>
                        </ul>
                    </div>
                </td>
                <td class="c-text-alt s-16">{{ $v->clave }}</td>
                <td class="c-text-alt s-16">{{ $v->meta }}</td>
            </tr>
        @endforeach
    </table>

@else
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h2 class="text-center com">No se encontraron metas!</h2>
    </div>
@endif