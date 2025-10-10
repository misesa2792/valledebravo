{{-- */ 
    $row = json_decode($rows);
/* --}}

@if (count($row) > 0)

    <table class="table table-hover table-responsive">
        <thead>
            <tr class="c-text-alt">
                <th width="20">#</th>
                <th width="10"></th>
                <th width="10"></th>
                <th>Nivel</th>
                <th>Institución</th>
                <th>Nombre completo</th>
                <th>Email</th>
                <th>Accesos</th>
                <th width="70"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row as $key => $v)
                <tr>
                    <td class="c-text-alt text-center">{{ ++$j }}</td>
                    <td>
                      <div class="btn-group">
                          <button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                          <ul class="dropdown-menu text-left overflow-h" role="menu"
                              style="z-index: 9">
                              <li><a href="#" class="btneditar" id="{{ $v->id }}"><i class="fa fa-edit fun "></i> Editar usuario</a></li>
                              <li><a href="#" class="btnestatus" id="{{ $v->id }}"><i class="fa fa-random var"></i> Cambiar estatus</a></li>
                          </ul>
                      </div>
                    </td>
                    <td class="c-text-alt text-center">
                        <i class="fa fa-circle @if ($v->active == 1) c-success @else c-danger @endif"></i>
                    </td>
                    <td class="c-text-alt">{{ $v->nivel }}</td>
                    <td class="c-text-alt">{{ $v->institucion }}</td>
                    <td class="c-text">{{ $v->name }}</td>
                    <td class="c-text-alt">{{ $v->email }}</td>
                    <td>
                        <table class="table no-margins">
                            @foreach ($v->rowsAccess as $t)
                                <tr>
                                    <td width="30">
                                        <div class="btn-group">
                                            <button type="button"
                                                class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5"
                                                data-toggle="dropdown"><span
                                                    class="fa fa-ellipsis-h c-text"></span></button>
                                            <ul class="dropdown-menu text-left overflow-h" role="menu"
                                                style="z-index: 9">
                                                <li><a href="#" class="btnpermisosaux" id="{{ $t->id }}"
                                                        data-da="{{ $t->no_dep_gen }}"><i class="fa fa-cogs fun "></i>
                                                        Agregar Permiso</a></li>
                                                <li><a href="#" class="btndeleteaux" id="{{ $t->id }}"><i
                                                            class="fa fa-trash-o var"></i> Eliminar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <strong class="c-black">{{ $t->no_dep_gen . ' ' . $t->dep_gen }}</strong>
                                        <div>
                                            @if (count($t->dep_aux) > 0)
                                                <ul>
                                                    @foreach ($t->dep_aux as $da)
                                                        <li class="c-text">{{ $da->numero . ' ' . $da->descripcion }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="c-danger">
                                                    <i class="fa fa-eye"></i> El usuario tiene acceso de visualización a
                                                    todas las dependencias auxiliares.
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-white btnaccesos b-r-5 tips" title="Asignar permiso para visualizar dependencias generales" id="{{ $v->id }}">
                            <i class="fa fa-unlock-alt c-blue"></i> Permisos
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-md-12 no-padding" style="margin-bottom:70px;">
        @include('footermisesa')
    </div>
    <script>
        $(".tips").tooltip();
    </script>
@else
    <div class="col-md-12 m-t-lg">
        <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
        <h2 class="text-center com">No se encontraron Registros!</h2>
    </div>

@endif
