<form enctype="multipart/form-data" id="searchgnal" method="post">
    <input type="hidden" name="idy" value="{{ $idy }}">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">

    <table class="table no-margins b-gray bg-white">
        <tbody>
            <tr>
                    <td class="no-borders">
                        <div class="s-14 c-text-alt">Número Proyecto</div>
                        <input type="text" name="no_proyecto" class="form-control" placeholder="Ingresa número">
                    </td>
                    <td class="no-borders">
                        <div class="s-14 c-text-alt">Proyecto</div>
                            <select name="idproyecto" class="mySelect">
                            <option value="0"> --Selecciona proyecto-- </option>
                            @foreach($rowsProyectos as $pr)
                            <option value="{{ $pr->idproyecto }}">{{ $pr->no_proyecto.' '.$pr->proyecto }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="no-borders">
                        <div class="s-14 c-text-alt">Meta</div>
                        <input type="text" name="meta" class="form-control" placeholder="Ingresa nombre de la meta">
                    </td>
                    <td class="text-center no-borders" width="30">

                        <input type="hidden" name="page" value="1" id="pagep">
                        <input type="hidden" name="nopagina" value="10" id="pagep">


                        <div class="s-14 c-text-alt">Buscar</div>
                        <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                    </td>
            </tr>
        </tbody>
    </table>
</form>

<form id="saveInfo" method="post" class="form-horizontal">
    <div class="col-md-12" id="result"></div>
    <div class="col-md-12 no-padding" id="result2"></div>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Alinear PbRM con Meta del PDM</button>
    </article>
</form>
<script>
    $(".mySelect").select2();

    query();
    function query(){
        var formData = new FormData(document.getElementById("searchgnal"));
        $.ajax("{{ URL::to($pageModule.'/searchmetas') }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#result").empty().append(mss_tmp.load);
            },success: function(mensaje){
                $("#result").empty();
                $("#result2").empty().append(mensaje);
            }
        });
    }
    $("#searchgnal").on("submit", function(e){
        e.preventDefault();
        $("#pagep").val("1");
        query();
    });
    $(document).on("click",".pagination li a",function(e){
        e.preventDefault();
        var url =$( this).attr("href");
        var nopagina = $("#nopagina").val();
        var cadena = url.split('=');
        $("#pagep").val(cadena[1]);
        query();
    });

  
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
          formData.append('idy', "{{ $idy }}");
          formData.append('idmeta', "{{ $idmeta }}");
        $.ajax("{{ URL::to('alineacion/savealineacion') }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btnsave").prop("disabled",true).html(btnSaveSpinner);
            },success: function(res){
                let row = JSON.parse(res);
                if(row.status == 'ok'){
                    $("#sximo-modal").modal("toggle");
                    toastr.success(row.message);
                    appTema.loadData();
                }else{
                    toastr.error(row.message);
                }
                $(".btnsave").prop("disabled",false).html('<i class="fa fa-save"></i> Alinear PbRM con Meta del PDM');
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html('<i class="fa fa-save"></i> Alinear PbRM con Meta del PDM');
            }
        });
    });
</script>