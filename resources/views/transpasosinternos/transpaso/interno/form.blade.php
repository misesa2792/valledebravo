<form id="saveInfo" method="post" class="form-horizontal">
    <section class="col-md-12" style="min-height:500px;" id="app_crear">

        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" id="clave_programatica_int" value="">
        <input type="hidden" id="clave_programatica_ext" value="">

        <article class="col-md-12">
            <div class="col-md-8 no-padding"></div>
            <div class="col-md-4 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <td>Ejercicio Fiscal</td>
                        <th>{{ $year }}</th>
                    </tr>
                </table>
            </div>
        </article>

        <article class="col-md-12">
            <div class="col-md-4 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <td>Municipio: </td>
                        <th class="text-center">{{ $row->municipio }}</th>
                        <td>No.</td>
                        <th class="text-center">{{ $row->no_municipio }}</th>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <td>FORMATO</td>
                        <th colspan="3" class="text-center">
                            <div class="c-blue">SOLICITUD DE TRASPASOS INTERNOS</div>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-1 no-padding"></div>
            <div class="col-md-7 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                    <th></th>
                    <th class="text-center">Clave</th>
                    <th class="text-center">Denominación</th>
                    </tr>
                  
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Dependencia General:</th>
                        <td>{{ $row->numero }}</td>
                        <td>{{ $row->area }}</td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Dependencia Auxiliar:</th>
                        <td>{{ $row->no_coord }}</td>
                        <td>{{ $row->coordinacion }}</td>
                    </tr>

					<tr class="t-tr-s14 c-text-alt">
                        <th>Proyecto: </th>
                        <td id="td_no_proyecto"></td>
                        <td width="60%">
							<select name="idproyecto" class="mySelect full-width" onchange="obtenerValorData()" id="sltproject" required>
								<option value="">--Select Please--</option>
								@foreach ($rows_projects as $v)
									<option value="{{ $v->idproyecto }}" 
										data-idproyecto="{{ $v->idproyecto }}" 
										data-no_proyecto="{{ $v->no_proyecto }}" 
										data-no_programa="{{ $v->no_programa }}" 
										data-programa="{{ $v->programa }}" 
										data-obj_programa="{{ $v->obj_programa }}" 
										data-clasificacion="{{ $v->clasificacion }}" 
											>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
								@endforeach
							</select>
						</td>
                    </tr>
					<tr class="t-tr-s14 c-text-alt">
                        <th>Programa presupuestario: </th>
                        <td id="td_no_programa"></td>
                        <td id="td_programa"></td>
                    </tr>
					<tr class="t-tr-s14 c-text-alt">
                        <th>Objetivo: </th>
                        <td></td>
                        <td id="td_obj_programa"></td>
                    </tr>
					
                </table>
            </div>

        </article>

        <div class="table-resp" id="resFF"></div>
    </section>
</form>

<script>
	$(".mySelect").select2();

	function obtenerValorData() {
        var select = document.getElementById("sltproject");
        var opcionSeleccionada = select.options[select.selectedIndex];
        var no_programa = opcionSeleccionada.getAttribute("data-no_programa");
        var programa = opcionSeleccionada.getAttribute("data-programa");
        var obj_programa = opcionSeleccionada.getAttribute("data-obj_programa");
        var no_proyecto = opcionSeleccionada.getAttribute("data-no_proyecto");
        var clasificacion = opcionSeleccionada.getAttribute("data-clasificacion");
        $("#td_no_programa").html(no_programa);
        $("#td_programa").html(programa);
        $("#td_obj_programa").html(obj_programa);
        $("#td_no_proyecto").html(no_proyecto);
		let clave = "{{ $row->numero }} " + "{{ $row->no_coord }} " + no_proyecto +" "+ clasificacion;
		$("#clave_programatica_int").val(clave);
		$("#clave_programatica_ext").val(clave);
        loadTemplate(clave);
    }
    function loadTemplate(clave){
		$("#resFF").html(mss_tmp.load);

        axios.get('{{ URL::to("transpasosinternos/viewadd") }}',{
			params : {clave_int:clave,clave_ext:clave, idyear: "{{ $idyear }}", k:"{{ $token }}"},
		}).then(response => {
			$("#resFF").empty().append(response.data);
		}).catch(error => {
		}).finally(() => {
		});
    }

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
      formData.append("idyear", "{{ $idyear }}");
        $.ajax("{{ URL::to($pageModule.'/saveti?k='.$token) }}", {
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
                    proyectos.rowsProjects();
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
    });
</script>