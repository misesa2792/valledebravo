@extends('layouts.app')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
  <template id="comp_btn_pdf_reverse">
    <div v-if="url == 'empty'"></div>
    <div v-else>
      <i class="fa icon-file-pdf c-danger s-12 cursor icon-animation" @click.prevent="reversePDF(id,url,trim)"></i>
    </div>
</template>
<template id="comp_btn_pdf">
    <div v-if="url == 'empty'">
      <i class="fa icon-file-pdf c-text-alt s-12 cursor" @click.prevent="generateRecPDF(type,id,trim)"></i>
    </div>
    <div v-else>
      <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(url)"></i>
    </div>
</template>

<template id="component_metas">
  <div>
    <table class="table bg-white table-hover">
      <tr class="text-center font-bold">
        <td>#</td>
        <td>Proyecto</td>
        <td>Dep. Gen</td>
        <td>Dep. Aux</td>
        <td>Código</td>
        <td>Meta</td>
        <td>Unidad Medida</td>
        <td>Programado Anterior</td>
        <td>Real Anterior</td>
        <td>Trim #1</td>
        <td>Trim #2</td>
        <td>Trim #3</td>
        <td>Trim #4</td>
        <td>Pbrm-01c</td>
        <td>Metas</td>
      </tr>
      <tr v-for="(r,tot) in rowinfo" class="c-text-alt">
        <td class="text-center">@{{ ++tot }}</td>
        <td class="text-center">@{{ r.proy }}</td>
        <td class="text-center">@{{ r.no_dep_gen }}</td>
        <td class="text-center">@{{ r.no_dep_aux }}</td>
        <td class="text-center">@{{ r.cod }}</td>
        <td >@{{ r.meta }}</td>
        <td class="text-center">@{{ r.um }}</td>
        <td class="text-center">@{{ r.prog_ant }}</td>
        <td class="text-center">@{{ r.real_ant }}</td>
        <td class="text-center">@{{ r.t1 }}</td>
        <td class="text-center">@{{ r.t2 }}</td>
        <td class="text-center">@{{ r.t3 }}</td>
        <td class="text-center">@{{ r.t4 }}</td>
        <td :class="'text-center ' + (r.val1 == 1 ? 'success' : 'danger')">@{{ r.val1 == 1 ? 'Si' : 'No' }}</td>
        <td :class="'text-center ' + (r.val2 == 1 ? 'success' : 'danger')">@{{ r.val2 == 1 ? 'Si' : 'No'  }}</td>
      </tr>
    </table>
  </div>
</template>


<template id="component_txt">
  <div>
    <table class="table bg-white table-hover">
      <tr>
        <td colspan="14" class="text-right">
          <a href="#" class="tips btn btn-sm btn-primary btn-outline" @click.prevent="generateTXT"> <i class="fa fa-file-text-o"></i> Generar {{ $nameTxt }}.txt</a>
        </td>
        <th colspan="8" v-if="trim==1" class="text-center c-white bg-yellow-meta">Trimestre #@{{ trim }}</th>
        <th colspan="8" v-else-if="trim==2" class="text-center c-white bg-green-meta">Trimestre #@{{ trim }}</th>
        <th colspan="8" v-else-if="trim==3" class="text-center c-white bg-blue-meta">Trimestre #@{{ trim }}</th>
        <th colspan="8" v-else-if="trim==4" class="text-center c-white bg-red-meta">Trimestre #@{{ trim }}</th>
      </tr>
      <tr class="text-center font-bold">
        <td>#</td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td colspan="6">5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
        <td>15</td>
        <td>16</td>
      </tr>
      <tr v-for="(r,tot) in rowinfo" class="c-text-alt">
        <td class="text-center">@{{ ++tot }}</td>
        <td class="text-center">@{{ r.lb }}</td>
        <td class="text-center">@{{ r.pb }}</td>
        <td class="text-center">@{{ r.dg }}</td>
        <td class="text-center">@{{ r.da }}</td>
        <td class="text-center">@{{ r.no1 }}</td>
        <td class="text-center">@{{ r.no2 }}</td>
        <td class="text-center">@{{ r.no3 }}</td>
        <td class="text-center">@{{ r.no4 }}</td>
        <td class="text-center">@{{ r.no5 }}</td>
        <td class="text-center">@{{ r.no6 }}</td>
        <td class="text-center">@{{ r.ac }}</td>
        <td>@{{ r.me }}</td>
        <td>@{{ r.um }}</td>
        <td class="text-right">@{{ r.pa }}</td>
        <td class="text-right">@{{ r.vp }}</td>
        <td class="text-right">@{{ r.va }}</td>
        <td class="text-right">@{{ r.vv }}</td>
        <td class="text-right">@{{ r.vvp }}</td>
        <td class="text-right">@{{ r.aa }}</td>
        <td class="text-right">@{{ r.av }}</td>
        <td class="text-right">@{{ r.avp }}</td>
      </tr>
    </table>
  </div>
