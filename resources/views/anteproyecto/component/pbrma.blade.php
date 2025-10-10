<template id="component_pbrma">

    <section class="row">

	    <div class="col-md-12 ">
		
		<article class="ai-border-alt ai-panel">
			<div class="row">
			<div class="col-sm-8">
				<h2 style="margin-top:6px;" class="font-bold">PbRM–01a <small>Dimensión Administrativa del Gasto</small> </h2>
			</div>
			<div class="col-sm-4 text-right">
                @if($access['is_add'] == 1)
                    <a href="#" class="btn btn-cta" @click.prevent="addPbrm()" title="Agregar Pbrm-01a"><span class="fa fa-plus-circle"></span> Agregar PbRM–01a</a>
                @endif
			</div>
			</div>

            <div v-if="rowsData.length == 0">

                <div class="poa-empty" style="margin-top:14px;">
                    <div>
                        <span class="glyphicon glyphicon-inbox" style="font-size:28px; opacity:.6;"></span>
                        <p class="muted" style="margin:10px 0 0;">
                        No se encontraron formatos PbRM–01a del año {{ $data['year'] }}
                        </p>
                    </div>
			    </div>
            </div>

             <div class="row poa-body" v-if="rowsData.length > 0">
                <div class="col-md-12">
                      <table class="table table-hover border-gray no-margins" >
                            <thead>
                                <tr class="t-tr-s12 c-text-alt">
                                    <th class="no-borders" width="40"></th>
                                    <th class="no-borders text-center" width="120">No. Programa</th>
                                    <th class="no-borders">Programa</th>
                                    <th class="no-borders" width="5"></th>
                                    <th class="no-borders text-center" width="100">Presupuesto</th>
                                    <th class="no-borders text-center" width="80">Acción</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                <tr class="t-tr-s12 c-text-alt btnmostrar" v-for="row in rowsData">
                                    <td class="text-center">
                                        <div class="btn-group  d-none btnhover">
                                            <button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                                            <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                                @if($access['is_edit'] == 1)
                                                    <li v-if="!row.url"><a href="#" @click.prevent="editPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
                                                @endif
                                                @if($access['is_reverse'] == 1)
                                                    <li v-if="row.url != null && row.url != ''"><a href="#" @click.prevent="undoPbrm(row)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
                                                @endif
                                                @if($access['is_remove'] == 1)
                                                    <li v-if="!row.url"><a href="#" @click.prevent="destroyPbrm(row.id)"><i class="fa fa-trash-o var"></i> Eliminar</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="text-center">@{{ row.no_programa }}</td>
                                    <td class="a-line">@{{ row.programa }}</td>
                                    <td class="text-right">$</td>
                                    <td class="text-right">@{{ row.total }}</td>
                                    <td class="text-center">
                                        <div v-if="row.url != null && row.url != ''">
                                            @if($access['is_download'] == 1)
                                                <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDF(row)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
                                            @endif
                                        </div>
                                        <div v-else>
                                            @if($access['is_generate'] == 1)
                                                <button type="button" class="btn btn-xs btn-default btn-ses btn-outline b-r-30" @click.prevent="createPDF(row.id)"><i class="fa icon-file-pdf s-12"></i> Generar PDF</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr class="t-tr-s12 c-text-alt">
                                    <th colspan="3" class="text-right">TOTAL:</th>
                                    <th width="5" class="c-text">$</th>
                                    <th class="c-text-alt text-right">@{{ total }}</th>
                                    <th></th>
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
			addPbrm(){
              modalMisesa("{{ URL::to('anteproyecto/addpbrma') }}",{idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},"Agregar PbRM-01a","95%");
            },
			rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}
				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("anteproyecto/searchpbrma") }}',{
					params : {idy: "{{ $idy }}", type: "{{ $type }}", id: "{{ $id }}"},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {

					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = row.data.data;
						this.total = row.data.total;
					}else{
						toastr.error(row.message);
					}
				
				}).catch(error => {
				}).finally(() => {
				});

        	},
            createPDF(id){
				modalMisesa("{{ URL::to('anteproyecto/generatepbrma') }}",{id:id, type: "{{ $type }}"},"Generar PDF","95%");
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
                      axios.post('{{ URL::to("anteproyecto/reversepbrma") }}',{
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
			},editPbrm(id){
				modalMisesa("{{ URL::to('anteproyecto/editpbrma') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Editar PbRM-01a","95%");
			},downloadPDF(row){
                if(this.idy == 4){//Año 2025 que esta en otra tabla
                    window.open("{{ URL::to('proyectopbrma/download?k=') }}"+row.id, '_blank');
                }else{
                    window.open("{{ URL::to('download/pdf?number=') }}"+row.url, '_blank');
                }
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
                      axios.delete('{{ URL::to("anteproyecto/pbrma") }}',{
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
			}
		},
		mounted(){
            this.idy = "{{ $idy }}";
			this.rowsProjects();
		}
	};
</script>