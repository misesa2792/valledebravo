@include('formatos.meta.include.include_style_pdf',array("size"=>9))
<br>
<table id="table" width="100%" cellspacing="0" cellpadding="0" class="my-table" cellmargin="0">
	<tr>
		<th width="20" rowspan="2">#</th>
		<th rowspan="2">Descripción de Acciones</th>
		<th class="text-center bg-yellow-meta" colspan="4">
			Periodo Trimestral:
			<div> 01 Enero al 31 de Marzo {{ $proy->anio }}</div>
		</th>
		<th class="text-center bg-green-meta" colspan="4">
			Periodo Trimestral:
			<div>01 Abril al 30 de Junio {{ $proy->anio }}</div>
		</th>
		<th class="text-center bg-blue-meta" colspan="4">
			Periodo Trimestral:
			<div>01 Julio al 30 de Septiembre {{ $proy->anio }}</div>
		</th>
		<th class="text-center bg-red-meta" colspan="4">
			Periodo Trimestral:
			<div> 01 Octubre al 31 de Diciembre {{ $proy->anio }}</div>
		</th>
	</tr>
	<tr>
		<th style="width:30px;" class="text-center pun bg-yellow-meta">Total <div>Prog.</div></th>
		<th style="width:30px;">ENE.</th>
		<th style="width:30px;">FEB.</th>
		<th style="width:30px;">MAR.</th>
		<th style="width:30px;" class="text-center pun  bg-green-meta">Total <div>Prog.</div></th>
		<th style="width:30px;">ABR.</th>
		<th style="width:30px;">MAY.</th>
		<th style="width:30px;">JUN.</th>
		<th style="width:30px;" class="text-center pun bg-blue-meta">Total <div>Prog.</div></th>
		<th style="width:30px;">JUL.</th>
		<th style="width:30px;">AGO.</th>
		<th style="width:30px;">SEP.</th>
		<th style="width:30px;" class="text-center pun bg-red-meta">Total <div>Prog.</div></th>
		<th style="width:30px;">OCT.</th>
		<th style="width:30px;">NOV.</th>
		<th style="width:30px;">DIC.</th>
	</tr>
	@foreach (json_decode($metas) as $m)
		<tr>
			<td class="text-center" rowspan="2">{{ $m->no_a }}</td>
			<td rowspan="2" style="padding:5px;">
				<div class="s-8"><strong>Denominación:</strong> {{ $m->deno }}</div>
				<div class="s-8"><strong>Acción:</strong> {{ $m->meta }}</div>
				<br>
				<table width="100%" cellspacing="0" border="0" cellpadding="0" cellmargin="0">
					<tr>
						<th class="text-center">Medidda</th>
						<th class="text-center">Frecuencia Medición</th>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->um }}</td>
						<td class="text-center bg-body">{{ $m->fm }}</td>
					</tr>
					<tr>
						<th class="text-center">Tipo de Operación</th>
						<th class="text-center">Total Anual</th>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->to }}</td>
						<td class="text-center bg-body">{{ $m->pa }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table width="100%" cellspacing="0" border="0" cellpadding="0" cellmargin="0">
					<tr>
						<td class="text-center bg-yellow-meta">{{ $m->t1 }}</td>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->tt1 }}</td>
					</tr>
					<tr>
						<th class="no-borders bg-body">{{ $m->total_m1 }}%</th>
					</tr>
				</table>
			</td>
			@foreach ($m->m1 as $r)
				<td class="text-center"><strong>{{ $r->cant > 0 ? $r->cant : '' }}</strong></td>	
			@endforeach
			<td>
				<table width="100%" cellspacing="0" border="0" cellpadding="0" cellmargin="0">
					<tr>
						<td class="text-center bg-green-meta">{{ $m->t2 }}</td>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->tt2 }}</td>
					</tr>
					<tr>
						<th class="no-borders bg-body">{{ $m->total_m2 }}%</th>
					</tr>
				</table>
			</td>
			@foreach ($m->m2 as $r)
				<td class="text-center"><strong>{{ $r->cant > 0 ? $r->cant : '' }}</strong></td>	
			@endforeach
			<td>
				<table width="100%" cellspacing="0" border="0" cellpadding="0" cellmargin="0">
					<tr>
						<td class="text-center bg-blue-meta">{{ $m->t3 }}</td>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->tt3 }}</td>
					</tr>
					<tr>
						<th class="no-borders bg-body">{{ $m->total_m3 }}%</th>
					</tr>
				</table>
			</td>
			@foreach ($m->m3 as $r)
				<td class="text-center"><strong>{{ $r->cant > 0 ? $r->cant : '' }}</strong></td>	
			@endforeach
			<td>
				<table width="100%" cellspacing="0" border="0" cellpadding="0" cellmargin="0">
					<tr>
						<td class="text-center bg-red-meta">{{ $m->t4 }}</td>
					</tr>
					<tr>
						<td class="text-center bg-body">{{ $m->tt4 }}</td>
					</tr>
					<tr>
						<th class="no-borders bg-body">{{ $m->total_m4 }}%</th>
					</tr>
				</table>
			</td>
			@foreach ($m->m4 as $r)
				<td class="text-center"><strong>{{ $r->cant > 0 ? $r->cant : '' }}</strong></td>	
			@endforeach
		</tr>
		<tr>
			<td colspan="4">{{ $m->obs }}</td>
			<td colspan="4">{{ $m->obs2 }}</td>
			<td colspan="4">{{ $m->obs3 }}</td>
			<td colspan="4">{{ $m->obs4 }}</td>
		</tr>
	@endforeach
</table>