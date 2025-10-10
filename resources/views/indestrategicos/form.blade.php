<form id="saveInfo" method="post" class="form-horizontal">
	<div class="col-md-12">
		{!! Form::hidden('idanio', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
					
		<div class="form-group  " >
			<label class=" control-label col-md-3 text-right s-14"> Programa </label>
			<div class="col-md-9">
				<select name="idprograma" class="mySelect2" required>
					<option value="">--Select Please--</option>
					@foreach ($rowsProgramas as $p)
						<option value="{{ $p->idprograma }}" @if($row['idprograma'] == $p->idprograma) selected @endif>{{ $p->no_programa.' '.$p->programa }}</option>
					@endforeach
				</select>
			</div>
		</div> 
		
		<div class="form-group  " >
			<label class=" control-label col-md-3 text-right s-14"> Código Indicador </label>
			<div class="col-md-9">
				{!! Form::text('codigo', $row['codigo'],array('class'=>' c-text form-control', 'placeholder'=>'Código indicador','required'  )) !!}
			</div>
		</div> 

		<div class="form-group  " >
			<label class=" control-label col-md-3 text-right s-14"> Nombre del Indicador </label>
			<div class="col-md-9">
				{!! Form::text('indicador', $row['indicador'],array('class'=>'form-control c-text', 'placeholder'=>'Nombre del indicador', 'required' )) !!}
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<table class="table table-bordered bg-white">
			<tr>
				<th width=20%>Nombre corto de la variable</th>
				<th>Nombre largo de la variable</th>
				<th width="30">Acción</th>
			</tr>
			@foreach($rowsIndicadores as $v)
				<tr id="tr_{{ $v->id }}">
					<td class="no-borders">
						<input type="hidden" value="{{ $v->id }}" class="form-control c-text-alt no-borders" name="idreg[]" required>
						<input type="text" value="{{ $v->nombre_corto }}" class="form-control c-text-alt no-borders" placeholder="Nombre corto" name="nombre_corto[]" required>
					</td>

					<td class="no-borders">
						<input type="text" value="{{ $v->nombre_largo }}" class="form-control c-text-alt no-borders" placeholder="Nombre largo" name="nombre_largo[]"required>
					</td>

					<td class="text-center no-borders">
						<i class="fa fa-trash-o c-danger s-14 cursor btndestroyedit" id="{{ $v->id }}"></i>
					</td>
				</tr>
			@endforeach
    		<tbody id="_tbody"></tbody>
			<tr>
				 <td colspan="3">
					<button class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> </button>
				</td>
			</tr>
		</table>
	</div>


	<div style="clear:both"></div>	

	<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
		<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
	</article>
</form>
				
<script>
$(".mySelect2").select2();

	$("#btnadd").click(function(e){
		e.preventDefault();
		agregarTr();
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
                eliminarColumna(time);
            }
          })
    })

	function eliminarColumna(id){
        axios.delete('{{ URL::to($pageModule."/tr") }}',{
            params : {id:id}
        }).then(response => {
            let row = response.data;
            if(row.status == "ok"){
                toastr.success(row.message);
                $("#tr_"+id).remove();
				query();
            }else{
                toastr.warning(row.message);
            }
        })
    }

function agregarTr(){
	axios.get('{{ URL::to($pageModule."/tr") }}',{
		params : {id:"{{ $id }}"}
	}).then(response => {
		$("#_tbody").append(response.data);
	})
}

$("#saveInfo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("saveInfo"));
	$.ajax("{{ URL::to($pageModule.'/save?id='.$id) }}", {
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
				toastr.success(mss_tmp.success);
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