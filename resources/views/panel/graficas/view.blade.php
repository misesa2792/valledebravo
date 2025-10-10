@extends('layouts.main')

@section('content')

<script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>

<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Gráficas</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
		<li>
			<a href="{{ URL::to('panel/graficas') }}" class="c-blue"><i>Ejercicio Fiscal</i></a>
		</li>
		<li class="active"><i>{{ $row->year }}</i></li>
	  </ul>	  
  </section>
	
	<div class="table-responsive m-t-md m-b-lg" style="border:0px !important;background:transparent;">
		<div class="col-sm-12 col-md-12 col-lg-12 m-b-md ">
			<ul class="nav nav-tabs no-borders">

				<li class="btnaccion active" data-no="3" data-type="0" id="btnaccion_3">
					<a href="#" class="b-r-5 s-16 cursor"> 
						<i class="fa fa-bar-chart-o s-18 c-yellow"></i> &nbsp;&nbsp;&nbsp;Gráfica por Proyecto
					</a>
				</li>
	
				<li class="btnaccion" data-no="1" data-type="0" id="btnaccion_1">
					<a href="#" class="b-r-5 s-16 cursor"> 
						<i class="fa fa-bar-chart-o s-18 kwd"></i> &nbsp;&nbsp;&nbsp;Gráfica Metas
					</a>
				</li>

				<li class="btnaccion" data-no="6" data-type="1" id="btnaccion_6">
					<a href="#" class="b-r-5 s-16 cursor"> 
						<i class="fa fa-bar-chart-o s-18 kwd"></i> &nbsp;&nbsp;&nbsp;Gráfica Indicadores
					</a>
				</li>
			
			</ul>
    	</div>
	
		<div class="col-md-12" id="tmp_graficas"></div>
  </div>
				
</main>	

<div class="p-lg m-b-lg"></div>

<script>
	loadTemplateGraficas(3,0);
	

	function loadTemplateGraficas(no,type){
		let idanio = "{{ $row['idy'] }}";
		$("#tmp_graficas").empty().html(mss_tmp.load);
		axios.get("{{ URL::to('graficas/template') }}",{
				params : {no:no, idanio:idanio,type:type}
		}).then(response =>{
			$("#tmp_graficas").html(response.data);
		}).catch(error => {
			toastr.error("Error, vuelve a intentar!");
		})
	}
	$(".btnaccion").click(function(e){
		e.preventDefault();
		let no = $(this).data("no");
		let type = $(this).data("type");
		let component = document.getElementsByClassName("btnaccion");
		for(var i = 0; i < component.length; i++) {
			component[i].classList.remove("active");
		}
		let id = document.getElementById("btnaccion_"+no);
		id.classList.add("active");
		loadTemplateGraficas(no,type);
	})
</script>

@stop