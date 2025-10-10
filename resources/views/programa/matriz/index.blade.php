<form id="saveInfo" method="post" class="form-horizontal" >
<article class="col-sm-12 col-md-12 m-t-md no-padding">

    <div class="col-md-5 no-padding">
        <table class="table table-bordered bg-white" >
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right" width="30%">Programa presupuestario: </th>
                <td>{{ $row['no_programa'].' '.$row['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right" width="30%">No. Matriz: </th>
                <td>{{ $no_matriz }}</td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered bg-white">
        <tr class="t-tr-s14">
            <th rowspan="2" class="c-text-alt" width="35%">Objetivo o resumen narrativo</th>
            <th colspan="3" class="c-text-alt text-center">Indicadores</th>
            <th rowspan="2" class="c-text-alt text-center">Medios de verificación</th>
            <th rowspan="2" class="c-text-alt text-center">Supuestos</th>
            <th rowspan="2" class="c-text-alt"></th>
        </tr>
        <tr class="t-tr-s14">
            <th class="c-text-alt">Nombre</th>
            <th class="c-text-alt">Fórmula</th>
            <th class="c-text-alt">Frecuencia y Tipo</th>
        </tr>
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Fin</th>
        </tr>
        @if(isset($rows[1]))
            @include('programa.matriz.includetrind',['tr_tmp' => 'ok','tr_no' => 1, 'tr_name' => 'Fin', 'tr_rows' => $rows[1]])
        @else 
            @include('programa.matriz.includetrind',['tr_tmp' => 'no','tr_no' => 1, 'tr_name' => 'Fin', 'tr_rows' => []])
        @endif
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Propósito</th>
        </tr>
        @if(isset($rows[2]))
            @include('programa.matriz.includetrind',['tr_tmp' => 'ok','tr_no' => 2, 'tr_name' => 'Propósito', 'tr_rows' => $rows[2]])
        @else 
            @include('programa.matriz.includetrind',['tr_tmp' => 'no','tr_no' => 2, 'tr_name' => 'Propósito', 'tr_rows' => []])
        @endif
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Componentes</th>
        </tr>

        @if(isset($rows[3]))
            @include('programa.matriz.includetrmulti',['tr_tmp' => 'ok','tr_no' => 3, 'tr_name' => 'Componentes', 'tr_rows' => $rows[3]])
        @else 
            @include('programa.matriz.includetrmulti',['tr_tmp' => 'no','tr_no' => 3, 'tr_name' => 'Componentes', 'tr_rows' => [], 'time' => rand(3,100).time()])
        @endif
     
        <tbody id="add_comp"></tbody>
        <tr>
            <th colspan="7">
                <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses b-r-30 btnadd" data-no="3" data-type="add_comp" data-text="Componentes"> <i class="fa fa-plus"></i> Agregar componente</button>
            </th>
        </tr>
        <tr class="t-tr-s14">
            <th colspan="7" class="c-text-alt bg-gray">Actividades</th>
        </tr>

        @if(isset($rows[4]))
            @include('programa.matriz.includetrmulti',['tr_tmp' => 'ok','tr_no' => 4, 'tr_name' => 'Actividades', 'tr_rows' => $rows[4]])
        @else 
            @include('programa.matriz.includetrmulti',['tr_tmp' => 'no','tr_no' => 4, 'tr_name' => 'Actividades', 'tr_rows' => [], 'time' => rand(3,100).time()])
        @endif

        <tbody id="add_act"></tbody>
        <tr>
            <th colspan="7">
                <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses b-r-30 btnadd" data-no="4" data-type="add_act" data-text="Actividades"> <i class="fa fa-plus"></i> Agregar actividad</button>
            </th>
        </tr>
    </table>
</article>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>
</form>

<script>
    $(".mySelect2").select2({});
    $(".btnadd").click(function(e){
        e.preventDefault();
        axios.get('{{ URL::to($pageModule."/addtr") }}',{
            params : {no:$(this).data("no"),text:$(this).data("text")}
        }).then(response => {
            $("#"+$(this).data("type")).append(response.data);
        })
    })
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
            }
          })
    })

    $(document).on("click",".btndestroyprogreg",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){

                axios.delete('{{ URL::to("programa/trprogreg") }}',{
                    params : {id:time}
                }).then(response => {
                    let row = response.data;
                    if(row.status == "ok"){
                        toastr.success(row.message);
                        $("#tr_"+time).remove();
                    }
                })

            }
          })
    })

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
          formData.append('no_matriz', "{{ $no_matriz }}");
        $.ajax("{{ URL::to($pageModule.'/savematriz?id='.$id) }}", {
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
                    toastr.success(row.message);
                    query();
                    $("#sximo-modal").modal("toggle");
                }else{
                    toastr.error(row.message);
                }
                $(".btnsave").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>