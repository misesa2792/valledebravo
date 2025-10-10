<template id="component_plan">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          <div class="sbox-title border-t-blue"> <i class="icon-pie4 c-text-alt s-12 p-b-i"></i> <strong class="p-xs c-text-alt">Planeación APDM - ARPPPDM - PMPDM</strong></div>
          <div class="sbox-content bg-white"> 	

			<div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com">
				<div class="col-md-4 no-padding">
					@if($access['is_add'] == 1)
						<a href="#" class="tips btn btn-sm btn-primary btn-outline btn-ses" @click.prevent="addPbrm()" title="Agregar Programas"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Programas</a>
					@endif
				</div>

				<div class="col-md-8">
					<div v-if="rowsData.length == 0" class="c-text-alt s-14">No se encontraron APDM - ARPPPDM - PMPDM  del año {{ $data['year'] }}!</div>
				</div>
			</div>

			<div class="col-md-12 no-padding m-t-md" v-if="rowsData.length > 0">
				 <table class="table table-hover no-margins border-gray " >
					<thead>
						<tr class="t-tr-s12 c-text-alt">
							<td class="no-borders" width="30">#</td>
							<td class="no-borders text-center" width="80">No. Programa</td>
							<td class="no-borders">Programa</td>
							<td class="no-borders text-center" width="140">APDM</td>
							<td class="no-borders text-center" width="140">ARPPPDM</td>
							<td class="no-borders text-center" width="140">PMPDM</td>
						</tr>
					</thead>
			
					<tbody>
						<template v-for="v in rowsData">
							<tr class="t-tr-s12">
								<td>
									<div class="btn-group" v-if="v.std_apdm == 1 && v.std_arpppdm == 1 && v.std_pmpdm == 1">
										<button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
										<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
											@if($access['is_remove'] == 1)
												<li><a href="#" @click.prevent="destroyprograma(v.id)"> <i class="fa fa-trash-o c-danger"></i> Eliminar</a></li>
											@endif
										</ul>
									</div>
								</td>
								<td class="c-text">@{{ v.no_programa }}</td>
								<td class="c-text">@{{ v.programa }}</td>
								<td>
									@if($access['is_add'] == 1)
										<button v-if="v.std_apdm == 1" type="button" class="btn btn-ses btn-danger btn-outline full-width " @click.prevent="addapdm(v.id)"><i class="fa fa-plus-circle"></i> Agregar APDM</button>
										<button v-else type="button" class="btn btn-ses btn-success btn-outline full-width" @click.prevent="addapdm(v.id)"><i class="fa fa-edit"></i> Editar APDM</button>
									@endif
								</td>
								<td>
									@if($access['is_add'] == 1)
										<button v-if="v.std_arpppdm == 1" type="button" class="btn btn-ses btn-danger btn-outline full-width" @click.prevent="addarpppdm(v.id)"><i class="fa fa-plus-circle"></i> Agregar ARPPPDM</button>
										<button v-else type="button" class="btn btn-ses btn-success btn-outline full-width" @click.prevent="addarpppdm(v.id)"><i class="fa fa-edit"></i> Editar ARPPPDM</button>
									@endif
								</td>
								<td>
									@if($access['is_add'] == 1)
										<button v-if="v.std_pmpdm == 1" type="button" class="btn btn-ses btn-danger btn-outline full-width" @click.prevent="addpmpdm(v.id)"><i class="fa fa-plus-circle"></i> Agregar PMPDM</button>
										<button v-else type="button" class="btn btn-ses btn-success btn-outline full-width" @click.prevent="addpmpdm(v.id)"><i class="fa fa-edit"></i> Editar PMPDM</button>
									@endif
								</td>
							</tr>
						</template>
					</tbody>
				</table>
				
			</div>
            
          </div>
        </div>		 
      </section>
		
		</div>
	</div>
</template>

<script>
    const ComponentPlan = { 
		template: "#component_plan",
		data() {
			return {
				rowsData: [],
				cancelTokenSource: null
			};
		},
		methods:{
			addPbrm(){
              modalMisesa("{{ URL::to('anteproyecto/addpprograma') }}",{idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},"Agregar Programas","95%");
            },
			rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}
				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("anteproyecto/searchplan") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},
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
			addarpppdm(id){
                modalMisesa('{{ URL::to("anteproyecto/addarpppdm") }}',{id:id, type: "{{ $type }}"},"Agregar ARPPPDM","95%");
            },
			addpmpdm(id){
                modalMisesa('{{ URL::to("anteproyecto/addpmpdm") }}',{id:id, type: "{{ $type }}"},"Agregar PMPDM","95%");
            },
			addapdm(id){
                modalMisesa('{{ URL::to("anteproyecto/addappdm") }}',{id:id, idy: "{{ $idy }}", type: "{{ $type }}"},"Agregar APPDM","95%");
			}
		},
		mounted(){
			this.rowsProjects();
		}
	};
</script>