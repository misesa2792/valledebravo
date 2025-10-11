<form id="formOchob" method="post" class="form-horizontal">
 
     <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th width="15%">Pilar/Eje Transversal: </th>
                    <td width="80" class="text-center">{{ $json->no_pilar }}</td>
                    <td>{{ $json->pilar }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Tema de Desarrollo: </th>
                    <td class="text-center"></td>
                    <td>{{ $json->tema_desarrollo }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center">{{ $json->no_programa }}</td>
                    <td>{{ $json->programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto: </th>
                    <td class="text-center">{{ $json->no_proyecto }}</td>
                    <td>{{ $json->proyecto }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Objetivo del programa presupuestario: </th>
                    <td></td>
                    <td>{{ $json->obj_programa }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $json->no_dep_gen }}</td>
                    <td>{{ $json->dep_gen }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td class="text-center">{{ $json->no_dep_aux }}</td>
                    <td>{{ $json->dep_aux }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h3 class="text-center c-text-alt s-12">ESTRUCTURA DEL INDICADOR</h3>
    
    
    <div class="col-md-12">
        <div class="col-md-12 no-padding">
            <table class="table bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right" width="15%">Nombre del Indicador</td>
                    <td class="no-borders c-text" colspan="3">{{ $json->indicador }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Fórmula de Cálculo</td>
                    <td class="no-borders c-text" colspan="2">{{ $json->form_larga }}</td>
                    <td class="no-borders c-text" >{{ $json->formula }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Interpretación</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="interpretacion" value="{{ $json->interpretacion }}" class="form-control border-b-1-dashed c-black" placeholder="Interpretación" required>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Dimensión que Atiende</td>
                    <td class="no-borders c-text">
                        <select name="iddimension_atiende" class="form-control" required>
                            <option value="">--Selecciona dimension que atiende--</option>
                            @foreach ($rowsDim as $f)
                                <option value="{{ $f->id }}" @if($f->id == $json->iddimension_atiende) selected @endif>{{ $f->dimension_atiende }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="no-borders text-right" width="15%">Frecuencia de Medición</td>
                    <td class="no-borders c-text" width="20%">{{ $json->frecuencia }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Factor de Comparación</td>
                    <td class="no-borders c-text">
                        <input type="text" name="factor" value="{{ $json->factor }}" class="form-control border-b-1-dashed c-black" placeholder="Factor de comparación" required>
                    </td>
                    <td class="no-borders text-right" width="15%">Tipo de Indicador</td>
                    <td class="no-borders c-text" width="20%">{{ $json->tipo_indicador }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Descripción del Factor de Comparación</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="desc_factor" value="{{ $json->desc_factor }}" class="form-control border-b-1-dashed c-black" placeholder="Descripción del factor de comparación" required>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Línea Base</td>
                    <td class="no-borders c-text" colspan="3">
                        <input type="text" name="linea" value="{{ $json->linea }}" class="form-control border-b-1-dashed c-black" placeholder="Línea base" required>
                    </td>
                </tr>

                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Ambito Geográfico</td>
                    <td class="no-borders c-text" colspan="2">
                        <input type="text" name="ambito" class="form-control border-b-1-dashed c-black" value="{{ $json->ambito }}" placeholder="AMBITO GEOGRAFICO">
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <td class="no-borders text-right">Cobertura</td>
                    <td class="no-borders c-text" colspan="2">
                        <input type="text" name="cobertura" class="form-control border-b-1-dashed c-black" value="{{ $json->cobertura }}" placeholder="COBERTURA">
                    </td>
                </tr>

            </table>
    
            <div class="col-md-4 no-padding bg-white">
                <div class="col-md-12 no-padding">
                    <table class="table no-margins">
                        <tr class="t-tr-s12 c-text-alt">
                            <td class="no-borders">Nivel de la MIR:</td>
                            <td class="no-borders c-text">{{ $json->mir }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        <h3 class="col-md-12 text-center c-text-alt s-12">CALENDARIZACIÓN TRIMESTRAL</h3>


        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <th width="10%" class="text-center">Nombre Corto</th>
                <th width="25%" class="text-center">Variables del Indicador</th>
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
                @foreach ($rowsMetas as $kev => $m)
                    <tr class="t-tr-s12 c-text">
                        <td>{{ $m->nombre_corto }}</td>
                        <td>
                            <input type="hidden" name="idind_estrategicos_reg[]" value="{{ $m->idind_estrategicos_reg }}" class="form-control no-borders" placeholder="Nombre Corto" required>
                            <input type="hidden" name="idrg[]" value="{{ $m->id }}" required>
                            <input type="text" name="meta[]" value="{{ $m->meta }}" class="form-control no-borders" placeholder="Variables del indicador" required>
                        </td>
                        <td>
                            <input type="text" name="unidad_medida[]" value="{{ $m->unidad_medida }}" class="form-control border-b-1-dashed c-black" placeholder="Unidad de medida" required>
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
                            <input type="text" name="trim1[{{ $kev }}]" value="{{ $m->trim_1 }}" class="form-control no-borders" placeholder="Trim #1" id="trim1_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim2[{{ $kev }}]" value="{{ $m->trim_2 }}" class="form-control no-borders" placeholder="Trim #2" id="trim2_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim3[{{ $kev }}]" value="{{ $m->trim_3 }}" class="form-control no-borders" placeholder="Trim #3" id="trim3_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="trim4[{{ $kev }}]" value="{{ $m->trim_4 }}" class="form-control no-borders" placeholder="Trim #4" id="trim4_{{ $m->id }}" onKeyUp="totalMeta({{ $m->id }})" required>
                        </td>
                        <td>
                            <input type="text" name="prog_anual[{{ $kev }}]" value="{{ $m->prog_anual }}" class="form-control no-borders" placeholder="Total anual" id="anual_{{ $m->id }}" readonly required>
                        </td>
                    </tr>
                @endforeach
                <tr class="t-tr-s12 c-text">
                    <td colspan="4"></td>

                    <td class="text-center" id="td_aplica1">
                        <input type="hidden" name="aplica1" value="{{ $json->aplica1 }}" id="aplica1" class="form-control no-borders c-black" placeholder="%">
                        <span id="txt_aplica1"></span>
                    </td>
                    <td class="text-center" id="td_aplica2">
                        <input type="hidden" name="aplica2" value="{{ $json->aplica2 }}" id="aplica2" class="form-control no-borders c-black" placeholder="%">
                        <span id="txt_aplica2"></span>
                    </td>
                    <td class="text-center" id="td_aplica3">
                        <input type="hidden" name="aplica3" value="{{ $json->aplica3 }}" id="aplica3" class="form-control no-borders c-black" placeholder="%">
                        <span id="txt_aplica3"></span>
                    </td>
                    <td class="text-center" id="td_aplica4">
                        <input type="hidden" name="aplica4" value="{{ $json->aplica4 }}" id="aplica4" class="form-control no-borders c-black" placeholder="%">
                        <span id="txt_aplica4"></span>
                    </td>
                </tr>
            </tbody>
           
        </table>
            
        </div>
    </div>

    <div class="col-md-12">
        <strong>DESCRIPCIÓN DE LA META ANUAL:</strong>
        <textarea name="descripcion_meta" rows="3" class="form-control no-borders" placeholder="Descripción de la Meta Anual" required>{{ $json->descripcion_meta }}</textarea>
    </div>
    <div class="col-md-12 m-t-md">
        <strong>MEDIOS DE VERIFICACIÓN:</strong>
        <textarea rows="3" class="form-control no-borders" placeholder="Medios de Verificación" readonly required>{{ $json->medios }}</textarea>
    </div>

    <div class="col-md-12 m-t-md">
        <strong>METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong>
        <textarea name="metas_actividad" rows="3" class="form-control no-borders" placeholder="Metas de Actividad Relacionadas y Avance" required>{{ $json->metas_actividad }}</textarea>
    </div>

    <br>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" class="btn btn-sm btn-primary btnsavepbrmb"> <i class="fa fa-save"></i> Guardar</button>
    </article>
    </form>
    
    <script>
    $(".mySelect2").select2();
    const idformula = "{{ $json->idmir_formula }}";
    
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

        if(tipo == 1 || tipo == 4){
            $("#anual_"+idrg).val(anual);
        }else if(tipo == 2 || tipo == 3){
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

       aplicarFormula();
    } 
    

    aplicarFormula();

    function aplicarFormula(){
         //Aplicado de la formula
        var trim1_a = $('input[name="trim1[0]"]').val();
        var trim1_b = $('input[name="trim1[1]"]').val();
        var t1_a = (trim1_a == "" ? 0 : parseFloat(trim1_a));
        var t1_b = (trim1_b == "" ? 0 : parseFloat(trim1_b));
        //Valido si aplica
        valAplica(1, t1_a, t1_b);

        var trim2_a = $('input[name="trim2[0]"]').val();
        var trim2_b = $('input[name="trim2[1]"]').val();
        var t2_a = (trim2_a == "" ? 0 : parseFloat(trim2_a));
        var t2_b = (trim2_b == "" ? 0 : parseFloat(trim2_b));

        valAplica(2, t2_a, t2_b);

        var trim3_a = $('input[name="trim3[0]"]').val();
        var trim3_b = $('input[name="trim3[1]"]').val();
        var t3_a = (trim3_a == "" ? 0 : parseFloat(trim3_a));
        var t3_b = (trim3_b == "" ? 0 : parseFloat(trim3_b));

        valAplica(3, t3_a, t3_b);

        var trim4_a = $('input[name="trim4[0]"]').val();
        var trim4_b = $('input[name="trim4[1]"]').val();
        var t4_a = (trim4_a == "" ? 0 : parseFloat(trim4_a));
        var t4_b = (trim4_b == "" ? 0 : parseFloat(trim4_b));

        valAplica(4, t4_a, t4_b);

        var anual_a = $('input[name="anual[0]"]').val();
        var anual_b = $('input[name="anual[1]"]').val();
        var tanual_a = (anual_a == "" ? 0 : parseFloat(anual_a));
        var tanual_b = (anual_b == "" ? 0 : parseFloat(anual_b));

        var multi = 100;
        if(idformula == 4){
            multi = 1000;
        }else if(idformula == 5){
            multi = 10000;
        }

        if(idformula == 1 || idformula == 4 || idformula == 5){ //(A/B)*100 - (A/B)*1000 - (A/B)*10000
            operacionFormula1(t1_a,t1_b,multi,"#porc1");
            operacionFormula1(t2_a,t2_b,multi,"#porc2");
            operacionFormula1(t3_a,t3_b,multi,"#porc3");
            operacionFormula1(t4_a,t4_b,multi,"#porc4");
            operacionFormula1(tanual_a,tanual_b,multi,"#porc_anual");
        }else if(idformula == 2){
            operacionFormula2(t1_a,t1_b,multi,"#porc1");
            operacionFormula2(t2_a,t2_b,multi,"#porc2");
            operacionFormula2(t3_a,t3_b,multi,"#porc3");
            operacionFormula2(t4_a,t4_b,multi,"#porc4");
            operacionFormula2(tanual_a,tanual_b,multi,"#porc_anual");
        }else if(idformula == 3){
            operacionFormula3(t1_a,t1_b,"#porc1");
            operacionFormula3(t2_a,t2_b,"#porc2");
            operacionFormula3(t3_a,t3_b,"#porc3");
            operacionFormula3(t4_a,t4_b,"#porc4");
            operacionFormula3(tanual_a,tanual_b,"#porc_anual");
        }else if(idformula == 6){ // (A/B/C)
            var trim1_c = $('input[name="trim1[2]"]').val();
            var trim2_c = $('input[name="trim2[2]"]').val();
            var trim3_c = $('input[name="trim3[2]"]').val();
            var trim4_c = $('input[name="trim4[2]"]').val();
            var anual_c = $('input[name="anual[1]"]').val();
            var t1_c = (trim1_c == "" ? 0 : parseFloat(trim1_c));
            var t2_c = (trim2_c == "" ? 0 : parseFloat(trim2_c));
            var t3_c = (trim3_c == "" ? 0 : parseFloat(trim3_c));
            var t4_c = (trim4_c == "" ? 0 : parseFloat(trim4_c));
            var tanual_c = (anual_c == "" ? 0 : parseFloat(anual_c));

            operacionFormula6(t1_a, t1_b, t1_c,"#porc1");
            operacionFormula6(t2_a, t2_b, t2_c,"#porc2");
            operacionFormula6(t3_a, t3_b, t3_c,"#porc3");
            operacionFormula6(t4_a, t4_b, t4_c,"#porc4");
            operacionFormula6(tanual_a,tanual_b, tanual_c,"#porc_anual");
        }
    }
    function valAplica(trim, a, b){
        $("#aplica"+trim).val((a != 0 || b != 0) ? '1' : '2');
        $("#txt_aplica"+trim).html((a != 0 || b != 0) ? 'Aplica' : 'No Aplica');
        $("#td_aplica" + trim).css({
            'background-color': (a != 0 || b != 0) ? 'var(--color-success)' : 'var(--ses-color-red)', 'color' : 'white'
        });
    }
    function operacionFormula1(a,b,multi,id){
        if(b > 0){
            let result = (a / b)*multi;
            $(id).val(parseFloat(result).toFixed(2));
        }else{
            $(id).val("0.00");
        }
    }
    function operacionFormula2(a,b,multi,id){
        if(b > 0){
            let result = ((a / b)-1)*multi;
            $(id).val(parseFloat(result).toFixed(2));
        }else{
            $(id).val("0.00");
        }
    }
    function operacionFormula3(a,b,id){
        if(b > 0){
            let result = (a / b);
            $(id).val(parseFloat(result).toFixed(2));
        }else{
            $(id).val("0.00");
        }
    }
    function operacionFormula6(a,b,c,id){
        if(b > 0 && c > 0){
            let result = (a / b / c);
            $(id).val(parseFloat(result).toFixed(2));
        }else{
            $(id).val("0.00");
        }
    }

    
    
    $("#formOchob").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("formOchob"));
            $.ajax("{{ URL::to('indicadores/editindicador?id='.$id) }}", {
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
                        appMetas.rowsProjects();
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
    </script>