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
		<li>
			<a href="{{ URL::to('panel/poa') }}" class="c-blue"><i>Ejercicio Fiscal</i></a>
		</li>
		<li class="active"><i>{{ $row->year }}</i></li>
	  </ul>	  
  </section>
	
		<article class="page-content-wrapper m-t-xs m-b-lg">

			<div class="sbox animated fadeInRight border-t-green">
				
				<div class="col-md-12 b-b-gray no-padding c-text-alt m-b-md">
					<div class="p-sm"> <i class="fa icon-newspaper s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-16">Presupuesto Operativo Anual</span></div>
				</div>
		
				<div class="sbox-content "> 	
			
				<div class="row">
					<div class="col-md-12">
					<table class="table table-bordered table-hover table-ses">
						<tbody>
							<tr>
								<td rowspan="4" width="20"><i class="fa icon-grid3 s-20 c-blue"></i></td>
								<td rowspan="4">Planeación</td>
							</tr>
							<tr>
								<td width="100">APDM</td>
								<td>Alineación del Plan de Desarrollo Municipal con el Plan Nacional de Desarrollo y Plan de Desarrollo Estatal</td>
							</tr>
							<tr>
								<td>ARPPPDM</td>
								<td>Asignación de Recurso por Programa Presupuestario PDM</td>
							</tr>
							<tr>
								<td>PMPDM</td>
								<td>Programación de Metas del Plan de Desarrollo Municipal</td>
							</tr>
			
							<tr>
								<td rowspan="5" width="20"><i class="fa icon-stats-up s-20 c-success"></i></td>
								<td rowspan="5">Programa Operativo Anual</td>
							</tr>
							<tr>
								<td>PbRM-01a</td>
								<td>Programa Anual Dimensión Administrativa del Gasto</td>
							</tr>
							<tr>
								<td>PbRM-01b</td>
								<td>Programa Anual Descripción del Programa Presupuestario</td>
							
							</tr>
							<tr>
								<td>PbRM-01c</td>
								<td>Programa Anual de Metas de Actividad por Proyecto</td>
								
							</tr>
							<tr>
								<td>PbRM-02a</td>
								<td>Calendarización de Metas de Actividad por Proyecto</td>
								
							</tr>
						
							<tr>
								<td rowspan="3" width="20"><i class="fa icon-bars3 s-20 c-blue"></i></td>
								<td rowspan="3">Indicadores y Matrices</td>
							</tr>
							<tr>
								<td>PbRM-01d</td>
								<td>Ficha Técnica de Diseño de Indicadores Estratégicos de Gestión</td>
								
							</tr>
							<tr>
								<td>PbRM-01e</td>
								<td>Matriz de Indicadores para Resultados por Programa Presupuestario y Dependencia General</td>
								
							</tr>
						</tbody>
					</table>
					</div>
				</div>
	
				
				</div>
			</div>	
			</article>
				
</main>	

<div class="p-lg m-b-lg"></div>

@stop