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
                    <select name="idp" class="mySelect2" required>
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

<div class="col-md-12">
    <table class="table table-bordered bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th width="40" class="text-center">Código</th>
            <th class="text-center" width="60%">Nombre de la meta de actividad</th>
            <th width="40"></th>
            <th class="text-center" width="10%">Unidad Medida</th>
            <th class="text-center">Programación Anual </th>
            <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
        </tr>
         
        <tbody id="_tbody" class="no-borders"></tbody>
        <tbody class="no-borders">
            <tr>
                <td class="no-borders text-center">
                    <button class="btn btn-xs btn-white c-blue" id="btnadd"> <i class="fa fa-plus"></i> </button>
                </td>
            </tr>
        </tbody>     
    </table>
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" class="btn btn-sm btn-primary btnsaveinfo"> <i class="fa fa-save"></i> Guardar</button>
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

    agregarTr();

    function totalMeta(idrg) {
        let trim1 = $("#t1_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim1)){
            toastr.error("Trim. #1, No es un número!");
            $("#t1_"+idrg).val("");
        }
        let trim2 = $("#t2_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim2)){
            toastr.error("Trim. #2, No es un número!");
            $("#t2_"+idrg).val("");
        }
        let trim3 = $("#t3_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim3)){
            toastr.error("Trim. #3, No es un número!");
            $("#t3_"+idrg).val("");
        }
        let trim4 = $("#t4_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim4)){
            toastr.error("Trim. #4, No es un número!");
            $("#t4_"+idrg).val("");
        }
        let t1 = (trim1 == "" ? 0 : parseFloat(trim1));
        let t2 = (trim2 == "" ? 0 : parseFloat(trim2));
        let t3 = (trim3 == "" ? 0 : parseFloat(trim3));
        let t4 = (trim4 == "" ? 0 : parseFloat(trim4));

        let anual = t1+t2+t3+t4;

        $("#anual_"+idrg).val(anual);
    } 
    function asignarNumeracion(){
        $("input[name='codigo[]']").each(function(indice, elemento) {
            $(elemento).val(indice+1);
        });
    }
    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
        axios.get('{{ URL::to("reporte/addtrmeta") }}',{
            params : {}
        }).then(response => {
            $("#_tbody").append(response.data);
            asignarNumeracion();
        })
    }
    $(document).on("click",".btndestroy",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                $("#tr_"+time).remove();
                asignarNumeracion();
            }
          })
    })
    $(document).on("click",".btndestroyedit",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                axios.delete('{{ URL::to("reporte/meta") }}',{
                    params : {id:time}
                }).then(response => {
                    var row = response.data;
                    if(row.status == "ok"){
                        $("#tr_"+time).remove();
                        asignarNumeracion();
                        toastr.success(row.message);
                    }
                })
            }
          })
    })

    $("#formOchoc").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById("formOchoc"));
        $.ajax("{{ URL::to('reporte/addmeta?idy='.$idy) }}", {
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