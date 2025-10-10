<form id="formJustificacion" method="post" class="form-horizontal">
    <section class="table-resp">

        <input type="hidden" name="json" value="{{ json_encode($json) }}">

        <table width="100%" cellspacing="0">
            <tr>
                <td width="20%" style="text-align:center;border-right:1px solid #6e6e6e;">
                    @if(!empty($json['header']['row']['logo_izq'] ))
                        <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
                    @endif
                </td>
                <td>
                    <div class="s-16 c-text-alt text-center">&nbsp;&nbsp;&nbsp;&nbsp;{{ $json['header']['row']['leyenda'] }}</div>
                </td>
                <td width="20%" style="text-align:center;">
                    @if(!empty($json['header']['row']['logo_der'] ))
                        <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
                    @endif
                </td>
            </tr>
        </table>

        <h2 class="text-center">MUNICIPIO DE <span class="text-uppercase">{{ $json['header']['municipio'] }}</span></h2>
        <h2 class="text-center">TARJETA DE JUSTIFICACIÓN DE RECONDUCCIÓN</h2>

        <br>

        <div class="col-md-12 no-padding">
            <div class="col-md-4"></div>
            <div class="col-md-8 no-padding">
                <table class="table border-gray">
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Fecha:</td>
                        <td width="60%" class="bg-white no-borders">
                            <input type="text" name="fecha" class="border-b-1-dashed form-control" placeholder="Fecha" value="{{ $json['fecha'] }}" required> 
                        </td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Número de folio de reconducción:</td>
                        <td class="bg-white no-borders">
                            <input type="text" value="{{ $json['header']['folio'] }}" name="folio_reconduccion" class="border-b-1-dashed form-control" placeholder="No. de Folio" required> 
                        </td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Programa presupuestario:</td>
                        <td class="bg-white no-borders">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Proyecto:</td>
                        <td class="bg-white no-borders">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Area:</td>
                        <th class="bg-white no-borders">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</th>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Tipo de Reconducción:</td>
                        <th class="bg-white no-borders">Movimiento de adecuación programática</th>
                    </tr>
                    <tr class="t-tr-s14">
                        <td class="text-right bg-gray">Folio:</td>
                        <td class="bg-white no-borders">
                            <input type="text" name="folio" value="{{ $json['proyecto']['folio'] }}" class="border-b-1-dashed form-control" placeholder="Folio" required> 
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br>

        <p class="s-8">Por este conducto me permito enviar las justificaciones, referentes a la reconducción realizada:</p>

        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th colspan="2"><div class="p-xs">JUSTIFICACIÓN:</div></th>
            </tr>
            
            <tr>
                <td colspan="2">
                    <div class="p-m">
                        <table cellspacing="0" class="table table-bordered">
                            <tr class="t-tr-s14">
                                <th class="bg-body" width="50%"><div class="p-xs">Meta de Actividad Sustantiva</div></th>
                                <th class="bg-body" width="50%"><div class="p-xs">Justificación</div></th>
                            </tr>
                            @foreach ($json['metas'] as $v)
                                <tr class="t-tr-s14">
                                    <td>{{ $v['ico'] }} {{ $v['ime'] }}</td>
                                    <td>{{ $v['iob'] }}</td>
                                </tr>
                            @endforeach
                            </table>
                    </div>
                </td>
            </tr>
            <tr class="t-tr-s14">
                <th colspan="2"><div class="p-xs">OBSERVACIONES:</div></th>
            </tr>
            <tr class="t-tr-s14">
                <td colspan="2">
                    <div class="p-xs">
                        El detalle de las metas inicial y modificada se adjunta en el formato DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL {{ $json['year'] }}, adjunto a esta tarjeta.
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center border bg-white">
                            <div><strong>ATENTAMENTE</strong></div>
                            <br>
                            <br>
                            <br>
                            <input type="text" name="t_dep_gen" value="{{ $json['header']['t_dep_gen'] }}" class="border-b-1-dashed form-control text-center fun" placeholder="Ingresa Nombre de Director" required>
                            <br>
                            <input type="text" name="c_dep_gen" value="{{ $json['header']['c_dep_gen'] }}" class="border-b-1-dashed form-control text-center fun" placeholder="Ingresa Dirección o Área" required>
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4"></div>
        </div>
    

        <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>
        </article>

    </section>
</form>
<script>
    $(".btnexportar").click(function(e){
        e.preventDefault();

        swal({
            title : 'PDF Justificación',
            text: 'Estás seguro de generar el PDF de justificación?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formJustificacion"));
                $.ajax("{{ URL::to('reporte/pdfjustificacion?k='.$token) }}", {
                    type: 'post',
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".btnexportar").prop("disabled",true).html(mss_spinner + '...Generado PDF...');
                    },success: function(res){
                        let row = JSON.parse(res);
                        if(row.status == 'ok'){
                            toastr.success(row.message);
                            $("#sximo-modal").modal("toggle");
                            pbrmc.rowsProjects();
                            window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                        }else{
                            toastr.error(row.message);
                        }
                        $(".btnexportar").prop("disabled",false).html('<i class="fa icon-file-pdf"></i> Convertir a PDF');
                    }, error : function(err){
                        toastr.error(mss_tmp.error);
                        $(".btnexportar").prop("disabled",false).html('<i class="fa icon-file-pdf"></i> Convertir a PDF');
                    }
                });
                        
            }
        })
    })
</script>








