<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Restablecer contraseña</h2>

		<div>
			Para restablecer tu contraseña, completa el siguiente formulario: {{ URL::to('user/reset', array($token)) }}.
		</div>
	</body>
</html>