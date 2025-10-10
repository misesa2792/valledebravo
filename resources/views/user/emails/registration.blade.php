<!DOCTYPE html>
<html lang="es-MX">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hola {{ $firstname }} , </h2>
		<p> Gracias por registrate </p>
		<p> A continuación la información de tu cuenta </p>
		<p>
			Email : {{ $email }} <br />
			Contraseña : {{ $password }}<br />
		</p>
		<p> Da clic en <a href="{{ URL::to('user/activation?code='.$code) }}">Activar cuenta</a></p>
		<p> Si no funciona la liga, copia y pega la siguiente dirección en tu browser:</p>
		<p> {{ URL::to('user/activation?code='.$code) }} </p> 
		<br /><br /><p> Gracias </p><br /><br />
		
		{{ CNF_APPNAME }} 
	</body>
</html>