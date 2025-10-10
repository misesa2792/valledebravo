<form id="saveInfo" method="post" class="form-horizontal">
<table class="table">
    <tr>
        <td class="no-borders" width="10%" rowspan="3">
            @if(!empty($row['header']['row']['logo_izq'] ))
                <img src="{{ asset($row['header']['row']['logo_izq'] ) }}" width="110" height="60">
            @endif
        </td>
        <td class="no-borders text-center font-bold s-16 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
        <td class="no-borders" width="10%" rowspan="3">
            @if(!empty($row['header']['row']['logo_der'] ))
                <img src="{{ asset($row['header']['row']['logo_der'] ) }}" width="70" height="60">
            @endif
        </td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN MUNICIPAL {{ $row['header']['anio'] }}</td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
    </tr>
</table>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $row['header']['anio'] }}</th>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <td>Fecha</td>
                <td>
                    <input type="text" value="{{ date('Y-m-d') }}" name="txt_fecha" class="form-control border-b-1-dashed date c-blue" placeholder="0000-00-00"  required>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $row['header']['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $row['header']['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
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
            <tr class="t-tr-s14 c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Programa presupuestario: </th>
                <td>{{ $row['header']['no_programa'] }}</td>
                <td>{{ $row['header']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Proyecto: </th>
                <td>{{ $row['header']['no_proyecto'] }}</td>
                <td>{{ $row['header']['proyecto'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $row['header']['no_dep_gen'] }}</td>
                <td>{{ $row['header']['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Dependencia Auxiliar:</th>
                <td>{{ $row['header']['no_dep_aux'] }}</td>
                <td>{{ $row['header']['dep_aux'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
    <table class="table table-bordered  table-ses">
        <tr class="t-tr-s14 c-text-alt">
            <th rowspan="3" width="40" class="text-center">Código</th>
            <th rowspan="3" width="30%" class="text-center">Descripción de las Metas de Actividad </th>
            <th rowspan="3" class="text-center">Unidad de Medida </th>
            <th rowspan="3" class="text-center">Cantidad Programada Anual</th>
            <th colspan="8" class="text-center">Calendarización de Metas Físicas</th>
        </tr>
        <tr class="t-tr-s14 c-text-alt">
            <th colspan="2" class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th colspan="2" class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th colspan="2" class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th colspan="2" class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
        </tr>
        <tr class="t-tr-s14 c-text-alt">
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
        </tr>
        @foreach ($row['rowsRegistros'] as $p)
            <tr class="t-tr-s14 c-text bg-white">
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
        @if(count($row['rowsRegistros']) <= 10)
            @for ($i = 0; $i < 5; $i++)
                <tr class="bg-white t-tr-s14 c-white">
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
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <br>
                <br>
                <input type="text" name="txt_titular_dep" value="{{ $row['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="ELABORÓ" required>
                <input type="text" name="txt_titular_dep_cargo" value="{{ $row['header']['c_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO" >
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">REVISÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" name="txt_tesorero" value="{{ $row['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="REVISÓ" required>
                <input type="text" name="txt_tesorero_cargo" value="{{ $row['header']['c_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">AUTORIZÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                <br>
                <input type="text" name="txt_titular_uippe" value="{{ $row['header']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE"  required>
                <input type="text" name="txt_titular_uippe_cargo" value="{{ $row['header']['row']['c_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
       </tr>
    </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
</article>
</form>

<script>
     $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de generar el PDF?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    $.ajax("{{ URL::to('presupuestopbrma/generarpdfpbrmaa?k='.$token) }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".btnsave").prop("disabled",true).html(mss_spinner + " Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);

                            if(row.status == "ok"){
                                pbrmaa.rowsProjects();
                	            $('#sximo-modal').modal("toggle");
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                            }else{
                                toastr.warning("Error al generar el PDF!");
                            }
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }, error : function(err){
                            toastr.error(mss_tmp.error);
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }
                    });
            }
        })
    });
  
    $('.date').datepicker({format: 'yyyy-mm-dd'});
</script>