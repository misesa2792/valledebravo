@include("templates.presupuesto.header.view", array("ses_logo_izq"=> $proy->logo_izq, "ses_anio"=> $proy->anio))

<article class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $proy->anio }}</th>
            </tr>
        </table>
    </div>
</article>

<article class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $proy->municipio }}</th>
                <td>No.</td>
                <th class="text-center">{{ $proy->no_municipio }}</th>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <td>PbRM-01b</td>
                <th colspan="3" class="text-center">
                    <div>Programa Anual</div>
                    <div>Descripción del programa presupuestario</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-6 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Programa presupuestario: </th>
                <td>{{ $proy->no_programa }}</td>
                <td>{{ $proy->programa }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $proy->no_dep_gen }}</td>
                <td>{{ $proy->dep_gen }}</td>
            </tr>
        </table>
    </div>
</article>

<br>


<div class="col-md-12 m-b-md">
   <table class="table table-bordered bg-white">
        <tr class="t-tr-s16">
            <th class="c-text-alt">Diagnóstico de Programa presupuestario elaborado usando análisis FODA </th>
        </tr>
        <tr class="t-tr-s16">
            <td>
                <div>FORTALEZAS</div>
                <div>
                    @foreach ($foda1 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div>OPORTUNIDADES</div>
                <div>
                    @foreach ($foda2 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div>DEBILIDADES</div>
                <div>
                    @foreach ($foda3 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div>AMENAZAS</div>
                <div>
                    @foreach ($foda4 as $f)
                        <div>
                            <ul>
                                <li class="s-16">
                                {{ $f->foda }}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table> 
</div>

<div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Objetivo del Programa presupuestario </th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $proy->objetivo_programa }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Estrategias para alcanzar el objetivo del Programa presupuestario</th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $proy->estrategias_objetivo }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Objetivo, Estrategias y Líneas de Acción del PDM atendidas </th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $proy->pdm }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario </th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $proy->ods }}</td>
         </tr>
     </table> 
 </div>

<br>


<br>

@if($proy->anio == '2025')
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s16 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA</div>
                <br>
                <br>
                <input type="text" value="{{ $proy->titular_dep_gen }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep" placeholder="TITULAR DE LA DEPENDENCIA" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <br>
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">REVISÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                <br>
                <br>
                <input type="text" value="{{ $proy->titular_tesoreria }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero" placeholder="TESORERO MUNICIPAL" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <br>
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">AUTORIZÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                <br>
                <br>
                <input type="text" value="{{ $proy->titular_uippe }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_uippe" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_uippe_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <br>
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
       </tr>
    </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
</article>
@endif
<style>
    ul, ol{
        margin-bottom: 0px;
    }
</style>
<script>
     $(".btnexportar").click(function(e){
        e.preventDefault();
        let txt_titular_dep = $("#txt_titular_dep").val();
        let txt_tesorero = $("#txt_tesorero").val();
        let txt_titular_uippe = $("#txt_titular_uippe").val();
        if(txt_titular_dep == ""){
            toastr.warning("Ingresa nombre del titular de la dependencia");
        }else if(txt_tesorero == ""){
            toastr.warning("Ingresa nombre del tesorero municipal");
        }else if(txt_titular_uippe == ""){
            toastr.warning("Ingresa nombre de titular de la UIPPE");
        }else{

            let ti_c = $("#txt_titular_dep_cargo").val();
            let te_c = $("#txt_tesorero_cargo").val();
            let ui_c = $("#txt_titular_uippe_cargo").val();

            swal({
                title : 'PDF PbRM-01b',
                text: 'Estás seguro de generar el PDF PbRM-01b?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
            }).then((willOk) => {
                if(willOk){
                	$('#sximo-modal').modal("toggle");

                    axios.get('{{ URL::to($pageModule."/generarpdf") }}',{
                        params : {key:"{{ $token }}",txt_titular_dep:txt_titular_dep,txt_tesorero:txt_tesorero,txt_titular_uippe:txt_titular_uippe,ti_c:ti_c, te_c:te_c, ui_c:ui_c}
                        }).then(response => {
                            let row = response.data;
                            if(row.success == "ok"){
                                query();
                                window.open('{{ URL::to($pageModule."/download?k=") }}'+row.k, '_blank');
                            }else{
                                toastr.warning("Error al generar el PDF!");
                            }
                    })
                    
                }
            })
         
        }
    })
</script>