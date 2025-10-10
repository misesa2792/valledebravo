@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-primary s-20"> Accesos a usuarios <small class="s-16">Lista de usuarios</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>Usuarios Generales</li>
      </ul>	  
	</section>

	<div class="col-md-12 col-lg-12">

		<div id="block-filtros" class="table-resp">
		  <form enctype="multipart/form-data" id="searchgnal" method="post">
			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
			<div class="col-md-12 no-padding m-b">
  
				<div class="col-md-11 no-padding toolbar-line">
				  <a href="#" class="btn btn-sm btn-success b-r-30 c-white btnagregar" id="0"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
				</div>

				<div class="col-md-1 no-padding">
					<div class="toolbar-line">
						<select name="nopagina" id="nopagina" class="form-control">
							<option value="10"> Paginación </option>
							@foreach ($pages as $p)
								<option value="{{ $p }}"> {{ $p }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<table class="table no-margins b-gray bg-white">
					<tbody>
						<tr>
							<td>
								<div class="s-14 c-text-alt">Estatus</div>
								<select name="active" class="form-control">
									<option value="1" selected>Activo</option>
									<option value="9">Inactivo</option>
								</select>
							</td>
							<td>
								<div class="s-14 c-text-alt">Nivel</div>
								<select name="nivel" class="form-control">
									<option value="">--Select Please--</option>
									@foreach ($niveles as $v)
										<option value="{{ $v->group_id }}">{{ $v->name }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<div class="s-14 c-text-alt">Municipios</div>
								<select name="idmunicipio" class="form-control">
									<option value="">--Select Please--</option>
									@foreach ($municipios as $v)
										<option value="{{ $v->idmunicipios }}">{{ $v->descripcion }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<div class="s-14 c-text-alt">Nombre</div>
								<input type="text" name="name" class="form-control" placeholder="Ingresa nombre a buscar">
							</td>
							
							<td class="text-center" width="30">
								<div class="s-14 c-text-alt">Buscar</div>
								<button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
							</td>
							<td class="text-center" width="30">
								<input type="hidden" name="page" value="1" id="pagep">
								<div class="s-14 c-text-alt">Limpiar</div>
								<a href="{{ URL::to('core/users')}}" class="tips btn btn-xs btn-white tips b-r-30 box-shadow" title="Limpiar consulta"> <i class="fa fa-eraser var"></i> Limpiar</a>
							</td>
						</tr>
					</tbody>
				</table>
  
		   </form>
		</div>

		<div class="table-resp">
			<div class="col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
			<div class="col-md-12 col-lg-12 no-padding m-b-lg" id="result2"></div>
			<br>
			<br>
		</div>
	  </div>
	
</main>	
<script>
	query();
function query(){
    var formData = new FormData(document.getElementById("searchgnal"));
    $.ajax("{{ URL::to('core/users/search') }}", {
		type: 'post',
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){
			$("#result").empty().append(mss_tmp.load);
		},success: function(mensaje){
			$("#result").empty();
			$("#result2").empty().append(mensaje);
		}
	});
}
$("#searchgnal").on("submit", function(e){
    e.preventDefault();
    $("#pagep").val("1");
    query();
  });
$(document).on("click",".pagination li a",function(e){
    e.preventDefault();
    var url =$( this).attr("href");
    var nopagina = $("#nopagina").val();
    var cadena = url.split('=');
    $("#pagep").val(cadena[1]);
    query();
});
$(document).on("click",".btnagregar",function(e){
    e.preventDefault();
	modalMisesa("{{ URL::to('core/users/update') }}",{id:$(this).attr("id")},"Agregar Usuario","50%");
});
</script>		
@stop