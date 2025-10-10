
<template id="comp_img">
    <div class="item-file-list item-files no-padding" :id="'imgs_'+rows.idri">
        <a :href="rows.url" target="_blank" class="relatedFile" style="height:70px;">
            <img :src="rows.ico" border="0" class="img-related b-r-5"/>
        </a>
        <div style="height:auto;">
            @if($accesos == 0)
            <a href="" class="btn btn-xs btn-white" @click.prevent="destroyFile(rows.idri)"> <i class="fa fa-trash-o var"></i> </a>
            @endif
        </div>
    </div>
</template>

    <form id="saveMetaMes" method="post" class="form-horizontal ">
        <input type="hidden" name="idmes" value="{{ $idmes }}">
        <input type="hidden" name="trim" value="{{ $trim }}">
        <input type="hidden" name="idrg" value="{{ $idrg }}">
        <div class="col-md-12" id="app_mes">


            <div class="col-md-12 m-t-md m-b-md">
                <div class="tab-container">
                    <ul class="nav nav-tabs">
                      <li :class="checkMenu == 1 ? 'active' : 'no-active' " @click.prevent="changeMenuValue(1)"><a href="#"> <i class="fa icon-plus-circle2 s-14"></i> &nbsp;&nbsp; Registrar</a></li>
                      <li :class="checkMenu == 2 ? 'active' : 'no-active' " @click.prevent="changeMenuValue(2)"><a href="#"><i class="fa fa-picture-o s-14"></i> &nbsp;&nbsp; Evidencia</a></li>
                    </ul>
                </div>
            </div>


            <article class="tab-pane active use-padding m-t-md" v-if="checkMenu == 1">
                <div class="col-md-8">
                    <div class="col-md-12 b-r-10 bg-white p-xs">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="font-bold">Descripción de acción: </div>
                                <p>{{ $row->meta }}</p>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="font-bold">Unidad de medida:</div>
                                <p>{{ $row->unidad_medida }}</p>
                            </div>
                            <div class="col-md-6">
                                <div class="font-bold">Mes:</div>
                                <p>{{ $mes }}</p>
                            </div>
                            
                        </div>
                    </div>
    
                    <div class="col-md-12 m-t-md b-r-10 bg-white p-md">
                        @if($accesos == 0)
                            <div class="col-md-12">
                                <form id="saveMetaMes" method="post" class="form-horizontal">

                                    <div class="font-bold">Cantidad:</div>
                                    <input type="text" name="cantidad" class="form-control" placeholder="Ingresa Cantidad" required>
                    
                                    <br>
                
                                    <div class="font-bold">Evidencia:</div>
                                    <input type="file" name="evidencia[]" id="file_evidencia" class="form-control" accept=".jpeg,.jpg,.png,.xlsx,.xls,.pdf,.txt,.ppt,.pptx,.doc,.docx,.csv" multiple>
                
                                    <div class="col-md-12 text-center m-t-md">
                                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline" ><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
                                        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </form>
                            </div>
                        @else 
                            <div class="text-center c-danger">El periodo establecido para realizar la captura de avance ha finalizado. </div>
                        @endif

                    </div>
    
                    
                </div>
    
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="col-md-12 text-center c-text-alt b-r-10 p-xs {{ $color }} c-white">
                            <h3>Trimestre</h3>
                            <h3>#{{ $trim }}</h3>
                        </div>
                    </div>
    
                    @if($accesos == 0)
                        <div class="col-md-12 m-t-md ">
                            <div class="col-md-12 b-r-10 bg-white">
                                <header class="col-md-12 p-xs s-14 b-b-gray">
                                    <div class="col-md-12 text-center font-bold">
                                        Documentos permitidos
                                    </div>
                                </header>
                                <div class="col-md-12">
        
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
                        </div>
                    @endif
                </div>
            </article>

            <article class="tab-pane active use-padding m-t-md" v-if="checkMenu == 2">
                <div class="col-md-8">
                    <div class="col-md-12 b-r-10 bg-white p-xs">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="font-bold">Descripción de acción: </div>
                                <p>{{ $row->meta }}</p>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="font-bold">Unidad de medida:</div>
                                <p>{{ $row->unidad_medida }}</p>
                            </div>
                            <div class="col-md-6">
                                <div class="font-bold">Mes:</div>
                                <p>{{ $mes }}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="col-md-12 text-center c-text-alt b-r-10 p-xs {{ $color }} c-white">
                            <h3>Trimestre</h3>
                            <h3>#{{ $trim }}</h3>
                        </div>
                    </div>
                </div>

                <section class="col-md-12 m-t-md">
                           <div class="col-md-12 no-padding" v-if="rowMes.length > 0">
                            <div class="col-md-12 p-xs bg-white b-r-c m-b-md" v-for="row in rowMes">
                                <article class="col-sm-12 col-md-12 col-lg-12 line-texto com no-padding" >
                                    <div class="col-md-12 no-padding b-b-gray" >
                                        <div class="col-md-10 c-blue text-left font-bold s-16">@{{ row.cant }}</div>
                                        @if($accesos == 0)
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-trash-o c-danger cursor s-16 tips" @click.prevent="destroyRegistro(row.idrm)" title="Eliminar"></i>
                                                &nbsp;&nbsp;&nbsp;
                                                <i class="fa fa-edit c-blue cursor s-16 tips" @click.prevent="editarRegistro(row.idrm)" title="Editar"></i>
                                            </div>
                                        @endif
                                    </div>
                                </article>

                                <article class="col-sm-12 col-md-12 col-lg-12 no-padding text-justify " >
                                    <div class="col-md-12 no-padding m-t-xs">
                        
                                           <template v-if="row.rowsImgs.length > 0 ">
                                                <comp-img v-for="(row , key) in row.rowsImgs" :rows="row" :idkey="key"></comp-img>
                                           </template>
                        
                                            <template v-else>
                                                <div class="col-md-12 text-center c-text-alt-50 p-xs">
                                                    <div>
                                                        <i class="fa fa-picture-o s-30"></i>
                                                    </div>
                                                    <h3>No hay evidencia!</h3>
                                                </div>
                                            </template>
                        
                                        <div class="col-md-12 text-right">
                                            <div class="c-text s-12">@{{ row.usuario }}</div>
                                            <p class="c-text-alt s-10">@{{ row.fecha_rg }} @{{ row.hora_rg }}</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                           </div>

                            <div class="col-md-12 bg-white b-r-c m-b-md p-xs" v-else>
                                <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
                                <h2 class="text-center com">No se encontraron Registros!</h2>
                            </div>
                    </div>
                </section>

            </article>
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
    var meses = new Vue({
        el:'#app_mes',
        data:{
            menu:1,
            rowMes : []
        },
        computed: {
          checkMenu(){
              return this.menu;
          }
      },
        methods:{
            changeMenuValue(no){
                this.menu = no;
                if(no == 2){
                    this.rowsMeses();
                }
            },
            rowsMeses(){
                axios.get('{{ URL::to("reporte/gallery") }}',{
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
                        axios.delete('{{ URL::to("reporte/gallery") }}',{
                            params : {idrm:idrm}
                        }).then(response => {
                            let row = response.data;
                            if(row.status == "ok"){
                                toastr.success(row.message);
                                meses.rowsMeses();
                                metas.rowsMetas();
                            }
                        })
                    }
                })
            },editarRegistro(idrm){
                modalAvance("{{ URL::to('reporte/mesesedit') }}",{idrm:idrm, trim:"{{ $trim }}"},"Editar Registro","40%");
            }
        },
        mounted(){
            $(".tips").tooltip();
        }
    });
    const compImg = Vue.component("comp-img",{
			template : "#comp_img",
			props : ['rows','idkey'],
            methods:{
                destroyFile(idri){
                    swal({
                        title : 'Estás seguro de eliminar el archivo?',
                        icon : 'warning',
                        buttons : true,
                        dangerMode : true
                    }).then((willDelete) => {
                        if(willDelete){
                            axios.delete('{{ URL::to("reporte/galleryfile") }}',{
                                params : {idri:idri}
                            }).then(response => {
                                let row = response.data;
                                if(row.status == "ok"){
                                    toastr.success(row.message);
                                    meses.rowsMeses();
                                    metas.rowsMetas();
                                }
                            })
                        }
                    })
                }
            }
	})
    $("#saveMetaMes").on("submit", function (e) {
    e.preventDefault();

    const archivos = $('#file_evidencia')[0].files;
    const limiteMB = 20; // Límite de tamaño en MB
    let archivoExcedeLimite = false;

    // Validar la cantidad de archivos
    if (archivos.length > 5) {
        toastr.error("El límite permitido es de 5 archivos como evidencia por cada guardado!");
        return; // Detener la ejecución
    }

    // Validar el tamaño de cada archivo
    for (let i = 0; i < archivos.length; i++) {
        const archivo = archivos[i];
        const tamañoMB = archivo.size / (1024 * 1024); // Convertir a MB

        if (tamañoMB > limiteMB) {
            toastr.error(`El archivo "${archivo.name}" excede el límite de ${limiteMB} MB.`);
            archivoExcedeLimite = true;
        }
    }

    // Si algún archivo excede el límite, detener el envío
    if (archivoExcedeLimite) {
        return;
    }

    // Si todo está bien, proceder con el envío del formulario
    var formData = new FormData(document.getElementById("saveMetaMes"));
    $.ajax("{{ URL::to('reporte/savemeses?idrg='.$idrg) }}", {
        type: 'post',
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
             $(".btnsave").prop("disabled",true).html(btnSaveSpinner);
        },
        success: function (res) {
            let row = JSON.parse(res);
            if (row.status == 'ok') {
                $("#sximo-modal").modal("toggle");
                metas.rowsMetas();
                toastr.success(row.message);
            } else {
                toastr.error(mss_tmp.error);
            }
            $(".btnsave").prop("disabled", false).html(btnSave);
        },
        error: function (err) {
            toastr.error(mss_tmp.error);
            $(".btnsave").prop("disabled", false).html(btnSave);
        }
    });
});
</script>

<style>
    #sximo-modal-content{padding: 0px !important;}
</style>