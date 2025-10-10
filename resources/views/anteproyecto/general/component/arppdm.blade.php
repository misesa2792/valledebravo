<template id="component_arppdm">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          <div class="sbox-title border-t-blue"> <i class="icon-pie4 c-text-alt s-12 p-b-i"></i> <strong class="p-xs c-text-alt">Planeación ARPPPDM</strong></div>
          <div class="sbox-content bg-white"> 	

			<div class="row p-xs">
				<div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com" v-if="rowsData.length == 0">
					<div  class="c-text-alt s-14">No se encontraron ARPPPDM del año !</div>
				</div>

				<div class="col-md-12 no-padding" v-if="rowsData.length > 0">
					<table class="table table-hover no-margins border-gray " >
						<thead>
							<tr class="t-tr-s12 c-text-alt">
								<td class="no-borders" width="30">#</td>
								<td class="no-borders text-center" width="80">No. Dep. Gen</td>
								<td class="no-borders text-center" width="80">No. Programa</td>
								<td class="no-borders">Programa</td>
								<td class="no-borders" width="5"></td>
								<td class="no-borders text-center">Presupuesto
									<div>{{ $rowYear['anio'] - 2 }}</div>
								</td>
								<td class="no-borders" width="5"></td>
								<td class="no-borders text-center">Presupuesto
									<div>{{ $rowYear['anio'] - 1 }}</div>
								</td>
								<td class="no-borders" width="5"></td>
								<td class="no-borders text-center">Presupuesto
									<div>{{ $rowYear['anio'] }}</div>
								</td>
								<td class="no-borders text-center" width="80">Acción</td>
							</tr>
						</thead>
				
						<tbody>
							<template v-for="(v , keyv) in rowsData">
								<tr class="t-tr-s12">
									<td>@{{ ++keyv }}</td>
									<td class="c-text text-center">@{{ v.no_dep_gen }}</td>
									<td class="c-text font-ses-monospace">@{{ v.no_programa }}</td>
									<td class="c-text">@{{ v.programa }}</td>
                                    <td class="text-right">$</td>
									<td class="c-text text-right">@{{ v.pres_1 }}</td>
                                    <td class="text-right">$</td>
									<td class="c-text text-right">@{{ v.pres_2 }}</td>
                                    <td class="text-right">$</td>
									<td class="c-text text-right">@{{ v.pres_3 }}</td>
									<td class="text-center">
										
									</td>
								</tr>
							</template>
						</tbody>
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

    const ComponentArppdm = { 
		template: "#component_arppdm",
		data() {
			return {
				rowsData: [],
				cancelTokenSource: null
			};
		},
		methods:{
			rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}
				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("anteproyecto/searcharppdm") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}"},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {

					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = response.data.data;
					}else{
						toastr.error(row.message);
					}
				
				}).catch(error => {
				}).finally(() => {
				});

        	},destroyprograma(id){
				swal({
                  title : 'Estás seguro de eliminar el Registro?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.delete('{{ URL::to("anteproyecto/plan") }}',{
                          params : {id:id}
                      }).then(response => {
                          let row = response.data;
                          if(row.status == "ok"){
                            this.rowsProjects();
							toastr.success(row.message);
                          }else{
							toastr.error(row.message);
						  }
                      })
                  }
              })
			},
			
		},
		mounted(){
			this.rowsProjects();
		}
	};
</script>