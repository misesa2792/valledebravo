@extends('layouts.app')

@section('content')

<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body s-14">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		<li class="active"><i>{{ $pageNote }}</i></li>
	  </ul>	  
  </section>
	
	<div class="col-md-12 m-t-md">
		@foreach ($rowsAnios as $row)
		<div class="item-file-list b-r-c bg-white box-shadow no-padding" >
			<div class="col-md-12 p-xs"></div>
	
			<div class="col-md-12 item-content cursor">
			<a href="{{ URL::to($pageModule.'/ejes?idy='.$row->idanio)}}" title="{{ $row->anio }}">
				<div class="col-md-12 text-center h-95 d-table">
					<div class="d-table-cell"><i class="fa fa-calendar {{ date('Y') == $row->anio ? 'c-success' : 'c-danger' }} s-60"></i></div>
				</div>
				
				<div class="col-md-12 text-center" id="s-14">
					<span class="c-text-alt">Ejercicio Fiscal</span>
				</div>
				<p class="font-bold overflow-h col-md-12 no-padding text-center no-margins c-blue m-t-md s-20">{{ $row->anio }}</p>
			</a>
			</div>
		</div>
	@endforeach
	</div>
				
</main>	




<style>
	.s-60{font-size: 60px;}
	.h-95{height:95px;}
	.item-content{height:160px;}
	.item-file-list{height: 210px !important;border:none;width:183px;}
	.item-file-list:hover{
		background: var(--color-gray) !important;
	}
</style>
	
@stop