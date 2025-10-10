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

      <div class="col-md-10 no-padding">
          <div class="page-title">
            <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
          </div>

          <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li><i>Ejercicio Fiscal - {{ $year }}</i></li>
            <li><i>{{ $row->numero }} {{ $row->area }}</i></li>
            <li><i>{{ $row->no_coord }} {{ $row->coordinacion }}</i></li>
            <li class="active"><i>Traspasos</i></li>
          </ul>	  
    </div> 

      <div class="col-md-2">
        <div class="c-blue font-bold b-r-5 bg-white p-xs text-center">
            <div><i>Ejercicio Fiscal</i></div>
            <div>{{ $year }}</div>
        </div>
    </div>
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
                  class="tips btn btn-sm btn-primary btn-outline btn-ses" title="Agregar Traspaso Interno" @click.prevent="addTraspasoTI(1)">
                <i class="fa fa-plus-circle"></i> Agregar Traspaso Interno
              </button>

              <button 
                  type="button" 
                  class="tips btn btn-sm btn-danger btn-outline btn-ses" title="Agregar Traspaso Externo" @click.prevent="addTraspasoTE(2)">
                <i class="fa fa-plus-circle"></i> Agregar Traspaso Externo
              </button>

            </div>
            <div class="col-md-8">
              <div v-if="rowsData.length == 0" class="c-text-alt s-14">No se encontraron Transpasos Internos del año @{{ year }}!</div>
            </div>
          </article>

          <article class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto ">
            <div class="col-md-12 no-padding m-t-md"  style="min-height:350px">

              <table class="table table-hover no-margins border-gray table-ses"  v-if="rowsData.length > 0">
                <thead>
                  <tr class="t-tr-s14 c-text">
                    <th class="text-center" width="10">#</th>
                    <th class="text-center" width="10"></th>
                    <th class="text-center" width="60">ESTATUS</th>
                    <th class="text-center" width="60">FECHA</th>
                    <th class="text-center" width="60">OFICIO</th>
                    <th class="text-center">PROYECTO</th>
                    <th class="text-center" width="30%">JUSTIFICACIÓN</th>
                    <th class="text-center">IMPORTE</th>
                    <th class="text-center" width="60">DICTAMEN DE RECONDUCCIÓN</th>
                    <th class="text-center" width="60">NOTA DE RECONDUCCIÓN</th>
                    <th class="text-center" width="60">TRASPASO</th>
                  </tr>
                </thead>
            
                <tbody>
                  <template v-for="(row,index) in rowsData">
                      <tr class="t-tr-s14 c-text-alt">
                          <td class="text-center">
                            <div class="btn-group" v-if="row.std_delete == 1 && row.number != ''">
                              <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-primary-alt"></span></button>
                                <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                    <li><a href="#" @click.prevent="editTranspaso(row.id)"><i class="fa fa-edit fun"></i> Editar</a></li>
                                    @if(\Auth::user()->group_id == 8 || \Auth::user()->group_id == 1)
                                      <li><a href="#" @click.prevent="reverseTranspaso(row)"><i class="fa fa-exchange lit"></i> Revertir Transpaso</a></li>
                                      <li><a href="#" @click.prevent="reverseNota(row)"><i class="fa fa-exchange lit"></i> Revertir Nota de Reconducción</a></li>
                                      <li><a href="#" @click.prevent="reverseRec(row)"><i class="fa fa-exchange lit"></i> Revertir Dictamen de Reconducción</a></li>
                                      <li><a href="#" @click.prevent="destroyTranspaso(row,2)"><i class="fa fa-check-circle c-success"></i> Autorizar</a></li>
                                      <li><a href="#" @click.prevent="destroyTranspaso(row,3)"><i class="fa fa-times c-black"></i> Cancelar</a></li>
                                    @endif
                                </ul>
                            </div>
                          </td>
                          <td class="text-center">
                            <div class="label label-primary tips" title="Transpaso Interno" v-if="row.type == 1">TI</div>
                            <div class="label label-danger tips" title="Transpaso Externo" v-if="row.type == 2">TE</div>
                          </td>
                          <td class="text-center">
                            <div v-if="row.std_delete == 1" class="badge badge-warning tips" title="En proceso">En Proceso</div>
                            <div v-else-if="row.std_delete == 2" class="badge badge-success tips" title="Autorizado">Autorizado</div>
                            <div v-else-if="row.std_delete == 3" class="badge badge-black tips" title="Cancelado">Cancelado</div>
                          </td>
                          <td>@{{ row.fecha_rg }}</td>
                          <td class="text-center">@{{ row.oficio }}</td>
                          <td>
                            <strong class="c-text-alt">@{{ row.no_proyecto }}</strong>
                            <div>@{{ row.proyecto }}</div>
                            <div class="c-danger" v-if="row.type == 2">
                              <i class="fa fa-mail-forward"></i> @{{ row.no_dep_gen+''+row.no_dep_aux+' '+row.dep_aux }}
                            </div>
                          </td>
                          <td>@{{ row.justificacion }}</td>
                          <td class="text-right c-blue">@{{ row.importe }}</td>

                          <td class="text-center">
                            <div v-if="row.pdfrec != null && row.pdfrec != ''">
                              <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width tips" title="Descargar PDF" @click.prevent="downloadPDF(row.pdfrec)">
                                <i class="fa icon-file-pdf s-12"></i> Descargar PDF
                              </button>
                            </div>
                           <div v-else>
                            <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar Dictamen de Reconducción" @click.prevent="generarRecPDF(row.id)">
                              <i class="fa icon-file-pdf s-12"></i> Generar Reconducción
                            </button>
                           </div>
                          </td>

                          <td class="text-center">
                            <div v-if="row.pdfnota != null && row.pdfnota != ''">
                              <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width tips" title="Descargar PDF" @click.prevent="downloadPDF(row.pdfnota)">
                                <i class="fa icon-file-pdf s-12"></i> Descargar PDF
                              </button>
                            </div>
                           <div v-else>
                            <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar Nota" @click.prevent="generarNotaPDF(row.id)">
                              <i class="fa icon-file-pdf s-12"></i> Generar Nota
                            </button>
                           </div>
                          </td>
                          <td class="text-center">

                             <div v-if="row.std_delete == 1">
                                <div v-if="row.number != null && row.number != ''">
                                    <button type="button" class="btn btn-xs btn-danger btn-ses btn-outline full-width tips" title="Descargar PDF" @click.prevent="downloadPDF(row.number)">
                                      <i class="fa icon-file-pdf s-12"></i> Descargar PDF
                                    </button>
                                </div>
                                <div v-else>

                                  <div v-if="row.type == 1">
                                    <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar PDF del Traspaso Interno" @click.prevent="generarPDFTI(row.id)">
                                      <i class="fa icon-file-pdf s-12"></i> Generar PDF
                                    </button>
                                  </div>
                                  <div v-if="row.type == 2">
                                    <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar PDF del Traspaso Externo" @click.prevent="generarPDFTE(row.id)">
                                      <i class="fa icon-file-pdf s-12"></i> Generar PDF
                                    </button>
                                  </div>
                                  
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
              addTraspasoTI(type){
                modalMisesa("{{ URL::to($pageModule.'/transpasoti') }}",{k:this.token,idyear:this.idyear,year:this.year,type:type},"Agregar Transpaso "+(type == 1 ? "Interno " : "Externo ")+this.year,"95%");
              },addTraspasoTE(type){
                modalMisesa("{{ URL::to($pageModule.'/transpasote') }}",{k:this.token,idyear:this.idyear,year:this.year,type:type},"Agregar Transpaso "+(type == 1 ? "Interno " : "Externo ")+this.year,"95%");
              },generarPDFTI(id){
                modalMisesa("{{ URL::to($pageModule.'/generateti') }}",{k:this.token,idyear:this.idyear,year:this.year, id:id},"Generar PDF del Transpaso Interno "+this.year,"85%");
              },generarPDFTE(id){
                modalMisesa("{{ URL::to($pageModule.'/generatete') }}",{k:this.token,idyear:this.idyear,year:this.year, id:id},"Generar PDF del Transpaso Externo "+this.year,"85%");
              },generarNotaPDF(id){
                modalMisesa("{{ URL::to($pageModule.'/generatenota') }}",{k:this.token,idyear:this.idyear,year:this.year, id:id},"Generar PDF de la Nota de reconducción "+this.year,"95%");
              },generarRecPDF(id){
                modalMisesa("{{ URL::to($pageModule.'/generaterec') }}",{k:this.token,idyear:this.idyear,year:this.year, id:id},"Generar PDF Dictamen de Reconducción "+this.year,"95%");
              },downloadPDF(number){
                window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
              },editTranspaso(id){
                modalMisesa("{{ URL::to($pageModule.'/edit') }}",{k:this.token,idyear:this.idyear, id:id},"Editar Transpaso Interno "+this.year,"95%");
              },reverseTranspaso(row){
                swal({
                    title : 'Estás seguro de revertir el PDF del transpaso?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to($pageModule."/reverse") }}',{
                            params : {k:this.token,id:row.id, number:row.number}
                        }).then(response => {
                            let row = response.data;
                            if(row.status == "ok"){
                              this.rowsProjects();
                            }
                        })
                    }
                })
              },reverseNota(row){
                swal({
                    title : 'Estás seguro de revertir el PDF de la Nota de reconducción?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to($pageModule."/reversenota") }}',{
                            params : {k:this.token,id:row.id, number:row.number}
                        }).then(response => {
                            let row = response.data;
                            if(row.status == "ok"){
                              this.rowsProjects();
                            }
                        })
                    }
                })
              },reverseRec(row){
                swal({
                    title : 'Estás seguro de revertir el PDF del Dictamen de reconducción?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to($pageModule."/reverserec") }}',{
                            params : {k:this.token,id:row.id, number:row.number}
                        }).then(response => {
                            let row = response.data;
                            if(row.status == "ok"){
                              this.rowsProjects();
                            }
                        })
                    }
                })
              },destroyTranspaso(row,numero){
                if(numero == 2){
                  swal({
                      title : 'Estás seguro de AUTORIZAR el transpaso interno?',
                      icon : 'success',
                      buttons : true,
                      dangerMode : true
                  }).then((willDelete) => {
                      if(willDelete){
                          axios.delete('{{ URL::to($pageModule."/transpaso") }}',{
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
                      title : 'Estás seguro de CANCELAR el transpaso interno?',
                      icon : 'warning',
                      buttons : true,
                      dangerMode : true
                  }).then((willDelete) => {
                      if(willDelete){
                          axios.delete('{{ URL::to($pageModule."/transpaso") }}',{
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