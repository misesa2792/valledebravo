@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

  <section class="page-header bg-body">
    <div class="page-title">
      <h3 class="c-blue s-18"> {{ $pageTitle }} <small class="s-14"><i>{{ $pageNote }}</i></small></h3>
    </div>

    <ul class="breadcrumb bg-body s-14">
      <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
      <li class="active"><i>Ejercicio Fiscal</i></li>
    </ul>	  
</section>

<div class="col-md-12 m-t-md">

  @foreach ($rowsAnios as $row)
  <a href="{{ URL::to($pageModule.'/principal?idy='.$row->idanio.'&year='.$row->anio)}}" class="tips btn btn-xs btn-white full-width no-padding m-b-xs" title="{{ $row->anio }}">
    <article class="col-sm-12 col-md-12 col-lg-12 bg-white p-sm cursor">
      <div class="col-sm-11 col-md-11 col-lg-11 c-text-alt text-left s-16">Ejercicio Fiscal - <strong>{{ $row->anio }}</strong></div>
      <div class="col-sm-1 col-md-1 col-lg-1 text-center">
          <i class="fa  fa-chevron-right cursor s-16 c-blue"></i>	
      </div>
    </article>
  </a>
  @endforeach
</div>

</main>		
@stop