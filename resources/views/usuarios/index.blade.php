@extends('layouts.app')

@section('content')
    <main class="page-content row bg-body">

        <section class="page-header bg-body">
            <div class="page-title">
                <h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Enlaces</i></small></h3>
            </div>

            <ul class="breadcrumb bg-body">
                <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
                <li class="active"><i>Enlaces</i></li>
            </ul>
        </section>

        <article class="col-md-12 m-t-md">
            <section class="page-content-wrapper no-padding">
                <div class="sbox animated fadeInRight ">
                    <div class="sbox-title border-t-yellow">
                        <h4 class="col-md-8"> Usuarios</h4>
                        <div class="col-md-4 text-right">
                            @if(Auth::user()->id == 1)
                                <a href="#" class="tips btn btn-xs b-r-30 btn-ses btn-success btnedit"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                            @endif
                        </div>
                    </div>
                    <div class="sbox-content bg-white" style="min-height:300px;">

                        <div id="block-filtros" class="table-resp">
                            <form enctype="multipart/form-data" id="searchgnal" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="hidden" name="idtd" value="{{ $idtd }}">
                                <div class="col-md-12 no-padding">

                                    <table class="table no-margins bg-white">
                                        <tbody>
                                            <tr>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Estatus</div>
                                                    <select name="active" class="form-control">
                                                        <option value="">--Select Please--</option>
                                                        <option value="1" selected>Activo</option>
                                                        <option value="5">Inactivo</option>
                                                    </select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Nivel</div>
                                                    <select name="group_id" class="form-control">
                                                        <option value="">--Select Please--</option>
                                                        @foreach ($rowsNivel as $v)
                                                            <option value="{{ $v->id }}">{{ $v->nivel }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Nombre</div>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Ingresa nombre a buscar">
                                                    <input type="hidden" name="page" value="1" id="pagep">
                                                </td>
                                                <td class="no-borders" width="80">
                                                    <div class="s-14 c-text-alt">Paginación</div>
                                                    <select name="nopagina" id="nopagina" class="form-control">
                                                        <option value="10"> Paginación </option>
                                                        @foreach ($pages as $p)
                                                            <option value="{{ $p }}"> {{ $p }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center no-borders" width="30">
                                                    <div class="s-14 c-text-alt">Buscar</div>
                                                    <button type="submit"
                                                        class="tips btn btn-xs btn-white b-r-30 box-shadow"
                                                        title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                            </form>
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
                        <div class="col-sm-12 col-md-12 col-lg-12 no-padding m-t-xs" id="result2"></div>

                    </div>
                </div>
            </section>
        </article>
    </main>

    <script>
        query();

        function query() {
            var formData = new FormData(document.getElementById("searchgnal"));
            $.ajax("{{ URL::to('usuarios/search?idi=' . $idi) }}", {
                type: 'post',
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#result").empty().append(mss_tmp.load);
                },
                success: function(mensaje) {
                    $("#result").empty();
                    $("#result2").empty().append(mensaje);
                }
            });
        }
        $("#searchgnal").on("submit", function(e) {
            e.preventDefault();
            $("#pagep").val("1");
            query();
        });
        $(document).on("click", ".pagination li a", function(e) {
            e.preventDefault();
            var url = $(this).attr("href");
            var nopagina = $("#nopagina").val();
            var cadena = url.split('=');
            $("#pagep").val(cadena[1]);
            query();
        });
        $(document).on("click", ".btnedit", function(e) {
            e.preventDefault();
            modalMisesa("{{ URL::to('usuarios/update') }}", {}, "Agregar Usuario", '40%');
        });

        $(document).on("click", ".btnaccesos", function(e) {
            e.preventDefault();
            modalMisesa("{{ URL::to('usuarios/accesos') }}", {
                id: $(this).attr("id"),
                idtd: "{{ $idtd }}"
            }, "Permisos Usuario", '40%');
        });
        $(document).on("click", ".btnpermisosaux", function(e) {
            e.preventDefault();
            modalMisesa("{{ URL::to('usuarios/accesosaux') }}", {id: $(this).attr("id"),da: $(this).data("da") }, "Permisos por dependencia auxiliar", '40%');
        });
        $(document).on("click", ".btneditar", function(e) {
            e.preventDefault();
            modalMisesa("{{ URL::to('usuarios/informacion') }}", {id: $(this).attr("id") }, "Editar usuario", '40%');
        });
        $(document).on("click", ".btnestatus", function(e) {
            e.preventDefault();
            modalMisesa("{{ URL::to('usuarios/estatus') }}", {id: $(this).attr("id") }, "Cambiar estatus del usuario", '40%');
        });
        $(document).on("click", ".btndeleteaux", function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            swal({
                title: 'Estás seguro de eliminar el permiso para ver la dependencia general?',
                icon: 'warning',
                buttons: {
                    cancel: {
                        text: "No, Cancelar",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Sí, eliminar permiso",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                },
                dangerMode: true,
                closeOnClickOutside: false
            }).then((willDelete) => {
                if (willDelete) {
                    axios.delete('{{ URL::to('usuarios/depgen') }}', {
                        params: {
                            id: id
                        }
                    }).then(response => {
                        let row = response.data;
                        if (row.status == "ok") {
                            query();
                            toastr.success(row.message);
                        } else {
                            toastr.error(row.message);
                        }
                    })
                }
            })
        });
    </script>
@stop
