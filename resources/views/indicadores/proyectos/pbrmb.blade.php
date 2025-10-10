@extends('layouts.app')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
  <template id="component_body">
    <article class="col-md-12 no-padding">

      <div class="col-md-12 no-padding">
        <button v-if="count == true"
                type="button" class="tips btn btn-sm btn-white b-r-5" @click="changeEstatusReverse()" title="Revertir PDF">
            <i class="fa icon-file-pdf c-danger"></i>&nbsp;Revertir PDFs
        </button>

        <span class="subrayado s-14 cursor icon-animation" v-else @click="changeEstatusReverse()"><i class="fa fa-arrow-circle-left c-blue"></i>&nbsp;Regresar a tabla de proyectos</span>
    </div>

      <section class="col-sm-12 col-md-12 col-lg-12 b-r-5 p-xs m-b-xs" v-if="count == true">

          <table class="table no-margins table-hover" style="border:none">
              <tr class="t-tr-s14 c-text-alt">
                <td colspan="19" class="no-borders"></td>
                <td colspan="4" class="no-borders c-text-alt text-center">Oficio Dictamen de Reconducción</td>
              </tr>
              <tr class="t-tr-s14 c-text-alt">
                <td colspan="19" class="no-borders"></td>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
              </tr>
              <tr class="t-tr-s14 c-text-alt">
                <td colspan="19" class="no-borders"></td>
                <td class="border-gray c-text-alt text-center">
                  <comp-btn-dic :url="dic1" :trim="'1'"></comp-btn-dic>
                </td>
                <td class="border-gray c-text-alt text-center">
                  <comp-btn-dic :url="dic2" :trim="'2'"></comp-btn-dic>
                </td>
                <td class="border-gray c-text-alt text-center">
                  <comp-btn-dic :url="dic3" :trim="'3'"></comp-btn-dic>
                </td>
                <td class="border-gray c-text-alt text-center">
                  <comp-btn-dic :url="dic4" :trim="'4'"></comp-btn-dic>
                </td>
              </tr>

              <tr class="t-tr-s14 c-text-alt">
                <td rowspan="2" class="no-borders" width="30">#</td>
                <td rowspan="2" class="no-borders" width="120">Número</td>
                <td rowspan="2" class="no-borders">Proyecto</td>
                <td rowspan="2" class="no-borders"></td>
                <td colspan="4" class="no-borders c-text-alt text-center">FODA</td>
                <td rowspan="2" class="no-borders"></td>
                <td colspan="4" class="no-borders c-text-alt text-center">Formato Reconducción</td>
                <td rowspan="2" class="no-borders"></td>
                <td colspan="4" class="no-borders c-text-alt text-center">Formato PbRM-08b</td>
                <td rowspan="2" class="no-borders"></td>
                <td colspan="4" class="no-borders c-text-alt text-center">Formato Tarjeta de Justificación</td>
                <td rowspan="2" class="no-borders c-text-alt"></td>
              </tr>
              <tr>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                <td width="40" class="text-center c-white bg-green-meta">2</td>
                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                <td width="40" class="text-center c-white bg-red-meta">4</td>
            </tr>
              <tr class="t-tr-s14 c-text-alt" v-for="(p, indexp) in row">
                <td class="no-borders">@{{ p.numero }}</td>
                <td class="no-borders"><span class="badge badge-primary badge-outline">@{{ p.no_proyecto }}</span></td>
                <td class="no-borders c-blue"> @{{ p.proyecto }}</td>

                <td class="no-borders">
                  <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c s-16 b-r-30" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-primary-alt"> FODA </span></button>
                    <ul class="dropdown-menu text-left overflow-h s-16 c-text-alt" role="menu">
                        <li><a  href="#" target="_blank" class="tips btnfoda" @click.prevent="addFODA(p.id,'1')" ><i class="fa fa-comments c-primary-alt"></i> Trimestre #1</a></li>
                        <li><a  href="#" target="_blank" class="tips btnfoda" @click.prevent="addFODA(p.id,'2')" ><i class="fa fa-comments c-primary-alt"></i> Trimestre #2</a></li>
                        <li><a  href="#" target="_blank" class="tips btnfoda" @click.prevent="addFODA(p.id,'3')" ><i class="fa fa-comments c-primary-alt"></i> Trimestre #3</a></li>
                        <li><a  href="#" target="_blank" class="tips btnfoda" @click.prevent="addFODA(p.id,'4')" ><i class="fa fa-comments c-primary-alt"></i> Trimestre #4</a></li>
                    </ul>
                </div>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.foda1" :id="p.id" :trim="'1'" :type="'5'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.foda2" :id="p.id" :trim="'2'" :type="'5'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.foda3" :id="p.id" :trim="'3'" :type="'5'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.foda4" :id="p.id" :trim="'4'" :type="'5'" :no="p.numero"></comp-btn-pdf>
                </td>

                <td class="no-borders"></td>

                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.url1" :id="p.id" :trim="'1'" :type="'1'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.url2" :id="p.id" :trim="'2'" :type="'1'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.url3" :id="p.id" :trim="'3'" :type="'1'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.url4" :id="p.id" :trim="'4'" :type="'1'" :no="p.numero"></comp-btn-pdf>
                </td>

                <td class="no-borders"></td>

                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.ocho1" :id="p.id" :trim="'1'" :type="'4'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.ocho2" :id="p.id" :trim="'2'" :type="'4'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.ocho3" :id="p.id" :trim="'3'" :type="'4'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.ocho4" :id="p.id" :trim="'4'" :type="'4'" :no="p.numero"></comp-btn-pdf>
                </td>

                <td class="no-borders"></td>

                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.jus1" :id="p.id" :trim="'1'" :type="'2'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.jus2" :id="p.id" :trim="'2'" :type="'2'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.jus3" :id="p.id" :trim="'3'" :type="'2'" :no="p.numero"></comp-btn-pdf>
                </td>
                <td class="text-center border-gray">
                  <comp-btn-pdf :url="p.jus4" :id="p.id" :trim="'4'" :type="'2'" :no="p.numero"></comp-btn-pdf>
                </td>

                
                <td class="text-center border-gray" width="20">
                  <i class="fa icon-arrow-right5 s-16 c-primary tips cursor" @click.prevent="viewFiles(p.id)" title="Abrir Meta"></i>
                </td>

              </tr>
          </table>
      </section>


      <section class="col-sm-12 col-md-12 col-lg-12 b-r-5 p-xs m-b-xs" v-if="count == false">

        <table class="table no-margins table-hover" style="border:none">
          <tr class="t-tr-s14 c-text-alt">
            <td colspan="18" class="no-borders"></td>
            <td colspan="4" class="no-borders c-text-alt text-center">Oficio Dictamen de Reconducción</td>
          </tr>
          <tr class="t-tr-s14 c-text-alt">
            <td colspan="18" class="no-borders"></td>
            <td width="40" class="text-center c-white bg-yellow-meta">1</td>
            <td width="40" class="text-center c-white bg-green-meta">2</td>
            <td width="40" class="text-center c-white bg-blue-meta">3</td>
            <td width="40" class="text-center c-white bg-red-meta">4</td>
          </tr>
          <tr class="t-tr-s14 c-text-alt">
            <td colspan="18" class="no-borders"></td>
            <td class="border-gray c-text-alt text-center">
              <comp-btn-dic-reverse :url="dic1" :trim="'1'"></comp-btn-dic-reverse>
            </td>
            <td class="border-gray c-text-alt text-center">
              <comp-btn-dic-reverse :url="dic2" :trim="'2'"></comp-btn-dic-reverse>
            </td>
            <td class="border-gray c-text-alt text-center">
              <comp-btn-dic-reverse :url="dic3" :trim="'3'"></comp-btn-dic-reverse>
            </td>
            <td class="border-gray c-text-alt text-center">
              <comp-btn-dic-reverse :url="dic4" :trim="'4'"></comp-btn-dic-reverse>
            </td>
          </tr>

            <tr class="t-tr-s14 c-text-alt">
              <td rowspan="2" class="no-borders" width="30">#</td>
              <td rowspan="2" class="no-borders" width="120">Número</td>
              <td rowspan="2" class="no-borders">Proyecto</td>
              <td colspan="4" class="no-borders c-text-alt text-center">FODA</td>
              <td rowspan="2" class="no-borders"></td>
              <td colspan="4" class="no-borders c-text-alt text-center">Formato Reconducción</td>
              <td rowspan="2" class="no-borders"></td>
              <td colspan="4" class="no-borders c-text-alt text-center">Formato PbRM-08b</td>
              <td rowspan="2" class="no-borders"></td>
              <td colspan="4" class="no-borders c-text-alt text-center">Formato Tarjeta de Justificación</td>
              <td rowspan="2" class="no-borders c-text-alt"></td>
            </tr>
            <tr>
              <td width="40" class="text-center c-white bg-yellow-meta">1</td>
              <td width="40" class="text-center c-white bg-green-meta">2</td>
              <td width="40" class="text-center c-white bg-blue-meta">3</td>
              <td width="40" class="text-center c-white bg-red-meta">4</td>
              <td width="40" class="text-center c-white bg-yellow-meta">1</td>
              <td width="40" class="text-center c-white bg-green-meta">2</td>
              <td width="40" class="text-center c-white bg-blue-meta">3</td>
              <td width="40" class="text-center c-white bg-red-meta">4</td>
              <td width="40" class="text-center c-white bg-yellow-meta">1</td>
              <td width="40" class="text-center c-white bg-green-meta">2</td>
              <td width="40" class="text-center c-white bg-blue-meta">3</td>
              <td width="40" class="text-center c-white bg-red-meta">4</td>
              <td width="40" class="text-center c-white bg-yellow-meta">1</td>
              <td width="40" class="text-center c-white bg-green-meta">2</td>
              <td width="40" class="text-center c-white bg-blue-meta">3</td>
              <td width="40" class="text-center c-white bg-red-meta">4</td>
          </tr>
            <tr class="t-tr-s14 c-text-alt" v-for="(p, indexp) in row">
              <td class="no-borders">@{{ p.numero }}</td>
              <td class="no-borders"><span class="badge badge-danger badge-outline">@{{ p.no_proyecto }}</span></td>
              <td class="no-borders c-danger"> @{{ p.proyecto }}</td>

              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.foda1" :id="p.id" :trim="'1'" :type="'5'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.foda2" :id="p.id" :trim="'2'" :type="'5'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.foda3" :id="p.id" :trim="'3'" :type="'5'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.foda4" :id="p.id" :trim="'4'" :type="'5'"></comp-btn-pdf-reverse>
              </td>

              <td class="no-borders"></td>

              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.url1" :id="p.id" :trim="'1'" :type="'1'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.url2" :id="p.id" :trim="'2'" :type="'1'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.url3" :id="p.id" :trim="'3'" :type="'1'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.url4" :id="p.id" :trim="'4'" :type="'1'"></comp-btn-pdf-reverse>
              </td>

              <td class="no-borders"></td>

              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.ocho1" :id="p.id" :trim="'1'" :type="'4'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.ocho2" :id="p.id" :trim="'2'" :type="'4'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.ocho3" :id="p.id" :trim="'3'" :type="'4'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.ocho4" :id="p.id" :trim="'4'" :type="'4'"></comp-btn-pdf-reverse>
              </td>


              <td class="no-borders"></td>

              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.jus1" :id="p.id" :trim="'1'" :type="'2'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.jus2" :id="p.id" :trim="'2'" :type="'2'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.jus3" :id="p.id" :trim="'3'" :type="'2'"></comp-btn-pdf-reverse>
              </td>
              <td class="border-gray text-center">
                <comp-btn-pdf-reverse :url="p.jus4" :id="p.id" :trim="'4'" :type="'2'"></comp-btn-pdf-reverse>
              </td>

            </tr>
        </table>

        <div class="col-md-12 no-padding m-t-md">
          <div class="alert alert-danger fade in block-inner">
              <i class="icon-warning"></i>  Para revertir un PDF, haga clic en el PDF que desea revertir.
          </div>
      </div>
    </section>

    </article>
  </template>