</template>

<template id="component_body">
    <div>
      <section class="col-sm-12 col-md-12 col-lg-12 b-r-5 p-xs m-t-xs m-b-md bg-white">
  
        <article class="col-md-12">
          <table class="table table-bordered table-hover no-margins">
            <tr class="t-tr-14 c-text">
              <tr class="c-text">
                <th colspan="6">
                  <div class="col-md-12 no-padding" v-if="group_id == 1 || group_id == 2">
                    <button v-if="count == true"
                            type="button" class="tips btn btn-sm btn-white b-r-5" @click="changeEstatusReverse()" title="Revertir PDF">
                        <i class="fa icon-file-pdf c-danger"></i>&nbsp;Revertir PDFs
                    </button>
              
                    <span class="subrayado s-14 cursor icon-animation" v-else @click="changeEstatusReverse()"><i class="fa fa-arrow-circle-left c-blue"></i>&nbsp;Regresar a tabla de proyectos</span>
                  </div>
                </th>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
            </tr>
            <template v-for="(row, key) in rowinfo">
                <template v-if="count == true">
                  <tr class="c-text-alt" v-for="(v, kke) in row.rows">
                    <td v-if="kke == 0" :rowspan="row.rows.length">
                      @{{ row.nodg }} @{{ row.dg }}
                    </td>
                     <td class="text-center">@{{ v.nda }}</td>
                     <td>@{{ v.da }}</td>
                     <td class="text-center">@{{ v.nop }}</td>
                     <td>@{{ v.pro }}</td>
                     <td class="text-right">@{{ v.pre }}</td>
                     <td class="text-center">
                       <comp-btn-pdf v-if="access.t1 == 'si'" :url="v.ocho1" :id="v.id" :trim="'1'" :type="'4'"></comp-btn-pdf>
                     </td>
                     <td class="text-center">
                       <comp-btn-pdf v-if="access.t2 == 'si'" :url="v.ocho2" :id="v.id" :trim="'2'" :type="'4'"></comp-btn-pdf>
                     </td>
                     <td class="text-center">
                       <comp-btn-pdf v-if="access.t3 == 'si'" :url="v.ocho3" :id="v.id" :trim="'3'" :type="'4'"></comp-btn-pdf>
                     </td>
                     <td class="text-center">
                       <comp-btn-pdf v-if="access.t4 == 'si'" :url="v.ocho4" :id="v.id" :trim="'4'" :type="'4'"></comp-btn-pdf>
                     </td>
                   </tr>
                </template>
                <template v-if="count == false">
                  <tr class="c-text-alt" v-for="(v, kke) in row.rows">
                    <td v-if="kke == 0" :rowspan="row.rows.length">
                      @{{ row.nodg }} @{{ row.dg }}
                    </td>
                    <td class="no-borders"></td>
                    <td class="text-center">@{{ v.nda }}</td>
                    <td>@{{ v.da }}</td>
                    <td class="text-center"><span class="badge badge-danger badge-outline">@{{ v.nop }}</span></td>
                    <td class="c-danger">@{{ v.pro }}</td>
                    <td class="text-right">@{{ v.pre }}</td>
                    <td class="text-center">
                      <comp-btn-pdf-reverse v-if="access.t1 == 'si'" :url="v.ocho1" :id="v.id" :trim="'1'"></comp-btn-pdf-reverse>
                    </td>
                    <td class="text-center">
                      <comp-btn-pdf-reverse v-if="access.t2 == 'si'" :url="v.ocho2" :id="v.id" :trim="'2'"></comp-btn-pdf-reverse>
                    </td>
                    <td class="text-center">
                      <comp-btn-pdf-reverse v-if="access.t3 == 'si'" :url="v.ocho3" :id="v.id" :trim="'3'"></comp-btn-pdf-reverse>
                    </td>
                    <td class="text-center">
                      <comp-btn-pdf-reverse v-if="access.t4 == 'si'" :url="v.ocho4" :id="v.id" :trim="'4'"></comp-btn-pdf-reverse>
                    </td>
                  </tr>
                </template>
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

    <div class="col-md-12">

      <ul class="nav nav-tabs text-right">
        <li>
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 1 ? 'btn-active' : '')" @click.prevent="openMenu(1,0)"> <i class="fa icon-file-pdf c-app"></i> Formatos</button>
        </li>
        <li v-if="access.t1 == 'si'">
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 2 ? 'btn-active' : '')" @click.prevent="openMenu(2,1)"> <i class="fa fa-file-text-o c-yellow-meta"></i> Trimestre #1 .txt</button>
        </li>
        <li v-if="access.t2 == 'si'" >
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 3 ? 'btn-active' : '')" @click.prevent="openMenu(3,2)"> <i class="fa fa-file-text-o c-green-meta"></i> Trimestre #2 .txt</button>
        </li>
        <li v-if="access.t3 == 'si'" >
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 4 ? 'btn-active' : '')" @click.prevent="openMenu(4,3)"> <i class="fa fa-file-text-o c-blue-meta"></i> Trimestre #3 .txt</button>
        </li>
        <li v-if="access.t4 == 'si'" >
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 5 ? 'btn-active' : '')" @click.prevent="openMenu(5,4)"> <i class="fa fa-file-text-o c-red-meta"></i> Trimestre #4 .txt</button>
        </li>
        <li>
          <button type="buttom" :class="'btn btn-sm btn-white btn-tab ' + (checkMenu == 6 ? 'btn-active' : '')" @click.prevent="openMenu(6,0)"> <i class="fa fa-edit c-app"></i> Metas</button>
        </li>
      </ul>

      <div class="col-md-12 m-t-md" v-if="info.length == 0">
        <i class='fa fa-spinner fa-spin fa-2x fa-fw '></i> ...Cargando... Este proceso puede tardar unos segundos...
      </div>

      <div class="col-md-12 no-padding" v-else> 
        <div class="col-md-12 no-padding m-t-md" v-if="checkMenu == 1">
          <div class="col-md-12 bg-white p-xs">
            <table class="table no-margins">
              <tr>
                <td class="no-borders">
                  Dependencia General
                  <select name="ins" class="form-control miSelectDep">
                    <option value="">--Selecciona Dependencias--</option>
                    @foreach ($rowsIns as $v)
                      <option value="{{ $v->id }}">{{ $v->no_dep_gen.' '.$v->dep_gen }}</option>
                    @endforeach
                  </select>
                </td>
                <td class="no-borders" width="60">
                  Buscar
                  <button type="button" class="btn btn-xs btn-white" @click.prevent="buscarDeps"> <i class="fa fa-search"></i> Buscar</button>
                </td>
              </tr>
            </table>
          </div>
    
          <component-body :rowinfo="info" :access="access" ></component-body>
        </div>
        <div class="col-md-12 no-padding m-t-md" v-if="checkMenu != 1 && checkMenu != 6">
          <component-txt :rowinfo="info" :access="access" :trim="trim" ></component-txt>
        </div>

        <div class="col-md-12 no-padding m-t-md" v-if="checkMenu == 6">
          <component-metas :rowinfo="info"></component-metas>
        </div>
      </div>
    </section>
      
    </div>
    
  </main>	
