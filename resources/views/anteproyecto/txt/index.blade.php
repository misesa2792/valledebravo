@extends('layouts.main')

@section('content')

 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
<main class="page-content row bg-body">
	@include("anteproyecto.txt.component.pbrma")
	@include("anteproyecto.txt.component.pbrmc")
	@include("anteproyecto.txt.component.pbrmaa")
	@include("anteproyecto.txt.component.pbrmb")
	@include("anteproyecto.txt.component.pbrme")
	@include("anteproyecto.txt.component.pbrmd")


	<div class="col-md-12 no-padding" id="appTabs">

		<section class="page-header bg-body">
			<div class="col-md-5 no-padding">
				<div class="page-title">
					<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>Generacion de txt</i></small></h3>
				</div>
			
				<ul class="breadcrumb bg-body s-14">
					<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
					<li class="active"><i>Generacion de txt</i></li>
				</ul>	  
			</div>
			<div class="col-md-7">

				<table class="table bg-white no-margins">
					<tr>
						<th class="text-center bg-blue-meta c-white">Planeación</th>
						<th class="text-center bg-green-meta c-white" colspan="3">Metas</th>
						<th class="text-center bg-red-meta c-white">FODA</th>
						<th class="text-center bg-yellow-meta c-white" colspan="2">Indicadores</th>
					</tr>
					<tr>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPlan' ? 'nav-menu-blue' : '')" :key="'Plan'" @click="currentComponent = 'ComponentPlan'">
								<i class="fa fa-calendar s-14"></i>  Planeación
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrma' ? 'nav-menu-green' : '')" :key="'01a'" @click="currentComponent = 'ComponentPbrma'">
								<i class="fa fa-money s-14"></i>  PbRM-01a
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrmc' ? 'nav-menu-green' : '')" :key="'01c'" @click="currentComponent = 'ComponentPbrmc'">
								<i class="fa fa-calendar s-14"></i>  PbRM-01c
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrmaa' ? 'nav-menu-green' : '')" :key="'02a'" @click="currentComponent = 'ComponentPbrmaa'">
								<i class="fa fa-calendar s-14"></i>  PbRM-02a
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrmb' ? 'nav-menu-danger' : '')" :key="'01b'" @click="currentComponent = 'ComponentPbrmb'">
								<i class="fa fa-calendar s-14"></i>  PbRM-01b
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrme' ? 'nav-menu-yellow' : '')" :key="'01e'" @click="currentComponent = 'ComponentPbrme'">
								<i class="fa fa-calendar s-14"></i>  PbRM-01e
							</a>
						</td>
						<td class="text-center">
							<a href="#" 
								:class="'btn btn-white c-text-alt tips no-borders ' + (currentComponent == 'ComponentPbrmd' ? 'nav-menu-yellow' : '')" :key="'01d'" @click="currentComponent = 'ComponentPbrmd'">
								<i class="fa fa-calendar s-14"></i>  PbRM-01d
							</a>
						</td>
					</tr>
				</table>

			</div>
		</section>

		<div class="col-md-12">
			<button type="button" onclick="location.href='{{ URL::to($pageModule.'/dependencias?idy='.$idy.'&type='.$type) }}' " class="btn bg-default c-text btn-ses b-r-5 tips" title="Regresar" style="margin-right:15px;">
				<i class="fa  fa-arrow-circle-left "></i> Regresar
			</button>
		</div>

		<div class="col-md-12 m-t-md">
			<component :is="currentComponent" ref="componenteActivo"></component>
		</div>
	</div>
</main>	
<style>
	/* sin margen interno, ganando a Bootstrap */
	.table.table-ses > thead > tr > th,
	.table.table-ses > thead > tr > td,
	.table.table-ses > tbody > tr > th,
	.table.table-ses > tbody > tr > td,
	.table.table-ses > tfoot > tr > th,
	.table.table-ses > tfoot > tr > td {
	padding: 1 !important;
	font-size:10px;
	}

	/* elimina espacios entre celdas */
	.table.table-ses {
	border-collapse: collapse !important;
	border-spacing: 1 !important;
	}
	.nav-menu-blue{
		border-bottom:2px solid var(--color-blue) !important;
	}
	.nav-menu-green{
		border-bottom:2px solid var(--color-green-meta) !important;
	}
	.nav-menu-danger{
		border-bottom:2px solid var(--color-red-meta) !important;
	}
	.nav-menu-yellow{
		border-bottom:2px solid var(--color-yellow-meta) !important;
	}
	#sximo-modal .modal-dialog {
		max-height: 95%;
		overflow-y: auto !important;
	}

	#sximo-modal .modal-body {
		max-height: 80vh;
		overflow-y: auto !important;
	}

	.sbox-content {
		min-height: 70vh;
	}
	
</style>

<script>
	const componentes = {
						ComponentPbrma,
						ComponentPbrmc,
						ComponentPbrmaa,
						ComponentPbrmb,
						ComponentPbrme,
						ComponentPbrmd,
						/*ComponentPlan,*/
					};

	const appTabs = Vue.createApp({
			data() {
				return {
					currentComponent: 'ComponentPbrma',
				};
			},
				components: componentes
			});

	const vm = appTabs.mount('#appTabs');
</script>
	
@stop