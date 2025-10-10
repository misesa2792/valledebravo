<form id="saveInfo" method="post" class="form-horizontal">
    <table class="table">
        <tr>
            <td class="no-borders" width="10%" rowspan="3">
                @if(!empty($data['footer']['firmas']['logo_izq'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_izq'] ) }}" width="110" height="60">
                @endif
            </td>
            <td class="no-borders text-center font-bold s-14 c-text-alt">SISTEMA DE COORDINACIÓN HACENDARIA DEL ESTADO DE MÉXICO CON SUS MUNICIPIOS</td>
            <td class="no-borders" width="10%" rowspan="3">
                @if(!empty($data['footer']['firmas']['logo_der'] ))
                    <img src="{{ asset($data['footer']['firmas']['logo_der'] ) }}" width="70" height="60">
                @endif
            </td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">MANUAL PARA LA PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTO DE EGRESOS MUNICIPAL {{ $data['anio'] }}</td>
        </tr>
        <tr>
            <td class="no-borders text-center font-bold s-14 c-text-alt">PRESUPUESTO BASADO EN RESULTADOS MUNICIPAL</td>
        </tr>
    </table>


<br>

<div class="col-md-12">
    <div class="col-md-8 no-padding"></div>
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <td>Ejercicio Fiscal</td>
                <th>{{ $data['anio'] }}</th>
            </tr>
            @if($view == 'pdf')
                <tr class="c-text-alt">
                    <td>Fecha</td>
                    <th>
                        <input type="text" name="fecha" value="{{date('Y-m-d')}}" class="form-control date c-black border-b-1-dashed" placeholder="0000-00-00" required>
                    </th>
                </tr>
            @endif
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
                <td>Municipio: </td>
                <th class="text-center">{{ $data['institucion'] }}</th>
                <td>No.</td>
                <th class="text-center">{{ $data['no_institucion'] }}</th>
            </tr>
            <tr class="c-text-alt">
                <td class="text-center">PbRM-01e</td>
                <th colspan="3" class="text-center">
                    <div>Matriz de Indicadores para Resultados por</div>
                    <div>Programa presupuestario y Dependencia General</div>
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 no-padding"></div>
    <div class="col-md-7 no-padding">
        <table class="table table-bordered bg-white">
            <tr class="c-text-alt">
               <th></th>
               <th class="text-center">Clave</th>
               <th class="text-center">Denominación</th>
            </tr>
            <tr class="c-text-alt">
                <th class="text-right">Programa presupuestario: </th>
                <td class="text-center">{{ $data['no_programa'] }}</td>
                <td>{{ $data['programa'] }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="text-right">Objetivo del Programa Presupuestario: </th>
                <td></td>
                <td>{{ $data['obj_programa'] }}</td>
            </tr>
            <tr class="c-text-alt">
                <th class="text-right">Dependencia General:</th>
                <td class="text-center">{{ $data['no_dep_gen'] }}</td>
                <td>{{ $data['dep_gen'] }}</td>
            </tr>
             <tr class="c-text-alt">
                <th class="text-right">Eje de Cambio o Eje transversal:</th>
                <td class="text-center">{{ $data['no_pilar'] }}</td>
                <td>{{ $data['pilar'] }}</td>
            </tr>
             <tr class="c-text-alt">
                <th class="text-right">Tema de Desarrollo:</th>
                <td class="text-center">{{ $data['no_tema'] }}</td>
                <td>{{ $data['tema'] }}</td>
            </tr>
        </table>
    </div>
</div>

<br>


<div class="col-md-12">
   <table class="table table-bordered bg-white">
        <tr class="c-text-alt">
            <th rowspan="2"></th>
            <th rowspan="2" width="25%">Objetivo o resumen narrativo</th>
            <th colspan="3" class="text-center">Indicadores</th>
            <th rowspan="2"  class="text-center">Medios de verificación</th>
            <th rowspan="2"  class="text-center">Supuestos</th>
        </tr>
        <tr class="c-text-alt">
            <th class="text-center">Nombre</th>
            <th class="text-center">Fórmula</th>
            <th class="text-center">Frecuencia y Tipo</th>
        </tr>
       
        <tr class="c-text-alt">
            <td class="text-center-middle s-10">Fin</td>
            <td class="s-10">{{ $data['rows']['fin']->descripcion }}</td>
            <td class="s-10">{{ $data['rows']['fin']->nombre }}</td>
            <td class="s-10">{{ $data['rows']['fin']->formula }}</td>
            <td class="s-10 text-center">
                {{ $data['rows']['fin']->frecuencia }}
                <br>
                {{ $data['rows']['fin']->tipo_indicador }}
            </td>
            <td class="s-10">{{ $data['rows']['fin']->medios }}</td>
            <td class="s-10">{{ $data['rows']['fin']->supuestos }}</td>
        </tr>

         <tr class="c-text-alt">
            <td class="text-center-middle s-10">Propósito</td>
            <td class="s-10">{{ $data['rows']['proposito']->descripcion }}</td>
            <td class="s-10">{{ $data['rows']['proposito']->nombre }}</td>
            <td class="s-10">{{ $data['rows']['proposito']->formula }}</td>
            <td class="s-10 text-center">
                {{ $data['rows']['proposito']->frecuencia }}
                <br>
                {{ $data['rows']['proposito']->tipo_indicador }}
            </td>
            <td class="s-10">{{ $data['rows']['proposito']->medios }}</td>
            <td class="s-10">{{ $data['rows']['proposito']->supuestos }}</td>
        </tr>

        @foreach($data['rows']['componente'] as $ca => $c)
            @if($ca == 0)
                <tr class="c-text-alt s-10">
                    <td rowspan="{{ count($data['rows']['componente']) + 1 }}" class="text-center-middle">Componentes</td>
                </tr>
            @endif

            <tr class="c-text-alt">
                <td class="s-10">{{ $c->descripcion }}</td>
                <td class="s-10">{{ $c->nombre }}</td>
                <td class="s-10">{{ $c->formula }}</td>
                <td class="s-10 text-center">
                    {{ $c->frecuencia }}
                    <br>
                    {{ $c->tipo_indicador }}
                </td>
                <td class="s-10">{{ $c->medios }}</td>
                <td class="s-10">{{ $c->supuestos }}</td>
            </tr>
        @endforeach
    
        @foreach($data['rows']['actividad'] as $ka => $c)
            @if($ka == 0)
                <tr class="c-text-alt s-10">
                    <td rowspan="{{ count($data['rows']['actividad']) + 1 }}" class="text-center-middle">Actividades</td>
                </tr>
            @endif
            <tr class="c-text-alt">
                <td class="s-10">{{ $c->descripcion }} </td>
                <td class="s-10">{{ $c->nombre }}</td>
                <td class="s-10">{{ $c->formula }}</td>
                <td class="s-10 text-center">
                    {{ $c->frecuencia }}
                    <br>
                    {{ $c->tipo_indicador }}
                </td>
                <td class="s-10">{{ $c->medios }}</td>
                <td class="s-10">{{ $c->supuestos }}</td>
            </tr>
        @endforeach
</table>
</div>

    @if($view == 'pdf')
        <div class="col-md-12">
            <table class="table">
                <tr class="c-text">
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">ELABORÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA</div>
                        <br>
                        <input type="text" name="titular1" value="{{ $data['footer']['dg']['titular'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo1" value="{{ $data['footer']['dg']['cargo'] }}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
                    <th class="no-borders"></th>
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">REVISÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA DEPENDENCIA GENERAL</div>
                        <br>
                        <input type="text" name="titular2" value="{{$data['footer']['dg']['titular']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo2" value="{{$data['footer']['dg']['cargo']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
                    <th class="no-borders"></th>
                    <td width="30%" class="text-center bg-white no-borders">
                        <div class="font-bold c-text-alt">AUTORIZÓ</div>
                        <div class="font-bold c-text-alt">TITULAR DE LA UIPPE O SU EQUIVALENTE</div>
                        <br>
                        <input type="text" name="titular3" value="{{$data['footer']['firmas']['t_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA NOMBRE" required>
                        <input type="text" name="cargo3" value="{{$data['footer']['firmas']['c_uippe']}}" onkeyup="MassMayusculas(this);" class="form-control text-center border-b-1-dashed c-black" placeholder="INGRESA CARGO">
                        <div class="col-md-4 c-text-alt">Nombre</div>
                        <div class="col-md-4 c-text-alt">Firma</div>
                        <div class="col-md-4 c-text-alt">Cargo</div>
                    </td>
            </tr>
            </table>
        </div>

        <article class="col-sm-12 col-md-12 text-center m-t-lg m-b-lg">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-outline btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>
            <button type="submit" name="save" class="btn btn-danger btn-sm btnsave"><i class="fa icon-file-pdf"></i> Convertir a PDF</button>
        </article>
    @endif
</form>
<style>
#sximo-modal .modal-dialog {
  max-height: 90%;
  overflow-y: auto !important;
}

#sximo-modal .modal-body {
  max-height: 80vh;
}
.select2-container {
    z-index: 99999 !important;
}
</style>
<script>
    $('.date').datepicker({format: 'yyyy-mm-dd'});
    
    $("#saveInfo").on("submit", function(e){
      e.preventDefault();


      swal({
        title : 'Estás seguro de generar el PDF?',
        icon : 'warning',
        buttons: {
            cancel: {
            text: "No, Cancelar",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true,
            },
            confirm: {
            text: "Sí, generar PDF",
            value: true,
            visible: true,
            className: "btn btn-danger",
            closeModal: true
            }
        },
        dangerMode : true,
		closeOnClickOutside: false
        }).then((willDelete) => {
        if(willDelete){
                var formData = new FormData(document.getElementById("saveInfo"));
                    formData.append('type', "{{ $type }}");

                    $.ajax("{{ URL::to('anteproyecto/pdfpbrme?id='.$id) }}", {
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $(".btnsave").prop("disabled",true).html(mss_spinner + " Generando PDF...");
                        },success: function(res){
                            let row = JSON.parse(res);

                            if(row.status == "ok"){
                                vm.$refs.componenteActivo?.rowsProjects();
                	            $('#sximo-modal').modal("toggle");
                                window.open('{{ URL::to("download/pdf?number=") }}'+row.data.number, '_blank');
                            }else{
                                toastr.warning(row.message);
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