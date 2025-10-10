<form id="saveInfo" method="post" class="form-horizontal">
    <table class="table">
        <tr>
            <td class="no-borders" width="10%" rowspan="3">
                @if(!empty($data['footer']['firmas']['logo_izq'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="no-borders text-center font-bold s-14 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td class="no-borders" width="10%" rowspan="3">
                @if(!empty($data['footer']['firmas']['logo_der'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['anio'] }}</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>


<br>

<div class="col-md-12">
    <div class="col-md-9 no-padding"></div>
    <div class="col-md-3 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th class="text-center">{{ $data['anio'] }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="c-text-alt">
                <td class="text-center">PbRM-01b</td>
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
            <tr class="c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>
<div class="col-md-12 m-b-xs">
    <table class="table table-bordered bg-white">
         <tr>
             <th class="c-text-alt">Diagnóstico de Programa presupuestario elaborado usando análisis FODA </th>
         </tr>
         <tr>
             <td>
                 <div>FORTALEZAS</div>
                        <ul>
                    @foreach ($data['fortalezas'] as $fk => $f)
                            <li class="s-10 p-l-10">{{ $f }}</li>
                    @endforeach
                        </ul>
                 <div>OPORTUNIDADES</div>
                        <ul>
                    @foreach ($data['oportunidades'] as $fo => $o)
                            <li class="s-10 p-l-10">{{ $o }}</li>
                    @endforeach
                        </ul>
                 <div>DEBILIDADES</div>
                        <ul>
                    @foreach ($data['debilidades'] as $fd => $d)
                            <li class="s-10 p-l-10">{{ $d }}</li>
                    @endforeach
                        </ul>
                 <div>AMENAZAS</div>
                        <ul>
                    @foreach ($data['amenazas'] as $fa => $a)
                            <li class="s-10 p-l-10">{{ $a }}</li>
                    @endforeach
                        </ul>
             </td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-xs">
    <table class="table table-bordered bg-white">
         <tr>
             <th class="c-text-alt">Objetivo del Programa presupuestario </th>
         </tr>
         <tr>
             <td class="s-10">{{ $data['obj_programa'] }}</td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-xs">
    <table class="table table-bordered bg-white">
         <tr>
             <th class="c-text-alt">Estrategias para alcanzar el objetivo del Programa presupuestario</th>
         </tr>
         <tr>
             <td>
                <div>
                    @foreach ($data['estrategias'] as $f)
                        <ul><li class="s-10">{{ $f }}</li></ul>
                    @endforeach
                 </div>
             </td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-xs">
    <table class="table table-bordered bg-white">
         <tr>
             <th class="c-text-alt">Objetivo, Estrategias y Líneas de Acción del PDM atendidas </th>
         </tr>
         <tr>
             <td>
                @foreach ($data['lineas_accion'] as $k1 => $l1)
                    <ul>
                        <li class="s-10">{{ $k1.' '.$l1['objetivo'] }}</li>
                        @foreach ($l1['estrategias'] as $k2 => $l2)
                            <ul>
                                <li class="s-10">{{ $k2.' '.$l2['estrategia'] }}</li>
                                @foreach ($l2['lineas_accion'] as $l3)
                                    <ul>
                                        <li class="s-10">{{ $l3['no_linea_accion'].' '.$l3['linea_accion'] }}</li>
                                    </ul>
                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                @endforeach
             </td>
         </tr>
     </table> 
 </div>

 <div class="col-md-12 m-b-xs">
    <table class="table table-bordered bg-white">
         <tr>
             <th class="c-text-alt">Objetivos y metas para el Desarrollo Sostenible (ODS) atendidas por el Programa presupuestario </th>
         </tr>
         <tr>
             <td>
                @foreach ($data['ods'] as $l1)
                    <ul>
                        <li class="s-10">{{ $l1['ods'] }}</li>
                        @foreach ($l1['metas'] as $l2)
                            <ul>
                                <li class="s-10">{{ $l2 }}</li>
                            </ul>
                        @endforeach
                    </ul>
                @endforeach
             </td>
         </tr>
     </table> 
 </div>

    @if($view == 'pdf')
        <div class="col-md-12">
            <table class="table">
                <tr class="c-text">
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">ELABORÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA</div>
                        <br>
                        <input type="text" name="titular1" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo1" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
                    <th class="no-borders"></th>
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">REVISÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                        <br>
                        <input type="text" name="titular2" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo2" value="{{ $data['footer']['dg']['cargo'] }}" value="TESORERO MUNICIPAL" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
                    <th class="no-borders"></th>
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">AUTORIZÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                        <br>
                        <input type="text" name="titular3" value="{{$data['footer']['firmas']['t_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo3" value="{{$data['footer']['firmas']['c_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
            </tr>
            </table>
        </div>

        <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
        </article>
    @endif

</form>
<script>
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
            title : 'Estás seguro de generar el PDF?',
            icon : 'warning',
            buttons: {
            cancel: {
            text: "No, Cancelar",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true,
            },
            confirm: {
            text: "Sí, generar PDF",
            value: true,
            visible: true,
            className: "btn btn-danger",
            closeModal: true
            }
        },
        dangerMode : true,
		closeOnClickOutside: false
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    formData.append('type', "{{ $type }}");

                    $.ajax("{{ URL::to('anteproyecto/pdfpbrmb?id='.$id) }}", {
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
                                vm.$refs.componenteActivo?.rowsProjects();
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