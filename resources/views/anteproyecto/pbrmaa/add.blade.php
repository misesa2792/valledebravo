<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">
    
    <div class="col-md-12">
        <div class="col-md-8 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data['year'] }}</th>
                </tr>
            </table>
        </div>
    </div>
   
    <div class="col-md-12">
        <div class="col-md-5 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td>Municipio: </td>
                    <th class="text-center">{{ $data['institucion'] }}</th>
                    <td>No.</td>
                    <th class="text-center">{{ $data['no_institucion'] }}</th>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td>PbRM-02a</td>
                    <th colspan="3" class="text-center">
                        <div>Calendarización de Metas</div>
                        <div>de Actividad por Proyecto</div>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-md-1 no-padding"></div>
        <div class="col-md-6 no-padding">
            <table class="table border-gray bg-white">
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
            </table>
        </div>
    </div>

    <article class="col-sm-12 col-md-12">
        <table class="table table-bordered no-margins bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <th rowspan="3" width="40" class="text-center">Código</th>
                <th rowspan="3" width="20%" class="text-center">Descripción de las Metas de Actividad </th>
                <th rowspan="3" class="text-center">Unidad de Medida </th>
                <th rowspan="3" class="text-center bg-primary">
                    Cantidad Programada Anual
                    <div>PbRM-01c</div>
                </th>
                <th rowspan="3" class="text-center bg-success c-white">
                    Cantidad Programada Anual
                    <div>PbRM-02a</div>
                </th>
                <th colspan="8" class="text-center">Calendarización de Metas Físicas</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th colspan="2" class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
                <th colspan="2" class="c-white bg-green-meta text-center">Segundo Trimestre</th>
                <th colspan="2" class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
                <th colspan="2" class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="bg-gray text-center">Abs.</th>
                <th class="bg-gray text-center">%</th>
                <th class="bg-gray text-center">Abs.</th>
                <th class="bg-gray text-center">%</th>
                <th class="bg-gray text-center">Abs.</th>
                <th class="bg-gray text-center">%</th>
                <th class="bg-gray text-center">Abs.</th>
                <th class="bg-gray text-center">%</th>
            </tr>
            <tbody id="_tbody" class="no-borders">
                @foreach ($data['rowsMetas'] as $r)
                {{--*/
                        $time = $r->id;
                    /*--}}
                <tr class="bg-white t-tr-s12">
                    <td class="c-text-alt text-center">{{ $r->codigo }}</td>
                    <td class="c-text-alt">{{ $r->meta }}</td>
                    <td class="c-text-alt text-center">{{ $r->unidad_medida }}</td>
                    <td class="c-text-alt">
                        <input type="text" value="{{ $r->c_anual }}" class="form-control c-blue-meta no-borders form-control-ses" name="canual[]" id="canual_{{ $time }}" placeholder="PbRM-01c" required readonly>
                    </td>
                    <td id="tda_{{$time}}">
                        <input type="hidden" class="form-control" name="idaa[]" value="{{ $time }}">
                        <input type="text" value="{{ $r->aa_anual }}" class="form-control c-blue-meta no-borders form-control-ses" name="anual[]" id="anual_{{ $time }}" placeholder="Cant. Prog. Anual" required readonly>
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_trim1 }}" class="form-control c-yellow-meta no-borders form-control-ses" name="trim1[]" id="trim1_{{ $time }}" placeholder="Trimestre #1" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_porc1 }}" class="form-control c-yellow-meta no-borders form-control-ses text-center" name="porc1[]" id="porc1_{{ $time }}" placeholder="%" required readonly>
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_trim2 }}" class="form-control c-green-meta no-borders form-control-ses" name="trim2[]" id="trim2_{{ $time }}" placeholder="Trimestre #2" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_porc2 }}" class="form-control c-green-meta no-borders form-control-ses text-center" name="porc2[]" id="porc2_{{ $time }}" placeholder="%" required readonly>
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_trim3 }}" class="form-control c-blue-meta no-borders form-control-ses" name="trim3[]" id="trim3_{{ $time }}" placeholder="Trimestre #3" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_porc3 }}" class="form-control c-blue-meta no-borders form-control-ses text-center" name="porc3[]" id="porc3_{{ $time }}" placeholder="%" required readonly>
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_trim4 }}" class="form-control c-red-meta no-borders form-control-ses" name="trim4[]" id="trim4_{{ $time }}" placeholder="Trimestre #4" required onKeyUp="totalMeta({{ $time }})">
                    </td>
                    <td>
                        <input type="text" value="{{ $r->aa_porc4 }}" class="form-control c-red-meta no-borders form-control-ses text-center" name="porc4[]" id="porc4_{{ $time }}" placeholder="%" required readonly>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </article>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
    </form>
</section>

<script>
    function totalMeta(idrg) {
        let trim1 = $("#trim1_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(trim1)){
            toastr.error("Trim. #1, No es un número!");
            $("#trim1_"+idrg).val("");
        }
        
        let trim2 = $("#trim2_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(trim2)){
            toastr.error("Trim. #2, No es un número!");
            $("#trim2_"+idrg).val("");
        }
        
        let trim3 = $("#trim3_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(trim3)){
            toastr.error("Trim. #3, No es un número!");
            $("#trim3_"+idrg).val("");
        }
        
        let trim4 = $("#trim4_"+idrg).val();
        if (!/^([0-9\.,])*$/.test(trim4)){
            toastr.error("Trim. #4, No es un número!");
            $("#trim4_"+idrg).val("");
        }

        let t1 = (trim1 == "" ? 0 : parseFloat(trim1.replace(/[^0-9.]/g, '')));
        let t2 = (trim2 == "" ? 0 : parseFloat(trim2.replace(/[^0-9.]/g, '')));
        let t3 = (trim3 == "" ? 0 : parseFloat(trim3.replace(/[^0-9.]/g, '')));
        let t4 = (trim4 == "" ? 0 : parseFloat(trim4.replace(/[^0-9.]/g, '')));

        let anual = t1+t2+t3+t4;

        let c_anual = $("#canual_"+idrg).val();

        if(anual > c_anual){
             $("#tda_" + idrg).css('background', 'var(--color-danger)');
        }else if(anual == c_anual){
             $("#tda_" + idrg).css('background', 'var(--color-success)');
        }else{
             $("#tda_" + idrg).css('background', 'var(--color-danger)');
        }
        
        $("#anual_"+idrg).val(anual);

        let tanual = (anual == "" ? 0 : parseFloat(anual));
        //Porcentaje
        let porc1 = (t1/tanual)*100;
        let porc2 = (t2/tanual)*100;
        let porc3 = (t3/tanual)*100;
        let porc4 = (t4/tanual)*100;
        $("#porc1_"+idrg).val(porc1.toFixed(2));
        $("#porc2_"+idrg).val(porc2.toFixed(2));
        $("#porc3_"+idrg).val(porc3.toFixed(2));
        $("#porc4_"+idrg).val(porc4.toFixed(2));
    } 
   
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('id', "{{ $id }}");
        $.ajax("{{ URL::to('anteproyecto/savepbrmaa') }}", {
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
