<form id="saveInfo" method="post" class="form-horizontal">
<section class="table-resp">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .h-45{height:65px;}
    .c-white{color:white;}
    #table tr td,tr th{font-size:12px;padding-top:2px;padding-bottom:2px;}
    .border{border:1px solid #ececec;}
    .border-t{border-top:1px solid #ececec;}
    .s-8{font-size:12px;}
    .m-b-xs{margin-bottom:5px;}
    .m-t-sm{margin-top:10px;}
    .m-b-sm{margin-bottom:10px;}
    .text-top{vertical-align: text-top;}
    .p-2{padding-top:2px;padding-bottom:2px;}
</style>
<table class="table no-margins">
    <tr>
        <td width="10%" class="text-center no-borders">
            @if(!empty($row['header']['logo_izq']))
                <img src="{{ asset('mass/images/logos/'.$row['header']['logo_izq']) }}" width="70" height="60">
            @endif
        </td>
        <td class="no-borders text-center">
            <div class="s-8 text-center m-b-xs"><strong>SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</strong></div>
            <div class="s-8 text-center"><strong>DICTAMEN DE RECONDUCCIÓN Y ACTUALIZACIÓN PROGRAMÁTICA - PRESUPUESTAL PARA RESULTADOS</strong></div>
        </td>
    </tr>
</table>

<input type="hidden" class="form-control" id="txt_folio"> 

<table id="table" width="100%" cellspacing="0">
    <tr>
        <td width="50%"><strong>Tipo de Movimiento:</strong> Reconducción presupuestal</td>
        <td width="50%">
            <table id="table" width="100%" cellspacing="0">
                <tr>
                    <th>No. de Oficio:</th>
                    <td>
                        <input type="text" class="form-control" name="no_oficio" placeholder="No. de Oficio" required> 
                    </td>
                </tr>
               
                <tr>
                    <th>Fecha:</th>
                    <td>
                        <input type="text" class="form-control" name="fecha" placeholder="Fecha" value="" required> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="table" width="100%" cellspacing="0" class="m-t-sm">
    <tr>
        <th width="50%">
            <table width="100%">
                <tr>
                    <th class="bg-title">Identificación del Proyecto en el que se cancela o reduce.</th>
                </tr>
            </table>
        </th>
        <th width="50%">
            <table width="100%">
                <tr>
                    <th class="bg-title">Identificación del Proyecto en el que se asigna o se amplia</th>
                </tr>
            </table>
        </th>
    </tr>
</table>

<table id="table" width="100%">
    <tr>
        <td width="50%">
            <table id="table" width="100%" cellspacing="0" class="border bg-white">
                <tr>
                    <td width="20%" class="border-t">Dependencia General:</td>
                    <td width="70%" class="border-t">{{ $row['dep_int']['no_dep_gen'].' '.$row['dep_int']['dep_gen'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia Auxiliar:</td>
                    <td width="70%" class="border-t">{{ $row['dep_int']['no_dep_aux'].' '.$row['dep_int']['dep_aux'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Programa presupuestario:</td>
                    <td width="70%" class="border-t">{{ $row['dep_int']['no_programa'].' '.$row['dep_int']['programa'] }}</td>
                </tr>
                <tr>
                    <td width="100%" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $row['dep_int']['obj_programa'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Proyecto presupuestario:</td>
                    <td width="70%" class="border-t">{{ $row['dep_int']['no_proyecto'].' '.$row['dep_int']['proyecto'] }}</td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table id="table" width="100%" cellspacing="0" class="border bg-white">
                <tr>
                    <td width="20%" class="border-t">Dependencia General:</td>
                    <td width="70%" class="border-t">{{ $row['dep_ext']['no_dep_gen'].' '.$row['dep_ext']['dep_gen'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia Auxiliar:</td>
                    <td width="70%" class="border-t">{{ $row['dep_ext']['no_dep_aux'].' '.$row['dep_ext']['dep_aux'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Programa presupuestario:</td>
                    <td width="70%" class="border-t">{{ $row['dep_ext']['no_programa'].' '.$row['dep_ext']['programa'] }}</td>
                </tr>
                <tr>
                    <td width="100%" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $row['dep_ext']['obj_programa'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Proyecto presupuestario:</td>
                    <td width="70%" class="border-t">{{ $row['dep_ext']['no_proyecto'].' '.$row['dep_ext']['proyecto'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="table" width="100%" cellspacing="0" class="m-t-sm">
    <tr>
        <th width="50%">
            <table width="100%" cellspacing="0" class="border">
                <tr>
                    <th class="bg-title">Identificación de Recursos a nivel de Proyecto que se cancelan o se reducen.</th>
                </tr>
            </table>
        </th>
        <th width="50%">
            <table width="100%" cellspacing="0" class="border">
                <tr>
                    <th class="bg-title">Identificación de Recursos a nivel de Proyecto que se amplían o se asignan.</th>
                </tr>
            </table>
        </th>
    </tr>
</table>

<table id="table" width="100%" cellspacing="0">
    <tr>
        <th width="50%" style="vertical-align: text-top;">
                <table width="100%" cellspacing="0" class="border">
                    <tr>
                        <th rowspan="2" class="bg-title text-center">Clave</th>
                        <th rowspan="2" class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center" colspan="4">Presupuesto</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Autorizado</th>
                        <th class="bg-title text-center">Por ejercer</th>
                        <th class="bg-title text-center">Por cancelar o reducir</th>
                        <th class="bg-title text-center">Autorizado modificado</th>
                    </tr>
                    <tr>
                        <td class="s-8 bg-white text-center">{{ $row['dep_int']['no_proyecto'].' '.$row['dep_int']['clasificacion'] }}</td>
                        <td class="s-8 bg-white">{{ $row['dep_int']['proyecto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['dep_int']['totales']['presupuesto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['dep_int']['totales']['d_x_ejercer'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['importe'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['dep_int']['totales']['mod_d'] }}</td>
                    </tr>
                </table>
            </div>
        </th>
        <th width="50%" style="vertical-align: text-top;">
                <table width="100%" cellspacing="0" class="border">
                    <tr>
                        <th rowspan="2" class="bg-title text-center">Clave</th>
                        <th rowspan="2" class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center" colspan="4">Presupuesto</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Autorizado</th>
                        <th class="bg-title text-center">Ampliación y/o Reasignación</th>
                        <th class="bg-title text-center">Autorizado Modificado</th>
                    </tr>
                    <tr>
                        <td class="s-8 bg-white text-center">{{ $row['dep_ext']['no_proyecto'].' '.$row['dep_ext']['clasificacion'] }}</td>
                        <td class="s-8 bg-white">{{ $row['dep_ext']['proyecto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['dep_ext']['totales']['presupuesto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['importe'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $row['dep_ext']['totales']['mod_a'] }}</td>
                    </tr>
                </table>
        </th>
    </tr>
</table>

<table id="table" width="100%" cellspacing="0" class="m-t-sm">
    <tr>
        <th width="50%">
            <table width="100%">
                <tr>
                    <th class="bg-title">Metas de Actividad Programadas y alcanzadas del Proyecto a cancelar o Reducir.</th>
                </tr>
            </table>
        </th>
        <th width="50%">
            <table width="100%">
                <tr>
                    <th class="bg-title">Metas de Actividad Programadas y alcanzadas del Proyecto que se crea o incrementa.</th>
                </tr>
            </table>
        </th>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <td width="50%" class="text-top">
            <table id="table" width="100%" cellspacing="0" class="border">
                <tr>
                    <th class="bg-title" rowspan="2" style="height:80px;">Código</th>
                    <th class="bg-title" rowspan="2">Descripción</th>
                    <th class="bg-title" rowspan="2">Unidad de medida</th>
                    <th class="bg-title" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                    <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                </tr>
                <tr>
                    <th class="bg-title">Inicial</th>
                    <th class="bg-title">Avance</th>
                    <th class="bg-title">Modificada</th>
                    <th class="bg-title text-center" width="50">1</th>
                    <th class="bg-title text-center" width="50">2</th>
                    <th class="bg-title text-center" width="50">3</th>
                    <th class="bg-title text-center" width="50">4</th>
                </tr>
                <tr>
                    <td colspan="10" class="c-white bg-white">D</td>
                </tr>
            </table>
        </td>
        <td width="50%" class="text-top">
            <table id="table" width="100%" cellspacing="0" class="border">
                <tr>
                    <th class="bg-title" rowspan="2" style="height:80px;">Código</th>
                    <th class="bg-title" rowspan="2">Descripción</th>
                    <th class="bg-title" rowspan="2">Unidad de medida</th>
                    <th class="bg-title" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                    <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                </tr>
                <tr>
                    <th class="bg-title">Inicial</th>
                    <th class="bg-title">Avance</th>
                    <th class="bg-title">Modificada</th>
                    <th class="bg-title text-center" width="50">1</th>
                    <th class="bg-title text-center" width="50">2</th>
                    <th class="bg-title text-center" width="50">3</th>
                    <th class="bg-title text-center" width="50">4</th>
                </tr>
                <tr>
                    <td colspan="10" class="c-white bg-white">A</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <th colspan="3" class="text-left">Justificación</th>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <th class="text-left border bg-white p-xxs">De la cancelación o reducción de metas de actividad y/o recursos del Proyecto. (impacto o repercusión programática)</th>
    </tr>
    <tr>
        <td>
            <textarea name="texto1" class="form-control" rows="3" placeholder="De la cancelación o reducción de metas de actividad y/o recursos del Proyecto. (impacto o repercusión programática)" required></textarea>
        </td>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <th class="text-left border bg-white p-xxs">De creación o reasignación de metas de actividad y/o recursos al proyecto (Beneficio, Impacto, Repercusión programática).</th>
    </tr>
    <tr>
        <td>
            <textarea name="texto2" class="form-control" rows="3" placeholder="De creación o reasignación de metas de actividad y/o recursos al proyecto (Beneficio, Impacto, Repercusión programática)." required></textarea>
        </td>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <th class="text-left border bg-white">Identificación del Origen de los recursos.</th>
    </tr>
    <tr>
        <td>
            <textarea name="texto3" class="form-control" rows="3" placeholder="Identificación del Origen de los recursos." required></textarea>
        </td>
    </tr>
</table>

<table id="table" width="100%" class="m-t-sm">
    <tr>
        <td width="30%" class="text-center border bg-white">
            <div><strong>Elabora (Dep. General)</strong></div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div>
                <input type="text" value="{{ $row['footer']['dep_gen'] }}" name="firma1" class="form-control text-center fun no-borders" style="border-bottom:2px solid var(--border-color) !important;" placeholder="Ingresa Nombre" required>
            </div>
            <div><strong>Nombre y Firma</strong></div>
        </td>
        <th width="5%" class="text-center"></th>
        <td width="25%" class="text-center border bg-white">
            <div><strong>Vo. Bo. (Tesorería)</strong></div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div>
                <input type="text" value="{{ $row['footer']['tesorero'] }}" name="firma2" class="form-control text-center fun no-borders" style="border-bottom:2px solid var(--border-color) !important;" placeholder="Ingresa Nombre" required>
            </div>
            <div><strong>Nombre y Firma</strong></div>
        </td>
        <th width="5%" class="text-center"></th>
        <td width="25%" class="text-center border bg-white">
            <div><strong>Autorizó (Titular de la UIPPE o equivalente)</strong></div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div class="c-white">.</div>
            <div>
                <input type="text" value="{{ $row['footer']['uippe'] }}" name="firma3" class="form-control text-center fun no-borders" style="border-bottom:2px solid var(--border-color) !important;" placeholder="Ingresa Nombre" required>
            </div>
            <div><strong>Nombre y Firma</strong></div>
        </td>
    </tr>
</table>


<br>
<div class="text-center s-8"><strong>CUANDO LAS ADECUACIONES APLIQUEN PARA MODIFICAR PRESUPUESTO, ESTAS SE DEBEN DEFINIR A NIVEL DE PARTIDA PRESUPUESTARIA Y CAPÍTULO DE GASTO</strong></div>
<div class="text-center s-8"><strong>EN RELACIÓN ANEXA, ESTO NO APLICA PARA ADECUACIONES PROGRAMÁTICAS, ES DECIR PARA MODIFICACIÓN DE PROGRAMACIÓN DE METAS DE ACTIVIDAD</strong></div>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>


</section>
</form>
<script>
  $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de generar el PDF?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                formData.append("id", "{{ $id }}");
                    $.ajax("{{ URL::to($pageModule.'/generatepdfrec?k='.$token) }}", {
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
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
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
