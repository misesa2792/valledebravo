@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary"> {{ $pageTitle }} <small class="s-12"> <i>{{ $pageNote }} </i></small></h3>
		</div>

		<ul class="breadcrumb bg-body s-14">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-14"></i> </a></li>
			<li class="active"><i>Municipios</i></li>
		</ul>		  
	</section>
    
    <div id="block-filtros" class="col-md-12 m-t-md">
        <form enctype="multipart/form-data" id="searchgnal" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="col-md-12 no-padding">

            <table class="table no-margins b-gray bg-white">
                <tbody>
                    <tr>
                        <td class="no-borders">
                            <div class="s-14 c-text-alt">Estatus</div>
                            <select name="active" class="form-control">
                                <option value="1" selected>Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </td>
                        <td class="no-borders">
                            <div class="s-14 c-text-alt">Clave</div>
                            <input type="text" name="clave" class="form-control" placeholder="Ingresa clave">
                        </td>
                        <td class="no-borders">
                            <div class="s-14 c-text-alt">Nombre del municipio</div>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresa nombre del municipio">
                        </td>
                        <td class="no-borders" width="100">
                            <div class="s-14 c-text-alt">Paginación</div>
                            <select name="nopagina" id="nopagina" class="form-control">
                                <option value="10"> Paginación </option>
                                @foreach ($pages as $p)
                                    <option value="{{ $p }}"> {{ $p }} </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="page" value="1" id="pagep">
                        </td>
                        <td class="text-center no-borders" width="30">
                            <div class="s-14 c-text-alt">Buscar</div>
                            <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
</main>	
<div class="row">
    <div class="col-md-12 m-b-lg m-t-md">
        <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
        <div class="col-sm-12 col-md-12 col-lg-12 no-padding " id="result2"></div>
    </div>
</div>
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
 
</script>
  
@stop