<template id="comp_btn_dic">
    <div v-if="url == 'empty'">
      <i class="fa icon-file-pdf c-text-alt s-12 cursor" @click.prevent="generateDicPDF(trim)"></i>
    </div>
    <div v-else-if="url == 'no_aplica'">
      <i v-if="trim == 1" class="fa fa-check-circle c-yellow-meta s-12"></i>
      <i v-else-if="trim == 2" class="fa fa-check-circle c-green-meta s-12"></i>
      <i v-else-if="trim == 3" class="fa fa-check-circle c-blue-meta s-12"></i>
      <i v-else class="fa fa-check-circle c-red-meta s-12"></i>
    </div>
    <div v-else-if="url != 'empty' && url != 'no_aplica'">
      <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(url)"></i>
    </div>
</template>

<template id="comp_btn_dic_reverse">
  <div v-if="url != 'empty' && url != 'no_aplica'">
    <i class="fa icon-file-pdf c-danger s-12 icon-animation cursor" @click="reversePDFDic(trim,url)"></i>
  </div>
</template>

<template id="comp_btn_pdf">
    <div v-if="url == 'empty'">
      <i class="fa icon-file-pdf c-text-alt s-12 cursor" @click.prevent="generateRecPDF(type,id,trim, no)"></i>
    </div>
    <div v-else-if="url == 'no_aplica'">
      <i v-if="trim == 1" class="fa fa-check-circle c-yellow-meta s-12"></i>
      <i v-else-if="trim == 2" class="fa fa-check-circle c-green-meta s-12"></i>
      <i v-else-if="trim == 3" class="fa fa-check-circle c-blue-meta s-12"></i>
      <i v-else class="fa fa-check-circle c-red-meta s-12"></i>
    </div>
    <div v-else>
      <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(url)"></i>
    </div>
