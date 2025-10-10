@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body s-14">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		<li class="active"><i>PDM alineación con metas</i></li>
	  </ul>	  
  </section>
	
  <section class="table-resp m-b-lg" style="min-height:300px;">

    <div class="toolbar-line col-md-12">
        <button type="button" onclick="location.href='{{ URL::to($pageModule)}}' " class="btn btn-default btn-xs b-r-5 btn-ses" ><i class="fa fa-arrow-circle-left"></i> Regresar</button>
    </div> 

    <div class="col-sm-12 col-md-12 col-lg-12 m-b-lg m-t-xs">
            @foreach ($rowsPilares as $row)
              <article class="col-sm-12 col-md-12 col-lg-12 bg-white p-sm b-b-gray cursor s-16 btnaccion_n" style="border-left:4px solid var({{ $row['color'] }});" data-type="down" data-id="{{ $row['id'] }}">
                <div class="col-sm-5 col-md-5 col-lg-6 font-bold c-text-alt">{{ $row['no'] }}. {{ $row['pilar'] }}</div>
                <div class="col-sm-4 col-md-4 col-lg-3 c-text-alt"></div>
                <div class="col-sm-2 col-md-2 col-lg-2 c-text-alt"></div>
                <div class="col-sm-1 col-md-1 col-lg-1">
                  <i class="fa fa-chevron-down cursor s-16 c-text-alt" id="icon_{{ $row['id'] }}"></i>	
                </div>
              </article>
              <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bg-white p-md d-none" id="ul_{{ $row['id'] }}" >
                @foreach ($row['temas'] as $c)
                  <a  href="{{ URL::to($pageModule.'/metas?idt='.$c['id'].'&idy='.$idy) }}" class="col-sm-12 col-md-12 col-lg-12 p-xs bg-hover-gray c-text-alt s-16" title="Abrir">
                    <div class="col-sm-6 col-md-6 col-lg-6"> <div class="b-r-100" style="background-color: var({{ $row['color'] }}); width: 10px; height: 10px; display: inline-block;margin-right:10px;"></div> {{ $c['no'].' '.$c['tema'] }}</div>
                    <div class="col-sm-3 col-md-3 col-lg-3"></div>
                    <div class="col-sm-2 col-md-2 col-lg-2"></div>
                    <div class="col-sm-1 col-md-1 col-lg-1"><i class="fa icon-arrow-right5 cursor s-20"  style="color: var({{ $row['color'] }});"></i></div>
                  </a>
                @endforeach
              </article>
            @endforeach

    </div>
</section>
				
</main>	
<script>
	$(".btnaccion_n").click(function(e){
		e.preventDefault();
		let type = $(this).data("type");
		let ida = $(this).data("id");
		if(type == "down"){
			$(this).data("type","up");
			$("#ul_"+ida).removeClass("d-none").addClass("d-block");
			$("#icon_"+ida).removeClass("fa-chevron-down").addClass("fa-chevron-up");
		}else{
			$(this).data("type","down");
			$("#ul_"+ida).removeClass("d-block").addClass("d-none");
			$("#icon_"+ida).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		}
	});
</script>
	
@stop