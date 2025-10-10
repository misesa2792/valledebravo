@extends('layouts.app')
@section('content')
<main class="page-content row bg-body">
    <section class="page-header bg-body">
        <div class="page-title">
            <h3 class="s-20" style="color:var({{ $row->color }});"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
        </div>
        <ul class="breadcrumb bg-body s-20">
            <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
            <li><a href="{{ URL::to('pdm?id='.$id) }}">{{ $pageTitle }}</a></li>
            <li><a href="{{ URL::to('pdm/subtemas?id='.$id.'&idtema='.$idtema) }}">Subtema</a></li>
            <li><a href="{{ URL::to('pdm/objetivos?id='.$id.'&idtema='.$idtema.'&idps='.$idps) }}">Objetivos</a></li>
            <li><a href="{{ URL::to('pdm/estrategias?id='.$id.'&idtema='.$idtema.'&idps='.$idps.'&idpo='.$idpo) }}">Estrategias</a></li>
            <li class="active"><a href="{{ URL::to('pdm/lineasaccion?id='.$id.'&idtema='.$idtema.'&idps='.$idps.'&idpo='.$idpo.'&idpe='.$idpe) }}">Líneas de Acción</a></li>
        </ul>
    </section>
    <div class="toolbar-line">
        <div class="col-md-12 m-b-md">
            <button type="button" onclick="location.href='{{ URL::to('pdm/estrategias?id='.$id.'&idtema='.$idtema.'&idps='.$idps.'&idpo='.$idpo) }}'" class="btn btn-default btn-xs b-r-30"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
            <a href="#" class="tips btn btn-sm c-white b-r-30 btnagregar" style="background: var({{ $row->color }});" title="Agregar Línea de Acción"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Línea de Acción</a>
        </div>
    </div>
    <section class="table-resp m-b-lg" style="min-height:300px;">
        <article class="col-sm-12 col-md-12 col-lg-12">
            <section class="col-sm-5 col-md-5 col-lg-5 no-padding">
                <div class="sbox animated fadeInRight" style="border-left:4px solid var({{ $row->color }});">
                    <div class="sbox-title"><h4><i class="fa fa-table"></i> PDM</h4></div>
                    <div class="sbox-content">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="col-sm-12 col-md-12 col-lg-12 p-xs b-b-gray">
                                <label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> PDM: </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->pilares }}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 p-xs b-b-gray">
                                <label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> TEMA: </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->tema }}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 p-xs b-b-gray">
                                <label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> SUBTEMA: </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->subtema }}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 p-xs b-b-gray">
                                <label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> OBJETIVO: </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->objetivo }}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                                <label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> ESTRATEGIA: </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->estrategia }}</div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </section>
            <section class="col-sm-7 col-md-7 col-lg-7 p-md">
                <div class="col-sm-12 col-md-12 col-lg-12 bg-white border-gray p-md b-r-c" id="line-comm">
                    <div class="col-sm-12 col-md-12 col-lg-12 c-text s-16 b-b-gray p-xs">LÍNEAS DE ACCIÓN</div>
                    <div class="col-sm-12 col-md-12 col-lg-12 m-t-md m-b-md" id="result2"></div>
                </div>
            </section>
        </article>
    </section>
</main>
<script>
const id = "{{ $id }}";
const idpo = "{{ $idpo }}";
const idtema = "{{ $idtema }}";
const idpe = "{{ $idpe }}";
const idps = "{{ $idps }}";
const color = "{{ $row->color }}";
query();
function query(){
    axios.get('{{ URL::to("pdm/searchlinaccion") }}',{params:{id:id,idpo:idpo,idtema:idtema,idpe:idpe,idps:idps,color:color}}).then(response=>{
        $("#result2").empty().append(response.data);
    })
}
$(".btnagregar").click(function(e){
    e.preventDefault();
    modalMisesa("{{ URL::to('pdm/agregarlinaccion') }}",{idpe:idpe},"Agregar Línea de Acción","50%");
})
$(document).on("click",".btnedit",function(e){
    e.preventDefault();
    modalMisesa("{{ URL::to('pdm/editarlinaccion') }}",{idpla:$(this).attr("id")},"Editar Línea de Acción","50%");
});
$(document).on("click",".btndestroy",function(e){
    e.preventDefault();
    let idpla=$(this).attr("id");
    swal({
        title:'Estás seguro de eliminar la línea de acción?',
        icon:'warning',
        buttons:true,
        dangerMode:true
    }).then((willDelete)=>{
        if(willDelete){
            axios.post('{{ URL::to("pdm/destroylinaccion") }}',{params:{idpla:idpla}}).then(response=>{
                let row=response.data;
                if(row.success=="ok"){
                    query();
                    toastr.success(mss_tmp.delete);
                }else{
                    toastr.error(mss_tmp.error);
                }
            })
        }
    })
})
</script>
<style>
#line-comm{margin-left:40px;margin-top:-30px;}
#line-comm::before{
    content:'';
    position:absolute;
    left:-10px;
    top:24px;
    border-top:12px solid transparent;
    border-bottom:10px solid transparent;
    border-right:12px solid var(--color-white);
}
</style>
@stop
