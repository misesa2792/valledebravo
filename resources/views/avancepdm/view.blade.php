@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

  <section class="page-header bg-body">
    <div class="page-title">
      <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
    </div>

    <ul class="breadcrumb bg-body s-14">
      <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
      <li class="active"><i>Dependencias</i></li>
    </ul>	  
</section>

<div class="col-md-12 m-t-md">
  <ul class="nav nav-tabs text-right">
    <li>
      <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 tips" title="Regresar" style="margin-right:15px;">
        <i class="fa  fa-arrow-circle-left "></i> Regresar
      </button>
    </li>
    <li>
      <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&t=1') }}" class="tips {{ $trim == 1 ? 'bg-blue c-white' : 'bg-white c-text' }} "><i class="fa fa-external-link s-12"></i> Trimestre #1</a>
    </li>
    <li>
      <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&t=2') }}" class="tips {{ $trim == 2 ? 'bg-blue c-white' : 'bg-white c-text' }} "><i class="fa fa-external-link s-12"></i> Trimestre #2</a>
    </li>
    <li>
      <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&t=3') }}" class="tips {{ $trim == 3 ? 'bg-blue c-white' : 'bg-white c-text' }} "><i class="fa fa-external-link s-12"></i> Trimestre #3</a>
    </li>
    <li>
      <a href="{{ URL::to($pageModule.'/principal?idy='.$idy.'&t=4') }}" class="tips {{ $trim == 4 ? 'bg-blue c-white' : 'bg-white c-text' }} "><i class="fa fa-external-link s-12"></i> Trimestre #4</a>
    </li>

  </ul>
</div>

<div class="col-md-12 m-t-md no-padding" id="resProgramas">


</div>

</main>		

<script>
  query();
  	function query(){
		axios.get("{{ URL::to('avancepdm/programas') }}",{
				params : {idy:"{{ $idy }}",trim:"{{ $trim }}"}
		}).then(response =>{
			$("#resProgramas").empty().html(response.data);
		}).catch(error => {
			toastr.error("Error, vuelve a intentar!");
		})
	}

  $(document).on("click",".btnprograma",function(e){
        e.preventDefault();
        let idp = $(this).attr("id");
        let id = $(this).data("id");
				modalMisesa("{{ URL::to($pageModule.'/edit') }}",{idy: "{{ $idy }}", idp:idp,trim:"{{ $trim }}",id:id},"Agregar descripción","95%");
    });
</script>

@stop