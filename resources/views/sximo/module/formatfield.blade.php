<div style="width:padding:10px;;">

{!! Form::open(array('url'=>'sximo/module/format/'.$module_name, 'id'=>'conn_form','class'=>'form-vertical' ,'parsley-validate'=>'','novalidate'=>' ')) !!}
	<div id="result"></div>
<div class="padding-lg">

	<div class="form-group">	
		<label> Tipo de Formato </label>
			<select name="type"  class="ext" id="type"  
			style="width:30%; padding:5px; border:solid 1px #ddd; ">
			<option value="">Selecciona el tipo</option>
			<option value="numero">Numero</option>
			<option value="moneda">Moneda</option>
			<option value="boleano">Boleano</option>
			<option value="fecha">Fecha</option>
		</select> 
	</div>	

	<div class="form-group format-number" style="display: none;">
		<label for="sep_thousand"> Separador de miles </label>
		<input type="text" id="sep_thousand" name="sep_thousand" class="ext form-control" value="{{ $f['sep_thousand'] }}" />
		<label for="decimals"> Numero de decimales </label>
		<input type="text" id="decimals" name="decimals" class="ext form-control" value="{{ $f['decimals'] }}" />
		<label for="sep_decimal"> Separador de decimales </label>
		<input type="text" id="sep_decimal" name="sep_decimal" class="ext form-control" value="{{ $f['sep_decimal'] }}" />
	</div>

	<div class="form-group format-currency" style="display: none;">	
		<label for="pretext"> Prefijo </label>
		<input type="text" name="pretext" id="pretext"  class="ext form-control" value="{{ $f['pretext'] }}" />

		<label for="postext"> Codigo Moneda (sufijo) </label>
		<input type="text" name="postext" id="postext"  class="ext form-control" value="{{ $f['postext'] }}" />
	</div>

	<div class="form-group format-boolean" style="display: none;">
		<label for="boolval"> Valor Boleano (true/false) </label>
		<input type="text" name="boolval" id="boolval"  class="ext form-control" value="{{ $f['boolval'] }}" />
	</div>

	<div class="form-group format-date" style="display: none;">
		<label for="boolval"> Formato de Fecha </label>
		<input type="text" name="dateformat" id="dateformat"  class="ext form-control" value="{{ $f['dateformat'] }}" />
	</div>

	<div class="form-group">
			<input type="hidden" name="module_id" value="{{ $row->module_id }}" />
			<input type="hidden" name="field_id" value="{{ $field_id }}" />
			<input type="hidden" name="alias" value="{{ $alias }}" />
			<button type="submit" class="btn btn-primary" id="saveLayout"> Guardar Formato </button>
	
	 </div>	 			 
</div>
{!! Form::close() !!}

</div>

<script>
$(document).ready(function(){
	$("#type").change(function(){
		if($(this).val() == "numero")
		{
			$(".format-number").show();
			$(".format-currency").hide();
			$(".format-boolean").hide();
		}else if($(this).val() == "moneda")
		{
			$(".format-number").show();
			$(".format-currency").show();
			$(".format-boolean").hide();
		}
		else if($(this).val() == "boleano")
		{
			$(".format-number").hide();
			$(".format-currency").hide();
			$(".format-boolean").show();
		}
		else if($(this).val() == "fecha")
		{
			$(".format-number").hide();
			$(".format-currency").hide();
			$(".format-boolean").hide();
			$(".format-date").show();
		}
	});
});	
</script>	


