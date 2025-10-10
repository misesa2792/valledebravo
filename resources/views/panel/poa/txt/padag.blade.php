@extends('layouts.main')

@section('content')

<script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>

<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>Presupuesto Operativo Anual</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body s-14">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		<li><i>Presupuesto Operativo Anual</i></li>
		<li><i>Programa Anual Dimensión Administrativa del Gasto</i></li>
		<li class="active c-danger font-bold"><i>PADAG0000{{ $row['year'] }}.txt</i></li>
	  </ul>	  
  </section>
	
		<article class="page-content-wrapper m-t-xs m-b-lg">

			<button type="button" onclick="location.href='{{ URL::to('panel/poa?idy='.$row['idy']) }}' " class="btn bg-default c-text b-r-5 tips m-b-xs" title="Regresar" style="margin-right:15px;">
				<i class="fa  fa-arrow-circle-left "></i> Regresar
			</button>

			<div class="sbox animated fadeInRight border-t-green">
		
				<div class="col-md-12 b-b-gray no-padding c-text-alt m-b-md">
					<div class="p-sm"> <i class="fa icon-newspaper s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-16">Programa Anual Dimensión Administrativa del Gasto</span></div>
				</div>
		
				<div class="sbox-content"> 	
			
					<div class="row">
						<div class="col-md-12" id="appTxt">
							
							
							<table class="table table-bordered table-ses no-borders">
								<tr>
									<th class="text-center no-borders">1</th>
									<th class="text-center no-borders">2</th>
									<th class="text-center no-borders">3</th>
									<th class="text-center no-borders">4</th>
									<th class="text-center no-borders">5</th>
									<th class="text-center no-borders">6</th>
									<th class="text-center no-borders">7</th>
									<th class="text-center no-borders">8</th>
									<th class="text-center no-borders">9</th>
								</tr>
								<tr class="bg-gray">
									<th class="text-center">Dependencia general</th>
									<th class="text-center">Dependencia auxiliar</th>
									<th class="text-center">Finalidad</th>
									<th class="text-center">Función</th>
									<th class="text-center">Subfunción</th>
									<th class="text-center">Programa</th>
									<th class="text-center">Subprograma</th>
									<th class="text-center">Proyecto</th>
									<th class="text-center">Presupuesto autorizado por proyecto</th>
								</tr>
								<tr v-for="row in rowsData">
									<td class="text-center">@{{ row.no_dep_gen }}</td>
									<td class="text-center">@{{ row.no_dep_aux }}</td>
									<td class="text-center">@{{ row.fin }}</td>
									<td class="text-center">@{{ row.fun }}</td>
									<td class="text-center">@{{ row.sub }}</td>
									<td class="text-center">@{{ row.prog }}</td>
									<td class="text-center">@{{ row.subpro }}</td>
									<td class="text-center">@{{ row.proy }}</td>
									<td class="text-center">@{{ row.presupuesto }}</td>
								</tr>
							</table>

						</div>
					</div>
				
				</div>
			</div>	
			</article>
				
</main>	

<div class="p-lg m-b-lg"></div>

<script>
	 const appTxt = Vue.createApp({
            data() {
                    return {
                        rowsData: [],
                    };
                },
            methods: {
                rowsProjects() {
                    axios.get('{{ URL::to("panel/padag") }}', {
                        params: {idy:"{{ $row['idy'] }}"}
                    }).then(response => {
                        this.rowsData = [];
                        this.rowsData = response.data.data;
                    }).catch(error => {
                    });
                }
            },
			mounted() {
				this.rowsProjects();
			},
        });

    const vm = appTxt.mount('#appTxt');
</script>

@stop