@extends('layouts.app')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  $idu = Auth::user()->id;
  /*--}}
<template id="comp_semaforo">
    <div>
      <span @click.prevent="addEvaluacion(id)">
        <i class="fa fa-comments s-12 c-green-meta tips cursor" title="Verde" v-if="semaforo == 1"></i>
        <i class="fa fa-comments s-12 c-yellow-meta tips cursor" title="Amarillo" v-else-if="semaforo == 2"></i>
        <i class="fa fa-comments s-12 c-red-meta tips cursor" title="Rojo" v-else-if="semaforo == 3"></i>
        <i  class="fa fa-comments s-12 c-text-alt tips cursor" title="Agregar" v-else></i>
      </span>
    </div>
</template>
<template id="comp_btn_pdf_reverse">
  <div v-if="url == 'empty'"></div>
  <div v-else>
    <i class="fa icon-file-pdf c-danger s-12 cursor icon-animation" @click.prevent="reversePDF(id,url,trim)"></i>
  </div>
</template>

<template id="component_body">
    <div>
      
      <section class="col-sm-12 col-md-12 col-lg-12 b-r-5 p-xs m-t-xs m-b-md bg-white">

        <article class="col-md-12 p-xs b-b-gray m-b-md">
          <div class="col-md-12 font-bold c-blue">@{{ rowinfo.nodg }} @{{ rowinfo.dg }}</div>
        </article>

          <article class="col-md-12" v-if="count == true">
            <table class="table table-hover no-margins">
              <tr class="c-text">
                  <th colspan="3">DEPENDENCIA</th>
                  <th colspan="3">PROYECTOS</th>
              </tr>
                <template v-for="v in rowinfo.rows">
                  <tr class="c-text">
                    <td width="10">
                      @if($gp == 1)
                        <div class="btn-group">
                          <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                          <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                <li><a href="#" @click.prevent="addPbrmd(v.id)"><i class="fa fa-edit c-blue cursor"></i> Agregar nuevo indicador</a></li>
                          </ul>
                        </div>
                      @endif
                    </td>
                    <td class="text-center">@{{ v.nda }}</td>
                    <td>@{{ v.da }}</td>
                    <td class="text-center">@{{ v.nop }}</td>
                    <td>@{{ v.pro }}</td>
                    <td width="60%">
                          <table class="table table-bordered no-margins">
                            <tr>
                              <td colspan="5">INDICADORES</td>
                              <td class="text-center c-white bg-yellow-meta" width="25">1</td>
                              <td class="text-center c-white bg-green-meta" width="25">2</td>
                              <td class="text-center c-white bg-blue-meta" width="25">3</td>
                              <td class="text-center c-white bg-red-meta" width="25">4</td>
                            </tr>
                            <tr v-for="m in v.mirs">
                              <td width="10">
                                @if($gp == 1 || $idu == 64)
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text"></span></button>
                                    <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                          <li><a href="#" @click.prevent="editPbrmd(m.id)"><i class="fa fa-edit c-blue cursor"></i> Editar</a></li>
                                          <li><a href="#" @click.prevent="destroyPbrmd(m.id)"><i class="fa fa-trash-o c-danger cursor"></i> Eliminar</a></li>
                                    </ul>
                                  </div>
                                @endif
                              </td>
                              <td width="80">@{{ m.mir }}</td>
                              <td>@{{ m.ci }}</td>
                              <td width="50%">@{{ m.ind }}</td>
                              <td class="text-center s-10">@{{ m.fre }}</td>
                              <td width="80" class="text-center s-10">@{{ m.fla }}</td>

                              <template v-if="m.eva.length == 4" v-for="e in m.eva">
                                  <template v-if="e.trim == 1">
                                    <td :class="'text-center ' + (m.a1 == 1 ? 'success' : 'danger')" width="25">
                                        <comp-semaforo v-if="access.t1 == 'si' && m.a1 == 1" :semaforo="e.semaforo" :id="e.id"></comp-semaforo>
                                    </td>
                                  </template>
                                  <template v-if="e.trim == 2">
                                    <td :class="'text-center ' + (m.a2 == 1 ? 'success' : 'danger')" width="25">
                                        <comp-semaforo v-if="access.t2 == 'si' && m.a2 == 1" :semaforo="e.semaforo" :id="e.id"></comp-semaforo>
                                    </td>
                                  </template>
                                  <template v-if="e.trim == 3">
                                    <td :class="'text-center ' + (m.a3 == 1 ? 'success' : 'danger')" width="25">
                                        <comp-semaforo v-if="access.t3 == 'si' && m.a3 == 1" :semaforo="e.semaforo" :id="e.id"></comp-semaforo>
                                    </td>
                                  </template>
                                  <template v-if="e.trim == 4">
                                    <td :class="'text-center ' + (m.a4 == 1 ? 'success' : 'danger')" width="25">
                                        <comp-semaforo v-if="access.t4 == 'si' && m.a4 == 1" :semaforo="e.semaforo" :id="e.id"></comp-semaforo>
                                    </td>
                                  </template>
                              </template>

                            </tr>
                          </table>
                    </td>
                  </tr>
                </template>
            </table>
          </article>
  
          <article class="col-md-12" v-if="count == false">
            <div class="alert alert-danger fade in block-inner">
              <i class="icon-warning"></i>  Para revertir un PDF, haga clic en el PDF que desea revertir.
            </div>
  
            <table class="table table-hover">
              <tr class="c-text">
                  <th colspan="2">DEPENDENCIA</th>
                  <th colspan="2">PROYECTOS</th>
                  <th>INDICADORES</th>
              </tr>
                <template v-for="v in rowinfo.rows">
                  <tr class="c-text">
                    <td class="text-center">@{{ v.nda }}</td>
                    <td>@{{ v.da }}</td>
                    <td class="text-center"><span class="badge badge-danger badge-outline">@{{ v.nop }}</span></td>
                    <td class="c-danger">@{{ v.pro }}</td>
                    <td width="50%">
                          <table class="table table-bordered">
                            <tr>
                              <td colspan="4"></td>
                              <td class="text-center c-white bg-yellow-meta" width="25">1</td>
                              <td class="text-center c-white bg-green-meta" width="25">2</td>
                              <td class="text-center c-white bg-blue-meta" width="25">3</td>
                              <td class="text-center c-white bg-red-meta" width="25">4</td>
                            </tr>
                            <tr v-for="m in v.mirs">
                              <td width="60">@{{ m.mir }}</td>
                              <td width="50%" >@{{ m.ind }}</td>
                              <td class="text-center s-10">@{{ m.fre }}</td>
                              <td width="80" class="text-center s-10">@{{ m.fla }}</td>
                              <td class="text-center" width="25">
                                <comp-btn-pdf-reverse v-if="access.t1 == 'si'" :url="m.url1" :id="m.id" :trim="'1'"></comp-btn-pdf-reverse>
                              </td>
                              <td class="text-center" width="25">
                                <comp-btn-pdf-reverse v-if="access.t2 == 'si'" :url="m.url2" :id="m.id" :trim="'2'"></comp-btn-pdf-reverse>
                              </td>
                              <td class="text-center" width="25">
                                <comp-btn-pdf-reverse v-if="access.t3 == 'si'" :url="m.url3" :id="m.id" :trim="'3'"></comp-btn-pdf-reverse>
                              </td>
                              <td class="text-center" width="25">
                                <comp-btn-pdf-reverse v-if="access.t4 == 'si'" :url="m.url4" :id="m.id" :trim="'4'"></comp-btn-pdf-reverse>
                              </td>
                            </tr>
                          </table>
                    </td>
                  </tr>
                </template>
            </table>
  
          </article>
      </section>

    </div>
</template>
  
  <main class="page-content row bg-body" id="app_foda">
    @if($type == 0)
      @include('reporte.include.menumetas')
    @else 
      @include('reporte.include.menuindicadores')
    @endif

    <section class="col-md-12">

      <ul class="nav nav-tabs text-right d-none">
        <li>
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 1 ? 'btn-active' : '')" @click.prevent="openMenu(1,0)"> <i class="fa icon-file-pdf c-app"></i> Formatos</button>
        </li>
        <li v-if="access.t1 == 'si'">
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 2 ? 'btn-active' : '')" @click.prevent="openMenu(2,1)"> <i class="fa fa-file-text-o c-yellow-meta"></i> Indicadores</button>
        </li>
      </ul>



      <table class="table bg-white">
        <tr>
          <td colspan="4">
            Dependencia General
            <select name="ins" class="select2 miSelectDep">
              <option value="">--Selecciona Dependencias--</option>
              @foreach ($rowsIns as $v)
                <option value="{{ $v->id }}">{{ $v->no_dep_gen.' '.$v->dep_gen }}</option>
              @endforeach
            </select>
          </td>
          <td width="20%">
            <div>
              <i class="fa fa-comments s-12 c-green-meta tips" title="Verde"></i> Verde (Aceptable)
            </div>
            <div>
              <i class="fa fa-comments s-12 c-yellow-meta tips" title="Amarillo"></i> Amarillo (Con riesgo)
            </div>
            <div>
              <i class="fa fa-comments s-12 c-red-meta tips" title="Rojo"></i> Rojo (Crítico)
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right">
            <button type="button" class="tips btn btn-sm btn-white b-r-5" @click="printPDFs(1)" title="Imprimir PDFs"><i class="fa icon-file-pdf c-danger"></i>&nbsp;Imprimir PDFs Trim #1</button>
            <button type="button" class="tips btn btn-sm btn-white b-r-5" @click="printPDFs(2)" title="Imprimir PDFs"><i class="fa icon-file-pdf c-danger"></i>&nbsp;Imprimir PDFs Trim #2</button>
            <button type="button" class="tips btn btn-sm btn-white b-r-5" @click="printPDFs(3)" title="Imprimir PDFs"><i class="fa icon-file-pdf c-danger"></i>&nbsp;Imprimir PDFs Trim #3</button>
            <button type="button" class="tips btn btn-sm btn-white b-r-5" @click="printPDFs(4)" title="Imprimir PDFs"><i class="fa icon-file-pdf c-danger"></i>&nbsp;Imprimir PDFs Trim #4</button>
          </td>
        </tr>
      </table>

      <component-body v-for="(row, key) in info" :key="key" :rowinfo="row" :access="access" ></component-body>
    </section>
  </main>	

	<script>
    Vue.component('component-body', {
        template: '#component_body',
        props: ['rowinfo','access'],
        data: function () {
            return {
                count: true,
                hidden: true,
                group_id: window.user.group_id
            }
        },
        methods: {
            changeEstatusReverse(){
                this.count = (this.count == true ? false : true);
            },editPbrmd(id){
              modalMisesa("{{ URL::to($pageModule.'/editindicador') }}",{k:id},"Editar Indicador","95%");
            },addPbrmd(id){
              modalMisesa("{{ URL::to($pageModule.'/addindicador') }}",{k:id},"Agregar nuevo indicador","95%");
            },destroyPbrmd(id){
              swal({
                    title : 'Eliminar Indicador',
                    text: 'Estás seguro de eliminar el indicador?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.delete('{{ URL::to("indicadores/indicadormir") }}',{
                            params : {k:id}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmb.rowsPbrmb();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
            }
        }
    });
   
    Vue.component("comp-semaforo",{
			template : "#comp_semaforo",
			props : ['semaforo','id'],
      methods:{
        addEvaluacion(id){
          modalMisesa("{{ URL::to($pageModule.'/formatos') }}",{id:id, type:'6'},"Evaluar indicador","80%");
        }
      }
	  })

    Vue.component("comp-btn-pdf-reverse",{
			template : "#comp_btn_pdf_reverse",
			props : ['url','id','trim'],
        methods:{
          reversePDF(id,number,trim){
            swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF del PbRM-08b del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reverseochob") }}',{
                            params : {k:id, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmb.rowsPbrmb();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
          }
        }
	  })

    window.user = {
      group_id: "{{ Auth::user()->group_id }}" 
    };


     var pbrmb = new Vue({
        el:'#app_foda',
        data:{
            group_id: window.user.group_id,
            info : [],
            access: [],
            idy:0,
            access:0,
            year:0,
            type:0,
            cancelTokenSource: null,
            isLoading:false,
            ida:0,
            menu:1
        },computed: {
          checkMenu(){
              return this.menu;
          }
       },
        methods:{
          openMenu(no, trim){
            this.info = [];
            this.menu = no;
            this.trim = trim;
            if(no == 1){
              this.rowsPbrmb();
            }else if(no == 2){
              this.rowsPbrmbIndicaodres();
            }
          },
          rowsPbrmb(){
              //this.isLoading = true;

              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.get('{{ URL::to("indicadores/projectsochob") }}',{
                  params : {idy:this.idy, type: this.type,year:this.year,ida:this.ida},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  this.info = [];
                  var row = response.data;
                  if(row.status == "ok"){
                    this.info = row.rowsData;
                    this.access = row.access;
                  }
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
              }).finally(() => {
                  // Ocultar el loading cuando la solicitud termina (éxito o error)
                  //this.isLoading = false;
              });
          },rowsPbrmbIndicaodres(){
              //this.isLoading = true;
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }
              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();
              axios.get('{{ URL::to("indicadores/variables") }}',{
                  params : {idy:this.idy, type: this.type,year:this.year,ida:this.ida},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  this.info = [];
                  var row = response.data;
                  if(row.status == "ok"){
                    this.info = row.rowsData;
                    this.access = row.access;
                  }
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
              }).finally(() => {
                  // Ocultar el loading cuando la solicitud termina (éxito o error)
                  //this.isLoading = false;
              });
          },searchDepGen(id){
            this.ida = id;
            this.rowsPbrmb();
          },printPDFs(trim){
            swal({
                  title : 'Imprimir PDFs',
                  text: 'Estás seguro de imprimir PDFs del PbRM-08b?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                    window.open('{{ URL::to("indicadores/generatepdfeightb?idy=") }}'+this.idy+'&trim='+trim, '_blank');
                  }
              })
          }
        },
        mounted(){
          this.type = "{{ $type }}";
          this.idy = "{{ $idy }}";
          this.year = "{{ $year }}";
          this.rowsPbrmb();
        }
    });

    $(".miSelectDep").on("change", function(e) {
      e.preventDefault();
      let id = $(this).val();
      pbrmb.searchDepGen(id);
    })
  </script>
  
@stop