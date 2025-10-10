@extends('layouts.main')

@section('content')

<script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>

<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Generar .TXT</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
		<li class="active"><i>Generar .TXT</i></li>
	  </ul>	  
  </section>
	
	<div class="table-responsive m-b-lg" style="border:0px !important;background:transparent;">
		<div class="col-md-12">
			<div class="col-md-12 bg-white b-r-5 p-lg m-t-md">
				<form action="{{ url('panel/generartxt') }}" method="POST" enctype="multipart/form-data">
					<input type="file" name="archivos" class="form-control" accept=".xlsx,.xls" multiple>
					<div class="col-md-12 p-lg text-center">
					<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Generar .txt</button>
					</div>
				</form>
			</div>
		</div>
  	</div>
				
</main>	

<div class="p-lg m-b-lg"></div>

@stop