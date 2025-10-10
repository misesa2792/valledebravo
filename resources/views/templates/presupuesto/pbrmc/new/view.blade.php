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
                <td>PbRM-01c</td>
                <th colspan="3" class="text-center">
                    <div>Programa Anual de Metas de Actividad por Proyecto</div>
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

        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <td><strong class="c-text-alt">Objetivo del Proyecto:</strong> <span class="c-text">{{ $row['header']['obj_proyecto'] }}</span></td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="t-tr-s14 c-text-alt">
            <th rowspan="3" width="40" class="text-center">Código</th>
            <th rowspan="3" width="30%" class="text-center">Descripción de las Metas de Actividad sustantivas relevantes</th>
            <th colspan="4" class="text-center">Metas de actividad</th>
            <th colspan="2" class="text-center">Variación</th>
        </tr>
        <tr class="t-tr-s14 c-text-alt">
            <th rowspan="2" class="bg-gray text-center">Unidad de Medida</th>
            <th colspan="2" class="bg-gray text-center">{{ $row['header']['anio'] - 1 }}</th>
            <th rowspan="2" class="bg-gray text-center">
                <div>{{ $row['header']['anio'] }}</div>
                <div>Programado</div>
            </th>
            <th rowspan="2" class="text-center">Absoluta</th>
            <th rowspan="2" class="text-center">%</th>
        </tr>
        <tr class="t-tr-s14 c-text-alt">
            <th class="bg-gray text-center">Programado</th>
            <th class="bg-gray text-center">Alcanzado</th>
        </tr>
        @foreach ($row['rowsRegistros'] as $p)
            <tr class="bg-white t-tr-s14 c-text-alt">
                <td class="text-center">{{ $p->codigo }}</td>
                <td>{{ $p->meta }}</td>
                <td>{{ $p->unidad_medida }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->programado) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->alcanzado) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->anual) }}</td>
                <td class="text-center">{{ SiteHelpers::getMassDecimales($p->absoluta) }}</td>
                <td class="text-center">{{ $p->porcentaje }}</td>
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
            </tr>
            @endfor
        @endif
    </table>
</div>

<br>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text">
                <td>Gasto estimado total:</td>
                <td class="c-black">$ {{ SiteHelpers::getMassDecimales($row['presupuesto']) }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <div class="font-bold"></div>
                <br>
                <br>
                <br>
                <input type="text" name="txt_titular_dep" value="{{ $row['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="TITULAR DE LA DEPENDENCIA" required>
                <input type="text" name="txt_titular_dep_cargo" value="{{ $row['header']['c_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">Vo.Bo.</div>
                <div class="font-bold c-text-alt">TESORERO MUNICIPAL</div>
                <br>
                <br>
                <input type="text" name="txt_tesorero" value="{{ $row['header']['row']['t_tesoreria'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="TESORERO MUNICIPAL" required>
                <input type="text" name="txt_tesorero_cargo" value="{{ $row['header']['row']['c_tesoreria'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">AUTORIZÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                <br>
                <br>
                <input type="text" name="txt_titular_uippe" value="{{ $row['header']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>
                <input type="text" name="txt_titular_uippe_cargo" value="{{ $row['header']['row']['c_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
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
                    $.ajax("{{ URL::to('presupuestopbrma/generarpdfpbrmc?k='.$token) }}", {
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
                                pbrmc.rowsProjects();
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

</script>