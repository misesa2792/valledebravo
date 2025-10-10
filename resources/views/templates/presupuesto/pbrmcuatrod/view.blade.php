<form id="saveInfo" method="post" class="form-horizontal">

<table class="table">
    <tr>
        <td class="no-borders" width="10%" rowspan="3">
            @if(!empty($row['header']['logo_izq']))
                <img src="{{ asset('mass/images/logos/'.$row['header']['logo_izq']) }}" width="70" height="60">
            @endif
        </td>
        <td class="no-borders text-center font-bold s-16 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
        <td class="no-borders" width="10%" rowspan="3"> </td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN DE EGRESOS MUNICIPAL {{ $row['header']['anio'] }}</td>
    </tr>
    <tr>
        <td class="no-borders text-center font-bold s-16 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
    </tr>
</table>


<div class="col-md-12">
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14 c-text-alt">
                <td>PbRM-04d</td>
                <th class="text-center">CARATULA DE PRESUPUESTO DE EGRESOS</th>
            </tr>
        </table>
    </div>
    <div class="col-md-8 no-padding">
    </div>
</div>

<div class="col-md-12 m-b-md">
    <div class="col-md-8"></div>
    <div class="col-md-4 text-right">
        DEL 01 DE ENERO AL 31 DE DICIEMBRE DE {{ $row['header']['anio'] }}
    </div>
</div>
<div class="col-md-12">
    <table class="table">
        <tr class="no-borders t-tr-s14 c-text-alt bg-white">
            <td colspan="3"></td>
            <td colspan="3">
                <table class="table no-margins">
                     <tr class="no-borders t-tr-s14 c-text-alt">
                        <th class="no-borders" width="10%">PROYECTO:</th>
                        <th class="no-borders">
                            <table class="table table-bordered no-margins" style="width:50px !important;">
                                <tr>
                                    <th height="30" class="text-center">
                                        @if($row['header']['tipo'] == 2 || $row['header']['tipo'] == 3 )
                                        X
                                        @endif
                                    </th>
                                </tr>
                            </table>
                        </th>
                        <th class="no-borders" width="10%">DEFINITIVO:</th>
                        <th class="no-borders">
                            <table class="table table-bordered no-margins" style="width:50px !important;" >
                                <tr>
                                    <th height="30" class="text-center">
                                        @if($row['header']['tipo'] == 1 )
                                        X
                                        @endif
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="no-borders t-tr-s14 c-text-alt bg-white">
            <td colspan="3">
                <table class="table no-margins">
                    <tr class="no-borders t-tr-s14 c-text-alt">
                       <th class="no-borders" width="20%">ENTE PUBLICO:</th>
                       <th class="no-borders">{{ $row['header']['municipio'] }}</th>
                   </tr>
               </table>
            </td>
            <td colspan="3">
                <table class="table no-margins">
                     <tr class="no-borders t-tr-s14 c-text-alt">
                        <th class="no-borders"  width="5%">No.</th>
                        <th class="no-borders">{{ $row['header']['no_municipio'] }}</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="no-borders t-tr-s14 c-text-alt">
            <th class="text-center bg-white" colspan="2">CAPÍTULO</th>
            <th class="text-center bg-white">CONCEPTO</th>
            <th class="text-center bg-white">AUTORIZADO {{ $row['header']['anio'] -1 }}</th>
            <th class="text-center bg-white">EJERCIDO {{ $row['header']['anio'] -1 }}</th>
            <th class="text-center bg-white">PRESUPUESTADO {{ $row['header']['anio'] }}</th>
        </tr>

        <tr class="no-borders t-tr-s14 c-text-alt">
            <td class="bg-white text-left" colspan="2">8210</td>
            <td class="bg-white">PRESUPUESTO DE EGRESOS APROBADO</td>
            <td class="text-center bg-white">{{ $row['autorizado'] }}</td>
            <td class="text-center bg-white">{{ $row['ejercido'] }}</td>
            <td class="text-right bg-white">{{ $row['presupuesto'] }}</td>
        </tr>

        @foreach ($row['rowsRegistros'] as $p)
        <tr class="no-borders t-tr-s14 c-text-alt">
            <td class="text-right bg-white" colspan="2">{{ $p['no_capitulo'] }}</td>
            <td class="bg-white">{{ $p['capitulo'] }}</td>
            <td class="text-center bg-white">{{ $p['autorizado'] }}</td>
            <td class="text-center bg-white">{{ $p['ejercido'] }}</td>
            <td class="text-right bg-white">{{ $p['presupuesto'] }}</td>
        </tr>
       @endforeach
       
    </table>
</div>

<br>


<br>
<div class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">PRESIDENTE MUNICIPAL</div>
                <br>
                <input type="text" name="firma1" value="" class="form-control border-b-1-dashed text-center c-black" placeholder="TITULAR DE LA DEPENDENCIA" required>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">SÍNDICO MUNICIPAL</div>
                <br>
                <input type="text" name="firma2" value="" class="form-control border-b-1-dashed text-center c-black" placeholder="TESORERO MUNICIPAL" required>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">SECRETARIO DEL AYUNTAMIENTO</div>
                <br>
                <input type="text" name="firma3" value="{{ $row['footer']['titular_secretario'] }}" class="form-control border-b-1-dashed text-center c-black" placeholder="TITULAR DE LA UIPPE O SU EQUIVALENTE" required>
            </td>
         </tr>

         <tr class="t-tr-s14 c-text">
            <th class="no-borders" colspan="5"></th>
         </tr>

         <tr class="t-tr-s14 c-text">
            <td width="30%" class="text-center no-borders"></td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center bg-white no-borders">
                <div class="font-bold c-text-alt">TESORERO MUNICIPAL</div>
                <br>
                <input type="text" name="firma4" value="{{ $row['footer']['titular_tesoreria'] }}" class="form-control border-b-1-dashed text-center c-black" placeholder="TESORERO MUNICIPAL" required>
            </td>
            <th class="no-borders"></th>
            <td width="30%" class="text-center no-borders">
               <br>
               <br>
                <table class="table">
                    <tr>
                        <th>FECHA DE ELABORACIÓN:</th>
                        <td>
                            <input type="text" name="fecha" value="{{ date('Y-m-d') }}" class="form-control date border-b-1-dashed c-black" placeholder="0000-00-00" required>
                        </td>
                    </tr>
                </table>
            </td>
         </tr>
    </table>

    
</div>

<br>
<article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
</article>

</form>

<script>
    $('.date').datepicker({format: 'yyyy-mm-dd'});
    
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
                    $.ajax("{{ URL::to($pageModule.'/generarpdf?k='.$token) }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".btnsave").prop("disabled",true).html(mss_spinner + " Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);

                            if(row.status == "ok"){
                                proyectos.rowsProjects();
                	            $('#sximo-modal').modal("toggle");
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                            }else{
                                toastr.warning("Error al generar el PDF!");
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