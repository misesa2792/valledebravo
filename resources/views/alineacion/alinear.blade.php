<form id="saveInfo" method="post" class="form-horizontal">
    <section class="col-sm-6 col-md-6 col-lg-6">
			
        <div class="sbox animated fadeInRight" style="border-left:4px solid var({{ $linea->color }});">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> PDM</h4></div>
            <div class="sbox-content"> 	
    
                <div class="col-sm-12 col-md-12 col-lg-12">
                    
                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class="control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> PILAR: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt"></div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->pilares }}</div>
                    </div> 
    
                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> TEMA: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt"></div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->tema }}</div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> SUBTEMA: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt"></div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->subtema }}</div>
                    </div>
                    
                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> OBJETIVO: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt">{{ $linea->obj_clave }}</div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->objetivo }}</div>
                    </div>
    
                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> ESTRATEGIA: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt">{{ $linea->est_clave }}</div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->estrategia }}</div>
                    </div>
    
                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> LÍNEA DE ACCIÓN: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt">{{ $linea->linea_clave }}</div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">{{ $linea->linea_accion }}</div>
                    </div>
    
                </div>
    
                <div style="clear:both"></div>	
                
            </div>
        </div>
    </section>

    <section class="col-sm-6 col-md-6 col-lg-6">
        <table class="table table-bordered bg-white border-t-yellow">
            <tr>
                <th colspan="3" class="text-center s-16 c-text-alt">
                    <div class="p-xs">PROYECTOS</div>
                </th>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Finalidad:</td>
                <td class="bg-white c-text-alt" id="fin_no"></td>
                <td id="fin_desc" class="bg-white" width="60%"></td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Función:</td>
                <td class="bg-white c-text-alt" id="fun_no"></td>
                <td id="fun_desc" class="bg-white"></td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Subfunción:</td>
                <td class="bg-white c-text-alt" id="sub_no"></td>
                <td id="sub_desc" class="bg-white"></td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Programa:</td>
                <td class="bg-white c-text-alt" id="pro_no"></td>
                <td class="pro_desc bg-white"></td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Subprograma:</td>
                <td class="bg-white c-text-alt" id="subp_no"></td>
                <td id="subp_desc" class="bg-white"></td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Proyecto:</td>
                <td class="bg-white c-text-alt" id="proy_no"></td>
                <td>
                    <select name="idp" class="mySelect2 full-width sltproy" required>
                        <option value="">--Selecciona Proyecto--</option>
                        @foreach ($rows_projects as $p)
                            <option value="{{ $p->idproyecto }}">{{ $p->numero }}-{{ $p->descripcion }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr class="t-tr-s16">
                <td class="text-right c-text-alt">Año:</td>
                <td class="bg-white c-text-alt" colspan="2">{{ $anio }}</td>
            </tr>
        </table>

    </section>


    <section class="col-sm-12 col-md-12 col-lg-12">
        <div class="sbox animated fadeInRight border-t-green">
            <div class="sbox-title"> <h4> <i class="fa fa-table"></i> METAS POR PROYECTO</h4></div>
            <div class="sbox-content"> 	

                <div class="row s-16" id="resultMeta">
                    <div class="col-sm-12 col-md-12 col-lg-12 m-t-lg m-b-lg">
                        <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-30"></i> </h1>
                        <h2 class="text-center com">No se encontraron metas!</h2>
                    </div>
                </div>
                <div style="clear:both"></div>	
                
            </div>
        </div>
    </section>

    <input type="hidden" value="{{ $idanio }}" name="idanio">
    
    <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
<script>
    const idanio = "{{ $idanio }}";
    $(".mySelect2").select2();
    $(".sltproy").click(function(e){
        e.preventDefault();
        $("#resultMeta").empty().append(mss_tmp.load);
        let id = $(this).val();
        axios.get('{{ URL::to("reporte/dataproject") }}',{
            params : {id:id}
        }).then(response => {
            let row = response.data;
            $("#proy_no").html(row.proy_no);
            $("#fin_no").html(row.fin_numero);
            $("#fin_desc").html(row.fin_desc);
            $("#fun_no").html(row.fun_numero);
            $("#fun_desc").html(row.fun_desc);
            $("#sub_no").html(row.sub_numero);
            $("#sub_desc").html(row.sub_desc);
            $("#pro_no").html(row.pro_numero);
            $(".pro_desc").html(row.pro_desc);
            $("#subp_no").html(row.subp_numero);
            $("#subp_desc").html(row.subp_desc);
            loadMetas(id);
        })
    })

    function loadMetas(idp){
        $("#resultMeta").empty().append(mss_tmp.load);
        axios.get('{{ URL::to("alineacion/loadmeta") }}',{
            params : {idp:idp,idanio:idanio}
        }).then(response => {
            $("#resultMeta").empty().append(response.data);
        })
    }
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to('alineacion/savealinear?id='.$idlinea_accion) }}", {
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
                    alinear.rowsLineasAccion();
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