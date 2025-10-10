<template id="component_pbrmd">
	<section class="page-content-wrapper no-padding">
        <div class="sbox">
          <div class="sbox-title border-t-yellow"> <i class="icon-tree2 c-text-alt s-12 p-b-i"></i> <strong class="p-xs c-text-alt">PbRM-01d</strong></div>
          <div class="sbox-content bg-white"> 	

			<div class="row">
			@if($idy == 4)
				<div class="col-md-12">

					<table class="table border-gray no-margins">
						<thead>
							<tr class="t-tr-s12 c-text-alt">
								<th class="no-borders">Dependencia Auxiliar</th>
								<th class="no-borders">Programa</th>
								<th class="no-borders">Proyecto</th>
								<th class="no-borders">Indicador</th>
								<th class="no-borders">Frecuencia</th>
								<th class="no-borders">Acción</th>
							</tr>
						</thead>
				
						<tbody>
							<tr class="t-tr-s12 c-text-alt" v-for="rr in rowsData">
								<td>
									<div class="font-bold">@{{ rr.no_dep_aux }}</div>
									<div>@{{ rr.dep_aux }}</div>	
								</td>
								<td>
									<div class="font-bold">@{{ rr.no_programa }}</div>
									<div>@{{ rr.programa }}</div>
								</td>
								<td>
									<div class="font-bold">@{{ rr.no_proyecto }}</div>
									<div>@{{ rr.proyecto }}</div>
								</td>
								<td>@{{ rr.indicador }}</td>
								<td>@{{ rr.frecuencia }}</td>
								<td>
									<div v-if="rr.url != null && rr.url != ''">
										@if($access['is_download'] == 1)
											<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width" @click.prevent="downloadPDFOld(rr.id)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
										@endif
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				
				</div>
			@else

				<div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto com">
					<div class="col-md-4 no-padding">
					</div>

					<div class="col-md-8 no-padding ">
						<div v-if="rowsData.length == 0" class="c-text-alt s-14"> 
							No se encontraron PbRM-01d del año {{ $data['year'] }}
						</div>
					</div>
				</div>

				<div class="col-md-12" v-if="rowsData.length > 0">

					<table class="table border-gray table-hover" v-for="rr in rowsData">
						<thead>
							<tr>
								<td colspan="5" class="c-blue no-padding">
									<table class="table no-margins">
										<tr>
											<td class="no-borders" width="20%">@{{ rr.no_dep_aux }} @{{ rr.dep_aux }}</td>
											<td class="no-borders" width="80%"> <span class="badge badge-primary badge-outline"> @{{ rr.no_proyecto }}</span> @{{ rr.proyecto }}</td>
										</tr>
									</table>
								</td>
								<td width="25" class="text-center c-white bg-yellow-meta">1</td>
								<td width="25" class="text-center c-white bg-green-meta">2</td>
								<td width="25" class="text-center c-white bg-blue-meta">3</td>
								<td width="25" class="text-center c-white bg-red-meta">4</td>
								<td width="50"></td>
								<td class="text-center c-text-alt">Acción</td>
							</tr>
						</thead>
						<tr class="c-text-alt btnmostrar" v-for="row in rr.rows">
							<td width="40" class="text-center">
								<div class="btn-group d-none btnhover">
									<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
									<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
										@if($access['is_edit'] == 1)
											<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
										@endif
										@if($access['is_reverse'] == 1)
											<li v-if="row.url != null && row.url != ''"><a href="#" @click.prevent="undoPbrm(row)"><i class="fa fa-exchange lit"></i> Revertir</a></li>
										@endif
									</ul>
								</div>
							</td>
							<td width="40">@{{ row.no_mir }}</td>
							<td class="a-line">@{{ row.indicador }}</td>
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
							
							<td width="80">
								<div v-if="row.estatus == 0">
									@if($access['is_add'] == 1)
										<button type="button" class="btn btn-xs btn-success btn-ses btn-outline full-width" @click.prevent="addPbrm(row.id)"><i class="fa fa-plus-circle s-10"></i> Agregar PbRM-01d</button>
									@endif
								</div>
								<div v-else>
									<div v-if="row.url != null && row.url != ''">
										@if($access['is_download'] == 1)
											<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width" @click.prevent="downloadPDF(row.url)"><i class="fa icon-file-pdf s-10"></i> Descargar PDF</button>
										@endif
									</div>
									<div v-else>
										@if($access['is_generate'] == 1)
											<button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width" @click.prevent="createPDF(row.id)"><i class="fa icon-file-pdf s-10"></i> Generar PDF</button>
										@endif
									</div>
								</div>
							</td>
						</tr>
					</table>
				
				</div>
			@endif

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
			addPbrm(id){
              modalMisesa("{{ URL::to('anteproyecto/addpbrmd') }}",{idy: "{{ $idy }}", type: "{{ $type }}", idarea: "{{ $id }}",id:id},"Agregar PbRM-01d","95%");
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