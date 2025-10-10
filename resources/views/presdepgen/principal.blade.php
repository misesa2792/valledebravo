@extends('layouts.app')

@section('content')

<template id="card_loading">
    <div class="col-md-12 m-t-md">
        <div class="col-md-12 ">
            <article class="col-sm-12 col-md-12 col-lg-12">
                <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
                    <span class="line-circle-b text-center font-bold tips loading-skeleton"></span>
                    <div class="col-sm-12 col-md-12 col-lg-12 bg-white b-r-10 p-md b-r-c" id="line-comm3" >
                        <article class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto " style="min-height:350px;">

                            <table class="table">
                                <tr>
                                    <td class="no-borders" width="10%">
                                        <div class="loading-skeleton p-xs b-r-30"></div>
                                    </td>
                                    <td class="no-borders"></td>
                                </tr>
                            </table>

                            <table class="table m-b-xs" style="margin-bottom:12px;" v-for="v in skeletonArray">
                                <tr>
                                    <td class="no-borders" width="30">
                                        <div class="loading-skeleton p-xs b-r-30"></div>
                                    </td>
                                    <td class="no-borders" width="100">
                                        <div class="loading-skeleton p-xs b-r-30"></div>
                                    </td>
                                    <td class="no-borders" >
                                        <div class="loading-skeleton p-xs b-r-30"></div>
                                    </td>
                                    <td class="no-borders" width="10%">
                                        <div class="loading-skeleton p-xs b-r-30"></div>
                                    </td>
                                </tr>
                            </table>

                        </article>
                    </div>
                </section>
            </article>
            <article class="col-sm-12 col-md-12 col-lg-12">
                <section class="col-sm-12 col-md-12 col-lg-12 p-md">
                    <span class="line-circle-b text-center font-bold tips loading-skeleton" title="Inicio"></span>
                </section>
            </article>
        </div>
    </div>
</template>
<main class="page-content row bg-body"  id="app_ff">
    <section class="page-header bg-body">
		<div class="page-title">
		  <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
		</div>
	
		<ul class="breadcrumb bg-body s-14">
		  <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		  <li class="active">{{ $pageTitle }} </li>
		</ul>	  
	  </section>

    <section class="col-md-12 no-padding m-t-md">
        <div class="col-md-12 p-rel">
            <ul class="nav nav-tabs text-right">
                <li>
                  <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
                    <i class="fa  fa-arrow-circle-left "></i> Regresar
                  </button>
                </li>
                <li>
                    <button type="button" class="btn bg-blue c-white tips)" @click.prvent="selectYear()" :title="year">
                        <i class="fa fa-calendar s-14"></i> @{{ year }}
                    </button>
                </li>
            </ul>
        </div>
      </section>
    <card-loading v-if="isLoading"></card-loading>
	<div class="col-md-12 m-t-md" v-else>

		<div class="col-md-12">
			<article class="col-sm-12 col-md-12 col-lg-12">
					
				<section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
		
					<span class="line-circle-a text-center font-bold tips" :title="year">@{{ year }}</span>
					
					<div class="col-sm-12 col-md-12 col-lg-12 bg-white b-r-5 p-md b-r-c" id="line-comm">
	
                        <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com">
                              <div class="col-md-12 text-right">
                                <i class="fa icon-spinner8 cursor s-14 c-text tips" @click.prevent="syncDepGen()" title="Agregar Dependencias Generales"></i>
                              </div>
                        </div>
	
						<article class="table-resp text-justify line-texto " >
							<div class="col-sm-12 col-md-12 col-lg-12 m-t-md" style="min-height: 350px;">
	
								<table class="table table-hover no-margins table-bordered table-ses"  v-if="rowsData.length > 0">
									<thead>
										<tr class="t-tr-s12 c-text">
											<th rowspan="2" class="text-center" width="5"></th>
											<th rowspan="2" class="text-center" width="40">Número</th>
											<th rowspan="2" class="text-center">Dependencia General</th>

											<th rowspan="2" class="no-borders" width="10"></th>
											<th class="text-center c-white bg-blue-meta" colspan="4">Presupuesto Definitivo</th>
											<th rowspan="2" class="no-borders" width="10"></th>
											<th class="text-center c-white bg-green-meta" colspan="4">Proyecto</th>
											<th rowspan="2" class="no-borders" width="10"></th>
											<th class="text-center c-white bg-yellow-meta" colspan="4">Anteproyecto</th>
										</tr>
                                        <tr class="t-tr-s12 c-text">
											<th class="text-center" width="20"></th>
											<th class="text-center">Presupuestado</th>
											<th class="text-center">UIPPE</th>
											<th class="text-center">Restante</th>

											<th class="text-center" width="20"></th>
                                            <th class="text-center">Presupuestado</th>
											<th class="text-center">UIPPE</th>
											<th class="text-center">Restante</th>

											<th class="text-center" width="20"></th>
                                            <th class="text-center">Presupuestado</th>
											<th class="text-center">UIPPE</th>
											<th class="text-center">Restante</th>
										</tr>
									</thead>
							
									<tbody>
										<template v-for="(row,index) in rowsData">
                                            <tr class="t-tr-s12">
                                                <td class="text-center">
                                                    <i :class="'fa fa-circle tips ' + (row.estatus == 1 ? 'c-success' : 'c-danger') " :title="row.estatus == 1 ? 'Activa' : 'Inactiva'"></i>
                                                </td>
                                                <td class="text-center">@{{ row.no_dep_gen }}</td>
                                                <td>@{{ row.dep_gen }}</td>

                                                <td class="no-borders"></td>
                                                <td class="text-center">
                                                    <i class="fa fa-edit cursor c-blue s-14" @click.prevent="addPres(row.id, 3)"></i>
                                                </td>
                                                <td class="text-right c-success">@{{ row.pres.presupuesto }}</td>
                                                <td class="text-right c-blue">@{{ row.pres.uippe }}</td>
                                                <td class="text-right c-danger">@{{ row.pres.restante }}</td>

                                                <td class="no-borders"></td>
                                                <td class="text-center">
                                                    <i class="fa fa-edit cursor c-blue s-14" @click.prevent="addPres(row.id, 2)"></i>
                                                </td>
                                                <td class="text-right">@{{ row.proy.presupuesto }}</td>
                                                <td class="text-right c-blue">@{{ row.proy.uippe }}</td>
                                                <td class="text-right c-danger">@{{ row.proy.restante }}</td>

                                                <td class="no-borders"></td>
                                                <td class="text-center">
                                                    <i class="fa fa-edit cursor c-blue s-14" @click.prevent="addPres(row.id, 1)"></i>
                                                </td>
                                                <td class="text-right">@{{ row.ante.presupuesto }}</td>
                                                <td class="text-right c-blue">@{{ row.ante.uippe }}</td>
                                                <td class="text-right c-danger">@{{ row.ante.restante }}</td>
                                            </tr>
										</template>
                                            <tr class="t-tr-s12">
                                                <th colspan="3" class="text-right">TOTAL:</th>
                                                <td class="no-borders"></td>
                                                <td class="no-borders"></td>
                                                <th class="text-right c-success">@{{ rowsPres.presupuesto }}</th>
                                                <th class="text-right c-blue">@{{ rowsPres.uippe }}</th>
                                                <th class="text-right c-danger">@{{ rowsPres.restante }}</th>
                                                <td class="no-borders"></td>
                                                <td class="no-borders"></td>
                                                <th class="text-right c-success">@{{ rowsProy.presupuesto }}</th>
                                                <th class="text-right c-blue">@{{ rowsProy.uippe }}</th>
                                                <th class="text-right c-danger">@{{ rowsProy.restante }}</th>
                                                <td class="no-borders"></td>
                                                <td class="no-borders"></td>
                                                <th class="text-right c-success">@{{ rowsAnte.presupuesto }}</th>
                                                <th class="text-right c-blue">@{{ rowsAnte.uippe }}</th>
                                                <th class="text-right c-danger">@{{ rowsAnte.restante }}</th>
                                            </tr>
									</tbody>
								</table>
	
							</div>
						</article>
						
					</div>
				</section>
				
			</article>
		</div>

		<div class="col-md-12" >
			<article class="col-sm-12 col-md-12 col-lg-12 contArticle">
				<section class="col-sm-12 col-md-12 col-lg-12 p-md">
					<span class="line-circle-a text-center font-bold tips" title="Inicio"><i class="fa fa-calendar s-16"></i></span>
					
				</section>
			 
			</article>
		</div>
	</div>

	
