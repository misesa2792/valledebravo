@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

  <section class="page-header bg-body">
      <div class="col-md-10 no-padding">
        <div class="page-title">
            <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
          </div>
    
          <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li><i>Ejercicio Fiscal - {{ $year }}</i></li>
            <li class="active"><i>Dependencias</i></li>
          </ul>	
    </div>  
    <div class="col-md-2">
        <div class="c-blue font-bold b-r-5 bg-white p-xs text-center">
            <div><i>Ejercicio Fiscal</i></div>
            <div>{{ $year }}</div>
        </div>
    </div>
  </section>


  <section class="col-md-12 no-padding m-b-md">
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

{{--*/
    $info = json_decode($rowData);    
/*--}}
<section class="table-resp m-b-lg" style="min-height:300px;">

    <div class="col-sm-12 col-md-12 col-lg-12 m-b-lg">
        @if(count($info) > 0)
            @foreach ($info as $row)
                <article class="col-sm-12 col-md-12 col-lg-12 bg-white p-sm b-b-gray cursor s-14 btnaccion_n" data-type="{{$ida == $row->ida ? 'up' : 'down'}}" data-id="{{ $row->ida }}">
                    <div class="col-sm-6 col-md-6 col-lg-6 c-text"><strong class="c-text-alt">{{ $row->no }}</strong> - {{ $row->area }}</div>
                    <div class="col-sm-5 col-md-5 col-lg-5 c-text-alt">{{ $row->titular }}</div>
                    <div class="col-sm-1 col-md-1 col-lg-1 text-center">
                            <i class="fa {{$ida == $row->ida ? 'fa-chevron-up' : 'fa-chevron-down'}} cursor s-16 c-blue" id="icon_{{ $row->ida }}"></i>	
                    </div>
                </article>
                    <article class="col-sm-12 col-md-12 col-lg-12 p-md bg-white {{$ida == $row->ida ? 'd-block' : 'd-none'}}" id="ul_{{ $row->ida }}">
                        @foreach ($row->rows_coor as $key => $c)
                            <a  href="{{ URL::to($pageModule.'/proyectos?k='.SiteHelpers::CF_encode_json(array('ida'=>$row->ida,'idac'=>$c->id,'idi'=>$idi)).'&idy='.$idy.'&year='.$year) }}" style="border-left:2px solid var(--color-blue);" class="col-sm-12 col-md-12 col-lg-12 p-xs bg-hover-gray c-text-alt s-14" title="Abrir">
                                <i class="s-16 fa fa-circle p-abs" style="left:-8px;top:-2px;color:var(--color-blue);"></i>
                                <div class="col-sm-6 col-md-6 col-lg-6"><strong class="c-text-alt">{{ $c->numero }}</strong> - {{ $c->descripcion }}</div>
                                <div class="col-sm-5 col-md-5 col-lg-5"></div>
                                <div class="col-sm-1 col-md-1 col-lg-1 text-center"><i class="fa icon-arrow-right5 cursor s-16 c-blue"></i></div>
                            </a>
                        @endforeach
                    </article>
            @endforeach
        @else
            <div class="col-md-12 bg-white">
                <h1 class="text-center com m-t-lg m-b-lg"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
                <h2 class="text-center com m-t-lg m-b-lg">No se encontraron Registros!</h2>
            </div>
        @endif
    </div>
</section>
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

</main>		
@stop


