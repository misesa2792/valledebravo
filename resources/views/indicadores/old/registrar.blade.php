@extends('layouts.app')

@section('content')

<div class="page-content row bg-body">

    <section class="page-header bg-body">
        <div class="page-title">
          <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>
    
        <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i> </a></li>
            <li><i>{{ $row->institucion }}</i></li>
            <li><i><a href="{{ URL::to('indicadores?k='.$k) }}">{{ $row->area }}</a></i></li>
            <li><i><a href="{{ URL::to('indicadores/proyectos?k='.$k) }}">{{ $row->coordinacion }}</a></i></li>
            <li><i>{{ $anio }}</i></li>
            <li class="active"><i>PbRM</i></li>
        </ul>	  
    </section>

    <div class="toolbar-line">
        <div class="col-sm-12 col-md-12 m-b-md">
            <button type="button" onclick="location.href='{{ URL::to('indicadores/proyectos?k='.$k.'&idy='.$idy.'&year='.$anio.'&type='.$type) }}' " class="btn bg-default c-text b-r-5 tips"><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
        </div>
	</div> 	
	
    <section class="table-resp m-t-md">

        <article class="col-sm-12 col-md-12 col-lg-12 no-padding">
            <div class="col-sm-12 col-md-5 col-lg-5">

                    <div class="sbox animated fadeInRight border-l-app b-r-5">
                        <div class="sbox-title"> <h3> <i class="fa fa-table"></i> Reporte de Avance de Metas</h3></div>
                        <div class="sbox-content"> 	
            
                            <div class="col-md-12 text-center">
                           
                                <table class="table">
                                    <tr class="t-tr-s16">
                                        <td class="bg-white no-borders">{{ $row->area }}</td>
                                    </tr>
                                    <tr class="t-tr-s16">
                                        <td class="pro_desc bg-white no-borders">.</td>
                                    </tr>
                                </table>
                                
                            </div>
            
                            <div style="clear:both"></div>	
                        </div>
                    </div>		 
                
            </div>
            <div class="col-sm-12 col-md-7 col-lg-7 no-padding">
                <table class="table table-bordered bg-white">
                    <tr>
                        <th colspan="3" class="text-center s-16 c-text border-t-pink">Identificador</th>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Finalidad:</td>
                        <td class="bg-white c-text-alt" id="fin_no"></td>
                        <td id="fin_desc" class="bg-white" width="60%"></td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Función:</td>
                        <td class="bg-white c-text-alt" id="fun_no"></td>
                        <td id="fun_desc" class="bg-white"></td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Subfunción:</td>
                        <td class="bg-white c-text-alt" id="sub_no"></td>
                        <td id="sub_desc" class="bg-white"></td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Programa:</td>
                        <td class="bg-white c-text-alt" id="pro_no"></td>
                        <td class="pro_desc bg-white"></td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Subprograma:</td>
                        <td class="bg-white c-text-alt" id="subp_no"></td>
                        <td id="subp_desc" class="bg-white"></td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Proyecto:</td>
                        <td class="bg-white c-text-alt" id="proy_no"></td>
                        <th id="proy_desc" class="bg-white c-primary-alt"></th>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Dependencia General:</td>
                        <td class="bg-white c-text-alt">{{ $row->numero }}</td>
                        <td class="bg-white">{{ $row->area }}</td>
                    </tr>
                    <tr class="t-tr-s16">
                        <td class="text-right c-text-alt">Dependencia Auxiliar:</td>
                        <td class="bg-white c-text-alt">{{ $row->no_coord }}</td>
                        <td class="bg-white">{{ $row->coordinacion }}</td>
                    </tr>
                </table>
            </div>
        </article>

        <article class="table-resp" id="app_metas">
                <table class="table table-bordered" style="border:0px;">
                    <tr class="t-tr-s12">
                        <th width="80" rowspan="2" class="bg-white no-borders">#</th>
                        <th rowspan="2" class="bg-white no-borders">Descripción de Acciones</th>
                        <th rowspan="2" class="text-center bg-white no-borders">Medida</th>
                        <th rowspan="2" class="text-center bg-white no-borders">Frecuencia Medición</th>
                        <th rowspan="2" class="text-center bg-white no-borders">Tipo de Operación</th>
                        <th rowspan="2" class="text-center bg-white no-borders" width="50">Prog. Anual</th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-yellow-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Enero al 31 de Marzo {{ $proy->anio }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-green-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div>01 Abril al 30 de Junio {{ $proy->anio }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-blue-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div>01 Julio al 30 de Septiembre {{ $proy->anio }}</div>
                        </th>
                        <td class="no-borders"></td>
                        <th class="text-center c-white bg-red-meta no-borders" colspan="4">
                            Periodo Trimestral:
                            <div> 01 Octubre al 31 de Diciembre {{ $proy->anio }}</div>
                        </th>
                    </tr>
                    <tr class="t-tr-s12">
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
        
                        <tr class="t-tr-s12">
                            <td class="text-center bg-white no-borders"><span class="s-12">@{{ row.no_a }}</span></td>
                            <td class="no-padding bg-white no-borders">
                                <div class="bg-white c-primary alt p-xxs s-12">@{{ row.meta }}</div>
                                <div class="c-text p-xxs s-12">@{{ row.deno }}</div>
                            </td>
                            <td class="text-center bg-white no-borders"><span class="s-12">@{{ row.um }}</span></td>
                            <td class="text-center bg-white no-borders"><span class="s-12">@{{ row.fm }}</span></td>
                            <td class="text-center bg-white no-borders">
                                <div class="s-12">@{{ row.to }}</div>
                            </td>
                            <td class="text-center bg-white no-borders"><span class="s-12">@{{ row.pa }}</span></td>
                            <td class="no-borders"></td>
                            <td v-for="r in row.m1" class="cursor text-center c-morena bg-white btnmeses-yellow" @click.prevent="regMeses(row.idrg,r.idmes,1)">
                                <table class="table bg-transparent no-margins">
                                    <tr>
                                        <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-borders">
                                            <div v-if="r.total_img > 0">
                                                <i class="fa fa-picture-o s-14 c-text-alt"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-center bg-white cursor" @click.prevent="regObs(row.idrg,'obs1',1)">
                                <i class="fa fa-comments s-14 c-yellow-meta" v-if='row.obs != null'></i>
                                <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                            </td>
                            <td class="no-borders"></td>

                            <td v-for="r in row.m2" class="cursor text-center c-morena bg-white btnmeses-green" @click.prevent="regMeses(row.idrg,r.idmes,2)">
                                <table class="table bg-transparent no-margins">
                                    <tr>
                                        <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-borders">
                                            <div v-if="r.total_img > 0">
                                                <i class="fa fa-picture-o s-14 c-text-alt"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-center bg-white cursor"  @click.prevent="regObs(row.idrg,'obs2',2)">
                                <i class="fa fa-comments s-14 c-green-meta" v-if='row.obs2 != null'></i>
                                <i class="fa fa-comments s-14 c-text-alt-50" v-else></i>
                            </td>
                            <td class="no-borders"></td>
                        
                            <td v-for="r in row.m3" class="cursor text-center c-morena bg-white btnmeses-blue" @click.prevent="regMeses(row.idrg,r.idmes,3)">
                                <table class="table bg-transparent no-margins">
                                    <tr>
                                        <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-borders">
                                            <div v-if="r.total_img > 0">
                                                <i class="fa fa-picture-o s-14 c-text-alt"></i>
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
                            
                            <td v-for="r in row.m4" class="cursor c-morena text-center c-morena bg-white btnmeses-red" @click.prevent="regMeses(row.idrg,r.idmes,4)">
                                <table class="table bg-transparent no-margins">
                                    <tr>
                                        <td class="no-borders">@{{ r.cant == 'mass' ? '' : r.cant }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-borders">
                                            <div v-if="r.total_img > 0">
                                                <i class="fa fa-picture-o s-14 c-text-alt"></i>
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
                            <td class="no-borders" colspan="7"></td>
                            
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
                axios.get('{{ URL::to("reporte/metasall?idr=".$idr) }}',{
                    params : {}
                }).then(response => {
                    this.info = [];
                    this.info = response.data;
                })
            },
            regMeses(idrg,idmes,trim){
                modalMisesa("{{ URL::to('reporte/registrarmes') }}",{idrg:idrg, idmes:idmes,trim:trim},"Registrar","60%");
            },
            regObs(idrg,obs,trim){
                modalMisesa("{{ URL::to('reporte/registrarobs') }}",{idrg:idrg,obs:obs,trim:trim},"Agregar Justificación","40%");
            },
            rowProject(){
                axios.get('{{ URL::to("reporte/dataproject?id=".$proy->idproyecto) }}',{
                    params : {}
                }).then(response => {
                    let row = response.data;
                    $("#proy_no").html(row.proy_no);
                    $("#proy_desc").html(row.proy_desc);
                    $("#fin_no").html(row.fin_numero);
                    $("#fin_desc").html(row.fin_desc);
                    $("#fun_no").html(row.fun_numero);
                    $("#fun_desc").html(row.fun_desc);
                    $("#sub_no").html(row.sub_numero);
                    $("#sub_desc").html(row.sub_desc);
                    $("#pro_no").html(row.pro_numero);
                    $(".pro_desc").html(row.pro_desc);
                    $("#subp_no").html(row.subp_numero);
                    $("#subp_desc").html(row.subp_desc);
                })
            }
        },
        mounted(){
            this.rowsMetas();
            this.rowProject();
        }
    });
</script>
@stop
