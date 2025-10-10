<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp">


        <table class="table">
            <tr>
                <td width="15%" class="text-center no-borders">
                    <img src="{{ asset('mass/images/tesoreria.png') }}" alt="Tesorería" width="90">
                </td>
                <td class="no-borders text-center">
                    <div style="font-size:33px;border-bottom:10px solid #990033" class="c-black font-bold">TESORERÍA MUNICIPAL</div>
                    <div class="font-bold text-center m-t-xs s-16 c-text-alt">{{ $data['footer']['leyenda'] }}</div>
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td class="no-borders text-center">
                    <div style="font-size:18px;background: #990033;" class="c-white font-bold">SOLICITUD DE ADECUACIÓN PROGRAMÁTICA Y PRESUPUESTAL </div>
                </td>
            </tr>
        </table>

        <article class="col-md-12">
            <div class="col-md-8 no-padding font-bold c-black">
                <div class="col-md-12">
                  <input type="text" value="{{ $data['footer']['t_tesoreria'] }}" name="txt_tesorero_title" class="form-control border-b-1-dashed c-black" placeholder="TESORERO MUNICIPAL" required>
                </div>
                <div class="col-md-12">
                  <input type="text" value="{{ $data['footer']['c_tesoreria'] }}" name="txt_tesorero_cargo" class="form-control border-b-1-dashed c-black" placeholder="CARGO" required>
                </div>
            </div>
            <div class="col-md-4 no-padding">
                <table class="table">
                    <tr>
                        <td class="s-16 no-borders">Lugar y Fecha:</td>
                        <td class="s-16 no-borders">
                            <input type="text" name="fecha" value="{{ $data['fecha'] }}" class="form-control border-b-1-dashed" placeholder="MUNICIPIO, MÉXICO A 00 DE 0000"  required>
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
                <p class="s-16">Por este conducto, solicito a Usted sea tan gentil de efectuar los siguientes movimientos, mediante los traspasos presupuestarios correspondientes  y en su caso las ampliaciones presupuestarias correspondientes, de conformidad con lo establecido en los artículos 317, del Codigo Financiero del Estado de Mexico y Municipios vigente que a continuación se relacionan: </p>
            </div>
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
                @if($data['count'] > 10)
                    @foreach ($data['rowsRegistros'] as $key => $r)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="text-center">{{ $data['dep_int']['clave'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['d_partida'] }}</td>
                            <td class="text-center">{{ $r['d_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            <td class="text-center">{{ $data['dep_ext']['clave'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['a_partida'] }}</td>
                            <td class="text-center">{{ $r['a_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            @if($key == 0)
                                <td class="text-justify" rowspan="{{ $data['count'] }}">{{ $data['justificacion'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else 
                    @foreach ($data['rowsRegistros'] as $key => $r)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="text-center">{{ $data['dep_int']['clave'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['d_partida'] }}</td>
                            <td class="text-center">{{ $r['d_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            <td class="text-center">{{ $data['dep_ext']['clave'] }}</td>
                            <td class="text-center">{{ $r['no_ff'] }}</td>
                            <td class="text-center">{{ $r['a_partida'] }}</td>
                            <td class="text-center">{{ $r['a_mes'] }}</td>
                            <td class="p-rel text-right"> <span class="p-abs" style="left:0px">$</span> {{ $r['importe'] }}</td>
                            @if($key == 0)
                                <td class="text-justify" rowspan="{{ $data['count'] + $data['resta'] }}">{{ $data['justificacion'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                        @for ($i=0 ; $i < $data['resta']; $i++)
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
                    <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span> {{ $data['importe'] }}</th>
                    <td colspan="3" class="no-borders"></td>
                    <th class="no-borders bg-white">Total:</th>
                    <th class="p-rel text-right bg-white"> <span class="p-abs" style="left:0px">$</span> {{ $data['importe'] }}</th>
                </tr>
			</table>
		</article>

      
        <article class="col-md-12 m-t-md">

			<table class="table table-bordered">
			
                <tr class="t-tr-s14 c-text-alt">
                    <td class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="" name="title1" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="COORDINADOR DE APOYO TÉCNICO" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">COORDINADOR DE APOYO TÉCNICO</div>    
                    </td> 
                    <td colspan="2" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="" name="title2" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="DELEGADA ADMINISTRATIVA DE LA TESORERÍA MUNICIPAL" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">DELEGADA ADMINISTRATIVA DE LA TESORERÍA MUNICIPAL</div>    
                    </td>  
                                     
                </tr>

                <tr class="t-tr-s14 c-text-alt">
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $data['footer']['t_prog_pres'] }}" name="title3" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="JEFE DEL DEPTO. DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">JEFE DEL DEPTO. DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL</div>    
                    </td> 
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $data['footer']['t_egresos'] }}" name="title4" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="DIRECTOR DE EGRESOS" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">DIRECTOR DE EGRESOS</div>    
                    </td>  
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $data['footer']['t_tesoreria'] }}" name="title5" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="TESORERO MUNICIPAL" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">TESORERO MUNICIPAL</div>    
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
                formData.append("idam", "{{ $idam }}");
                    $.ajax("{{ URL::to($pageModule.'/generatepdfte') }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".btnsave").prop("disabled",true).html(mss_spinner+" Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);
                            if(row.status == 'ok'){
                                $("#sximo-modal").modal("toggle");
                                proyectos.rowsProjects();
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.number, '_blank');
                                toastr.success(row.message);
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