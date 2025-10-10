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
		
        <h3 class="c-primary s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>{{ $pageTitle }}</li>
      </ul>	  
	</section>

	<section class="table-resp m-b-lg" style="min-height:300px;">
		@foreach (json_decode($rowData) as $v)
			<div class="col-sm-12 col-md-10 col-lg-12 m-b-lg">

				<div class="col-sm-12 col-md-12 col-lg-12 c-text s-16 b-b-gray p-md bg-white font-bold">
					<div class="col-md-10">{{ $v->periodo }}</div>
					<div class="col-md-2 text-right">
						<a href="{{ URL::to('pdm/exportar?idperiodo='.$v->idperiodo) }}" class="btn btn-md btn-white" ><i class="fa icon-file-excel s-12 lit"></i> Exportar</a>
					</div>
				</div>

				@foreach ($v->rows as $row)
					<article class="col-sm-12 col-md-12 col-lg-12 bg-white p-sm b-b-gray cursor s-16 btnaccion_n" style="border-left:4px solid var({{ $row->color }});" data-type="{{$id == $row->id ? 'up' : 'down'}}" data-id="{{ $row->id }}">
						<div class="col-sm-5 col-md-5 col-lg-6 font-bold c-text-alt">{{ ++$i }}. {{ $row->pilares }}</div>
						<div class="col-sm-4 col-md-4 col-lg-3 c-text-alt">{{ $row->tipo }}</div>
						<div class="col-sm-2 col-md-2 col-lg-2 c-text-alt"></div>
						<div class="col-sm-1 col-md-1 col-lg-1">
							<i class="fa {{$id == $row->id ? 'fa-chevron-up' : 'fa-chevron-down'}} cursor s-16 c-text-alt" id="icon_{{ $row->id }}"></i>	
						</div>
					</article>
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bg-white p-md {{$id == $row->id ? 'd-block' : 'd-none'}}" id="ul_{{ $row->id }}" >
						@foreach ($row->temas as $key => $c)
							<a  href="{{ URL::to('pdm/subtemas?id='.$row->id."&idtema=".$c->idtema) }}" class="col-sm-12 col-md-12 col-lg-12 p-xs bg-hover-gray c-text-alt s-16" title="Abrir">
								<div class="col-sm-6 col-md-6 col-lg-6"> <div class="b-r-100" style="background-color: var({{ $row->color }}); width: 10px; height: 10px; display: inline-block;margin-right:10px;"></div> {{ $c->tema }}</div>
								<div class="col-sm-3 col-md-3 col-lg-3"></div>
								<div class="col-sm-2 col-md-2 col-lg-2"></div>
								<div class="col-sm-1 col-md-1 col-lg-1"><i class="fa icon-arrow-right5 cursor s-20"  style="color: var({{ $row->color }});"></i></div>
							</a>
						@endforeach
					</article>
				@endforeach
			</div>
		@endforeach
	</section>
</main>	

<script>
	$(".btnaccion_n").click(function(e){
		e.preventDefault();
		let type = $(this).data("type");
		let ida = $(this).data("id");
		console.log(type);
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