@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-primary s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>{{ $pageTitle }}</li>
		<li>Finalidad</li>
		<li>Función</li>
      </ul>	  
	</section>
	
	<div class="toolbar-line">
		<div class="col-md-12 m-b-md">
		  <button type="button" onclick="location.href='{{ URL::to('estructuraprogramatica') }}' " class="btn btn-default btn-xs b-r-30"><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
		  <a href="#" class="tips btn btn-sm b-r-30 c-white btnagregar" style="background: var(--color-blue-meta);" title="Agregar Función"><i class="fa fa-plus-circle"></i>&nbsp;Agregar Función</a>
		</div>
	</div> 	

	<section class="table-resp m-b-lg" style="min-height:300px;">

		<article class="col-sm-12 col-md-12 col-lg-12">
		
			<section class="col-sm-5 col-md-5 col-lg-5 no-padding">
			
				<div class="sbox animated fadeInRight b-r-5" style="border-left:4px solid var(--color-blue-meta);">
					<div class="sbox-title"> <h4> <i class="fa fa-table"></i> FINALIDAD</h4></div>
					<div class="sbox-content"> 	
		
						<div class="col-sm-12 col-md-12 col-lg-12">
							
							<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
								<label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Finalidad: </label>
								<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $row->numero }} - {{ $row->descripcion }}</div>
							</div> 
		
						</div>
		
						<div style="clear:both"></div>	
						
					</div>
				</div>
			</section>

			<section class="col-sm-7 col-md-7 col-lg-7 p-md">
				<div class="col-sm-12 col-md-12 col-lg-12 border-gray p-md b-r-5 bg-white" id="line-comm">
					<div class="col-sm-12 col-md-12 col-lg-12 c-text s-16 b-b-gray p-xs">FUNCIONES</div>
					<div class="col-sm-12 col-md-12 col-lg-12 m-t-md m-b-md" id="result2"></div>
				</div>
			</section>
		</article>

	</section>

</main>	

<script>
	const idfinalidad = "{{ $idfinalidad }}";
	 query();
    
	function query(){
      axios.get('{{ URL::to($pageModule."/searchfun") }}',{
            params : {idfinalidad:idfinalidad}
        }).then(response => {
          $("#result2").empty().append(response.data);
      })
    }

	$(document).on("click",".btnagregar",function(e){
      e.preventDefault();
      modalMisesa("{{ URL::to('estructuraprogramatica/agregarfun') }}",{idfuncion:$(this).attr("id"),idfinalidad:idfinalidad},"Agregar Función","40%");
    })

	$(document).on("click",".btndestroy",function(e){
		e.preventDefault();
		let idf = $(this).attr("id");
		swal({
			title : 'Estás seguro de eliminar la función?',
			icon : 'warning',
			buttons : true,
			dangerMode : true
		}).then((willDelete) => {
			if(willDelete){
				axios.post('{{ URL::to("estructuraprogramatica/destroyfun") }}',{
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