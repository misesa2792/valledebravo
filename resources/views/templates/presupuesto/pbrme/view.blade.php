<table class="table">
    <tr>
        <td class="no-borders" width="10%" rowspan="3">
            <img src="{{ asset('mass/images/logo_toluca_tl.png') }}" width="130" height="60">
        </td>
        <td class="no-borders text-center font-bold s-16 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
        <td class="no-borders" width="10%" rowspan="3">
            <img src="{{ asset('mass/images/logos/tl2527.png') }}" width="70" height="60">
        </td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $proy->anio }}</td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
    </tr>
</table>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $proy->anio }}</th>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <td>Fecha</td>
                <th>
                    <input type="text" value="{{ date('Y-m-d') }}" id="txt_fecha" class="form-control date c-blue font-bold" placeholder="0000-00-00"  required>
                </th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $proy->municipio }}</th>
                <td>No.</td>
                <th class="text-center">{{ $proy->no_municipio }}</th>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <td>PbRM-01e</td>
                <th colspan="3" class="text-center">
                    <div>Matriz de Indicadores para Resultados por </div>
                    <div>Programa presupuestario y Dependencia General</div>
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
                <th>Obletivo del Programa Presupuestario:</th>
                <td></td>
                <td>{{ $proy->objetivo }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Dependencia General o Auxiliar:</th>
                <td>{{ $proy->no_dep_gen }}</td>
                <td>{{ $proy->dep_gen }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Eje de Cambio o Eje transversal:</th>
                <td></td>
                <td>{{ $proy->pilar }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Tema de Desarrollo:</th>
                <td></td>
                <td>{{ $proy->tema }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<table class="table table-bordered bg-white">
    <tr class="t-tr-s16">
        <th rowspan="2" width="35%">Objetivo o resumen narrativo</th>
        <th colspan="3" class="text-center">Indicadores</th>
        <th rowspan="2"  class="text-center">Medios de verificación</th>
        <th rowspan="2"  class="text-center">Supuestos</th>
    </tr>
    <tr class="t-tr-s16">
        <th>Nombre</th>
        <th>Fórmula</th>
        <th>Frecuencia y Tipo</th>
    </tr>
    <tr class="t-tr-s16">
        <th colspan="6">Fin</th>
    </tr>
    @foreach($rows_projects1 as $r)
    <tr class="t-tr-s16">
            <td>{{ $r->descripcion }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->formula }}</td>
            <td>{{ $r->frecuencia }}</td>
            <td>{{ $r->medios }}</td>
            <td>{{ $r->supuestos }}</td>
        </tr>
    @endforeach

    <tr class="t-tr-s16">
        <th colspan="6">Propósito</th>
    </tr>
    @foreach($rows_projects2 as $r)
        <tr class="t-tr-s16">
            <td>{{ $r->descripcion }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->formula }}</td>
            <td>{{ $r->frecuencia }}</td>
            <td>{{ $r->medios }}</td>
            <td>{{ $r->supuestos }}</td>
        </tr>
    @endforeach

    <tr class="t-tr-s16">
        <th colspan="6">Componentes</th>
    </tr>
    @foreach($rows_projects3 as $r)
        <tr class="t-tr-s16">
            <td>{{ $r->descripcion }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->formula }}</td>
            <td>{{ $r->frecuencia }}</td>
            <td>{{ $r->medios }}</td>
            <td>{{ $r->supuestos }}</td>
        </tr>
    @endforeach

    <tr class="t-tr-s16">
        <th colspan="6">Actividades</th>
    </tr>
    @foreach($rows_projects4 as $r)
        <tr class="t-tr-s16">
            <td>{{ $r->descripcion }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->formula }}</td>
            <td>{{ $r->frecuencia }}</td>
            <td>{{ $r->medios }}</td>
            <td>{{ $r->supuestos }}</td>
        </tr>
    @endforeach
</table>

<br>


<br>
@if($proy->anio == '2025')
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s16 c-text">
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">ELABORÓ</div>
                <div class="font-bold">TITULAR DE LA DEPENDENCIA</div>
                <br>
                <input type="text" value="{{ $proy->titular_dep_gen }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep" placeholder="TITULAR DE LA DEPENDENCIA" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <br>
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">REVISÓ</div>
                <div class="font-bold">TITULAR DE LA DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" value="{{ $proy->titular_tesoreria }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero" placeholder="TESORERO MUNICIPAL" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <br>
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">AUTORIZÓ</div>
                <div class="font-bold">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
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

<script>
     $(".btnexportar").click(function(e){
        e.preventDefault();
        let txt_titular_dep = $("#txt_titular_dep").val();
        let txt_tesorero = $("#txt_tesorero").val();
        let txt_titular_uippe = $("#txt_titular_uippe").val();
        let txt_fecha = $("#txt_fecha").val();
        
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
                title : 'PDF PbRM-01e',
                text: 'Estás seguro de generar el PDF PbRM-01e?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
            }).then((willOk) => {
                if(willOk){
                	$('#sximo-modal').modal("toggle");

                    axios.get('{{ URL::to($pageModule."/generarpdf") }}',{
                        params : {key:"{{ $token }}",txt_titular_dep:txt_titular_dep,txt_fecha:txt_fecha,txt_tesorero:txt_tesorero,txt_titular_uippe:txt_titular_uippe,ti_c:ti_c, te_c:te_c, ui_c:ui_c}
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