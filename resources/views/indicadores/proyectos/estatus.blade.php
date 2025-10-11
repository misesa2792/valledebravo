<form id="formEstatus" method="post" class="form-horizontal">
 
    <table class="table table-bordered">
        <tr>
            <th>MIR:</th>
            <td colspan="3">{{ $row->mir }}</td>
        </tr>
        <tr>
            <th>Indicador:</th>
            <td colspan="3">{{ $row->indicador }}</td>
        </tr>
        <tr>
            <th class="c-white bg-yellow-meta">Trim. #1</th>
            <th class="c-white bg-green-meta">Trim. #2</th>
            <th class="c-white bg-blue-meta">Trim. #3</th>
            <th class="c-white bg-red-meta">Trim. #4</th>
        </tr>
        <tr>
            <td>
                    <select name="aplica1" class="form-control">
                        @foreach($rowEstatus as $key => $value)
                            <option value="{{ $key }}" @if($key == $row->aplica1) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
            </td>
            <td>
                    <select name="aplica2" class="form-control">
                        @foreach($rowEstatus as $key => $value)
                            <option value="{{ $key }}" @if($key == $row->aplica2) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
            </td>
            <td>
                    <select name="aplica3" class="form-control">
                        @foreach($rowEstatus as $key => $value)
                            <option value="{{ $key }}" @if($key == $row->aplica3) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
            </td>
            <td>
                    <select name="aplica4" class="form-control">
                        @foreach($rowEstatus as $key => $value)
                            <option value="{{ $key }}" @if($key == $row->aplica4) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
            </td>
        </tr>
    </table>
   
    <br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" class="btn btn-sm btn-primary btnsavestatus"> <i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
    
<script>
    $("#formEstatus").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("formEstatus"));
            $.ajax("{{ URL::to('reporte/savestatus?idrm='.$idrm) }}", {
                type: 'post',
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".btnsavestatus").prop("disabled",true).html(mss_spinner + '...Guardando...');
                },success: function(res){
                    let row = JSON.parse(res);
                    if(row.status == 'ok'){
                        toastr.success(row.message);
                        $("#sximo-modal").modal("toggle");
                        metas.rowsMetas();
                    }else{
                        toastr.error(row.message);
                    }
                    $(".btnsavestatus").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
                }, error : function(err){
                    toastr.error(mss_tmp.error);
                    $(".btnsavestatus").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
                }
            });
        })
    </script>