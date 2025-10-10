
<form id="formReconduccion" method="post" class="form-horizontal">
    <input type="hidden" name="json" value="{{ json_encode($json) }}">

<table width="100%" cellspacing="0">
    <tr>
        <td width="20%" style="text-align:center;border-right:1px solid #6e6e6e;">
            @if(!empty($json['header']['row']['logo_izq'] ))
                <img src="{{ asset($json['header']['row']['logo_izq'] ) }}" width="110" height="60">
            @endif
        </td>
        <td>
            <div class="s-12 c-text-alt text-center">&nbsp;&nbsp;&nbsp;&nbsp;{{ $json['header']['row']['leyenda'] }}</div>
        </td>
        <td width="20%">
            @if(!empty($json['header']['row']['logo_der'] ))
                <img src="{{ asset($json['header']['row']['logo_der'] ) }}" width="70" height="60">
            @endif
        </td>
    </tr>
</table>


<br>

<table class="table bg-white">
    <tr class="t-tr-s12">
        <th width="20%" class="border-t c-text-alt">PROGRAMA PRESUPUESTARIO:</th>
        <td width="70%" class="border-t">{{ $json['header']['no_programa'] }} {{ $json['header']['programa'] }}</td>
    </tr>
    <tr class="t-tr-s12">
        <th width="20%" class="border-t c-text-alt">OBJETIVO DEL PROGRAMA PRESUPUESTARIO:</th>
        <td width="70%" class="border-t">{{ $json['header']['obj_programa'] }}</td>
    </tr>
    <tr class="t-tr-s12">
        <th width="20%" class="border-t c-text-alt">DEPENDENCIA GENERAL:</th>
        <td width="70%" class="border-t">{{ $json['header']['no_dep_gen'] }} {{ $json['header']['dep_gen'] }}</td>
    </tr>
    <tr class="t-tr-s12">
        <th width="20%" class="border-t c-text-alt">TEMA DE DESARROLLO:</th>
        <td width="70%" class="border-t">
            <textarea name="tema" class="form-control" placeholder="Tema de desarrollo" rows="1">{{ $json['header']['tema'] }}</textarea>
        </td>
    </tr>
</table>

<h3 class="text-center c-text-alt s-12">DIAGNÓSTICO DEL PROGRAMA PRESUPUESTARIO USANDO ANÁLISIS FODA</h3>
<br>

<table id="table" width="100%" class="table table-bordered bg-white">
    <tr>
        <th class="text-center bg-title">FORTALEZAS</th>
        <th class="text-center bg-title">OPORTUNIDADES</th>
        <th class="text-center bg-title">DEBILIDADES</th>
        <th class="text-center bg-title">AMENAZAS</th>
    </tr>
    <tr>
        <td>
            <div style="min-height:200px">
                @if(isset($json['rowsReg'][1]))
                    @foreach ($json['rowsReg'][1] as $t)
                    <div>
                        <ul>
                            <li class="s-16">{{ $t['foda'] }}</li>
                        </ul>
                    </div>
                    @endforeach
                @endif
            </div>
        </td>
        <td>
            @if(isset($json['rowsReg'][2]))
                @foreach ($json['rowsReg'][2] as $t)
                <div>
                    <ul>
                        <li class="s-16">{{ $t['foda'] }}</li>
                    </ul>
                </div>
                @endforeach
            @endif
        </td>
        <td>
            @if(isset($json['rowsReg'][3]))
                @foreach ($json['rowsReg'][3] as $t)
                <div>
                    <ul>
                        <li class="s-16">{{ $t['foda'] }}</li>
                    </ul>
                </div>
                @endforeach
            @endif
        </td>
        <td>
            @if(isset($json['rowsReg'][4]))
                @foreach ($json['rowsReg'][4] as $t)
                <div>
                    <ul>
                        <li class="s-16">{{ $t['foda'] }}</li>
                    </ul>
                </div>
                @endforeach
            @endif
        </td>
    </tr>
</table>

<br>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <th width="10%" class="text-center"></th>
        <td width="30%" class="text-center border bg-white">
            <div class="font-bold c-text-alt">Titular de la Dependencia General</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div>
                <input type="text" name="footer1" value="{{ $json['header']['t_dep_gen'] }}" class="border-b-1-dashed form-control text-center c-blue" placeholder="Ingresa Nombre" required>
            </div>
            <div class="col-md-12 c-text-alt">Nombre y Firma</div>
        </td>
        <th width="10%" class="text-center"></th>
        <td width="30%" class="text-center border bg-white">
            <div class="font-bold c-text-alt">Titular de la UIPPE o su Equivalente</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div>
                <input type="text" name="footer2" value="{{ $json['header']['row']['t_uippe'] }}" class="border-b-1-dashed form-control text-center c-blue" placeholder="Ingresa Nombre" required>
            </div>
            <div class="col-md-12 c-text-alt">Nombre y Firma</div>
        </td>
        <th width="10%" class="text-center"></th>
    </tr>
</table>

<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="button" class="btn btn-sm btn-danger btnexportar"> <i class="fa icon-file-pdf"></i> Convertir a PDF</button>
</article>

</form>

<script>
    $(".btnexportar").click(function(e){
        e.preventDefault();

        swal({
            title : 'PDF FODA',
            text: 'Estás seguro de generar el PDF del FODA?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
        }).then((willOk) => {
            if(willOk){

                var formData = new FormData(document.getElementById("formReconduccion"));
                $.ajax("{{ URL::to('indicadores/pdffoda?k='.$token) }}", {
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