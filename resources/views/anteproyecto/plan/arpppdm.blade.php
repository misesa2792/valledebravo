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
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="t-tr-s14">
                    <th width="100">No. Programa</th>
                    <th>Programa</th>
                    <th>Pilar</th>
                    <th width="10%" class="text-center c-white bg-yellow-meta">{{ $data->anio -2 }}</th>
                    <th width="10%" class="text-center c-white bg-red-meta">{{ $data->anio - 1 }}</th>
                    <th width="10%" class="text-center c-white bg-blue-meta">{{ $data->anio }}</th>
                    <th width="10%"  class="text-center c-white bg-green-meta">Presupuesto de Egresos Estimado</td>
                </tr>
            </thead>
            <tbody>
                <tr class="t-tr-s14">
                    <td>{{ $data->no_programa }}</td>
                    <td>{{ $data->programa }}</td>
                    <td>{{ $data->pilar }}</td>
                    <td>
                        <input type="text" name="total_year1" value="{{ $data->total_year1 }}" id="total1" class="form-control" placeholder="$" onKeyUp="sumarTab()" required>
                    </td>
                    <td>
                        <input type="text" name="total_year2" value="{{ $data->total_year2 }}" id="total2" class="form-control" placeholder="$" onKeyUp="sumarTab()" required>
                    </td>
                    <td>
                        <input type="text" name="total_year3" value="{{ $data->total_year3 }}" id="total3" class="form-control" placeholder="$" onKeyUp="sumarTab()" required>
                    </td>
                    <td>
                        <input type="text" name="total_presupuesto" value="{{ $data->total_presupuesto }}" id="presupuesto" class="form-control" placeholder="$" required readonly>
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

    function sumarTab() {
		let total1 = $("#total1").val();
		let total2 = $("#total2").val();
		let total3 = $("#total3").val();

		if (!/^([0-9\.,])*$/.test(total1)){
			toastr.error("No es un número!");
			$("#total1").val("");
		}
		if (!/^([0-9\.,])*$/.test(total2)){
			toastr.error("No es un número!");
			$("#total2").val("");
		}

		if (!/^([0-9\.,])*$/.test(total3)){
			toastr.error("No es un número!");
			$("#total3").val("");
		}

		// Remover las comas y convertir a float
		let t1 = (total1 === "" ? 0 : parseFloat(total1.replace(/[,]/g, '')));
		let t2 = (total2 === "" ? 0 : parseFloat(total2.replace(/[,]/g, '')));
		let t3 = (total3 === "" ? 0 : parseFloat(total3.replace(/[,]/g, '')));

        let ft1 = truncarDosDecimales(t1);
        let ft2 = truncarDosDecimales(t2);
        let ft3 = truncarDosDecimales(t3);

        let suma = ft1 + ft2 + ft3;

		let sumaFormateada = truncarDosDecimales(suma);

        $("#presupuesto").val(sumaFormateada);
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
                    $.ajax("{{ URL::to('anteproyecto/updatearpppdm') }}", {
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