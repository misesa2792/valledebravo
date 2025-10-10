<form id="saveInfo" method="post" class="form-horizontal">
<input type="hidden" name="trimestre" value="{{ $trim }}">
<section class="row">
    <article class="col-sm-12 col-md-12 col-lg-12 no-padding">
        <div class="col-sm-12 col-md-5 col-lg-5">

                <div class="sbox animated fadeInRight b-r-5">
                    <div class="sbox-title s-12"> <h3> <i class="fa fa-table"></i> Reporte de Avance de Metas</h3></div>
                    <div class="sbox-content"> 	
        
                        <div class="col-md-12 text-center">
                       
                            <table class="table">
                                <tr class="t-tr-s12">
                                    <td class="bg-white no-borders">{{ $json['header']['dep_gen'] }}</td>
                                </tr>
                                <tr class="t-tr-s12">
                                    <td class="pro_desc bg-white no-borders">{{ $json['header']['proyecto'] }}</td>
                                </tr>

                                <tr class="t-tr-s12">
                                    <th class="pro_desc bg-white no-borders c-primary-alt text-center">Trimestre #{{ $trim }}</th>
                                </tr>
                            </table>
                            
                        </div>
        
                        <div style="clear:both"></div>	
                    </div>
                </div>		 
            
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 no-padding animated fadeInRight">
            <table class="table table-bordered bg-white">
                <tr>
                    <th colspan="3" class="text-center s-12 c-text">Identificador</th>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Finalidad:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_finalidad'] }}</td>
                    <td id="fin_desc" class="bg-white" width="60%">{{ $json['header']['finalidad'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Función:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_funcion'] }}</td>
                    <td id="fun_desc" class="bg-white">{{ $json['header']['funcion'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Subfunción:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_subfuncion'] }}</td>
                    <td id="sub_desc" class="bg-white">{{ $json['header']['subfuncion'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Programa:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_programa'] }}</td>
                    <td class="pro_desc bg-white">{{ $json['header']['programa'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Subprograma:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_subprograma'] }}</td>
                    <td id="subp_desc" class="bg-white">{{ $json['header']['subprograma'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Proyecto:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_proyecto'] }}</td>
                    <th id="proy_desc" class="bg-white c-primary-alt">{{ $json['header']['proyecto'] }}</th>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Dependencia General:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_dep_gen'] }}</td>
                    <td class="bg-white">{{ $json['header']['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Dependencia Auxiliar:</td>
                    <td class="bg-white c-text-alt">{{ $json['header']['no_dep_aux'] }}</td>
                    <td class="bg-white">{{ $json['header']['dep_aux'] }}</td>
                </tr>

                <tr class="t-tr-s12">
                    <td class="text-right c-text-alt">Tema de Desarrollo:</td>
                    <td class="bg-white c-text-alt"></td>
                    <td class="bg-white">{{ $json['header']['tema'] }}</td>
                </tr>
            </table>
        </div>
    </article>

    <section class="col-sm-3 col-md-3 col-lg-3">
        
        <div class="sbox animated fadeInRight bg-white">
            <div class="sbox-title p-sm"> <h4> <i class="fa fa-check-circle-o"></i> FORTALEZAS</h4></div>
            <div class="p-sm"> 	

                <table class="table">
                    @if(isset($json['rowsReg'][1]))
                        @foreach ($json['rowsReg'][1] as $t)
                            <tr id="tr_{{ $t['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td>
                                    <input type="hidden" name="id1[]" value="{{ $t['id'] }}">
                                    <textarea name="desc1[]" rows="3" class="form-control" placeholder="Fortaleza" required>{{ $t['foda'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btneliminar" id="{{ $t['id'] }}"></i>
                                </td>
                            </tr>	
                        @endforeach
                    @endif

                    <tbody id="_tbody1" class="no-borders"></tbody>
                    <tbody class="no-borders">
                        <tr>
                            <td class="no-borders" colspan="3">
                                <button type="button" class="btn btn-xs btn-info b-r-5 btn-ses" id="btnadd1" data-num="1"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </section>

    <section class="col-sm-3 col-md-3 col-lg-3">
        <div class="sbox animated fadeInRight bg-white">
            <div class="sbox-title"> <h4> <i class="fa fa-signal"></i> OPORTUNIDADES</h4></div>
            <div class="p-sm"> 	
                <table class="table">
                    @if(isset($json['rowsReg'][2]))
                        @foreach ($json['rowsReg'][2] as $t)
                            <tr id="tr_{{ $t['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td>
                                    <input type="hidden" name="id2[]" value="{{ $t['id'] }}">
                                    <textarea name="desc2[]" rows="3" class="form-control" placeholder="Oportunidad" required>{{ $t['foda'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btneliminar" id="{{ $t['id'] }}"></i>
                                </td>
                            </tr>	
                        @endforeach
                    @endif
                    <tbody id="_tbody2" class="no-borders"></tbody>
                    <tbody class="no-borders">
                        <tr>
                            <td class="no-borders" colspan="3">
                                <button type="button" class="btn btn-xs btn-info btn-ses" id="btnadd2" data-num="2"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="col-sm-3 col-md-3 col-lg-3">
        <div class="sbox animated fadeInRight bg-white">
            <div class="sbox-title"> <h4> <i class="fa fa-question-circle"></i> DEBILIDADES</h4></div>
            <div class="p-sm"> 	
                <table class="table">
                    @if(isset($json['rowsReg'][3]))
                        @foreach ($json['rowsReg'][3] as $t)
                            <tr id="tr_{{ $t['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td>
                                    <input type="hidden" name="id3[]" value="{{ $t['id'] }}">
                                    <textarea name="desc3[]" rows="3" class="form-control" placeholder="Debilidad" required>{{ $t['foda'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btneliminar" id="{{ $t['id'] }}"></i>
                                </td>
                            </tr>	
                        @endforeach
                    @endif
                    <tbody id="_tbody3" class="no-borders"></tbody>
                    <tbody class="no-borders">
                        <tr>
                            <td class="no-borders" colspan="3">
                                <button type="button" class="btn btn-xs btn-info btn-ses" id="btnadd3" data-num="3"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="col-sm-3 col-md-3 col-lg-3">
        <div class="sbox animated fadeInRight bg-white">
            <div class="sbox-title"> <h4> <i class="fa fa-exclamation-triangle"></i> AMENAZAS</h4></div>
            <div class="p-sm"> 	
                <table class="table">
                    @if(isset($json['rowsReg'][4]))
                        @foreach ($json['rowsReg'][4] as $t)
                            <tr id="tr_{{ $t['id'] }}">
                                <td width="10" class="text-centrar"><i class="fa fa-circle c-text-alt s-10"></i></td>
                                <td>
                                    <input type="hidden" name="id4[]" value="{{ $t['id'] }}">
                                    <textarea name="desc4[]" rows="3" class="form-control" placeholder="Amenaza" required>{{ $t['foda'] }}</textarea>
                                </td>
                                <td width="10" class="text-center">
                                    <i class="fa fa-trash-o c-danger s-18 cursor btneliminar" id="{{ $t['id'] }}"></i>
                                </td>
                            </tr>	
                        @endforeach
                    @endif
                    <tbody id="_tbody4" class="no-borders"></tbody>
                    <tbody class="no-borders">
                        <tr>
                            <td class="no-borders" colspan="3">
                                <button type="button" class="btn btn-xs btn-info btn-ses" id="btnadd4" data-num="4"> <i class="fa fa-plus"></i> Agregar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn-outline"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>

    
</section>
</form>

<script>
     $("#btnadd1").click(function(e){
        e.preventDefault();
        agregarTr("btnadd1",1);
    })
    $("#btnadd2").click(function(e){
        e.preventDefault();
        agregarTr("btnadd2",2);
    })
    $("#btnadd3").click(function(e){
        e.preventDefault();
        agregarTr("btnadd3",3);
    })
    $("#btnadd4").click(function(e){
        e.preventDefault();
        agregarTr("btnadd4",4);
    })
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
            }
          })
    })
    $(document).on("click",".btneliminar",function(e){
        e.preventDefault();
        let id = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
				eliminadoTr(id);
            }
          })
    })
	function eliminadoTr(id){
        axios.get('{{ URL::to("reporte/eliminarfodatr") }}',{
            params : {id:id}
        }).then(response => {
			let row = response.data;
			if(row.success == "ok"){
				toastr.success("Registro eliminado!");
				$("#tr_"+id).remove();
			}else{
				toastr.error("Error al eliminar!");
			}
        })
    }
    function agregarTr(text,num){
		$("#"+text).prop("disabled",true).html(mss_spinner);
        axios.get('{{ URL::to("reporte/addfodatr") }}',{
            params : {num:num}
        }).then(response => {
			$("#"+text).prop("disabled",false).html('<i class="fa fa-plus"></i> Agregar');
            $("#_tbody"+num).append(response.data);
        })
    }

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to('reporte/savefoda?k='.$token) }}", {
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
                if(row.success == 'ok'){
                    $("#sximo-modal").modal("toggle");
                    toastr.success(mss_tmp.success);
                }else{
                    toastr.error(mss_tmp.error);
                }
                $(".btnsave").prop("disabled",false).html(btnSave);
            }, error : function(err){
                toastr.error(mss_tmp.error);
                $(".btnsave").prop("disabled",false).html(btnSave);
            }
        });
    });
</script>

@if(!isset($json['rowsReg'][1]))
    <script>
        agregarTr("btnadd1",1);
    </script>
@endif
@if(!isset($json['rowsReg'][2]))
    <script>
        agregarTr("btnadd2",2);
    </script>
@endif
@if(!isset($json['rowsReg'][3]))
    <script>
        agregarTr("btnadd3",3);
    </script>
@endif
@if(!isset($json['rowsReg'][4]))
    <script>
        agregarTr("btnadd4",4);
    </script>
@endif