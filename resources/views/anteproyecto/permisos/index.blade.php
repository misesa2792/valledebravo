@extends('layouts.main')

@section('content')

 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
<main class="page-content row bg-body">

	<div class="col-md-12 no-padding" id="appTabs">

		<section class="page-header bg-body no-padding">
			<div class="page-title">
				<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>Acceso a permisos por usuario</i></small></h3>
			</div>
		
			<ul class="breadcrumb bg-body">
				<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-16 c-blue"></i> </a></li>
				<li>
					<a href="{{ URL::to($pageModule) }}" class="c-blue"> <i>Ejercicio Fiscal</i> </a>
				</li>
				<li>{{ $rowYear['anio'] }}</li>
				<li class="active"><i>Acceso a permisos por usuario</i></li>
				<li>
					<i><a href="{{ URL::to($pageModule.'/dependencias?idy='.$idy.'&type='.$type) }}" class="subrayado cursor icon-animation c-text s-12"> <i class="fa fa-arrow-circle-left"></i> Regresar a dependencias</a></i>
				</li>
			</ul>	  
		</section>


			<section class="page-content-wrapper no-padding m-t-md">
				<div class="sbox animated fadeInRight ">
					<div class="sbox-title border-t-yellow"> <h4> Permisos</h4></div>
					<div class="sbox-content bg-white" style="min-height:300px;"> 	

						<div class="row no-padding m-t-md">
							<div class="col-md-12">
    							<form id="saveInfo" method="post" class="form-horizontal">
									<table class="table table-bordered table-hover table-striped border-gray no-margins table-no-borders" >
										<thead>
											<tr>
												<th colspan="3"></th>
												<th colspan="7" class="text-center">Acceso a Botones</th>
												<th colspan="6" class="text-center">Acceso a Módulos</th>
											</tr>
											<tr class="c-text-alt">
												<th class="no-borders" rowspan="2">Nivel</th>
												<th class="no-borders" rowspan="2">Nombre</th>
												<th class="no-borders" rowspan="2">Accesos</th>
												<th class="no-borders text-center">Ver</th>
												<th class="no-borders text-center">Agregar</th>
												<th class="no-borders text-center">Editar</th>
												<th class="no-borders text-center">Eliminar</th>
												<th class="no-borders text-center">Generar PDF</th>
												<th class="no-borders text-center">Revertir PDF</th>
												<th class="no-borders text-center">Descargar PDF</th>
												<th class="no-borders text-center">PbRM-01a</th>
												<th class="no-borders text-center">PbRM-01b</th>
												<th class="no-borders text-center">PbRM-01c</th>
												<th class="no-borders text-center">PbRM-01d</th>
												<th class="no-borders text-center">PbRM-01e</th>
												<th class="no-borders text-center">PbRM-02a</th>
											</tr>
											<tr>
												<td class="text-center"><i class="fa icon-file6 s-12"></i></td>
												<td class="text-center"><i class="fa fa-plus-circle s-14 c-success"></i></td>
												<td class="text-center"><i class="fa fa-edit s-14 c-blue"></i></td>
												<td class="text-center"><i class="fa fa-trash-o s-14 c-danger"></i></td>
												<td class="text-center"><i class="fa icon-file-pdf s-12 c-text"></i></td>
												<td class="text-center"><i class="fa fa-exchange lit s-14"></i></td>
												<td class="text-center"><i class="fa icon-file-pdf s-12 c-danger"></i></td>
											</tr>
											<tr class="c-text-alt">
												<th class="no-borders"></th>
												<th class="no-borders"></th>
												<th class="no-borders"></th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_view">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_add">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_edit">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_remove">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_generate">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_reverse">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_download">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_01a">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_01b">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_01c">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_01d">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_01e">
												</th>
												<th class="no-borders text-center">
													<input type="checkbox" data-toggle-perm="is_02a">
												</th>
											</tr>
										</thead>
									
										<tbody>
											@foreach($rowsUser as $u)
												<tr>
													<td>{{ $u['nivel'] }}
														<input type="hidden" name="ids[]" value="{{$u['id']}}">
													</td>
													<td>{{ $u['user'] }}</td>
													<td>
														<ul>
															@foreach($u['dep_gen'] as $dg)
																<li>{{ $dg->no_dep_gen }} - {{ $dg->dep_gen }}</li>
															@endforeach
														</ul>
													</td>
													<td class="text-center"><input type="checkbox" class="perm is_view" name="is_view[{{ $u['id'] }}]" @if($u['access']['is_view'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_add" name="is_add[{{ $u['id'] }}]" @if($u['access']['is_add'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_edit" name="is_edit[{{ $u['id'] }}]" @if($u['access']['is_edit'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_remove" name="is_remove[{{ $u['id'] }}]" @if($u['access']['is_remove'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_generate" name="is_generate[{{ $u['id'] }}]" @if($u['access']['is_generate'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_reverse" name="is_reverse[{{ $u['id'] }}]" @if($u['access']['is_reverse'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_download" name="is_download[{{ $u['id'] }}]" @if($u['access']['is_download'] == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_01a" name="is_01a[{{ $u['id'] }}]" @if(isset($u['access']['is_01a']) ? $u['access']['is_01a'] : '0' == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_01b" name="is_01b[{{ $u['id'] }}]" @if(isset($u['access']['is_01b']) ? $u['access']['is_01b'] : '0' == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_01c" name="is_01c[{{ $u['id'] }}]" @if(isset($u['access']['is_01c']) ? $u['access']['is_01c'] : '0' == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_01d" name="is_01d[{{ $u['id'] }}]" @if(isset($u['access']['is_01d']) ? $u['access']['is_01d'] : '0' == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_01e" name="is_01e[{{ $u['id'] }}]" @if(isset($u['access']['is_01e']) ? $u['access']['is_01e'] : '0' == '1') checked @endif></td>
													<td class="text-center"><input type="checkbox" class="perm is_02a" name="is_02a[{{ $u['id'] }}]" @if(isset($u['access']['is_02a']) ? $u['access']['is_02a'] : '0' == '1') checked @endif></td>
												</tr>
											@endforeach
										</tbody>
									</table>

								<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
									<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
								</article>

    							</form>

							</div>
						</div>

					</div>
				</div>		 
				</section>
	</div>
</main>	


<script>
	document.querySelectorAll('input[data-toggle-perm]').forEach(function(hd){
	hd.addEventListener('change', function(){
		var perm = this.getAttribute('data-toggle-perm');    // ej. "is_view"
		document.querySelectorAll('input.perm.'+perm).forEach(function(cb){
		cb.checked = hd.checked;
		});
	});
	});

	$("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de guardar?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
            if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    formData.append('idy', "{{ $idy }}");
                    formData.append('idmodule', "{{ $idmodule }}");
                    $.ajax("{{ URL::to('anteproyecto/savepermisos') }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                           // $(".btnsave").prop("disabled",true).html(btnSaveSpinner);
                        },success: function(res){
                            let row = JSON.parse(res);
                            if(row.status == 'ok'){
                                toastr.success(row.message);
                            }else{
                                toastr.error(row.message);
                            }
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }, error : function(err){
                            toastr.error(mss_tmp.error);
                            $(".btnsave").prop("disabled",false).html(btnSave);
                        }
                    });
            }
        })
    });

</script>
	
@stop