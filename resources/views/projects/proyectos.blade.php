@extends('layouts.app')

@section('content')
  {{--*/
  $gp = Auth::user()->group_id;
  /*--}}




  <main class="page-content row bg-body" id="app_pbrma">
   
    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
      </div>

      <ul class="breadcrumb bg-body s-14">
        <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
        <li><i>Ejercicio Fiscal </i></li>
        <li class="active"><i>Proyectos</i></li>
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
            <div class="sbox-title border-t-yellow"> <h4> Dependencias Generales</h4></div>
            <div class="sbox-content bg-white" style="min-height:300px;"> 	
  
              <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com m-b-md">
                  <a href="#" class="tips btn btn-sm btn-primary btn-outline btn-ses" @click.prevent="addProyectos()" title="Agregar Proyectos"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Proyectos</a>
              </div>

                <table class="table table-hover border-gray no-margins">
                    <thead>
                         <tr class="t-tr-s14 c-text-alt">
                            <th class="no-borders">Dependencia General</th>
                            <th class="no-borders" width="5"></th>
                            <th class="no-borders">Dependencia Auxiliar</th>
                            <th class="no-borders">No. Proyecto</th>
                            <th class="no-borders">Proyecto</th>
                            <th class="no-borders" width="5"></th>
                            <th class="no-borders text-center" width="100">Presupuesto</th>
                        </tr>
                    </thead>
            
                    <tbody>
                      <template v-for="row in rowsData">
                        <tr class="c-text-alt" v-for="(v, kke) in row.rows">
                          <td v-if="kke == 0" :rowspan="row.rows.length">
                            @{{ row.no_dep_gen }} @{{ row.dep_gen }}
                          </td>
                          <td>
                            <div class="btn-group">
                              <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                              <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                  <li><a href="#" @click.prevent="editProyecto(v.id)"><i class="fa fa-edit c-blue"></i> Editar</a></li>
                                  @if($gp == 1)
                                    <li><a href="#" @click.prevent="destroyPbrm(v.id)"><i class="fa fa-trash-o var"></i> Eliminar</a></li>
                                  @endif
                                </ul>
                            </div>
                          </td>
                          <td class="c-text">@{{ v.no_dep_aux }} @{{ v.dep_aux }}</td>
                          <td class="c-text text-center">@{{ v.no_proyecto }}</td>
                          <td class="c-text">@{{ v.proyecto }}</td>
                          <td class="text-right c-black">$</td>
                          <td class="text-right ">@{{ v.importe }}</td>
                        </tr>

                      </template>
                    </tbody>
                </table>
  
            </div>
        </div>		 
      </section>
    </div>

  </main>	

	<script>
    

     var pbrma = new Vue({
        el:'#app_pbrma',
        data:{
            rowsData : [],
            idam:0,
            cancelTokenSource: null,
      },
      computed: {
      },
        methods:{
          rowsProjects(){
    
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.post('{{ URL::to($pageModule."/search") }}',{
                  params : {idam:this.idam},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  var row = response.data;
                  if(row.status == 'ok'){
                    this.rowsData = row.data;
                  }
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
              }).finally(() => {
                  // Ocultar el loading cuando la solicitud termina (éxito o error)
              });
            },destroyPbrm(id){
              swal({
                  title : 'Estás seguro de eliminar el registro?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.delete('{{ URL::to($pageModule."/proyecto") }}',{
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
            },addProyectos(){
              modalMisesa("{{ URL::to($pageModule.'/add') }}",{idam:this.idam},"Agregar Proyectos","50%");
            },editProyecto(id){
              modalMisesa("{{ URL::to($pageModule.'/edit') }}",{idam:this.idam,id:id},"Editar Proyecto","50%");
            }
        },
        mounted(){
          this.idam = "{{ $idam }}";
          this.rowsProjects();
        }
    });
  </script>
  
@stop