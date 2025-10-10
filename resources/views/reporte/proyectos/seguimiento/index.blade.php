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
                          <th>Dependencia General</th>
                          <th>Programa</th>
                          <th>Nombre de la acción</th>
                          <th>Unidad de medida</th>
                          <th width="5" class="no-borders"></th>
                          <th class="c-white text-center bg-pink">Programación Anual</th>
                          <th width="5" class="no-borders"></th>
                          <th class="c-white text-center bg-yellow-meta">Prog. 1er Trimestre</th>
                          <th class="c-white text-center bg-yellow-meta">Avance 1ER Trimestre</th>
                          <th width="5" class="no-borders"></th>
                          <th class="c-white text-center bg-green-meta">Prog. 2DO Trimestre</th>
                          <th class="c-white text-center bg-green-meta">Avance 2do Trimestre</th>
                          <th width="5" class="no-borders"></th>
                          <th class="c-white text-center bg-blue-meta">Prog. 3er Trimestre</th>
                          <th class="c-white text-center bg-blue-meta">Avance 3er Trimestre</th>
                          <th width="5" class="no-borders"></th>
                          <th class="c-white text-center bg-red-meta">Prog. 4to Trimestre</th>
                          <th class="c-white text-center bg-red-meta">Avance 4to Trimestre</th>
                      </tr>
                      <template v-for="row in info">
                        <tr class="t-tr-s12">
                          <td>@{{ row.no_area }}</td>
                          <td>@{{ row.no_programa }}</td>
                          <td>@{{ row.accion }}</td>
                          <td>@{{ row.unidad_medida }}</td>
                          <td class="no-borders"></td>
                          <th :class="'text-center ' + (row.programacion_anual > 0 ? 'success' : 'danger')"> @{{ row.programacion_anual > 0 ? row.programacion_anual : '' }}</th>
                          <td class="no-borders"></td>
                          <th :class="'text-center ' + (row.trim_1 > 0 ? 'success' : 'danger')"> @{{ row.trim_1 > 0 ? row.trim_1 : '' }}</th>
                          <th :class="'text-center ' + (row.cant_1 > 0 ? 'info' : 'danger')"> @{{ row.cant_1 > 0 ? row.cant_1 : '' }}</th>
                          <td class="no-borders"></td>
                          <th :class="'text-center ' + (row.trim_2 > 0 ? 'success' : 'danger')"> @{{ row.trim_2 > 0 ? row.trim_2 : '' }}</th>
                          <th :class="'text-center ' + (row.cant_2 > 0 ? 'info' : 'danger')"> @{{ row.cant_2 > 0 ? row.cant_2 : '' }}</th>
                          <td class="no-borders"></td>
                          <th :class="'text-center ' + (row.trim_3 > 0 ? 'success' : 'danger')"> @{{ row.trim_3 > 0 ? row.trim_3 : '' }}</th>
                          <th :class="'text-center ' + (row.cant_3 > 0 ? 'info' : 'danger')"> @{{ row.cant_3 > 0 ? row.cant_3 : '' }}</th>
                          <td class="no-borders"></td>
                          <th :class="'text-center ' + (row.trim_4 > 0 ? 'success' : 'danger')"> @{{ row.trim_4 > 0 ? row.trim_4 : '' }}</th>
                          <th :class="'text-center ' + (row.cant_4 > 0 ? 'info' : 'danger')"> @{{ row.cant_4 > 0 ? row.cant_4 : '' }}</th>
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
            idy:0,
            year:0,
            type:0,
            cancelTokenSource: null,
            isLoading:false
      },
        methods:{
          exportInfo(){
            swal({
                title : 'Exportar' ,
                text: 'Estás seguro de exportar la información a Excel?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
              }).then((willOk) => {
                if(willOk){
                  window.open('{{ URL::to("reporte/segmetasexportar?idy=") }}'+this.idy+'&type='+this.type, '_blank');
                }
              })
          },
          rowsMetas(){
              this.isLoading = true;
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.get('{{ URL::to("reporte/segmetas") }}',{
                  params : {idy:this.idy, type: this.type},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  this.info = [];
                  this.info = response.data;
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
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