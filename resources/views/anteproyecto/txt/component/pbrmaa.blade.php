<template id="component_pbrmaa">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          <div class="sbox-title border-t-green">
                <h4 class="col-md-8"> CMAP0000{{$rowYear['anio']}}.txt</h4>
                <div class="col-md-4 text-right">
                  <a href="{{URL::to('definitivo/txtcmap?idy='.$idy.'&name=CMAP0000'.$rowYear['anio'].'.txt')}}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="fa fa-file-text-o"></i>  Generar CMAP0000{{$rowYear['anio']}}.txt</a>
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
								<th class="text-center">Localidad beneficiada</th>
								<th class="text-center">Población beneficiada</th>
								<th class="text-center">Dependencia general</th>
								<th class="text-center">Dependencia auxiliar</th>
								<th class="text-center">Finalidad</th>
								<th class="text-center">Función</th>
								<th class="text-center">Subfunción</th>
								<th class="text-center">Programa</th>
								<th class="text-center">Subprograma</th>
								<th class="text-center">Proyecto</th>
								<th class="text-center">No. de Acción</th>
								<th class="text-center">Descripccion de las Metas de Actividad</th>
								<th class="text-center">Unidad de Medida</th>
								<th class="text-center">Cantidad Programada Anual</th>
								<th class="text-center">Absoluta Trim #1</th>
								<th class="text-center">Relativo Trim #1</th>
								<th class="text-center">Absoluta Trim #2</th>
								<th class="text-center">Relativo Trim #2</th>
								<th class="text-center">Absoluta Trim #3</th>
								<th class="text-center">Relativo Trim #3</th>
								<th class="text-center">Absoluta Trim #4</th>
								<th class="text-center">Relativo Trim #4</th>
							</tr>
							<tr v-for="(row, kc) in rowsData">
								<td class="text-center no-borders">@{{ ++kc }}</td>
								<td class="text-center">0</td>
								<td class="text-center">100</td>
								<td class="text-center">@{{ row.dg }}</td>
								<td class="text-center">@{{ row.da }}</td>
								<td class="text-center">@{{ row.fi }}</td>
								<td class="text-center">@{{ row.fu }}</td>
								<td class="text-center">@{{ row.sf }}</td>
								<td class="text-center">@{{ row.pr }}</td>
								<td class="text-center">@{{ row.sp }}</td>
								<td class="text-center">@{{ row.py }}</td>
								<td class="text-center">@{{ row.co }}</td>
								<td>@{{ row.me }}</td>
								<td class="text-center">@{{ row.um }}</td>
								<td :class="'text-center ' + (row.anual == '' || row.anual == null ? 'danger' : '')">@{{ row.anual }}</td>
								<td :class="'text-center ' + (row.t1 == '' || row.t1 == null ? 'danger' : '')">@{{ row.t1 }}</td>
								<td :class="'text-center ' + (row.p2 == '' || row.p2 == null ? 'danger' : '')">@{{ row.p1 }}</td>
								<td :class="'text-center ' + (row.t2 == '' || row.t2 == null ? 'danger' : '')">@{{ row.t2 }}</td>
								<td :class="'text-center ' + (row.p2 == '' || row.p2 == null ? 'danger' : '')">@{{ row.p2 }}</td>
								<td :class="'text-center ' + (row.t3 == '' || row.t3 == null ? 'danger' : '')">@{{ row.t3 }}</td>
								<td :class="'text-center ' + (row.p3 == '' || row.p3 == null ? 'danger' : '')">@{{ row.p3 }}</td>
								<td :class="'text-center ' + (row.t4 == '' || row.t4 == null ? 'danger' : '')">@{{ row.t4 }}</td>
								<td :class="'text-center ' + (row.p4 == '' || row.p4 == null ? 'danger' : '')">@{{ row.p4 }}</td>
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

				axios.get('{{ URL::to("definitivo/txtpbrmaa") }}',{
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