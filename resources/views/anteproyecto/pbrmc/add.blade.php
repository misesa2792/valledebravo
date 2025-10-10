<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-10 no-padding"></div>
        <div class="col-md-2 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td class="text-right">Ejercicio Fiscal</td>
                    <th width="50%">{{ $data['year'] }}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td>Municipio: </td>
                    <th class="text-center">{{ $data['institucion'] }}</th>
                    <td>No.</td>
                    <th class="text-center">{{ $data['no_institucion'] }}</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="text-center">PbRM-01c</td>
                    <th colspan="3" class="text-center">
                        <div>Programa Anual de Metas de Actividad por Proyecto</div>
                    </th>
                </tr>
            </table>

            <div class="alert alert-danger" role="alert">

            <strong>Notas importantes</strong>

            <h5 style="margin:10px 0 6px;"><span class="text-danger">Meta</span></h5>
            <ul style="margin-bottom:8px;" class="c-text-alt s-10">
                <li>Redacta en oración normal: <em>Mayúscula inicial y resto en minúsculas</em> (no todo en MAYÚSCULAS).</li>
                <li>Máximo <strong>120 caracteres</strong>.</li>
                <li>Evita caracteres no permitidos:
                <code>? ¡ # $ % / - ' "</code>. El sistema los eliminará automáticamente.
                </li>
            </ul>
            <div class="col-md-12" style="margin:-2px 0 10px;">
                <div><span class="label label-success">Correcto</span> <small class="c-text-alt">“Incrementar la recolección de residuos en zonas rurales.”</small></div>
                <span class="label label-danger">Incorrecto</span> <small class="c-text-alt">“INCREMENTAR LA RECOLECCIÓN DE RESIDUOS EN ZONAS RURALES”</small>
            </div>

            <h5 style="margin:10px 0 6px;"><span class="text-danger">Unidad de medida</span></h5>
                <ul style="margin-bottom:8px;" class="c-text-alt s-10">
                    <li>Si no está en el catálogo, puedes <strong>agregar una nueva</strong>.</li>
                </ul>
            </div>
        </div>
        <div class="col-md-1 no-padding"></div>
        <div class="col-md-7 no-padding">
            <table class="table border-gray no-margins bg-white">
                <tr class="t-tr-s12 c-text-alt">
                   <th width="20%"></th>
                   <th class="text-center" width="50">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Programa presupuestario: </th>
                    <td class="text-center border-gray">{{ $data['no_programa'] }}</td>
                    <td>{{ $data['programa'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Proyecto: </th>
                    <td class="text-center border-gray">{{ $data['no_proyecto'] }}</td>
                    <td>{{ $data['proyecto'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Dependencia General:</th>
                    <td class="text-center border-gray">{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Dependencia Auxiliar:</th>
                    <td class="text-center border-gray">{{ $data['no_dep_aux'] }}</td>
                    <td>{{ $data['dep_aux'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td colspan="3">
                        <strong>Descripción del Proyecto: </strong> {{ $data['obj_proyecto'] }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <article class="col-sm-12 col-md-12" style="min-height:500px;">
        
        <table class="table border-gray bg-white table-ses no-margins">
            <tr class="t-tr-s12 c-text-alt">
                <th rowspan="3" width="40" class="text-center">Código</th>
                <th rowspan="3" width="60%">Descripción de las Metas de Actividad sustantivas relevantes</th>
                <th rowspan="3" width="40"></th>
                <th colspan="4" class="text-center">Metas de actividad</th>
                <th colspan="2" class="text-center">Variación</th>
                <th rowspan="3" width="40"></th>
            </tr>
            <tr class="t-tr-s12 c-text-alt ">
                <th rowspan="2" class="text-center no-borders" width="10%">Unidad de Medida</th>
                <th colspan="2" class="text-center no-borders bg-danger c-white">{{ $data['year'] - 1 }}</th>
                <th rowspan="2" class="text-center no-borders bg-success c-white">
                    <div>{{ $data['year'] }}</div>
                    <div>Programado</div>
                </th>
                <th rowspan="2" class="text-center no-borders">Absoluta</th>
                <th rowspan="2" class="text-center no-borders">%</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-center bg-danger c-white">Programado</th>
                <th class="text-center bg-danger c-white">Alcanzado</th>
            </tr>
            @foreach ($data['rowsMetas'] as $r)
              {{--*/
                        $time = $r->id;
                    /*--}}
                <tr id="tr_{{ $time }}" class="bg-white t-tr-s12 btnmostrar">
                    <td>
                        <input type="text" class="form-control no-borders text-center" value="{{ $r->codigo }}" name="numero[]" placeholder="#" readonly required>
                    </td>
                    <td width="60%">
                        <input type="hidden" class="form-control" name="idag[]" value="{{ $time }}">
                        <div class="col-md-10 no-padding">
                            <input type="text" value="{{ $r->meta }}" class="form-control no-borders" name="meta[]" placeholder="Ingresa descripción de la meta" onkeyup="validarMetaCaracteres(this, {{ $time }})" required>
                        </div>
                        <div class="col-md-2 text-right">
                            <small id="contador_{{ $time }}" class="text-muted">{{ mb_strlen($r->meta, 'UTF-8') }} caracteres</small>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default btn-outline btn-ses d-none btnhover btnagregarum" id="{{ $time }}"> <i class="fa fa-plus"></i> </button>
                    </td>
                    <td>
                        <select name="medida[]" id="sltum_{{$time}}" class="mySelect" required>
                            <option value="">--Unidad de medida--</option>
                            @foreach($rowsUnidadMedida as $v)
                                <option value="{{$v->um}}" @if($v->um == $r->unidad_medida) selected @endif>{{$v->um}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" value="{{ $r->programado }}" class="form-control c-green-meta no-borders" name="programado[]" id="programado_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->alcanzado }}" class="form-control c-green-meta no-borders" name="alcanzado[]" id="alcanzado_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->anual }}" class="form-control c-blue-meta no-borders" name="anual[]" id="anual_{{ $time }}" placeholder="#" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td width="80">
                        <input type="text" value="{{ $r->absoluta }}" class="form-control c-green-meta no-borders" name="absoluta[]" id="absoluta_{{ $time }}" placeholder="Absoluta" readonly required>
                    </td>
                    <td width="80">
                        <input type="text" value="{{ $r->porcentaje }}" class="form-control c-red-meta no-borders" name="porcentaje[]" id="porcentaje_{{ $time }}" placeholder="%" readonly required>
                    </td>
                    <td class="text-center">
                        <i class="fa fa-trash-o c-danger cursor s-14 btndestroyedit d-none btnhover" id="{{ $time }}"></i>
                    </td>
                </tr>
            @endforeach
            <tbody id="_tbody" class="no-borders"></tbody>
        </table>
        <table class="table no-borders no-margins">
            <tr>
                <td>
                    <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> </button>
                </td>
            </tr>
        </table>

        <div class="col-md-9"></div>
        <div class="col-md-3 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Gasto estimado total:</th>
                    <th width="50%">{{ $data['presupuesto'] }}</th>
                </tr>
            </table>
        </div>
    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
    </form>
</section>
<style>
    .select2-container {
        z-index: 99999 !important;
    }
    .btnmostrar:hover .btnhover{
        display: block;
    }
</style>
<script>
    $(".mySelect").select2();

    const totalCaracteres = 120;

    
    function validarUnidadCaracteres(input, id) {
        // Expresión regular que elimina caracteres especiales no permitidos
        input.value = input.value.replace(/[?¡#$%/\-,'"]/g, "");
    }

    function validarMetaCaracteres(input, id) {
        const max = totalCaracteres; // límite OSFEM

        // Expresión regular que elimina caracteres especiales no permitidos
        input.value = input.value.replace(/[?¡#$%/\-,'"]/g, "");

        const len = input.value.length;
        const contador = document.getElementById("contador_" + id);

        if (contador) {
            contador.textContent = `${len}/${max} caracteres`;

            if (len > max) {
                contador.style.color = "red";
                input.classList.add("is-invalid");
            } else {
                contador.style.color = "gray";
                input.classList.remove("is-invalid");
            }
        }
    }
    $(document).on("click",".btnagregarum",function(e){
        e.preventDefault();
        let id = $(this).attr("id");
        modalAvance("{{ URL::to('anteproyecto/addum') }}",{id:id},"Agregar nueva Unidad de Medida","40%");
    })
    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
        axios.get('{{ URL::to("anteproyecto/addpbrmctr") }}',{
            params : {}
        }).then(response => {
            $("#_tbody").append(response.data);
            asignarNumeracion();
        })
    }
    function asignarNumeracion(){
        $("input[name='numero[]']").each(function(indice, elemento) {
            $(elemento).val(indice+1);
        });
    }
    function clearDecimales(valor){
        let valorLimpio = valor.replace(/[^0-9.]/g, '');

        let partes = valorLimpio.split('.');
        if (partes.length === 2) {
            partes[1] = partes[1].substring(0, 2);
            valorLimpio = partes[0] + '.' + partes[1]; // corta lo extra
        }
        return valorLimpio;
    }
    function totalMeta(idrg) {
        
        let programado = $("#programado_"+idrg).val();
        
        if (!/^([0-9\.,])*$/.test(programado)){
            toastr.error("Programado, No es un número!");
            $("#programado_"+idrg).val("");
        }

        let alcanzado = $("#alcanzado_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(alcanzado)){
            toastr.error("Alcanzado, No es un número!");
            $("#alcanzado_"+idrg).val("");
        }

        let anual = $("#anual_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(anual)){
            toastr.error("Programado anual, No es un número!");
            $("#anual_"+idrg).val("");
        }

        let t1 = (programado == "" ? 0 : parseFloat(programado.replace(/[^0-9.]/g, '')));
        let t2 = (alcanzado == "" ? 0 : parseFloat(alcanzado.replace(/[^0-9.]/g, '')));
        let t3 = (anual == "" ? 0 : parseFloat(anual.replace(/[^0-9.]/g, '')));

        let absoluta = t3 - t2 
        let formateado = (absoluta % 1 === 0) ? parseInt(absoluta) : absoluta.toFixed(2);

        $("#absoluta_"+idrg).val(formateado);

        let porc = 0;
        if(t2 > 0 ){
            porc = ((t3 / t2 ) - 1 ) * 100;
        }
        $("#porcentaje_"+idrg).val(porc.toFixed(2));
    } 
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
                eliminarColumna(time);
            
            }
          })
    })
    function eliminarColumna(id){
        axios.delete('{{ URL::to("anteproyecto/pbrmctr") }}',{
            params : {id:id}
        }).then(response => {
            let row = response.data;
            if(row.status == "ok"){
                toastr.success(row.message);
                $("#tr_"+id).remove();
                asignarNumeracion();
            }else{
                toastr.warning(row.message);
            }
        })
    }
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('id', "{{ $id }}");
        $.ajax("{{ URL::to('anteproyecto/savepbrmc') }}", {
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
    });
</script>

@if(count($data['rowsMetas']) == 0)
    <script>
        agregarTr();
    </script>
@endif