<template id="component_pbrme">

	<section class="row">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
					<div class="col-sm-8">
						<h2 style="margin-top:6px;" class="font-bold">PbRM–01e <small>Matriz de Indicadores para Resultados por Programa presupuestario y Dependencia General</small> </h2>
					</div>
					<div class="col-sm-4 text-right">
							@if($access['is_add'] == 1)
								<a href="#" class="btn btn-cta-yellow" @click.prevent="addPbrm()" title="Agregar Pbrm-01e"><span class="fa fa-plus-circle"></span> Agregar PbRM–01e</a>
							@endif
					</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–01e del año {{ $data['year'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

						<table class="table table-hover no-margins table-btn">
							<thead>
                                <tr class="t-tr-s12 c-text-alt">
                                    <th class="no-borders" width="40"></th>
                                    <th class="no-borders text-center" width="120">No. Programa</th>
                                    <th class="no-borders">Programa</th>
                                    <th class="no-borders text-center" width="80">Acción</th>
                                </tr>
                            </thead>
						<tbody>
							<template v-for="v in rowsData">
								<tr class="t-tr-s12 c-text-alt btnmostrar">
									<td class="text-center no-borders" width="40">
											<div class="btn-group d-none btnhover">
												<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
												<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
													@if($access['is_edit'] == 1)
														<li v-if="!v.url"><a href="#" @click.prevent="editPbrm(v.id)"><i class="fa fa-edit c-blue"></i> Editar</a></li>
													@endif
													@if($access['is_reverse'] == 1)
														<li v-if="v.url != null && v.url != ''"><a href="#" @click.prevent="undoPbrm(v)"><i class="fa fa-exchange lit"></i> Revertir PDF</a></li>
													@endif
													@if($access['is_remove'] == 1)
														<li v-if="!v.url"><a href="#" @click.prevent="destroyPbrm(v.id)"><i class="fa fa-trash-o c-danger"></i> Eliminar</a></li>
													@endif
												</ul>
											</div>
									</td>
									<td class="text-center no-borders" width="50">@{{ v.no_programa }}</td>
									<td class="a-line no-borders">@{{ v.programa }}</td>
									<td class="text-center no-borders" width="30">
										<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" title="Ver Información" @click.prevent="viewInfo(v.id)"></i>
									</td>
									<td width="70" class="text-center no-borders">
										<div v-if="v.url != null && v.url != ''">
											@if($access['is_download'] == 1)
												<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(v)"><i class="fa icon-file-pdf s-10"></i> Descargar PDF</button>
											@endif
										</div>
										<div v-else>
												@if($access['is_generate'] == 1)
													<button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(v.id)"><i class="fa icon-file-pdf s-10"></i> Generar PDF</button>
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
			addPbrm(){
              modalMisesa("{{ URL::to('anteproyecto/addpbrme') }}",{idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},"Agregar PbRM-01e","95%");
            },viewInfo(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrme') }}",{id:id, type: "{{ $type }}",view:'view'},"Ver información de la matriz","95%");
			},createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrme') }}",{id:id, type: "{{ $type }}",view:'pdf'},"Generar PDF","95%");
			},editPbrm(id){
				modalMisesa("{{ URL::to('anteproyecto/editpbrme') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Editar PbRM-01e","95%");
			},downloadPDF(row){
				if(this.idy == 4){//Año 2025 que esta en otra tabla
                    window.open("{{ URL::to('proyectopbrme/download?k=') }}"+row.id, '_blank');
                }else{
              		window.open("{{ URL::to('download/pdf?number=') }}"+row.url, '_blank');
                }
            },undoPbrm(row){
				swal({
					title: "¿Estás seguro de revertir el PDF?",
  					text: row.no_programa+" "+row.programa,
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
                      axios.post('{{ URL::to("anteproyecto/reversepbrme") }}',{
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
					buttons: {
						cancel: {
						text: "No, Cancelar",
						value: null,
						visible: true,
						className: "btn btn-secondary",
						closeModal: true,
						},
						confirm: {
						text: "Sí, eliminar registro",
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

				axios.get('{{ URL::to("anteproyecto/searchpbrme") }}',{
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
        	}	
		},
		mounted(){
			this.idy = "{{$idy}}";
			this.rowsProjects();
		}
	};
</script>