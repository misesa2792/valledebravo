
<form id="saveInfo" method="post" class="form-horizontal">
    <link href="{{ asset('mass/js/plugins/sumoselect/sumoselectviejo.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('mass/js/plugins/sumoselect/jquery.sumoselectviejo.min.js') }}"></script>
    <section class="col-sm-12 col-md-12 col-lg-12">
			<input type="hidden" name="idanio" value="{{ $idanio }}">
        <div class="sbox" style="border-left:4px solid var({{ $linea->color }});">
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

                    <div class="col-sm-12 col-md-12 col-lg-12 p-xs">
                        <label class=" control-label col-sm-2 col-md-2 col-lg-2 text-right s-16"> META: </label>
                        <div class="col-sm-1 col-md-1 col-lg-1 s-16 c-text-alt"></div>
                        <div class="col-sm-9 col-md-9 col-lg-9 s-16 c-text-alt">
                            <p>{{ $rows_metas->meta }}</p>
                        </div>
                    </div>
    
                </div>
    
                <div style="clear:both"></div>	
                
            </div>
        </div>
    </section>

    <article class="col-sm-12 col-md-12 col-lg-12 no-padding">
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-green">
                <div class="sbox-title bg-green-rgba p-sm c-green"> <h4> <i class="fa fa-table"></i> Paso #1</h4></div>
                <div class="bg-green-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">

                       
                        <textarea name="paso1" rows="3" id="txt_paso1" class="form-control border-all-green bg-transparent font-bold c-primary-alt" placeholder="Texto político" onKeyUp="unirTextos()" required>{{ $rows_metas->paso1 }}</textarea>
                        
                        <div class="m-t-md m-b-xs">
                            <select name="slt_paso1" id="text_1" class="mySelect2 full-width sltconector" onchange="myDelegaciones()">
                                <option value="">Selecciona Conector</option>
                                @foreach ($conectores as $c)
                                    @if($c->tipo == 1)
                                        <option value="{{ $c->idpdm_alineacion_conectores }}" @if($rows_metas->c1 == $c->idpdm_alineacion_conectores) selected @endif>{{ $c->descripcion }}</option>
                                    @endif   
                                @endforeach
                            </select>
                        </div>
                      


                        <p class="var">Ejemplo:</p>
                        <p class="c-text-alt">La salud publica de las y los Toluqueños requiere de la sanidad de sus animales de compañía </p>

                    </div>
        
                    <div style="clear:both"></div>	
                    
                </div>
            </div>
        </section>
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-pink">
                <div class="sbox-title bg-pink-rgba c-pink"> <h4> <i class="fa fa-table"></i> Paso #2</h4></div>
                <div class="bg-pink-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">

                        
                        <textarea name="paso2" rows="3" id="txt_paso2" class="form-control border-all-pink bg-transparent font-bold c-primary-alt" placeholder="Enunciado de Valor" onKeyUp="unirTextos()" required>{{ $rows_metas->paso2 }}</textarea>
                      
                        <div class="m-t-md m-b-xs">
                            <select name="slt_paso2" id="text_2" class="mySelect2 full-width sltconector" onchange="myDelegaciones()">
                                <option value="">Selecciona Conector</option>
                                @foreach ($conectores as $c)
                                    @if($c->tipo == 2)
                                    <option value="{{ $c->idpdm_alineacion_conectores }}"  @if($rows_metas->c2 == $c->idpdm_alineacion_conectores) selected @endif>{{ $c->descripcion }}</option>
                                @endif   
                                @endforeach
                            </select>
                        </div>

                        <p class="var">Ejemplo:</p>
                        <p class="c-text">Por lo que se brinda de manera gratuita la vacuna antirrábica y la esterilización de perros y gatos, mediante las campañas de vacunación antirrábica canina y felina que se realizan año con año en coordinación con el Instituto de Salud del Estado de México.</p>
                    
                    </div>
                    <div style="clear:both"></div>	
                </div>
            </div>
        </section>
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-yellow">
                <div class="sbox-title bg-yellow-rgba c-yellow"> <h4> <i class="fa fa-table"></i> Paso #3</h4></div>
                <div class="bg-yellow-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">

                        <textarea name="paso3" rows="3" id="txt_paso3" class="form-control border-all-yellow bg-transparent font-bold c-primary-alt" placeholder="Logro Cuantitativo" onKeyUp="unirTextos()" required>{{ $rows_metas->paso3 }}</textarea>
                        <div class="m-t-md m-b-xs">
                            <select name="slt_paso3" id="text_3" class="mySelect2 full-width sltconector" onchange="myDelegaciones()">
                                <option value="">Selecciona Conector</option>
                                @foreach ($conectores as $c)
                                    @if($c->tipo == 3)
                                    <option value="{{ $c->idpdm_alineacion_conectores }}"  @if($rows_metas->c3 == $c->idpdm_alineacion_conectores) selected @endif>{{ $c->descripcion }}</option>
                                @endif   
                                @endforeach
                            </select>
                        </div>
                        <p class="var">Ejemplo:</p>
                        <p class="c-text-alt">Se logró la aplicación de 6,654 dosis de vacuna y 10,117 esterilizaciones. </p>

                    </div>
        
                    <div style="clear:both"></div>	
                    
                </div>
            </div>
        </section>
    </article>

    <article class="col-sm-12 col-md-12 col-lg-12 no-padding">
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-green">
                <div class="sbox-title bg-green-rgba p-sm c-green"> <h4> <i class="fa fa-table"></i> Paso #4</h4></div>
                <div class="bg-green-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">

                       
                        <textarea name="paso4" rows="3" id="txt_paso4" class="form-control border-all-green bg-transparent font-bold c-primary-alt" placeholder="Población Beneficiada" onKeyUp="unirTextos()" required>{{ $rows_metas->paso4 }}</textarea>
                        <div class="m-t-md m-b-xs">
                            <select name="slt_paso4" id="text_4" class="mySelect2 full-width sltconector" onchange="myDelegaciones()">
                                <option value="">Selecciona Conector</option>
                                @foreach ($conectores as $c)
                                    @if($c->tipo == 4)
                                    <option value="{{ $c->idpdm_alineacion_conectores }}"  @if($rows_metas->c4 == $c->idpdm_alineacion_conectores) selected @endif>{{ $c->descripcion }}</option>
                                @endif   
                                @endforeach
                            </select>
                        </div>
                        <p class="var">Ejemplo:</p>
                        <p class="c-text-alt">Con lo que se benefició a 10 mil dueños de animales de compañía, de los cuales, seis mil fueron mujeres  y cuatro mil hombres (con perspectiva de género)</p>
                
                    </div>
        
                    <div style="clear:both"></div>	
                    
                </div>
            </div>
        </section>
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-pink">
                <div class="sbox-title bg-pink-rgba p-sm c-pink"> <h4> <i class="fa fa-table"></i> Paso #5</h4></div>
                <div class="bg-pink-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">
                        <select name="iddelegacion[]" id="iddelegacion" multiple class='testselect2 full-width' onchange="myDelegaciones()">
                            <option value="">--Selecciona delegación--</option>
                            @foreach ($delegaciones as $d)
                            <option value="{{ $d->iddelegacion }}" @if($d->total > 0 ) selected @endif>{{ $d->descripcion }}</option>
                            @endforeach
                        </select>

                        <div class="m-t-md m-b-xs">
                            <select name="slt_paso6" id="text_6" class="mySelect2 full-width sltconector" onchange="myDelegaciones()">
                                <option value="">Selecciona Conector</option>
                                @foreach ($conectores as $c)
                                @if($c->tipo == 6)
                                    <option value="{{ $c->idpdm_alineacion_conectores }}"  @if($rows_metas->c6 == $c->idpdm_alineacion_conectores) selected @endif>{{ $c->descripcion }}</option>
                                @endif   
                                @endforeach
                            </select>
                        </div>

                        <p class="var">Ejemplo:</p>
                        <p class="c-text-alt">Localidades beneficiadas</p>
                    </div>
        
                    <div style="clear:both"></div>	
                    
                </div>
            </div>
        </section>
        <section class="col-sm-4 col-md-4 col-lg-4">
            <div class="sbox border-t5-yellow">
                <div class="sbox-title bg-yellow-rgba p-sm c-yellow"> <h4> <i class="fa fa-table"></i> Paso #6</h4></div>
                <div class="bg-yellow-rgba p-sm box-height-card"> 	
        
                    <div class="col-sm-12 col-md-12 col-lg-12 no-padding">

                        
                        <textarea name="paso6" rows="3" id="txt_paso6" class="form-control border-all-yellow bg-transparent font-bold c-primary-alt" placeholder="Monto de la inversión" onKeyUp="unirTextos()" required>{{ $rows_metas->paso6 }}</textarea>
                       
                        <p class="var">Ejemplo:</p>
                        <p class="c-text-alt">Con una inversión ejercida de 999 mil pesos.</p>
                    </div>
        
                    <div style="clear:both"></div>	
                    
                </div>
            </div>
        </section>
    </article>


    <section class="col-sm-12 col-md-12 col-lg-12">
        <div class="sbox">
            <div class="sbox-title bg-white p-sm c-text"> <h4> <i class="fa fa-table"></i> Informe de Gobierno</h4></div>
            <div class="bg-white p-sm"> 	
    
                <div class="col-sm-12 col-md-12 col-lg-12">
                     <textarea name="comentarios" rows="4" class="form-control font-bold fun no-borders" placeholder="Informe de Gobierno" id="_comentarios" readonly style="background: transparent;">{{ $rows_metas->comentarios }}</textarea>
                </div>
    
                <div style="clear:both"></div>	
                
            </div>
        </div>
    </section>
    
    <section class="col-sm-8 col-md-8 col-lg-8" id="cont_appimg">

            <div class="col-md-12 no-padding bg-white b-r-5 overflow-h box-shadow" style="min-height: 300px;">
                <header class="col-md-12 p-xs s-20 b-b-gray">
                    <div class="col-md-10 no-padding d-table">
                        <div class="d-table-cell p-l-10">Evidencia</div>
                    </div>
                </header>

                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input type="file" name="evidencia[]" class="form-control" accept=".jpeg,.jpg,.png,.xlsx,.xls,.pdf,.txt,.ppt,.pptx,.doc,.docx,.csv" multiple>
                </div>

                <div class="col-md-12 m-t-md m-b-md text-center s-16">
                    <template v-for="(rows , key) in infoimgs">
                        <div class="item-file-list item-files" :id="'imgs_'+rows.id">
                            <a :href="rows.url" target="_blank" class="relatedFile" style="height:100px;">
                                <img :src="rows.ico" border="0" class="img-related b-r-10"/>
                            </a>
                            <div style="height:auto;">
                                <a href="" class="btn btn-xs btn-white" @click.prevent="destroyFile(rows.id)"> <i class="fa fa-trash-o var"></i> </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
    </section>

    <section class="col-md-4">
        <article class="col-md-12 no-padding">
            <div class="col-md-12 no-padding bg-white b-r-5 overflow-h box-shadow">
                <header class="col-md-12 p-xs s-20 b-b-gray">
                    <div class="col-md-10 no-padding d-table">
                        <div class="d-table-cell p-l-10">Documentos permitidos</div>
                    </div>
                </header>
                <div class="col-md-12 m-t-md m-b-md text-center s-16">
                    <h5>Imágenes (.PNG , .JPG, .JPEG)</h5>
                    <h5>PDF</h5>
                    <h5>Archivos de Word (.DOCX , .DOC)</h5>
                    <h5>Archivos (.CSV)</h5>
                    <h5>Archivos de Excel (.XLSX , .XLS)</h5>
                    <h5>Archivos de PowerPoint (.PPTX , .PPT)</h5>
                    <h5>Archivos de Texto Plano (.TXT)</h5>

                    <h4 class='m-t-md m-b-md var'>Tamaño máximo permitido por archivo es de 50MB</h4>

                </div>
            </div>
        </article>
    </section>

    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
    </article>
