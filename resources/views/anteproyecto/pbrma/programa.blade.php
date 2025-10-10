<table class="table bg-white border-gray no-margins">
    <tr class="t-tr-s12 c-text-alt">
        <th width="15%" rowspan="2" class="border-gray">Código Dependencia Auxiliar</th>
        <th width="15%" rowspan="2" class="border-gray">Denominación Dependencia Auxiliar</th>
        <th width="50%" colspan="2" class="text-center border-gray">Proyectos Ejecutados</th>
        <th rowspan="2" class="border-gray text-center">Presupuesto autorizado por Proyecto</th>
        <th width="20" rowspan="2" class="border-gray"></th>
    </tr>
    <tr class="t-tr-s12 c-text-alt">
        <th class="border-gray text-center">Clave del Proyecto</th>
        <th class="border-gray text-center">Denominación del Proyecto</th>
    </tr>
    <tbody id="_tbody" style="border-top: 0px solid #ddd;"></tbody>
    <tbody style="border-top: 0px solid #ddd;">
        <tr class="t-tr-s12 c-text-alt">
            <td>
                <button type="button" class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> </button>
            </td>
            <td colspan="3" class="text-right">Presupuesto Total:</td>
            <td colspan="2" class="text-right">
                <input type="text" name="total" class="form-control no-borders c-text bg-white" id="totalgen" readonly>
            </td>
        </tr>
    </tbody>
</table>


<style>
    .select2-container{width:100% !important;}
</style>
<script>
    sumarTab();
    function parseToCents(str) {
    // Quita todo menos dígitos y punto
    str = (str || '').toString().replace(/[^\d.]/g, '');
    if (!str) return 0;

    // Separa enteros y decimales (máx 2)
    const [ent = '0', decRaw = ''] = str.split('.');
    const dec = (decRaw.replace(/\D/g, '').substring(0,2)).padEnd(2, '0');
    return parseInt(ent || '0', 10) * 100 + parseInt(dec || '0', 10);
    }

    function formatFromCents(cents) {
        const sign = cents < 0 ? '-' : '';
        cents = Math.abs(cents);
        const ent = Math.floor(cents / 100).toString();
        const dec = (cents % 100).toString().padStart(2, '0');
        // si quieres miles con coma:
        const entMiles = ent.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return `${sign}${entMiles}.${dec}`;
    }

    function sumarTab(){
        let totalCents = 0;
        const inputs = document.getElementsByName('pres[]');

        for (let i=0; i<inputs.length; i++) {
            totalCents += parseToCents(inputs[i].value);
        }

        // muestra formateado, sin errores de flotante
        const mostrado = formatFromCents(totalCents);
        $("#totalgen").val(mostrado);

        // si vas a enviar al backend, envía también el entero en centavos:
        //$("#totalgen_cents").val(totalCents); // <input type="hidden" id="totalgen_cents" ...>
    }

    agregarTr();

    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
        axios.get('{{ URL::to("anteproyecto/addpbrmatr") }}',{
            params : {idp:"{{ $idp }}",idy:"{{ $idy }}",type:"{{ $type }}",id:"{{ $id }}"}
        }).then(response => {
            $("#_tbody").append(response.data);
        })
    }
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
                sumarTab();
            }
          })
    })
</script>