</main>	
<style>
.t-tr-s11 > th, .t-tr-s11 > td{font-size: 11px !important;}

</style>
<script>

Vue.component('card-loading', {
	template: "#card_loading",
	data: function() {
		return {
			skeletonArray: [1,2,3,4,5,6,7,8,9,10],
		};
	}
});

 var proyectos = new Vue({
        el:'#app_ff',
        data:{
                rowsData : [],
                rowsPres : [],
                rowsProy : [],
                rowsAnte : [],
                rowsYears : [],
                idyear:0,
                year:0,
                cancelTokenSource: null,
                isLoading:false,
                proyectosCache: [] // Almacena proyectos por año
        },
        computed: {
            checkActive(){
                return this.idyear;
            }
        },
        methods:{
			addPres(id,modulo){
				modalMisesa("{{ URL::to($pageModule.'/add') }}",{id:id,modulo:modulo},"Agregar presupuesto "+this.year,"45%");
			},
            syncDepGen(){
                axios.get('{{ URL::to($pageModule."/sync") }}',{
                    params : {idyear:this.idyear},
                }).then(response => {
                    var row = response.data;
                    if(row.response == "ok"){
                        toastr.success("Sincronización exitosa!!!");
                        this.rowsProjects();
                    }
                })
            },
            rowsProjects(){
				this.isLoading = true;

                if (this.cancelTokenSource) {
                    this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
                }

                // Crear un nuevo token de cancelación
                this.cancelTokenSource = axios.CancelToken.source();

                axios.get('{{ URL::to($pageModule."/data") }}',{
                    params : {idyear:this.idyear},
                    cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                }).then(response => {

                    var row = response.data;
                    if(row.response == 'error'){
                        toastr.error(row.text);
                    }else{
                        this.rowsData = row.rowsData;
                        this.rowsPres = row.rowsPres;
                        this.rowsProy = row.rowsProy;
                        this.rowsAnte = row.rowsAnte;
                        
                    }
                   
                }).catch(error => {
                    /*if (axios.isCancel(error)) {
                    } */
                }).finally(() => {
                    // Ocultar el loading cuando la solicitud termina (éxito o error)
                    this.isLoading = false;
                });
            },selectYear(){
                this.rowsProjects();
            }
            
        },
        mounted(){
            this.idyear = "{{ $idy }}";
            this.year = "{{ $year }}";
            this.rowsProjects();

            $(".tips").tooltip();
        },
        updated(){
            $(".tips").tooltip();
        }
    });
</script>		
@stop