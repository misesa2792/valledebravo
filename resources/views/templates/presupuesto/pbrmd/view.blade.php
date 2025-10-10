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
        </table>
    </div>
</div>

<br>
<h3 class="text-center c-text-alt">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $proy->anio }}</h3>
<br>

<div class="col-md-12">
    <div class="col-md-12 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <th>Eje de Cambio/Eje Transversal: </th>
                <td></td>
                <td>{{ $proy->pilares }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Tema de Desarrollo: </th>
                <td></td>
                <td>{{ $proy->temas_desarrollo }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Programa presupuestario: </th>
                <td>{{ $proy->no_programa }}</td>
                <td>{{ $proy->programa }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Objetivo del programa presupuestario: </th>
                <td></td>
                <td>{{ $proy->objetivo }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $proy->no_dep_gen }}</td>
                <td>{{ $proy->dep_gen }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Dependencia Auxiliar:</th>
                <td>{{ $proy->no_dep_aux }}</td>
                <td>{{ $proy->dep_aux }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<h3 class="text-center c-text-alt">ESTRUCTURA DEL INDICADOR</h3>
<br>

<table class="table table-bordered bg-white">
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Nombre del Indicador</th>
        <td colspan="3">{{ $proy->nombre_indicador }}</td>
    </tr>
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Fórmula de Cálculo</th>
        <td colspan="3">{{ $proy->formula }}</td>
    </tr>
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Interpretación</th>
        <td colspan="3">{{ $proy->interpretacion }}</td>
    </tr>
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Dimención que Atiende</th>
        <td>{{ $proy->dimencion }}</td>
        <th width="15%" class="text-right">Frecuencia de Medición</th>
        <td>{{ $proy->frecuencia }}</td>
    </tr>
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Factor de Comparación</th>
        <td>{{ $proy->factor }}</td>
        <th width="15%" class="text-right">Tipo de Indicador</th>
        <td>{{ $proy->tipo }}</td>
    </tr>
     <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Descripción del Factor de Comparación</th>
        <td colspan="3">{{ $proy->desc_factor }}</td>
    </tr>
    <tr class="t-tr-s16 c-text-alt">
        <th width="15%" class="text-right">Línea Base</th>
        <td colspan="3">{{ $proy->linea }}</td>
    </tr>
</table>

<br>
<h3 class="text-center c-text-alt">CALENDARIZACIÓN TRIMESTRAL</h3>
<br>

<div class="col-md-12 ">
    <table class="table table-bordered">
        <tr class="t-tr-s16 c-text-alt">
            <th width="20%" class="text-center">Variables del Indicador</th>
            <th class="text-center">Unidad de Medida</th>
            <th class="text-center">Tipo de Operación</th>
            <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            <th class="c-white bg-primary text-center">Total Anual</th>
        </tr>
      
        @foreach ($projects as $p)
            <tr class="t-tr-s16 c-text bg-white">
                <td>{{ $p->indicador }}</td>
                <td class="text-center">{{ $p->unidad_medida }}</td>
                <td class="text-center">{{ $p->tipo_operacion }}</td>
                <td class="text-center c-yellow-meta">{{ SiteHelpers::getMassDecimales($p->trim1) }}</td>
                <td class="text-center c-green-meta">{{ SiteHelpers::getMassDecimales($p->trim2) }}</td>
                <td class="text-center c-blue-meta">{{ SiteHelpers::getMassDecimales($p->trim3) }}</td>
                <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->trim4) }}</td>
                <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->anual) }}</td>
            </tr>
        @endforeach
        @for ($i = 0; $i < 5; $i++)
        <tr class="bg-white t-tr-s16 c-white">
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
        </tr>
        @endfor
        <tr class="t-tr-s16 c-text-alt bg-white">
            <th class="text-right" colspan="3">Resultado Esperado:</th>
            <td class="text-center">{{ $proy->porc1 }}%</td>
            <td class="text-center">{{ $proy->porc2 }}%</td>
            <td class="text-center">{{ $proy->porc3 }}%</td>
            <td class="text-center">{{ $proy->porc4 }}%</td>
            <td class="text-center">{{ $proy->porc_anual }}%</td>
        </tr>
    </table>

    <div class="m-b-md">
        <strong class="c-text-alt">DESCRIPCIÓN DE LA META ANUAL:</strong> <span>{{ $proy->descripcion_meta }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">MEDIOS DE VERIFICACIÓN:</strong> <span>{{ $proy->medios_verificacion }}</span>
    </div>
    <div class="m-b-md">
        <strong class="c-text-alt">METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong> <span>{{ $proy->metas_actividad }}</span>
    </div>
</div>

<br>
@if($proy->anio == '2025')
<div class="col-md-12">
    <table class="table no-borders">
        <tr class="t-tr-s16 c-text">
            <th width="10%" class="no-borders"></th>
            <td class="text-center bg-white">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <div class="font-bold c-text-alt">.</div>
                <br>
                <input type="text" value="" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep" placeholder="ELABORÓ" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th width="20%" class="no-borders"></th>
            <td class="text-center bg-white">
                <div class="font-bold c-text-alt">VALIDÓ</div>
                <div class="font-bold c-text-alt">TITULAR DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" value="{{ $proy->titular_dep_gen }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_uippe" placeholder="VALIDÓ" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_uippe_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th width="10%" class="no-borders"></th>
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
        let txt_titular_uippe = $("#txt_titular_uippe").val();
        if(txt_titular_dep == ""){
            toastr.warning("Ingresa nombre de la persona que elaboró");
        }else if(txt_titular_uippe == ""){
            toastr.warning("Ingresa nombre de la dependencia general");
        }else{

            let ti_c = $("#txt_titular_dep_cargo").val();
            let ui_c = $("#txt_titular_uippe_cargo").val();

            swal({
                title : 'PDF PbRM-01d',
                text: 'Estás seguro de generar el PDF PbRM-01d?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
            }).then((willOk) => {
                if(willOk){
                	$('#sximo-modal').modal("toggle");

                    axios.get('{{ URL::to($pageModule."/generarpdf") }}',{
                        params : {key:"{{ $token }}",txt_titular_dep:txt_titular_dep,txt_titular_uippe:txt_titular_uippe, ti_c:ti_c, ui_c:ui_c}
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
    $('.date').datepicker({format: 'yyyy-mm-dd'});
</script>