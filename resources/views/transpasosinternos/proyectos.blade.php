@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body s-14">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		<li class="active"><i>Proyectos</i></li>
	  </ul>	  
  </section>
	

  <section class="table-resp m-b-lg m-t-md" style="min-height:300px;" id="app_ff">

      <div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c">
        <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com">
            <button type="button" 
                class="tips btn btn-sm btn-primary btn-outline btn-ses" title="Agregar Traspaso Interno" @click.prevent="addTraspaso(1)">
              <i class="fa fa-plus-circle"></i> Agregar Traspaso Interno
            </button>

            <button type="button" 
            class="tips btn btn-sm btn-danger btn-outline btn-ses" title="Agregar Traspaso Externo" @click.prevent="addTraspaso(2)">
          <i class="fa fa-plus-circle"></i> Agregar Traspaso Externo
        </button>
        </div>
  
        <div class="col-md-12 no-padding m-t-md">
  
          <table class="table table-hover no-margins border-gray table-ses"  v-if="rowsData.length > 0">
            <thead>
              <tr class="t-tr-s14 c-text">
                <th class="text-center" width="10">#</th>
                <th class="text-center" width="10"></th>
                <th class="text-center" width="60">ESTATUS</th>
                <th class="text-center" width="70">FECHA</th>
                <th class="text-center">DEP. GEN</th>
                <th class="text-center">DEP. AUX</th>
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
                                <li><a href="#" @click.prevent="editTranspaso(row.id,row.type)"><i class="fa fa-edit fun"></i> Editar</a></li>
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
                      <td>
                        <div>@{{ row.fecha_rg }}</div>
                        <small>@{{ row.hora_rg }}</small>
                      </td>
                      <td>
                        <strong class="c-text-alt">@{{ row.no_dep_gen }}</strong>
                        <div>@{{ row.dep_gen }}</div>
                      </td>
                      <td>
                        <strong class="c-text-alt">@{{ row.no_dep_aux }}</strong>
                        <div>@{{ row.dep_aux }}</div>
                      </td>
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
                                <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar PDF del Traspaso Interno" @click.prevent="generarPDF(row.id,1)">
                                  <i class="fa icon-file-pdf s-12"></i> Generar PDF
                                </button>
                              </div>
                              <div v-if="row.type == 2">
                                <button type="button" class="btn btn-xs btn-default btn-ses btn-outline full-width tips" title="Generar PDF del Traspaso Externo" @click.prevent="generarPDF(row.id,2)">
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
      </div>
  </section>
				
</main>	

<script>
  var proyectos = new Vue({
        el:'#app_ff',
        data:{
            rowsData : [],
            idam:0,
            iddg:0,
            cancelTokenSource: null
        },
        computed: {
           
        },
        methods:{
          addTraspaso(type){
            modalMisesa("{{ URL::to($pageModule.'/agregar') }}",{idam:this.idam,type:type},"Agregar Transpaso "+(type == 1 ? "Interno " : "Externo "),"95%");
          },addTraspasoTE(type){
            modalMisesa("{{ URL::to($pageModule.'/transpasote') }}",{k:this.token,idyear:this.idyear,year:this.year,type:type},"Agregar Transpaso "+(type == 1 ? "Interno " : "Externo ")+this.year,"95%");
          },generarPDF(id,type){
            modalMisesa("{{ URL::to($pageModule.'/generate') }}",{idam:this.idam, type:type,id:id},"Generar PDF del Transpaso ","85%");
          },generarNotaPDF(id){
            modalMisesa("{{ URL::to($pageModule.'/generatenota') }}",{idam:this.idam,id:id},"Generar PDF de la Nota de reconducción ","95%");
          },generarRecPDF(id){
            modalMisesa("{{ URL::to($pageModule.'/generaterec') }}",{idam:this.idam,id:id},"Generar PDF Dictamen de Reconducción ","95%");
          },downloadPDF(number){
            window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
          },editTranspaso(id,type){
            modalMisesa("{{ URL::to($pageModule.'/edit') }}",{idam:this.idam,id:id,type:type},"Editar Transpaso ","95%");
          },reverseTranspaso(row){
            swal({
                title : 'Estás seguro de revertir el PDF del transpaso?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
            }).then((willDelete) => {
                if(willDelete){
                    axios.post('{{ URL::to($pageModule."/reverse") }}',{
                        params : {id:row.id, number:row.number}
                    }).then(response => {
                        let row = response.data;
                        if(row.status == "ok"){
                          this.rowsProjects();
                          toastr.success(row.message);
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
                    axios.post('{{ URL::to($pageModule."/reversenota") }}',{
                        params : {id:row.id, number:row.number}
                    }).then(response => {
                        let row = response.data;
                        if(row.status == "ok"){
                          this.rowsProjects();
                          toastr.success(row.message);
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
                    axios.post('{{ URL::to($pageModule."/reverserec") }}',{
                        params : {id:row.id, number:row.number}
                    }).then(response => {
                        let row = response.data;
                        if(row.status == "ok"){
                          this.rowsProjects();
                          toastr.success(row.message);
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
                          params : {id:row.id,numero:numero}
                      }).then(response => {
                          let row = response.data;
                            if(row.status == "ok"){
                            this.rowsProjects();
                            toastr.success(row.message);
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
                          params : {id:row.id,numero:numero}
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
                    this.isLoading = false;
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