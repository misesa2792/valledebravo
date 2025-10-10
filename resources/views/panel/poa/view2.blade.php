@extends('layouts.main')

@section('content')

<script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>

<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Presupuesto Operativo Anual</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
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
								<th colspan="4"></th>
								<td>Exportación OSFEM 2025</td>
								<td>Exportación Normal 2025</td>
							</tr>
							<tr>
								<td rowspan="4" width="20"><i class="fa icon-grid3 s-20 c-blue"></i></td>
								<td rowspan="4">Planeación</td>
							</tr>
							<tr>
								<td width="100">APDM</td>
								<td>Alineación del Plan de Desarrollo Municipal con el Plan Nacional de Desarrollo y Plan de Desarrollo Estatal</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportapdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>

							</tr>
							<tr>
								<td>ARPPPDM</td>
								<td>Asignación de Recurso por Programa Presupuestario PDM</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/arpppdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
							<tr>
								<td>PMPDM</td>
								<td>Programación de Metas del Plan de Desarrollo Municipal</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportpmpdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
			
							<tr>
								<td rowspan="5" width="20"><i class="fa icon-stats-up s-20 c-success"></i></td>
								<td rowspan="5">Programa Operativo Anual</td>
							</tr>
							<tr>
								<td>PbRM-01a</td>
								<td>Programa Anual Dimensión Administrativa del Gasto</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmaosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmanormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
							<tr>
								<td>PbRM-01b</td>
								<td>Programa Anual Descripción del Programa Presupuestario</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmbnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
							<tr>
								<td>PbRM-01c</td>
								<td>Programa Anual de Metas de Actividad por Proyecto</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmcosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmcosfemnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
							<tr>
								<td>PbRM-02a</td>
								<td>Calendarización de Metas de Actividad por Proyecto</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmaaosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmaanormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
						
							<tr>
								<td rowspan="3" width="20"><i class="fa icon-bars3 s-20 c-blue"></i></td>
								<td rowspan="3">Indicadores y Matrices</td>
							</tr>
							<tr>
								<td>PbRM-01d</td>
								<td>Ficha Técnica de Diseño de Indicadores Estratégicos de Gestión</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmdnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
							</tr>
							<tr>
								<td>PbRM-01e</td>
								<td>Matriz de Indicadores para Resultados por Programa Presupuestario y Dependencia General</td>
								<td class="text-center">
									<a href="{{ URL::to('pbrma/exportarpbrmenormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
								</td>
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