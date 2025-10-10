        <form id="saveInfo" method="post" class="form-horizontal">
          <section class="col-md-12" style="min-height:500px;" id="app_crear">
      
              <article class="col-md-12">
                  <div class="col-md-8 no-padding"></div>
                  <div class="col-md-4 no-padding">
                      <table class="table table-bordered bg-white">
                          <tr class="t-tr-s14 c-text-alt">
                              <td>Ejercicio Fiscal</td>
                              <th>{{ $data['year'] }}</th>
                          </tr>
                      </table>
                  </div>
              </article>
      
              <article class="col-md-12">
                  <div class="col-md-4 no-padding">
                      <table class="table table-bordered bg-white">
                          <tr class="t-tr-s14 c-text-alt">
                              <td>Municipio: </td>
                              <th class="text-center">{{ $data['institucion'] }}</th>
                              <td>No.</td>
                              <th class="text-center">{{ $data['no_institucion'] }}</th>
                          </tr>
                          <tr class="t-tr-s14 c-text-alt">
                              <td>FORMATO</td>
                              <th colspan="3" class="text-center">
                                  <div class="c-blue">SOLICITUD DE TRASPASOS INTERNOS</div>
                              </th>
                          </tr>
                      </table>
                  </div>
                  <div class="col-md-1 no-padding"></div>
                  <div class="col-md-7 no-padding">
                      <table class="table table-bordered bg-white">
                          <tr class="t-tr-s14 c-text-alt">
                          <th></th>
                          <th class="text-center">Clave</th>
                          <th class="text-center">Denominación</th>
                          </tr>
                        
                          <tr class="t-tr-s14 c-text-alt">
                              <th>Dependencia General:</th>
                              <td></td>
                              <td>
                                <select name="iddep_gen" class="mySelect"  required>
                                  <option value="">--Select Please--</option>
                                  @foreach ($data['rowsDepGen'] as $v)
                                    <option value="{{ $v->id }}" 
                                        @if($v->id == $data['row']->iddep_gen) selected @endif>{{ $v->no_dep_gen.' '.$v->dep_gen }}</option>
                                  @endforeach
                                </select>
                              </td>
                          </tr>
                          <tr class="t-tr-s14 c-text-alt">
                              <th>Dependencia Auxiliar:</th>
                              <td></td>
                              <td>
                                <select name="iddep_aux" class="mySelect"  required>
                                  <option value="">--Select Please--</option>
                                  @foreach ($data['rowsDepAux'] as $v)
                                    <option value="{{ $v->id }}" 
                                        @if($v->id == $data['row']->iddep_aux) selected @endif>{{ $v->no_dep_aux.' '.$v->dep_aux }}</option>
                                  @endforeach
                                </select>
                              </td>
                          </tr>
      
                <tr class="t-tr-s14 c-text-alt">
                              <th>Proyecto: </th>
                              <td id="td_no_proyecto"></td>
                              <td width="60%">
                                <select name="idproyecto" class="mySelect" id="sltproject" onchange="obtenerValorData()" required>
                                  <option value="">--Select Please--</option>
                                  @foreach ($data['rowsProjects'] as $v)
                                    <option value="{{ $v->idproyecto }}" 
                                      data-idproyecto="{{ $v->idproyecto }}" 
                                      data-no_proyecto="{{ $v->no_proyecto }}" 
                                      data-no_programa="{{ $v->no_programa }}" 
                                      data-programa="{{ $v->programa }}" 
                                      data-obj_programa="{{ $v->obj_programa }}" 
                                      data-clasificacion="{{ $v->clasificacion }}" 
                                        @if($v->idproyecto == $data['row']->idproyecto) selected @endif>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                                  @endforeach
                                </select>
                              </td>
                          </tr>
                <tr class="t-tr-s14 c-text-alt">
                              <th>Programa presupuestario: </th>
                              <td id="td_no_programa"></td>
                              <td id="td_programa"></td>
                          </tr>
                <tr class="t-tr-s14 c-text-alt">
                              <th>Objetivo: </th>
                              <td></td>
                              <td id="td_obj_programa"></td>
                          </tr>
                
                      </table>
                  </div>
      
              </article>

              <table class="table">
                <tr class="t-tr-s14 c-text-alt">
                    <th colspan="4" width="49%" class="text-center bg-white">DISMINUCIÓN</th>
                    <th class="no-borders" width="5"></th>
                    <th colspan="4" width="49%" class="text-center bg-white">AUMENTO</th>
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <th class="bg-white">F.F.</th>
                    <th class="bg-white">PARTIDA</th>
                    <th class="bg-white">MES</th>
                    <th class="bg-white">IMPORTE</th>
                    <th class="no-borders" width="5"></th>
                    <th class="bg-white">F.F.</th>
                    <th class="bg-white">PARTIDA</th>
                    <th class="bg-white">MES</th>
                    <th class="bg-white">IMPORTE</th>
                </tr>

                @foreach ($data['rowReg'] as $h)
                    {{--*/ $time = $h->id /*--}}
                    <tr id="tr_{{ $time }}">
                        <td class="bg-white" width="10%">
                            <input type="hidden" name="idr[]" value="{{ $time }}">
                            <select name="d_ff[]" class="mySelect{{ $time }} full-width" required onchange="handleChangeNew(this, '{{ $time }}')">
                                <option value="">--Select Please--</option>
                                @foreach ($rowsFF as $v)
                                    <option value="{{ $v->id }}" data-texto="{{ $v->clave.' '.$v->descripcion }}" @if($v->id == $h->idteso_ff_n3) selected @endif>{{ $v->clave.' '.$v->descripcion }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bg-white" width="10%">
                            <select name="d_partida[]" class="mySelect{{ $time }} full-width" required>
                                <option value="">--Select Please--</option>
                                @foreach ($rowsPartidas as $v)
                                    <option value="{{ $v->id }}" @if($v->id == $h->d_idteso_partidas_esp) selected @endif>{{ $v->clave.' '.$v->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bg-white" width="5%">
                            <select name="d_mes[]" class="form-control form-control-ses" required>
                                <option value="">--Select Please--</option>
                                @foreach ($rowsMes as $r)
                                    <option value="{{ $r->idmes }}" @if($r->idmes == $h->d_idmes) selected @endif>{{ $r->mes }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bg-white">
                        <input type="text" name="d_importe[]" value="{{ $h->importe }}" class="form-control no-borders form-control-ses" placeholder="Importe" id="d_importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
                        </td>
                    
                        <td class="no-borders"></td>
                    
                        <td class="bg-white" width="10%" id="div_partida_{{ $time }}"></td>
                        <td class="bg-white" width="10%">
                            <select name="a_partida[]" class="mySelect{{ $time }} full-width" required>
                                <option value="">--Select Please--</option>
                                @foreach ($rowsPartidas as $v)
                                    <option value="{{ $v->id }}" @if($v->id == $h->a_idteso_partidas_esp) selected @endif>{{ $v->clave.' '.$v->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bg-white" width="5%">
                            <select name="a_mes[]" class="form-control form-control-ses" required>
                                <option value="">--Select Please--</option>
                                @foreach ($rowsMes as $r)
                                    <option value="{{ $r->idmes }}" @if($r->idmes == $h->a_idmes) selected @endif>{{ $r->mes }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="bg-white">
                        <input type="text" name="a_importe[]" value="{{ $h->importe }}" class="form-control no-borders form-control-ses" id="a_importe{{ $time }}" placeholder="Importe" readonly>
                        </td>
                    
                        <td class="text-center no-borders">
                            <script>
                                $(".mySelect{{ $time }}").select2();
                                function handleChangeNew(selectElement, time) {
                                    // Obtén el valor seleccionado
                                    const selectedValue = selectElement.value;
                    
                                    // Obtén el texto del atributo `data-texto` del <option> seleccionado
                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                    const dataTexto = selectedOption.getAttribute('data-texto');
                    
                                    $("#div_partida_"+time).html(dataTexto);
                                }
                            </script>
                            <i class="fa fa-trash-o c-danger cursor btndestroyedit s-16" id="{{ $time }}"></i>
                        </td>
                    </tr>
                @endforeach
             
                <tbody id="_tbody" class="no-borders"></tbody>
               
                <tbody class="no-borders">
                    <tr class="t-tr-s14">
                        <td class="no-borders">
                            <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses btnagregar" > <i class="fa fa-plus"></i> Agregar</button>
                        </td>
                        <td></td>
                        <th class=" c-text-alt">Total:</th>
                        <td>
                            <input type="text" name="importe" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                        </td>
        
                        <td class="no-borders"></td>
        
                        <td></td>
                        <td></td>
                        <th class=" c-text-alt">Total:</th>
                        <td>
                            <input type="text" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                        </td>
                    </tr>
                </tbody>
            </table>
      
            <article class="col-md-12 m-t-md">
              <table class="table table-bordered bg-white">
                  <tr class="t-tr-s16">
                      <th width="60%" class="c-text-alt no-borders">JUSTIFICACIÓN</th>
                      <th class="text-right no-borders"><p id="contadorCaracteresJust" class="c-danger">Carácteres restantes: 500</p></th>
                  </tr>
                  <tr class="t-tr-s16">
                      <td colspan="2">
                          <div style="min-height: 80px;">
                              <textarea name="justificacion" id="txtjustificacion" rows="5" class="form-control no-borders bg-transparent" placeholder="Justificación" required>{{ $data['row']->justificacion }}</textarea>
                          </div>
                      </td>
                  </tr>
              </table> 
          </article>
          </section>

          <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
        </article>

      </form>

   
<script>
  $(document).ready(function() { 
    $(".mySelect").select2();
	});
  function obtenerValorData() {
        var select = document.getElementById("sltproject");
        var opcionSeleccionada = select.options[select.selectedIndex];
        var no_programa = opcionSeleccionada.getAttribute("data-no_programa");
        var programa = opcionSeleccionada.getAttribute("data-programa");
        var obj_programa = opcionSeleccionada.getAttribute("data-obj_programa");
        var no_proyecto = opcionSeleccionada.getAttribute("data-no_proyecto");
        var clasificacion = opcionSeleccionada.getAttribute("data-clasificacion");
        $("#td_no_programa").html(no_programa);
        $("#td_programa").html(programa);
        $("#td_obj_programa").html(obj_programa);
        $("#td_no_proyecto").html(no_proyecto);
    }
   
    function viewTr(){
      axios.get('{{ URL::to("transpasosinternos/tr") }}',{
        params : {idam: "{{ $idam }}"},
      }).then(response => {
        $("#_tbody").append(response.data);
      }).catch(error => {
      }).finally(() => {
      });
    }

    $(".btnagregar").click(function(e){
    e.preventDefault();
      viewTr();
    });

    $(document).on("click",".btndestroy",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                $("#tr_"+time).remove();
                sumarImporte();
            }
          })
    })
    $(document).on("click",".btndestroyedit",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                deleteTr(time);
            }
          })
    })

    function deleteTr(id){
        axios.delete('{{ URL::to("transpasosinternos/registro") }}',{
            params : {id: id},
        }).then(response => {
            let row = response.data;
            if(row.status == "ok"){
                $("#tr_"+id).remove();
                sumarImporte();
                toastr.success(row.message);
            }
        }).catch(error => {
        }).finally(() => {
        });
    }
    
    function totalImporte(time) {
        let importe = $("#d_importe"+time).val();
        if (!/^([0-9\.,])*$/.test(importe)){
            toastr.error("Importe, No es un número!");
            $("#d_importe"+time).addClass("border-2-dashed-red");
            $("#d_importe"+time).removeClass("no-borders");
        }else{
            $("#d_importe"+time).addClass("no-borders");
            $("#d_importe"+time).removeClass("border-2-dashed-red");
        }
        let t1 = (importe == "" ? 0 : importe);
        $("#a_importe"+time).val(t1);
        sumarImporte();
    } 
    function sumarImporte(){
        let cantidad = 0;
        var cant = document.getElementsByName('d_importe[]');
        for(key=0; key < cant.length; key++)  {
            if(cant[key].value != ''){
                var valor = cant[key].value;
                cantidad = cantidad + parseFloat(valor.replace(/[^0-9.]/g, ''));
            }
        }
        let numeroFormateadoMX = cantidad.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $(".txtimporte").val(numeroFormateadoMX);
    }
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
      formData.append("type", "{{ $type }}");
      formData.append("idam", "{{ $idam }}");
      formData.append("id", "{{ $id }}");
        $.ajax("{{ URL::to($pageModule.'/editti') }}", {
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
                    toastr.success(row.message);
                    $("#sximo-modal").modal("toggle");
                    proyectos.rowsProjects();
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