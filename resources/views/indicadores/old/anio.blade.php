@extends('layouts.app')

@section('content')

  <div class="page-content row bg-body">

    <section class="page-header bg-body">
        <div class="page-title">
          <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>
    
        <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li><i>{{ $row->institucion }}</i></li>
            <li><i>{{ $row->area }}</i></li>
            <li class="active"><i>{{ $row->coordinacion }}</i></li>
        </ul>	  
    </section>
  

    <article class="toolbar-line">
      <div class="col-md-12 m-b-md">
          <button type="button" onclick="location.href='{{ URL::to($pageModule.'/principal?idy='.$idy) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
              <i class="fa  fa-arrow-circle-left "></i> Regresar
            </button>
      </div>
    </article>

    <section class="col-md-12 m-b-lg" id="result2"></section>

  </div>	
	<script>
  query();
  function query(){
    axios.get('{{ URL::to("indicadores/search") }}',{
            params : {k:"{{ $k }}",type:"{{ $type }}",idy:"{{ $idy }}",year:"{{ $year }}"}
        }).then(response => {
          $("#result2").empty().append(response.data);
      })
  }
  </script>
@stop