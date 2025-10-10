@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">
    <!-- Page header -->
	<div class="page-header bg-body">

		<div class="col-xs-12 col-md-5 col-lg-5 no-padding">
			<div class="page-title">
				<h3 class="c-primary-alt s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
			</div>

			<ul class="breadcrumb bg-body s-20">
				<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-20"></i>  </a></li>
				<li class="active">{{ $pageTitle }}</li>
			</ul>	
		</div>
		
		<div class="col-sm-12 col-md-7 col-lg-7 m-b-md text-left no-padding">
			<div class="sbox-tools" >
				@if(Session::get('gid') ==1)
					<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
				@endif 
			</div>

			<div class="d-none">
				@foreach ($rowsInstituciones as $row)
				<a href="{{ URL::to($pageModule.'?k='.SiteHelpers::CF_encode_json(array('idi'=>$row->idinstituciones)) )}}" class="btn {{ $row->idinstituciones == $idi ? 'btn-mass' : 'btn-white' }} b-r-30"> 
					<img src="{{ asset('images/icons/'.$row->logo) }}" width="20" height="20"> &nbsp;&nbsp;&nbsp;{{ $row->descripcion }}
				</a>
			@endforeach
			</div>
		</div>
	</div>

    <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-b-md no-padding" id="contInst"></section>
	
	<script>
		loadInstitucion();
		function loadInstitucion(){
			$.ajax("{{ URL::to('alineacion/principal') }}", {
				type: 'GET',
				data: {k:"{{ $k }}"},
				beforeSend: function(){
					$("#contInst").html(mss_tmp.load);
				},success: function(res){
					$("#contInst").empty().append(res);
				}, error: function(err){
					toastr.error(mss_tmp.error);
				}
			});
		}
	</script>
</main>
@stop