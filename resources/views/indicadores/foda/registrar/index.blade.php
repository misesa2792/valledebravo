@extends('layouts.app')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
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
  
  <main class="page-content row bg-body" id="app_foda">
    @if($type == 0)
      @include('reporte.include.menumetas')
    @else 
      @include('reporte.include.menuindicadores')
    @endif

    <section class="col-md-12 no-padding m-b-md">
      <div class="col-md-12 p-rel">
          <ul class="nav nav-tabs text-right">
                 <li>
                  <button type="button" :class="'btn tips ' + (checkActive == 1 ? 'bg-blue c-white' : 'bg-white c-text')" @click.prvent="loadTrim(1)" title="Permisos">
                      <i class="fa fa-calendar s-14"></i> Trim #1
                  </button>
                 </li>

                 <li>
                  <button type="button" :class="'btn tips ' + (checkActive == 2 ? 'bg-blue c-white' : 'bg-white c-text')" @click.prvent="loadTrim(2)" title="Permisos">
                      <i class="fa fa-calendar s-14"></i> Trim #2
                  </button>
                 </li>

                 <li>
                  <button type="button" :class="'btn tips ' + (checkActive == 3 ? 'bg-blue c-white' : 'bg-white c-text')" @click.prvent="loadTrim(3)" title="Permisos">
                      <i class="fa fa-calendar s-14"></i> Trim #3
                  </button>
                 </li>

                 <li>
                  <button type="button" :class="'btn tips ' + (checkActive == 4 ? 'bg-blue c-white' : 'bg-white c-text')" @click.prvent="loadTrim(4)" title="Permisos">
                      <i class="fa fa-calendar s-14"></i> Trim #4
                  </button>
                 </li>
          </ul>
      </div>
    </section>

    
 

    <card-loading v-if="isLoading"></card-loading>
    <div class="col-md-12 m-t-md" v-else>
        <section class="col-md-12">
          <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
            <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
                <span class="line-circle-a text-center font-bold tips" :title="year">@{{ year }} </span>
                <div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c" id="line-comm" >

                 <div class="col-md-12 m-b-md">
                    <button type="button" class="btn btn-xs btn-white" @click.prevent="exportInfo" title="Exportar"><i class="fa icon-file-excel lit"></i> Exportar</button>
                 </div>

                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">
                      <tr class="t-tr-12">
                            <th>#</th>
                            <th>Dependencia General</th>
                            <th>#</th>
                            <th>Dependencia Auxiliar</th>
                            <th>No. Programa</th>
                            <th>Programa</th>
                            <th>Fortalezas</th>
                            <th>Oportunidades</th>
                            <th>Debilidades</th>
                            <th>Amenazas</th>
                      </tr>
                      <template v-for="row in info">
                        <tr class="t-tr-s12">
                          <td>@{{ row.no_dep_gen }}</td>
                          <td>@{{ row.dep_gen }}</td>
                          <td>@{{ row.no_dep_aux }}</td>
                          <td>@{{ row.dep_aux }}</td>
                          <td>@{{ row.no_programa }}</td>
                          <td>@{{ row.programa }}</td>
                          <td>
                            <ul class="no-padding">
                                <li v-for="f in  row.f1">@{{ f }}</li>
                            </ul>
                          </td>
                          <td>
                            <ul class="no-padding">
                                <li v-for="f in  row.f2">@{{ f }}</li>
                            </ul>
                          </td>
                          <td>
                            <ul class="no-padding">
                                <li v-for="f in  row.f3">@{{ f }}</li>
                            </ul>
                          </td>
                          <td>
                            <ul class="no-padding">
                                <li v-for="f in  row.f4">@{{ f }}</li>
                            </ul>
                          </td>
                        </tr>
                      </template>
                    </table>

                  </div>
                </div>
            </section>
          </article>
        </section>
      
      <section class="col-md-12">
          <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
              <section class="col-sm-12 col-md-12 col-lg-12 p-md">
                  <span class="line-circle-a text-center font-bold tips" title="Inicio"><i class="fa fa-calendar s-16"></i></span>
              </section>
          
          </article>
      </section>

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

     var foda = new Vue({
        el:'#app_foda',
        data:{
            info : [],
            trimestre:1,
            idy:0,
            year:0,
            type:0,
            cancelTokenSource: null,
            isLoading:false
      },
      computed: {
          checkActive(){
              return this.trimestre;
          }
      },
        methods:{
          loadTrim(numero){
            this.trimestre = numero;
            this.rowsMetas();
          },
          exportInfo(){
            swal({
                title : 'Trimestre ' + this.trimestre,
                text: 'Estás seguro de exportar la información a Excel?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
              }).then((willOk) => {
                if(willOk){
                  window.open('{{ URL::to("reporte/fodaexportar?idy=") }}'+this.idy+'&type='+this.type+'&trim='+this.trimestre, '_blank');
                }
              })
          },
          rowsMetas(){
              this.info = [];
              this.isLoading = true;
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.get('{{ URL::to("reporte/foda") }}',{
                  params : {idy:this.idy, type: this.type, trim:this.trimestre},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  this.info = response.data;
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
			            toastr.error("Error, vuelve a intentar!");
              }).finally(() => {
                  // Ocultar el loading cuando la solicitud termina (éxito o error)
                  this.isLoading = false;
              });

            }
        },
        mounted(){
          this.type = "{{ $type }}";
          this.idy = "{{ $idy }}";
          this.year = "{{ $year }}";
          this.rowsMetas();
        }
    });
  </script>
  
@stop