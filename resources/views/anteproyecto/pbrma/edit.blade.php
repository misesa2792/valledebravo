<form id="saveInfo" method="post" class="form-horizontal">

<div class="col-md-12">
    <div class="col-md-10 no-padding"></div>
    <div class="col-md-2 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-right">Ejercicio Fiscal</td>
                <th width="50%">{{ $data['anio'] }}</th>
            </tr>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <td class="text-center">PbRM-01a</td>
                <th colspan="3" class="text-center">
                    <div>Programa Anual</div>
                    <div>Dimensión Administrativa del Gasto</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="t-tr-s12 c-text-alt">
               <th width="15%"></th>
               <th class="text-center" width="100">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="t-tr-s12 c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12" style="min-height:500px;">

    <table class="table bg-white">
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

            @foreach ($data['data'] as $p)
            <tr id="tr_{{ $p['id'] }}" class="bg-white">
                <td colspan="2" class="no-borders">
                    <input type="hidden" value="{{ $p['id'] }}" class="form-control" name="ida[]" >
                    <select name="iddep_aux[]" class="mySelectAc{{ $p['id'] }} full-width" required>
                        <option value="">--Select Please--</option>
                        @foreach ($data['rowsDepAux'] as $c)
                            <option value="{{ $c->id }}" @if($c->id == $p['idarea_coordinacion']) selected @endif>{{ $c->no_dep_aux.' '.$c->dep_aux }}</option>
                        @endforeach
                    </select>
                </td>
                <td colspan="2" class="no-borders">
                    <select name="idproyecto[]" class="mySelectProy{{ $p['id'] }} full-width" required>
                        <option value="">--Select Please--</option>
                        @foreach ($data['rowsProyectos'] as $v)
                            <option value="{{ $v->id }}" @if($v->id == $p['idproyecto']) selected @endif>{{ $v->no_proyecto.' '.$v->proyecto }}</option>
                        @endforeach
                    </select>
                    <script>
                        $(".mySelectProy{{ $p['id'] }}").select2();
                        $(".mySelectAc{{ $p['id'] }}").select2();
                    </script>
                </td>
                <td class="no-borders">
                    <input type="text" value="{{ $p['presupuesto'] }}" class="form-control c-text-alt no-borders" placeholder="Presupuesto" name="pres[]" onKeyUp="sumarTab()" required>
                </td>
                <td class="text-center no-borders">
                   <i class="fa fa-trash-o c-danger cursor btndestroyedit s-14" id="{{ $p['id'] }}"></i>
                </td>
            </tr>
        @endforeach

        <tbody id="_tbody" style="border-top: 0px solid #ddd;"></tbody>
        <tr class="t-tr-s12 c-text-alt">
            <td>
                <button class="btn btn-xs btn-primary btn-outline btn-ses" id="btnadd"> <i class="fa fa-plus"></i> </button>
            </td>
            <td colspan="3" class="text-right">Presupuesto Total:</td>
            <td colspan="2" class="text-right">
                <input type="text" value="{{ $data['total'] }}" name="total" class="form-control no-borders c-text bg-white" id="totalgen" readonly >
            </td>
        </tr>
    </table>

</div>

<br>
    <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
        <button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Editar </button>
    </article>
</form>
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

    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
        axios.get('{{ URL::to("anteproyecto/addpbrmatr") }}',{
            params : {idp:"{{ $data['idprograma'] }}",idy:"{{ $idy }}",type:"{{ $type }}",id:"{{ $idarea }}"}
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
                eliminarColumna(time);
            }
          })
    })

    function eliminarColumna(id){
        axios.delete('{{ URL::to("anteproyecto/pbrmatr") }}',{
            params : {id:id}
        }).then(response => {
            let row = response.data;
            if(row.status == "ok"){
                toastr.success(row.message);
                $("#tr_"+id).remove();
                sumarTab();
                vm.$refs.componenteActivo?.rowsProjects();
            }else{
                toastr.warning(row.message);
            }
        })
    }

    $("#saveInfo").on("submit", function(e){
      e.preventDefault();
        var formData = new FormData(document.getElementById("saveInfo"));
            formData.append('type', "{{ $type }}");
            formData.append('idy', "{{ $idy }}");

            $.ajax("{{ URL::to('anteproyecto/updatepbrma?id='.$id) }}", {
                type: 'post',
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".btnsave").prop("disabled",true).html(mss_spinner + " Guardando...");
                },success: function(res){
                    let row = JSON.parse(res);

                    if(row.status == "ok"){
                        vm.$refs.componenteActivo?.rowsProjects();
                        $('#sximo-modal').modal("toggle");
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
    });
</script>