</form>
<style>
    .SumoSelect,.CaptionCont{width:100% !important;}
    .box-height-card{min-height: 300px;}
    .full-width{width:100% !important;}
</style>
<script>
    const idd = "{{ $id }}";
    var commets = new Vue({
        el:'#cont_appimg',
        data:{
            infoimgs : [],
        },
        methods:{
            loadImgs(){
                axios.get('{{ URL::to("alineacion/comentariosimg") }}',{
                    params : {id:idd}
                }).then(response => {
                    this.infoimgs = [];
                    this.infoimgs = response.data;
                })
             },
             destroyFile(idai){
                swal({
                    title : 'Estás seguro de eliminar el archivo?',
                    icon : 'warning',
                    buttons : true,
                    dangerMode : true
                }).then((willDelete) => {
                    if(willDelete){
                        axios.get('{{ URL::to("alineacion/destroyfilealineacion") }}',{
                            params : {idai:idai}
                        }).then(response => {
                            let row = response.data;
                            if(row.success == "ok"){
                                toastr.success(mss_tmp.deleteFile);
                                commets.loadImgs();
                            }
                        })
                    }
                })
            }
        },
        mounted(){
            this.loadImgs();
        }
    });

    $(".mySelect2").select2();
    $('.testselect2').SumoSelect();
  
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData(document.getElementById("saveInfo"));
        $.ajax("{{ URL::to('alineacion/comentarios?id='.$id) }}", {
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

    function unirTextos(){
        var paso1=document.getElementsByName('paso1');
        var paso2=document.getElementsByName('paso2');
        var paso3=document.getElementsByName('paso3');
        var paso4=document.getElementsByName('paso4');
        var paso6=document.getElementsByName('paso6');
        
        var selectElement = document.getElementById("iddelegacion");
        var texto = "";
        for (var i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].selected) {
               if(selectElement.options[i].text != "--Selecciona delegación--"){
                texto = texto + "(" +selectElement.options[i].text + ")";
               }
            }
        }
        var tc1 = "";
        var tc2 = "";
        var tc3 = "";
        var tc4 = "";
        var tc6 = "";

        var se1 = document.getElementById("text_1");
        var so1 = se1.options[se1.selectedIndex];

        var se2 = document.getElementById("text_2");
        var so2 = se2.options[se2.selectedIndex];

        var se3 = document.getElementById("text_3");
        var so3 = se3.options[se3.selectedIndex];

        var se4 = document.getElementById("text_4");
        var so4 = se4.options[se4.selectedIndex];

        var se6 = document.getElementById("text_6");
        var so6 = se6.options[se6.selectedIndex];

        var ts = "Selecciona Conector";

        if(so1.text != ts){
            tc1 = so1.text;
        }
        if(so2.text != ts){
            tc2 = so2.text;
        }
        if(so3.text != ts){
            tc3 = so3.text;
        }
        if(so4.text != ts){
            tc4 = so4.text;
        }
        if(so6.text != ts){
            tc6 = so6.text;
        }
       
       
        $("#_comentarios").val(paso1[0].value + " " + tc1 +" "+ paso2[0].value + " " + tc2 +" "+ paso3[0].value + " " + tc3 +" "+ paso4[0].value + " " + tc4 +" "+ texto + " " + tc6 +" "+ paso6[0].value);
    }
    function myDelegaciones(){
        var paso1=document.getElementsByName('paso1');
        var paso2=document.getElementsByName('paso2');
        var paso3=document.getElementsByName('paso3');
        var paso4=document.getElementsByName('paso4');
        var paso6=document.getElementsByName('paso6');

        var selectElement = document.getElementById("iddelegacion");
        var texto = "";
        for (var i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].selected) {
               if(selectElement.options[i].text != "--Selecciona delegación--"){
                texto = texto + "(" +selectElement.options[i].text + ")";
               }
            }
        }
        var tc1 = "";
        var tc2 = "";
        var tc3 = "";
        var tc4 = "";
        var tc6 = "";

        var se1 = document.getElementById("text_1");
        var so1 = se1.options[se1.selectedIndex];

        var se2 = document.getElementById("text_2");
        var so2 = se2.options[se2.selectedIndex];

        var se3 = document.getElementById("text_3");
        var so3 = se3.options[se3.selectedIndex];

        var se4 = document.getElementById("text_4");
        var so4 = se4.options[se4.selectedIndex];

        var se6 = document.getElementById("text_6");
        var so6 = se6.options[se6.selectedIndex];

        var ts = "Selecciona Conector";

        if(so1.text != ts){
            tc1 = so1.text;
        }
        if(so2.text != ts){
            tc2 = so2.text;
        }
        if(so3.text != ts){
            tc3 = so3.text;
        }
        if(so4.text != ts){
            tc4 = so4.text;
        }
        if(so6.text != ts){
            tc6 = so6.text;
        }
       
        $("#_comentarios").val(paso1[0].value + " " + tc1 +" "+ paso2[0].value + " " + tc2 +" "+ paso3[0].value + " " + tc3 +" "+ paso4[0].value + " " + tc4 +" "+ texto + " " + tc6 +" "+ paso6[0].value);
    }
  
  
</script>