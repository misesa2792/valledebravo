<form id="formDictamen" method="post" class="form-horizontal">
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
        
        <table id="table" width="100%" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <table id="table" width="100%" cellspacing="0">
                        <tr>
                            <td>.</td>
                        </tr>
                        <tr>
                            <th class="s-16 c-text-alt">FECHA:</th>
                            <td class="s-16 c-text">
                                <input type="text" name="fecha" class="border-b-1-dashed form-control c-blue" placeholder="Fecha" value="{{ $json['fecha'] }}" required> 
                            </td>
                        </tr>
                        <tr>
                            <td>.</td>
                        </tr>
                        <tr>
                            <th class="s-16 c-text-alt">OFICIO:</th>
                            <td>
                                <input type="text" name="oficio" class="border-b-1-dashed form-control c-blue" placeholder="No. de Oficio" required> 
                            </td>
                        </tr>
                        <tr>
                            <td>.</td>
                        </tr>
                        <tr>
                            <th class="s-16 c-text-alt">ASUNTO:</th>
                            <td>
                                <input type="text" name="asunto" value=" {{ $json['type'] == 0 ? 'Dictamen de reconduccion y actualización programática' : 'Dictamen de reconduccion de indicadores' }}" class="border-b-1-dashed form-control c-blue" placeholder="Asunto" required> 
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
        
            <br>
            <div class="col-md-12 no-padding">
                <div class="col-md-6 no-padding">
                    <input type="text" name="t_uippe" class="border-b-1-dashed  form-control c-blue" value="{{ $json['header']['row']['t_uippe'] }}" placeholder="Titular UIPPE" required>
                </div>
            </div>
            <br>
            <br>
            <h3>TITULAR DE LA UNIDAD DE INFORMACIÓN, PLANEACIÓN, PROGRAMACIÓN Y EVALUACIÓN.</h3>
            <br>
            <br>
            <h3>P R E S E N T E</h3>
        
            <br>
            
            <p class="s-16">Por este conducto me permito enviar a usted un cordial saludo; así mismo solicito se realicen las adecuaciones programáticas que se encuentran en el formato "Dictamen de Reconducción y Actualización Programática – Presupuestal {{ $json['year'] }}", que adjunto al presente y que corresponden al proyecto presupuestario con los datos siguientes:</p>
        
            <br>
        
        <table class="table table-bordered bg-white">
        <tr class="t-tr-s16">
                <th>No.</th>
                <th>No. de Folio</th>
                <th>Clave Programática</th>
                <th>Programa</th>
                <th>Proyecto</th>
        </tr>
            @foreach ($json['projects'] as $p)
                <tr class="t-tr-s16">
                    <td class="text-center">{{ $p['no'] }}</td>
                    <td class="text-center"> {{ $p['folio'] }}</td>
                    <td>{{ $p['no_proyecto'] }}</td>
                    <td>{{ $p['no_programa'] }} {{ $p['programa'] }}</td>
                    <td>{{ $p['proyecto'] }}</td>
                </tr> 
            @endforeach
        </table>    
        <br>
        <br>
        <p class="s-16">Esperando su valioso apoyo, aprovecho la ocasión para reiterar mis más altas consideraciones.</p>
        <br>
        <br>
        
        <table id="table" width="100%">
            <tr>
                <td width="30%" class="text-center"></td>
                <td width="30%" class="text-center bg-white p-xs">
                    <div><strong>A T E N T A M E N T E</strong></div>
                    <div class="c-white">.</div>
                    <div class="c-white">.</div>
                    <div class="c-white">.</div>
                    <div>
                        <input type="text" name="t_dep_gen" value="{{ $json['header']['t_dep_gen'] }}" class="border-b-1-dashed form-control text-center c-blue" placeholder="Ingresa Nombre de Director" required>
                    </div>
                    <br>
                    <div>
                        <input type="text" name="c_dep_gen" value="{{ $json['header']['c_dep_gen'] }}" class="border-b-1-dashed form-control text-center c-blue" placeholder="Ingresa Dirección o Área" required>
                    </div>
                </td>
                <td width="30%" class="text-center"></td>
            </tr>
        </table>
        
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
            title : 'PDF Dictamen',
            text: 'Estás seguro de generar el PDF Dictamen?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formDictamen"));
                $.ajax("{{ URL::to('reporte/pdfdictamen?k='.$token) }}", {
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
    
    
    
    
    
    
    
    
    