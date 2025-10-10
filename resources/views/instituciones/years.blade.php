@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary"> {{ $pageTitle }} <small class="s-12"> <i>{{ $pageNote }} </i></small></h3>
		</div>

		<ul class="breadcrumb bg-body s-14">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-14"></i> </a></li>
			<li class="active"><i>Configuración</i></li>
		</ul>		  
	</section>

 

	<div class="row" >
		<section class="page-content-wrapper m-t-md" >
			<div class="sbox animated fadeInRight">
				<div class="sbox-title border-t-yellow"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
				<div class="sbox-content" id="aplicacionyears"> 	
	
					<table class="table table-bordered">
						<tr>
							<th>Año</th>
							<th>Logo Izquierdo</th>
							<th>Logo Derecho</th>
							<th>UIPPE</th>
							<th>Tesorería</th>
							<th>Egresos</th>
							<th>Programa Presupuestario</th>
							<th>Secretario</th>
						</tr>
						<template v-for="info in rowData">
							<tr>
								<td rowspan="2">@{{ info.anio }}</td>
								<td rowspan="2">
									<img :src="'../../'+info.logo_izq" width="120" height="60">
								</td>
								<td rowspan="2" class="text-center">
									<img :src="'../../'+info.logo_der" width="70" height="70">
								</td>
								<td>@{{ info.t_uippe }}</td>
								<td>@{{ info.t_tesoreria }}</td>
								<td>@{{ info.t_egresos }}</td>
								<td>@{{ info.t_prog_pres }}</td>
								<td>@{{ info.t_secretario }}</td>
								<td rowspan="2">
									<button type="button" class="btn btn-xs btn-white" @click.prevent="editYears(info.id)">
										<i class="fa fa-edit"></i>
									</button>
								</td>
							</tr>
							<tr>
								<td>@{{ info.c_uippe }}</td>
								<td>@{{ info.c_tesoreria }}</td>
								<td>@{{ info.c_egresos }}</td>
								<td>@{{ info.c_prog_pres }}</td>
								<td>@{{ info.c_secretario }}</td>
							</tr>
						</template>
						
					</table>
					
	
				</div>
			</div>
		</section>

		
	</div>
	

</div>	
</main>			 
  	 
<script>

     var years = new Vue({
		el:'#aplicacionyears',
		data:{
			rowData : [],
			idi:0
			},
		methods:{
			rowsProjects(){

				axios.get('{{ URL::to($pageModule."/listyears") }}',{
					params : {idi:this.idi},
				}).then(response => {
                    this.rowsData = [];
					var row = response.data;
					this.rowData = row.rowData;
				});
				
			},editYears(id){
				modalMisesa("{{ URL::to($pageModule.'/edityear') }}",{id:id},"Editar Año","60%");
			}
		},
		mounted(){
			this.idi = "{{ $idi }}";
			this.rowsProjects();
		}
	});
</script>

@stop

