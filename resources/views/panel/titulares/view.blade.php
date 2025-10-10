@extends('layouts.main')

@section('content')


<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Titulares por dependencia general</i></small></h3>
		</div>
	
		<ul class="breadcrumb bg-body">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
			<li>
				<a href="{{ URL::to('panel/titulares') }}" class="c-blue"><i>Ejercicio Fiscal</i></a>
			</li>
			<li class="active"><i>{{ $row->year }}</i></li>
		</ul>	  
	</section>
		
	<div class="table-responsive m-t-md m-b-lg" id="app_titulares" style="border:0px !important;background:transparent;">

		<div class="col-md-12">

			<table class="table table-bordered table-hover bg-white table-ses" v-if="rowsData.length > 0">
				<tr class="c-text-alt">
					<th class="text-center" width="30"></th>
					<th class="text-center">Dependencia General</th>
					<th class="text-center">Titular</th>
					<th class="text-center">Cargo</th>
					<th class="text-center">Acción</th>
				</tr>
				
				<tr v-for="(row,key) in rowsData">
					<td class="c-text-alt text-center">@{{ row.no_dep_gen }}</td>
					<td class="c-text-alt">@{{ row.dep_gen }}</td>
					<td class="c-text-alt">@{{ row.titular }}</td>
					<td class="c-text-alt">@{{ row.cargo }}</td>
					<td class="text-center">
						<i class="fa fa-edit c-blue cursor" @click.prevent="edit(row.id)"></i>
					</td>
				</tr>
			</table>
		</div>
  	</div>
				
</main>	

<div class="p-lg m-b-lg"></div>

<script>
	const appTabs = Vue.createApp({
				data() {
					return {
						rowsData : [],
						cancelTokenSource: null,
					};
				},
				methods:{
					loadTitulares(){
						if (this.cancelTokenSource) {
							this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
						}
						// Crear un nuevo token de cancelación
						this.cancelTokenSource = axios.CancelToken.source();

						axios.get('{{ URL::to("panel/searchdepgen") }}',{
							params : {idy: "{{ $row['idy'] }}"},
							cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
						}).then(response => {

							var row = response.data;
							if(row.status == 'ok'){
								this.rowsData = response.data.data;
							}else{
								toastr.error(row.message);
							}
						
						}).catch(error => {
						}).finally(() => {
						});
					},edit(id){
						modalMisesa("{{ URL::to('panel/editartitular') }}",{id:id},"Editar Titular","50%");
					}
				},
				mounted(){
					this.loadTitulares();
				}
			});

	const vm = appTabs.mount('#app_titulares');
</script>
@stop