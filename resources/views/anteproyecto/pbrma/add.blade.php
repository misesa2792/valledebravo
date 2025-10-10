<section class="table-resp">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-10 no-padding"></div>
        <div class="col-md-2 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data['year'] }}</th>
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
                    <td class="text-center">PbRM-01a</td>
                    <th colspan="3" class="text-center">
                        <div>Programa Anual</div>
                        <div>Dimensión Administrativa del Gasto</div>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-md-1 no-padding"></div>
        <div class="col-md-7 no-padding">
            <table class="table table-bordered bg-white" >
                <tr class="t-tr-s12 c-text-alt">
                   <th width="15%"></th>
                   <th class="text-center" width="100">Clave</th>
                   <th class="text-center">Denominación</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Programa presupuestario: </th>
                    <td id="proy_no"></td>
                    <td>
                        <select name="idprograma" class="mySelect full-width" id="sltprograma" required>
                            <option value="">--Selecciona Programa--</option>
                            @foreach ($rowsPogramas as $v)
                            <option value="{{ $v->id }}">{{ $v->no_programa.' '.$v->programa }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th class="text-right">Dependencia General:</th>
                    <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <article class="col-sm-12 col-md-12" id="resPrograma" style="min-height:500px;"></article>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>

    </form>
</section>

<script>
    $(".mySelect").select2();

    $("#sltprograma").on("change", function(e) {
        $("#resPrograma").html(mss_tmp.load);
        axios.get('{{ URL::to("anteproyecto/programa") }}',{
            params : {idprograma:$(this).val(),idy:"{{ $idy }}",type:"{{ $type }}",id:"{{ $id }}"}
        }).then(response => {
            $("#resPrograma").empty().append(response.data);
        })
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
                    formData.append('iddg', "{{ $data['iddep_gen'] }}");
                    $.ajax("{{ URL::to('anteproyecto/savepbrma') }}", {
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