<section class="col-md-12" id="app_create">
	<form id="saveInfo" method="post" class="form-horizontal">
		<table class="table table-bordered bg-white">
			<tr class="t-tr-s14 c-text-alt">
				<th class="text-center" colspan="2" width="20%">CONCEPTO</th>
				<th class="text-center">ENERO</th>
				<th class="text-center">FEBRERO</th>
				<th class="text-center">MARZO</th>
				<th class="text-center">ABRIL</th>
				<th class="text-center">MAYO</th>
				<th class="text-center">JUNIO</th>
				<th class="text-center">JULIO</th>
				<th class="text-center">AGOSTO</th>
				<th class="text-center">SEPTIEMBRE</th>
				<th class="text-center">OCTUBRE</th>
				<th class="text-center">NOVIEMBRE</th>
				<th class="text-center">DICIEMBRE</th>
				<th class="text-center">PRESUPUESTO</th>
			</tr>
				<tr>
					<td colspan="2">
						{{ $row->clave.' '.$row->fuente }}
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m1,2) }}" name="m1" id="txtm1" placeholder="Enero" onKeyUp="totalImporte(1)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m2,2) }}" name="m2" id="txtm2" placeholder="Febrero" onKeyUp="totalImporte(2)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m3,2) }}" name="m3" id="txtm3" placeholder="Marzo" onKeyUp="totalImporte(3)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m4,2) }}" name="m4" id="txtm4" placeholder="Abril" onKeyUp="totalImporte(4)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m5,2) }}" name="m5" id="txtm5" placeholder="Mayo" onKeyUp="totalImporte(5)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m6,2) }}" name="m6" id="txtm6" placeholder="Junio" onKeyUp="totalImporte(6)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m7,2) }}" name="m7" id="txtm7" placeholder="Julio" onKeyUp="totalImporte(7)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m8,2) }}" name="m8" id="txtm8" placeholder="Agosto" onKeyUp="totalImporte(8)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m9,2) }}" name="m9" id="txtm9" placeholder="Septiembre" onKeyUp="totalImporte(9)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m10,2) }}" name="m10" id="txtm10" placeholder="Octubre" onKeyUp="totalImporte(10)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m11,2) }}" name="m11" id="txtm11" placeholder="Noviembre" onKeyUp="totalImporte(11)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->m12,2) }}" name="m12" id="txtm12" placeholder="Diciembre" onKeyUp="totalImporte(12)" required>
					</td>
					<td>
						<input type="text" class="form-control no-borders form-control-ses" value="{{ number_format($row->total,2) }}" name="total" id="txttotal" placeholder="Total" readonly>
					</td>
				</tr>
		</table>

		<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar </button>
        </article>
	</form>

</section>
<script>
	$(".mySelect").select2();
	function cajaTextoNumero(valor,no){
		if(valor != "" && valor != null){
			if (!/^([0-9\.,])*$/.test(valor)){
				toastr.error("Importe, No es un número!");
				$("#txtm"+no).addClass("border-2-dashed-red");
				$("#txtm"+no).removeClass("no-borders");
			}else{
				$("#txtm"+no).addClass("no-borders");
				$("#txtm"+no).removeClass("border-2-dashed-red");
			}
		}
	}
	function totalImporte(no) {
		let valor = $("#txtm"+no).val();
		cajaTextoNumero(valor, no);
	
		let t1 = $("#txtm1").val();
        let t2 = $("#txtm2").val();
        let t3 = $("#txtm3").val();
        let t4 = $("#txtm4").val();
        let t5 = $("#txtm5").val();
        let t6 = $("#txtm6").val();
        let t7 = $("#txtm7").val();
        let t8 = $("#txtm8").val();
        let t9 = $("#txtm9").val();
        let t10 = $("#txtm10").val();
        let t11 = $("#txtm11").val();
        let t12 = $("#txtm12").val();

        let m1 = (t1 == "" ? 0 : parseFloat(t1.replace(/[^0-9.]/g, '')));
        let m2 = (t2 == "" ? 0 : parseFloat(t2.replace(/[^0-9.]/g, '')));
        let m3 = (t3 == "" ? 0 : parseFloat(t3.replace(/[^0-9.]/g, '')));
        let m4 = (t4 == "" ? 0 : parseFloat(t4.replace(/[^0-9.]/g, '')));
        let m5 = (t5 == "" ? 0 : parseFloat(t5.replace(/[^0-9.]/g, '')));
        let m6 = (t6 == "" ? 0 : parseFloat(t6.replace(/[^0-9.]/g, '')));
        let m7 = (t7 == "" ? 0 : parseFloat(t7.replace(/[^0-9.]/g, '')));
        let m8 = (t8 == "" ? 0 : parseFloat(t8.replace(/[^0-9.]/g, '')));
        let m9 = (t9 == "" ? 0 : parseFloat(t9.replace(/[^0-9.]/g, '')));
        let m10 = (t10 == "" ? 0 : parseFloat(t10.replace(/[^0-9.]/g, '')));
        let m11 = (t11 == "" ? 0 : parseFloat(t11.replace(/[^0-9.]/g, '')));
        let m12 = (t12 == "" ? 0 : parseFloat(t12.replace(/[^0-9.]/g, '')));
		let total = (m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12);
        $("#txttotal").val(total.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    } 

	$("#saveInfo").on("submit", function(e){
            e.preventDefault();
            var formData = new FormData(document.getElementById("saveInfo"));
            $.ajax("{{ URL::to('fuentefinanciamiento/update?id='.$id) }}", {
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
                        proyectos.rowsProjects();
                    }else{
                        toastr.error(row.message);
                    }
                    $(".btnsave").prop("disabled",false).html(btnSave);
                }, error : function(err){
                    toastr.error(mss_tmp.error);
                    $(".btnsave").prop("disabled",false).html(btnSave);
                }
            });
        });
</script>