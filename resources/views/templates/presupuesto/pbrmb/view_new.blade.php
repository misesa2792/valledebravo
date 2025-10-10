<form id="saveInfo" method="post" class="form-horizontal">

@include("templates.presupuesto.header.view", array("ses_logo_izq"=> $json['header']['logo_izq'], "ses_anio"=> $json['header']['anio']))
    <input type="hidden" name="json" value="{{ json_encode($json) }}">

<article class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $json['header']['anio'] }}</th>
            </tr>
        </table>
    </div>
</article>

<article class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s16 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{  $json['header']['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $json['header']['no_institucion'] }}</th>
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
                <td>{{ $json['header']['no_programa'] }}</td>
                <td>{{ $json['header']['programa'] }}</td>
            </tr>
            <tr class="t-tr-s16 c-text-alt">
                <th>Dependencia General:</th>
                <td>{{ $json['header']['no_dep_gen'] }}</td>
                <td>{{ $json['header']['dep_gen'] }}</td>
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
                    @if(isset($json['rowsRegistros'][1]))
                        @foreach ($json['rowsRegistros'][1] as $f)
                            <div>
                                <ul>
                                    <li class="s-16">
                                    {{ $f }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div>OPORTUNIDADES</div>
                <div>
                    @if(isset($json['rowsRegistros'][2]))
                        @foreach ($json['rowsRegistros'][2] as $f)
                            <div>
                                <ul>
                                    <li class="s-16">
                                    {{ $f }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div>DEBILIDADES</div>
                <div>
                    @if(isset($json['rowsRegistros'][3]))
                        @foreach ($json['rowsRegistros'][3] as $f)
                            <div>
                                <ul>
                                    <li class="s-16">
                                    {{ $f }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div>AMENAZAS</div>
                <div>
                    @if(isset($json['rowsRegistros'][4]))
                        @foreach ($json['rowsRegistros'][4] as $f)
                            <div>
                                <ul>
                                    <li class="s-16">
                                    {{ $f }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
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
             <td>{{ $json['body']['op'] }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Estrategias para alcanzar el objetivo del Programa presupuestario</th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $json['body']['eo'] }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Objetivo, Estrategias y Líneas de Acción del PDM atendidas </th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $json['body']['pdm'] }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-md">
    <table class="table table-bordered bg-white">
         <tr class="t-tr-s16">
             <th class="c-text-alt">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario </th>
         </tr>
         <tr class="t-tr-s16">
             <td>{{ $json['body']['ods'] }}</td>
         </tr>
     </table> 
 </div>

<br>


<br>

<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">ELABORÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA</div>
                <br>
                <input type="text" name="footer1" value="{{ $json['footer']['titular_dep_gen'] }}" class="form-control border-b-1-dashed text-center c-black" placeholder="TITULAR DE LA DEPENDENCIA" onkeyup="MassMayusculas(this);" required>
                <input type="text" name="cargo1" class="form-control border-b-1-dashed text-center c-black" placeholder="INGRESA CARGO"  onkeyup="MassMayusculas(this);">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">REVISÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                <br>
                <input type="text" name="footer2" value="{{ $json['footer']['titular_tesoreria'] }}" class="form-control border-b-1-dashed text-center c-black" placeholder="TESORERO MUNICIPAL" onkeyup="MassMayusculas(this);" required>
                <input type="text" name="cargo2" class="form-control border-b-1-dashed text-center c-black" placeholder="INGRESA CARGO" onkeyup="MassMayusculas(this);">
                <div class="col-md-4 c-text-alt">Nombre</div>
                <div class="col-md-4 c-text-alt">Firma</div>
                <div class="col-md-4 c-text-alt">Cargo</div>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">AUTORIZÓ</div>
                <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                <br>
                <input type="text" name="footer3" value="{{ $json['footer']['titular_uippe'] }}" class="form-control border-b-1-dashed text-center c-black" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" onkeyup="MassMayusculas(this);" required>
                <input type="text" name="cargo3" class="form-control border-b-1-dashed text-center c-black" placeholder="INGRESA CARGO" onkeyup="MassMayusculas(this);">
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


<style>
    ul, ol{
        margin-bottom: 0px;
    }
</style>

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
                                pbrmb.rowsProjects();
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