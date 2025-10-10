<table class="table table-bordered">
    <tr>
        <th width="15%">Código Dependencia Auxiliar</th>
        <th width="15%">Denominación Dependencia Auxiliar</th>
        <th width="15%">Clave del Proyecto</th>
        <th width="15%">Denominación del Proyecto</th>
        <th>Presupuesto autorizado por Proyecto</th>
        <th width="20"></th>
    </tr>
    <tbody id="_tbody" class="no-borders"></tbody>
    <tr>
        <td colspan="4" class="text-right bg-white s-16 c-text-alt">Presupuesto Total:</td>
        <td colspan="2" class="text-right bg-white">
            <input type="text" name="total" class="form-control no-borders c-success" id="totalgen" readonly style="height:30px;background:transparent;font-size:25px !important;">
        </td>
    </tr>
    <tbody class="no-borders">
        <tr>
            <td class="no-borders">
                <button class="btn btn-xs btn-info" id="btnadd"> <i class="fa fa-plus"></i> </button>
            </td>
        </tr>
    </tbody>
</table>

<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
    <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>
</article>
<style>
    .select2-container{width:100% !important;}
</style>
<script>
    sumarTab();
    function sumarTab(){
        let cantidad = 0;
        var cant=document.getElementsByName('pres[]');
        for(key=0; key < cant.length; key++)  {
            var idtt = cant[key].id;
            if(cant[key].value != ''){
                var valor = cant[key].value;
                cantidad = cantidad + parseFloat(valor.replace(/[^0-9.]/g, ''));
            }
        }
        let numeroFormateadoMX = cantidad.toLocaleString('es-MX');
        $("#totalgen").val(numeroFormateadoMX);
    }
     agregarTr();
    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
        axios.get('{{ URL::to("anteproyecto/addpbrmatr") }}',{
            params : {idp:"{{ $idp }}",idy:"{{ $idy }}",type:"{{ $type }}"}
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