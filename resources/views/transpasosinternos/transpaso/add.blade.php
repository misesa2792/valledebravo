<article class="col-md-12">
    <table class="table">
        <tr class="t-tr-s14 c-text-alt">
            <th colspan="5" width="49%" class="text-center bg-white">DISMINUCIÓN</th>
            <th class="no-borders" width="5"></th>
            <th colspan="5" width="49%" class="text-center bg-white">AUMENTO</th>
        </tr>
        <tr class="t-tr-s14 c-text-alt">
            <th class="bg-white">CLAVE PROGRAMATICA</th>
            <th class="bg-white">F.F.</th>
            <th class="bg-white">PARTIDA</th>
            <th class="bg-white">MES</th>
            <th class="bg-white">IMPORTE</th>
            <th class="no-borders" width="5"></th>
            <th class="bg-white">CLAVE <br> PROGRAMATICA</th>
            <th class="bg-white">F.F.</th>
            <th class="bg-white">PARTIDA</th>
            <th class="bg-white">MES</th>
            <th class="bg-white">IMPORTE</th>
        </tr>
     
        <tbody>
            <tr id="tr_{{ $time }}">
                <td class="bg-white s-14">{{ $clave_int }}</td>
                <td class="bg-white" width="10%">
                     <select name="d_ff[]" class="mySelect{{ $time }} full-width btnselectfuente" required onchange="handleChange(this, '{{ $time }}')">
                         <option value="">--Select Please--</option>
                         @foreach ($rowsFF as $v)
                             <option value="{{ $v->id }}" data-texto="{{ $v->no_fuente.' '.$v->fuente }}">{{ $v->no_fuente.' '.$v->fuente }}</option>
                         @endforeach
                     </select>
                </td>
                <td class="bg-white" width="10%">
                     <select name="d_partida[]" class="mySelect{{ $time }} full-width" required>
                         <option value="">--Select Please--</option>
                         @foreach ($rowsPartidas as $v)
                             <option value="{{ $v->id }}">{{ $v->no_partida.' '.$v->partida }}</option>
                         @endforeach
                     </select>
                </td>
                <td class="bg-white" width="5%">
                     <select name="d_mes[]" class="form-control form-control-ses" required>
                         <option value="">--Select Please--</option>
                         @foreach ($rowsMes as $r)
                         <option value="{{ $r->idmes }}">{{ $r->mes }}</option>
                         @endforeach
                     </select>
                </td>
                <td class="bg-white">
                 <input type="text" name="d_importe[]" class="form-control no-borders form-control-ses" placeholder="Importe" id="d_importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
                </td>
             
                <td class="no-borders"></td>
                
                <td class="bg-white s-14" >{{ $clave_ext }}</td>
                <td class="bg-white" width="10%" id="div_partida_{{ $time }}"></td>
                <td class="bg-white" width="10%">
                     <select name="a_partida[]" class="mySelect{{ $time }} full-width" required>
                         <option value="">--Select Please--</option>
                         @foreach ($rowsPartidas as $v)
                             <option value="{{ $v->id }}">{{ $v->no_partida.' '.$v->partida }}</option>
                         @endforeach
                     </select>
                </td>
                <td class="bg-white" width="5%">
                     <select name="a_mes[]" class="form-control form-control-ses" required>
                         <option value="">--Select Please--</option>
                         @foreach ($rowsMes as $r)
                         <option value="{{ $r->idmes }}">{{ $r->mes }}</option>
                         @endforeach
                     </select>
                </td>
                <td class="bg-white">
                 <input type="text" name="a_importe[]" class="form-control no-borders form-control-ses" id="a_importe{{ $time }}" placeholder="Importe" readonly>
                </td>
             
                <td class="text-center no-borders"></td>
             </tr>
        </tbody>

        <tbody id="_tbody" class="no-borders"></tbody>
    
       
        <tbody class="no-borders">
            <tr class="t-tr-s14">
                <td class="no-borders">
                    <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses btnagregar" > <i class="fa fa-plus"></i> Agregar</button>
                </td>
                <td></td>
                <td></td>
                <th class=" c-text-alt">Total:</th>
                <td>
                    <input type="text" name="importe" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                </td>

                <td class="no-borders"></td>

                <td></td>
                <td></td>
                <td></td>
                <th class=" c-text-alt">Total:</th>
                <td>
                    <input type="text" class="form-control form-control-ses txtimporte" placeholder="Importe" readonly required>
                </td>
            </tr>
        </tbody>
    </table>
</article>

<article class="col-md-12 m-t-md">
    <table class="table table-bordered bg-white">
        <tr class="t-tr-s16">
            <th width="60%" class="c-text-alt no-borders">JUSTIFICACIÓN</th>
            <th class="text-right no-borders"><p id="contadorCaracteresJust" class="c-danger">Carácteres restantes: 500</p></th>
        </tr>
        <tr class="t-tr-s16">
            <td colspan="2">
                <div style="min-height: 80px;">
                    <textarea name="justificacion" id="txtjustificacion" rows="5" class="form-control no-borders bg-transparent" placeholder="Justificación" required></textarea>
                </div>
            </td>
        </tr>
    </table> 
</article>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>

<script>
     function handleChange(selectElement, time) {
       // Obtén el valor seleccionado
       const selectedValue = selectElement.value;

        // Obtén el texto del atributo `data-texto` del <option> seleccionado
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const dataTexto = selectedOption.getAttribute('data-texto');

        $("#div_partida_"+time).html(dataTexto);
    }

    $(".mySelect{{ $time }}").select2();

    limitarCaracteres('txtjustificacion', 'contadorCaracteresJust', 500);

    $(".btnagregar").click(function(e){
    e.preventDefault();
        let clave_int = $("#clave_programatica_int").val();
        let clave_ext = $("#clave_programatica_ext").val();

        let btnagregar = '<i class="fa fa-plus"></i> Agregar';

        $(".btnagregar").prop("disabled",true).html(mss_spinner);

        axios.get('{{ URL::to("transpasosinternos/addtr") }}',{
            params : {clave_int:clave_int,clave_ext:clave_ext, idyear: "{{ $idyear }}", k:"{{ $token }}"},
        }).then(response => {
            var row = response.data;
            $("#_tbody").append(response.data);
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).catch(error => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        }).finally(() => {
            $(".btnagregar").prop("disabled",false).html(btnagregar);
        });
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

    
</script>