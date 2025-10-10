<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $data['anio'] }}</th>
            </tr>
        </table>
    </div>
</div>
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
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="c-text-alt">
                <th>Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="c-text-alt">
                <th>Objetivo del Programa Presupuestario: </th>
                <td></td>
                <td>{{ $data['obj_programa'] }}</td>
            </tr>
            <tr class="c-text-alt">
                <th>Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
             <tr class="c-text-alt">
                <th>Eje de Cambio o Eje transversal:</th>
                <td class="text-center">{{ $data['no_pilar'] }}</td>
                <td>{{ $data['pilar'] }}</td>
            </tr>
             <tr class="c-text-alt">
                <th>Tema de Desarrollo:</th>
                <td class="text-center">{{ $data['no_tema'] }}</td>
                <td>{{ $data['tema'] }}</td>
            </tr>
        </table>
    </div>
</div>


<br>
<form id="saveInfoEditar" method="post" class="form-horizontal">

    <article class="col-sm-12 col-md-12" id="appPbrmeEdit">
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
                        @{{ rowsFin.descripcion }}
                    </td>
                    <td>@{{ rowsFin.codigo }}</td>
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
                        @{{ rowsProposito.descripcion }}
                    </td>
                    <td>@{{ rowsProposito.codigo }}</td>
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

                <tr v-for="c in rowsComponente" :key="c.idprograma_reg" :class="c.checked ? 'success' : 'danger'">
                    <td>
                        <i :class="'fa fa-check-square s-16 ' + (c.checked ? 'c-blue' : 'c-danger')"></i>
                        
                        <div class="d-none">
                            <input type="checkbox" name="componentes[]" :value="c.idprograma_reg" :checked="c.checked" > 
                        </div>
                        @{{ c.descripcion }}
                    </td>
                    <td>@{{ c.codigo }}</td>
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
                <tr v-for="c in rowsActividad" :key="c.idprograma_reg" :class="c.checked ? 'success' : 'danger'">
                    <td>
                        <input type="checkbox" name="actividades[]" :value="c.idprograma_reg" :checked="c.checked" v-model="actividadesSeleccionadas" @change="onActividadChange(c)">
                        @{{ c.descripcion }}
                    </td>
                    <td>@{{ c.codigo }}</td>
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
    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave" style="margin-left:10px"><i class="fa fa-save"></i> Guardar </button>
    </article>

</form>


<style>
#sximo-modal .modal-dialog {
  max-height: 90%;
  overflow-y: auto !important;
}

#sximo-modal .modal-body {
  max-height: 80vh;
  overflow-y: auto !important;
}
.select2-container {
    z-index: 99999 !important;
}
</style>
<script>
    const appPbrmeEdit = Vue.createApp({
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
            rowsProjects(id) {
                axios.get('{{ URL::to("anteproyecto/editmatriz") }}', {
                    params: {id:id}
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
                actividad.checked = !actividad.checked;

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
                    componente.checked = hayRelacionadasSeleccionadas;
                }

            },dataMatrizComponente(rows) {
                rows.forEach(c => {
                    let row = c;
                    this.rowsComponente.push(row);
                });
            },dataMatrizActividad(rows) {
                rows.forEach(c => {
                    this.rowsActividad.push(c);
                    if (c.checked) {
                        this.actividadesSeleccionadas.push(c.idprograma_reg);
                    }
                });
            }
        },
        mounted(){
            this.rowsProjects("{{$id}}");
        }
    });

    const vmpbrmeEdit = appPbrmeEdit.mount('#appPbrmeEdit');

    $("#saveInfoEditar").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de editar la matriz?',
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
            text: "Sí, editar",
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
                var formData = new FormData(document.getElementById("saveInfoEditar"));
                    formData.append('no_matriz', "{{ $no_matriz }}");
                    formData.append('idprograma', "{{ $idprograma }}");
                    $.ajax("{{ URL::to('anteproyecto/editarpbrme?id='.$id) }}", {
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