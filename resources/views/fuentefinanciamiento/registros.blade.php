@extends('layouts.app')

@section('content')
<main class="page-content row bg-body"  id="app_ff">

	<section class="page-header bg-body">
		<div class="page-title">
		  <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
		</div>
	
		<ul class="breadcrumb bg-body s-14">
		  <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		  <li><i>{{ $pageTitle }}</i></li>
		  <li class="active"><i>Ejercicio Fiscal</i></li>
		</ul>	  
	</section>


    <section class="col-md-12 no-padding m-t-md m-b-md">
        <div class="col-md-12 p-rel">
            <ul class="nav nav-tabs text-right">
                <li>
                    <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
                    <i class="fa  fa-arrow-circle-left "></i> Regresar
                    </button>
                </li>
            </ul>
        </div>
    </section>


    <div class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                <div class="sbox-title border-t-yellow"> <h4> {{ $pageTitle }}</h4></div>
                <div class="sbox-content bg-white" style="min-height:300px;"> 	
                    
                    <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto com no-padding" >
                        <button type="button" class="tips btn btn-sm btn-primary btn-outline btn-ses" title="Agregar Nueva FF" @click.prevent="addFuenteFinanciamiento">
                            <i class="fa fa-plus-circle"></i> Agregar Fuente de Financiamiento
                        </button>
                    </div>

                    <div class="col-md-12 m-t-md no-padding">
                        <table class="table table-hover no-margins table-bordered table-ses">
                            <thead>
                                <tr class="t-tr-s11 c-text">
                                    <th class="text-center" colspan="4">CONCEPTO</th>
                                    <th class="text-center" >ENERO</th>
                                    <th class="text-center" >FEBRERO</th>
                                    <th class="text-center" >MARZO</th>
                                    <th class="text-center" >ABRIL</th>
                                    <th class="text-center" >MAYO</th>
                                    <th class="text-center" >JUNIO</th>
                                    <th class="text-center" >JULIO</th>
                                    <th class="text-center" >AGOSTO</th>
                                    <th class="text-center" >SEPTIEMBRE</th>
                                    <th class="text-center" >OCTUBRE</th>
                                    <th class="text-center" >NOVIEMBRE</th>
                                    <th class="text-center" >DICIEMBRE</th>
                                    <th class="text-center" >PRESUPUESTO </th>
                                </tr>
                                <tr class="t-tr-s11 c-black">
                                    <th class="text-center" colspan="4">PRESUPUESTO DE EGRESOS APROBADO</th>
                                    <th class="text-right" >@{{ rowsTotales.m1 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m2 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m3 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m4 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m5 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m6 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m7 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m8 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m9 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m10 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m11 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.m12 }}</th>
                                    <th class="text-right" >@{{ rowsTotales.total }}</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                <template v-for="(row,index) in rowsData">
                                  
                                    <tr class="t-tr-s11 c-text">
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                                                    <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                                        <li><a href="#" @click.prevent="editFF(row.id)"><i class="fa fa-edit c-blue"></i> Editar</a></li>
                                                        <li><a href="#" @click.prevent="destroyFF(row.id)"><i class="fa fa-trash-o c-danger"></i> Eliminar</a></li>
                                                    </ul>
                                              </div>
                                        </td>
                                        <td class="text-center">@{{ row.clave }}</td>
                                        <td>@{{ row.fuente }}</td>
                                        <td>$</td>
                                        <td class="text-right">@{{ row.m1.importe }}</td>
                                        <td class="text-right">@{{ row.m2.importe }}</td>
                                        <td class="text-right">@{{ row.m3.importe }}</td>
                                        <td class="text-right">@{{ row.m4.importe }}</td>
                                        <td class="text-right">@{{ row.m5.importe }}</td>
                                        <td class="text-right">@{{ row.m6.importe }}</td>
                                        <td class="text-right">@{{ row.m7.importe }}</td>
                                        <td class="text-right">@{{ row.m8.importe }}</td>
                                        <td class="text-right">@{{ row.m9.importe }}</td>
                                        <td class="text-right">@{{ row.m10.importe }}</td>
                                        <td class="text-right">@{{ row.m11.importe }}</td>
                                        <td class="text-right">@{{ row.m12.importe }}</td>
                                        <td class="text-right">@{{ row.total.importe }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>		 
        </section>
    </div>
	
</main>	
<script>
 var proyectos = new Vue({
        el:'#app_ff',
        data:{
            rowsData : [],
            rowsTotales: [],
            idam:0,
            cancelTokenSource: null,
        },
        computed: {
        },
        methods:{
			addFuenteFinanciamiento(){
				modalMisesa("{{ URL::to($pageModule.'/add') }}",{idam:this.idam},"Agregar Fuente de Financiamiento ","95%");
			},editFF(id){
				modalMisesa("{{ URL::to($pageModule.'/edit') }}",{id:id,idam:this.idam},"Editar Fuente de Financiamiento ","95%");
			},destroyFF(id){
                swal({
                      title : 'Estás seguro de ELIMINAR la fuente de financiamiento?',
                      icon : 'warning',
                      buttons : true,
                      dangerMode : true
                  }).then((willDelete) => {
                      if(willDelete){
                          axios.delete('{{ URL::to($pageModule."/fuente") }}',{
                              params : {id:id}
                          }).then(response => {
                              let row = response.data;
                              if(row.status == "ok"){
                                this.rowsProjects();
                                toastr.success(row.message);
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

                axios.get('{{ URL::to("fuentefinanciamiento/data") }}',{
                    params : {idam:this.idam},
                    cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                }).then(response => {
                    var row = response.data;
                    if(row.status == 'ok'){
                        this.rowsData = row.data.data;
                        this.rowsTotales = row.data.totales;
                    }
                   
                }).catch(error => {
                    /*if (axios.isCancel(error)) {
                    } */
                }).finally(() => {
                    // Ocultar el loading cuando la solicitud termina (éxito o error)
                });
            }
        },
        mounted(){
            this.idam = "{{ $idam }}";
            this.rowsProjects();
            $(".tips").tooltip();
        },
        updated(){
            $(".tips").tooltip();
        }
    });
</script>		
@stop