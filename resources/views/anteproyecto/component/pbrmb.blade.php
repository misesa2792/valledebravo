<template id="component_pbrmb">

	<section class="row">
		<div class="col-md-12 ">
			<article class="ai-border-alt ai-panel">
				<div class="row">
				<div class="col-sm-8">
					<h2 style="margin-top:6px;" class="font-bold">PbRM–01b <small>Descripción del Programa presupuestario</small> </h2>
				</div>
				<div class="col-sm-4 text-right">
						@if($access['is_add'] == 1)
                    		<a href="#" class="btn btn-cta-danger" @click.prevent="addPbrm()" title="Agregar Pbrm-01b"><span class="fa fa-plus-circle"></span> Agregar PbRM–01b</a>
						@endif
				</div>
				</div>

				<div v-if="rowsData.length == 0" >

					<div class="poa-empty" style="margin-top:14px;">
						<div>
							<span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
							<p class="muted" style="margin:10px 0 0;">
							No se encontraron formatos PbRM–01b del año {{ $data['year'] }}
							</p>
						</div>
					</div>
				</div>

				<div class="row poa-body" v-else>
					<div class="col-md-12">

						<table class="table table-hover border-gray no-margins">
						<thead>
							<tr class="t-tr-s12 c-text-alt">
								<th class="no-borders" width="40"></th>
								<th class="no-borders text-center" width="120">No. Programa</th>
								<th class="no-borders">Programa</th>
								<th class="no-borders" width="100"></th>
								<th class="no-borders text-center" width="80">Acción</th>
							</tr>
						</thead>
				
						<tbody>
							<tr class="t-tr-s12 c-text-alt btnmostrar" v-for="rr in rowsData">
								<td class="text-center">
										<div class="btn-group d-none btnhover">
											<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
											<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
												@if($access['is_edit'] == 1)
													<li v-if="!rr.url"><a href="#" @click.prevent="editPbrm(rr.id)"><i class="fa fa-edit c-blue"></i> Editar</a></li>
												@endif
												@if($access['is_reverse'] == 1)
													<li v-if="rr.url != null && rr.url != ''"><a href="#" @click.prevent="undoPbrm(rr)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
												@endif
												@if($access['is_remove'] == 1)
													<li v-if="!rr.url"><a href="#" @click.prevent="destroyPbrm(rr.id)"><i class="fa fa-trash-o c-danger"></i> Eliminar</a></li>
												@endif
											</ul>
										</div>
								</td>
								<td class="text-center">@{{ rr.no_programa }}</td>
								<td class="a-line">@{{ rr.programa }}</td>
								<td class="text-center">
									<i class="icon-file6 c-text-alt s-12 cursor tips d-none btnhover" title="Ver Información" @click.prevent="viewInfo(rr.id)"></i>
								</td>
								<td class="text-center">
									<div v-if="rr.url != null && rr.url != ''">
										@if($access['is_download'] == 1)
											<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(rr)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
										@endif
									</div>
									<div v-else>
											@if($access['is_generate'] == 1)
												<button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(rr.id)"><i class="fa icon-file-pdf s-12"></i> Generar PDF</button>
											@endif
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					
					</div>
				</div>
			</article>
		</div>
	</section>

</template>

<script>
    const ComponentPbrmb = { 
		template: "#component_pbrmb",
		data() {
			return {
				rowsData : [],
            	cancelTokenSource: null,
				idy: 0
			};
		},
		methods:{
			addPbrm(){
              modalMisesa("{{ URL::to('anteproyecto/addpbrmb') }}",{idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},"Agregar PbRM-01b","95%");
            },viewInfo(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmb') }}",{id:id, type: "{{ $type }}", view: 'view'},"Ver infomación del FODA","95%");
			},createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrmb') }}",{id:id, type: "{{ $type }}", view: 'pdf'},"Generar PDF","95%");
			},editPbrm(id){
				modalMisesa("{{ URL::to('anteproyecto/editpbrmb') }}",{idy: "{{ $idy }}", type: "{{ $type }}",id:id, idarea:"{{ $id }}"},"Editar PbRM-01a","95%");
			},downloadPDF(row){
				if(this.idy == 4){//Año 2025 que esta en otra tabla
                    window.open("{{ URL::to('proyectopbrmb/download?k=') }}"+row.id, '_blank');
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
                      axios.post('{{ URL::to("anteproyecto/reversepbrmb") }}',{
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
                      axios.delete('{{ URL::to("anteproyecto/pbrmb") }}',{
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

				axios.get('{{ URL::to("anteproyecto/searchpbrmb") }}',{
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
			this.idy = "{{ $idy }}";
			this.rowsProjects();
		}
	};
</script>