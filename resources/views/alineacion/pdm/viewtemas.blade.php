

		@foreach ($data as $v)
			<div class="col-md-12 m-b-md no-padding bg-white">
				<div class="col-md-12 p-xs bg-pink c-white"><strong>Tema de desarrollo:</strong> {{ $v['no'].' '.$v['tema'] }}</div>
				@foreach ($v['subtemas'] as $s)
						<div class="col-md-12 p-xs bg-title"><strong>Subtema:</strong> {{ $s['subtema'] }}</div>

						<div class="col-md-12 no-padding">
								@foreach ($s['objetivos'] as $o)
									<table class="table table-bordered no-margins">
										<tr>
											<td class="bg-red-meta c-white">Objetivo</td>
											<td class="bg-blue-meta c-white">Estrategias</td>
											<td class="bg-green-meta c-white">Lineas de Acción</td>
											<td class="bg-yellow-meta c-white">Metas PDM - PbRM</td>
										</tr>
										<tr>
											<td rowspan="{{ 100 }}">{{ $o['no'] .' '.$o['objetivo'] }}</td>
										</tr>
										@foreach ($o['estrategias'] as $e)
											<tr>
												<td rowspan="{{ count($e['lineas']) + 1 }}" width="25%">{{ $e['no'] .' '.$e['est'] }}</td>
											</tr>

											@foreach ($e['lineas'] as $l)
												<tr>
													<td width="15%">{{ $l['no'] .' '.$l['la'] }}</td>
													<td width="45%">
														<table class="table">
															@foreach ($l['metas'] as $m)
																<tr>
																	<td>
																		<button type="button" class="btn btn-xs btn-white btnalinear" data-id="{{ $m['id'] }}" data-idla="{{ $l['id'] }}"><i class="fa fa-plus-circle"></i></button>
																	</td>
																	<td width="45%">{{ $m['no'].' '.$m['meta'] }}</td>
																	<td width="50%">

																		<table class="table">
																			@foreach ($m['metas'] as $mr)
																				<tr>
																					<td>{{ $mr->no_accion }}</td>
																					<td>{{ $mr->meta }}</td>
																					<td>
																						<i class="fa fa-trash-o c-danger cursor btneliminar" data-id="{{ $mr->id }}"></i>
																					</td>
																				</tr>
																			@endforeach
																		</table>


																	</td>
																</tr>
															@endforeach
														</table>
														<ul>
															
														</ul>
													</td>
												</tr>
												
											@endforeach
										@endforeach
									</table>
								@endforeach
						</div>
				@endforeach
			</div>
		@endforeach
	</div>
<script>
	$(document).ready(function(){
		$('.btnalinear').click(function(e){
			e.preventDefault();
			let idmeta = $(this).data('id');
			let idla = $(this).data('idla');
              modalMisesa("{{ URL::to($pageModule.'/alinearmetas') }}",{idy:"{{$idy}}",idla:idla,idmeta:idmeta},"Alinear con metas","90%");
		});
		$('.btneliminar').click(function(e){
			e.preventDefault();
			let id = $(this).data('id');

			swal({
				title : 'Estás seguro de eliminar la meta del PbRM alineada a la meta del PDM?',
				icon : 'warning',
				buttons : true,
				dangerMode : true
			}).then((willDelete) => {
				if(willDelete){
					axios.delete('{{ URL::to("alineacion/metapbrm") }}',{
						params : {id:id}
					}).then(response => {
						let row = response.data;
						if(row.status == "ok"){
							toastr.success(row.message);
							appTema.loadData();
						}
					})
				}
			})

		});
	});
</script>