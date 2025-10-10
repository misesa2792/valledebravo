<form id="saveInfo" method="post" class="form-horizontal">
		<div class="col-md-12">
		{!! Form::hidden('idprograma', $row['idprograma'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}
		{!! Form::hidden('idy', $idy,array('class'=>'form-control', 'placeholder'=>'',   )) !!}

		<div class="form-group m-t-md">
			<label for="Idsubfuncion" class=" control-label col-md-3 text-left s-14"> Estatus </label>
			<div class="col-md-9">
				<select name="estatus" class="mySelect2" required>
					<option value="">--Select Please--</option>
					@foreach ($estatus as $key => $p)
						<option value="{{ $key }}" @if($key == $row['estatus']) selected @endif>{{ $p }}</option>
					@endforeach
				</select>
				</div>
			</div> 

				<div class="form-group m-t-md">
					<label for="Idsubfuncion" class=" control-label col-md-3 text-left s-14"> Pilar </label>
					<div class="col-md-9">
						<select name="idpdm_pilares" class="mySelect2" required>
							<option value="">--Select Please--</option>
							@foreach ($pilares as $key => $p)
								<option value="{{ $p->id }}" @if($p->id == $row['idpdm_pilares']) selected @endif>{{ $p->pilar }}</option>
							@endforeach
						</select>
					</div>
				</div> 

				<div class="form-group m-t-md">
					<label for="Idsubfuncion" class=" control-label col-md-3 text-left s-14"> Pilar - Tema de desarrollo </label>
					<div class="col-md-9">
						<select name="idtema" class="mySelect2" required>
							<option value="">--Select Please--</option>
							@foreach ($pilaresTemas as $key => $p)
								<option value="{{ $p->id }}" @if($p->id == $row['idpdm_pilares_temas']) selected @endif>{{ $p->no_pilar.'-'.$p->no_tema.' '.$p->tema }}</option>
							@endforeach
						</select>
					</div>
				</div> 

				<div class="form-group  " >
					<label for="Descripcion" class=" control-label col-md-3 text-left s-14"> Tema de Desarrollo - Old No usar </label>
					<div class="col-md-9">
						<input type="text" name="tema_desarrollo" value="{{ $row['tema_desarrollo'] }}" class="form-control" placeholder="Tema de desarrollo">
					</div>
				</div>
				
					<div class="form-group m-t-md">
					<label for="Idsubfuncion" class=" control-label col-md-3 text-left s-14"> Subfunción </label>
					<div class="col-md-9">
						<select name="idsubfuncion" class="mySelect2" required>
							<option value="">--Select Please--</option>
							@foreach ($rows as $p)
								<option value="{{ $p->idsubfuncion }}" @if($p->idsubfuncion == $row['idsubfuncion']) selected @endif>{{ $p->numero }} - {{ $p->descripcion }}</option>
							@endforeach
						</select>
						</div>
					</div> 

					<div class="form-group  " >
						<label for="Numero" class=" control-label col-md-3 text-left s-14"> Número </label>
						<div class="col-md-9">
							{!! Form::text('numero', $row['numero'],array('class'=>'form-control', 'placeholder'=>'Ingresa número','required'   )) !!}
						</div>
					</div> 

					<div class="form-group  " >
						<label for="Descripcion" class=" control-label col-md-3 text-left s-14"> Descripción </label>
						<div class="col-md-9">
							{!! Form::text('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa nombre','required'   )) !!}
						</div>
					</div>

					<div class="form-group  " >
						<label for="Descripcion" class=" control-label col-md-3 text-left s-14"> Objetivo </label>
						<div class="col-md-9">
							<textarea name="objetivo" rows="5" class="form-control" placeholder="Objetivo">{{ $row['objetivo'] }}</textarea>
						</div>
					</div>

					
				</div>

		
			<div style="clear:both"></div>	
				
			<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
				<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
				<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
			</article>
	</form>
<script>
 $(".mySelect2").select2();
 
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
        if(row.success == 'ok'){
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