<template id="component_pbrmb">

	<section class="row">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
				<div class="col-sm-6">
					<h2 style="margin-top:6px;" class="font-bold">PbRM–01b</h2>
				</div>
				<div class="col-sm-6 text-right">
					
				</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–01b del año {{ $rowYear['anio'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

						<table class="table table-hover border-gray no-margins table-ses">
							<thead>
								<tr class="t-tr-s12 c-text-alt">
									<th class="no-borders" width="15%">Dependencia General</th>
									<th class="no-borders text-center" width="120">No. Programa</th>
									<th class="no-borders">Programa</th>
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
										<td>@{{ v.no_programa }}</td>
										<td class="a-line">@{{ v.programa }}</td>
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
    const ComponentPbrmb = { 
		template: "#component_pbrmb",
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

				axios.get('{{ URL::to("anteproyecto/searchb") }}',{
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
			this.idy = "{{ $idy }}";
			this.rowsProjects();
		}
	};
</script>