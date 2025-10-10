@extends('layouts.app')

@section('content')

<main class="page-content row bg-body">
    <!-- Page header -->
	<div class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
		</div>

		<ul class="breadcrumb bg-body s-20">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i>  </a></li>
			<li>{{ $rowsInstituciones[0]->descripcion }}</li>
			<li>{{ $anio }}</li>
			<li>{{ $pageTitle }}</li>
			<li class="active">PDM</li>
		</ul>	  
	</div>
	
	<div class="toolbar-line">
		<div class="col-md-12 m-b-md">
			<button type="button" onclick="location.href='{{ URL::to($pageModule.'?k='.SiteHelpers::CF_encode_json(array('idi'=>$idi)) )}}' " class="btn btn-default btn-xs b-r-30 tips" title="Regresar"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
		</div>
	</div> 

	<section class="table-resp m-b-lg" style="min-height:300px;" id="app_alinear">
		<div class="col-sm-12 col-md-10 col-lg-12" v-for="row in info">

			<div class="col-sm-12 col-md-12 col-lg-12 bg-white p-md b-b-gray s-16" :style="'border-left:4px solid var('+row.color+');'">
				<div class="col-sm-5 col-md-5 col-lg-6 font-bold c-text-alt">@{{ row.pilares }}</div>
				<div class="col-sm-4 col-md-4 col-lg-3 c-text-alt">@{{ row.tipo }}</div>
				<div class="col-sm-2 col-md-2 col-lg-2 c-text-alt"></div>
			</div>

			<table class="table table-bordered" style="border:0px solid white">
				<tr>
					<td class="no-borders"></td>
				</tr>
				<template v-for="t in row.rows_temas">
					<tr>
						<td class="no-borders c-text-alt">TEMA</td>
						<th class="bg-white s-12 c-primary no-borders" colspan="10">@{{ t.tema }}</th>
					</tr>
					<template v-for="s in t.rows_subtemas">
						
						<tr>
							<td class="no-borders"></td>
							<td class="no-borders c-text-alt">SUBTEMA</td>
							<th class="bg-white c-primary-alt s-12 no-borders" colspan="8">@{{ s.subtema }}</th>
						</tr>	

						

						<template v-for="o in s.rows_obj">
							<tr>
								<td class="no-borders"></td>
								<td class="no-borders"></td>
								<td class="no-borders c-text-alt">OBJETIVO</td>
								<td class="bg-white s-12 bg-yellow-meta c-white">@{{ o.clave }}</td>
								<td class="bg-white s-12 no-borders" colspan="8">@{{ o.objetivo }}</td>
							</tr>	

								
							<template v-for="e in o.rows_est">
								<tr>
									<td class="no-borders"></td>
									<td class="no-borders"></td>
									<td class="no-borders"></td>
									<td class="no-borders c-text-alt">ESTRATEGIA</td>
									<td class="bg-white s-12 bg-red-meta c-white">@{{ e.clave }}</td>
									<td class="bg-white s-12 no-borders" colspan="6">@{{ e.estrategia }}</td>
								</tr>	
								
								<template v-for="(l,idkey) in e.rows_linea">
									
									<tr>
										<td class="no-borders"></td>
										<td class="no-borders"></td>
										<td class="no-borders c-text-alt text-right" colspan="3">LINEA DE ACCIÓN</td>
										<td class="bg-white s-10 bg-blue-meta c-white" style="border-bottom:1px solid #e7eaec;border-left:none;border-right:none;">@{{ l.clave }}</td>
										<td class="bg-white s-12" style="border-bottom:1px solid #e7eaec;border-left:none;border-right:none;">@{{ l.linea }}</td>
									
										<td class="bg-white" style="border-bottom:1px solid #e7eaec;border-left:none;border-right:none;">
											@if($idg == 1 || $idg == 2)
												<button class="btn btn-xs btn-success b-r-30 c-white full-width" style="text-align: left;" type="buttom" @click.prevent="openAlinear(l.id)">
													<i class="fa fa-plus-circle s-16"></i> Alinear
												</button>
											@endif

											@if($idg != 7)
												<button class="btn btn-xs b-r-30 btn-primary full-width" style="text-align: left;" type="buttom" @click.prevent="addActividadesRelevantes(l.id)">
													<i class="fa fa-plus-circle s-16"></i> Actividades Relevantes
												</button>
											@endif
										</td>
										<td class="bg-white" colspan="2" style="border-bottom:1px solid #e7eaec;border-left:none;border-right:none;">
											<table class="table table-bordered no-margins" v-if="l.rows_metas.length > 0">
												<tr>
													<td class="no-padding">
														<table class="table no-margins">
															<tr>
																<th class="no-borders">Institución</th>
																<th class="no-borders">Número</th>
																<th class="no-borders">Proyecto</th>
																<th class="no-borders">Meta</th>
																<th class="no-borders">Dependencia General</th>
																<th class="no-borders">Dependencia Auxiliar</th>
																<th class="no-borders"></th>
															</tr>
			
															<template v-for="m in l.rows_metas">
																<tr>
																	<td>@{{ m.institucion }}</td>
																	<td>@{{ m.no_proyecto }}</td>
																	<td>@{{ m.proyecto }}</td>
																	<td>@{{ m.meta }}</td>
																	<td>@{{ m.no_area }} @{{ m.area }}</td>
																	<td>@{{ m.no_coordinacion }} @{{ m.coordinacion }}</td>
																	<td width="30">
																		@if($idg != 7)
																			<i class="tips fa fa-comments s-16 fun cursor s-20" v-if="m.comentarios == '' || m.comentarios ==  null" title="Agregar Comentario" @click.prevent="openAgregarComentario(l.id,m.id)"></i>
																		@endif	
																	</td>
																	<td width="30">
																		@if($idg == 1 || $idg == 2)
																			<i class="tips fa fa-trash-o s-16 var cursor s-20" title="Eliminar Alineación" @click.prevent="deleteAlineacion(m.id)"></i>
																		@endif
																	</td>
																</tr>
																<tr v-if="m.comentarios != '' && m.comentarios !=  null">
																	<td colspan="10" class="bg-pink c-white">
																		<table class="table table-bordered no-margins">
																			<tr>
																				<td class="no-borders bg-pink c-white">@{{ m.comentarios }}
																					<div class="col-md-12">
																						<div class="text-right"><i>Por: @{{ m.usuario }}</i></div>
																						<div class="text-right"><i>@{{ m.fecha_rg }} @{{ m.hora_rg }}</i></div>
																					</div>
																				</td>
																				<td width="30" class="no-borders bg-pink c-white" v-if="m.iduser_rg == mass_idu || mass_idu == 1  || mass_idu == 3 || mass_idu == 45 || mass_idu == 44 || mass_idu == 37"> <i class="tips fa fa-edit cursor s-20" title="Editar Actividad Relevante" @click.prevent="openAgregarComentario(l.id,m.id)"></i></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</template> 
														</table>
													</td>
												</tr>
											</table>

											<template v-if="l.rows_ar.length > 0">
												<h3>Actividades Relevantes</h3>
												<table class="table table-bordered no-margins" v-for="mar in l.rows_ar">
													<tr>
														<td class="no-borders bg-primary c-white">@{{ mar.comentarios }}
															<div class="col-md-12">
																<div class="col-md-6">
																	<div class="text-left"><i>.</i></div>
																	<div class="text-left"><i>@{{ mar.institucion }}</i></div>
																</div>
																<div class="col-md-6">
																	<div class="text-right"><i>Por: @{{ mar.usuario }}</i></div>
																	<div class="text-right"><i>@{{ mar.fecha_rg }} @{{ mar.hora_rg }}</i></div>
																</div>
															</div>
														</td>
														<td width="30" class="no-borders bg-primary c-white" v-if="mar.iduser_rg == mass_idu || mass_idu == 1  || mass_idu == 3 || mass_idu == 45 || mass_idu == 44 || mass_idu == 37"> <i class="tips fa fa-edit cursor s-20" title="Editar Actividad Relevante" @click.prevent="editActividadesRelevantes(l.id, mar.id)"></i></td>
														<td width="30" class="no-borders bg-primary c-white" v-if="mar.iduser_rg == mass_idu"><i class="tips fa fa-trash-o cursor s-20" title="Eliminar actividades relevantes" @click.prevent="destroyActividadesRelevantes(l.id, mar.id)"></i></td>
													</tr>
												</table>
											</template>

											

										</td>
									</tr>	
									
								</template>

							</template>

						</template>

					</template>

				</template>
			</table>

		</div>
	</section>
