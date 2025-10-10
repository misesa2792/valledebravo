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
  
  <main class="page-content row bg-body" id="app_pbrmc">
    
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
                  <div class="col-md-12">

                    
                  <div class="toolbar-line ">
                    <div class="col-md-7"></div>
                    <div class="col-md-5 no-padding">
                          <table class="table border-gray">
                            <tr class="t-tr-s12">
                              <th class="text-center border-gray" colspan="5">Trimeste Completo</th>
                            </tr>
                            <tr class="t-tr-s12">
                              <td></td>
                              <td class="text-center c-white bg-yellow-meta">1</td>
                              <td class="text-center c-white bg-green-meta">2</td>
                              <td class="text-center c-white bg-blue-meta">3</td>
                              <td class="text-center c-white bg-red-meta">4</td>
                            </tr>

                            <tr class="t-tr-s12">
                            <th class="text-right no-borders">Bloquear</th>
                              <td @click.prevent="cambiarPermisoAll(1,1)" class="text-center s-14 cursor border-gray">
                                <div class="text-center s-14 fa fa-unlock-alt"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(2,1)" class="text-center s-14 cursor border-gray">
                              <div class="text-center s-14 fa fa-unlock-alt"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(3,1)" class="text-center s-14 cursor border-gray">
                              <div class="text-center s-14 fa fa-unlock-alt"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(4,1)" class="text-center s-14 cursor border-gray">
                              <div class="text-center s-14 fa fa-unlock-alt"></div>
                              </td>
                              </tr>
                              
                            <tr class="t-tr-s12">
                              <th class="text-right no-borders">Desbloquear</th>
                              <td @click.prevent="cambiarPermisoAll(1,0)" class="text-center s-14 cursor border-gray">
                                <div class="text-center s-16 fa fa-unlock"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(2,0)" class="text-center s-14 cursor border-gray">
                                <div class="text-center s-16 fa fa-unlock"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(3,0)" class="text-center s-14 cursor border-gray">
                                <div class="text-center s-16 fa fa-unlock"></div>
                              </td>
                              <td @click.prevent="cambiarPermisoAll(4,0)" class="text-center s-14 cursor border-gray">
                                <div class="text-center s-16 fa fa-unlock"></div>
                              </td>
                            </tr>
                          </table>
                    </div>
                    
                  </div> 	

                    <table class="table table-bordered table-hover">
                      <tr class="t-tr-s12">
                        <th>Dependencia General</th>
                        <th>Dependencia Auxiliar</th>
                        <th>Número</th>
                        <th>Proyecto</td>
                        <th width="40" class="text-center c-white bg-yellow-meta">1</th>
                        <th width="40" class="text-center c-white bg-green-meta">2</th>
                        <th width="40" class="text-center c-white bg-blue-meta">3</th>
                        <th width="40" class="text-center c-white bg-red-meta">4</th>
                      </tr>
                      <template v-for="row in info">
                        <tr class="t-tr-s12">
                          <td :rowspan="row.rows.length + 1">@{{ row.nodg }} @{{ row.dg }}</td>
                        </tr>
                        <template v-for="r in row.rows">
                          <tr class="t-tr-s12">
                            <td>@{{ r.nda }} @{{ r.da }}</td>
                            <td class="text-center">@{{ r.nop }}</td>
                            <td>@{{ r.pro }}</td>
                            <td>
                              <button type="button" :class="'btn btn-sm btn-ses b-r-5 '+(r.a1 == 0 ? 'btn-success' : 'btn-danger')"  @click.prevent="cambiarPermiso(r,r.a1,1)"> 
                                <i :class="'fa '+(r.a1 == 0 ? ' fa-unlock' : 'fa-unlock-alt')"></i> 
                              </button>
                            </td>
                            <td>
                              <button type="button" :class="'btn btn-sm btn-ses b-r-5 '+(r.a2 == 0 ? 'btn-success' : 'btn-danger')"  @click.prevent="cambiarPermiso(r,r.a2,2)"> 
                                <i :class="'fa '+(r.a2 == 0 ? ' fa-unlock' : 'fa-unlock-alt')"></i> 
                              </button>
                            </td>
                            <td>
                              <button type="button" :class="'btn btn-sm btn-ses b-r-5 '+(r.a3 == 0 ? 'btn-success' : 'btn-danger')"  @click.prevent="cambiarPermiso(r,r.a3,3)"> 
                                <i :class="'fa '+(r.a3 == 0 ? ' fa-unlock' : 'fa-unlock-alt')"></i> 
                              </button>
                            </td>
                            <td>
                              <button type="button" :class="'btn btn-sm btn-ses b-r-5 '+(r.a4 == 0 ? 'btn-success' : 'btn-danger')"  @click.prevent="cambiarPermiso(r,r.a4,4)"> 
                                <i :class="'fa '+(r.a4 == 0 ? ' fa-unlock' : 'fa-unlock-alt')"></i> 
                              </button>
                            </td>
                          </tr>
                        </template>
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

     var pbrmc = new Vue({
        el:'#app_pbrmc',
        data:{
            info : [],
            contador:0,
            idy:0,
            year:0,
            type:0,
            cancelTokenSource: null,
            isLoading:false
      },
        methods:{
           rowsMetas(){
              this.isLoading = true;
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.get('{{ URL::to("reporte/projectpermits") }}',{
                  params : {type: this.type,idy:this.idy},
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

            },cambiarPermiso(row,numero,trim){
              swal({
                title : row.pro,
                text: 'Estás seguro de cambiar el permiso del trimestre #'+trim+'?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
              }).then((willOk) => {
                if(willOk){
                  this.cambiarPermisometa(row.id,numero,trim);
                }
              })
            },cambiarPermisometa(idr,numero,trim){
                axios.post('{{ URL::to("reporte/changepermission") }}',{
                    params : {idr:idr,trim:trim,numero:numero}
                }).then(response => {
                  let row = response.data;
                  if(row.status == "ok"){
                    toastr.success(row.message);
                    this.rowsMetas();
                  }else{
                  toastr.error("Error al cambiar el permiso!");
                  }
                })
            },cambiarPermisoAll(trim,numero){
              swal({
                title : (numero == 1 ? 'Bloquear Trim #'+trim : 'Desbloquear Trim #'+trim ),
                text: 'Estás seguro de cambiar el permiso a todos los proyectos del trimestre #'+trim+'?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
              }).then((willOk) => {
                if(willOk){
                  this.cambiarPermisometaAll(trim,numero);
                }
              })	
            },cambiarPermisometaAll(trim,numero){
                axios.post('{{ URL::to("reporte/changepermissiontrim") }}',{
                    params : {trim:trim,idy:this.idy,numero:numero,type:this.type}
                }).then(response => {
                    let row = response.data;
                    if(row.status == "ok"){
                      toastr.success(row.message);
                      this.rowsMetas();
                    }else{
                      toastr.error("Error al cambiar el permiso!");
                    }
                });
            },
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