@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
		<div class="sbox-tools" >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
			@endif 
			</div>

        <h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>{{ $pageTitle }}</li>
        <li>{{ $ins->municipio }}</li>
        <li>{{ $ins->institucion }}</li>
      </ul>	  
	</section>
	
    <article class="toolbar-line">
        <div class="col-md-12 m-b-md">
            <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn btn-default btn-xs b-r-30"><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
        </div>
    </article>

    <article class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-title border-t-yellow"> <h4> <img src="{{ asset('images/icons/'.$ins->logo) }}" width="20" height="20"> &nbsp;&nbsp;&nbsp; {{ $ins->institucion }}</h4></div>
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <div class="col-md-12 no-padding m-b">
                        
                                      <div class="col-md-11 no-padding toolbar-line">
                                          @if($access['is_add'] == 1)
                                              <a href="#" class="tips btn btn-sm btn-success b-r-30 btnedit"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                                          @endif  
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
                                                      <a href="{{ URL::to($pageModule.'/municipio?k='.$token) }}" class="btn btn-xs btn-white b-r-30"><i class="fa fa-eraser var"></i> Limpiar</a>
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
        $.ajax("{{ URL::to($pageModule.'/search?k='.$token) }}", {
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
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{k: "{{ $token }}"}, "Agregar Usuario",'40%');
    });
    
</script>
@stop