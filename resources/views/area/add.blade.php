<form id="saveInfo" method="post" class="form-horizontal">

	<div class="col-md-12">
				
	{!! Form::hidden('idy', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
	{!! Form::hidden('idtd', $id,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
		
        <div class="form-group" >
			<div class="col-md-12">
			    <label class=" control-label s-14 c-text-alt"> Institución: </label>
                <select name="idi" class="form-control" required>
                    <option value="">--Select Please--</option>
                    @foreach ($rowsInstitucion as $kk => $v)
                         <option value="{{ $v->id }}">{{ $v->no_institucion.' '.$v->institucion }}</option>
                    @endforeach
                </select>
			</div>
		</div> 

        <table class="table table-bordered">
            <tr>
                <th width="40">#</th>
                <th width="40">No.</th>
                <th>Dependencia</th>
            </tr>
            @foreach($rowsDepGen as $v)
                <tr>
                    <td width="30" class="text-center">{{$j++}}</td>
                    <td class="text-center">{{ $v->no_dep_gen }}</td>
                    <td>{{ $v->dep_gen }}</td>
                </tr> 
            @endforeach
        </table>


	</div>

	<div style="clear:both"></div>

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
<script>
    $(".select2").select2();
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to($pageModule.'/add') }}", {
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
                    query();
                    toastr.success(row.message);
                }else{
                    toastr.error(mss_tmp.error);
                }
                $(".btnsave").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>