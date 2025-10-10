<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ CNF_APPNAME }}</title>
		<link rel="shortcut icon" href="{{ asset('ses.ico')}}" type="image/x-icon">
		<link href="{{ asset('mass/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/sesmas.css?v1.24')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/animate.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/icons.min.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<script type="text/javascript" src="{{ asset('mass/js/plugins/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/parsley.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/bootstrap/js/bootstrap.js') }}"></script>
  	</head>

	<body class="gray-bg">
		<div class="middle-box">
			@yield('content')
		</div>
	</body>

</html>
