<section class="table-resp" style="min-height:500px;">
    <form id="saveInfo" method="post" class="form-horizontal">

    <div class="col-md-12">
        <div class="col-md-8 no-padding"></div>
        <div class="col-md-4 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s16 c-text-alt">
                    <td>Ejercicio Fiscal</td>
                    <th>{{ $data['anio'] }}</th>
                </tr>
            </table>
        </div>
    </div>

    <br>
    <h3 class="text-center c-text-alt">PbRM-01d FICHA TÉCNICA DE DISEÑO DE INDICADORES ESTRATÉGICOS O DE GESTIÓN {{ $data['anio'] }}</h3>
    <br>

    <div class="col-md-12 no-padding">
        <div class="col-md-12 no-padding">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s12 c-text-alt">
                    <th>Pilar/Eje Transversal: </th>
                    <td class="text-center">{{ $data['no_pilar'] }}</td>
                    <td>{{ $data['pilar'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Tema de Desarrollo: </th>
                    <td class="text-center">{{ $data['no_tema'] }}</td>
                    <td>{{ $data['tema'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Programa presupuestario: </th>
                    <td class="text-center">{{ $data['no_programa'] }}</td>
                    <td>{{ $data['programa'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Proyecto: </th>
                    <td class="text-center"></td>
                    <td>
                        <select name="idproyecto" class="mySelect full-width" required>
                            <option value="">--Selecciona Proyecto--</option>
                            @foreach ($rowsProyectos as $v)
                            <option value="{{ $v->idproyecto }}" @if($v->idproyecto == $data['idproyecto']) selected @endif>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Objetivo del programa presupuestario: </th>
                    <td></td>
                    <td>{{ $data['obj_programa'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia General:</th>
                    <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                    <td>{{ $data['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s12 c-text-alt">
                    <th>Dependencia Auxiliar:</th>
                    <td class="text-center"></td>
                    <td>
                        <select name="idac" class="mySelect full-width" required>
                            <option value="">--Selecciona dependencia auxiliar--</option>
                            @foreach ($rowsDepAux as $v)
                            <option value="{{ $v->id }}" @if($v->id == $data['idac']) selected @endif>{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <br>
    <h3 class="text-center c-text-alt">ESTRUCTURA DEL INDICADOR</h3>
    <br>

      <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <th width="60%" class="text-right c-text-alt">Nivel de la MIR</th>
                <td>{{ $data['mir'] }}</td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered bg-white">
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Nombre del Indicador</th>
            <td colspan="4">{{ $data['indicador'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Fórmula de Cálculo</th>
            <td colspan="3">{{ $data['formula'] }}</td>
            <td width="10%" class="text-center">{{ $data['formula_corta'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Interpretación</th>
            <td colspan="4">
                <input type="text" name="interpretacion" value="{{ $data['interpretacion'] }}" class="form-control border-b-1-dashed c-black" placeholder="Interpretación" required>
            </td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Dimención que Atiende</th>
            <td>
                <select name="iddimension_atiende" class="form-control" required>
                    <option value="">--Selecciona opción--</option>
                    @foreach($rowsDimension as $m)
                        <option value="{{$m->id}}" @if($m->id == $data['iddimension_atiende']) selected @endif>{{$m->dimension}}</option>
                    @endforeach
                </select>
            </td>
            <th width="15%" class="text-right">Frecuencia de Medición</th>
            <td colspan="2">{{ $data['frecuencia'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Factor de Comparación</th>
            <td>
                <input type="text" name="factor" value="{{ $data['factor'] }}" class="form-control border-b-1-dashed c-black" placeholder="Factor de Comparación" required>
            </td>
            <th width="15%" class="text-right">Tipo de Indicador</th>
            <td colspan="2">{{ $data['tipo_indicador'] }}</td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Descripción del Factor de Comparación</th>
            <td colspan="4">
                <input type="text" name="factor_desc" value="{{ $data['factor_desc'] }}" class="form-control border-b-1-dashed c-black" placeholder="Descripción del Factor de Comparación" required>
            </td>
        </tr>
        <tr class="t-tr-s12 c-text-alt">
            <th width="15%" class="text-right">Línea Base</th>
            <td colspan="4">
                <input type="text" name="linea_base" value="{{ $data['linea_base'] }}" class="form-control border-b-1-dashed c-black" placeholder="Línea Base" required>
            </td>
        </tr>
    </table>

     <br>
        <h3 class="text-center c-text-alt">CALENDARIZACIÓN TRIMESTRAL</h3>
        <br>

        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <th width="40%" class="text-center" colspan="2">Variables del Indicador</th>
                <th width="40"></th>
                <th class="text-center">Unidad de Medida</th>
                <th class="text-center">Tipo de Operación</th>
                <th class="c-white bg-yellow-meta text-center">Primer Trimestre</th>
                <th class="c-white bg-green-meta text-center">Segundo Trimestre</th>
                <th class="c-white bg-blue-meta text-center">Tercer Trimestre</th>
                <th class="c-white bg-red-meta text-center">Cuarto Trimestre</th>
                <th class="c-white bg-primary text-center">Total Anual</th>
            </tr>
            @foreach($data['rows'] as $keyv => $v)
                <tr class="t-tr-s12 c-text-alt bg-white btnmostrar">
                    <td>{{ $v->nombre_corto }}</td>
                    <td>{{ $v->nombre_largo }}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default btn-outline btn-ses d-none btnhover btnagregarum" id="{{ $v->id }}"> <i class="fa fa-plus"></i> </button>
                    </td>
                    <td>
                        <input type="hidden" name="idindicador[{{$keyv}}]" value="{{ $v->id }}" class="form-control no-borders c-black">

                        <select name="unidad_medida[{{$keyv}}]" id="sltum_{{$v->id}}" class="mySelect" required>
                            <option value="">--Unidad de medida--</option>
                            @foreach($rowsUnidadMedida as $m)
                                <option value="{{$m->um}}" @if($m->um == $v->unidad_medida) selected @endif>{{$m->um}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="tipo_operacion[{{$keyv}}]" id="tipo_{{ $v->id }}" onchange="totalMeta({{ $v->id }})" class="form-control" required>
                            <option value="">--Select Please--</option>
                            @foreach($rowsTipoOpe as $to)
                                <option value="{{ $to->id }}" @if($to->id == $v->idtipo_operacion) selected @endif>{{ $to->tipo_operacion }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="trim1[{{$keyv}}]" value="{{ $v->trim1 }}" class="form-control no-borders c-black" placeholder="Trim. #1" id="trim1_{{ $v->id }}" onKeyUp="totalMeta({{ $v->id }})" required>
                    </td>
                    <td>
                        <input type="text" name="trim2[{{$keyv}}]" value="{{ $v->trim2 }}" class="form-control no-borders c-black" placeholder="Trim. #2" id="trim2_{{ $v->id }}" onKeyUp="totalMeta({{ $v->id }})" required>
                    </td>
                    <td>
                        <input type="text" name="trim3[{{$keyv}}]" value="{{ $v->trim3 }}" class="form-control no-borders c-black" placeholder="Trim. #3" id="trim3_{{ $v->id }}" onKeyUp="totalMeta({{ $v->id }})" required>
                    </td>
                    <td>
                        <input type="text" name="trim4[{{$keyv}}]" value="{{ $v->trim4 }}" class="form-control no-borders c-black" placeholder="Trim. #4" id="trim4_{{ $v->id }}" onKeyUp="totalMeta({{ $v->id }})" required>
                    </td>
                    <td>
                        <input type="text" name="anual[{{$keyv}}]" value="{{ $v->anual }}" class="form-control no-borders c-black" placeholder="Anual" id="anual_{{ $v->id }}" readonly required>
                    </td>
                </tr>
            @endforeach
            <tr class="t-tr-s12 c-text-alt bg-white">
                <th class="text-right" colspan="5">Resultado Esperado:</th>
                <td class="text-center">
                    <input type="text" name="porc1" value="{{ $data['porc1'] }}" id="porc1" class="form-control no-borders c-black" placeholder="%" required>
                </td>
                <td class="text-center">
                    <input type="text" name="porc2" value="{{ $data['porc2'] }}" id="porc2" class="form-control no-borders c-black" placeholder="%" required>
                </td>
                <td class="text-center">
                    <input type="text" name="porc3" value="{{ $data['porc3'] }}" id="porc3" class="form-control no-borders c-black" placeholder="%" required>
                </td>
                <td class="text-center">
                    <input type="text" name="porc4" value="{{ $data['porc4'] }}" id="porc4" class="form-control no-borders c-black" placeholder="%" required>
                </td>
                <td class="text-center">
                    <input type="text" name="porc_anual" value="{{ $data['porc_anual'] }}" id="porc_anual" class="form-control no-borders c-black" placeholder="%" required>
                </td>
            </tr>

            <tr class="t-tr-s12 c-text-alt bg-white">
                <th class="text-right" colspan="5"></th>
                <td class="text-center" id="td_aplica1">
                    <input type="hidden" name="aplica1" value="{{ $data['aplica1'] }}" id="aplica1" class="form-control no-borders c-black" placeholder="%">
                    <span id="txt_aplica1"></span>
                </td>
                <td class="text-center" id="td_aplica2">
                    <input type="hidden" name="aplica2" value="{{ $data['aplica2'] }}" id="aplica2" class="form-control no-borders c-black" placeholder="%">
                    <span id="txt_aplica2"></span>
                </td>
                <td class="text-center" id="td_aplica3">
                    <input type="hidden" name="aplica3" value="{{ $data['aplica3'] }}" id="aplica3" class="form-control no-borders c-black" placeholder="%">
                    <span id="txt_aplica3"></span>
                </td>
                <td class="text-center" id="td_aplica4">
                    <input type="hidden" name="aplica4" value="{{ $data['aplica4'] }}" id="aplica4" class="form-control no-borders c-black" placeholder="%">
                    <span id="txt_aplica4"></span>
                </td>
                <td class="text-center"></td>
            </tr>
        </table>

     <br>
        <strong>DESCRIPCIÓN DE LA META ANUAL:</strong>
        <textarea name="desc_meta" rows="3" class="form-control c-black" placeholder="Descripción de la meta anual" required>{{ $data['desc_meta'] }}</textarea>
        <br>
        <strong>MEDIOS DE VERIFICACIÓN:</strong>
        <textarea rows="3" class="form-control" placeholder="Medios de verificación c-black" disabled>{{ $data['medios'] }}</textarea>
        <br>
        <strong>METAS DE ACTIVIDAD RELACIONADAS Y AVANCE:</strong>

         <div class="col-md-12 m-t-md no-padding">
             <div class="alert alert-danger fade in block-inner">
                <div class="s-10">
                    <i class="icon-warning"></i> Notas Importantes:
                </div>
                
                <p class="c-text s-10 m-t-xs">
                    <span class="c-danger">Metas:</span> 
                    Ahora puedes seleccionar las metas del <strong>PbRM-02a</strong> relacionadas con el indicador. 
                    Están disponibles todas las  metas de las dependencias generales, en caso de que tu indicador este relacionado con otra dependencia.  
                    <br><br>
                    Conforme las vayas eligiendo, aparecerán en el recuadro de la izquierda y también en el campo de texto de la derecha.  
                    <br><br>
                    Si no seleccionas ninguna meta, el campo de texto de la derecha se podrá editar de forma manual.  
                    <br><br>
                    <strong>Nota:</strong> al usar el selector múltiple, se <u>reemplazarán todas las metas existentes</u> en el campo de texto.
                </p>
            </div>
        </div>

        

        <div class="col-md-12 no-padding bg-white" style="min-height:250px;">

            <div class="col-md-6 no-padding">

                <select id="mySelect" name="idmetas[]" multiple="multiple" class="full-width">
                    @foreach ($rowsMetas as $v)
                        <option value="{{ $v->id }}"
                                data-texto="{{ 'META '.$v->codigo.' '.$v->meta.' ('.str_replace('0','',$v->no_proyecto).' - '.$v->no_dep_aux.')' }}" 
                                @if(isset($data['idmetas'][$v->id])) selected @endif
                                >{{ ' . '.$v->no_dep_gen }} - {{ 'META '.$v->codigo.' '.$v->meta }} ({{ str_replace('0','',$v->no_proyecto) }} - {{ $v->no_dep_aux }})</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-6 no-padding">
                <textarea name="metas_act" rows="15" id="txt_metas_act" class="form-control c-black" placeholder="Metas de actividad relacionadas y avance" required>{{ $data['metas_act'] }}</textarea>
            </div>
        </div>

      

<script>
  $(function () {
    $('#mySelect').multipleSelect({
      placeholder: "Selecciona metas del PbRM-02a",
      selectAll: true,       // Botón "Seleccionar todo"
      filter: true,          // Barra de búsqueda
      minimumCountSelected: 2 // Texto de "X seleccionados" cuando hay varias
    });
  });
   // Escuchar cambios
    $('#mySelect').on('change', function () {
      // IDs seleccionados
      const values = $(this).val() || [];
      var cadena = "";
      // Recorremos para sacar los textos
      values.forEach(val => {
        const option = $(this).find('option[value="'+ val +'"]');
        const texto = option.data('texto'); // <-- recupera tu data-texto

        cadena += texto + "\n"; 

      });
        $("#txt_metas_act").val(cadena);

    });
</script>


    <br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Editar </button>
    </article>

    </form>
</section>
<style>
    .btnmostrar:hover .btnhover{
        display: block;
    }
    .btnmostrar:hover tr{
        border-left:4px solid var(--ses-color-orange) !important;
    }
</style>
<script>
    $(".mySelect").select2();

    $(document).off("click", ".btnagregarum"); 
    $(document).on("click",".btnagregarum",function(e){
        e.preventDefault();
        let id = $(this).attr("id");
        modalAvance("{{ URL::to('anteproyecto/addum') }}",{id:id},"Agregar nueva Unidad de Medida","40%");
    })

    const idformula = "{{ $data['idformula'] }}";
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
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      swal({
        title : 'Estás seguro de guardar la información?',
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
                    $.ajax("{{ URL::to('anteproyecto/savepbrmd') }}", {
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