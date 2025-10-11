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
                <button type="button" class="tips btn btn-xs btn-success b-r-30 btn-ses" title="Agregar proyecto con indicadores" @click.prevent="addProyecto"><i class="fa fa-plus-circle"></i> Agregar Proyecto</button>
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
                    <td width="30"></td>
                    <td>Dependencia General</td>
                    <td>Dependencia Auxiliar</td>
                    <td>Proyecto</td>
                    <td width="50%">Indicadores</td>
                  </tr>
                  <template v-for="v in rowsData">
                  <tr>
                      <td width="30">
                          <div class="btn-group" v-if="v.mirs.length == 0">
                              <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                              <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                    <li><a href="#" @click.prevent="destroyProyecto(v.id)"><i class="fa fa-trash-o c-danger cursor"></i> Eliminar proyecto</a></li>
                              </ul>
                            </div>
                      </td>
                      <td>@{{ v.no_dep_gen }} @{{ v.dep_gen }}</td>
                      <td>@{{ v.no_dep_aux }} @{{ v.dep_aux }}</td>
                      <td>
                        <div>@{{ v.no_proyecto }}</div>
                        <div>@{{ v.proyecto }}</div>
                      </td>
                      <td>
                        <table class="table table-bordered no-margins">
                            <tr>
                              <td colspan="5">INDICADORES</td>
                              <td class="text-center c-white bg-yellow-meta" width="25">1</td>
                              <td class="text-center c-white bg-green-meta" width="25">2</td>
                              <td class="text-center c-white bg-blue-meta" width="25">3</td>
                              <td class="text-center c-white bg-red-meta" width="25">4</td>
                            </tr>
                            <tr v-for="m in v.mirs" :class="m.iddimension_atiende == 0 ? 'danger' : 'success'">
                              <td width="10">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                                    <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                          <li><a href="#" @click.prevent="editPbrmd(m.id)"><i class="fa fa-edit c-blue cursor"></i> Editar</a></li>
                                          <li><a href="#" @click.prevent="destroyPbrmd(m.id)"><i class="fa fa-trash-o c-danger cursor"></i> Eliminar</a></li>
                                    </ul>
                                  </div>
                              </td>
                              <td width="80">@{{ m.mir }}</td>
                              <td width="50%">@{{ m.indicador }}</td>
                              <td class="text-center s-10">@{{ m.frecuencia }}</td>
                              <td width="80" class="text-center s-10">@{{ m.formula }}</td>
                              <td class="text-center">
                                <span v-if="m.aplica1 == 1" :class="['fa', 'fa-check-circle', 'c-yellow-meta', 's-10', 'tips']" title="Aplica indicador"></span>
                                <span v-else-if="m.aplica1 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #1"></span>
                              </td>
                              <td class="text-center">
                                <span v-if="m.aplica2 == 1" :class="['fa', 'fa-check-circle', 'c-green-meta', 's-10', 'tips']" title="Aplica indicador"></span>
                                <span v-else-if="m.aplica2 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #2"></span>
                              </td>
                              <td class="text-center">
                                <span v-if="m.aplica3 == 1" :class="['fa', 'fa-check-circle', 'c-blue-meta', 's-10', 'tips']" title="Aplica indicador"></span>
                                <span v-else-if="m.aplica3 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #3"></span>
                              </td>
                              <td class="text-center">
                                <span v-if="m.aplica4 == 1" :class="['fa', 'fa-check-circle', 'c-red-meta', 's-10', 'tips']" title="Aplica indicador"></span>
                                <span v-else-if="m.aplica4 == 2" :class="['fa','fa-times','c-text-alt', 's-10','tips']" title="No Aplica el indicador en el Trim #4"></span>
                              </td>
                            </tr>
                          </table>
                      </td>
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
              type:1,
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
            editPbrmd(id){
              modalMisesa("{{ URL::to('indicadores/editindicador') }}",{id:id},"Editar Indicador","95%");
            },
            addProyecto(){
              modalMisesa("{{ URL::to('reporte/addindicador') }}",{idy: this.idy},"Agregar nuevo proyecto con meta","95%");
            },
            destroyProyecto(id){
              swal({
                    title : 'Eliminar proyecto',
                    text: '¿Estás seguro de que deseas eliminar el proyecto? Esta acción es irreversible.',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.delete('{{ URL::to("reporte/proyectofull") }}',{
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
            destroyPbrmd(id){
              swal({
                    title : 'Eliminar indicador',
                    text: '¿Estás seguro de que deseas eliminar el indicador? Esta acción es irreversible.',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.delete('{{ URL::to("reporte/indicadorfull") }}',{
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

              axios.get('{{ URL::to("reporte/indicadorproyectosall") }}',{
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
            },
            initTooltips() {
                  // Limpia instancias previas para evitar duplicados
              $(".tips").tooltip('destroy');

              // Inicializa de nuevo
              $(".tips").tooltip({
                container: 'body',      // evita issues de z-index dentro de modales
                html: true,             // si necesitas HTML en el tooltip
                trigger: 'hover focus', // por defecto
                placement: 'top'        // ajusta según necesites
              });
            }
          },
          mounted(){
            this.idy = "{{ $idy }}";
			      this.initTooltips();
            this.rowsProjects();
          },
          updated() {
            // Si tu template cambia por otras causas, asegúrate de que los tooltips sigan vivos
            this.$nextTick(() => this.initTooltips());
          },
          unmounted() {
            // Evita memory leaks al destruir el componente
            $(".tips").tooltip('destroy');
          }
          
  });
  var appMetas = app.mount('#app_metas');
</script>
@stop