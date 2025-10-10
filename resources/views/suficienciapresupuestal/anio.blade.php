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
        <h3 class="c-blue s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
        <li>{{ $row->institucion }}</li>
        <li><a href="{{ URL::to($pageModule.'?k='.$token) }}">{{ $row->area }}</a></li>
        <li class="active">{{ $row->coordinacion }}</li>
      </ul>	  
	  </section>

    <div class="col-md-12 no-padding m-t-md m-b-md">
      <div class="col-md-12 p-rel">
          <ul class="nav nav-tabs text-right">
              <li>
                <button type="button" onclick="location.href='{{ URL::to($pageModule.'/principal?k='.$token.'&idy='.$idy.'&year='.$year) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
                  <i class="fa  fa-arrow-circle-left "></i> Regresar
                </button>
              </li>
              <li>
                  <button type="button" class="btn bg-blue c-white tips" @click.prvent="selectYear()" :title="year">
                      <i class="fa fa-calendar s-14"></i> @{{ year }}
                  </button>
              </li>
          </ul>
      </div>
  </div>


  <card-loading v-if="isLoading"></card-loading>
  <div class="col-md-12 m-t-md" v-else>

  <div class="col-md-12">
    <article class="col-sm-12 col-md-12 col-lg-12">
        
      <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">

        <span class="line-circle-a text-center font-bold tips" :title="year">@{{ year }}</span>
        
        <div class="col-sm-12 col-md-12 col-lg-12 bg-white b-r-5 p-md b-r-c" id="line-comm">

          <article class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto com no-padding" >
            <div class="col-md-4">
              <button 
                  type="button" 
                  class="tips btn btn-sm btn-primary btn-outline btn-ses" title="AGREGAR SOLICITUD DE SUFICIENCIA PRESUPUESTAL PARA ADQUISICIÓN DE BIENES" @click.prevent="addSolicitudBienes">
                <i class="fa fa-plus-circle"></i> Solicitud de Bienes
              </button>

              <button 
              type="button" 
              class="tips btn btn-sm btn-danger btn-outline btn-ses" title="AGREGAR SOLICITUD DE SUFICIENCIA PRESUPUESTAL PARA SERVICIOS" @click.prevent="addSolicitudServicios">
            <i class="fa fa-plus-circle"></i> Solicitud de Servicios
          </button>
            </div>
            <div class="col-md-8">
              <div v-if="rowsData.length == 0" class="c-text-alt s-14">No se encontraron solicitudes presupuestales del año @{{ year }}!</div>
            </div>
          </article>

          <article class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto ">
            <div class="col-md-12 m-t-md">

              <table class="table table-hover no-margins border-gray table-ses"  v-if="rowsData.length > 0">
                <thead>
                  <tr class="t-tr-s14 c-text">
                    <th class="text-center" width="10">#</th>
                    <th class="text-center" width="20"></th>
                    <th class="text-center" width="60">ESTATUS</th>
                    <th class="text-center" width="60">FECHA</th>
                    <th class="text-center" width="60">FOLIO</th>
                    <th>PROYECTO</th>
                    <th>TIPO RECURSO</th>
                    <th class="text-center">OBSERVACIONES</th>
                    <th class="text-center">IMPORTE</th>
                    <th class="text-center" width="60">ACCION</th>
                  </tr>
                </thead>
            
                <tbody>
                  <template v-for="(row,index) in rowsData">

                      <tr class="t-tr-s14 c-text-alt">
                          <td class="text-center">
                            <div class="btn-group"  v-if="row.std_delete == 1">
                              <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-primary-alt"></span></button>
                                <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                    <li v-if="row.number == null || row.number == ''"><a href="#" @click.prevent="editSuficiencia(row)"><i class="fa fa-edit fun"></i> Editar</a></li>
                                    @if(\Auth::user()->group_id == 8 || \Auth::user()->group_id == 1)
                                      <li v-if="row.number != null && row.number != ''"><a href="#" @click.prevent="reverseSuficiencia(row)"><i class="fa fa-exchange lit"></i> Revertir PDF</a></li>
                                      <li v-if="row.number != null && row.number != ''"><a href="#" @click.prevent="destroySuficiencia(row,2)"><i class="fa fa-check-circle c-success"></i> Autorizar</a></li>
                                      <li v-if="row.number != null && row.number != ''"><a href="#" @click.prevent="destroySuficiencia(row,3)"><i class="fa fa-times c-black"></i> Cancelar</a></li>
                                    @endif
                                </ul>
                            </div>
                          </td>
                          <td class="text-center">
                            <span class="label label-primary full-width tips" title="Bienes" v-if="row.type == 1">BI</span>
                            <span class="label label-danger full-width tips" title="Servicios" v-if="row.type == 2">SE</span>
                          </td>
                          <td class="text-center">
                            <div v-if="row.std_delete == 1" class="badge badge-warning tips" title="En proceso">En Proceso</div>
                            <div v-else-if="row.std_delete == 2" class="badge badge-success tips" title="Autorizado">Autorizado</div>
                            <div v-else-if="row.std_delete == 3" class="badge badge-black tips" title="Cancelado">Cancelado</div>
                          </td>
                          <td>@{{ row.fecha_rg }}</td>
                          <td class="text-center">@{{ row.folio }}</td>
                          <td>
                            <strong class="c-text-alt">@{{ row.no_proyecto }}</strong>
                            <div>@{{ row.proyecto }}</div>
                          </td>
                          <td class="text-center">@{{ row.no_fuente }}</td>
                          <td>@{{ row.obs }}</td>
                          <td></td>
                          <td class="text-center">
                            <div v-if="row.std_delete == 1">
                                <div v-if="row.number != null && row.number != ''">
                                  <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width tips" title="Descargar PDF" @click.prevent="downloadPDF(row.number)">
                                  <i class="fa icon-file-pdf s-12"></i> Descargar PDF
                                  </button>
                                </div>
                                <div v-else>
                                  <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar PDF" @click.prevent="generarPDF(row.id, row.type)">
                                    <i class="fa icon-file-pdf s-12"></i> Generar PDF
                                  </button>
                                </div>
                            </div>
                            <div v-else-if="row.std_delete == 2">
                              <div v-if="row.number != null && row.number != ''">
                                <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width tips" title="Descargar PDF" @click.prevent="downloadPDF(row.number)">
                                <i class="fa icon-file-pdf s-12"></i> Descargar PDF
                                </button>
                              </div>
                            </div>

                          </td>
                      </tr>
                      
                  </template>
                </tbody>
              </table>
              
            </div>
          </article>
          
        </div>
      </section>
      
    </article>
  </div>

  <div class="col-md-12">
    <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
      <section class="col-sm-12 col-md-12 col-lg-12 p-md">
        <span class="line-circle-a text-center font-bold tips" title="Inicio"><i class="fa fa-calendar s-16"></i></span>
        
      </section>
    
    </article>
  </div>
  </div>


  </main>	

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
                    rowsTotales : [],
                    rowsYears : [],
                    token:0,
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
              addSolicitudBienes(){
                modalMisesa("{{ URL::to($pageModule.'/bienes') }}",{k:this.token,idyear:this.idyear,year:this.year},"Agregar Solicitud Presupuestal de Bienes "+this.year,"95%");
              },addSolicitudServicios(){
                modalMisesa("{{ URL::to($pageModule.'/servicios') }}",{k:this.token,idyear:this.idyear,year:this.year},"Agregar Solicitud Presupuestal de Servicios "+this.year,"95%");
              },generarPDF(id, type){
                modalMisesa("{{ URL::to($pageModule.'/generate') }}",{k:this.token,idyear:this.idyear,year:this.year, id:id, type:type},"Generar PDF de la Solicitud de suficiencia presupuestal "+(type == 1 ? "Bienes " : "Servicios ")+this.year,"85%");
              },downloadPDF(number){
                window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
              },editSuficiencia(row){
                modalMisesa("{{ URL::to($pageModule.'/edit') }}",{k:this.token, idyear:this.idyear, id:row.id, type:row.type},"Editar suficiencia presupuestal "+(row.type == 1 ? "Bienes " : "Servicios ")+this.year,"95%");
              },reverseSuficiencia(row){
                swal({
                    title : 'Estás seguro de revertir el PDF?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.post('{{ URL::to($pageModule."/reverse") }}',{
                            params : {k:this.token,id:row.id, number:row.number}
                        }).then(response => {
                            let row = response.data;
                            if(row.status == "ok"){
                              this.rowsProjects();
                            }
                        })
                    }
                })
              },destroySuficiencia(row,numero){

                if(numero == 2){
                  swal({
                      title : 'Estás seguro de AUTORIZAR la solicitud?',
                      icon : 'success',
                      buttons : true,
                      dangerMode : true
                  }).then((willDelete) => {
                      if(willDelete){
                          axios.delete('{{ URL::to($pageModule."/suficienciapres") }}',{
                              params : {k:this.token,id:row.id,numero:numero}
                          }).then(response => {
                              let row = response.data;
                                if(row.status == "ok"){
                                toastr.success(row.message);
                                this.rowsProjects();
                              }
                          })
                      }
                  })
                }else if(numero == 3){
                  swal({
                      title : 'Estás seguro de CANCELAR la solicitud?',
                      icon : 'warning',
                      buttons : true,
                      dangerMode : true
                  }).then((willDelete) => {
                      if(willDelete){
                          axios.delete('{{ URL::to($pageModule."/suficienciapres") }}',{
                              params : {k:this.token,id:row.id,numero:numero}
                          }).then(response => {
                              let row = response.data;
                              if(row.status == "ok"){
                                toastr.success(row.message);
                                this.rowsProjects();
                              }
                          })
                      }
                  })
                }

              },rowsProjects(){
                   this.isLoading = true;
    
                    if (this.cancelTokenSource) {
                        this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
                    }
    
                    // Crear un nuevo token de cancelación
                    this.cancelTokenSource = axios.CancelToken.source();
    
                    axios.get('{{ URL::to($pageModule."/data") }}',{
                        params : {k:this.token,idyear:this.idyear},
                        cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                    }).then(response => {
    
                        var row = response.data;
                        if(row.response == 'error'){
                            toastr.error(row.text);
                        }else{
                            this.rowsData = row.rowsData;
                        }
                       
                    }).catch(error => {
                        /*if (axios.isCancel(error)) {
                        } */
                    }).finally(() => {
                        // Ocultar el loading cuando la solicitud termina (éxito o error)
                        this.isLoading = false;
                    });
                },selectYear(){
                    this.idyear = this.idyear;
                    this.year = this.year;
                    this.rowsProjects();
                }
                
            },
            mounted(){
              this.token = "{{ $token }}";
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