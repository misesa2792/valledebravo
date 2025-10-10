@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
      </div>
  
      <ul class="breadcrumb bg-body s-14">
        <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
        <li class="active"><i>PDFs</i></li>
      </ul>	  
  </section>
	
	<article class="col-md-12 m-t-md">
        @include('planpdf.nav')


        <section class="page-content-wrapper no-padding m-t-md">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <div class="col-md-12 no-padding m-b">
                        
                                      <table class="table no-margins bg-white">
                                            <tbody>
                                                <tr>
                                                    <td class="no-borders" width="80%">
                                                        <input type="hidden" name="page" value="1" id="pagep">
                                                    </td>
												    <td class="no-borders">
                                                        <div class="s-14 c-text-alt">Paginación</div>
                                                        <select name="nopagina" id="nopagina" class="form-control">
                                                            <option value="10"> Paginación </option>
                                                            @foreach ($pages as $p)
                                                                <option value="{{ $p }}"> {{ $p }} </option>
                                                            @endforeach
                                                        </select>
												    </td>
                                                    <td class="text-center no-borders" width="30">
                                                      <div class="s-14 c-text-alt">Buscar</div>
                                                      <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                    </td>
                                                    <td class="text-center no-borders" width="30">
                                                      <div class="s-14 c-text-alt">Limpiar</div>
                                                      <a href="{{ URL::to($pageModule.'/pdf') }}" class="btn btn-xs btn-white b-r-30"><i class="fa fa-eraser var"></i> Limpiar</a>
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
        $.ajax("{{ URL::to($pageModule.'/pdfsearch') }}", {
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
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{id:$(this).attr("id"), idy:$(this).attr("idy")}, "Programa",'50%');
    });
    $(document).on("click",".btnmatriz",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/matriz') }}",{id:$(this).attr("id"), idy:$(this).attr("idy")}, "Matriz",'90%');
    }); 
    $(document).on("click",".btndelpdf",function(e){
        e.preventDefault();
        swal({
            title : 'Eliminar PDF',
            text: 'Estás seguro de eliminar el PDF?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willDelete) => {
            if(willDelete){
                axios.delete('{{ URL::to("planpdf/pdf") }}',{
                    params : {id:$(this).attr("id")}
                }).then(response => {
                    var row = response.data;
                    if(row.status == "ok"){
                        toastr.success(row.message);
                        query();
                    }else{
                        toastr.error(row.message);
                    }
                })
            }
        })
    });

    
</script>		
@stop