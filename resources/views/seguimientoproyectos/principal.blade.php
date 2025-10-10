@extends('layouts.app')

@section('content')
<main class="page-content row bg-body"  id="app_ff">

    <section class="page-header bg-body">
		<div class="col-md-10">
            <div class="page-title">
                <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
            </div>
            <ul class="breadcrumb bg-body s-14">
                <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
                <li class="active">{{ $pageTitle }} </li>
            </ul>	
        </div>
        
        <div class="col-md-2">
            <div class="c-blue font-bold b-r-5 bg-white p-xs text-center">
                <div><i>Ejercicio Fiscal</i></div>
                <div>{{ $year }}</div>
            </div>
        </div>
	  </section>
	
      <section class="col-md-12 no-padding">
        <div class="col-md-12 p-rel">
            <ul class="nav nav-tabs text-right">
                <li>
                  <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
                    <i class="fa  fa-arrow-circle-left "></i> Regresar
                  </button>
                </li>
            </ul>
        </div>
      </section>

	<article class="col-md-12 m-t-md">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-title border-t-yellow"> <h4> Proyectos</h4></div>
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <input type="hidden" name="idanio" value="{{ $idy }}">
                                  <div class="col-md-12 no-padding m-b">
                      
                                      <div class="col-md-11"></div>
                                      <div class="col-md-1 text-right no-padding">
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
                                                    <div class="s-14 c-text-alt">No. Proyecto</div>
                                                    <input type="text" name="no_proyecto" class="form-control" placeholder="Ingresa número del proyecto">
                                                </td>
                                                <td>
                                                    <div class="s-14 c-text-alt">Proyecto</div>
                                                    <input type="text" name="proyecto" class="form-control" placeholder="Ingresa nombre del proyecto">
                                                </td>
                                                <td>
                                                    <div class="s-14 c-text-alt">Dependencia General</div>
                                                    <select name="iddep_gen" class="form-control">
                                                        <option value="">--Select Please--</option>
                                                        @foreach ($rowsDepGen as $ka => $v)
                                                            <option value="{{ $v->idarea }}">{{$v->area}} </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                  <td class="text-center" width="30">
                                                      <div class="s-14 c-text-alt">Buscar</div>
                                                    <input type="hidden" name="page" value="1" id="pagep">
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
        $.ajax("{{ URL::to($pageModule.'/search?idam='.$idam) }}", {
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