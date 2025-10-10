<template id="component_pbrmb">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          <div class="sbox-title border-t-green">
                <h4 class="col-md-8"> PADPP0000{{$rowYear['anio']}}.txt</h4>
                <div class="col-md-4 text-right">
                  <a href="{{URL::to('definitivo/txtpadpp?idy='.$idy.'&name=PADPP0000'.$rowYear['anio'].'.txt')}}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="fa fa-file-text-o"></i>  Generar PADPP0000{{$rowYear['anio']}}.txt</a>
                </div>
          </div>
          <div class="sbox-content bg-white"> 	

			<div class="row">

				<div class="col-md-12 m-t-md" v-if="rowsData.length > 0">
						<table class="table table-bordered table-ses no-borders">
							<tr>
								<th class="no-borders"></th>
								<th class="text-center no-borders">1</th>
								<th class="text-center no-borders">2</th>
								<th class="text-center no-borders">3</th>
								<th class="text-center no-borders">4</th>
								<th class="text-center no-borders">5</th>
								<th class="text-center no-borders">6</th>
								<th class="text-center no-borders">7</th>
								<th class="text-center no-borders">8</th>
								<th class="text-center no-borders">9</th>
								<th class="text-center no-borders">10</th>
								<th class="text-center no-borders">11</th>
								<th class="text-center no-borders">12</th>
								<th class="text-center no-borders">13</th>
								<th class="text-center no-borders">14</th>
								<th class="text-center no-borders">15</th>
								<th class="text-center no-borders">16</th>
								<th class="text-center no-borders">17</th>
							</tr>
							<tr class="bg-gray">
								<th class="no-borders bg-white"></th>
								<th class="text-center">DG</th>
								<th class="text-center">Fin</th>
								<th class="text-center">Fun</th>
								<th class="text-center">Sub</th>
								<th class="text-center">Pro</th>
								<th class="text-center">Denominación del programa presupuestario</th>
								<th class="text-center">Fortalezas del programa presupuestario (F)</th>
								<th class="text-center">Oportunidades del programa presupuestario (O)</th>
								<th class="text-center">Debilidades del programa presupuestario (D)</th>
								<th class="text-center">Amenazas del programa presupuestario (A)</th>
								<th class="text-center">Objetivo del programa presupuestario</th>
								<th class="text-center">Estrategias para alcanzar el objetivo del programa presupuestario</th>
								<th class="text-center">Objetivos del PDM atendidos</th>
								<th class="text-center">Estrategias del PDM atendidas</th>
								<th class="text-center">Líneas de Acción del PDM atendidas</th>
								<th class="text-center">Objetivos para el Desarrollo Sostenible (ODS) atendidos por el programa presupuestario</th>
								<th class="text-center">Metas para el Desarrollo Sostenible (ODS) atendidas por el programa presupuestario</th>
							</tr>
							<tr v-for="(row, kc) in rowsData">
								<td class="text-center no-borders">@{{ ++kc }}</td>
								<td class="text-center">@{{ row.dg }}</td>
								<td class="text-center">@{{ row.fi }}</td>
								<td class="text-center">@{{ row.fu }}</td>
								<td class="text-center">@{{ row.sf }}</td>
								<td class="text-center">@{{ row.pr }}</td>
								<td>@{{ row.prog }}</td>
								<td>@{{ row.fort }}</td>
								<td>@{{ row.opo }}</td>
								<td>@{{ row.deb }}</td>
								<td>@{{ row.ame }}</td>
								<td>@{{ row.ob_prog }}</td>
								<td>@{{ row.est }}</td>
								<td>@{{ row.la_obj }}</td>
								<td>@{{ row.la_est }}</td>
								<td>@{{ row.la_la }}</td>
								<td>@{{ row.ods_obj }}</td>
								<td>@{{ row.ods_metas }}</td>
							</tr>
						</table>
					</div>
				
			</div>

          </div>
        </div>		 
      </section>
		
		</div>
	</div>
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

				axios.get('{{ URL::to("definitivo/txtpbrmb") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}"},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {

					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = response.data.data.data;
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