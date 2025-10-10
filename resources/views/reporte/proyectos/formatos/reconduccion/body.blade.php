
<style>
    .text-center{text-align:center;}
    .text-right{text-align:right;}
    .text-left{text-align:left;}
    .font-bold{font-weight: bold;}
    .f-12{font-size:7px;}
    .f-8{font-size:8px;}
    .my-table {
        border: 0.1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 0.1px solid #000000;
        border-collapse: collapse;
        padding: 2px;
        font-size: 7px;
        font-family: Inter, sans-serif;
    }
    .p-md{padding:3px}
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .color-white{color:#ffffff;}
    .text-top{vertical-align: text-top;}
    #table2 tr td,#table tr th{font-size:7px;border: none;color:rgb(41, 41, 41);}
    .border-bottom{border-bottom:0.1px solid #000000;}
</style>
<div>
    <table width="100%" cellspacing="0">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <th class="f-12 text-right">Tipo de Movimiento:</th>
                        <td class="f-12 border-bottom">MOVIMIENTO DE ADECUACIÓN PROGRAMÁTICA</td>
                    </tr>
                </table>
            </td>

            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <th width="50%" class="text-right f-12">No. de Oficio:</th>
                        <td width="50%" class="text-left f-12 border-bottom">{{ $oficio }}</td>
                    </tr>
                    <tr>
                        <th width="50%" class="text-right f-12">Fecha:</th>
                        <td width="50%" class="text-left f-12 border-bottom">{{ $fecha }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        
    <div style="padding-top:5px;"></div>

        <table id="table" width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th width="50%">
                <table width="100%" class="my-table">
                    <tr>
                        <th class="bg-title">Identificación del Proyecto en el que se cancela o reduce</th>
                    </tr>
                </table>
            </th>
            <th width="50%">
                <table width="100%" class="my-table">
                    <tr>
                        <th class="bg-title">Identificación del Proyecto en el que se asigna o amplia</th>
                    </tr>
                </table>
            </th>
        </tr>
        </table>
        
        <table id="table" width="100%" cellspacing="0">
        <tr>
            <td width="50%">
                <table class="my-table" width="100%" cellspacing="0" >
                    <tr>
                        <td width="20%">Dependencia General:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Dependencia Auxiliar:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Programa presupuestario:</td>
                        <td width="70%">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Proyecto presupuestario:</td>
                        <td width="70%">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="my-table" width="100%" cellspacing="0">
                    <tr>
                        <td width="20%">Dependencia General:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_gen'] }} {{ $json['proyecto']['dep_gen'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Dependencia Auxiliar:</td>
                        <td width="70%">{{ $json['proyecto']['no_dep_aux'] }} {{ $json['proyecto']['dep_aux'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Programa presupuestario:</td>
                        <td width="70%">{{ $json['proyecto']['no_programa'] }} {{ $json['proyecto']['programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2"><strong>Objetivo:</strong> {{ $json['proyecto']['obj_programa'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%">Proyecto presupuestario:</td>
                        <td width="70%">{{ $json['proyecto']['no_proyecto'] }} {{ $json['proyecto']['proyecto'] }}</td>
                    </tr>
                </table>
            </td>
          
        </tr>
        </table>

        <div class="p-md"></div>

        <table id="table" width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th width="50%">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title">Identificación de Recursos a nivel de Proyecto que se cancelan  o se reducen</th>
                    </tr>
                </table>
            </th>
            <th width="50%">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title">Identificación de Recursos a nivel de Proyecto que se amplian o se asignan</th>
                    </tr>
                </table>
            </th>
        </tr>
        </table>
        
        <table id="table" width="100%" cellspacing="0">
        <tr>
            <th width="50%">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title text-center">Clave</th>
                        <th class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center">Presupuesto</th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <br>
                            <br>
                        </td>
                    </tr>
                    
                </table>
            </th>
            <th width="50%">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title text-center">Clave</th>
                        <th class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center">Presupuesto</th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <br>
                            <br>
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        </table>

        <div class="p-md"></div>
        
        <table width="100%" cellspacing="0" class="m-t-sm">
        <tr>
            <th width="50%">
                <table width="100%" id="table2">
                    <tr>
                        <th class="f-12">Metas de Actividad  Programadas y alcanzadas del proyecto a cancelar o reducir</th>
                    </tr>
                </table>
            </th>
            <th width="50%">
                <table width="100%" id="table2">
                    <tr>
                        <th class="f-12">Metas de Actividad Programadas y alcanzadas del proyecto que se crea o incrementa</th>
                    </tr>
                </table>
            </th>
        </tr>
        </table>
        
        <table cellspacing="0" width="100%" >
        <tr>
            <td width="50%" class="text-top">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title" rowspan="2">Código</th>
                        <th class="bg-title" rowspan="2">Descripción</th>
                        <th class="bg-title" rowspan="2">Unidad de medida</th>
                        <th class="bg-title text-center" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                        <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Inicial</th>
                        <th class="bg-title text-center">Avance</th>
                        <th class="bg-title text-center">Modificada</th>
                        <th class="bg-title text-center" width="50">1</th>
                        <th class="bg-title text-center" width="50">2</th>
                        <th class="bg-title text-center" width="50">3</th>
                        <th class="bg-title text-center" width="50">4</th>
                    </tr>
                    @foreach ($json['metas']['arr_reduce'] as $v)
                        <tr>
                            <td class="text-center">{{ $v['ico'] }}</td>
                            <td>{{ $v['ime'] }}</td>
                            <td>{{ $v['ium'] }}</td>
                            <td class="text-center">{{ $v['iti'] }}</td>
                            <td class="text-center">{{ $v['ita'] }}</td>
                            <td class="text-center">{{ $v['itm'] }}</td>
                            <td class="text-center">{{ $v['it1'] }}</td>
                            <td class="text-center">{{ $v['it2'] }}</td>
                            <td class="text-center">{{ $v['it3'] }}</td>
                            <td class="text-center">{{ $v['it4'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td width="50%" class="text-top">
                <table width="100%" cellspacing="0"  class="my-table">
                    <tr>
                        <th class="bg-title" rowspan="2">Código</th>
                        <th class="bg-title" rowspan="2">Descripción</th>
                        <th class="bg-title" rowspan="2">Unidad de medida</th>
                        <th class="bg-title text-center" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                        <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Inicial</th>
                        <th class="bg-title text-center">Avance</th>
                        <th class="bg-title text-center">Modificada</th>
                        <th class="bg-title text-center" width="50">1</th>
                        <th class="bg-title text-center" width="50">2</th>
                        <th class="bg-title text-center" width="50">3</th>
                        <th class="bg-title text-center" width="50">4</th>
                    </tr>
                    @foreach ($json['metas']['arr_amplia'] as $v)
                        <tr>
                            <td class="text-center">{{ $v['ico'] }}</td>
                            <td>{{ $v['ime'] }}</td>
                            <td>{{ $v['ium'] }}</td>
                            <td class="text-center">{{ $v['iti'] }}</td>
                            <td class="text-center">{{ $v['ita'] }}</td>
                            <td class="text-center">{{ $v['itm'] }}</td>
                            <td class="text-center">{{ $v['it1'] }}</td>
                            <td class="text-center">{{ $v['it2'] }}</td>
                            <td class="text-center">{{ $v['it3'] }}</td>
                            <td class="text-center">{{ $v['it4'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        </table>

        <div class="p-md"></div>

        <table width="100%" cellspacing="0">
            <tr>
                <th width="30%">
                    <table width="100%" cellspacing="0" class="my-table">
                        <tr>
                            <th class="text-left bg-title">Justificación:</th>
                        </tr>
                    </table>
                </th>
                <td width="70%"></td>
            </tr>
        </table>

        <div class="p-md"></div>
        
        <table width="100%" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" class="my-table">
                        <tr>
                            <td>
                                <div>
                                    <strong>De la cancelación o reducción de metas y/o recursos del proyecto (impacto o recuperación programática).</strong>
                                </div>
            
                                <table width="100%" cellspacing="0" id="table2">
                                    @foreach ($json['metas']['arr_reduce']  as $v)
                                        @if(!empty($v['iob']))
                                            <tr>
                                                <td>{{ $v['ico'] }} {{ $v['iob'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
       </table>


        <table width="100%" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" class="my-table">
                        <tr>
                            <td>
                                <div>
                                    <strong>De la creación o reasignación de metas y/o recurso al proyecto.</strong>
                                </div>
                                
                                <table width="100%" cellspacing="0" id="table2">
                                    @foreach ($json['metas']['arr_amplia'] as $v)
                                        @if(!empty($v['iob']))
                                            <tr>
                                                <td>{{ $v['ico'] }} {{ $v['iob'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table width="100%" cellspacing="0">
        <tr>
            <td>
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="text-left border">Identificación del Origen de los recursos.</th>
                    </tr>
                </table>
            </td>
        </tr>
       </table>
</div>