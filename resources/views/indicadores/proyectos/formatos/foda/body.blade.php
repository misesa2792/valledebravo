<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text-center{text-align:center;}
    .text-justify{text-align:justify;}
    .text-right{text-align:right;}
    .text-left{text-align:left;}
    .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
    .h-45{height:65px;}
    .c-white{color:white;}
    #table tr td,#table tr th{font-size:11px;}
    .border{border:1px solid #f3f3f3;}
    .border-t{border-top:1px solid #f3f3f3;}
    .s-8{font-size:8px;font-size:8px; line-height:1.1;}
    .m-b-xs{margin-bottom:5px;}
    .m-t-sm{margin-top:10px;}
    .m-b-sm{margin-bottom:10px;}
    .text-top{vertical-align: text-top;}
	.bg-body{background: #f8f8f8;}
    .p-2{padding:10px 5px;}
    .p-xxs{padding:5px;}
    .bg-yellow-meta { background: #ffc000;}
    .bg-green-meta { background: #92d050;}
    .bg-blue-meta { background: #9cc2e5;}
    .bg-red-meta { background: #df6b51;}
	.my-table {
        border: 1px solid #000000;
        border-collapse: collapse;
        width: 100%;
        page-break-inside: auto;
	}
	.my-table td,
	.my-table th {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px 3px;
        vertical-align: top;
        font-size: 8px;
        page-break-inside: auto;
	}
    .my-table-no td,
	.my-table-no th {
        border: 0px solid #ffffff;
        padding: 0;
        margin: 0;
	}
    .global-font-size-14{font-size: 11px;}
</style>

<div style="margin-left:25px;margin-right:25px;">
    
    <table id="table" width="100%" cellspacing="0" class="my-table">
        <tr>
            <th width="30%" class="text-left"><div class="s-8">PROGRAMA PRESUPUESTARIO:</div></th>
            <td width="60%"><div class="s-8">{{ $json['header']['no_programa'] }} {{ $json['header']['programa'] }}</div></td>
        </tr>
        <tr>
            <th width="30%" class="text-left"><div class="s-8">OBJETIVO DEL PROGRAMA PRESUPUESTARIO:</div></th>
            <td width="60%"><div class="s-8">{{ $json['header']['obj_programa'] }}</div></td>
        </tr>
        <tr>
            <th width="30%" class="text-left"><div class="s-8">DEPENDENCIA GENERAL:</div></th>
            <td width="60%"><div class="s-8">{{ $json['header']['no_dep_gen'] }} {{ $json['header']['dep_gen'] }}</div></td>
        </tr>
        <tr>
            <th width="30%" class="text-left"><div class="s-8">TEMA DE DESARROLLO:</div></th>
            <td width="60%"><div class="s-8">{{ $tema }}</div></td>
        </tr>
    </table>

<h5 class="text-center s-8">DIAGNÓSTICO DEL PROGRAMA PRESUPUESTARIO USANDO ANÁLISIS FODA</h5>

    <table id="table" width="100%" cellspacing="0" class="my-table">
        <tr>
            <th class="text-center bg-title" width="25%"><div class="s-8">FORTALEZAS</div></th>
            <th class="text-center bg-title" width="25%"><div class="s-8">OPORTUNIDADES</div></th>
            <th class="text-center bg-title" width="25%"><div class="s-8">DEBILIDADES</div></th>
            <th class="text-center bg-title" width="25%"><div class="s-8">AMENAZAS</div></th>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="0" class="my-table-no">
                    @if(isset($json['rowsReg'][1]))
                        @foreach ($json['rowsReg'][1] as $t)
                        <tr>
                            <td>
                                <ul>
                                    <li class="s-8">{{ $t['foda'] }}</li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </td>
            <td>
                <table width="100%" cellspacing="0" class="my-table-no">
                    @if(isset($json['rowsReg'][2]))
                        @foreach ($json['rowsReg'][2] as $t)
                            <tr>
                                <td>
                                    <ul>
                                        <li class="s-8">{{ $t['foda'] }}</li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                </table>
            </td>
            <td>
                <table width="100%" cellspacing="0" class="my-table-no">
                    @if(isset($json['rowsReg'][3]))
                        @foreach ($json['rowsReg'][3] as $t)
                           <tr>
                                <td>
                                    <ul>
                                        <li class="s-8">{{ $t['foda'] }}</li>
                                    </ul>
                                </td>
                           </tr>
                        @endforeach
                    @endif
                </table>
            </td>
            <td>
                <table width="100%" cellspacing="0" class="my-table-no">
                    @if(isset($json['rowsReg'][4]))
                        @foreach ($json['rowsReg'][4] as $t)
                            <tr>
                                <td>
                                    <ul>
                                        <li class="s-8">{{ $t['foda'] }}</li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
    </table>

</div>
