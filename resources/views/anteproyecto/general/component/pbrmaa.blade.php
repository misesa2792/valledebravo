<template id="component_pbrmaa">

	<section class="row m-b-lg">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
				<div class="col-sm-6">
					<h2 style="margin-top:6px;" class="font-bold">PbRM–02a</h2>
				</div>
				<div class="col-sm-6 text-right">
				
				</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–02a del año {{ $rowYear['anio'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

						<table class="table table-hover border-gray no-margins table-ses">
						<thead>
							<tr class="c-text-alt">
								<th class="no-borders" width="15%">Dependencia General</th>
								<th class="no-borders" width="15%">Dependencia Auxiliar</th>
								<th class="no-borders text-center" width="120">No. Proyecto</th>
								<th class="no-borders">Proyecto</th>
								<th class="no-borders" width="5"></th>
							</tr>
						</thead>
				
						<tbody>
							<template v-for="rr in rowsData">
								<tr class="c-text-alt">
									<td :rowspan="rr.data.length + 1" class="border-gray">
										@{{ rr.no_dep_gen }}  @{{ rr.dep_gen }}
									</td>
								</tr>
								<tr class="c-text-alt btnmostrar" v-for="v in rr.data">
									<td>@{{ v.no_dep_aux }} @{{ v.dep_aux }}</td>
									<td>@{{ v.no_proyecto }}</td>
									<td class="a-line">@{{ v.proyecto }}</td>
									<td class="text-center" width="20">
										<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" v-if="v.estatus != 1" title="Ver Información" @click.prevent="viewInfo(v.id)"></i>
									</td>
									<td width="70" class="text-center">
										<div v-if="v.c_estatus == 2">
											<div v-if="v.estatus == 1">
												@if($access['is_add'] == 1)
													<button type="button" class="btn btn-xs btn-success btn-ses btn-outline b-r-30" @click.prevent="addPbrmaa(v.id)"><i class="fa fa-plus-circle"></i> Agregar PbRM-02a</button>
												@endif
											</div>
											<div v-else>
		
												<div v-if="v.url != null && v.url != ''">
													@if($access['is_download'] == 1)
														<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(v)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
													@endif
												</div>
												<div v-else>
													@if($access['is_generate'] == 1)
														<button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(v.id)"><i class="fa icon-file-pdf s-12"></i> Generar PDF</button>
													@endif
												</div>
											</div>
										</div>

										<div v-else>
											@if($access['is_add'] == 1)
												<button type="button" class="btn btn-xs btn-warning btn-ses btn-outline b-r-30" disabled> Pendiente PbRM-01e</button>
											@endif
										</div>
									</td>
								</tr>
							</template>
						</tbody>
					</table>

					</div>
				</div>
			</article>
		</div>
	</section>

</template>

<script>
    const ComponentPbrmaa = { 
		template: "#component_pbrmaa",
		data() {
			return {
				rowsData : [],
            	cancelTokenSource: null,
				idy: 0
			};
		},
		methods:{
			rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("anteproyecto/searchaa") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}"},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {

					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = row.data;
					}else{
						toastr.error(row.message);
					}
				
				}).catch(error => {
				}).finally(() => {
				});

        	}
		},
		mounted(){
			this.idy = "{{$idy}}";
			this.rowsProjects();
		}
	};
</script>