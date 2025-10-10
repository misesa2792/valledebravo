<section class="row" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="c-text-alt">
                    <td>Municipio: </td>
                    <th class="text-center">{{ $data['institucion'] }}</th>
                    <td>No.</td>
                    <th class="text-center">{{ $data['no_institucion'] }}</th>
                </tr>
                <tr class="c-text-alt">
                    <td>PbRM-01e</td>
                    <th colspan="3" class="text-center">
                        <div>Matriz de Indicadores para Resultados por</div>
                        <div>Programa presupuestario y Dependencia General</div>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-md-4 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data['year'] }}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12">

            <table class="table table-bordered bg-white">
                <tr class="c-text-alt">
                   <th width="15%"></th>
                   <th width="100" class="text-center">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center" id="td_no_programa"></td>
                    <td>
                        <input type="hidden" name="no_matriz" id="no_matriz" value="0">
                        <select name="idprograma" class="mySelect full-width" id="sltprograma" required>
                            <option value="">--Selecciona Programa--</option>
                            @foreach ($rowsPogramas as $v)
                            <option value="{{ $v->id }}" 
                                    data-no_matriz="{{ $v->no_matriz }}" 
                                    data-no="{{ "'".$v->no_programa }}" 
                                    data-obj="{{ $v->obj_programa }}" 
                                    data-no_pilar="{{ "'".$v->no_pilar }}"
                                    data-pilar="{{ $v->pilares }}"
                                    data-no_tema="{{ "'".$v->no_tema }}"
                                    data-tema="{{ $v->tema_desarrollo }}"
                                    >{{ $v->no_programa.' '.$v->programa.' Matriz #'.$v->no_matriz }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="c-text-alt">
                    <th>Obletivo del Programa Presupuestario:</th>
                    <td></td>
                    <td id="proy_obj" colspan="2"></td>
                </tr>
                <tr class="c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
                <tr class="c-text-alt">
                    <th>Eje de Cambio o Eje transversal:</th>
                    <td class="text-center" id="td_no_pilar"></td>
                    <td id="td_pilar" colspan="2"></td>
                </tr>
                <tr class="c-text-alt">
                    <th>Tema de Desarrollo: </th>
                    <td class="text-center" id="td_no_tema"></td>
                    <td id="td_tema" colspan="2"></td>
                </tr>
            </table>

            <div class="alert alert-danger" role="alert">
                <strong>Notas importantes</strong>
                <ul class="c-text-alt s-10" style="margin-bottom:8px;">
                    
                    <li>
                    <strong>Programa único en <span class="c-danger">PbRM-01e</span></strong>
                    <ul>
                        <li>
                        En el formato <strong>PbRM-01e</strong> solo se asigna <u>un programa único por dependencia general</u>.
                        </li>
                        <li>
                        Esto asegura que no existan duplicados de matrices dentro del <strong>PbRM-01e</strong>.
                        </li>
                    </ul>
                    </li>
                    
                    <li>
                    <strong>Asignación y personalización de indicadores en <span class="c-danger">PbRM-01d</span></strong>
                    <ul>
                        <li>
                        La definición de indicadores corresponde al formato <strong>PbRM-01d</strong>.
                        </li>
                        <li>
                        Un mismo indicador puede asignarse a varios proyectos y personalizarse según corresponda.
                        </li>
                        <li>
                        Esto permite flexibilidad y evita inconsistencias entre proyectos dependientes de una misma matriz.
                        </li>
                    </ul>
                    </li>

                    <li>
                    <strong>Proyecto y dependencia auxiliar</strong>
                    <ul>
                        <li>
                        Los campos de <em>proyecto</em> y <em>dependencia auxiliar</em> son obligatorios en <strong>PbRM-01d</strong>.
                        </li>
                        <li>
                        Esto permite que algunos indicadores sean alimentados por otro proyecto o dependencia auxiliar.
                        </li>
                    </ul>
                    </li>

                </ul>
                </div>
    </div>

    <article class="col-sm-12 col-md-12" id="appPbrme">

        <div class="col-md-12 no-padding" v-if="loading">
            <table class="table table-bordered bg-white">
                <tr>
                    <th rowspan="2" width="100"></th>
                    <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
                    <th colspan="4" class="text-center">Indicadores</th>
                    <th rowspan="2"  class="text-center">Medios de verificación</th>
                    <th rowspan="2"  class="text-center">Supuestos</th>
                </tr>
                <tr>
                    <th class="text-center" width="30"></th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Fórmula</th>
                    <th class="text-center">Frecuencia y Tipo</th>
                </tr>

                <tr class="success">
                    <td class="bg-white text-center-middle">Fin</td>
                    <td>
                        <i class="fa fa-check-square s-16 c-blue"></i>
                        <div class="d-none">
                            <input type="radio" name="fin" :value="rowsFin.idprograma_reg" checked required>
                        </div>
                        @{{ rowsFin.descripcion }}
                    </td>
                    <td>@{{ rowsFin.mir }}</td>
                    <td>@{{ rowsFin.indicador }}</td>
                    <td>@{{ rowsFin.formula }}</td>
                     <td class="text-center">
                        <div>@{{ rowsFin.frecuencia }}</div>
                        <div>@{{ rowsFin.tipo_indicador }}</div>
                    </td>
                    <td>@{{ rowsFin.medios }}</td>
                    <td>@{{ rowsFin.supuestos }}</td>
                </tr>

                <tr class="success">
                    <td class="bg-white text-center-middle">Propósito</td>
                    <td>
                        <i class="fa fa-check-square s-16 c-blue"></i>

                        <div class="d-none">
                            <input type="radio" name="proposito" :value="rowsProposito.idprograma_reg" checked required>
                        </div>
                        @{{ rowsProposito.descripcion }}
                    </td>
                    <td>@{{ rowsProposito.mir }}</td>
                    <td>@{{ rowsProposito.indicador }}</td>
                    <td>@{{ rowsProposito.formula }}</td>
                    <td class="text-center">
                        <div>@{{ rowsProposito.frecuencia }}</div>
                        <div>@{{ rowsProposito.tipo_indicador }}</div>
                    </td>
                    <td>@{{ rowsProposito.medios }}</td>
                    <td>@{{ rowsProposito.supuestos }}</td>
                </tr>

                <tr>
                    <td :rowspan="rowsComponente.length + 1" class="text-center-middle">Componentes</td>
                </tr>

                <tr v-for="c in rowsComponente" :key="c.idprograma_reg" :class="c.estatus ? 'success' : 'danger'">
                    <td>
                        <i :class="'fa fa-check-square s-16 ' + (c.estatus ? 'c-blue' : 'c-danger')"></i>
                        
                        <div class="d-none">
                            <input type="checkbox" name="componentes[]" :value="c.idprograma_reg" :checked="c.estatus" > 
                        </div>
                        @{{ c.descripcion }}
                    </td>
                    <td>@{{ c.mir }}</td>
                    <td>@{{ c.indicador }}</td>
                    <td>@{{ c.formula }}</td>
                    <td class="text-center">
                        <div>@{{ c.frecuencia }}</div>
                        <div>@{{ c.tipo_indicador }}</div>
                    </td>
                    <td>@{{ c.medios }}</td>
                    <td>@{{ c.supuestos }}</td>
                </tr>
                <tr>
                    <td :rowspan="rowsActividad.length + 1" class="text-center-middle">Actividades</td>
                </tr>
                <tr v-for="c in rowsActividad" :key="c.idprograma_reg" :class="c.estatus ? 'success' : 'danger'">
                    <td>
                        <input type="checkbox" name="actividades[]" :value="c.idprograma_reg" v-model="actividadesSeleccionadas" @change="onActividadChange(c)">
                        @{{ c.descripcion }}
                    </td>
                    <td>@{{ c.mir }}</td>
                    <td>@{{ c.indicador }}</td>
                    <td>@{{ c.formula }}</td>
                    <td class="text-center">
                        <div>@{{ c.frecuencia }}</div>
                        <div>@{{ c.tipo_indicador }}</div>
                    </td>
                    <td>@{{ c.medios }}</td>
                    <td>@{{ c.supuestos }}</td>
                </tr>
            </table>
        </div>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave" style="margin-left:10px"><i class="fa fa-save"></i> Guardar </button>
    </article>

    </article>
    <article class="col-sm-12 col-md-12" id="resPrograma"></article>
    
    </form>
</section>
<style>

.select2-container {
    z-index: 99999 !important;
}
</style>
<script>

    const appPbrme = Vue.createApp({
            data() {
                    return {
                        rowsFin: [],
                        rowsProposito: [],
                        rowsComponente: [],
                        rowsActividad: [],
                        actividadesSeleccionadas: [],
                        loading: false
                    };
                },
            methods: {
                rowsProjects(idprograma, no_matriz) {
                    axios.get('{{ URL::to("anteproyecto/matriz") }}', {
                        params: {idprograma:idprograma,idy:"{{ $idy }}",type:"{{ $type }}",id:"{{ $id }}", no_matriz: no_matriz}
                    }).then(response => {
                        this.rowsFin = [];
                        this.rowsProposito = [];
                        this.rowsComponente = [];
                        this.rowsActividad = [];
                        
                        this.rowsFin = response.data.data.fin;
                        this.rowsProposito = response.data.data.proposito;
                        this.dataMatrizComponente(response.data.data.componente);
                        this.dataMatrizActividad(response.data.data.actividad);
                    }).catch(error => {
                    });
                },onActividadChange(actividad){

                    // Alternar estatus local de la actividad
                    actividad.estatus = !actividad.estatus;

                    // Obtener el ID del componente al que pertenece la actividad
                    const idComponente = actividad.idprograma_reg_rel;

                    // Verifica si hay alguna actividad del mismo componente seleccionada
                    const hayRelacionadasSeleccionadas = this.rowsActividad.some(a =>
                        a.idprograma_reg_rel === idComponente &&
                        this.actividadesSeleccionadas.includes(a.idprograma_reg)
                    );

                    // Buscar y actualizar el componente correspondiente
                    const componente = this.rowsComponente.find(c => c.idprograma_reg === idComponente);
                    if (componente) {
                        componente.estatus = hayRelacionadasSeleccionadas;
                    }

                },dataMatrizComponente(rows) {
                    rows.forEach(c => {
                        let row = c;
                        row.estatus = false;
                        this.rowsComponente.push(row);
                    });
                },dataMatrizActividad(rows) {
                    rows.forEach(c => {
                        let row = c;
                        row.estatus = false;
                        this.rowsActividad.push(row);
                    });
                }
            }
        });

    const vmpbrme = appPbrme.mount('#appPbrme');

    $('.mySelect').select2({
        dropdownParent: $('#sximo-modal')
    });

   
   
    $("#sltprograma").on("change", function(e) {
        
        //Simula un click para cerrar y no bloquear el modal
        $('#sltprograma').select2('close');

        let obj = $(this).find(':selected').data('obj');
        let no_pilar = $(this).find(':selected').data('no_pilar');
        let pilar = $(this).find(':selected').data('pilar');
        let tema = $(this).find(':selected').data('tema');
        let no_tema = $(this).find(':selected').data('no_tema');
        let no_programa = $(this).find(':selected').data('no');
        let no_matriz = $(this).find(':selected').data('no_matriz');

        $("#no_matriz").val(no_matriz);

        let idprograma = $(this).val();
        $("#proy_obj").empty().html(obj);
        $("#td_pilar").empty().html(pilar);
        $("#td_no_pilar").empty().html(no_pilar);
        $("#td_no_tema").empty().html(no_tema);
        $("#td_tema").empty().html(tema);
        $("#td_no_programa").empty().html(no_programa);

        /*
        // $("#sltproyecto").empty().html('<option value="">--Selecciona Proyecto--</option>');
        rowsProjects.forEach(function(project) {
            if(project.idprograma == idprograma){
                $("#sltproyecto").append('<option value="'+project.id+'" >'+project.no_proyecto+' '+project.proyecto+'</option>');
            }
        });*/

        vmpbrme.rowsProjects(idprograma, no_matriz);
        vmpbrme.loading = true

        /*axios.get('{{ URL::to("anteproyecto/matriz") }}',{
            params : {idprograma:idprograma,idy:"{{ $idy }}",type:"{{ $type }}",id:"{{ $id }}"}
        }).then(response => {
            $("#resPrograma").empty().append(response.data);
        })*/

        

    });

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de guardar?',
        icon : 'warning',
        buttons: {
            cancel: {
            text: "No, Cancelar",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true,
            },
            confirm: {
            text: "Sí, guardar",
            value: true,
            visible: true,
            className: "btn btn-danger",
            closeModal: true
            }
        },
        dangerMode : true,
		closeOnClickOutside: false
        }).then((willDelete) => {
            if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    formData.append('type', "{{ $type }}");
                    formData.append('idy', "{{ $idy }}");
                    formData.append('id', "{{ $id }}");
                    $.ajax("{{ URL::to('anteproyecto/savepbrme') }}", {
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