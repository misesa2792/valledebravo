<form id="formOchoc" method="post" class="form-horizontal">
    
<div class="col-md-12">
    <div class="col-md-5 no-padding">
        <table class="table bg-white">
            <tr class="c-text-alt">
               <th class="no-borders text-center" colspan="3">Proyecto a transferir</th>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Proyecto: </th>
                <td class="bg-white no-borders text-center">{{ $row->no_proyecto }}</td>
                <td class="bg-white no-borders">{{ $row->proyecto }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Dependencia General:</th>
                <td class="bg-white no-borders text-center">{{ $row->no_dep_gen }}</td>
                <td class="bg-white no-borders">{{ $row->dep_gen }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Dependencia Auxiliar:</th>
                <td class="bg-white no-borders text-center">{{ $row->no_dep_aux  }}</td>
                <td class="bg-white no-borders">{{ $row->dep_aux  }}</td>
            </tr>
        </table>


        <table class="table table-bordered bg-white">
          
            <tr class="c-text-alt">
                <th width="40" class="text-center">Código</th>
                <th width="30%" class="text-center">Nombre de la meta de actividad</th>
                <th class="text-center">Unidad Medida</th>
                <th class="text-center">Programación Anual </th>
                <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
                <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
                <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
                <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            </tr>
            @foreach ($rowsMetas as $v)
                <tr>
                    <td class="text-center">{{ $v->no_accion }}</td>
                    <td>{{ $v->meta }}</td>
                    <td class="text-center">{{ $v->unidad_medida }}</td>
                    <td class="text-center">{{ $v->prog_anual }}</td>
                    <td class="text-center">{{ $v->t1 }}</td>
                    <td class="text-center">{{ $v->t2 }}</td>
                    <td class="text-center">{{ $v->t3 }}</td>
                    <td class="text-center">{{ $v->t4 }}</td>
                </tr>
            @endforeach   
        </table>

    </div>
    <div class="col-md-2 text-center s-30">
        <br>
        <br>
        >
    </div>

    <div class="col-md-5 no-padding">
        <table class="table bg-white">
            <tr class="c-text-alt">
               <th class="no-borders text-center" colspan="3">Proyecto</th>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Proyecto: </th>
                <td class="bg-white no-borders text-center">{{ $row->no_proyecto }}</td>
                <td class="bg-white no-borders">{{ $row->proyecto }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Dependencia General:</th>
                <td class="bg-white no-borders text-center"></td>
                <td class="bg-white no-borders">
                    <select class="mySelect2" onchange="handleChangeDG(this)" required>
                        <option value="">--Selecciona dependencia general--</option>
                        @foreach($rowsDepGen as $v)
                            <option value="{{ $v->idarea }}">{{ $v->no_dep_gen.' '.$v->area }}</option>
                        @endforeach
                   </select>
                </td>
            </tr>
            <tr class="c-text-alt">
                <th class="no-borders text-right">Dependencia Auxiliar:</th>
                <td class="bg-white no-borders text-center"></td>
                <td class="bg-white no-borders">
                    <select name="idac" class="mySelect2" id="iddep_aux" required>
                        <option value="">--Selecciona dependencia auxiliar--</option>
                    </select>
                </td>
            </tr>
        </table>


        <table class="table table-bordered bg-white">
          
            <tr class="c-text-alt">
                <th width="40" class="text-center">Código</th>
                <th width="30%" class="text-center">Nombre de la meta de actividad</th>
                <th class="text-center">Unidad Medida</th>
                <th class="text-center">Programación Anual </th>
                <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
                <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
                <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
                <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            </tr>
            @foreach ($rowsMetas as $v)
                <tr>
                    <td class="text-center">{{ $v->no_accion }}</td>
                    <td>{{ $v->meta }}</td>
                    <td class="text-center">{{ $v->unidad_medida }}</td>
                    <td class="text-center">{{ $v->prog_anual }}</td>
                    <td class="text-center">{{ $v->t1 }}</td>
                    <td class="text-center">{{ $v->t2 }}</td>
                    <td class="text-center">{{ $v->t3 }}</td>
                    <td class="text-center">{{ $v->t4 }}</td>
                </tr>
            @endforeach   
        </table>
    </div>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" class="btn btn-sm btn-primary btnsaveinfo"> <i class="fa fa-random"></i> Transferir</button>
</article>
</form>

<script>
    $(".mySelect2").select2();

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
        $.ajax("{{ URL::to('reporte/movemeta?id='.$id) }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $(".btnsaveinfo").prop("disabled",true).html(mss_spinner + '...Transfiriendo proyecto...');
            },success: function(res){
                let row = JSON.parse(res);
                if(row.status == 'ok'){
                    toastr.success(row.message);
                    $("#sximo-modal").modal("toggle");
                    appMetas.rowsProjects();
                }else{
                    toastr.error(row.message);
                }
                $(".btnsaveinfo").prop("disabled",false).html('<i class="fa fa-save"></i> Transferir');
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsaveinfo").prop("disabled",false).html('<i class="fa fa-save"></i> Transferir');
            }
        });
    })
</script>