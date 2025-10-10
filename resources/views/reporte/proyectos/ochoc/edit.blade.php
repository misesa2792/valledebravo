<form id="formOchoc" method="post" class="form-horizontal">
    
<div class="col-md-12">
    <div class="col-md-4 no-padding">
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table">
            <tr class="t-tr-s12 c-text-alt">
               <th class="no-borders"></th>
               <th class="text-center no-borders bg-white">Identifiador</th>
               <th class="text-center no-borders bg-white">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Programa presupuestario: </th>
                <td class="bg-white no-borders">{{ $json->no_programa }}</td>
                <td class="bg-white no-borders">{{ $json->programa }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Proyecto: </th>
                <td class="bg-white no-borders">{{ $json->no_proyecto }}</td>
                <td class="bg-white no-borders">{{ $json->proyecto }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia General:</th>
                <td class="bg-white no-borders">{{ $json->no_dep_gen }}</td>
                <td class="bg-white no-borders">{{ $json->dep_gen }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Dependencia Auxiliar:</th>
                <td class="bg-white no-borders">{{ $json->no_dep_aux  }}</td>
                <td class="bg-white no-borders">{{ $json->dep_aux  }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="no-borders text-right">Presupuesto:</th>
                <td class="bg-white no-borders"></td>
                <td class="bg-white no-borders">
                    <input type="text" name="presupuesto" value="{{ $json->presupuesto }}" class="form-control" placeholder="Presupuesto" required>
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
            <th width="30%" class="text-center">Nombre de la meta de actividad</th>
            <th class="text-center">Unidad Medida</th>
            <th class="text-center">Programación Anual </th>
            <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
            <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
            <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
            <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
        </tr>
        @foreach ($rowsMetas as $v)
            <tr class="t-tr-s12" id="tr_{{ $v->id }}">
                <td>
                    <input type="hidden" name="idrg[]" value="{{ $v->id }}">
                    <input type="text" name="codigo[]" value="{{ $v->no_accion }}" class="form-control no-borders" placeholder="Código" readonly required>
                </td>
                <td>
                    <input type="text" name="meta[]" value="{{ $v->meta }}" class="form-control no-borders" placeholder="Meta" required>
                </td>
                <td>
                    <input type="text" name="um[]" value="{{ $v->unidad_medida }}" class="form-control no-borders" placeholder="Unidad medida" required>
                </td>
                <td>
                    <input type="text" name="anual[]" value="{{ $v->prog_anual }}" id="anual_{{ $v->id }}" class="form-control no-borders text-center" placeholder="Prog. Anual" readonly required>
                </td>
                <td>
                    <input type="text" name="t1[]" value="{{ $v->t1 }}" id="t1_{{ $v->id }}" class="form-control no-borders text-center" placeholder="Trim #4" onKeyUp="totalMeta({{ $v->id }})" required>
                </td>
                <td>
                    <input type="text" name="t2[]" value="{{ $v->t2 }}" id="t2_{{ $v->id }}" class="form-control no-borders text-center" placeholder="Trim #2" onKeyUp="totalMeta({{ $v->id }})" required>
                </td>
                <td>
                    <input type="text" name="t3[]" value="{{ $v->t3 }}" id="t3_{{ $v->id }}" class="form-control no-borders text-center" placeholder="Trim #3" onKeyUp="totalMeta({{ $v->id }})" required>
                </td>
                <td>
                    <input type="text" name="t4[]" value="{{ $v->t4 }}" id="t4_{{ $v->id }}" class="form-control no-borders text-center" placeholder="Trim #4" onKeyUp="totalMeta({{ $v->id }})" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-white btndestroyedit" id="{{ $v->id }}"> <i class="fa fa-trash-o c-danger"></i> </button>
                </td>
            </tr>
        @endforeach   
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
        axios.get('{{ URL::to($pageModule."/addtrmeta") }}',{
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
                axios.delete('{{ URL::to($pageModule."/meta") }}',{
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
        $.ajax("{{ URL::to('reporte/editmeta?k='.$token) }}", {
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
                    pbrmc.rowsPbrmc();
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