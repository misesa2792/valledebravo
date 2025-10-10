@extends('layouts.main')

@section('content')

 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
<main class="page-content row bg-body">
	@include("anteproyecto.component.pbrma")
	@include("anteproyecto.component.pbrmc")
	@include("anteproyecto.component.pbrmaa")
	@include("anteproyecto.component.pbrmb")
	@include("anteproyecto.component.pbrme")
	@include("anteproyecto.component.pbrmd")
	@include("anteproyecto.component.planeacion")

	<div class="col-md-12 no-padding" id="appTabs">

		<section class="page-header bg-body">
			<div class="col-md-5 no-padding">
				<div class="page-title">
					<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $data['pageNote'] }}</i></small></h3>
				</div>
			
				<ul class="breadcrumb bg-body s-14">
					<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
					<li><i>{{ $data['year'] }}</i></li>
					<li><i>{{ $data['no_dep_gen'] }}</i></li>
					<li class="active"><i>{{ $data['dep_gen'] }}</i></li>
				</ul>	  
			</div>
			<div class="col-md-7">

				<table class="table table-bordered bg-white no-margins">
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

		@include("anteproyecto.regresar")
		
		<div class="col-md-12 m-t-md">
			<component :is="currentComponent" ref="componenteActivo"></component>
		</div>
	</div>
</main>	

<style>
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
</style>

<script>
	const componentes = {
						ComponentPbrma,
						ComponentPbrmc,
						ComponentPbrmaa,
						ComponentPbrmb,
						ComponentPbrme,
						ComponentPbrmd,
						ComponentPlan,
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