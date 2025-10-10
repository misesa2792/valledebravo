@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

  @if($type == 0)
    @include('reporte.include.menumetas')
  @else 
    @include('reporte.include.menuindicadores')
  @endif

{{--*/
    $info = json_decode($rowData);    
/*--}}
<section class="table-resp m-b-lg" style="min-height:300px;">

    <div class="col-sm-12 col-md-12 col-lg-12 m-b-lg">
        @if(count($info) > 0)
            @foreach ($info as $row)
                <article class="col-sm-12 col-md-12 col-lg-12 bg-white p-sm b-b-gray cursor btnaccion_n" data-type="{{$ida == $row->ida ? 'up' : 'down'}}" data-id="{{ $row->ida }}">
                    <div class="col-sm-6 col-md-6 col-lg-6 c-text"><strong class="c-text-alt">{{ $row->no }}</strong> - {{ $row->area }}</div>
                    <div class="col-sm-5 col-md-5 col-lg-5 c-text-alt"> {{ $row->titular }}</div>
                    <div class="col-sm-1 col-md-1 col-lg-1 text-right">
                            <i class="fa {{$ida == $row->ida ? 'fa-chevron-up' : 'fa-chevron-down'}} cursor c-blue" id="icon_{{ $row->ida }}"></i>	
                    </div>
                </article>
                    <article class="col-sm-12 col-md-12 col-lg-12 p-md bg-white {{$ida == $row->ida ? 'd-block' : 'd-none'}}" id="ul_{{ $row->ida }}">
                        @foreach ($row->rows_coor as $key => $c)
                            <a  href="{{ URL::to($pageModule.'/proyectos?k='.SiteHelpers::CF_encode_json(array('ida'=>$row->ida,'idac'=>$c->idac,'idi'=>$idi)).'&idy='.$idy.'&year='.$year.'&type='.$type) }}" style="border-left:1px solid var(--color-blue);" class="col-sm-12 col-md-12 col-lg-12 p-xs bg-hover-gray c-text-alt s-14" title="Abrir">
                                <i class="s-16 fa fa-circle p-abs s-12" style="left:-6px;top:-2px;color:var(--color-blue);"></i>
                                <div class="col-sm-6 col-md-6 col-lg-6"><strong class="c-text-alt">{{ $c->no_dep_aux }}</strong> - {{ $c->dep_aux }}</div>
                                <div class="col-sm-5 col-md-5 col-lg-5"></div>
                                <div class="col-sm-1 col-md-1 col-lg-1 text-right"><i class="fa icon-arrow-right5 cursor c-blue"></i></div>
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







