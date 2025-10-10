<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-8 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data->anio }}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-5 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                    <td>Municipio: </td>
                    <th class="text-center">{{ $data->no_institucion }}</th>
                    <td>No.</td>
                    <th class="text-center">{{ $data->institucion }}</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <td>ARPPPDM</td>
                    <th colspan="3" class="text-center">
                        <div>Programa Anual</div>
                        <div>Asignación de Recurso por Programa Presupuestario PDM</div>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-md-1 no-padding"></div>
        <div class="col-md-6 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s14 c-text-alt">
                   <th></th>
                   <th class="text-center">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th>Dependencia Ejecutora:</th>
                    <td>{{ $data->no_dep_gen }}</td>
                    <td>{{ $data->dep_gen }}</td>
                </tr>
                 <tr class="t-tr-s14 c-text-alt">
                    <th>Programa Presupuestario:</th>
                    <td>{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                </tr>
                 <tr class="t-tr-s14 c-text-alt">
                    <th>Objetivo del Programa: </th>
                    <td></td>
                    <td>{{ $data->obj_programa }}</td>
                </tr>
                 <tr class="t-tr-s14 c-text-alt">
                    <th>Ejes/Pilar:</th>
                    <td>{{ $data->tipo_pilar }}</td>
                    <td>{{ $data->pilar }}</td>
                </tr>
            </table>
        </div>
    </div>

    <article class="col-sm-12 col-md-12">
       <article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Alineación de Objetivos de Desarrollo Sostenibles (ODS)</th>
			</tr>
			<tr class="t-tr-s14">
				<td>
					<div class="p-xs">
						<select name="idods" class="mySelect full-width" required>
							<option value="">--Selecciona ODS--</option>
							@foreach($rowsODS as $o)
							<option value="{{ $o->id }}" @if($o->id == $data->a_idods) selected @endif >{{ $o->meta }}</option>
                            @endforeach
						</select>
					</div>
				</td>
			</tr>
		</table> 
	</article>

	<article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Meta Nacional/ Estrategia Transversal Plan Nacional de Desarrollo</th>
			</tr>
			<tr class="t-tr-s14">
				<td>
					<textarea name="meta_nacional" rows="5" class="form-control no-borders" placeholder="Meta Nacional/ Estrategia Transversal Plan Nacional de Desarrollo" required>{{ $data->a_meta_nacional }}</textarea>
				</td>
			</tr>
		</table> 
	</article>
	<article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Objetivo del Plan Nacional de Desarrollo</th>
			</tr>
			<tr class="t-tr-s14">
				<td>
					<textarea name="obj_plan_nacional" rows="5" class="form-control no-borders" placeholder="Objetivo del Plan Nacional de Desarrollo" required>{{ $data->a_obj_plan_nacional }}</textarea>
				</td>
			</tr>
		</table> 
	</article>
	<article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Objetivo del Plan de Desarrollo del Estado de México</th>
			</tr>
			<tr class="t-tr-s14">
				<td>
					<textarea name="obj_plan_estado" rows="5" class="form-control no-borders" placeholder="Objetivo del Plan de Desarrollo del Estado de México" required>{{ $data->a_obj_plan_estado }}</textarea>
				</td>
			</tr>
		</table> 
	</article>

    <article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Estrategias</th>
			</tr>
			<tr class="t-tr-s14">
				<td>
					<textarea name="estrategias" rows="5" class="form-control no-borders" placeholder="Estrategias" required>{{ $data->a_estrategias }}</textarea>
				</td>
			</tr>
		</table> 
	</article>

    <article class="col-md-12 m-b-xs no-padding">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14">
				<th class="c-text-alt no-borders">Estrategias y Líneas de Acción</th>
			</tr>
			@foreach($rowsIdla as $v)
               <tr class="t-tr-s14" id="tr_{{ $v }}">
                    <td>
                        <select name="idla[]" class="mySelect full-width" required>
                            <option value="">--Selecciona ODS--</option>
                            @foreach($rowsPDM as $l)
                                <option value="{{ $l->id }}" @if($l->id == $v) selected @endif >{{ $l->no_linea_accion.' '.$l->linea_accion }}</option>
                            @endforeach
                        </select>
                    </td>
                     <td class="text-center">
                        <i class="fa fa-trash-o c-danger s-18 cursor btndestroy" id="{{ $v }}"></i>
                    </td>
                </tr> 
            @endforeach

            <tbody id="_tbody"></tbody>
            <tbody class="no-borders">
                <tr>
                    <td class="no-borders">
                    <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> Agregar</button>
                    </td>
                </tr>
            </tbody>
		</table> 
	</article>


    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>



    </form>
</section>
<script>
    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    
    function agregarTr(){
        const btnAgregar = '<i class="fa fa-plus"></i> Agregar';

        $("#btnadd").prop("disabled",true).html(mss_spinner);

        axios.get('{{ URL::to("anteproyecto/addtrappdm") }}',{
            params : {idy: "{{ $idy }}"}
        }).then(response => {
            $("#_tbody").append(response.data);
            asignarNumeracion();
            $("#btnadd").prop("disabled",false).html(btnAgregar);
        }).catch(error => {
            $("#btnadd").prop("disabled",false).html(btnAgregar);
        })
    }

    $(".mySelect").select2();

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
              axios.delete('{{ URL::to("anteproyecto/trappdm") }}',{
                  params : {id:time}
              }).then(response => {
				let row = response.data;
                  if(row.status == "ok"){
                      $("#tr_"+time).remove();
					  toastr.success(row.message);
                  }
              })
          }
        })
    })

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
                    $.ajax("{{ URL::to('anteproyecto/updateappdm') }}", {
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
@if(count($rowsIdla) == 0)
    <script>
        agregarTr();
    </script>
@endif