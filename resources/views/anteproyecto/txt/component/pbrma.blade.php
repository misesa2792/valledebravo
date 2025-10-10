<template id="component_pbrma">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
            <div class="sbox-title border-t-green"> 
                <h4 class="col-md-8"> PADAG0000{{$rowYear['anio']}}.txt</h4>
                <div class="col-md-4 text-right">
                    <a href="{{URL::to('definitivo/txtpadag?idy='.$idy.'&name=PADAG0000'.$rowYear['anio'].'.txt')}}" class="tips btn btn-sm btn-primary btn-outline" target="_blank"><i class="fa fa-file-text-o"></i>  Generar PADAG0000{{$rowYear['anio']}}.txt</a>
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
                            </tr>
                            <tr class="bg-gray">
                                <th class="no-borders bg-white"></th>
                                <th class="text-center">Dependencia general</th>
                                <th class="text-center">Dependencia auxiliar</th>
                                <th class="text-center">Finalidad</th>
                                <th class="text-center">Función</th>
                                <th class="text-center">Subfunción</th>
                                <th class="text-center">Programa</th>
                                <th class="text-center">Subprograma</th>
                                <th class="text-center">Proyecto</th>
                                <th class="text-center">Presupuesto autorizado por proyecto</th>
                            </tr>
                            <tr v-for="(row, kc) in rowsData">
                                <td class="text-center no-borders">@{{ ++kc }}</td>
                                <td class="text-center">@{{ row.dg }}</td>
                                <td class="text-center">@{{ row.da }}</td>
                                <td class="text-center">@{{ row.fi }}</td>
                                <td class="text-center">@{{ row.fu }}</td>
                                <td class="text-center">@{{ row.sf }}</td>
                                <td class="text-center">@{{ row.pr }}</td>
                                <td class="text-center">@{{ row.sp }}</td>
                                <td class="text-center">@{{ row.py }}</td>
                                <td class="text-center">@{{ row.pre }}</td>
                            </tr>
                            <tr>
                                <th class="no-borders bg-white"></th>
                                <th class="text-right" colspan="8">TOTAL:</th>
                                <th class="text-center">@{{ total }}</th>
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
    const ComponentPbrma = { 
		template: "#component_pbrma",
		data() {
			return {
				rowsData: [],
				cancelTokenSource: null,
				total: 0,
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

				axios.get('{{ URL::to("definitivo/txtpbrma") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}"},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {

					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = response.data.data.data;
						this.total = response.data.data.total;
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