@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">

		<div class="sbox-tools" >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa fa-cog"></i></a>
			@endif 
		</div>
		
        <h3 class="c-primary s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>{{ $pageTitle }}</li>
		<li>Finalidad</li>
      </ul>	  
	</section>

	<div class="toolbar-line">
		<div class="col-md-12 m-b-md">
		  <a href="#" class="tips btn btn-sm b-r-30 btn-success btnagregar" id="0" title="Agregar Finalidad"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Finalidad</a>
		</div>
	</div> 	
	
	<section class="table-resp m-b-lg" style="min-height:400px;" id="result2"></section>

</main>	

<script>
	 query();
    
	function query(){
      axios.get('{{ URL::to($pageModule."/searchfin") }}',{
            params : {}
        }).then(response => {
          $("#result2").empty().append(response.data);
      })
    }
	$(document).on("click",".btnagregar",function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('estructuraprogramatica/agregarfin') }}",{idfinalidad:$(this).attr("id")},"Agregar Finalidad","40%");
    })
	$(document).on("click",".btndestroy",function(e){
		e.preventDefault();
		let idf = $(this).attr("id");
		swal({
			title : 'Estás seguro de eliminar la finalidad?',
			icon : 'warning',
			buttons : true,
			dangerMode : true
		}).then((willDelete) => {
			if(willDelete){
				axios.post('{{ URL::to("estructuraprogramatica/destroyfin") }}',{
					params : {idf:idf}
				}).then(response => {
					let row = response.data;
					if(row.success == "ok"){
						query();
						toastr.success(mss_tmp.delete);
					}else{
						toastr.error(mss_tmp.error);
					}
				})
			}
		})
	})
</script>
@stop