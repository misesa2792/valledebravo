@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary"> {{ $pageTitle }} <small class="s-12"> <i>{{ $pageNote }} </i></small></h3>
		</div>

		<ul class="breadcrumb bg-body s-14">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-14"></i> </a></li>
			<li class="active"><i>Usuarios</i></li>
		</ul>		  
	</section>
	
    <article class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-title border-t-yellow"> <h4> Usuarios</h4></div>
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <input type="hidden" name="idtd" value="{{ $idtd }}">
                                  <div class="col-md-12 no-padding">
                        
                                      <div class="col-md-11 no-padding toolbar-line">
                                         <a href="#" class="tips btn btn-sm btn-success btnedit"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                                      </div>
                      
                                      <div class="col-md-1 no-padding">
                                          <div class="toolbar-line">
                                              <select name="nopagina" id="nopagina" class="form-control">
                                                  <option value="10"> Paginación </option>
                                                  @foreach ($pages as $p)
                                                      <option value="{{ $p }}"> {{ $p }} </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                      
                                      <table class="table no-margins b-gray bg-white">
                                          <tbody>
                                              <tr>
                                                  <td>
                                                      <div class="s-14 c-text-alt">Estatus</div>
                                                      <select name="active" class="form-control">
                                                          <option value="">--Select Please--</option>
                                                          <option value="1" selected>Activo</option>
                                                          <option value="5">Inactivo</option>
                                                      </select>
                                                  </td>
                                                  <td>
                                                    <div class="s-14 c-text-alt">Nivel</div>
                                                    <select name="group_id" class="form-control">
                                                        <option value="">--Select Please--</option>
                                                        @foreach ($rowsNivel as $v)
                                                            <option value="{{ $v->id }}">{{$v->nivel}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                  <td>
                                                      <div class="s-14 c-text-alt">Nombre</div>
                                                      <input type="text" name="name" class="form-control" placeholder="Ingresa nombre a buscar">
                                                      <input type="hidden" name="page" value="1" id="pagep">
                                                  </td>
                                                  <td class="text-center" width="30">
                                                      <div class="s-14 c-text-alt">Buscar</div>
                                                      <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                  </td>
                                                  <td class="text-center no-borders" width="30">
                                                      <div class="s-14 c-text-alt">Limpiar</div>
                                                      <a href="{{ URL::to($pageModule) }}" class="btn btn-xs btn-white b-r-30"><i class="fa fa-eraser var"></i> Limpiar</a>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                        
                                 </form>
                              </div>
                            
                            <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
                            <div class="col-sm-12 col-md-12 col-lg-12 no-padding " id="result2"></div>
    
                        </div>
                </div>		 
            </section>
    </article>		
</main>		

<script>
    query();
    function query(){
        var formData = new FormData(document.getElementById("searchgnal"));
        $.ajax("{{ URL::to('usuarios/search?idi='.$idi) }}", {
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
    $(document).on("click",".btnedit",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to('usuarios/update') }}",{}, "Agregar Usuario",'40%');
    });
    
    $(document).on("click",".btnaccesos",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to('usuarios/accesos') }}",{id:$(this).attr("id"), idtd:"{{ $idtd }}"}, "Permisos Usuario",'40%');
    });
    
</script>
@stop