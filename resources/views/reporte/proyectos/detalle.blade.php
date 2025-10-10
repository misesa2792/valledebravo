@extends('layouts.app')

@section('content')
  <div class="page-content row bg-body">

    <section class="page-header bg-body no-padding">
        <div class="page-title">
            <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>
    
        <ul class="breadcrumb bg-body">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
            <li><i><a href="{{ URL::to('reporte') }}" class="cursor c-blue">Ejercicio Fiscal</a></i></li>
            <li><i>{{ $json['header']['anio'] }}</i></li>
            <li><i>{{ $json['header']['no_dep_gen'].' '.$json['header']['dep_gen'] }}</i></li>
            <li><i>{{ $json['header']['no_dep_aux'].' '.$json['header']['dep_aux'] }}</i></li>
            <li><i><a href="{{ URL::to('reporte/projects?k='.$token) }}" class="subrayado cursor icon-animation c-text s-12"><i class="fa fa-arrow-circle-left "></i> Regresar a proyectos</a></i></li>
        </ul>
    </section>
    
	
    <section class="table-resp">

        <article class="col-sm-12 col-md-12 col-lg-12 m-t-md no-padding">
            <div class="sbox animated fadeInRight border-t-blue b-r-5">
                <div class="sbox-title c-text-alt"> <h5> <i class="fa icon-list s-14"></i> &nbsp;&nbsp; {{ $pageNote }}</h5></div>
                <div class="sbox-content no-padding"> 	
    
                    <table class="table table-bordered bg-white no-margins">
                        <tr>
                            <td class="text-right c-text-alt" width="10%">Finalidad:</td>
                            <td class="bg-white c-text-alt text-center" width="50" id="fin_no">{{ $json['header']['no_finalidad'] }}</td>
                            <td id="fin_desc" class="bg-white">{{ $json['header']['finalidad'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Función:</td>
                            <td class="bg-white c-text-alt text-center" id="fun_no">{{ $json['header']['no_funcion'] }}</td>
                            <td id="fun_desc" class="bg-white">{{ $json['header']['funcion'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Subfunción:</td>
                            <td class="bg-white c-text-alt text-center" id="sub_no">{{ $json['header']['no_subfuncion'] }}</td>
                            <td id="sub_desc" class="bg-white">{{ $json['header']['subfuncion'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Programa:</td>
                            <td class="bg-white c-text-alt text-center" id="pro_no">{{ $json['header']['no_programa'] }}</td>
                            <td class="pro_desc bg-white">{{ $json['header']['programa'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Subprograma:</td>
                            <td class="bg-white c-text-alt text-center" id="subp_no">{{ $json['header']['no_subprograma'] }}</td>
                            <td id="subp_desc" class="bg-white">{{ $json['header']['subprograma'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Proyecto:</td>
                            <td class="bg-white c-text-alt text-center" id="proy_no">{{ $json['header']['no_proyecto'] }}</td>
                            <th id="proy_desc" class="bg-white c-blue">{{ $json['header']['proyecto'] }}</th>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Dependencia General:</td>
                            <td class="bg-white c-text-alt text-center">{{ $json['header']['no_dep_gen'] }}</td>
                            <td class="bg-white">{{ $json['header']['dep_gen'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right c-text-alt">Dependencia Auxiliar:</td>
                            <td class="bg-white c-text-alt text-center">{{ $json['header']['no_dep_aux'] }}</td>
                            <td class="bg-white">{{ $json['header']['dep_aux'] }}</td>
                        </tr>
                    </table>
                        
                </div>
            </div>		
        </article>

           
            <article class="table-resp" id="app_metas">
                <table class="table table-bordered" style="border:0px;">
                    <tr>
                        <th class="bg-white no-borders" width="20" rowspan="2">#</th>
                        <th rowspan="2" width="50%" class="bg-white no-borders">Descripción de Acciones</th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-yellow-meta no-borders s-9" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Enero al 31 de Marzo {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-green-meta no-borders s-9" colspan="4">
                            Periodo Trimestral:
                            <div>01 Abril al 30 de Junio {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-blue-meta no-borders s-9" colspan="4">
                            Periodo Trimestral:
                            <div>01 Julio al 30 de Septiembre {{ $json['header']['anio'] }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-red-meta no-borders s-9" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Octubre al 31 de Diciembre {{ $json['header']['anio'] }}</div>
                        </th>
                    </tr>
                    <tr>
                        <td class="no-borders"></td>
                        <th class="bg-white s-9" width="60">ENE.</th>
                        <th class="bg-white s-9" width="60">FEB.</th>
                        <th class="bg-white s-9" width="60">MAR.</th>
                        <th class="bg-white s-9" width="60">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white s-9" width="60">ABR.</th>
                        <th class="bg-white s-9" width="60">MAY.</th>
                        <th class="bg-white s-9" width="60">JUN.</th>
                        <th class="bg-white s-9" width="60">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white s-9" width="60">JUL.</th>
                        <th class="bg-white s-9" width="60">AGO.</th>
                        <th class="bg-white s-9" width="60">SEP.</th>
                        <th class="bg-white s-9" width="60">JUST.</th>
                        <td class="no-borders"></td>
                        <th class="bg-white s-9" width="60">OCT.</th>
                        <th class="bg-white s-9" width="60">NOV.</th>
                        <th class="bg-white s-9" width="60">DIC.</th>
                        <th class="bg-white s-9" width="60">JUST.</th>
                    </tr>
                   <template v-for="row in info">
                    <tr>
                        <td class="no-borders"></td>
                    </tr>
                   <tr>
                        <td class="text-center bg-white no-borders" rowspan="2">@{{ row.no_a }}</td>
                        <td class="bg-white c-text no-borders" rowspan="2" >
                            <div class="font-bold">@{{ row.meta }}</div>
                            <br>
                            <table class="table">
                                <tr>
                                    <td class="no-borders c-text-alt">@{{ row.um }}</td>
                                    <td class="no-borders c-text-alt text-right" width="30%">@{{ row.pa  }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="no-borders"></td>
                        <td v-for="r in row.reg[1]" class="cursor text-center c-morena bg-white btnmeses-yellow" @click.prevent="regMeses(row.idrg,r.idmes,1)">
                            <table class="table bg-transparent no-margins">
                                <tr>
                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                </tr>
                                <tr>
                                    <td class="no-borders">
                                        <div v-if="r.total_img > 0">
                                            <i class="fa fa-picture-o c-text-alt"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-center bg-white cursor" @click.prevent="regObs(row.idrg,'obs1',1)">
                            <i class="fa fa-comments s-14 c-yellow-meta" v-if='row.obs != null' ></i>
                            <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                        </td>
                        <td class="no-borders"></td>
                        <td v-for="r in row.reg[2]" class="cursor text-center c-morena bg-white btnmeses-green" @click.prevent="regMeses(row.idrg,r.idmes,2)">
                            <table class="table bg-transparent no-margins">
                                <tr>
                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                </tr>
                                <tr>
                                    <td class="no-borders">
                                        <div v-if="r.total_img > 0">
                                            <i class="fa fa-picture-o c-text"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-center bg-white cursor" @click.prevent="regObs(row.idrg,'obs2',2)">
                                <i class="fa fa-comments s-14 c-green-meta" v-if='row.obs2 != null'></i>
                                <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                        </td>
                        <td class="no-borders"></td>
                        <td v-for="r in row.reg[3]" class="cursor text-center c-morena bg-white btnmeses-blue" @click.prevent="regMeses(row.idrg,r.idmes,3)">
                            <table class="table bg-transparent no-margins">
                                <tr>
                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                </tr>
                                <tr>
                                    <td class="no-borders">
                                        <div v-if="r.total_img > 0">
                                            <i class="fa fa-picture-o c-text-alt"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-center bg-white cursor" @click.prevent="regObs(row.idrg,'obs3',3)">
                                <i class="fa fa-comments s-14 c-blue-meta" v-if='row.obs3 != null'></i>
                                <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                        </td>
                        <td class="no-borders"></td>
                        <td v-for="r in row.reg[4]" class="cursor c-morena text-center c-morena bg-white btnmeses-red" @click.prevent="regMeses(row.idrg,r.idmes,4)">
                            <table class="table bg-transparent no-margins">
                                <tr>
                                    <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                </tr>
                                <tr>
                                    <td class="no-borders">
                                        <div v-if="r.total_img > 0">
                                            <i class="fa fa-picture-o c-text-alt"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-center bg-white cursor" @click.prevent="regObs(row.idrg,'obs4',4)">
                            <i class="fa fa-comments s-14 c-red-meta" v-if='row.obs4 != null'></i>
                            <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                        </td>
                   </tr>

                   <tr>
                        <td class="no-borders"></td>
                        
                        <td class="no-padding text-center warning">@{{  row.tr1 > 0 ? row.tt1 : '' }}</td>
                        <td class="no-padding text-center warning">@{{ row.tr1 > 0 ? row.resta1 : ''}}</td>
                        <td class="no-padding text-center c-white bg-yellow-meta">@{{ row.t1 }}</td>
                        <td :class="(row.tr1 > 0 && (row.total_m1 > 110 || row.total_m1 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right warning'">@{{ row.tr1 > 0 ? (row.total_m1+'%') : '' }}</td>

                        <td class="no-borders"></td>

                        <td class="no-padding text-center success">@{{  row.tr2 > 0 ? row.tt2 : '' }}</td>
                        <td class="no-padding text-center success">@{{ row.tr2 > 0 ? row.resta2 : ''}}</td>
                        <td class="no-padding text-center c-white bg-green-meta">@{{ row.t2 }}</td>
                        <td :class="(row.tr2 > 0 && (row.total_m2 > 110 || row.total_m2 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right success'">@{{ row.tr2 > 0 ? (row.total_m2+'%') : '' }}</td>

                        <td class="no-borders"></td>

                        <td class="no-padding text-center info">@{{  row.tr3 > 0 ? row.tt3 : '' }}</td>
                        <td class="no-padding text-center info">@{{ row.tr3 > 0 ? row.resta3 : ''}}</td>
                        <td class="no-padding text-center c-white bg-blue-meta">@{{ row.t3 }}</td>
                        <td :class="(row.tr3 > 0 && (row.total_m3 > 110 || row.total_m3 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right info'">@{{ row.tr3 > 0 ? (row.total_m3+'%') : '' }}</td>

                        <td class="no-borders"></td>

                        <td class="no-padding text-center danger">@{{ row.tr4 > 0 ? row.tt4 : '' }}</td>
                        <td class="no-padding text-center danger">@{{ row.tr4 > 0 ? row.resta4 : ''}}</td>
                        <td class="no-padding text-center c-white bg-red-meta">@{{ row.t4 }}</td>
                        <td :class="(row.tr4 > 0 && (row.total_m4 > 110 || row.total_m4 <= 89.99)) ? 'no-padding text-right bg-pink c-white' : 'no-padding text-right danger'">@{{ row.tr4 > 0 ? (row.total_m4+'%') : '' }}</td>
                    </tr>

                    <tr>
                        <td class="no-borders"></td>
                    </tr>

                    </template>
                </table>
            </article>
        </section>

        <div class="col-sm-12 col-md-12 m-b-lg"></div>
        <div class="col-sm-12 col-md-12 m-b-lg"></div>
</div>	
<script>
     var metas = new Vue({
        el:'#app_metas',
        data:{
            info : [],
            anioActual:0
        },
        methods:{
            rowsMetas(){
                axios.get('{{ URL::to("reporte/metasprojects?id=".$id) }}',{
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
            }
        },
        mounted(){
            this.rowsMetas();
        }
    });
</script>
@stop
