<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp">


        <table class="table">
            <tr>
                <td width="15%" class="text-center no-borders">
                    <img src="{{ asset('mass/images/tesoreria.png') }}" alt="Tesorería" width="90">
                </td>
                <td class="no-borders text-center">
                    <div style="font-size:33px;border-bottom:10px solid #990033" class="c-black font-bold">TESORERÍA MUNICIPAL</div>
                    <div class="font-bold text-center m-t-xs s-16 c-text-alt">{{ $row['header']['leyenda'] }}</div>
                    <div class="font-bold text-center s-16 c-black">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS </div>
                    <div class="font-bold text-center s-16 c-black">FORMATO DE SOLICITUD DE TRASPASOS INTERNOS</div>
                </td>
            </tr>
        </table>



        <article class="col-md-12">
            <div class="col-md-8 no-padding font-bold c-black">
                <div class="col-md-7">
                  <input type="text" value="{{ $row['footer']['tesorero'] }}" name="txt_tesorero_title" class="form-control border-b-1-dashed c-black" placeholder="TESORERO MUNICIPAL" required>
                </div>
                <div class="col-md-12">
                    TESORERO MUNICIPAL
                </div>
            </div>
            <div class="col-md-4 no-padding">
                <table class="table">
                    <tr>
                        <td colspan="2" class="s-16 no-borders">
                            <input type="text" name="fecha" value="{{ $row['header']['municipio'] }}, MÉXICO A {{ date('d') }} {{ mb_strtoupper(SiteHelpers::mes(2)) }} DE {{ date('Y') }}" class="form-control border-b-1-dashed" placeholder="MUNICIPIO, MÉXICO A 00 DE 0000"  required>
                        </td>
                    </tr>
                    <tr>
                        <td class="s-16 no-borders">Oficio:</td>
                        <td class="no-borders">
                            <input type="text" name="oficio" class="form-control border-b-1-dashed" placeholder="00000000000/0-0000-0/0000" required>
                        </td>
                    </tr>
                </table>
            </div>

            <p class="s-16">P R E S E N T E : </p>
            <div>
                <p class="s-16">Por este conducto solicito es tan gentil de efectuar los movimientos, mediante los traspasos presupuestarios correspondientes  y en su caso las ampliaciones presupuestarias, de conformidad con lo establecido en el artículos 317 del Codigo Financiero del Estado de Mexico y Municipios vigente que a continuación se relacionan: </p>
            </div>
        </article>

        <article class="col-md-12 m-t-md">
            <table class="table table-bordered bg-white">
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt">Dependencia:</span> {{ $row['dep_int']['no_dep_gen'].' '.$row['dep_int']['dep_gen'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt">Dependencia Auxiliar:</span> {{ $row['dep_int']['no_dep_aux'].' '.$row['dep_int']['dep_aux'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt">Programa presupuestario:</span> {{ $row['dep_int']['no_programa'].' '.$row['dep_int']['programa'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt">Objetivo:</span> {{ $row['dep_int']['obj_programa'] }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td><span class="c-text-alt">Clave y denominación del Proyecto:</span> {{ $row['dep_int']['no_proyecto'].' '.$row['dep_int']['proyecto'] }}</td>
                </tr>
            </table>
        </article>

        <article class="col-md-12 m-t-md">
			<table class="table table-bordered">
				<tr class="t-tr-s14 c-text-alt">
					<th colspan="5" width="40%" class="text-center bg-white">DISMINUCIÓN</th>
					<th colspan="5" width="40%" class="text-center bg-white">AUMENTO</th>
					<th rowspan="2" class="text-center bg-white">JUSTIFICACIÓN</th>
				</tr>
				<tr class="t-tr-s14 c-text-alt">
					<th class="bg-white text-center">CLAVE <br> PROGRAMATICA</th>
					<th class="bg-white text-center">F.F.</th>
					<th class="bg-white text-center">PARTIDA</th>
					<th class="bg-white text-center">MES</th>
					<th class="bg-white text-center">IMPORTE</th>
					<th class="bg-white text-center">CLAVE <br> PROGRAMATICA</th>
					<th class="bg-white text-center">F.F.</th>
					<th class="bg-white text-center">PARTIDA</th>
					<th class="bg-white text-center">MES</th>
					<th class="bg-white text-center">IMPORTE</th>
				</tr>
                @if($row['count'] > 10)
                    @foreach ($row['rowsRegistros'] as $key => $r)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="text-center">{{ $row['dep_int']['clave_prog'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['d_partida'] }}</td>
                            <td class="text-center">{{ $r['d_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['a_partida'] }}</td>
                            <td class="text-center">{{ $r['a_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            @if($key == 0)
                                <td class="text-justify" rowspan="{{ $row['count'] }}">{{ $row['justificacion'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else 
                    @foreach ($row['rowsRegistros'] as $key => $r)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="text-center">{{ $row['dep_int']['clave_prog'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['d_partida'] }}</td>
                            <td class="text-center">{{ $r['d_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['a_partida'] }}</td>
                            <td class="text-center">{{ $r['a_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            @if($key == 0)
                            <td class="text-justify" rowspan="{{ $row['count'] + $row['resta'] }}">{{ $row['justificacion'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                        @for ($i=0 ; $i < $row['resta']; $i++)
                            <tr class="t-tr-s14 c-text-alt bg-white">
                                <td class="text-center c-white">TI</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                @endif
				<tr class="t-tr-s14 c-text-alt">
                    <td colspan="3" class="no-borders"></td>
                    <th class="no-borders bg-white">Total:</th>
                    <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span> {{ $row['importe'] }}</th>
                    <td colspan="3" class="no-borders"></td>
                    <th class="no-borders bg-white">Total:</th>
                    <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span> {{ $row['importe'] }}</th>
                </tr>
			</table>
		</article>


        
        <article class="col-md-12 m-t-md">

			<table class="table">
				<tr class="t-tr-s14 c-text-alt">
                    <th class="no-borders text-center">Solicitó</th> 
                    <td class="no-borders"></td> 
                    <th class="no-borders text-center">Vo. Bo.</th> 
                    <td class="no-borders"></td> 
                    <th class="no-borders text-center">Autorizó</th> 
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['secretario'] }}" name="txt_secretario" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="SECRETARIO DEL AYUNTAMIENTO" required>
                        <div class="text-center c-text">SECRETARIO DEL AYUNTAMIENTO</div>    
                    </td> 
                    <td class="no-borders"></td>                   
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['uippe'] }}" name="txt_uippe" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="TITULAR DE LA UIPPE" required>
                        <div class="text-center c-text">TITULAR DE LA UIPPE</div>    
                    </td>  
                    <td class="no-borders"></td>                   
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['tesorero'] }}" name="txt_tesorero" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="TESORERO MUNICIPAL" required>
                        <div class="text-center c-text">TESORERO MUNICIPAL</div>    
                    </td>                     
                </tr>

                <tr class="t-tr-s14 c-text-alt">
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['prog_pres'] }}" name="txt_programacion" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="JEFE DEL DEPTO. DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL" required>
                        <div class="text-center c-text">JEFE DEL DEPTO. DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL</div>    
                    </td> 
                    <td class="no-borders"></td>                   
                    <td width="33%" class="no-borders"></td>  
                    <td class="no-borders"></td>                   
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['egresos'] }}" name="txt_egresos" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="DIRECTOR DE EGRESOS" required>
                        <div class="text-center c-text">DIRECTOR DE EGRESOS</div>    
                    </td>                     
                </tr>

			</table>
		</article>

        <article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
        </article>

    </section>
</form>

<script>
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de generar el PDF?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                formData.append("id", "{{ $id }}");
                    $.ajax("{{ URL::to($pageModule.'/generatepdfti?k='.$token) }}", {
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
                                proyectos.rowsProjects();
                                toastr.success(row.message);
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
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