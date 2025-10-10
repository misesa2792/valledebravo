@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
        <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>

        <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li><i>Finalidad</i></li>
            <li class="active"><i>{{ $year }}</i></li>
        </ul>	  
    </section>
	
    <article class="toolbar-line col-md-12">
        <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 btn-ses" ><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
    </article>

  <div class="col-md-12 d-none" >
    {!! Form::open(array('url'=>'indestrategicos/saveind', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
    <div class="col-md-12">

    <div class="form-group  " >
        <label for="Descripcion" class=" control-label col-md-3 text-left s-14 c-text"> Archivo: </label>
        <div class="col-md-9">
            <input type="file" name="archivos" class="form-control">
        </div>
    </div> 

</div>
    
<div style="clear:both"></div>	
            
                
<div class="form-group">
    <div class="col-sm-12 text-center m-t-lg m-b-lg">	
        <button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
    </div>	  
</div> 
     
{!! Form::close() !!}
  </div>

	<article class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <input type="hidden" name="idy" value="{{ $idy }}">
                                  <div class="col-md-12 no-padding m-b">
                        
                                      <div class="col-md-11 no-padding toolbar-line">
                                          @if($access['is_add'] == 1)
                                              <a href="#" class="tips btn btn-sm btn-success btn-ses btnedit" id="0" idy="{{ $idy }}"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
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
                                                        <div class="s-14 c-text-alt">Número de programa</div>
                                                        <input type="text" name="no_programa" class="form-control" placeholder="Número de programa">
                                                    </td>
                                                    <td>
                                                        <div class="s-14 c-text-alt">Indicador</div>
                                                        <input type="text" name="indicador" class="form-control" placeholder="Indicador">
                                                        <input type="hidden" name="page" value="1" id="pagep">
                                                    </td>
                                                  <td class="text-center" width="30">
                                                      <div class="s-14 c-text-alt">Buscar</div>
                                                      <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                  </td>
                                                  <td class="text-center no-borders" width="30">
                                                      <div class="s-14 c-text-alt">Limpiar</div>
                                                      <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&year='.$year) }}" class="btn btn-xs btn-white b-r-30"><i class="fa fa-eraser var"></i> Limpiar</a>
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
    $(document).on("click",".btnedit",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{id:$(this).attr("id"), idy:$(this).attr("idy")}, "Indicador estrátegico",'50%');
    });
</script>		
@stop