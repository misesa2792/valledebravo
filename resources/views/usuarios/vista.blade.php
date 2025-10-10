@extends('layouts.app')

@section('content')
<template id="comp_activo">
	<div class="col-md-12 no-padding">
		<div class="col-md-12 bg-success" v-if="std == 1">
			<div class="col-md-12 s-20 p-xs">
				<h2 class="text-center c-white">Activo</h2>
			</div>
		</div>
	
		<div class="col-md-12 bg-danger" v-if="std == 0">
			<div class="col-md-12 s-20 p-xs">
				<h2 class="text-center c-white">Inactivo</h2>
			</div>
		</div>
	</div>
</template>

<main class="page-content row bg-body">

    <section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
		</div>

		<ul class="breadcrumb bg-body s-20">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
			<li>{{ $rowsInstituciones[0]->descripcion }}</li>
			<li>{{ $pageTitle }}</li>
			<li>Información</li>
		</ul>	 
	</section>

    <section class="col-md-12 no-padding" id="app_user">

		<div class="toolbar-line">
			<div class="col-md-12 m-b-md">
				<button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
			</div>
		</div> 
	
		<div class="col-md-8 no-padding">

			<article class="page-content-wrapper">

				<div class="sbox animated fadeInRight border-t-green">
	
				  <div class="col-md-12 b-b-gray no-padding c-text-alt m-b-md">
					<div class="col-md-9"> 
						<div class="p-md"> <i class="fa icon-newspaper s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-20">Información</span></div>
					</div>
					<div class="col-md-3"> 
						<div class="p-md text-right"> 
							<button class="btn btn-xs btn-default-alt" @click.prevent="editInformacion">
								<i class="fa icon-pencil cursor"></i>
							</button>
						</div>
					</div>
				  </div>
	
					<div class="sbox-content"> 	
			
						<div class="row">
							<div class="col-md-12 s-16">
								<div class="col-md-8">
									<div class="col-md-12 b-b-gray b-b-pad">
									<div class="col-md-4 text-right com">Nombre(s):</div>
									<div class="col-md-8">@{{ info.nombre }}</div>
									</div>
									
									<div class="col-md-12 b-b-gray b-b-pad">
									<div class="col-md-4 text-right com"> Apellido Paterno:</div>
									<div class="col-md-8">@{{ info.ap }}</div>
									</div>
			
									<div class="col-md-12 b-b-gray b-b-pad">
									<div class="col-md-4 text-right com">Apellido Materno:</div>
									<div class="col-md-8">@{{ info.am }}</div>
									</div>
			
									<div class="col-md-12 b-b-pad">
									<div class="col-md-4 text-right com"> E-mail :</div>
									<div class="col-md-8 fun">@{{ info.email }}</div>
									</div>
								</div>
	
								<div class="col-md-4" style="display: table;">
									<div class="text-center" style="display: table-cell;vertical-align: middle;">
										<img :src="avatar" height="150" width="150" class="b-r-5">
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>	
			</article>

			<article class="page-content-wrapper">

				<div class="sbox animated fadeInRight border-t-green">
	
				  <div class="col-md-12 b-b-gray no-padding c-text-alt m-b-md">
					<div class="col-md-9"> 
						<div class="p-md"> <i class="fa icon-unlocked2 s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-20">Permisos a Dependencias</span></div>
					</div>
					<div class="col-md-3"> 
						
					</div>
				  </div>
	
					<div class="sbox-content"> 	
			
						<div class="row">

							<div class="box well" v-if="deps.length > 0">
								  <div class="tab-container">
									<ul class="nav nav-tabs">
									  <li v-for="(row, key) in deps" :class="checkMenu == key ? 'active' : 'no-active'" @click.prvent="openMenu(key)"><a :href="'#years'+key" data-toggle="tab">@{{ row.year }}</a></li>
									</ul>
									<div class="tab-content bg-white">
									  	<div v-for="(r, keyy) in deps" :class="'tab-pane use-padding ' + (checkMenu == keyy ? 'active' : 'no-active')" :id="'years'+keyy">
											
											<div class="col-md-12 text-right m-b-md m-t-md">
												<button class="btn btn-xs btn-default-alt" @click.prevent="addPermisoDep(r.idy)">
													<i class="fa icon-pencil cursor"></i>
												</button>
											</div>

											<table class="table table-bordered">
												<tr class="t-tr-s14">
													<th>Dpendencia General</th>
													<th>Dpendencia Auxiliar</th>
												</tr>
												<tr class="t-tr-s14" v-for="d in r.rowsdepgen">
													<td>@{{ d.no_dep_gen+' '+d.dep_gen }}</td>
													<td>@{{ d.no_dep_aux+' '+d.dep_aux }}</td>
												  </tr>	
											</table>

										</div>
									</div>
								  </div>
							  </div>    
		
							<div class="row text-center" v-if="deps.length == 0">
								<h1> <i class="fa fa-users com"></i> </h1>
								<h2 class="com">No hay permisos para ver Dependencias!</h2>
							</div>
						</div>
						
					</div>
				</div>	
			</article>

		</div>

		<div class="col-md-4">

			<article class="page-content-wrapper">
				<div class="sbox animated fadeInRight">
					<div class="col-md-12 b-b-gray c-text-alt bg-white m-b-md"> 
						<div class="p-md"> <i class="fa icon-home6 s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-20 c-primary-alt font-bold">@{{ info.institucion }}</span></div>
					</div>
					<div class="sbox-content"></div>
				</div>
			</article>

			<article class="page-content-wrapper">
				<div class="sbox animated fadeInRight">
					<div class="col-md-12 b-b-gray c-text-alt bg-white m-b-md"> 
						<div class="p-md"> <i class="fa icon-location4 s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-20">@{{ municipio }}</span></div>
					</div>
					<div class="sbox-content"></div>
				</div>
			</article>

			<article class="page-content-wrapper">
				<div class="sbox animated fadeInRight">
	
					<div class="col-md-12 b-b-gray no-padding c-text-alt bg-white">
						<div class="col-md-9"> 
							<div class="p-md"> <i class="fa icon-flag3 s-20"></i> &nbsp;&nbsp;&nbsp; <span class="s-20">Estatus</span></div>
						</div>
						<div class="col-md-3"> 
							<div class="p-md text-right">
								<button class="btn btn-xs btn-default-alt" @click.prevent="editEstatus">
									<i class="fa icon-pencil cursor"></i>
								</button>
							</div>
						</div>
					</div>
	
					<comp-activo :std="activo"></comp-activo>
				</div>
			</article>
		</div>
	</section>
