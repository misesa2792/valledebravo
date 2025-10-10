@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
        <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>

        <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li>{{ $year }}</li>
            <li class="active"><i>{{ $pageNote }}</i></li>
        </ul>	  
    </section>
	
    <article class="toolbar-line col-md-12">
        <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 btn-ses" ><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
    </article>

    <article class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-title border-t-yellow"> <h4> Dependencias Generales</h4></div>
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="hidden" name="idy" value="{{ $idy }}">
                                <div class="col-md-12 no-padding">
                        
                                    <div class="col-md-2 no-padding">
                                        @if($access['is_add'] ==1)
                                            <div class="btn-group ">
                                                <button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-plus-circle c-text"></span> Agregar <i class="caret"></i> </button>
                                                <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                                    @foreach($rowsTipoDep as $td)
                                                        <li><a href="#" id="{{ $td->id }}" class="btnagregar"><i class="fa fa-plus-circle c-blue"></i> {{ $td->abreviatura.' - '.$td->dependencia }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9 no-padding">
                                    </div>
                    
                                    <div class="col-md-1 no-padding">
                                        <select name="nopagina" id="nopagina" class="form-control">
                                            <option value="10"> Paginación </option>
                                            @foreach ($pages as $p)
                                                <option value="{{ $p }}"> {{ $p }} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="page" value="1" id="pagep">
                                    </div>
                    
                                    <div class="col-md-12 no-padding m-t-xs m-b-xs">
                                        <table class="table table-bordered no-margins b-gray bg-white">
                                            <tr>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Municipios</div>
                                                    <select name="idm" class="select2">
                                                        <option value="">--Select Please--</option>
                                                        @foreach($rowsMunicipios as $m)
                                                            <option value="{{ $m->idmunicipios }}">{{ $m->numero.' '.$m->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Tipo Dependencia</div>
                                                    <select name="idtd" class="select2">
                                                        <option value="">--Select Please--</option>
                                                        @foreach($rowsTipoDep as $td)
                                                            <option value="{{ $td->id }}">{{ $td->abreviatura }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Estatus</div>
                                                    <select name="estatus" class="select2">
                                                        <option value="">--Select Please--</option>
                                                        @foreach($rowsEstatus as $ks => $std)
                                                        <option value="{{ $ks }}">{{ $std }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Denominación</div>
                                                    <input type="text" name="no" class="form-control" placeholder="Ingresa número">
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Dependencia General</div>
                                                    <input type="text" name="dg" class="form-control" placeholder="Ingresa Nombre">
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Titular</div>
                                                    <input type="text" name="titular" class="form-control" placeholder="Ingresa Nombre">
                                                </td>
                                                <td class="text-center no-borders" width="30">
                                                    <div class="s-14 c-text-alt">Buscar</div>
                                                    <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                </td>
                                                <td class="text-center no-borders" width="30">
                                                    <div class="s-14 c-text-alt">Limpiar</div>
                                                    <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&year='.$year) }}" class="btn btn-xs btn-white b-r-30"><i class="fa fa-eraser var"></i> Limpiar</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                        
                                </form>
                            </div>
                            
                            <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
                            <div class="col-sm-12 col-md-12 col-lg-12 no-padding " id="result2"></div>
    
                        </div>
                </div>		 
            </section>
    </article>		
<script>
    query();
    function query(){
        var formData = new FormData(document.getElementById("searchgnal"));
        $.ajax("{{ URL::to($pageModule.'/search') }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#result").empty().append(mss_tmp.load);
            },success: function(mensaje){
                $("#result").empty();
                $("#result2").empty().append(mensaje);
            }
        });
    }
    $("#searchgnal").on("submit", function(e){
        e.preventDefault();
        $("#pagep").val("1");
        query();
    });
    $(document).on("click",".pagination li a",function(e){
        e.preventDefault();
        var url =$( this).attr("href");
        var nopagina = $("#nopagina").val();
        var cadena = url.split('=');
        $("#pagep").val(cadena[1]);
        query();
    });

    $(document).on("click",".btnagregar",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/add') }}",{id:$(this).attr("id"), idy: "{{ $idy }}"}, "Agregar Dependencia General",'50%');
    })

    $(document).on("click",".btneditar",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{id:$(this).attr("id"), idy: "{{ $idy }}", idtd:$(this).data("idtd")}, "Editar dependencia general",'50%');
    })

    $(document).on("click",".btneliminar",function(e){
        e.preventDefault();
        let id = $(this).attr('id');

        swal({
            title : 'Estás seguro de eliminar la Dependencia General?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willDelete) => {
            if(willDelete){
                axios.delete('{{ URL::to($pageModule."/depgen") }}',{
                    params : {id:id}
                }).then(response => {
                    let row = response.data;
                    if(row.status == "ok"){
                        toastr.success(row.message);
                        query();
                    }
                })
            }
        })

    });

</script>
</main>		
@stop