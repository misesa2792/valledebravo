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
                <td>PbRM-02a</td>
                <th colspan="3" class="text-center">
                    <div>Calendarización de Metas</div>
                    <div>de Actividad por Proyecto</div>
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
                <th>Proyecto: </th>
                <td>{{ $proy->no_proyecto }}</td>
                <td>{{ $proy->proyecto }}</td>
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


<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="t-tr-s16 c-text-alt">
            <th rowspan="3" width="40" class="text-center">Código</th>
            <th rowspan="3" width="30%" class="text-center">Descripción de las Metas de Actividad </th>
            <th rowspan="3" class="text-center">Unidad de Medida </th>
            <th rowspan="3" class="text-center">Cantidad Programada Anual</th>
            <th colspan="8" class="text-center">Calendarización de Metas Físicas</th>
        </tr>
        <tr class="t-tr-s16 c-text-alt">
            <th colspan="2" class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th colspan="2" class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th colspan="2" class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th colspan="2" class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
        </tr>
        <tr class="t-tr-s16 c-text-alt">
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
        </tr>
        @foreach ($projects as $p)
            <tr class="t-tr-s16 c-text bg-white">
                <td class="text-center">{{ $p->codigo }}</td>
                <td>{{ $p->meta }}</td>
                <td class="text-center">{{ $p->unidad_medida }}</td>
                <td class="text-center fun">{{ SiteHelpers::getMassDecimales($p->aa_anual) }}</td>
                <td class="text-center c-yellow-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim1) }}</td>
                <td class="text-center c-yellow-meta">{{ $p->aa_porc1 }}</td>
                <td class="text-center c-green-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim2) }}</td>
                <td class="text-center c-green-meta">{{ $p->aa_porc2 }}</td>
                <td class="text-center c-blue-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim3) }}</td>
                <td class="text-center c-blue-meta">{{ $p->aa_porc3 }}</td>
                <td class="text-center c-red-meta">{{ SiteHelpers::getMassDecimales($p->aa_trim4) }}</td>
                <td class="text-center c-red-meta">{{ $p->aa_porc4 }}</td>
            </tr>
        @endforeach
        @if(count($projects) <= 10)
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
                <td>.</td>
                <td>.</td>
                <td>.</td>
                <td>.</td>
                </tr>
            @endfor
        @endif
    </table>
</div>

<br>
@if($proy->anio == '2025')
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s16 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <br>
                <br>
                <br>
                <input type="text" value="" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep" placeholder="ELABORÓ" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" value="" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_titular_dep_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
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
                <input type="text" value="{{ $proy->titular_dep_gen }}" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero" placeholder="REVISÓ" style="border-bottom:2px solid var(--border-color) !important;" required>
                <input type="text" onkeyup="MassMayusculas(this);" class="form-control text-center no-borders c-blue font-bold" id="txt_tesorero_cargo" placeholder="INGRESA CARGO" style="border-bottom:2px solid var(--border-color) !important;">
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
        }else if(txt_fecha == ""){
            toastr.warning("Ingresa fecha");
        }else{

            let ti_c = $("#txt_titular_dep_cargo").val();
            let te_c = $("#txt_tesorero_cargo").val();
            let ui_c = $("#txt_titular_uippe_cargo").val();

            swal({
                title : 'PDF PbRM-02a',
                text: 'Estás seguro de generar el PDF PbRM-02a?',
                icon : 'warning',
                buttons : true,
                dangerMode : true
            }).then((willOk) => {
                if(willOk){
                	$('#sximo-modal').modal("toggle");

                    axios.get('{{ URL::to($pageModule."/generarpdf") }}',{
                        params : {key:"{{ $token }}",txt_titular_dep:txt_titular_dep,txt_tesorero:txt_tesorero,txt_titular_uippe:txt_titular_uippe,txt_fecha:txt_fecha, ti_c:ti_c, te_c:te_c, ui_c:ui_c}
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