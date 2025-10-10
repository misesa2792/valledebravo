<form id="formOchob" method="post" class="form-horizontal">
 
    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders" width="20%">ID MIR: </td>
                    <td class="no-borders c-text">{{ $id }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders" width="20%">PILAR DE DESARROLLO / EJE TRANSVERSAL: </td>
                    <td class="no-borders c-text">{{ $json->no_pilar.' '.$json->pilar }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">TEMA DE DESARROLLO: </td>
                    <td class="no-borders c-text">{{ $json->tema_desarrollo }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">PROGRAMA PRESUPUESTARIO:</td>
                    <td class="no-borders c-text">{{ $json->no_programa.' '.$json->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">PROYECTO PRESUPUESTARIO:</td>
                    <td class="no-borders c-text">{{ $json->no_proyecto.' '.$json->proyecto }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">OBJETIVO DEL PROGRAMA PRESUPUESTARIO:</td>
                    <td class="no-borders c-text">{{ $json->obj_programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">DEPENDENCIA GENERAL:</td>
                    <td class="no-borders c-text">{{ $json->no_dep_gen.' '.$json->dep_gen }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">DEPENDENCIA AUXILIAR:</td>
                    <td class="no-borders c-text">{{ $json->no_dep_aux.' '.$json->dep_aux }}</td>
                </tr>
    
            </table>
    
        </div>
    </div>
    
    <h3 class="text-center c-text-alt s-12">ESTRUCTURA DEL INDICADOR</h3>
    
    
    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders" width="15%">NOMBRE DEL INDICADOR:</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="nombre_indicador" value="{{ $json->nombre_indicador }}" class="form-control" placeholder="Nombre del indicador" required>
                    </td>
                </tr>

                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders" width="15%">INDICADOR POR CATÁLOGO:</td>
                    <td class="no-borders c-text" colspan="3">
                        <select name="idind_estrategicos" class="mySelect2 sltindicador">
                            <option value="">--Selecciona Formula--</option>
                            @foreach ($catIndEst as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->idind_estrategicos) selected @endif>{{ $f->codigo.'-'.$f->indicador }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">FÓRMULA DEL CÁLCULO:</td>
                    <td class="no-borders c-text" colspan="2">
                        <input type="text" name="formula" value="{{ $json->formula }}" class="form-control" placeholder="Fórmula de cálculo" required>
                    </td>
                    <td class="no-borders c-text" >
                        <select name="idmir_formula" class="mySelect2">
                            <option value="">--Selecciona Formula--</option>
                            @foreach ($rowsFormulas as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->idmir_formula) selected @endif>{{ $f->formula }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">INTERPRETACIÓN:</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="interpretacion" value="{{ $json->interpretacion }}" class="form-control" placeholder="Interpretación" required>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">DIMENSIÓN QUE ATIENDE:</td>
                    <td class="no-borders c-text">
                        <select name="iddimension_atiende" class="mySelect2" required>
                            <option value="">--Selecciona dimension que atiende--</option>
                            @foreach ($rowsDim as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->iddimension_atiende) selected @endif>{{ $f->dimension_atiende }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="no-borders" width="15%">FRECUENCIA DE MEDICIÓN:</td>
                    <td class="no-borders c-text" width="20%">
                        <select name="idfrecuencia_medicion" class="mySelect2" required>
                            <option value="">--Selecciona frecuencia de medición--</option>
                            @foreach ($rowsFrec as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->idfrecuencia_medicion) selected @endif>{{ $f->frec_medicion }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">FACTOR DE COMPARACIÓN:</td>
                    <td class="no-borders c-text">
                        <input type="text" name="factor" value="{{ $json->factor }}" class="form-control" placeholder="Factor de comparación" required>
                    </td>
                    <td class="no-borders" width="15%">TIPO DE INDICADOR:</td>
                    <td class="no-borders c-text" width="20%">
                        <select name="idtipo_indicador" class="mySelect2" required>
                            <option value="">--Selecciona tipo de indicador--</option>
                            @foreach ($rowsTipo as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->idtipo_indicador) selected @endif>{{ $f->tipo_indicador }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">DESCRIPCIÓN DEL FACTOR DE COMPARACIÓN:</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="desc_factor" value="{{ $json->desc_factor }}" class="form-control" placeholder="Descripción del factor de comparación" required>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">LINEA BASE:</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="linea" value="{{ $json->linea }}" class="form-control" placeholder="Línea base" required>
                    </td>
                </tr>

                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">AMBITO GEOGRAFICO:</td>
                    <td class="no-borders c-text" colspan="2">
                        <input type="text" name="ambito" class="form-control" value="{{ $json->ambito }}" placeholder="AMBITO GEOGRAFICO" required>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders">COBERTURA:</td>
                    <td class="no-borders c-text" colspan="2">
                        <input type="text" name="cobertura" class="form-control" value="{{ $json->cobertura }}" placeholder="COBERTURA" required>
                    </td>
                </tr>

            </table>
    
            <div class="col-md-4 no-padding bg-white">
                <div class="col-md-12 no-padding">
                    <table class="table no-margins">
                        <tr class="t-tr-s12 c-text-alt">
                            <td class="no-borders">Nivel de la MIR:</td>
                            <td class="no-borders c-text">
                                <input type="text" name="mir" value="{{ $json->mir }}" class="form-control" placeholder="Nivel de la MIR">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        <h3 class="col-md-12 text-center c-text-alt s-12">CALENDARIZACIÓN TRIMESTRAL</h3>

        <section class="col-md-12 no-padding" id="appeditpbrmb">
            <table class="table bg-white" v-if="variables.length > 0">
                <tr>
                    <th>ID</th>
                    <th>Nombre Corto</th>
                    <th>Nombre Largo</th>
                </tr>
                <tr v-for="v in variables">
                    <td>@{{ v.id }}</td>
                    <td>@{{ v.nombre_corto }}</td>
                    <td>@{{ v.nombre_largo }}</td>
                </tr>
            </table>
        </section>

        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <th width="10%" class="text-center">ID</th>
                <th width="10%" class="text-center">Nombre Corto</th>
                <th width="50%" class="text-center">Variables del Indicador</th>
                <th width="15%" class="text-center">Unidad de Medida</th>
                <th class="text-center">Tipo de Operación</th>
                <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
                <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
                <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
                <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
                <th class="c-white bg-primary text-center">Total Anual</th>
                <th width="20"></th>
            </tr>
            <tbody class="no-borders">
                @foreach ($rowsMetas as $m)
                    <tr class="t-tr-s12 c-text">
                        <td>
                            <input type="text" name="idind_estrategicos_reg[]" value="{{ $m->idind_estrategicos_reg }}" class="form-control no-borders" placeholder="Nombre Corto" required>
                        </td>
                        <td>{{ $m->nombre_corto }}</td>
                        <td>
                            <input type="hidden" name="idrg[]" value="{{ $m->id }}" required>
                            <input type="text" name="meta[]" value="{{ $m->meta }}" class="form-control no-borders" placeholder="Variables del indicador" required>
                        </td>
                        <td>
                            <input type="text" name="unidad_medida[]" value="{{ $m->unidad_medida }}" class="form-control no-borders" placeholder="Unidad de medida" required>
                        </td>
                        <td>
                            <select name="idtipo_operacion[]" class="form-control" id="tipo_{{ $m->id }}" onchange="totalMeta({{ $m->id }})"  required>
                                <option value="">--Selecciona tipo de operación--</option>
                                @foreach ($rowsOperacion as $f)
                                    <option value="{{ $f->id }}" @if($f->id == $m->idtipo_operacion) selected @endif>{{ $f->tipo }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="trim1[]" value="{{ $m->trim_1 }}" class="form-control no-borders" placeholder="Trim #1" id="trim1_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim2[]" value="{{ $m->trim_2 }}" class="form-control no-borders" placeholder="Trim #2" id="trim2_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim3[]" value="{{ $m->trim_3 }}" class="form-control no-borders" placeholder="Trim #3" id="trim3_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim4[]" value="{{ $m->trim_4 }}" class="form-control no-borders" placeholder="Trim #4" id="trim4_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="prog_anual[]" value="{{ $m->prog_anual }}" class="form-control no-borders" placeholder="Total anual" id="anual_{{ $m->id }}" readonly required>
                        </td>
                    </tr>
                @endforeach
                <tr class="t-tr-s12 c-text">
                    <td colspan="3"></td>
                    <td>
                        <select name="aplica1" class="form-control" required>
                            @foreach ($rowsAplica as $key=> $value)
                                <option value="{{ $key }}" @if($json->aplica1 == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="aplica2" class="form-control" required>
                            @foreach ($rowsAplica as $key=> $value)
                                <option value="{{ $key }}" @if($json->aplica2 == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="aplica3" class="form-control" required>
                            @foreach ($rowsAplica as $key=> $value)
                                <option value="{{ $key }}" @if($json->aplica3 == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="aplica4" class="form-control" required>
                            @foreach ($rowsAplica as $key=> $value)
                                <option value="{{ $key }}" @if($json->aplica4 == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
           
        </table>
            
        </div>
    </div>
    

    <article class="col-md-12">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th class="c-text-alt no-borders">DESCRIPCIÓN DE LA META ANUAL:</th>
            </tr>
            <tr class="t-tr-s14">
                <td>
                    <textarea name="descripcion_meta" rows="3" class="form-control no-borders" placeholder="Descripción de la Meta Anual" required>{{ $json->descripcion_meta }}</textarea>
                </td>
            </tr>
        </table> 
    </article>

    <article class="col-md-12">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th class="c-text-alt no-borders">MEDIOS DE VERIFICACIÓN:</th>
            </tr>
            <tr class="t-tr-s14">
                <td>
                    <textarea name="medios_verificacion" rows="3" class="form-control no-borders" placeholder="Medios de Verificación" required>{{ $json->medios_verificacion }}</textarea>
                </td>
            </tr>
        </table> 
    </article>

    <article class="col-md-12">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s14">
                <th class="c-text-alt no-borders">METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</th>
            </tr>
            <tr class="t-tr-s14">
                <td>
                    <textarea name="metas_actividad" rows="3" class="form-control no-borders" placeholder="Metas de Actividad Relacionadas y Avance" required>{{ $json->metas_actividad }}</textarea>
                </td>
            </tr>
        </table> 
    </article>
    
    <br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" class="btn btn-sm btn-primary btnsavepbrmb"> <i class="fa fa-save"></i> Guardar</button>
    </article>
    </form>
    
    <script>
    $(".mySelect2").select2();
    $(".sltindicador").on("change", function(e) {
        e.preventDefault();
        let id = $(this).val();
        axios.get('{{ URL::to("indicadores/indest") }}',{
            params : {id:id}
        }).then(response => {
            let row = response.data;
            if(row.status == 'ok'){
                editpbrmb.variables = row.data;
            }
        })
    })
    function totalMeta(idrg) {
        let tipo = $("#tipo_"+idrg).val();

        let trim1 = $("#trim1_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim1)){
            toastr.error("Trim. #1, No es un número!");
            $("#trim1_"+idrg).val("");
        }
        let trim2 = $("#trim2_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim2)){
            toastr.error("Trim. #2, No es un número!");
            $("#trim2_"+idrg).val("");
        }
        let trim3 = $("#trim3_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim3)){
            toastr.error("Trim. #3, No es un número!");
            $("#trim3_"+idrg).val("");
        }
        let trim4 = $("#trim4_"+idrg).val();
        if (!/^([0-9\.])*$/.test(trim4)){
            toastr.error("Trim. #4, No es un número!");
            $("#trim4_"+idrg).val("");
        }
        
        let t1 = trim1 == "" ? 0 : parseFloat(trim1);
        let t2 = trim2 == "" ? 0 : parseFloat(trim2);
        let t3 = trim3 == "" ? 0 : parseFloat(trim3);
        let t4 = trim4 == "" ? 0 : parseFloat(trim4);
        let anual = t1+t2+t3+t4;

        if(tipo == "1" || tipo == "4"){
            $("#anual_"+idrg).val(anual);
        }else if(tipo == "2" || tipo == "3"){
            let constante = 0;
            if(t1 > 0){
                constante = t1;
            }else if(t2 > 0){
                constante = t2;
            }else if(t3 > 0){
                constante = t3;
            }else{
                constante = t4;
            }
            $("#anual_"+idrg).val(constante);
        }
    } 
    
    $("#formOchob").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("formOchob"));
            $.ajax("{{ URL::to('indicadores/editindicador?k='.$token) }}", {
                type: 'post',
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".btnsavepbrmb").prop("disabled",true).html(mss_spinner + '...Guardando...');
                },success: function(res){
                    let row = JSON.parse(res);
                    if(row.status == 'ok'){
                        toastr.success(row.message);
                        $("#sximo-modal").modal("toggle");
                        pbrmb.rowsPbrmb();
                    }else{
                        toastr.error(row.message);
                    }
                    $(".btnsavepbrmb").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
                }, error : function(err){
                    toastr.error(mss_tmp.error);
                    $(".btnsavepbrmb").prop("disabled",false).html('<i class="fa fa-save"></i> Guardar');
                }
            });
        })
        var editpbrmb = new Vue({
            el:'#appeditpbrmb',
            data:{
                variables : [],
            },methods:{
               
            }
        });
    </script>