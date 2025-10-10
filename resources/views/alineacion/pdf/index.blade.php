<html>
    <head>
        <title></title>
		<style>
            th{font-size: 10px;}
            td{font-size: 10px;}
            .bg-danger{background:#fddfe0;color:#000;}
            .bg-success{background:#e5f8d0;color:#000;}
            .bg-blue{background:#d0d1f8;color:#000;}
          </style>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    </head>
    <body>
            <table border="1">
                <tr>
                    <th>Titulos</th>
                    <th>Número</th>
                    <th>Descripcion</th>
                </tr>
                @foreach (json_decode($rows) as $p)
                @endforeach
            </table>
    </body>
</html>