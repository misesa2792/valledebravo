<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-left{text-align:left;}
    .text-justify{text-align:justify;}
    .text-right{text-align:right;}
    .font-bold{font-weight: bold;}
    .c-white{color:white;}
    .p-rel{position: relative;}
    .p-abs{position: absolute;}
    .s-10{font-size:9px;}
    .s-11{font-size:10px;}
    .s-12{font-size:10px;}
    .s-8{font-size:8px;}
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .text-top{vertical-align: text-top;}
    .m-t-md{margin-top:5px;}
    .my-table {
        border: 1px solid #000000;
        border-collapse: collapse;
    }
    .my-table td,
    .my-table th {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px 3px;
        font-size: 8px;
    }

    .my-table-top {
        border: 1px solid #000000;
        border-collapse: collapse;
    }
    .my-table-top td,
    .my-table-top th {
        border-top: 1px solid #000000;
        border-bottom: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px 3px;
        font-size: 8px;
    }

    .color-white{color:#ffffff;}
    .color-gray{color:#adadad;}
    .border-t{border-top:1px solid #000000;}
    .border-b{border-bottom:1px solid #000000;}
   
</style>
<table id="table" width="100%" cellspacing="0">
    <tr>
        <th width="15%" class="s-10 text-right">Tipo de Movimiento:</td>
        <td width="35%">
            <table width="100%">
                <tr>
                    <td class="border-b s-10">Reconducción presupuestal</td>
                </tr>
            </table>
        </td>
        <td width="20%"></td>
        <td width="30%">
            <table width="100%">
                <tr>
                    <th width="30%" class="text-right s-10">No. de Oficio:</th>
                    <td class="border-b s-10 text-left">{{ $request['no_oficio'] }}</td>
                </tr>
                <tr>
                    <th width="30%" class="text-right s-10">Fecha:</th>
                    <td class="border-b s-10 text-left">{{ $request['fecha'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellspacing="0">
    <tr>
        <td width="50%" class="text-top">
            <table width="100%"cellspacing="0" class="my-table-top">
                <tr>
                    <th class="text-center bg-title" colspan="2">Identificación del Proyecto en el que se cancela o reduce.</th>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia General:</td>
                    <td width="70%" class="border-t">{{ $data['dep_int']['no_dep_gen'].' '.$data['dep_int']['dep_gen'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia Auxiliar:</td>
                    <td width="70%" class="border-t">{{ $data['dep_int']['no_dep_aux'].' '.$data['dep_int']['dep_aux'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Programa presupuestario:</td>
                    <td width="70%" height="30" class="border-t">{{ $data['dep_int']['no_programa'].' '.$data['dep_int']['programa'] }}</td>
                </tr>
                <tr>
                    <td width="100%" height="70" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $data['dep_int']['obj_programa'] }}</td>
                </tr>
            </table>
        </td>
        <td width="50%" class="text-top">
            <table width="100%"cellspacing="0" class="my-table-top">
                <tr>
                    <th class="text-center bg-title" colspan="2">Identificación del Proyecto en el que se asigna o se amplia</th>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia General:</td>
                    <td width="70%" class="border-t">{{ $data['dep_ext']['no_dep_gen'].' '.$data['dep_ext']['dep_gen'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Dependencia Auxiliar:</td>
                    <td width="70%" class="border-t">{{ $data['dep_ext']['no_dep_aux'].' '.$data['dep_ext']['dep_aux'] }}</td>
                </tr>
                <tr>
                    <td width="20%" class="border-t">Programa presupuestario:</td>
                    <td width="70%" height="30" class="border-t">{{ $data['dep_ext']['no_programa'].' '.$data['dep_ext']['programa'] }}</td>
                </tr>
                <tr>
                    <td width="100%" height="70" colspan="2" class="border-t"><strong>Objetivo:</strong> {{ $data['dep_ext']['obj_programa'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="table" width="100%" cellspacing="0" class="m-t-md">
    <tr>
        <th width="50%" class="text-top">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title" colspan="6">Identificación de Recursos a nivel de Proyecto que se cancelan o se reducen.</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="bg-title text-center">Clave</th>
                        <th rowspan="2" class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center" colspan="4">Presupuesto</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Autorizado</th>
                        <th class="bg-title text-center">Por ejercer</th>
                        <th class="bg-title text-center">Por cancelar o reducir</th>
                        <th class="bg-title text-center">Autorizado modificado</th>
                    </tr>
                    <tr>
                        <td class="s-8 bg-white text-center" height="45">{{ $data['dep_int']['no_proyecto'].' '.$data['dep_int']['clasificacion'] }}</td>
                        <td class="s-8 bg-white">{{ $data['dep_int']['proyecto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $data['dep_int']['presupuesto'] }}</td>
                        <td class="s-8 bg-white text-right"></td>
                        <td class="s-8 bg-white text-right">{{ $data['importe'] }}</td>
                        <td class="s-8 bg-white text-right"></td>
                    </tr>
                </table>
            </div>
        </th>
        <th width="50%" class="text-top">
                <table width="100%" cellspacing="0" class="my-table">
                    <tr>
                        <th class="bg-title" colspan="6">Identificación de Recursos a nivel de Proyecto que se amplían o se asignan.</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="bg-title text-center">Clave</th>
                        <th rowspan="2" class="bg-title text-center">Denominación</th>
                        <th class="bg-title text-center" colspan="4">Presupuesto</th>
                    </tr>
                    <tr>
                        <th class="bg-title text-center">Autorizado</th>
                        <th class="bg-title text-center">Ampliación y/o Reasignación</th>
                        <th class="bg-title text-center">Autorizado Modificado</th>
                    </tr>
                    <tr>
                        <td class="s-8 bg-white text-center" height="45">{{ $data['dep_ext']['no_proyecto'].' '.$data['dep_ext']['clasificacion'] }}</td>
                        <td class="s-8 bg-white">{{ $data['dep_ext']['proyecto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $data['dep_ext']['presupuesto'] }}</td>
                        <td class="s-8 bg-white text-right">{{ $data['importe'] }}</td>
                        <td class="s-8 bg-white text-right"></td>
                    </tr>
                </table>
        </th>
    </tr>
</table>

<table width="100%" cellspacing="0" class="m-t-md">
    <tr>
        <td width="50%" class="text-top">
            <table width="100%" cellspacing="0">
                <tr>
                    <th class="text-center s-8">Metas de Actividad Programadas y alcanzadas del Proyecto a cancelar o Reducir.</th>
                </tr>
            </table>

            <table class="my-table" width="100%" cellspacing="0">
                <tr>
                    <th class="bg-title" rowspan="2" style="height:80px;">Código</th>
                    <th class="bg-title" rowspan="2">Descripción</th>
                    <th class="bg-title" rowspan="2">Unidad de medida</th>
                    <th class="bg-title" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                    <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                </tr>
                <tr>
                    <th class="bg-title">Inicial</th>
                    <th class="bg-title">Avance</th>
                    <th class="bg-title">Modificada</th>
                    <th class="bg-title text-center" width="50">1</th>
                    <th class="bg-title text-center" width="50">2</th>
                    <th class="bg-title text-center" width="50">3</th>
                    <th class="bg-title text-center" width="50">4</th>
                </tr>
                    <tr>
                        <td class="c-white bg-white" colspan="10" height="25">D</td>
                    </tr>
            </table>
        </td>
        <td width="50%" class="text-top">
            <table width="100%" cellspacing="0">
                <tr>
                    <th class="text-center s-8">Metas de Actividad Programadas y alcanzadas del Proyecto que se crea o incrementa.</th>
                </tr>
            </table>

            <table class="my-table" width="100%" cellspacing="0">
                <tr>
                    <th class="bg-title" rowspan="2" style="height:80px;">Código</th>
                    <th class="bg-title" rowspan="2">Descripción</th>
                    <th class="bg-title" rowspan="2">Unidad de medida</th>
                    <th class="bg-title" colspan="3">Cantidad Programada de la Meta de Actividad</th>
                    <th class="bg-title text-center" colspan="4">Calendarizacion trimestral modificada</th>
                </tr>
                <tr>
                    <th class="bg-title">Inicial</th>
                    <th class="bg-title">Avance</th>
                    <th class="bg-title">Modificada</th>
                    <th class="bg-title text-center" width="50">1</th>
                    <th class="bg-title text-center" width="50">2</th>
                    <th class="bg-title text-center" width="50">3</th>
                    <th class="bg-title text-center" width="50">4</th>
                </tr>
                <tr>
                    <tr>
                        <td class="c-white bg-white" colspan="10" height="25">D</td>
                    </tr>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellspacing="0" class="m-t-md">
    <tr>
        <td>
            <table width="30%" class="my-table" cellspacing="0">
                <tr>
                    <th class="text-left">Justificación</th> 
                </tr>
            </table>
            <table width="100%" class="my-table" cellspacing="0">
                <tr>
                    <td class="text-left">
                        <strong>De la cancelación o reducción de metas de actividad y/o recursos del Proyecto. (impacto o repercusión programática)</strong>
                        <div>{{ $request['texto1'] }}</div>    
                    </td> 
                </tr>
                <tr>
                    <td class="text-left">
                        <strong>De creación o reasignación de metas de actividad y/o recursos al proyecto (Beneficio, Impacto, Repercusión programática).</strong>
                        <div>{{ $request['texto2'] }}</div>    
                    </td> 
                </tr>
                <tr>
                    <td class="text-left">
                        <strong>Identificación del Origen de los recursos.</strong>
                        <div>{{ $request['texto3'] }}</div>    
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
</table>