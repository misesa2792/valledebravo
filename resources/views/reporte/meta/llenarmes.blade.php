
<template id="comp_img">
    <div class="item-file-list item-files no-padding" :id="'imgs_'+rows.idri">
        <a :href="rows.url" target="_blank" class="relatedFile" style="height:60px;">
            <img :src="rows.ico" border="0" class="img-related b-r-10"/>
        </a>
    </div>
</template>

    <form id="saveMetaMes" method="post" class="form-horizontal ">
        <input type="hidden" name="idmes" value="{{ $idmes }}">
        <div class="col-md-12" id="app_mes">

            
            <section class="col-md-12 text-center m-t-md" v-if="access_trim == 1">
                <div class="alert alert-danger fade in block-inner">
                    <i class="icon-cancel-circle"></i> El periodo establecido para realizar la captura de avance ha finalizado.
                </div>
            </section>

            <section class="col-md-8">
                <article class="col-md-12 m-t-md no-padding">
                    <div class="col-md-12 no-padding bg-white b-r-5 overflow-h box-shadow">
                        @if($idmes == 1 || $idmes == 2 || $idmes == 3)
                            <header class="col-md-12 p-xs s-16 b-b-gray bg-yellow-meta c-white">
                                <div class="col-md-10 no-padding d-table">
                                    <div class="d-table-cell p-l-10">
                                        Periodo Trimestral:
                                        <div>01 Enero al 31 de Marzo {{ $row->anio }}</div>
                                    </div>
                                </div>
                            </header>
                        @elseif($idmes == 4 || $idmes == 5 || $idmes == 6)
                            <header class="col-md-12 p-xs s-16 b-b-gray bg-green-meta c-white">
                                <div class="col-md-10 no-padding d-table">
                                    <div class="d-table-cell p-l-10">
                                        Periodo Trimestral:
                                        <div>01 Abril al 30 de Junio {{ $row->anio }}</div>
                                    </div>
                                </div>
                            </header>
                        @elseif($idmes == 7 || $idmes == 8 || $idmes == 9)
                            <header class="col-md-12 p-xs s-16 b-b-gray bg-blue-meta c-white">
                                <div class="col-md-10 no-padding d-table">
                                    <div class="d-table-cell p-l-10">
                                        Periodo Trimestral:
                                        <div>01 Julio al 30 de Septiembre {{ $row->anio }}</div>
                                    </div>
                                </div>
                            </header>
                        @elseif($idmes == 10 || $idmes == 11 || $idmes == 12)
                            <header class="col-md-12 p-xs s-16 b-b-gray bg-red-meta c-white">
                                <div class="col-md-10 no-padding d-table">
                                    <div class="d-table-cell p-l-10">
                                        Periodo Trimestral:
                                        <div>01 Octubre al 31 de Diciembre {{ $row->anio }}</div>
                                    </div>
                                </div>
                            </header>
                        @endif
                        <div class="col-md-12 m-t-md m-b-md">
                            <table class="table table-bordered">
                                <tr class="t-tr-s16">
                                    <td class="text-right c-text-alt">Mes : </td>
                                    <td class="c-text">{{ $mes }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td class="text-right c-text-alt">Descripción de acción : </td>
                                    <td class="c-text">{{ $row->meta }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td class="text-right c-text-alt">Unidad de medida : </td>
                                    <td class="c-text">{{ $row->unidad_medida }}</td>
                                </tr>
                                    <tr>
                                        <td class="s-16 text-right c-text-alt">Cantidad : </td>
                                        <td>
                                            <input type="text" name="cantidad" class="form-control" placeholder="Ingresa Cantidad" @if($access_trim == 1) disabled @endif required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="s-16 text-right c-text-alt">Evidencia : </td>
                                        <td>
                                            <input type="file" name="evidencia[]" class="form-control" @if($access_trim == 1) disabled @endif accept=".jpeg,.jpg,.png,.xlsx,.xls,.pdf,.txt,.ppt,.pptx,.doc,.docx,.csv" multiple>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </article>
            </section>

            <section class="col-md-4">
                <article class="col-md-12 m-t-md no-padding">
                    <div class="col-md-12 no-padding bg-white b-r-5 overflow-h box-shadow">
                        <header class="col-md-12 p-xs s-20 b-b-gray">
                            <div class="col-md-10 no-padding d-table">
                                <div class="col-md-12 text-center font-bold s-14">
                                    Documentos permitidos
                                </div>
                            </div>
                        </header>
                        <div class="col-md-12 m-t-md m-b-md s-14">
                            <table class="table">
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa fa-picture-o c-blue"></i></td>
                                    <td class="no-borders">Imágenes <i class="c-text-alt">(.png , .jpg, .jpeg)</i></td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa icon-file-pdf c-danger"></i></td>
                                    <td class="no-borders">PDF</td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa icon-file-word c-blue"></i></td>
                                    <td class="no-borders">Archivos de Word <i class="c-text-alt">(.docx , .doc)</i></td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="icon-file6 c-app"></i></td>
                                    <td class="no-borders">Archivos <i class="c-text-alt">(.csv)</i></td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa icon-file-excel c-success"></i></td>
                                    <td class="no-borders">Archivos de Excel <i class="c-text-alt">(.xlsx , .xls)</i></td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa icon-file-powerpoint c-yellow"></i></td>
                                    <td class="no-borders">Archivos de PowerPoint <i class="c-text-alt">(.pptx , .ppt)</i></td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="no-borders"><i class="fa icon-file5 c-text-alt"></i></td>
                                    <td class="no-borders">Archivos de Texto Plano <i class="c-text-alt">(.txt)</i></td>
                                </tr>
                            </table>

                            <h4 class='m-t-md m-b-md c-danger s-10'>Tamaño máximo permitido por archivo es de 20MB</h4>


                        </div>
                    </div>
                </article>
            </section>

            <section class="col-md-12 m-t-md">
                <div class="col-md-12 no-padding bg-white b-r-5 overflow-h box-shadow">
                    <header class="col-md-12 p-xs s-20 b-b-gray">
                        <div class="col-md-10 no-padding d-table">
                            <div class="d-table-cell p-l-10">Registro de movimientos</div>
                        </div>
                    </header>
                    <div class="col-md-12 m-t-md m-b-md">

                        <table class="table table-bordered" v-if="rowMes.length > 0">
                            <tr class="t-tr-s16 c-text-alt">
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Usuario que registro</th>
                                <th class="text-center" width="100">Cantidad</th>
                                <th class="text-center">Evidencia</th>
                            </tr>
                            <tr v-for="row in rowMes" class="t-tr-s16" :id="'trm_'+row.idrm">
                                <td class="text-center">@{{ row.fecha_rg }}</td>
                                <td class="text-center">@{{ row.hora_rg }}</td>
                                <td class="text-center">@{{ row.usuario }}</td>
                                <td class="text-center">@{{ row.cant }}</td>
                                <td>
                                    <comp-img v-for="(row , key) in row.rowsImgs" :rows="row" :idkey="key" :permiso="access_trim"></comp-img>
                                </td>
                            </tr>
                        </table>
            
                        <div class="col-md-12" v-else>
                            <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
                            <h2 class="text-center com">No se encontraron Registros!</h2>
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </form>

<style>
        .h-30{height: 30px;}
		.item-file-list{height: 80px !important;border:none;width:60px;}
        .swal-title {font-size: 14px;}
</style>
<script>
   

    const idrg = "{{ $idrg }}";
    const idmes = "{{ $idmes }}";
    const ACCESS_TRIM = "{{ $access_trim }}";
    var meses = new Vue({
        el:'#app_mes',
        data:{
            rowMes : [],
            access_trim: 0
        },
        methods:{
            rowsMeses(){
                axios.get('{{ URL::to("reporte/registros") }}',{
                    params : {idrg:idrg,idmes:idmes}
                }).then(response => {
                    this.rowMes = response.data;
                })
            },
            destroyRegistro(idrm){
                swal({
                    title : 'Estás seguro de eliminar el registro?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("reporte/destroyregistro") }}',{
                            params : {idrm:idrm}
                        }).then(response => {
                            let row = response.data;
                            if(row.success == "ok"){
                                toastr.success(mss_tmp.delete);
                                meses.rowsMeses();
                                metas.rowsMetas();
                            }
                        })
                    }
                })
            },editarRegistro(idrm){
                modalAvance("{{ URL::to('reporte/editreg') }}",{idrm:idrm},"Editar Registro","40%");
            },
            sizeFile(){
                // Obtener el elemento input
                const input = document.querySelector('input[type="file"]');

                // Agregar el evento change
                input.addEventListener('change', () => {
                // Obtener la lista de archivos seleccionados
                const files = input.files;
                
                // Iterar sobre la lista de archivos
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        // Validar el tamaño del archivo
                        if (file.size > 52428800) {
                        // Mostrar un mensaje de error
                        swal({
                            title : 'El archivo ' + file.name + ' es demasiado grande. El tamaño máximo permitido es 50 MB.',
                            icon : 'warning',
                        })
                        // Limpiar el valor del input
                        input.value = '';
                        return; // salir del loop si se encuentra un archivo grande
                        }
                    }
                });
            }
        },
        mounted(){
            this.access_trim = ACCESS_TRIM;
            $(".tips").tooltip();
            this.sizeFile();
            this.rowsMeses();
        }
    });
    const compImg = Vue.component("comp-img",{
			template : "#comp_img",
			props : ['rows','idkey','permiso'],
            methods:{
                destroyFile(idri){
                    swal({
                        title : 'Estás seguro de eliminar el archivo?',
                        icon : 'warning',
                        buttons : true,
                        dangerMode : true
                    }).then((willDelete) => {
                        if(willDelete){
                            axios.get('{{ URL::to("reporte/destroyfile") }}',{
                                params : {idri:idri}
                            }).then(response => {
                                let row = response.data;
                                if(row.success == "ok"){
                                    toastr.success(mss_tmp.deleteFile);
                                    meses.rowsMeses();
                                    metas.rowsMetas();
                                }
                            })
                        }
                    })
                }
            }
	})
     $("#saveMetaMes").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveMetaMes"));
        $.ajax("{{ URL::to('reporte/savemetames?idrg='.$idrg) }}", {
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
                if(row.success == 'ok'){
                    $("#sximo-modal").modal("toggle");
                    metas.rowsMetas();
                    toastr.success(mss_tmp.success);
                }else{
                    toastr.error(mss_tmp.error);
                }
                $(".btnsave").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>

<style>
    #sximo-modal-content{padding: 0px !important;}
</style>