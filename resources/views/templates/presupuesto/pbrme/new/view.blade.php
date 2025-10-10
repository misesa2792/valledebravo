<form id="saveInfo" method="post" class="form-horizontal">
    <input type="hidden" name="json" value="{{ json_encode($json) }}">
<table class="table">
    <tr>
        <td class="no-borders" width="10%" rowspan="3">
            @if(!empty($json['header']['row']['logo_izq'] ))
                <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
            @endif
        </td>
        <td class="no-borders text-center font-bold s-16 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
        <td class="no-borders" width="10%" rowspan="3">
            @if(!empty($json['header']['row']['logo_der'] ))
                <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
            @endif
        </td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $json['header']['year'] }}</td>
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
                <th>{{ $json['header']['year'] }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $json['header']['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $json['header']['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
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
            <tr class="t-tr-s14 c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Programa presupuestario: </th>
                <td>{{ $json['header']['no_programa'] }}</td>
                <td>{{ $json['header']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Obletivo del Programa Presupuestario:</th>
                <td></td>
                <td>{{ $json['header']['obj_programa'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $json['header']['no_dep_gen'] }}</td>
                <td>{{ $json['header']['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Pilar o Eje transversal:</th>
                <td></td>
                <td>{{ $json['header']['pilar'] }}</td>
            </tr>
            <tr class="t-tr-s14 c-text-alt">
                <th>Tema de Desarrollo:</th>
                <td></td>
                <td>{{ $json['header']['tema'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<table class="table table-bordered bg-white">
    <tr class="t-tr-s14">
        <th rowspan="2" width="35%">Objetivo o resumen narrativo</th>
        <th colspan="3" class="text-center">Indicadores</th>
        <th rowspan="2"  class="text-center">Medios de verificación</th>
        <th rowspan="2"  class="text-center">Supuestos</th>
    </tr>
    <tr class="t-tr-s14">
        <th class="text-center">Nombre</th>
        <th class="text-center">Fórmula</th>
        <th class="text-center">Frecuencia y Tipo</th>
    </tr>
    <tr class="t-tr-s16">
        <th colspan="6">Fin</th>
    </tr>
    @if(isset($json['rowsRegistros'][1]))
        @foreach($json['rowsRegistros'][1] as $r)
            <tr class="t-tr-s14">
                <td>{{ $r['descripcion'] }}</td>
                <td>{{ $r['nombre'] }}</td>
                <td>{{ $r['formula'] }}</td>
                <td class="text-center">
                    <div>{{ $r['frecuencia'] }}</div>
                    <div>{{ $r['tipo_indicador'] }}</div>
                </td>
                <td>{{ $r['medios'] }}</td>
                <td>{{ $r['supuestos'] }}</td>
            </tr>
        @endforeach
    @endif

    <tr class="t-tr-s14">
        <th colspan="6">Propósito</th>
    </tr>
    @if(isset($json['rowsRegistros'][2]))
        @foreach($json['rowsRegistros'][2] as $r)
            <tr class="t-tr-s14">
                <td>{{ $r['descripcion'] }}</td>
                <td>{{ $r['nombre'] }}</td>
                <td>{{ $r['formula'] }}</td>
                <td class="text-center">
                    <div>{{ $r['frecuencia'] }}</div>
                    <div>{{ $r['tipo_indicador'] }}</div>
                </td>
                <td>{{ $r['medios'] }}</td>
                <td>{{ $r['supuestos'] }}</td>
            </tr>
        @endforeach
    @endif

    <tr class="t-tr-s14">
        <th colspan="6">Componentes</th>
    </tr>
    @if(isset($json['rowsRegistros'][3]))
        @foreach($json['rowsRegistros'][3] as $r)
            <tr class="t-tr-s14">
                <td>{{ $r['descripcion'] }}</td>
                <td>{{ $r['nombre'] }}</td>
                <td>{{ $r['formula'] }}</td>
                <td class="text-center">
                    <div>{{ $r['frecuencia'] }}</div>
                    <div>{{ $r['tipo_indicador'] }}</div>
                </td>
                <td>{{ $r['medios'] }}</td>
                <td>{{ $r['supuestos'] }}</td>
            </tr>
        @endforeach
    @endif

    <tr class="t-tr-s14">
        <th colspan="6">Actividades</th>
    </tr>
    @if(isset($json['rowsRegistros'][4]))
        @foreach($json['rowsRegistros'][4] as $r)
            <tr class="t-tr-s14">
                <td>{{ $r['descripcion'] }}</td>
                <td>{{ $r['nombre'] }}</td>
                <td>{{ $r['formula'] }}</td>
                <td class="text-center">
                    <div>{{ $r['frecuencia'] }}</div>
                    <div>{{ $r['tipo_indicador'] }}</div>
                </td>
                <td>{{ $r['medios'] }}</td>
                <td>{{ $r['supuestos'] }}</td>
            </tr>
        @endforeach
    @endif
</table>

<br>


<br>
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">ELABORÓ</div>
                <div class="font-bold">TITULAR DE LA DEPENDENCIA</div>
                <br>
                <input type="text" name="footer1" value="{{ $json['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="TITULAR DE LA DEPENDENCIA" required>
                <input type="text" name="cargo1" value="{{ $json['header']['c_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">REVISÓ</div>
                <div class="font-bold">TITULAR DE LA DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" name="footer2" value="{{ $json['header']['t_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="TESORERO MUNICIPAL" required>
                <input type="text" name="cargo2" value="{{ $json['header']['c_dep_gen'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO">
                <div class="col-md-4">Nombre</div>
                <div class="col-md-4">Firma</div>
                <div class="col-md-4">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders c-text-alt">
                <div class="font-bold">AUTORIZÓ</div>
                <div class="font-bold">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                <br>
                <input type="text" name="footer3" value="{{ $json['header']['row']['t_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>
                <input type="text" name="cargo3" value="{{ $json['header']['row']['c_uippe'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center c-blue border-b-1-dashed" placeholder="INGRESA CARGO">
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
                    $.ajax("{{ URL::to($pageModule.'/generarpdf?k='.$token) }}", {
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
                                toastr.success(row.message);
                                pbrme.rowsProjects();
                	            $('#sximo-modal').modal("toggle");
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                            }else{
                                toastr.warning(row.message);
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
