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
            <td class="no-borders text-center font-bold s-14 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['year'] }}</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>


<br>

@if($view == 'pdf')
    <div class="col-md-12">
        <div class="col-md-8 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td>Fecha</td>
                    <th>
                        <input type="text" name="fecha" value="{{ date('Y-m-d') }}" class="form-control date" placeholder="0000-00-00" required>
                    </th>
                </tr>
            </table>
        </div>
    </div>
@endif


<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">PbRM-02a</td>
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
            <tr class="t-tr-s12 c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Proyecto: </th>
                <td class="text-center">{{ $data['no_proyecto'] }}</td>
                <td>{{ $data['proyecto'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia Auxiliar:</th>
                <td class="text-center">{{ $data['no_dep_aux'] }}</td>
                <td>{{ $data['dep_aux'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
    <table class="table table-bordered no-margins bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th rowspan="3" width="40" class="text-center">Código</th>
            <th rowspan="3" width="20%" class="text-center">Descripción de las Metas de Actividad </th>
            <th rowspan="3" class="text-center">Unidad de Medida </th>
            <th rowspan="3" class="text-center">Cantidad Programada Anual</th>
            <th colspan="8" class="text-center">Calendarización de Metas Físicas</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th colspan="2" class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th colspan="2" class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th colspan="2" class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th colspan="2" class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
            <th class="bg-gray text-center">Abs.</th>
            <th class="bg-gray text-center">%</th>
        </tr>
        <tbody id="_tbody" class="no-borders">
            @foreach ($data['rowsMetas'] as $r)
            <tr class="bg-white t-tr-s12">
                <td class="c-text-alt text-center">{{ $r->codigo }}</td>
                <td class="c-text-alt">{{ $r->meta }}</td>
                <td class="c-text-alt text-center">{{ $r->unidad_medida }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_anual }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_trim1 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_porc1 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_trim2 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_porc2 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_trim3 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_porc3 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_trim4 }}</td>
                <td class="c-text-alt text-center">{{ $r->aa_porc4 }}</td>
            </tr>
            @endforeach
            @if(count($data['rowsMetas']) <= 10)
                @for ($i = 0; $i < 5 ; $i++)
                    <tr>
                        <td class="c-white">.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
</div>

    @if($view == 'pdf')
    <div class="col-md-12 m-t-md">
        <table class="table">
            <tr class="t-tr-s12 c-text">
                <td width="30%" class="text-center bg-white no-borders">
                    <div class="font-bold c-text-alt">ELABORÓ</div>
                    <div class="font-bold c-text-alt"></div>
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
                    <input type="text" name="cargo2" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
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
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
    </article>
    @endif
</form>
<script>
    $('.date').datepicker({format: 'yyyy-mm-dd'});
    
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
                    $.ajax("{{ URL::to('anteproyecto/pdfpbrmaa?id='.$id) }}", {
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