</main>	

<script>
	const idanio = "{{ $idanio }}";
	const idperiodo = "{{ $idperiodo }}";
	const idpilar = "{{ $idpilar }}";
	const idi = "{{ $idi }}";
	const user_idu = "{{ $idu }}";
	var alinear = new Vue({
        el:'#app_alinear',
        data:{
            info : [],
			mass_idu: 0
        },
        methods:{
            rowsLineasAccion(){
                axios.get('{{ URL::to("alineacion/pdmpilar") }}',{
                    params : {idperiodo:idperiodo,idanio:idanio,idpilar:idpilar,idi:idi}
                }).then(response => {
                    this.info = [];
                    this.info = response.data;
                })
            },
			openAlinear(id){
				modalMisesa("{{ URL::to('alineacion/alinear') }}",{idanio:idanio,idlinea_accion:id},"Alinear con meta por actividad","98%");
			},
			addActividadesRelevantes(id){
				modalMisesa("{{ URL::to('alineacion/actividadesrelevantes') }}",{idanio:idanio,idlinea_accion:id,idi:idi},"Agregar actividades relevantes","98%");
			},
			editActividadesRelevantes(id,idar){
				modalMisesa("{{ URL::to('alineacion/actividadesrelevanteseditar') }}",{idanio:idanio,idlinea_accion:id,idar:idar},"Editar actividades relevantes","98%");
			},
			openAgregarComentario(idlinea_accion,id){
				modalMisesa("{{ URL::to('alineacion/comentarios') }}",{idanio:idanio,idlinea_accion:idlinea_accion,id:id},"Agregar descripción","99%");
			},destroyActividadesRelevantes(id,idar){
				swal({
					title : 'Estás seguro de eliminar la actividad relevante?',
					icon : 'warning',
					buttons : true,
					dangerMode : true
				}).then((willDelete) => {
					if(willDelete){
						axios.post('{{ URL::to("alineacion/destroyactrel") }}',{
							params : {idar:idar}
						}).then(response => {
							let row = response.data;
							if(row.success == "ok"){
								alinear.rowsLineasAccion();
								toastr.success(mss_tmp.delete);
							}else{
								toastr.error(mss_tmp.error);
							}
						})
					}
				})
			},/*editComentario(id,idcomm){
				modalMisesa("{{ URL::to('alineacion/comentarios') }}",{idanio:idanio,idlinea_accion:id,idcomm:idcomm},"Editar descripción","50%");
			},
			deleteComentario(idcomm){
				swal({
					title : 'Estás seguro de eliminar el comentario de la línea de acción?',
					icon : 'warning',
					buttons : true,
					dangerMode : true
				}).then((willDelete) => {
					if(willDelete){
						axios.post('{{ URL::to("alineacion/destroycomentario") }}',{
							params : {idcomm:idcomm}
						}).then(response => {
							let row = response.data;
							if(row.success == "ok"){
								alinear.rowsLineasAccion();
								toastr.success(mss_tmp.delete);
							}else{
								toastr.error(mss_tmp.error);
							}
						})
					}
				})
			},*/
			deleteAlineacion(id){
				swal({
					title : 'Estás seguro de eliminar la alineación?',
					icon : 'warning',
					buttons : true,
					dangerMode : true
				}).then((willDelete) => {
					if(willDelete){
						axios.post('{{ URL::to("alineacion/destroyalineacion") }}',{
							params : {id:id}
						}).then(response => {
							let row = response.data;
							if(row.success == "ok"){
								alinear.rowsLineasAccion();
								toastr.success(mss_tmp.delete);
							}else{
								toastr.error(mss_tmp.error);
							}
						})
					}
				})
			}
        },
        mounted(){
			this.mass_idu = user_idu;
            this.rowsLineasAccion();
        }
    });
</script>
@stop