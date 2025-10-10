{{--*/
  $gp = Auth::user()->group_id;
  /*--}}
 
    @foreach ($rows as $v)

    {{--*/
        $key_create = SiteHelpers::CF_encode_json(array('id' => $idac,'idanio'=>$v['ida'],'anio'=>$v['anio'],'idi'=>$idi, 'type'=>$type));
    /*--}}

    <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
        <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
            <span class="line-circle-a text-center font-bold tips" title="{{ $v['anio'] }}">{{ $v['anio'] }}</span>
        
            <div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c" id="line-comm" >
            
            <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto com">

                <div class="col-sm-9 col-md-9 col-lg-9">
                    @if($gp == 1 || $gp ==2 || $gp == 4)
                            @if($v['anio'] >= 7024)
                                <a href="#" class="tips btn btn-sm btn-success b-r-30 btnagregar" style="display: none;" title="Agregar Meta {{ $v['anio'] }}" data-k="{{ $key_create }}"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Meta {{ $v['anio'] }}</a>
                            
                                @if(count($v['reporte']) > 0)
                                    <a href="#" class="tips btn btn-sm btn-white b-r-30 btnrevertir" title="Revertir PDF {{ $v['anio'] }}" data-k="{{ $key_create }}"><i class="fa icon-file-pdf var"></i>&nbsp;Revertir PDF {{ $v['anio'] }}</a>
                                @endif
                            @endif
                    @endif
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-center">
                        @if(count($v['reporte']) > 0)
                        <table class="table table-bordered">
                            <tr><td colspan="4" class="s-16">Oficio Dictamen de Reconducción</td></tr>
                            <tr>
                                <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                                <td width="40" class="text-center c-white bg-green-meta">2</td>
                                <td width="40" class="text-center c-white bg-blue-meta">3</td>
                                <td width="40" class="text-center c-white bg-red-meta">4</td>
                            </tr>
                            <tr>
                                @if($v['d1']['total'] == 2)
                                    <td class="text-center"><i class="fa fa-check-circle c-yellow-meta s-14"></i></td>
                                @elseif($v['d1']['total'] == 1 && $v['d1']['url'] != '')
                                    <td class="text-center c-white"><a href="{{ URL::to('reporte/downloadpdf?k='.$v['d1']['idrp_dic']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                @elseif($v['d1']['total'] == 1 && $v['d1']['url'] == '')
                                <td width="40" height="30"></td>
                                @else
                                    <td width="40" height="30"></td>
                                @endif  

                                @if($v['d2']['total'] == 2)
                                    <td class="text-center"><i class="fa fa-check-circle c-green-meta s-14"></i></td>
                                @elseif($v['d2']['total'] == 1 && $v['d2']['url'] != '')
                                    <td class="text-center c-white"><a href="{{ URL::to('reporte/downloadpdf?k='.$v['d2']['idrp_dic']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                @elseif($v['d2']['total'] == 1 && $v['d2']['url'] == '')
                                <td width="40" height="30"></td>
                                @else
                                    <td width="40" height="30"></td>
                                @endif  

                                @if($v['d3']['total'] == 2)
                                    <td class="text-center"><i class="fa fa-check-circle c-blue-meta s-14"></i></td>
                                @elseif($v['d3']['total'] == 1 && $v['d3']['url'] != '')
                                    <td class="text-center c-white"><a href="{{ URL::to('reporte/downloadpdf?k='.$v['d3']['idrp_dic']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                @elseif($v['d3']['total'] == 1 && $v['d3']['url'] == '')
                                <td width="40" height="30"></td>
                                @else
                                    <td width="40" height="30"></td>
                                @endif  

                                @if($v['d4']['total'] == 2)
                                    <td class="text-center"><i class="fa fa-check-circle c-red-meta s-14"></i></td>
                                @elseif($v['d4']['total'] == 1 && $v['d4']['url'] != '')
                                    <td class="text-center c-white"><a href="{{ URL::to('reporte/downloadpdf?k='.$v['d4']['idrp_dic']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                @elseif($v['d4']['total'] == 1 && $v['d4']['url'] == '')
                                <td width="40" height="30"></td>
                                @else
                                    <td width="40" height="30"></td>
                                @endif  
                            </tr>
                        </table>
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding" >
                @if(count($v['reporte']) > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="t-tr-s16">
                                <td rowspan="2" class="no-borders" width="30"></td>
                                <td rowspan="2" class="no-borders c-text-alt">Número Proyecto</td>
                                <td rowspan="2" class="no-borders c-text-alt">Proyecto</td>
                                <td colspan="4" class="no-borders c-text-alt text-center">Formato Reconducción</td>
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
                            </tr>
                        </thead>
                
                        <tbody>
                            @foreach ($v['reporte'] as $r)
                            <tr class="t-tr-s16">
                                <td>
                                    {{--*/
                                            $key_k = SiteHelpers::CF_encode_json(array('ida'=>$ida,'idac'=>$idac,'idi'=>$idi,'type'=>$type,'idr'=>$r['idreporte'],'idp'=>$r['idproyecto'], 'idy' => $v['ida'], 'year' => $v['anio']));
                                        /*--}}
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle b-r-c" data-toggle="dropdown"><span class="fa fa-ellipsis-h c-primary-alt"></span></button>
                                        <ul class="dropdown-menu text-left overflow-h" role="menu" style="z-index: 9">
                                            <li><a href="#" class="btnanalisis" data-k="{{ $key_k }}"> <i class="fa fa-bars fun"></i> Análisis</a></li>
                                            <li><a  href="{{ URL::to('reporte/pdf?k='.$key_k) }}" target="_blank" title="Descargar PDF"><i class="fa icon-file-pdf var s-12"></i> Descargar PDF</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="c-text">{{ $r['numero'] }}</td>
                                <td class="c-text">{{ $r['proyecto'] }}</td>
                            
                                @if($r['t1']['total'] == 1)
                                    @if($r['total_proj_1'] > 0 && $r['t1']['url'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t1']['idrp_rec']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_1'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-yellow-meta s-14"></i></td>
                                    @else
                                      <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                @if($r['t2']['total'] == 1)
                                    @if($r['t2']['url'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t2']['idrp_rec']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_2'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-green-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                @if($r['t3']['total'] == 1)
                                    @if($r['t3']['url'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t3']['idrp_rec']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_3'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-blue-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                @if($r['t4']['total'] == 1)
                                    @if($r['t4']['url'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t4']['idrp_rec']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_4'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-red-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif
                            
                                <td class="no-borders"></td>

                                @if($r['t1']['total'] == 1)
                                    @if($r['t1']['url_j'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t1']['idrp_jus']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_1'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-yellow-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                
                                @if($r['t2']['total'] == 1)
                                    @if($r['t2']['url_j'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t2']['idrp_jus']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_2'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-green-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                @if($r['t3']['total'] == 1)
                                    @if($r['t3']['url_j'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t3']['idrp_jus']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_3'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-blue-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif

                                @if($r['t4']['total'] == 1)
                                    @if($r['t4']['url_j'] != '')
                                        <td class="text-center c-white">
                                            <a href="{{ URL::to('reporte/downloadpdf?k='.$r['t4']['idrp_jus']) }}" target="_blank"><i class="fa icon-file-pdf var s-14"></i></a>
                                        </td>
                                    @elseif($r['total_proj_4'] == 0)
                                        <td class="text-center"><i class="fa fa-check-circle c-red-meta s-14"></i></td>
                                    @else 
                                    <td></td>
                                    @endif
                                @else 
                                    <td></td>
                                @endif
                                
                                <td width="30" class="text-center">
                                    {{--*/ $j++; /*--}}
                                    <a  href="{{ URL::to('reporte/registrarmeta?k='.$key_k) }}" class="tips btn btn-xs btn-white no-borders" title="Abrir Meta"><i class="fa icon-arrow-right5 s-20 c-primary-alt tips"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="col-md-12">
                        <h2 class="text-center com">No se encontraron metas del año {{ $v['anio'] }}!</h2>
                    </div>
                @endif

            </div>

            </div>
        </section>
        
    </article>
  @endforeach

<style>
    .b-r{border: 1px solid red;}
    .contArticle{padding-top:10px;}
    .contArticle:hover .btnArticle{display: block;}
    /*Línea de tiempo*/
    .b-line-y{border-left:2px solid var(--color-pink);position: relative;}
    .line-circle-y{background: var(--color-pink);overflow: hidden;position: absolute;top:-10px;left:-25px;width:50px;height: 50px;border-radius: 50%;border:2px solid var(--color-pink);padding-top:15px;color:var(--color-white);}
    .line-logo{width:40px;height: 40px;margin-top:4px;margin-left:2px;}
    .line-puesto{font-size: 25px;}
    .line-emp{font-size: 18px;}
    .title-web{font-size: 18px;}
    #line-comm{margin-left:40px;margin-top: -30px;}
    #line-comm::before{
            content: '';
            position: absolute;
            left: -10px;
            top: 24px;
            border-top: 12px solid transparent;
            border-bottom: 10px solid transparent;
            border-right:12px solid var(--color-white);
        }
    .line-fecha{padding-right:50px;}
    .min-pdv{min-height:650px;}
    .b-b-gray{border-bottom:1px solid var(--color-gray);}
  </style>

<script>
     const idac = "{{ $idac }}";
    const ida = "{{ $ida }}";

    $(".tips").tooltip();
    $(".btnedit").click(function(e){
      e.preventDefault();
      let id = $(this).attr("id");
      let idanio = $(this).data("idanio");
      let anio = $(this).data("anio");
      modalMisesa("{{ URL::to('reporte/editmeta') }}",{id:id,idanio:idanio,anio:anio},"Editar Meta","95%");
    })
    $(".btnmove").click(function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('reporte/viewmovetarget') }}",{idr:$(this).attr("id"),type:0},"Mover Meta","50%");
    })
    $(".btnanalisis").click(function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('reporte/viewanalisis') }}",{k:$(this).data("k")},"Analisis Meta","99%");
    })
    $(".btnagregar").click(function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('reporte/addmeta') }}",{k:$(this).data("k")},"Agregar Meta","95%");
    })
    $(".btnrevertir").click(function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('reporte/revertirpdfmeta') }}",{k:$(this).data("k")},"Revertir PDF de Meta","80%");
    })
    $(".btnproject").click(function(e){
      e.preventDefault();
      let idr = $(this).data("idr");
      let idp = $(this).data("idp");
      let idanio = $(this).data("idanio");
      let anio = $(this).data("anio");
      let trim = $(this).data("trim");
      let mes = $(this).data("mes");
      modalMisesa("{{ URL::to('formatos/viewreconduccion') }}",{idr:idr,idp:idp,ida:ida,idac:idac,trim:trim,idanio:idanio,anio:anio,mes:mes,idi:"{{ $idi }}"},"Formato","80%");
    })
    $(".btntarjeta").click(function(e){
      e.preventDefault();
      let idr = $(this).data("idr");
      let idp = $(this).data("idp");
      let idanio = $(this).data("idanio");
      let anio = $(this).data("anio");
      let trim = $(this).data("trim");
      let mes = $(this).data("mes");
      let numero = $(this).data("numero");
      modalMisesa("{{ URL::to('formatos/viewjustificacion') }}",{idr:idr,idp:idp,ida:ida,idac:idac,trim:trim,idanio:idanio,anio:anio,mes:mes,numero:numero,idi:"{{ $idi }}"},"Formato","70%");
    })
    $(".btnformart").click(function(e){
      e.preventDefault();
      let idanio = $(this).data("idanio");
      let anio = $(this).data("anio");
      let trim = $(this).data("trim");
      let mes = $(this).data("mes");
      modalMisesa("{{ URL::to('formatos/viewdictamen') }}",{id:"{{ $idac }}",idanio:idanio,anio:anio,mes:mes,trim:trim,idi:"{{ $idi }}"},"Formato dictamnen de recondución","80%");
    })
</script>