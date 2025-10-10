<form enctype="multipart/form-data" id="saveInfo" method="post">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">

    <div class="col-md-12">
        <div class="col-md-6">
            <h2 class="text-center">Avance de Obras o Acciones 
                    @if($trim == 1 ) Primer 
                    @elseif($trim == 2) Segundo
                    @elseif($trim == 3) Tercer
                    @elseif($trim == 4) Cuarto
                    @endif Trimestre</h2>

            <table class="table table-bordered">
                <tr>
                    <th>Concepto</th>
                    <th>Descripción</th>
                </tr>
                <tr>
                    <td>Año</td>
                    <td>{{ $data['year'] }}</td>
                </tr>
                <tr>
                    <td>Fecha de inicio</td>
                    <td>
                        <input type="text" name="fi" class="form-control" placeholder="Fecha de inicio">
                    </td>
                </tr>
                <tr>
                    <td>Fecha de conclusión</td>
                    <td>
                        <input type="text" name="ff" class="form-control" placeholder="Fecha de conclusión">
                    </td>
                </tr>
                <tr>
                    <td>Municipio</td>
                    <td>
                        <input type="text" name="municipio" value="Toluca" class="form-control" placeholder="Municipio">
                    </td>
                </tr>
                <tr>
                    <td>Todo el municipio</td>
                    <td>
                        <input type="text" name="todo_mun" value="Si" class="form-control" placeholder="Todo el municipio">
                    </td>
                </tr>
                <tr>
                    <td>Localidad</td>
                    <td>
                        <input type="text" name="localidad" class="form-control" placeholder="Localidad">
                    </td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td>
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                    </td>
                </tr>
                <tr>
                    <td>Beneficiarios</td>
                    <td>
                        <input type="text" name="beneficiarios" class="form-control" placeholder="Beneficiarios">
                    </td>
                </tr>
                <tr>
                    <td>Costo</td>
                    <td>
                        <input type="text" name="costo" class="form-control" placeholder="Costo">
                    </td>
                </tr>
                <tr>
                    <td>Área ejecutora</td>
                    <td>
                        <input type="text" name="area_eje" value="" class="form-control" placeholder="Área ejecutora">
                    </td>
                </tr>
                <tr>
                    <td>Tipo de actividad</td>
                    <td>
                        <input type="text" name="tipo_act" value="Plan de Desarrollo Municipal" class="form-control" placeholder="Tipo de actividad">
                    </td>
                </tr>
                <tr>
                    <td>Eje cambio/Eje transversal</td>
                    <td>{{ $data['pilares'] }}</td>
                </tr>
                <tr>
                    <td>Línea de acción</td>
                    <td>{{ $data['no_linea_accion'] }}: {{ $data['linea_accion'] }}</td>
                </tr>
                <tr>
                    <td>Meta PDM 25-27</td>
                    <td>{{ $data['no_meta_pdm'] }}: {{ $data['meta_pdm'] }}</td>
                </tr>
                <tr>
                    <td>Meta PbRM</td>
                    <td>Meta {{ $data['no_meta'] }}: {{ $data['meta'] }}</td>
                </tr>
                <tr>
                    <td>Cantidad realizada</td>
                    <td>
                        <input type="text" name="cantidad_realizada" class="form-control" placeholder="Cantidad realizada">
                    </td>
                </tr>
            </table>

        </div>



    </div>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Generar PDF</button>
    </article>
</form>
<script>
    $(".mySelect").select2();
  
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
          formData.append('idy', "{{ $idy }}");
          formData.append('idmeta', "{{ $idmeta }}");
          formData.append('trim', "{{ $trim }}");
        $.ajax("{{ URL::to($pageModule.'/pdf') }}", {
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
                    window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
					appTema.loadData();
                }else{
                    toastr.error(row.message);
                }
                $(".btnsave").prop("disabled",false).html('<i class="fa fa-save"></i> Generar PDF');
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html('<i class="fa fa-save"></i> Generar PDF');
            }
        });
    });
</script>