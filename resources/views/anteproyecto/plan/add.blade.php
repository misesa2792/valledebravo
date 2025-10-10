<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

 <article class="col-md-12">
	<div class="col-md-9 no-padding"></div>
	<div class="col-md-3 no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14 c-text-alt">
				<td>Ejercicio Fiscal</td>
				<th>{{ $data['year'] }}</th>
			</tr>
		</table>
	</div>
</article>

<article class="col-md-12">
	<div class="col-md-5 no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14 c-text-alt">
				<td>Municipio: </td>
				<th class="text-center">{{ $data['institucion'] }}</th>
				<td>No.</td>
				<th class="text-center">{{ $data['no_institucion'] }}</th>
			</tr>
			<tr class="t-tr-s14 c-text-alt">
				<td>Planeación</td>
				<th colspan="3" class="text-center">
					<div>Programa Anual</div>
					<div>Asignación de Programas por Dependencia</div>
				</th>
			</tr>
		</table>
	</div>
	<div class="col-md-1 no-padding"></div>
	<div class="col-md-6 no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14 c-text-alt">
			<th  width="130"></th>
			<th class="text-center" width="80">Clave</th>
			<th class="text-center">Denominación</th>
			</tr>
			<tr class="t-tr-s16 c-text-alt">
				<th>Dependencia Ejecutora: </th>
				<td>{{ $data['no_dep_gen'] }}</td>
				<td>{{ $data['dep_gen'] }}</td>
			</tr>
		</table>
	</div>
</article>

    <article class="col-sm-12 col-md-12">
      
        <div class="col-md-12 no-padding m-t-md m-b-md">
            <div class="alert alert-danger fade in block-inner">
                <i class="icon-warning"></i> Selecciona los programas para la dependencia <strong>{{ $data['dep_gen'] }}</strong> para generar los formatos:
                <ul>
                    <li class="c-text">APDM - Alineación del Plan de Desarrollo Municipal</li>
                    <li class="c-text">ARPPPDM - Asignación de Recurso por Programa Presupuestario PDM</li>
                    <li class="c-text">PMPDM - Programación de Metas del PDM</li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered table-hover bg-white">
		<thead>
			<tr class="t-tr-s14">
				<th width="30" colspan="2">Pilar</th>
				<th width="30">#</th>
				<th width="130" class="text-center">No. Programa</th>
				<th>Programa</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rowsPogramas as $p)
				<tr class="t-tr-s14">
					<th colspan="5" class="c-text">{{ $p['pilar'] }}</th>
				</tr>
				@foreach ($p['programas'] as $l)
					<tr class="t-tr-s14">
						<td class="no-borders"></td>
						<td class="no-borders"></td>
						<td class="no-borders text-center">
							@if($l['status'] == 1)
								<i class="fa fa-check s-14 c-blue"></i>
							@else
								<input type="checkbox" name="idprograma[]" value="{{ $l['id'] }}">
							@endif
						</td>
						<td class="no-borders text-center">{{ $l['no_programa'] }}</td>
						<td class="no-borders">{{ $l['programa'] }}</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>

    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>



    </form>
</section>
<script>
  

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
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    formData.append('id', "{{ $id }}");
                    formData.append('idy', "{{ $idy }}");
                    formData.append('type', "{{ $type }}");
                    $.ajax("{{ URL::to('anteproyecto/saveplan') }}", {
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
                                vm.$refs.componenteActivo?.rowsProjects();
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