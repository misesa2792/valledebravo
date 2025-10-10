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
        <table class="table table-bordered table-hover bg-white">
		<thead>
			<tr class="t-tr-s14">
				<th rowspan="2" width="40">No.</th>
				<th rowspan="2">Meta por Actividad</th>
				<th rowspan="2">Unidad de Medida</th>
				<th rowspan="2" width="180">Total de Metas Programadas durante la administración</th>
				<th colspan="3" class="text-center">Calendarización Anual</th>
				<th rowspan="2" width="40">Acción</th>
			</tr>
			<tr class="t-tr-s14">
				<th width="11%" class="text-center c-white bg-yellow-meta">{{ $data->anio - 2 }}</th>
				<th width="11%" class="text-center c-white bg-red-meta">{{ $data->anio - 1 }}</th>
				<th width="11%" class="text-center c-white bg-blue-meta">{{ $data->anio }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rowsMetas as $v)
		 {{--*/
			$time = $v->id;
		/*--}}
			<tr id="tr_{{ $time }}" class="bg-white">
				<td>
					<input type="text" value="{{ $v->numero }}" class="form-control no-borders" style="background: transparent;" name="numero[]" placeholder="#" readonly required>
				</td>
				<td>
					<input type="hidden" class="form-control" name="idag[]" value="{{ $time }}">
					<input type="text" value="{{ $v->meta }}"  class="form-control no-borders" style="background: transparent;" name="meta[]" placeholder="Ingresa Meta por Actividad" required>
				</td>
				<td>
					<input type="text" value="{{ $v->unidad_medida }}" class="form-control no-borders" style="background: transparent;" name="medida[]" placeholder="Ingresa Medida" required>
				</td>
				<td>
					<input type="text" value="{{ $v->total_programado }}"  class="form-control fun no-borders" id="presupuesto_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="Programado" name="programado[]" required readonly>
				</td>
				<td>
					<input type="text" value="{{ $v->total_year1 }}" class="form-control fun no-borders" id="total1_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total1[]" onKeyUp="totalMeta({{ $time }})" required>
				</td>
				<td>
					<input type="text" value="{{ $v->total_year2 }}" class="form-control fun no-borders" id="total2_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total2[]" onKeyUp="totalMeta({{ $time }})" required>
				</td>
				<td>
					<input type="text" value="{{ $v->total_year3 }}" class="form-control fun no-borders" id="total3_{{ $time }}" style="background:transparent;font-size:16px !important;" placeholder="$" name="total3[]" onKeyUp="totalMeta({{ $time }})" required>
				</td>
			
				<td class="text-center">
					<i class="fa fa-trash-o c-danger s-18 cursor btndestroyedit" id="{{ $time }}"></i>
				</td>
			</tr>
		@endforeach
		</tbody>
		<tbody id="_tbody">
		</tbody>
		<tbody class="no-borders">
			<tr>
				<td class="no-borders">
				<button type="button" class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> Agregar</button>
				</td>
			</tr>
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
              axios.delete('{{ URL::to("anteproyecto/trpmpdm") }}',{
                  params : {id:time}
              }).then(response => {
				let row = response.data;
                  if(row.status == "ok"){
                      $("#tr_"+time).remove();
					  toastr.success(row.message);
                      asignarNumeracion();
                  }
              })
          }
        })
    })

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
                asignarNumeracion();
            }
            })
    })

    function totalMeta(time) {
		let total1 = $("#total1_"+time).val();
		let total2 = $("#total2_"+time).val();
		let total3 = $("#total3_"+time).val();

		if (!/^([0-9\.,])*$/.test(total1)){
			toastr.error("No es un número!");
			$("#total1_"+time).val("");
		}
		if (!/^([0-9\.,])*$/.test(total2)){
			toastr.error("No es un número!");
			$("#total2_"+time).val("");
		}

		if (!/^([0-9\.,])*$/.test(total3)){
			toastr.error("No es un número!");
			$("#total3_"+time).val("");
		}
		// Remover las comas y convertir a float
		let t1 = total1 === "" ? 0 : parseFloat(total1.replace(/[,]/g, ''));
		let t2 = total2 === "" ? 0 : parseFloat(total2.replace(/[,]/g, ''));
		let t3 = total3 === "" ? 0 : parseFloat(total3.replace(/[,]/g, ''));

        let ft1 = truncarDosDecimales(t1);
        let ft2 = truncarDosDecimales(t2);
        let ft3 = truncarDosDecimales(t3);

        let suma = ft1 + ft2 + ft3;

		let sumaFormateada = truncarDosDecimales(suma);

        $("#presupuesto_"+time).val(sumaFormateada);
   } 

    function agregarTr(){
        const btnAgregar = '<i class="fa fa-plus"></i> Agregar';

        $("#btnadd").prop("disabled",true).html(mss_spinner);

        axios.get('{{ URL::to("anteproyecto/addtrpmpdm") }}',{
            params : {}
        }).then(response => {
            $("#_tbody").append(response.data);
            asignarNumeracion();
            $("#btnadd").prop("disabled",false).html(btnAgregar);
        }).catch(error => {
            $("#btnadd").prop("disabled",false).html(btnAgregar);
        })
    }

    function asignarNumeracion(){
        $("input[name='numero[]']").each(function(indice, elemento) {
            $(elemento).val(indice+1);
        });
    }

    function truncarDosDecimales(valor) {
        return Math.trunc(valor * 100) / 100;
    }

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
                    $.ajax("{{ URL::to('anteproyecto/savepmpdm') }}", {
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

@if(count($rowsMetas) == 0)
<script>
 agregarTr();
</script>
@endif