</main>	

<script>
	const std = Vue.component("comp-activo",{
		template : "#comp_activo",
		props: ['std']
	})

	const mass_k = "{{ $token }}";
	var user = new Vue({
		el:'#app_user',
		data:{
			menu:0,
			info : [],
			deps : [],
			activo : '',
			municipio : '',
			avatar : '{{ asset("images/operadores/no-avatar.jpg") }}',
			mass_key : 0
		},
		computed: {
          	checkMenu(){
				return this.menu;
			}
		},
		methods:{
			openMenu(key){
				this.menu = key;
			},
			rowsUser(){
				axios.get('{{ URL::to("usuarios/datauser") }}',{
					params : {k: this.mass_key}
				}).then(response => {
					let rows = response.data;
		            this.info = rows;
					this.activo = rows.active;
					this.municipio = rows.mun;
					this.avatar = rows.avatar;
					this.deps = rows.deps;
				})
			},editEstatus(){
				modalMisesa("{{ URL::to('usuarios/estatus') }}",{ k: this.mass_key }, "Editar Estatus",'40%');
			},editInformacion(){
				modalMisesa("{{ URL::to('usuarios/informacion') }}",{ k: this.mass_key }, "Editar Información",'40%');
			},addPermisoDep(idy){
				modalMisesa("{{ URL::to('usuarios/permisosdep') }}",{ k: this.mass_key, idy:idy }, "Permisos Dependencias",'85%');
			}
		},
		mounted(){
			this.mass_key = mass_k;
			this.rowsUser();
		}
  });

  
</script>

@stop