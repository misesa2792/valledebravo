@extends('layouts.main')

@section('content')
<main class="page-content row bg-body">

  <section class="row m-b-lg no-padding" style="min-height:300px;">

    	<section class="page-header bg-body">
        <div class="page-title">
          <h3 class="c-blue s-14"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>
    
        <ul class="breadcrumb bg-body">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-16 c-blue"></i> </a></li>
            <li>
              <a href="{{ URL::to($pageModule) }}" class="c-blue"> <i>Ejercicio Fiscal</i> </a>
            </li>
            <li class="active"><i>{{ $rowYear->anio }}</i></li>
          	<li>
			        <a href="{{ URL::to($pageModule) }}" class="subrayado cursor icon-animation c-text s-12"> <i class="fa fa-arrow-circle-left"></i> Regresar</a>
					  </li>
        </ul>	  
      </section>

    <div class="col-sm-12 col-md-12 col-lg-12">
      <ul class="nav nav-tabs text-right m-b-md m-t-md no-borders">
        <li>
            <a href="{{ URL::to($pageModule.'/dependencias?idy='.$idy.'&type='.$type) }}" class="btn {{ $active == 1 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Dependencias Generales">
                <i class="fa icon-office"></i> Dependencias
            </a>
        </li>

        @if(Auth::user()->id == 1 || Auth::user()->id == 58)
          <li>
              <a href="{{ URL::to($pageModule.'/permisos?idy='.$idy.'&type='.$type) }}" class="btn bg-white c-text b-r-30 tips border-black" title="Permisos">
                  <i class="fa icon-office"></i> Permisos
              </a>
          </li>
        @endif

        @if(Auth::user()->id == 1)
          <li>
              <a href="{{ URL::to($pageModule.'/general?idy='.$idy.'&type='.$type.'&module=a') }}" class="btn {{ $active == 2 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Detalle General">
                  <i class="fa icon-office"></i> Vista General
              </a>
          </li>
           <li>
            @if($idy != 4 && $type == 'PD')
              <a href="{{ URL::to($pageModule.'/txt?idy='.$idy.'&type='.$type.'&module=a') }}" class="btn {{ $active == 2 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Detalle General">
                  <i class="fa icon-office"></i> TXT Presupuesto Definitivo
              </a>
            @endif
          </li>
        @endif
      </ul>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 m-b-lg">

            @foreach ($rowsDepGen as $row)
            <a  href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$row->idarea.'&module=1a') }}" class="col-sm-12 col-md-12 col-lg-12 no-padding bg-white c-text-alt s-14" title="Abrir">
                <article class="col-sm-12 col-md-12 col-lg-12 p-sm b-b-gray cursor s-12 bg-hover-gray">
                    <div class="col-sm-6 col-md-6 col-lg-6 c-text"><strong class="c-text-alt">{{ $row->no_dep_gen }}</strong> - {{ $row->dep_gen }}</div>
                    <div class="col-sm-5 col-md-5 col-lg-5 c-text-alt">{{ $row->titular }}</div>
                    <div class="col-sm-1 col-md-1 col-lg-1 text-center">
                            <i class="fa fa-angle-right cursor s-14 c-blue"></i>	
                    </div>
                </article>
            </a>
            @endforeach
    </div>
</section>
				
</main>	

@stop