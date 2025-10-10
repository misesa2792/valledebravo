<template id="component_pbrmd">

	<section class="row m-b-lg">
		<div class="col-md-12 m-b-lg">
			<article class="ai-border-alt ai-panel">
				<div class="row">
					<div class="col-sm-12">
						<h2 style="margin-top:6px;" class="font-bold">PbRM–01d <small>Ficha Técnica de Diseño de Indicadores Estratégicos o de Gestión</small> </h2>
					</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–01d del año {{ $data['year'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

						
						<div class="col-md-12" v-for="rr in rowsData">
							<table class="table no-margins table-btn">
								<tr>
									<td class="no-borders" colspan="2">
										<span class="badge badge-warning badge-outline">@{{ rr.no_programa }}</span> <strong class="c-text"> @{{ rr.programa }}</strong> </span>
									</td>
									<td class="no-borders" width="80">
										@if($access['is_add'] == 1)
											<a href="#" class="btn btn-cta-yellow tips" @click.prevent="addProyecto(rr.id)" title="Agregar proyecto con indicadores"><span class="fa fa-plus-circle"></span> Agregar Indicadores</a>
										@endif
									</td>
								</tr>

								<tr v-if="rr.rows.length > 0">
									<td class="no-borders" width="50"></td>
									<td class="no-borders" colspan="2">
											<table class="table border-gray table-hover bg-white">
												<tbody class="no-borders" v-for="v in rr.rows">
													<tr>
														<td colspan="3" class="bg-body" width="15%"><span class="badge badge-primary badge-outline">@{{ v.no_dep_aux }}</span> @{{ v.dep_aux }}</td>
														<td colspan="4" class="bg-body"><span class="badge badge-primary badge-outline">@{{ v.no_proyecto }}</span>  @{{ v.proyecto }} </td>
														<td width="25" class="text-center c-white bg-yellow-meta">1</td>
														<td width="25" class="text-center c-white bg-green-meta">2</td>
														<td width="25" class="text-center c-white bg-blue-meta">3</td>
														<td width="25" class="text-center c-white bg-red-meta">4</td>
														<td width="50" class="no-borders bg-body"></td>
														<td width="90" class="no-borders bg-body"></td>
													</tr>
													<tr class="c-text-alt btnmostrar"  v-for="row in v.indicadores">
														<td width="40" class="text-center">
															<div class="btn-group d-none btnhover">
																<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
																<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
																	@if($access['is_edit'] == 1)
																		<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
																		<li v-if="!row.url"><a href="#" @click.prevent="moverPbrm(row.id)"><i class="fa fa-edit fun"></i> Asignar a otro proyecto</a></li>
																		<li v-if="!row.url"><a href="#" @click.prevent="removePbrm(row)"><i class="fa fa-trash-o c-danger"></i> Eliminar Indicador</a></li>
																	@endif
																	@if($access['is_reverse'] == 1)
																		<li v-if="row.url != null && row.url != ''"><a href="#" @click.prevent="undoPbrm(row)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
																	@endif
																</ul>
															</div>
														</td>
														<td class="font-ses-arial text-center">@{{ row.no_dep_aux }}</td>
														<td class="font-ses-arial text-center">@{{ row.no_proyecto }}</td>
														<td width="40">@{{ row.no_mir }}</td>
														<td class="a-line">@{{ row.indicador }}
															<div class="c-danger" v-if="!row.validate">
															Indicador eliminado en PbRM-01e, de favor valida y procede a eliminarlo del PbRM-01d
															</div>
														</td>
														<td width="120">@{{ row.formula }}</td>
														<td width="120">@{{ row.frecuencia }}</td>
														<td class="text-center">
															<span v-if="row.aplica1 == 1" :class="['fa', 'fa-check-circle', 'c-yellow-meta', 's-10', 'tips']" title="Aplica indicador"></span>
															<span v-else-if="row.aplica1 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #1"></span>
														</td>
														<td class="text-center">
															<span v-if="row.aplica2 == 1" :class="['fa', 'fa-check-circle', 'c-green-meta', 's-10', 'tips']" title="Aplica indicador"></span>
															<span v-else-if="row.aplica2 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #2"></span>
														</td>
														<td class="text-center">
															<span v-if="row.aplica3 == 1" :class="['fa', 'fa-check-circle', 'c-blue-meta', 's-10', 'tips']" title="Aplica indicador"></span>
															<span v-else-if="row.aplica3 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #3"></span>
														</td>
														<td class="text-center">
															<span v-if="row.aplica4 == 1" :class="['fa', 'fa-check-circle', 'c-red-meta', 's-10', 'tips']" title="Aplica indicador"></span>
															<span v-else-if="row.aplica4 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #4"></span>
														</td>
														<td class="text-center">
															<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" v-if="row.estatus != 0" title="Ver Información" @click.prevent="viewInfo(row.id)"></i>
														</td>
														
														<td width="80" class="text-center">
															<div v-if="row.estatus == 0">
																@if($access['is_add'] == 1)
																	<button type="button" class="btn btn-xs btn-success btn-ses btn-outline b-r-30" @click.prevent="addPbrm(row.id)"><i class="fa fa-plus-circle s-10"></i> Agregar PbRM-01d</button>
																@endif
															</div>
															<div v-else>
																<div v-if="row.url != null && row.url != ''">
																	@if($access['is_download'] == 1)
																		<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(row.url)"><i class="fa icon-file-pdf s-10"></i> Descargar PDF</button>
																	@endif
																</div>
																<div v-else>
																	@if($access['is_generate'] == 1)
																		<button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(row.id)"><i class="fa icon-file-pdf s-10"></i> Generar PDF</button>
																	@endif
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
									</td>
								</tr>
							</table>
						</div>

						
					</div>
				</div>
			</article>
		</div>
	</section>

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
			addProyecto(id){
              modalMisesa("{{ URL::to('anteproyecto/addpbrmdproy') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Agregar proyectos con indicadores","95%");
			},addPbrm(id){
              modalMisesa("{{ URL::to('anteproyecto/addpbrmd') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Agregar PbRM-01d","95%");
            },moverPbrm(id){
				modalMisesa("{{ URL::to('anteproyecto/movepbrmd') }}",{idarea: "{{ $id }}",id:id},"Asignar Indicador a otro proyecto","95%");
			},viewInfo(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmd') }}",{id:id, type: "{{ $type }}",view:'view'},"Ver información del indicador","95%");
			},createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmd') }}",{id:id, type: "{{ $type }}",view:'pdf'},"Generar PDF","95%");
			},editPbrm(id){
				modalMisesa("{{ URL::to('anteproyecto/editpbrma') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Editar PbRM-01d","95%");
			},downloadPDF(number){
              window.open("{{ URL::to('download/pdf?number=') }}"+number, '_blank');
            },downloadPDFOld(id){
                window.open("{{ URL::to('proyectopbrmd/download?k=') }}"+id, '_blank');
			},removePbrm(row){
				swal({
                  	title: "¿Estás seguro de eliminar el indicador?",
  					text: row.no_mir+" "+row.indicador,
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
						text: "Sí, eliminar indicador",
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
                      axios.delete('{{ URL::to("anteproyecto/indicador") }}',{
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
			},undoPbrm(row){
				swal({
                  	title: "¿Estás seguro de revertir el PDF?",
  					text: row.no_mir+" "+row.indicador,
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
                      axios.post('{{ URL::to("anteproyecto/reversepbrmd") }}',{
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
			},destroyPbrm(id){
				swal({
                  title : 'Estás seguro de eliminar el Registro?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.delete('{{ URL::to("anteproyecto/pbrme") }}',{
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
			rowsProjects(){

				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("anteproyecto/searchpbrmd") }}',{
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

        	},
			initTooltips() {
      			// Limpia instancias previas para evitar duplicados
				$(".tips").tooltip('destroy');

				// Inicializa de nuevo
				$(".tips").tooltip({
					container: 'body',      // evita issues de z-index dentro de modales
					html: true,             // si necesitas HTML en el tooltip
					trigger: 'hover focus', // por defecto
					placement: 'top'        // ajusta según necesites
				});
			}
		},
		mounted(){
			this.initTooltips();
			this.rowsProjects();
		},
		updated() {
			// Si tu template cambia por otras causas, asegúrate de que los tooltips sigan vivos
			this.$nextTick(() => this.initTooltips());
		},
		unmounted() {
			// Evita memory leaks al destruir el componente
			$(".tips").tooltip('destroy');
		}
	};
	
</script>