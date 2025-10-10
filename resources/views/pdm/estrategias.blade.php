@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="fun s-16"> {{ $pageTitle }} <small class="s-14">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>{{ $pageTitle }}</li>
        <li>Objetivos</li>
      </ul>	  
	</section>

	<div class="toolbar-line">
		<div class="col-md-12 m-b-md">
		  <button type="button" onclick="location.href='{{ URL::to('pdm?id='.$idtema.'&idpo='.$idpo) }}' " class="btn btn-default btn-xs b-r-30"><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
		  <a href="#" class="tips btn btn-sm btn-success b-r-30 btnagregar" title="Agregar Estrategia"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Estrategia</a>
		</div>
	</div> 	

	<section class="table-resp m-b-lg" style="min-height:300px;">

			

		<article class="col-sm-12 col-md-12 col-lg-12">
		
			<section class="col-sm-5 col-md-5 col-lg-5 no-padding">
			
				<div class="sbox animated fadeInRight border-l-blue">
					<div class="sbox-title"> <h4> <i class="fa fa-table"></i> PDM</h4></div>
					<div class="sbox-content"> 	
		
						<div class="col-sm-12 col-md-12 col-lg-12">
							
							<div class="col-sm-12 col-md-12 col-lg-12 p-xs b-b-gray">
								<label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> PDM: </label>
								<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->pilares }}</div>
							</div> 

							<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
								<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> TEMA: </label>
								<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->tema }}</div>
							</div>
							
							<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
								<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> OBJETIVO: </label>
								<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->tema }}</div>
							</div>
		
						</div>
		
						<div style="clear:both"></div>	
						
					</div>
				</div>
			</section>

			<section class="col-sm-7 col-md-7 col-lg-7 p-md">
				<div class="col-sm-12 col-md-12 col-lg-12 bg-white border-gray p-md b-r-c" id="line-comm" >
					<div class="col-sm-12 col-md-12 col-lg-12 c-text s-16 b-b-gray p-xs">ESTRATEGIAS</div>
					<div class="col-sm-12 col-md-12 col-lg-12 m-t-md m-b-md" id="result2"></div>
				</div>
			</section>
		</article>

	</section>
</main>	

<script>
	const idtema = "{{ $idtema }}";
    query();
    function query(){
      axios.get('{{ URL::to("pdm/searchobj") }}',{
            params : {idtema:idtema}
        }).then(response => {
          $("#result2").empty().append(response.data);
      })
    }
	$(".btnagregar").click(function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('pdm/agregarobj') }}",{idtema:idtema},"Agregar Objetivo","50%");
    })
</script>

<style>
	#line-comm{margin-left:40px;margin-top: -30px;}
	#line-comm::before{
			content: '';
			position: absolute;
			left: -10px;
			top: 24px;
			border-top: 12px solid transparent;
			border-bottom: 10px solid transparent;
			border-right:12px solid var(--color-white);
	}
</style>
@stop