</template>

<template id="comp_btn_pdf_reverse">
  <div class="text-center" v-if="url != 'no_aplica' && url != 'empty'">
      <i class="fa icon-file-pdf c-danger s-12 icon-animation cursor" @click="reversePDF(id,trim,url,type)"></i>
  </div>
</template>

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
    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-16">
        <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
        <li><i>{{ $row->institucion }}</i></li>
        <li><i>{{ $row->numero }} {{ $row->area }}</i></li>
        <li><i>{{ $row->no_coord }} {{ $row->coordinacion }}</i></li>
        <li class="active"><i>Proyectos</i></li>
      </ul>	  
	  </section>

    <section class="col-md-12 no-padding m-t-md m-b-md">
      <div class="col-md-12 p-rel">
          <ul class="nav nav-tabs text-right">
                 <li>
                    <button type="button" onclick="location.href='{{ URL::to($pageModule.'/principal?k='.$token.'&idy='.$idy.'&year='.$year.'&type='.$type) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
                      <i class="fa  fa-arrow-circle-left "></i> Regresar
                    </button>
                 </li>
                  <li>
                    <button type="button" class="btn bg-blue c-white tips" @click.prvent="selectYear()" :title="year">
                        <i class="fa fa-calendar s-14"></i> Indicadores
                    </button>
                  </li>
                  <li>
                    <a href="{{ URL::to($pageModule.'/pbrmb?k='.$token) }}"  class="btn btn-xs bg-white tips">
                      <i class="fa fa-calendar s-14"></i> PbRM-08b
                    </a>
                  </li>
          </ul>
      </div>
    </section>

    <card-loading v-if="isLoading"></card-loading>
    <div class="col-md-12 m-t-md" v-else>
      <section class="col-md-12">

        <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
  
          <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
  
              <span class="line-circle-a text-center font-bold tips" :title="year">@{{ year }} </span>
          
              <div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c" id="line-comm" >
  
                <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding com">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <div v-if="contador == 0" class="c-text-alt s-14">No se encontraron proyectos del año @{{ year }}!</div>
                    </div>
                </div>
                <div class="col-md-12" v-if="contador > 0">
                  <component-body :row="rowsData" :dic1="dic1" :dic2="dic2" :dic3="dic3" :dic4="dic4"></component-body>
                </div>
  
              </div>
          </section>
          
      </article>
      </section>
      
      <div class="col-md-12">
          <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
              <section class="col-sm-12 col-md-12 col-lg-12 p-md">
                  <span class="line-circle-a text-center font-bold tips" title="Inicio"><i class="fa fa-calendar s-16"></i></span>
  
                  <div class="col-sm-12 col-md-12 col-lg-12 bg-white b-r-5 p-md b-r-c s-14" id="line-comm" >
                        <div><span class="c-text-alt">Total de proyectos: </span> <strong class="c-text"> @{{ contador  }}</strong></div>
                  </div>
              </section>
          
          </article>
      </div>
  
  
  
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

  Vue.component("comp-btn-pdf",{
			template : "#comp_btn_pdf",
			props : ['url','id','trim','type', 'no'],
        methods:{
          generateRecPDF(type,id,trim,no){
            modalMisesa("{{ URL::to($pageModule.'/formatos') }}",{type:type, k:id, trim:trim, no:no},"Generar PDF","80%");
          },downloadPDF(number){
            window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
          }
        }
	})

  Vue.component("comp-btn-dic",{
			template : "#comp_btn_dic",
			props : ['url','trim'],
        methods:{
          generateDicPDF(trim){
            modalMisesa("{{ URL::to($pageModule.'/formatos') }}",{type:3, k:pbrmc.token, trim:trim},"Generar PDF","80%");
          },downloadPDF(number){
            window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
          }
        }
	})

  Vue.component("comp-btn-dic-reverse",{
			template : "#comp_btn_dic_reverse",
			props : ['url','trim'],
        methods:{
          reversePDFDic(trim, number){
              swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF del dictamen del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reversedictamen") }}',{
                            params : {k:pbrmc.token, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmc.rowsProjects();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
               
            }
        }
	})

  Vue.component("comp-btn-pdf-reverse",{
			template : "#comp_btn_pdf_reverse",
			props : ['url','id','trim','type'],
        methods:{
          reversePDF(id,trim,number,type){
            if(type == 1){
              swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF de recoducción del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reversereconduccion") }}',{
                            params : {k:id, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmc.rowsProjects();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
            }else if(type == 2){
              swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF de justificación del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reversejustificacion") }}',{
                            params : {k:id, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmc.rowsProjects();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
            }else if(type == 5){
              swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF del FODA del Trim. #'+trim+'?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/reversefoda") }}',{
                            params : {k:id, trim:trim, number:number}
                        }).then(response => {
                            var row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                pbrmc.rowsProjects();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
            }else if(type == 4){
              swal({
                    title : 'Revertir PDF',
                    text: 'Estás seguro de revertir el PDF del PbRM-08b del Trim. #'+trim+'?',
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
                                pbrmc.rowsProjects();
                            }else{
                                toastr.error(row.message);
                            }

                        })
                    }
                })
            }
               
            }
        }
	})


  Vue.component('component-body', {
        template: '#component_body',
        props: ['row', 'dic1', 'dic2', 'dic3', 'dic4'],
        data: function () {
            return {
                count: true,
            }
        },
        methods: {
            changeEstatusReverse(){
                this.count = (this.count == true ? false : true);
            },
            viewFiles(id){
              window.location.href = "{{ URL::to($pageModule.'/detalle?k=') }}"+pbrmc.token+'&id='+id;
            },addFODA(id, trim){
              modalMisesa("{{ URL::to('reporte/addfoda') }}",{k:id, trim:trim},"FODA","90%");
            }
        }
    });



     var pbrmc = new Vue({
        el:'#app_pbrmc',
        data:{
            rowsData : [],
            dic1:'',
            dic2:'',
            dic3:'',
            dic4:'',
            contador:0,
            idyear:0,
            year:0,
            token:0,
            cancelTokenSource: null,
            isLoading:false,
            proyectosCache: [] // Almacena proyectos por año,
      },
      computed: {
          checkActive(){
              return this.idyear;
          }
      },
        methods:{
          rowsProjects(){

              this.isLoading = true;
    
              if (this.cancelTokenSource) {
                  this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
              }

              // Crear un nuevo token de cancelación
              this.cancelTokenSource = axios.CancelToken.source();

              axios.get('{{ URL::to($pageModule."/listprojects") }}',{
                  params : {k:this.token,idyear:this.idyear},
                  cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
              }).then(response => {
                  var row = response.data;
                  this.rowsData = row.rowsData;
                  this.dic1 = row.dic1;
                  this.dic2 = row.dic2;
                  this.dic3 = row.dic3;
                  this.dic4 = row.dic4;
                  this.contador = row.total;
              }).catch(error => {
                  /*if (axios.isCancel(error)) {
                  } */
              }).finally(() => {
                  // Ocultar el loading cuando la solicitud termina (éxito o error)
                  this.isLoading = false;
              });
             
            },addPbrm(){
              modalMisesa("{{ URL::to($pageModule.'/add') }}",{anio:this.year, idanio:this.idyear,k:this.token},"Agregar PbRM-01c","90%");
            },createPDF(id){
              modalMisesa("{{ URL::to($pageModule.'/pdf') }}",{key:id},"Generar PDF","80%");
            },downloadPDF(id){
              window.open("{{ URL::to($pageModule.'/download?k=') }}"+id, '_blank');
            },editPbrm(id){
              modalMisesa("{{ URL::to($pageModule.'/edit') }}",{key:id},"Editar PbRM-01c","90%");
            },undoPbrm(id){
              swal({
                  title : 'Estás seguro de revertir el registro de PbRM-01c?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.post('{{ URL::to($pageModule."/revertir") }}',{
                          params : {key:id}
                      }).then(response => {
                          let row = response.data;
                          if(row.success == "ok"){
                              this.rowsProjects();
                          }
                      })
                  }
              })
            },destroyPbrm(id){
              swal({
                  title : 'Estás seguro de eliminar el registro de PbRM-01c?',
                  icon : 'warning',
                  buttons : true,
                  dangerMode : true
              }).then((willDelete) => {
                  if(willDelete){
                      axios.delete('{{ URL::to($pageModule."/destroy") }}',{
                          params : {key:id}
                      }).then(response => {
                          let row = response.data;
                          if(row.success == "ok"){
                              this.rowsProjects();
                          }
                      })
                  }
              })
            },selectYear(){
                this.idyear = this.idyear;
                this.year = this.year;
                this.rowsProjects();
            }
        },
        mounted(){
          this.token = "{{ $token }}";
          this.idyear = "{{ $idy }}";
          this.year = "{{ $year }}";
          this.rowsProjects();
        }
    });
  </script>
  
@stop