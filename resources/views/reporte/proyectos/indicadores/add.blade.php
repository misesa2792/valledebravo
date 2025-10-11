<form id="formOchoc" method="post" class="form-horizontal">
    
<div class="col-md-12">
    <div class="col-md-7 no-padding">
        <table class="table bg-white">
            <tr class="t-tr-s12 c-text-alt">
               <th class="no-borders" width="15%"></th>
               <th class="text-center no-borders bg-white">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia General:</th>
                <td class="bg-white no-borders">
                   <select class="mySelect2" onchange="handleChangeDG(this)" required>
                    <option value="">--Selecciona dependencia general--</option>
                        @foreach($rowsDepGen as $v)
                            <option value="{{ $v->idarea }}">{{ $v->no_dep_gen.' '.$v->area }}</option>
                        @endforeach
                   </select>
                </td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia Auxiliar:</th>
                <td class="bg-white no-borders">
                    <select name="idac" class="mySelect2" id="iddep_aux" required>
                        <option value="">--Selecciona dependencia auxiliar--</option>
                    </select>
                </td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Proyecto: </th>
                <td class="bg-white no-borders">
                    <select name="idp" class="mySelect2" onchange="loadMatriz(this)" required>
                    <option value="">--Selecciona proyecto--</option>
                        @foreach($rowsProyectos as $v)
                            <option value="{{ $v->id }}">{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                        @endforeach
                   </select>
                </td>
            </tr>
        </table>
    </div>
</div>

<br>

<div class="col-md-12" id="res_matriz"></div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" class="btn btn-sm btn-primary btnsaveinfo"> <i class="fa fa-save"></i> Guardar</button>
</article>
</form>

<script>
    $(".mySelect2").select2();
    
    function loadMatriz(selectElement) {
        // Obtén el valor seleccionado
        const idp = selectElement.value;

        axios.get('{{ URL::to("reporte/loadmatriz") }}',{
            params : {idp:idp}
        }).then(response => {
            $("#res_matriz").empty().html(response.data);
        })
    }

    function handleChangeDG(selectElement) {
        // Obtén el valor seleccionado
        const idda = selectElement.value;
        $("#iddep_aux").html("");

        axios.get('{{ URL::to("reporte/loaddepaux") }}',{
            params : {idda:idda}
        }).then(response => {
            let row = response.data;
            if(row.status == "ok"){
                let options = '<option value="">Selecciona dependencia auxiliar</option>';
                response.data.data.forEach(element => {
                    options += `<option value="${element.id}" >${element.numero} - ${element.descripcion}</option>`;
                });
                $("#iddep_aux").html(options);
            }
        })
    }

    

    $("#formOchoc").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById("formOchoc"));
        $.ajax("{{ URL::to('reporte/addmatriz?idy='.$idy) }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btnsaveinfo").prop("disabled",true).html(mss_spinner + '...Generado PDF...');
            },success: function(res){
                let row = JSON.parse(res);
                if(row.status == 'ok'){
                    toastr.success(row.message);
                    $("#sximo-modal").modal("toggle");
                    appMetas.rowsProjects();
                }else{
                    toastr.error(row.message);
                }
                $(".btnsaveinfo").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsaveinfo").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
            }
        });
    })
</script>