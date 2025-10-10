<template id="component_pbrmd">

	<section class="row">
		<div class="col-md-12 ">
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

						@if($idy == 4)
							<table class="table border-gray table-hover no-margins">
								<tbody>
									<template v-for="rr in rowsData">
										<tr>
											<td colspan="8" class="no-borders">
												<span class="badge badge-warning badge-outline">@{{ rr.no_dep_aux }}</span>  <strong class="c-text">@{{ rr.dep_aux }}</strong>
											</td>
											
										</tr>
										<tr class="t-tr-s12 c-text-alt" v-for="v in rr.data">
											<td width="30" class="no-borders"></td>
											<td class="text-center no-borders" width="50">@{{ v.no_proyecto }}</td>
											<td class="no-borders">@{{ v.proyecto }}</td>
											<td class="no-borders">@{{ v.indicador }}</td>
											<td width="80" class="no-borders">@{{ v.frecuencia }}</td>
											<td width="70" class="no-borders text-center">
												<div v-if="v.url != null && v.url != ''">
													@if($access['is_download'] == 1)
														<button type="button" class="btn btn-xs btn-danger btn-ses btn-outline b-r-30" @click.prevent="downloadPDFOld(v.id)"><i class="fa icon-file-pdf s-12"></i> Descargar PDF</button>
													@endif
												</div>
											</td>
										</tr>
									</template>

									
								</tbody>
							</table>
						@else
						
						<div class="col-md-12" v-for="rr in rowsData">
							<table class="table no-margins table-btn">
								<tr>
									<td colspan="6" class="no-borders">
										<span class="badge badge-warning badge-outline">@{{ rr.no_programa }}</span>  <strong class="c-text">@{{ rr.programa }}</strong>
									</td>
									<td class="no-borders">
										@if($access['is_add'] == 1)
											<a href="#" class="btn btn-cta-yellow" @click.prevent="addProyecto(rr.id)" title="Agregar proyecto con indicadores"><span class="fa fa-plus-circle"></span> Agregar Indicadores</a>
										@endif
									</td>
								</tr>

								<tr>
									<td width="40" class="no-borders"></td>
									<td class="no-borders">
										<div v-for="m in rr.data">
											<table class="table border-gray table-hover bg-white">
												<thead>
													<tr>
														<th colspan="2" class="c-text-alt"></th>
														<th class="c-text-alt text-center">Dependencia <div>Auxiliar</div></th>
														<th class="c-text-alt text-center">Proyecto</th>
														<th colspan="4" class="c-text-alt">Indicadores</th>
														<td width="25" class="text-center c-white bg-yellow-meta">1</td>
														<td width="25" class="text-center c-white bg-green-meta">2</td>
														<td width="25" class="text-center c-white bg-blue-meta">3</td>
														<td width="25" class="text-center c-white bg-red-meta">4</td>
														<td width="50" class="no-borders"></td>
														<td width="90" class="no-borders"></td>
													</tr>
												</thead>
												<tr class="c-text-alt btnmostrar" v-for="row in m.rows.fin">
													<td class="border-gray text-center-middle text-right" width="5%">Fin</td>
													<td width="40" class="text-center">
														<div class="btn-group d-none btnhover">
															<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
															<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
																@if($access['is_edit'] == 1)
																	<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
																	<li v-if="!row.url"><a href="#" @click.prevent="moverPbrm(row.id)"><i class="fa fa-edit fun"></i> Asignar a otro proyecto</a></li>
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


												<tr class="c-text-alt btnmostrar" v-for="row in m.rows.proposito">
													<td class="border-gray text-center-middle text-right">Proposito</td>
													<td width="40" class="text-center">
														<div class="btn-group d-none btnhover">
															<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
															<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
																@if($access['is_edit'] == 1)
																	<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
																	<li v-if="!row.url"><a href="#" @click.prevent="moverPbrm(row.id)"><i class="fa fa-edit fun"></i> Asignar a otro proyecto</a></li>
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

												<tr class="c-text-alt btnmostrar" v-for="(row,kc) in m.rows.componente">
													<td class="border-gray text-center-middle text-right" v-if="kc == 0" :rowspan="m.rows.componente.length">Componente </td>
													<td width="40" class="text-center">
														<div class="btn-group d-none btnhover">
															<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
															<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
																@if($access['is_edit'] == 1)
																	<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
																	<li v-if="!row.url"><a href="#" @click.prevent="moverPbrm(row.id)"><i class="fa fa-edit fun"></i> Asignar a otro proyecto</a></li>
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

												<tr class="c-text-alt btnmostrar" v-for="(row,ka) in m.rows.actividad">
													<td class="border-gray text-center-middle text-right" v-if="ka == 0" :rowspan="m.rows.actividad.length">Actividad</td>
													<td width="40" class="text-center">
														<div class="btn-group d-none btnhover">
															<button type="button" class="btn btn-xs btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
															<ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
																@if($access['is_edit'] == 1)
																	<li v-if="!row.url"><a href="#" @click.prevent="addPbrm(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
																	<li v-if="!row.url"><a href="#" @click.prevent="moverPbrm(row.id)"><i class="fa fa-edit fun"></i> Asignar a otro proyecto</a></li>
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

											</table>
										</div>
									</td>
								</tr>
							</table>
						</div>

						@endif
						
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