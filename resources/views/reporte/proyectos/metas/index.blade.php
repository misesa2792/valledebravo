@extends('layouts.main')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  $idu = Auth::user()->id;
  /*--}}

<main class="page-content row bg-body">
    
    @if($type == 0)
      @include('reporte.include.menumetas')
    @else 
      @include('reporte.include.menuindicadores')
    @endif

      <section class="page-content-wrapper no-padding" id="app_metas">
        <div class="sbox animated fadeInRight ">
          <div class="sbox-title border-t-yellow"> 
            <div class="col-md-8">
              <h4> {{ $activeName }}</h4>
            </div>
            <div class="col-md-4 text-right">
                <button type="button" class="tips btn btn-xs btn-success b-r-30 btn-ses" title="Agregar proyecto con metas" @click.prevent="addProyecto"><i class="fa fa-plus-circle"></i> Agregar Proyecto</button>
            </div>
          </div>
          <div class="sbox-content bg-white"> 	

            <div class="table-resp">

                <div class="col-md-12 m-b">
                    <table class="table no-margins b-gray bg-white">
                        <tbody>
                            <tr>
                                <td class="no-borders">
                                    <div class="s-14 c-text-alt">Dependencia General</div>
                                    <input type="text" v-model="dep_gen" class="form-control" placeholder="Dependencia general">
                                </td>
                                 <td class="no-borders">
                                    <div class="s-14 c-text-alt">Dependencia Auxiliar</div>
                                    <input type="text" v-model="dep_aux" class="form-control" placeholder="Dependencia auxiliar">
                                </td>
                                <td class="no-borders">
                                    <div class="s-14 c-text-alt">No. Proyecto</div>
                                    <input type="text" v-model="no_proyecto" class="form-control" placeholder="Número de proyecto">
                                </td>
                                <td class="no-borders">
                                    <div class="s-14 c-text-alt">Proyecto</div>
                                    <input type="text" v-model="proyecto" class="form-control" placeholder="Nombre del proyecto">
                                </td>
                                <td class="text-center no-borders" width="30">
                                    <div class="s-14 c-text-alt">Buscar</div>
                                    <button type="button" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar" @click.prevent="search"><i class="fa fa-search fun"></i> Buscar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

              <div class="col-md-12" style="min-height:650px;">

                 <table class="table table-bordered bg-white table-hover">
                  <tr class="text-center font-bold">
                    <td>Dependencia General</td>
                    <td colspan="3">Dependencia Auxiliar</td>
                    <td colspan="2">Proyecto</td>
                  </tr>
                  <template v-for="row in rowsData">
                    <tr>
                      <td :rowspan="row.rows.length + 1">@{{ row.no_dep_gen }} @{{ row.dep_gen }}</td>
                    </tr>
                    <tr v-for="(v,kke) in row.rows">
                      <td width="30">
                          <div class="btn-group">
                              <button type="button" class="btn btn-ses btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                              <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                  <li><a href="#" @click.prevent="editMeta(v.id)"><i class="fa fa-edit c-blue cursor"></i> Editar Metas</a></li>
                                  <li><a href="#" @click.prevent="moveMeta(v.id)"><i class="fa fa-random c-yellow cursor"></i> Transferir Proyecto</a></li>
                                  <li><a href="#" @click.prevent="deleteProyecto(v.id)"><i class="fa fa-trash-o c-danger cursor"></i> Eliminar Proyecto</a></li>
                              </ul>
                          </div>
                      </td>
                      <td width="40" class="text-center">@{{ v.no_dep_aux }}</td>
                      <td>@{{ v.dep_aux }}</td>
                      <td width="40" class="text-center">@{{ v.no_proyecto }}</td>
                      <td>@{{ v.proyecto }}</td>
                    </tr>
                  </template>
                    
                 
                </table>
                
              </div>
            </div>

          </div>
        </div>		 
      </section>
</main>	

<script>
  $(document).on("click",".btnagregarum",function(e){
    e.preventDefault();
    let id = $(this).attr("id");
    modalAvance("{{ URL::to('anteproyecto/addum') }}",{id:id},"Agregar nueva Unidad de Medida","40%");
  })

     const app = Vue.createApp({
          data() {
            return {
              rowsData: [],
              idy: 0,
              type:0,
              cancelTokenSource: null,
              proyecto:'',
              no_proyecto:'',
              dep_gen:'',
              dep_aux:''
            };
          },
          methods:{
            search(){
              this.rowsProjects();
            },
            editMeta(id){
              modalMisesa("{{ URL::to('reporte/editmeta') }}",{id:id},"Editar Meta","95%");
            },
            addProyecto(){
              modalMisesa("{{ URL::to('reporte/addmeta') }}",{idy: this.idy},"Agregar nuevo proyecto con meta","95%");
            },moveMeta(id){
              modalMisesa("{{ URL::to('reporte/movemeta') }}",{id:id, idy: this.idy},"Transferir proyecto con metas a otra dependencia","95%");
            },
            deleteProyecto(id){
              swal({
                    title : 'Eliminar Proyecto',
                    text: '¿Estás seguro de que deseas eliminar el proyecto junto con todas sus metas? Esta acción es irreversible.',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.delete('{{ URL::to("reporte/metafull") }}',{
                            params : {id:id}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                this.rowsProjects();
                            }else{
                                toastr.error(row.message);
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

              axios.get('{{ URL::to("reporte/metasproyectosall") }}',{
                params : {idy: this.idy, type: this.type, nop: this.no_proyecto, proy: this.proyecto,dg: this.dep_gen,da: this.dep_aux},
                cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                var row = response.data;
                if(row.status == 'ok'){
                  this.rowsData = row.data;
                }else{
                  toastr.error(row.message);
                }
              }).catch(error => {
              }).finally(() => {
              });
            }
          },
          mounted(){
            this.idy = "{{ $idy }}";
            this.rowsProjects();
          }
  });
  var appMetas = app.mount('#app_metas');
</script>
@stop