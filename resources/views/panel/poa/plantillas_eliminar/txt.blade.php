<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover bg-white">
			<tr class="t-tr-s14">
				<th class="text-center" width="70">PbRM</th>
				<th class="text-center">Descripción</th>
				<th class="text-center" width="80">Exportación OSFEM 2025</th>
				<th class="text-center">Exportación Normal 2025</th>
			</tr>
	
			<tr class="t-tr-s14">
				<td>APDM00002025</td>
				<td>Alineación del Plan de Desarrollo Municipal con el Plan Nacional de Desarrollo y Plan Estatal de Desarrollo</td>
				<td>
					<a href="{{ URL::to('pbrma/exportapdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
					<td class="text-center"></td>
			</tr>

			<tr class="t-tr-s14">
				<td>ARPPPDM00002025</td>
				<td>Asignación de Recurso por Programa Presupuestario PDM</td>
				<td>
					<a href="{{ URL::to('pbrma/arpppdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
					<td class="text-center"></td>
			</tr>

			<tr class="t-tr-s14">
				<td>PMPDM00002025</td>
				<td>Programación de Metas del Plan de Desarrollo Municipal</td>
				<td>
					<a href="{{ URL::to('pbrma/exportpmpdm') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
					<td class="text-center"></td>
			</tr>

			<tr class="t-tr-s14">
				<td>PbRM-01a</td>
				<td>Dimensión Administrativa del Gasto</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmaosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
				<td class="text-center">
					<a href="{{ URL::to('pbrma/exportarpbrmanormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
			</tr>
	
			<tr class="t-tr-s14">
				<td>PbRM-01b</td>
				<td>Descripción del Programa presupuestario</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmbnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
				<td class="text-center"></td>
			</tr>
	
			<tr class="t-tr-s14">
				<td>PbRM-01c</td>
				<td>Metas de actividad por Proyecto</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmcosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
				<td class="text-center">
					<a href="{{ URL::to('pbrma/exportarpbrmcosfemnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
			</tr>
	
			<tr class="t-tr-s14">
				<td>PbRM-01d</td>
				<td>Ficha técnica de diseño de indicadores estratégicos o de gestión</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmdnormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
					<td class="text-center"></td>
			</tr>
	
			<tr class="t-tr-s14">
				<td>PbRM-01e</td>
				<td>Matriz de Indicadores para Resultados por Programa presupuestario</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmenormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
					<td class="text-center"></td>
			</tr>
	
			<tr class="t-tr-s14">
				<td>PbRM-02a</td>
				<td>Calendarización de Metas de Actividad por Proyecto</td>
				<td>
					<a href="{{ URL::to('pbrma/exportarpbrmaaosfem') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
				<td class="text-center">
					<a href="{{ URL::to('pbrma/exportarpbrmaanormal') }}" target="_blank" class="btn btn-xs btn-white b-r-5"><i class="fa icon-file-excel c-success"></i> Exportar</a>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="col-md-12 m-t-md m-b-md">
	<a href="{{ URL::to('pbrma/colocarpres') }}" target="_blank" class="btn btn-xs btn-white b-r-5 disabled"><i class="fa icon-file-excel c-success"></i> Actualizar Presupuesto PbRM-01a en PbRM-01c 2025</a>
</div>


<div class="col-md-12 m-t-md m-b-md">
	<a href="{{ URL::to('proyectopbrma/generarpdfa') }}" target="_blank" class="btn btn-xs btn-white b-r-5 disabled"><i class="fa icon-file-excel c-success"></i> Exportar generar PbRM-01a</a>
</div>

<div class="col-md-12 m-t-md m-b-md">
	<a href="{{ URL::to('proyectopbrmc/generarpdfcparte1') }}" target="_blank" class="btn btn-xs btn-white b-r-5 disabled"><i class="fa icon-file-excel c-success"></i> Exportar generar PbRM-01c Parte #1</a>
</div>

<div class="col-md-12 m-t-md m-b-md">
	<a href="{{ URL::to('proyectopbrmc/generarpdfcparte2') }}" target="_blank" class="btn btn-xs btn-white b-r-5 disabled"><i class="fa icon-file-excel c-success"></i> Exportar generar PbRM-01c Parte #2</a>
</div>

<div class="col-md-12 box-shadow bg-white b-r-5 p-md h-cont">
	
	<div class="c-blue s-20 text-center">Presupuesto Definitivo 2025</div>

	<div class="row m-l-none m-r-none m-t shortcut no-borders">
		<div class="col-sm-12 b-r p-sm bg-gray m-b-md">
			<span class="pull-left m-r-sm c-success"><i class="fa icon-file-excel"></i></span> 
			<a href="{{ URL::to('pbrma/exportarpbrmaanormalprogress') }}" class="clear" target="_blank">
				<span class="h3 block m-t-xs"><strong> Calendarización de Metas 2025</strong>
				</span> <small class="text-muted text-uc">Exportar Pbrm-01c con Pbrm-02a </small>
			</a>
		</div>		

		<div class="col-sm-12 b-r p-sm bg-gray m-b-md d-none">
			<span class="pull-left m-r-sm c-success"><i class="fa icon-file-excel"></i></span> 
			<a href="{{ URL::to('presupuestopbrma/exportarcalendarizacionmetas') }}" class="clear" target="_blank">
				<span class="h3 block m-t-xs"><strong> Calendarización de Metas 2024</strong>
				</span> <small class="text-muted text-uc">Exportar Pbrm-01c con Pbrm-02a </small>
			</a>
		</div>				
		<div class="col-sm-12 b-r p-sm bg-gray m-b-md d-none">
			<span class="pull-left m-r-sm text-success"><i class="fa icon-file-excel"></i></span>
			<a href="{{ URL::to('presupuestopbrma/exportardescripcionprograma') }}" class="clear" target="_blank">
				<span class="h3 block m-t-xs"><strong> Descripción del Programa </strong>
				</span> <small class="text-muted text-uc">Exportar  Pbrm-01b </small> 
			</a>
		</div>				
		<div class="col-sm-12 b-r p-sm bg-gray m-b-md d-none">
			<span class="pull-left m-r-sm text-warning"><i class="fa icon-file-excel"></i></span>
			<a href="{{ URL::to('presupuestopbrma/exportarindicadores') }}" class="clear post_url" target="_blank">
				<span class="h3 block m-t-xs"><strong>Indicadores</strong>
				</span> <small class="text-muted text-uc"> Exportar  Pbrm-01d</small> 
			</a>
		</div>	
		<div class="col-sm-12 b-r p-sm bg-gray m-b-md d-none">
			<span class="pull-left m-r-sm c-danger"><i class="fa icon-file-excel"></i></span>
			<a href="{{ URL::to('presupuestopbrma/exportarmatriz ') }}" class="clear post_url" target="_blank">
				<span class="h3 block m-t-xs"><strong>Indicadores Matriz</strong>
				</span> <small class="text-muted text-uc"> Exportar  Pbrm-01e</small> 
			</a>
		</div>					
	</div>
	
</div>