<template id="component_pbrme">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
           <div class="sbox-title border-t-green">
                <h4 class="col-md-8"> MIRPPDG0000{{$rowYear['anio']}}.txt</h4>
                <div class="col-md-4 text-right">
                  <a href="{{URL::to('definitivo/txtmirppdg?idy='.$idy.'&name=MIRPPDG0000'.$rowYear['anio'].'.txt')}}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="fa fa-file-text-o"></i>  Generar MIRPPDG0000{{$rowYear['anio']}}.txt</a>
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
							<th class="text-center no-borders">18</th>
							<th class="text-center no-borders">19</th>
							<th class="text-center no-borders">20</th>
							<th class="text-center no-borders">21</th>
							<th class="text-center no-borders">22</th>
						</tr>
						<tr class="bg-gray">
							<th class="no-borders bg-white"></th>
							<th class="text-center">DG</th>
							<th class="text-center">DA</th>
							<th class="text-center">Fin</th>
							<th class="text-center">Fun</th>
							<th class="text-center">Sub</th>
							<th class="text-center">Prog</th>
							<th class="text-center">Denominación del Programa Presupuestario</th>
							<th class="text-center">Objetivo del Programa Presupuestario</th>
							<th class="text-center">Eje</th>
							<th class="text-center">No. Eje</th>
							<th class="text-center">Tema de Desarrollo</th>
							<th class="text-center">Indicador</th>
							<th class="text-center">Nombre del Indicador</th>
							<th class="text-center">Fin del Programa</th>
							<th class="text-center">Propósito del Programa</th>
							<th class="text-center">Componentes del Programa</th>
							<th class="text-center">Actividades del Programa</th>
							<th class="text-center">Fórmula</th>
							<th class="text-center">Frecuencia</th>
							<th class="text-center">Tipo</th>
							<th class="text-center">Medio de verificación</th>
							<th class="text-center">Supuestos (Factores Externos)</th>
						</tr>
						<tr v-for="(row, kc) in rowsData">
							<td class="text-center no-borders">@{{ ++kc }}</td>
							<td class="text-center">@{{ row.dg }}</td>
							<td class="text-center">@{{ row.da }}</td>
							<td class="text-center">@{{ row.fi }}</td>
							<td class="text-center">@{{ row.fu }}</td>
							<td class="text-center">@{{ row.sf }}</td>
							<td class="text-center">@{{ row.pr }}</td>
							<td>@{{ row.prog }}</td>
							<td>@{{ row.obj_prog }}</td>
							<td class="text-center">@{{ row.tipo_pilar }}</td>
							<td class="text-center">@{{ row.no_pilar }}</td>
							<td>@{{ row.tema }}</td>
							<td>@{{ row.indicador }}</td>
							<td>@{{ row.nombre_indicador }}</td>
							<td>@{{ row.fin }}</td>
							<td>@{{ row.proposito }}</td>
							<td>@{{ row.componente }}</td>
							<td>@{{ row.actividad }}</td>
							<td>@{{ row.formula }}</td>
							<td class="text-center">@{{ row.frecuencia }}</td>
							<td class="text-center">@{{ row.tipo_indicador }}</td>
							<td>@{{ row.medios }}</td>
							<td>@{{ row.supuestos }}</td>
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
    const ComponentPbrme = { 
		template: "#component_pbrme",
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

				axios.get('{{ URL::to("definitivo/txtpbrme") }}',{
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
			this.idy = "{{$idy}}";
			this.rowsProjects();
		}
	};
</script>