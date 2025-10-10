<form id="saveInfo" method="post" class="form-horizontal">

<input type="hidden" name="idp" value="{{ $idp }}">
<input type="hidden" name="idy" value="{{ $idy }}">
<input type="hidden" name="trim" value="{{ $trim }}">
<input type="hidden" name="id" value="{{ $id }}">


    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="25%">Indicadores</th>
                <th width="25%">Descripción de logros y avances de los indicadores de la MIR</th>

                <th width="25%">Metas</th>
                <th width="25%">Descripción de logros y avances de metas físicas por proyecto</th>
            </tr>
            <tr>
               
                <td>
                    <table class="table">
                        <tr>
                            <th>Indicador</th>
                            <th>Trimestre</th>
                            <th>Avance</th>
                            <th>Porcentaje</th>
                        </tr>
                        @foreach ($rows['indicador'] as $v)
                            @if($v['trim'] > 0 || $v['cant'] > 0)
                                <tr>
                                    <td>{{ $v['meta'] }}</td>
                                    <td class="text-right">{{ number_format($v['trim']) }}</td>
                                    <td class="text-right">{{ number_format($v['cant']) }}</td>
                                    <td class="text-right">
                                        @if($v['trim'] > 0 && $v['por'] > 110)
                                            <div class="c-blue">+ {{ $v['por'] }}%</div>
                                        @elseif($v['trim'] > 0 &&  $v['por'] <= 89.99)
                                            <div class="c-danger">- {{ $v['por'] }}%</div>
                                        @else 
                                            <div class="text-center">
                                                <i class="fa fa-check-circle c-green-meta s-12"></i>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>

                <td>
                   <table class="table">
                        @foreach ($rowsReg['indicador'] as $v)
                            <tr id="tr_{{ $v['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td width="90%">
                                    <input type="hidden" name="idindicador_edit[]" value="{{ $v['id'] }}">
                                    <textarea name="indicador_edit[]" rows="3" class="form-control" placeholder="Descripción">{{ $v['text'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btndestroyedit" id="{{ $v['id'] }}"></i>
                                </td>
                            </tr>
                        @endforeach
                        <tbody id="tbody_indi"></tbody>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-xs btn-info btn-ses" id="btnaddindi"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                   </table>
                </td>

                <td>
                    <table class="table">
                        <tr>
                            <th>Meta</th>
                            <th>Trimestre</th>
                            <th>Avance</th>
                            <th>Porcentaje</th>
                        </tr>
                        @foreach ($rows['meta'] as $v)
                            @if($v['trim'] > 0 || $v['cant'] > 0)
                                <tr>
                                    <td>{{ $v['meta'] }}</td>
                                    <td class="text-right">{{ number_format($v['trim']) }}</td>
                                    <td class="text-right">{{ number_format($v['cant']) }}</td>
                                    <td class="text-right">
                                        @if($v['trim'] > 0 && $v['por'] > 110)
                                            <div class="c-blue">+ {{ $v['por'] }}%</div>
                                        @elseif($v['trim'] > 0 &&  $v['por'] <= 89.99)
                                            <div class="c-danger">- {{ $v['por'] }}%</div>
                                        @else 
                                            <div class="text-center">
                                                <i class="fa fa-check-circle c-green-meta s-12"></i>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>

                <td>
                    <table class="table">
                        @foreach ($rowsReg['meta'] as $v)
                            <tr id="tr_{{ $v['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td width="90%">
                                    <input type="hidden" name="idmeta_edit[]" value="{{ $v['id'] }}">
                                    <textarea name="meta_edit[]" rows="3" class="form-control" placeholder="Descripción">{{ $v['text'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btndestroyedit" id="{{ $v['id'] }}"></i>
                                </td>
                            </tr>
                        @endforeach
                        <tbody id="tbody_meta"></tbody>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-xs btn-info btn-ses" id="btnaddmeta"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                   </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="checkbox" name="checkindicador" value="1" @if($row->leyenda_indicador == 1) checked @endif> Alcanzando un óptimo desempeño, en el cumplimiento de los indicadores Estratégicos de Gestión del Programa Presupuestario.
                </td>
                <td></td>
                <td>
                    <input type="checkbox" name="checkmeta" value="1"  @if($row->leyenda_meta == 1) checked @endif>Alcanzando un cumplimiento satisfactorio en las metas de actividades sustantivas relevantes del Programa Presupuestario.
                </td>
            </tr>
        </table>
</div>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>
</form>

<script>

$("#saveInfo").on("submit", function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("saveInfo"));
    $.ajax("{{ URL::to('avancepdm/save') }}", {
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
                query();
            }else{
                toastr.error(row.error);
            }
            $(".btnsave").prop("disabled",false).html(btnSave);
        }, error : function(err){
            toastr.error(mss_tmp.error);
            $(".btnsave").prop("disabled",false).html(btnSave);
        }
    });
});

    $("#btnaddindi").click(function(e){
        e.preventDefault();
        axios.get('{{ URL::to("avancepdm/addtrindi") }}',{
            params : {}
        }).then(response => {
			//$("#"+text).prop("disabled",false).html('<i class="fa fa-plus"></i> Agregar');
            $("#tbody_indi").append(response.data);
        })
    })
    $("#btnaddmeta").click(function(e){
        e.preventDefault();
        axios.get('{{ URL::to("avancepdm/addtrmeta") }}',{
            params : {}
        }).then(response => {
			//$("#"+text).prop("disabled",false).html('<i class="fa fa-plus"></i> Agregar');
            $("#tbody_meta").append(response.data);
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
                eliminadoTr(time);
            }
          })
    })

    function eliminadoTr(id){
        axios.delete('{{ URL::to("avancepdm/registro") }}',{
            params : {id:id}
        }).then(response => {
			let row = response.data;
			if(row.status == "ok"){
				toastr.success(row.message);
				$("#tr_"+id).remove();
			}else{
				toastr.error(row.message);
			}
        })
    }
</script>