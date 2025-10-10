@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

  <section class="page-header bg-body">
    <div class="page-title">
      <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
    </div>

    <div class="sbox-tools" >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
			@endif 
		</div>

    <ul class="breadcrumb bg-body s-14">
      <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
      <li class="active"><i>{{ $pageTitle }}</i></li>
    </ul>	  
  </section>

    <div class="col-md-12 m-t-xs">
    @foreach ($rowsAnios as $row)
      @if($row->idanio != 3)
        <div class="item-file-list b-r-c bg-white box-shadow no-padding" >
            <div class="col-md-12 p-xs"></div>

            <div class="col-md-12 item-content cursor">
              <a href="{{ URL::to($pageModule.'/principal?idy='.$row->idanio.'&year='.$row->anio)}}" title="{{ $row->anio }}">
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
      @endif
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