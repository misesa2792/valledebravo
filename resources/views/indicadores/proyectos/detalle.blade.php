@extends('layouts.app')

@section('content')
  <div class="page-content row bg-body">

    <section class="page-header bg-body no-padding">
        <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>
    
        <ul class="breadcrumb bg-body">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
            <li><i><a href="{{ URL::to('indicadores') }}" class="cursor c-blue">Ejercicio Fiscal</a></i></li>
            <li><i>{{ $json['header']['anio'] }}</i></li>
            <li><i>{{ $json['header']['no_dep_gen'] }} {{ $json['header']['dep_gen'] }}</i></li>
            <li><i>{{ $json['header']['no_dep_aux'] }} {{ $json['header']['dep_aux'] }}</i></li>
            <li><i><a href="{{ URL::to('indicadores/projects?k='.$token) }}" class="subrayado cursor icon-animation c-text s-12"><i class="fa fa-arrow-circle-left "></i> Regresar a proyectos</a></i></li>
        </ul>	  
    </section>
	
    <section class="table-resp">
        <article class="col-sm-12 col-md-12 col-lg-12 m-t-md no-padding">
                <div class="sbox animated fadeInRight border-t-blue b-r-5">
                    <div class="sbox-title c-text-alt"> <h4> <i class="fa icon-list s-16"></i> &nbsp;&nbsp; Reporte de Avance de Indicadores Estratégicos</h4></div>
                    <div class="sbox-content no-padding"> 	
        
                        <table class="table table-bordered bg-white no-margins">
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt" width="10%">Finalidad:</td>
                                <td class="bg-white c-text-alt text-center" width="50" id="fin_no">{{ $json['header']['no_finalidad'] }}</td>
                                <td id="fin_desc" class="bg-white">{{ $json['header']['finalidad'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Función:</td>
                                <td class="bg-white c-text-alt text-center" id="fun_no">{{ $json['header']['no_funcion'] }}</td>
                                <td id="fun_desc" class="bg-white">{{ $json['header']['funcion'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Subfunción:</td>
                                <td class="bg-white c-text-alt text-center" id="sub_no">{{ $json['header']['no_subfuncion'] }}</td>
                                <td id="sub_desc" class="bg-white">{{ $json['header']['subfuncion'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Programa:</td>
                                <td class="bg-white c-text-alt text-center" id="pro_no">{{ $json['header']['no_programa'] }}</td>
                                <td class="pro_desc bg-white">{{ $json['header']['programa'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Subprograma:</td>
                                <td class="bg-white c-text-alt text-center" id="subp_no">{{ $json['header']['no_subprograma'] }}</td>
                                <td id="subp_desc" class="bg-white">{{ $json['header']['subprograma'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Proyecto:</td>
                                <td class="bg-white c-text-alt text-center" id="proy_no">{{ $json['header']['no_proyecto'] }}</td>
                                <th id="proy_desc" class="bg-white c-blue">{{ $json['header']['proyecto'] }}</th>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Dependencia General:</td>
                                <td class="bg-white c-text-alt text-center">{{ $json['header']['no_dep_gen'] }}</td>
                                <td class="bg-white">{{ $json['header']['dep_gen'] }}</td>
                            </tr>
                            <tr class="t-tr-s12">
                                <td class="text-right c-text-alt">Dependencia Auxiliar:</td>
                                <td class="bg-white c-text-alt text-center">{{ $json['header']['no_dep_aux'] }}</td>
                                <td class="bg-white">{{ $json['header']['dep_aux'] }}</td>
                            </tr>
                        </table>
                            
                    </div>
                </div>		
            </section>
        </article>

           
            <article class="table-resp" id="app_metas">
                <table class="table table-bordered" style="border:0px;">
                    <tr class="t-tr-s10">
                        <th class="bg-white no-borders" width="30" rowspan="2">#</th>
                        <th rowspan="2" class="bg-white no-borders">Indicador</th>
                        <th rowspan="2" class="bg-white no-borders text-center">Variables del indicador</th>
                        <th rowspan="2" class="bg-white no-borders text-center">Medida</th>
                        <th rowspan="2" class="bg-white no-borders text-center">Frecuencia Medición</th>
                        <th rowspan="2" class="bg-white no-borders text-center">Tipo de Operación</th>
                        <th rowspan="2" class="bg-white no-borders text-center" width="50">Prog. Anual</th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-yellow-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Enero al 31 de Marzo {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-green-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div>01 Abril al 30 de Junio {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-blue-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div>01 Julio al 30 de Septiembre {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-red-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Octubre al 31 de Diciembre {{ $json['header']['anio'] }}</div>
                        </th>
                    </tr>
                    <tr class="t-tr-s10">
                        <td class="no-borders"></td>
                        <th class="bg-white" width="40">ENE.</th>
                        <th class="bg-white" width="40">FEB.</th>
                        <th class="bg-white" width="40">MAR.</th>
                        <th class="bg-white" width="40">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white" width="40">ABR.</th>
                        <th class="bg-white" width="40">MAY.</th>
                        <th class="bg-white" width="40">JUN.</th>
                        <th class="bg-white" width="40">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white" width="40">JUL.</th>
                        <th class="bg-white" width="40">AGO.</th>
                        <th class="bg-white" width="40">SEP.</th>
                        <th class="bg-white" width="40">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white" width="40">OCT.</th>
                        <th class="bg-white" width="40">NOV.</th>
                        <th class="bg-white" width="40">DIC.</th>
                        <th class="bg-white" width="40">JUST.</th>
                    </tr>
                   <template v-for="row in info">
                            <tr>
                                <td class="no-borders"></td>
                            </tr>
                            <tr class="t-tr-s10">
                                <td class="text-center bg-white no-borders s-12" :rowspan="(row.total * 2) + 1">@{{ row.no_a }}

                                    @if(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
                                        <div class="m-t-md">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-5 s-12" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-text-alt">  </span></button>
                                                <ul class="dropdown-menu text-left overflow-h s-14 c-text-alt" role="menu">
                                                    <li><a href="#" class="tips" @click.prevent="cambiarEstatus(row.idrm)" ><i class="fa fa-random c-primary-alt"></i> Cambiar estatus</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="bg-white c-text s-12 no-borders" :rowspan="(row.total * 2) + 1">
                                    <div class="font-bold">@{{ row.meta }}</div>
                                </td>
                            </tr>
                            <template v-for="val in row.rowsInd">
                                <tr class="t-tr-s10">
                                    <td class="bg-white c-text s-12 no-borders" rowspan="2">@{{ val.ind }}</td>
                                    <td class="bg-white c-text s-12 no-borders text-center" rowspan="2">@{{ val.um }}</td>
                                    <td class="bg-white c-text s-12 no-borders text-center" rowspan="2">@{{ val.fm }}</td>
                                    <td class="bg-white c-text s-12 no-borders text-center" rowspan="2">@{{ val.to }}</td>
                                    <td class="bg-white c-text s-12 no-borders text-center" rowspan="2">@{{ val.pa }}</td>
                                    <td class="no-borders"></td>
    
                                    <template v-if="row.a1 == 1">
                                        <td v-for="r in val.reg[1]" class="cursor text-center c-morena bg-white btnmeses-yellow" @click.prevent="regMeses(val.idrg,r.idmes,1)">
                                            <table class="table bg-transparent no-margins">
                                                <tr>
                                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-borders">
                                                        <div v-if="r.total_img > 0">
                                                            <i class="fa fa-picture-o s-10 c-text-alt"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center bg-white cursor" @click.prevent="regObs(val.idrg,'obs1',1)">
                                            <i class="fa fa-comments s-10 c-yellow-meta" v-if='val.obs != null' ></i>
                                            <i class="fa fa-comments s-10 c-text-alt-50" v-else></i>
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="4" class="text-center">No aplica</td>
                                    </template>

                                   
    
                                    
                                    <td class="no-borders"></td>
    
                                    <template v-if="row.a2 == 1">
                                        <td v-for="r in val.reg[2]" class="cursor text-center c-morena bg-white btnmeses-green" @click.prevent="regMeses(val.idrg,r.idmes,2)">
                                            <table class="table bg-transparent no-margins">
                                                <tr>
                                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-borders">
                                                        <div v-if="r.total_img > 0">
                                                            <i class="fa fa-picture-o s-10 c-text"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center bg-white cursor" @click.prevent="regObs(val.idrg,'obs2',2)">
                                                <i class="fa fa-comments s-10 c-green-meta" v-if='val.obs2 != null'></i>
                                                <i class="fa fa-comments s-10 c-text-alt-50" v-else></i>
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="4" class="text-center">No aplica</td>
                                    </template>

                                    <td class="no-borders"></td>
    
                                    <template v-if="row.a3 == 1">
                                        <td v-for="r in val.reg[3]" class="cursor text-center c-morena bg-white btnmeses-blue" @click.prevent="regMeses(val.idrg,r.idmes,3)">
                                            <table class="table bg-transparent no-margins">
                                                <tr>
                                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-borders">
                                                        <div v-if="r.total_img > 0">
                                                            <i class="fa fa-picture-o s-10 c-text-alt"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center bg-white cursor" @click.prevent="regObs(val.idrg,'obs3',3)">
                                                <i class="fa fa-comments s-10 c-blue-meta" v-if='val.obs3 != null'></i>
                                                <i class="fa fa-comments s-10 c-text-alt-50" v-else></i>
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="4" class="text-center c-text-alt">No aplica</td>
                                    </template>

                                    <td class="no-borders"></td>
    
                                    <template v-if="row.a4 == 1">
                                        <td v-for="r in val.reg[4]" class="cursor c-morena text-center c-morena bg-white btnmeses-red" @click.prevent="regMeses(val.idrg,r.idmes,4)">
                                            <table class="table bg-transparent no-margins">
                                                <tr>
                                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-borders">
                                                        <div v-if="r.total_img > 0">
                                                            <i class="fa fa-picture-o s-10 c-text-alt"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center bg-white cursor" @click.prevent="regObs(val.idrg,'obs4',4)">
                                            <i class="fa fa-comments s-10 c-red-meta" v-if='val.obs4 != null'></i>
                                            <i class="fa fa-comments s-10 c-text-alt-50" v-else></i>
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="4" class="text-center c-text-alt">No aplica</td>
                                    </template>
                                </tr>
                                <tr class="t-tr-s10">
                                    <td class="no-borders"></td>
    
                                    <td class="no-padding text-center warning">@{{  val.tr1 > 0 ? val.tt1 : '' }}</td>
                                    <td class="no-padding text-center warning">@{{ val.tr1 > 0 ? val.resta1 : ''}}</td>
                                    <td class="no-padding text-center c-white bg-yellow-meta">@{{ val.t1 }}</td>
                                    <td :class="(val.tr1 > 0 && (val.total_m1 > 110 || val.total_m1 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right warning'">@{{ val.tr1 > 0 ? (val.total_m1+'%') : '' }}</td>
    
                                    <td class="no-borders"></td>
            
                                    <td class="no-padding text-center success">@{{  val.tr2 > 0 ? val.tt2 : '' }}</td>
                                    <td class="no-padding text-center success">@{{ val.tr2 > 0 ? val.resta2 : ''}}</td>
                                    <td class="no-padding text-center c-white bg-green-meta">@{{ val.t2 }}</td>
                                    <td :class="(val.tr2 > 0 && (val.total_m2 > 110 || val.total_m2 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right success'">@{{ val.tr2 > 0 ? (val.total_m2+'%') : '' }}</td>
            
                                    <td class="no-borders"></td>
            
                                    <td class="no-padding text-center info">@{{  val.tr3 > 0 ? val.tt3 : '' }}</td>
                                    <td class="no-padding text-center info">@{{ val.tr3 > 0 ? val.resta3 : ''}}</td>
                                    <td class="no-padding text-center c-white bg-blue-meta">@{{ val.t3 }}</td>
                                    <td :class="(val.tr3 > 0 && (val.total_m3 > 110 || val.total_m3 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right info'">@{{ val.tr3 > 0 ? (val.total_m3+'%') : '' }}</td>
            
                                    <td class="no-borders"></td>
            
                                    <td class="no-padding text-center danger">@{{ val.tr4 > 0 ? val.tt4 : '' }}</td>
                                    <td class="no-padding text-center danger">@{{ val.tr4 > 0 ? val.resta4 : ''}}</td>
                                    <td class="no-padding text-center c-white bg-red-meta">@{{ val.t4 }}</td>
                                    <td :class="(val.tr4 > 0 && (val.total_m4 > 110 || val.total_m4 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right danger'">@{{ val.tr4 > 0 ? (val.total_m4+'%') : '' }}</td>
                                </tr>
                            </template>
                    </template>
                </table>
            </article>
        </section>


        <div class="col-sm-12 col-md-12 m-b-lg"></div>
        <div class="col-sm-12 col-md-12 m-b-lg"></div>
</div>	
<style>
.t-tr-s10 > th, .t-tr-s10 > td{font-size: 9px !important;}
</style>
<script>
     var metas = new Vue({
        el:'#app_metas',
        data:{
            info : [],
            anioActual:0
        },
        methods:{
            rowsMetas(){
                axios.get('{{ URL::to("reporte/metasprojectsindicador?id=".$id) }}',{
                    params : {}
                }).then(response => {
                    this.info = [];
                    this.info = response.data;
                })
            },
            regMeses(idrg,idmes,trim){
                modalMisesa("{{ URL::to('reporte/meses') }}",{idrg:idrg, idmes:idmes,trim:trim},"Registrar","60%");
            },
            regObs(idrg,obs,trim){
                modalMisesa("{{ URL::to('reporte/registrarobs') }}",{idrg:idrg,obs:obs,trim:trim},"Agregar Justificación","40%");
            },
            cambiarEstatus(idrm){
                modalMisesa("{{ URL::to('reporte/cambiarestatus') }}",{idrm:idrm},"Cambiar Estatus del Indicador","40%");
            }
        },
        mounted(){
            this.rowsMetas();
        }
    });
</script>
@stop
