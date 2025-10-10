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
    <div class="col-md-10 no-padding"></div>
    <div class="col-md-2 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-right">Ejercicio Fiscal</td>
                <th width="50%">{{ $data['anio'] }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">PbRM-01a</td>
                <th colspan="3" class="text-center">
                    <div>Programa Anual</div>
                    <div>Dimensión Administrativa del Gasto</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
               <th width="15%"></th>
               <th class="text-center" width="100">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
    <table class="table">
        <tr class="no-borders t-tr-s12 c-text-alt">
            <th  class="text-center bg-white" rowspan="2">Código Dependencia Auxiliar</th>
            <th  class="text-center bg-white" rowspan="2">Denominación Dependencia Auxiliar</th>
            <th width="10" class="no-borders"></th>
            <th  class="text-center bg-white" colspan="2">Proyectos Ejecutados</th>
            <th width="10" class="no-borders"></th>
            <th  class="text-center bg-white" rowspan="2">Presupuesto autorizado por Proyecto</th>
        </tr>
        <tr class="no-borders t-tr-s12 c-text-alt">
            <th width="10" class="no-borders"></th>
            <th class="text-center bg-white">Clave del Proyecto</th>
            <th class="text-center bg-white">Denominación del Proyecto</th>
            <th class="text-center no-borders" width="10"></th>
        </tr>
        @foreach ($data['data'] as $p)
            <tr class="t-tr-s12 c-text">
                <td class="bg-white text-center">{{ $p['no_dep_aux'] }}</td>
                <td class="bg-white text-center">{{ $p['dep_aux'] }}</td>
                <td class="no-borders"></td>
                <td class="bg-white text-center">{{ $p['no_proyecto'] }}</td>
                <td class="bg-white text-center">{{ $p['proyecto'] }}</td>
                <td class="no-borders"></td>
                <td class="bg-white text-center">{{ $p['presupuesto'] }}</td>
            </tr>
        @endforeach
        @for ($i = 0; $i < 10; $i++)
            <tr class="t-tr-s12">
                <td class="bg-white text-center c-white no-borders">.</td>
                <td class="bg-white text-center c-white no-borders">.</td>
                <td class="no-borders"></td>
                <td class="bg-white text-center c-white no-borders">.</td>
                <td class="bg-white text-center c-white no-borders">.</td>
                <td class="no-borders"></td>
                <td class="bg-white text-center c-white no-borders">.</td>
            </tr>
        @endfor
    </table>
</div>

<br>

<div class="col-md-12">
    <div class="col-md-9 no-padding"></div>
    <div class="col-md-3 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text">
                <td class="text-right">Presupuesto Total:</td>
                <th class="c-black" width="60%">$ {{ $data['total'] }}</th>
            </tr>
        </table>
    </div>
</div>

<br>
    <div class="col-md-12">
        <table class="table">
            <tr class="t-tr-s12 c-text">
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">REVISÓ</div>
                    <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                    <br>
                    <input type="text" name="titular1" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                    <input type="text" name="cargo1" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                    <div class="col-md-4 c-text-alt">Nombre</div>
                    <div class="col-md-4 c-text-alt">Firma</div>
                    <div class="col-md-4 c-text-alt">Cargo</div>
                </td>
                <th class="no-borders"></th>
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">Vo.Bo.</div>
                    <div class="font-bold c-text-alt">TESORERO MUNICIPAL</div>
                    <br>
                    <input type="text" name="titular2" value="{{$data['footer']['firmas']['t_tesoreria']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                    <input type="text" name="cargo2" value="{{$data['footer']['firmas']['c_tesoreria']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
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

    <br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
    </article>
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

                    $.ajax("{{ URL::to('anteproyecto/pdfpbrma?id='.$id) }}", {
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
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.data.number, '_blank');
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