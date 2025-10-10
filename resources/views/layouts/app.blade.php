<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{ CNF_APPNAME }} </title>
<meta name="keywords" content="">
<meta name="description" content=""/>
<link rel="shortcut icon" href="{{ asset('ses.ico')}}" type="image/x-icon">

		<link href="{{ asset('mass/js/plugins/bootstrap/css/bootstrap.css?v1.3')}}" rel="stylesheet">
		<link href="{{ asset('mass/js/plugins/datepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/animate.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/icons.min.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/js/plugins/toastr/toastr.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/fonts/poppins.css')}}" rel="stylesheet">
		<link href="{{ asset('mass/css/sesmas.css?v2.81')}}" rel="stylesheet">
		<link href="{{ asset('mass/js/plugins/select2/select2-4.1.0.min.css')}}" rel="stylesheet">

		<script type="text/javascript" src="{{ asset('mass/js/plugins/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/jquery.cookie.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/toastr/toastr.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/vue/vuemin.js?v1.1') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/axios/axios.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/plugins/select2/select2-4.1.0.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mass/js/sesmas.js?v1.18') }}"></script>

	{{--
		vue local vue.js, produccion vuemin.js
		--}}
  	</head>
  	<body class="sxim-init" >
	<div id="wrapper" >
		@include('layouts/sidemenu')
		<div id="page-wrapper">
			@include('layouts/headmenu')

			@yield('content')
		</div>

		<div class="footer fixed">
		    <div class="pull-right">
		         <strong>{{ CNF_APPDESC }}</strong>
		    </div>
		    <div>
		        <strong>Copyright</strong> &copy; 2023-{{ date('Y')}} . {{ CNF_COMNAME }}
		    </div>
		</div>

	</div>

<div class="modal fade" id="modal_inventario" tabindex="-1" role="dialog" style="z-index:999999;"><div class="modal-dialog tamanoMass"><div class="modal-content"><div class="modal-header bg-default"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title sximo-modal-add-files-title tituloMass"></h4></div><div id="cont_mss_res"><div id="cont_mss_hijo"></div></div><div class="table-resp p-md bg-body" id="resultado"></div></div></div></div>
<div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog tamano">
		<div class="modal-content">
			<div class="modal-header bg-default">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title sximo-modal-add-files-title titulo"></h4>
			</div>
			<div id="cont_mass_res">
				<div id="cont_mass_hijo"></div>
			</div>
			<div class="table-resp p-md bg-body" id="sximo-modal-content"></div>
		</div>
	</div>
</div>

<style>
	#cont_mass_res{display: table;width:100%;}
	#cont_mass_hijo{display: table-cell;vertical-align: middle;text-align: center;}
	#cont_mss_res{display: table;width:100%;}
	#cont_mss_hijo{display: table-cell;vertical-align: middle;text-align: center;}
</style>


{{ Sitehelpers::showNotification() }}

<script type="text/javascript">
function modalMisesa(url, datos, title, size){
		$('#sximo-modal').modal({backdrop: 'static', keyboard: false});
		$(".tamano").css('width',size);
		$("#cont_mass_res").css({'min-height':'450px'});
		$(".titulo").empty().append(title);
		$(".modal-header").css('background',"var(--color-primary)");
		$(".modal-header").css('color','var(--color-white)');
		$(".close").css('color','var(--color-white)');
			$.ajax(url,{
				type:'GET',
				data: datos,
					beforeSend: function(){
						$("#cont_mass_hijo").html('<i class="fa fa-spinner fa-spin fa-2x fa-fw" style="font-size:40px;color:var(--color-primary);"></i>'); 
						$("#sximo-modal-content").empty(); 
					},success: function(res){
						$("#cont_mass_res").css({'min-height':'0px'});
						$("#cont_mass_hijo").empty(); 
						$("#sximo-modal-content").empty().append(res); 
					}
			});
	}
	function modalAvance(url, datos, title, size){
  		$('#modal_inventario').modal({backdrop: 'static', keyboard: false});
		$(".tamanoMass").css('width',size);
		$("#cont_mss_res").css({'min-height':'450px'});
		$(".tituloMass").empty().append(title);
		$(".modal-header").css('background',"var(--color-primary)");
    	$(".modal-header").css('color','var(--color-white)');
    	$(".close").css('color','var(--color-white)');
      	$.ajax(url,{ type:'GET', data: datos, beforeSend: function(){ 
			$("#cont_mss_hijo").html('<i class="fa fa-spinner fa-spin fa-2x fa-fw" style="font-size:40px;color:var(--color-primary);"></i>'); 
			$("#resultado").empty(); 
		},success: function(res){ 
			$("#cont_mss_res").css({'min-height':'0px'});
			$("#cont_mss_hijo").empty(); 
			$("#resultado").empty().append(res); 
		} });
  	}

jQuery(document).ready(function ($) {
  $('#sidemenu').sximMenu();
  $('.spin-icon').click(function () {
    $(".theme-config-box").toggleClass("show");
  });
});
</script>

@yield('scripts')
</body>
</html>
