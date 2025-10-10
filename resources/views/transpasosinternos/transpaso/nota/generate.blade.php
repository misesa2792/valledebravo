<form id="saveInfo" method="post" class="form-horizontal">
    <section class="table-resp">


        <table class="table">
            <tr>
                <td width="15%" class="text-center no-borders">
                    <img src="{{ asset('mass/images/tesoreria.png') }}" alt="Tesorería" width="90">
                </td>
                <td class="no-borders text-center">
                    <div class="font-bold text-center s-16 c-black">H. AYUNTAMIENTO DE {{ $row['header']['municipio'] }} </div>
                    <div class="font-bold text-center s-16 c-black">DIRECCIÓN DE PLANEACIÓN, PROGRAMACIÓN, EVALUACIÓN Y ESTADÍSTICA</div>
                    <div class="font-bold text-center s-16 c-black">NOTAS DE RECONDUCCION Y ACTUALIZACION PROGRAMÁTICA - PRESUPUESTAL</div>
                </td>
            </tr>
        </table>



        <article class="col-md-12">
            <div class="col-md-8 no-padding font-bold c-black">
                Tipo de Movimiento: Reconducción programático-presupuestal
            </div>
            <div class="col-md-4 no-padding">
                <table class="table">
                    
                    <tr>
                        <td class="s-16 no-borders">No. de Oficio:</td>
                        <td class="no-borders">
                            <input type="text" value="{{ $row['oficio'] }}" name="oficio" class="form-control border-b-1-dashed" placeholder="00000000000/0-0000-0/0000" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="s-16 no-borders">Fecha:</td>
                        <td class="s-16 no-borders">
                            <input type="text" name="fecha" value="{{ $row['header']['municipio'] }}, MÉXICO A {{ date('d') }} {{ mb_strtoupper(SiteHelpers::mes(1)) }} DE {{ date('Y') }}" class="form-control border-b-1-dashed" placeholder="MUNICIPIO, MÉXICO A 00 DE 0000"  required>
                        </td>
                    </tr>
                </table>
            </div>
          
        </article>


        <article class="col-md-12 m-t-md">
			<table class="table table-bordered">
				<tr class="t-tr-s14 c-text-alt">
					<th class="bg-white text-center">CLAVE DEL PROYECTO</th>
					<th class="bg-white text-center">DENOMINACIÓN</th>
					<th class="bg-white text-center" width="23%">DE LA CANCELACIÓN O REDUCCIÓN DE METAS Y/O RECURSOS DEL PROYECTO (IMPACTO O RECUPERACIÓN PROGRAMÁTICA)</th>
					<th class="bg-white text-center" width="23%">DE LA CREACIÓN, REASIGNACIÓN DE METAS Y /O RECURSOS AL PROYECTO (BENEFICIO, IMPACTO, REPERCUCIÓN PROGRAMÁTICA)</th>
					<th class="bg-white text-center" width="23%">IDENTIFICACIÓN DEL ORIGEN DE LOS RECURSOS</th>
				</tr>
                    @foreach ($row['rowsRegistros'] as $key => $r)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="text-center">{{ $row['dep_ext']['clave_prog'] }}</td>
                            <td class="text-center">{{ $row['dep_ext']['proyecto'] }}</td>
                            <td>
                                <textarea name="texto1" class="form-control" rows="5" placeholder="DE LA CANCELACIÓN O REDUCCIÓN DE METAS Y/O RECURSOS DEL PROYECTO (IMPACTO O RECUPERACIÓN PROGRAMÁTICA)" required>Sin Afectación</textarea>
                            </td>
                            <td>
                                <textarea name="texto2" class="form-control" rows="5" placeholder="DE LA CREACIÓN, REASIGNACIÓN DE METAS Y /O RECURSOS AL PROYECTO (BENEFICIO, IMPACTO, REPERCUCIÓN PROGRAMÁTICA)" required>Sin Afectación</textarea>
                            </td>
                            <td>
                                <textarea name="identificacion" class="form-control" rows="5" placeholder="IDENTIFICACIÓN DEL ORIGEN DE LOS RECURSOS" required>Reducción de recursos del programa {{ $row['dep_int']['clave_prog'] }}, de la partida {{ $r['d_partida'] }} por $ {{ $r['importe'] }} que se destinará a la partida {{ $r['a_partida'] }}. Fuente de financiamiento {{ $r['no_ff'] }}, {{ $r['ff'] }}</textarea>
                            </td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < 5; $i++)
                        <tr class="t-tr-s14 c-text-alt bg-white">
                            <td class="c-white">T</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
			</table>
		</article>

        <article class="col-md-12 m-t-md">

			<table class="table">
				<tr class="t-tr-s14 c-text-alt">
                    <th class="no-borders text-center">ELABORÓ (DEP. GENERAL)</th> 
                    <td class="no-borders"></td> 
                    <th class="no-borders text-center">REVISÓ (TITULAR DE UIPPE O EQUIVALENTE)</th> 
                    <td class="no-borders"></td> 
                    <th class="no-borders text-center">AUTORIZÓ (ENCARGADA DEL DESPACHO DE LA TESORERÍA MUNICIPAL)</th> 
                </tr>
                <tr class="t-tr-s14 c-text-alt">
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['dep_gen'] }}" name="txt_dep_gen" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="DEP. GENERAL" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">NOMBRE Y FIRMA</div>    
                    </td> 
                    <td class="no-borders"></td>                   
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['uippe'] }}" name="txt_uippe" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="TITULAR DE UIPPE O EQUIVALENTE" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">NOMBRE Y FIRMA</div>    
                    </td>  
                    <td class="no-borders"></td>                   
                    <td width="33%" class="bg-white">
                        <br>    
                        <br>
                        <br>
                        <input type="text" value="{{ $row['footer']['tesorero'] }}" name="txt_tesorero" class="form-control border-b-1-dashed text-center c-black font-bold" placeholder="AUTORIZÓ (ENCARGADA DEL DESPACHO DE LA TESORERÍA MUNICIPAL)" onkeyup="MassMayusculas(this);" required>
                        <div class="text-center c-text">NOMBRE Y FIRMA</div>    
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
                    $.ajax("{{ URL::to($pageModule.'/generatepdfnota?k='.$token) }}", {
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