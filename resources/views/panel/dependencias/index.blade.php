@extends('layouts.main')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Dependencias</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
		<li class="active"><i>Ejercicio Fiscal</i></li>
	  </ul>	  
  </section>
  
  	<h2 class="text-center">¿Selecciona el año fiscal con el que deseas trabajar?</h2>

	<div class="col-md-12 text-center d-flex flex-wrap justify-content-center">
		@foreach ($rowsAnios as $row)
			<div class="item-file-list b-r-c no-padding b-r-10 m-2">
			<div class="item-content cursor text-center">
				<a href="{{ URL::to($pageModule.'/dependencias?idy='.$row->idanio)}}" title="{{ $row->anio }}">
					<div class="h-95 d-table w-100">
					<div class="d-table-cell align-middle">
						<i class="fa fa-calendar {{ date('Y') == $row->anio ? 'c-success' : 'c-danger' }} s-60"></i>
					</div>
					</div>
					
					<div id="s-14" class="text-center">
					<span class="c-text-alt">Ejercicio Fiscal</span>
					</div>

					<p class="font-bold overflow-h no-padding text-center no-margins c-blue m-t-md s-20">
					{{ $row->anio }}
					</p>
				</a>
			</div>
			</div>
		@endforeach
	</div>
				
</main>	

<style>
    .d-flex {
      display: flex;
    }
    .flex-wrap {
      flex-wrap: wrap;
    }
    .justify-content-center {
      justify-content: center;
    }
    .m-2 {
      margin: 10px;
    }
    .w-100 {
      width: 100%;
    }
    .align-middle {
      vertical-align: middle;
    }

		.s-60{font-size: 40px;}
		.h-95{height:85px;}
		.item-content{
      height:160px;
      width: 123px;
    }
		.item-file-list{
      height: 160px !important;
      width: 123px;
      border:none;
      background: var(--color-white);
      border:1px solid var(--color-blue)
    }
		.item-file-list:hover{
			background: rgba(101, 161, 210,0.2) !important;
      border:none;
      color:white;
		}
</style>

	
@stop