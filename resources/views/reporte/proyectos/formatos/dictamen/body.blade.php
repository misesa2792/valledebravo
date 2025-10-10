<div style="margin-left:25px;margin-right:25px;">
        
    <style>
        .text-center{text-align:center;}
        .text-right{text-align:right;}
        .text-left{text-align:left;}
        .font-14{font-size:14px;}
        .font-10{font-size:10px;}
        .font-8{font-size:8px;}
        .my-table {
            border: 1px solid #6e6e6e;
            border-collapse: collapse;
        }
        .my-table td,
        .my-table th {
            border: 1px solid #6e6e6e;
            border-collapse: collapse;
            padding: 3px;
            font-size: 9px;
        }
        .bg-title{background:rgb(217,217,217);color:rgb(41, 41, 41);}
        .text-uppercase { text-transform: uppercase; }
        .bg-body{background: #f8f8f8;}
    </style>

    <table width="100%" cellspacing="0">
        <tr>
            <td width="50%"></td>
            <td width="50%" >
                <div class="s-8"><strong>FECHA:</strong> {{ $fecha }}</div>
                <div class="s-8"><strong>OFICIO:</strong> {{ $oficio }}</div>
                <div class="s-8"><strong>ASUNTO:</strong> {{ $asunto }}</div>
            </td>
        </tr>
    </table>

    <br>
    <br>
    <h3>{{ $t_uippe }}</h3>
    <h3>TITULAR DE LA UNIDAD DE INFORMACIÓN, PLANEACIÓN,</h3>
    <h3>PROGRAMACIÓN Y EVALUACIÓN.</h3>
    <br>

    <h5>P R E S E N T E</h5>

    <p class="s-8 text-justify">Por este conducto me permito enviar a usted un cordial saludo; así mismo solicito se realicen las adecuaciones programáticas que se encuentran en el formato "Dictamen de Reconducción y Actualización Programática – Presupuestal {{ $json['year'] }}", que adjunto al presente y que corresponden al proyecto presupuestario con los datos siguientes:</p>
    <br>

    <table width="100%" class="my-table">
        <tr>
                <th>No.</th>
                <th>No. de Folio</th>
                <th>Clave Programática</th>
                <th>Programa</th>
                <th>Proyecto</th>
        </tr>
        @foreach ($json['projects'] as $p)
            <tr>
                <td class="text-center">{{ $p['no'] }}</td>
                <td class="text-center"> {{ $p['folio'] }}</td>
                <td>{{ $p['no_proyecto'] }}</td>
                <td>{{ $p['no_programa'] }} {{ $p['programa'] }}</td>
                <td>{{ $p['proyecto'] }}</td>
            </tr> 
        @endforeach
    </table>    

    <br>
    <p class="s-8">Esperando su valioso apoyo, aprovecho la ocasión para reiterar mis más altas consideraciones.</p>
    
    <table id="table" width="100%" >
        <tr>
            <td width="30%" class="text-center"></td>
            <td width="30%" class="text-center p-2">

                <table width="100%" class="my-table">
                    <tr>
                        <th>
                            A T E N T A M E N T E
                            <br><br><br><br>
                            <div class="p-2">{{ $t_dep_gen }}</div>
                        </th>
                    </tr>
                    <tr>
                        <th>{{ $c_dep_gen }}</th>
                    </tr>
                </table>
               
            </td>
            <td width="30%" class="text-center"></td>
        </tr>
    </table>

</div>
