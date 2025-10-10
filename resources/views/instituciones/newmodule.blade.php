@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-primary"> {{ $pageTitle }} <small class="s-12"> <i>{{ $pageNote }} </i></small></h3>
		</div>

		<ul class="breadcrumb bg-body s-14">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-14"></i> </a></li>
			<li class="active"><i>Años</i></li>
		</ul>		  
	</section>

 

	<div class="row" >
		<section class="page-content-wrapper m-t-md" >
			<div class="sbox animated fadeInRight">
				<div class="sbox-title border-t-yellow"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
				<div class="sbox-content" id="aplicacionyears"> 	
	
					<table class="table table-bordered">
						<tr class="t-tr-s16">
							<th width="30">#</th>
							<th>Modulo</th>
							<th>Años</th>
							<th width="50">Acción</th>
						</tr>
						<template v-for="info in rowData">
							<tr class="t-tr-s16">
								<td>@{{ info.no }}</td>
								<td>@{{ info.module }}</td>
								<td>
									<ul>
										<li v-for="r in info.rows"> 
											<i class="fa fa-trash-o c-danger cursor" @click.prevent="deleteYear(r.id)"></i> @{{ r.anio }} - <i><small>(Catálogos a usar: @{{ r.anio_info }})</small> 
											</i>
										</li>
									</ul>
								</td>
								<td class="text-center">
									<button type="button" class="tips btn btn-xs btn-white" @click.prevent="addYear(info.no)"><i class="fa fa-edit c-blue"></i></button>
								</td>
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
				axios.get('{{ URL::to($pageModule."/listnewmodule") }}',{
					params : {idi:this.idi},
				}).then(response => {
                    this.rowsData = [];
					var row = response.data;
					this.rowData = row.rowData;
				});
				
			},addYear(no){
				modalMisesa("{{ URL::to($pageModule.'/addnewmodule') }}",{idi:"{{ $idi }}",no:no},"Agregar Año","60%");
			},deleteYear(id){
				swal({
                  title : 'Estás seguro de eliminar el año?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.delete('{{ URL::to($pageModule."/yearnewmodule") }}',{
                          params : {id:id}
                      }).then(response => {
                          let row = response.data;
                          if(row.status == "ok"){
                              this.rowsProjects();
                          }
                      })
                  }
              })
			}
		},
		mounted(){
			this.idi = "{{ $idi }}";
			this.rowsProjects();
		}
	});
</script>

@stop