<style>
  .btn-tab{
    background:transparent !important;
  }
  .btn-tab.btn-active{border-bottom:3px solid var(--color-blue) !important;}
</style>
	<script>
     Vue.component('card-loading', {
      template: "#card_loading",
      data: function() {
        return {
          skeletonArray: [1,2,3,4,5,6,7,8,9,10],
        };
      }
    });

    Vue.component('component-body', {
        template: '#component_body',
        props: ['rowinfo','access'],
        data: function () {
            return {
                count: true,
                group_id: window.user.group_id
            }
        },
        methods: {
            changeEstatusReverse(){
                this.count = (this.count == true ? false : true);
            }
        }
    });

    Vue.component('component-txt', {
        template: '#component_txt',
        props: ['rowinfo','access','trim'],
        data: function () {
            return {
                count: true,
                group_id: window.user.group_id
            }
        },
        methods: {
          generateTXT(){
            window.open('{{ URL::to("reporte/generatetxtochoc?idy=") }}'+pbrmc.idy+'&trim='+pbrmc.trim+'&name='+pbrmc.nameTxt, '_blank');
          }
        }
    });

    Vue.component('component-metas', {
        template: '#component_metas',
        props: ['rowinfo'],
        data: function () {
            return {
                count: true,
                group_id: window.user.group_id
            }
        },
    });
   

    Vue.component("comp-btn-pdf",{
			template : "#comp_btn_pdf",
			props : ['url','id','trim','type'],
        methods:{
          generateRecPDF(type,id,trim){
            modalMisesa("{{ URL::to($pageModule.'/formatos') }}",{type:type, k:id, trim:trim},"Generar PDF","80%");
          },downloadPDF(number){
            window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
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
                    text: 'Estás seguro de revertir el PDF del PbRM-08c del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reversepbrmocho") }}',{
                            params : {k:id, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmc.rowsPbrmc();
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
        // Otros datos del usuario si es necesario
    };


     var pbrmc = new Vue({
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
            nameTxt:'',
            menu:1,
            trim:0
      },computed: {
          checkMenu(){
              return this.menu;
          }
      },methods:{
          openMenu(no, trim){
            this.info = [];
            this.menu = no;
            this.trim = trim;
            if(no == 1){
              this.rowsPbrmc();
            }else if(no == 6){
              this.rowsPbrmcMetas();
            }else{
              this.rowsPbrmcTXT();
            }
          },buscarDeps(){
            let id = $(".miSelectDep").val();
            this.ida = id;
            this.rowsPbrmc();
          },
            rowsPbrmc(){
                if (this.cancelTokenSource) {
                    this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
                }

                // Crear un nuevo token de cancelación
                this.cancelTokenSource = axios.CancelToken.source();

                axios.get('{{ URL::to("reporte/projectsochoc") }}',{
                    params : {idy:this.idy, type: this.type,year:this.year,ida:this.ida},
                    cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                }).then(response => {
                    var row = response.data;
                    this.info = row.rowsData;
                    this.access = row.access;
                    ;
                }).catch(error => {
                    /*if (axios.isCancel(error)) {
                    } */
                }).finally(() => {
                    // Ocultar el loading cuando la solicitud termina (éxito o error)
                    this.isLoading = false;
                });
            },rowsPbrmcTXT(){
                if (this.cancelTokenSource) {
                    this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
                }
                this.cancelTokenSource = axios.CancelToken.source();
                axios.get('{{ URL::to("reporte/projectsochoctxt") }}',{
                    params : {idy:this.idy, trim:this.trim},
                    cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                }).then(response => {
                  var row = response.data;
                  if(row.status == "ok"){
                    this.info = row.rowsData;
                  }
                }).catch(error => {
                }).finally(() => {
                });
            },rowsPbrmcMetas(){
                if (this.cancelTokenSource) {
                    this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
                }
                this.cancelTokenSource = axios.CancelToken.source();
                axios.get('{{ URL::to("pbrma/metas") }}',{
                    params : {idy:4},
                    cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
                }).then(response => {
                  var row = response.data;
                  if(row.status == "ok"){
                    this.info = row.rowsData;
                  }
                }).catch(error => {
                }).finally(() => {
                });
            }
        },
        mounted(){
          this.type = "{{ $type }}";
          this.idy = "{{ $idy }}";
          this.year = "{{ $year }}";
          this.nameTxt = "{{ $nameTxt }}";
          this.rowsPbrmc();
        }
    });
    $(".miSelectDep").on("change", function(e) {
      e.preventDefault();
      let id = $(this).val();
      pbrmc.searchDepGen(id);
    })
  </script>
  
@stop