<template id="component_pbrmaa">

	
	<section class="row">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
				<div class="col-sm-12">
					<h2 style="margin-top:6px;" class="font-bold">PbRM–02a <small>Calendarización de Metas de actividad por Proyecto</small> </h2>
				</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–02a del año {{ $data['year'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

					<table class="table table-hover no-margins">
							<tbody>
								<template v-for="rr in rowsData">
									<tr>
										<td colspan="5" class="no-borders">
											<span class="badge badge-success badge-outline">@{{ rr.no_dep_aux }}</span>  <strong class="c-text">@{{ rr.dep_aux }}</strong>
										</td>
									</tr>
									<tr v-for="v in rr.data" class="t-tr-s12 c-text-alt btnmostrar">
										<td class="text-center no-borders" width="40">
												<div class="btn-group d-none btnhover" v-if="v.c_estatus == 2">
													<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
													<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
														@if($access['is_edit'] == 1)
															<li v-if="!v.url"><a href="#" @click.prevent="addPbrmaa(v.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
														@endif
														@if($access['is_reverse'] == 1)
															<li v-if="v.url != null && v.url != ''"><a href="#" @click.prevent="undoPbrm(v)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
														@endif
													</ul>
												</div>
										</td>
										<td width="50" class="no-borders">@{{ v.no_proyecto }}</td>
										<td class="a-line no-borders">@{{ v.proyecto }}</td>
										<td class="text-center no-borders" width="20">
											<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" v-if="v.estatus != 1" title="Ver Información" @click.prevent="viewInfo(v.id)"></i>
										</td>
										<td width="70" class="text-center no-borders">
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
													<button type="button" class="btn btn-xs btn-warning btn-ses btn-outline b-r-30" disabled> Pendiente PbRM-01c</button>
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

				axios.get('{{ URL::to("anteproyecto/searchpbrmaa") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},
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

        	},addPbrmaa(id){
				modalMisesa("{{ URL::to('anteproyecto/addpbrmaa') }}",{id: id},"Agregar PbRM-02a","95%");
			},viewInfo(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmaa') }}",{id:id,type:"{{ $type }}", view:'view'},"Ver información","95%");
			},createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmaa') }}",{id:id,type:"{{ $type }}", view:'pdf'},"Generar PDF","95%");
			},downloadPDF(row){
				if(this.idy == 4){//Año 2025 que esta en otra tabla
                    window.open("{{ URL::to('proyectopbrmaa/download?k=') }}"+row.id, '_blank');
                }else{
              		window.open("{{ URL::to('download/pdf?number=') }}"+row.url, '_blank');
                }
            },undoPbrm(row){
				swal({
                  	title: "¿Estás seguro de revertir el PDF?",
  					text: row.no_proyecto+" "+row.proyecto,
					icon : 'warning',
					buttons: {
						cancel: {
						text: "No, Cancelar",
						value: null,
						visible: true,
						className: "btn btn-secondary",
						closeModal: true,
						},
						confirm: {
						text: "Sí, revertir PDF",
						value: true,
						visible: true,
						className: "btn btn-danger",
						closeModal: true
						}
					},
					dangerMode : true,
					closeOnClickOutside: false
              }).then((willDelete) => {
                  if(willDelete){
                      axios.post('{{ URL::to("anteproyecto/reversepbrmaa") }}',{
                          params : {id: row.id}
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
			}
		},
		mounted(){
			this.idy = "{{ $idy }}";
			this.rowsProjects();
		}
	};
</script>