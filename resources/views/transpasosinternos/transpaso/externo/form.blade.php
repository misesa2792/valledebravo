<form id="saveInfo" method="post" class="form-horizontal">
    <section class="col-md-12" style="min-height:500px;" id="app_crear">

        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" id="clave_programatica_int">
        <input type="hidden" id="clave_programatica_ext">
        <input type="hidden" id="dep_gen_ext">

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
                            <div class="c-danger">SOLICITUD DE TRASPASOS EXTERNOS</div>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-8 no-padding"></div>
        </article>

        <article class="col-md-12">
            <div class="col-md-6 no-padding">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <th colspan="3" class="text-center">DISMINUCIÓN</th>
                    </tr>
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
							<select name="idproyecto" class="mySelect full-width s-12" onchange="obtenerValorData()" id="sltproject" required>
								<option value="">--Select Please--</option>
								@foreach ($rows_projects as $v)
									<option value="{{ $v->idproyecto }}" 
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
            <div class="col-md-6">
                <table class="table table-bordered bg-white">
                    <tr class="t-tr-s14 c-text-alt">
                        <th colspan="3" class="text-center">AUMENTO</th>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th></th>
                        <th class="text-center">Clave</th>
                        <th class="text-center">Denominación</th>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Dependencia General:</th>
                        <td id="td_no_dep_gen_ext"></td>
                        <td id="td_dep_gen_ext"></td>
                    </tr>
                    <tr class="t-tr-s14 c-text-alt">
                        <th>Dependencia Auxiliar:</th>
                        <td id="td_no_dep_aux_ext"></td>
                        <td>
                            <select name="idarea_coordinacion_ext" class="mySelect full-width" onchange="obtenerValorDataDepExt()" id="sltdepext" required>
                                <option value="">--Select Please--</option>
                                @foreach ($depGenExt as $v)
                                    <option value="{{ $v->idac }}" 
										data-idac="{{ $v->idac }}" 
										data-dep_gen="{{ $v->dep_gen }}" 
										data-no_dep_gen="{{ $v->no_dep_gen }}" 
										data-no_dep_aux="{{ $v->no_dep_aux }}" 
                                        >{{ $v->no_dep_gen.'-'.$v->no_dep_aux.' '.$v->dep_aux }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

					<tr class="t-tr-s14 c-text-alt">
                        <th>Proyecto: </th>
                        <td id="td_no_proyecto_a"></td>
                        <td width="60%">
							<select name="idproyecto_ext" class="mySelect full-width" id="sltprojectExt" required>
								<option value="">--Select Please--</option>
							</select>
						</td>
                    </tr>
					<tr class="t-tr-s14 c-text-alt">
                        <th>Programa presupuestario: </th>
                        <td id="td_no_programa_a"></td>
                        <td id="td_programa_a"></td>
                    </tr>
					<tr class="t-tr-s14 c-text-alt">
                        <th>Objetivo: </th>
                        <td></td>
                        <td id="td_obj_programa_a"></td>
                    </tr>
					
                </table>
            </div>
        </article>

        <div class="col-md-12" id="resFF"></div>
    </section>
</form>

<script>
	$(".mySelect").select2();

    let rowsProjects =  {!! json_encode($rows_projects_ext) !!};

    function loadProjectOption(idac){
        document.getElementById('sltprojectExt').innerHTML = '<option value="" selected>--Select Please--</option>';
        $('#sltprojectExt').change(); 

        rowsProjects.forEach(function(t) {
            if(idac == t.idac){
                $("#sltprojectExt").append('<option value="'+t.idproyecto+'" data-no_proyecto="'+t.no_proyecto+'"  data-no_programa="'+t.no_programa+'"  data-programa="'+t.programa+'"  data-obj_programa="'+t.obj_programa+'"  data-clasificacion="'+t.clasificacion+'" >'+t.no_proyecto+" "+t.proyecto+'</option>');
            }
        });
    }

   // Obtiene el valor seleccionado y datos personalizados al cambiar la opción
   $('#sltprojectExt').on('change', function () {
        const idproyecto = $(this).val(); // Valor seleccionado (idproyecto)
        const data = $(this).select2('data')[0]; // Datos adicionales del elemento seleccionado
        if(idproyecto != ""){
            var no_programa = data.element.dataset.no_programa;
            var no_programa = data.element.dataset.no_programa;
            var programa = data.element.dataset.programa;
            var obj_programa = data.element.dataset.obj_programa;
            var no_proyecto = data.element.dataset.no_proyecto;
            var clasificacion = data.element.dataset.clasificacion;
            $("#td_no_programa_a").empty().html(no_programa);
            $("#td_programa_a").empty().html(programa);
            $("#td_obj_programa_a").empty().html(obj_programa);
            $("#td_no_proyecto_a").empty().html(no_proyecto);
            let dg = $("#dep_gen_ext").empty().val();
            let clave_ext = dg +" "+ no_proyecto +" "+ clasificacion;
            $("#clave_programatica_ext").val(clave_ext);
            let clave_int = $("#clave_programatica_int").val();
            loadTemplate(clave_int, clave_ext);
        }
    });

    function obtenerValorDataDepExt() {
        var select = document.getElementById("sltdepext");
        var opcionSeleccionada = select.options[select.selectedIndex];
        let no_dep_gen = opcionSeleccionada.getAttribute("data-no_dep_gen");
        let no_dep_aux = opcionSeleccionada.getAttribute("data-no_dep_aux");
        let dep_gen = opcionSeleccionada.getAttribute("data-dep_gen");
		$("#dep_gen_ext").val(no_dep_gen+" "+no_dep_aux);
		$("#td_no_dep_aux_ext").empty().html(no_dep_aux);
        $("#td_no_dep_gen_ext").empty().html(no_dep_gen);
        $("#td_dep_gen_ext").empty().html(dep_gen);
        loadProjectOption(opcionSeleccionada.getAttribute("data-idac"));
		$("#resFF").empty();
        //Limpiamos
        $("#td_no_programa_a").empty();
        $("#td_programa_a").empty();
        $("#td_obj_programa_a").empty();
        $("#td_no_proyecto_a").empty();
    }
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
    }
    function obtenerValorDataAumenta() {
        var select = document.getElementById("sltprojectExt");
        var opcionSeleccionada = select.options[select.selectedIndex];
        var no_programa = opcionSeleccionada.getAttribute("data-no_programa");
        var programa = opcionSeleccionada.getAttribute("data-programa");
        var obj_programa = opcionSeleccionada.getAttribute("data-obj_programa");
        var no_proyecto = opcionSeleccionada.getAttribute("data-no_proyecto");
        var clasificacion = opcionSeleccionada.getAttribute("data-clasificacion");
        $("#td_no_programa_a").html(no_programa);
        $("#td_programa_a").html(programa);
        $("#td_obj_programa_a").html(obj_programa);
        $("#td_no_proyecto_a").html(no_proyecto);
        let dg = $("#dep_gen_ext").val();
		let clave_ext = dg +" "+ no_proyecto +" "+ clasificacion;
		$("#clave_programatica_ext").val(clave_ext);
        let clave_int = $("#clave_programatica_int").val();
        loadTemplate(clave_int, clave_ext);
    }
    function loadTemplate(clave_int, clave_ext){
		$("#resFF").html(mss_tmp.load);
        axios.get('{{ URL::to("transpasosinternos/viewadd") }}',{
			params : {clave_int:clave_int, clave_ext:clave_ext, idyear: "{{ $idyear }}", k:"{{ $token }}"},
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
        $.ajax("{{ URL::to($pageModule.'/savete?k='.$token) }}", {
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