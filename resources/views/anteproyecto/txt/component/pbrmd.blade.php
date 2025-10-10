<template id="component_pbrmd">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          
			<div class="sbox-title border-t-green">
                <h4 class="col-md-8"> FTDIEG0000{{$rowYear['anio']}}.txt</h4>
                <div class="col-md-4 text-right">
                  <a href="{{URL::to('definitivo/txtftdieg?idy='.$idy.'&name=FTDIEG0000'.$rowYear['anio'].'.txt')}}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="fa fa-file-text-o"></i>  Generar FTDIEG0000{{$rowYear['anio']}}.txt</a>
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
							<th class="text-center no-borders">23</th>
							<th class="text-center no-borders">24</th>
							<th class="text-center no-borders">25</th>
							<th class="text-center no-borders">26</th>
							<th class="text-center no-borders">27</th>
							<th class="text-center no-borders">28</th>
							<th class="text-center no-borders">29</th>
							<th class="text-center no-borders">30</th>
						</tr>
						<tr class="bg-gray">
							<th class="no-borders bg-white"></th>
							<th class="text-center">Eje</th>
							<th class="text-center">No. Eje</th>
							<th class="text-center">No. Tema</th>
							<th class="text-center">DG</th>
							<th class="text-center">DA</th>
							<th class="text-center">Fin</th>
							<th class="text-center">Fun</th>
							<th class="text-center">Sub</th>
							<th class="text-center">Prog</th>
							<th class="text-center">SubProg</th>
							<th class="text-center">Proy</th>
							<th class="text-center">Objetivo</th>
							<th class="text-center">Nombre del Indicador</th>
							<th class="text-center">Tipo de indicador</th>
							<th class="text-center">Fórmula de Cálculo</th>
							<th class="text-center">Interpretación</th>
							<th class="text-center">Dimensión</th>
							<th class="text-center">Factor de Comparación</th>
							<th class="text-center">Descripcción del factor de comparación</th>
							<th class="text-center">Linea Base</th>
							<th class="text-center">Frecuencia</th>
							<th class="text-center">Variable</th>
							<th class="text-center">Unidad de Medida</th>
							<th class="text-center">Tipo de Operación</th>
							<th class="text-center">Trimestre 1</th>
							<th class="text-center">Trimestre 2</th>
							<th class="text-center">Trimestre 3</th>
							<th class="text-center">Trimestre 4</th>
							<th class="text-center">Meta Anual</th>
							<th class="text-center">Medios de Verificación</th>
						</tr>
						<tr v-for="(row, kc) in rowsData">
							<td class="text-center no-borders">@{{ ++kc }}</td>
							<td class="text-center">@{{ row.tp }}</td>
							<td class="text-center">@{{ row.np }}</td>
							<td class="text-center">@{{ row.nt }}</td>
							<td class="text-center">@{{ row.dg }}</td>
							<td class="text-center">@{{ row.da }}</td>
							<td class="text-center">@{{ row.fi }}</td>
							<td class="text-center">@{{ row.fu }}</td>
							<td class="text-center">@{{ row.sf }}</td>
							<td class="text-center">@{{ row.pr }}</td>
							<td class="text-center">@{{ row.sp }}</td>
							<td class="text-center">@{{ row.py }}</td>
							<td>@{{ row.op }}</td>
							<td>@{{ row.ni }}</td>
							<td class="text-center">@{{ row.ti }}</td>
							<td>@{{ row.fl }}</td>
							<td>@{{ row.d_i }}</td>
							<td>@{{ row.d_d }}</td>
							<td>@{{ row.d_f }}</td>
							<td>@{{ row.d_fd }}</td>
							<td>@{{ row.d_lb }}</td>
							<td class="text-center">@{{ row.fre }}</td>
							<td>@{{ row.vari }}</td>
							<td>@{{ row.um }}</td>
							<td class="text-center">@{{ row.to }}</td>
							<td class="text-center">@{{ row.t1 }}</td>
							<td class="text-center">@{{ row.t2 }}</td>
							<td class="text-center">@{{ row.t3 }}</td>
							<td class="text-center">@{{ row.t4 }}</td>
							<td class="text-center">@{{ row.al }}</td>
							<td>@{{ row.mv }}</td>
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
    const ComponentPbrmd = { 
		template: "#component_pbrmd",
		data() {
			return {
				rowsData : [],
            	cancelTokenSource: null,
			};
		},
		methods:{
			rowsProjects(){

				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("definitivo/txtpbrmd") }}',{
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
			this.rowsProjects();
		}
	};
</script>