<template id="component_pbrmc">

	<section class="row m-b-lg">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
				<div class="col-sm-6">
					<h2 style="margin-top:6px;" class="font-bold">PbRM–01c</h2>
				</div>
				<div class="col-sm-6 text-right">
				
				</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–01c del año {{ $rowYear['anio'] }}
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
								<th class="no-borders" width="5"></th>
								<th class="no-borders" width="15%">Dependencia Auxiliar</th>
								<th class="no-borders text-center" width="120">No. Proyecto</th>
								<th class="no-borders">Proyecto</th>
								<th class="no-borders" width="5"></th>
								<th class="no-borders" width="5"></th>
								<th class="no-borders text-center" width="100">Presupuesto</th>
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
									<td class="text-center" width="40"> 
										<div class="btn-group d-none btnhover">
											<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
											<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
												@if($access['is_edit'] == 1)
													<li v-if="!v.url"><a href="#" @click.prevent="addPbrmc(v.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
												@endif

												@if($gp == 1  || $gp == 2)
													@if($access['is_reverse'] == 1)
														<li v-if="v.url != null && v.url != ''"><a href="#" @click.prevent="undoPbrm(v)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
													@endif
												@endif
											</ul>
										</div>
									</td>
									<td>@{{ v.no_dep_aux }} @{{ v.dep_aux }}</td>
									<td>@{{ v.no_proyecto }}</td>
									<td class="a-line">@{{ v.proyecto }}</td>
									<td class="text-center" width="20">
										<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" v-if="v.estatus != 1" title="Ver Información" @click.prevent="viewInfo(v.id)"></i>
									</td>
									<td class="text-right">$</td>
									<td class="text-right">@{{ v.presupuesto }}</td>
									<td width="70" class="text-center">
										<div v-if="v.estatus == 1">
											@if($idy != 4)
                                                @if($access['is_add'] == 1)
													<button type="button" class="btn btn-xs btn-success btn-ses btn-outline b-r-30" @click.prevent="addPbrmc(v.id)"><i class="fa fa-plus-circle"></i> Agregar PbRM-01c</button>
												@endif
											@endif
										</div>
										<div v-else>

											<div v-if="v.url != null && v.url != ''">
                                                @if($access['is_download'] == 1)
													<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(v)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
												@endif
											</div>
											<div v-else>
												@if($idy != 4)
                                                	@if($access['is_generate'] == 1)
														<button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(v.id)"><i class="fa icon-file-pdf s-12"></i> Generar PDF</button>
													@endif
												@endif
											</div>

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
    const ComponentPbrmc = { 
		template: "#component_pbrmc",
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

				axios.get('{{ URL::to("anteproyecto/searchc") }}',{
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

        	},downloadPDF(row){
				if(this.idy == 4){
                    window.open("{{ URL::to('proyectopbrmc/download?k=') }}"+row.id, '_blank');
				}else{
               		window.open("{{ URL::to('download/pdf?number=') }}"+row.url, '_blank');
				}
            },viewInfo(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmc') }}",{id:id,type:"{{ $type }}", view:'view'},"Ver Información","95%");
			},createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmc') }}",{id:id,type:"{{ $type }}", view:'pdf'},"Generar PDF","95%");
			},addPbrmc(id){
				modalMisesa("{{ URL::to('anteproyecto/addpbrmc') }}",{id: id},"Agregar PbRM-01c","95%");
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
                      axios.post('{{ URL::to("anteproyecto/reversepbrmc") }}',{
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
			this.idy = "{{$idy}}";
			this.rowsProjects();
		}
	};
</script>