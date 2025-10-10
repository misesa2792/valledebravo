@extends('layouts.app')

@section('content')

<main class="page-content row bg-body">

    <section class="page-header bg-body">
      <div class="page-title">
        <h3 class="c-primary s-20"> Perfil <small class="s-16">Usuario</small></h3>
      </div>

      <ul class="breadcrumb bg-body s-20">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li>Perfil</li>
      </ul>	  
	</section>
		
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<section class="col-sm-12 col-md-12 col-lg-12 no-padding">
			
			<div class="sbox b-r-5" style="border-left:4px solid var(--color-success);">
				<div class="sbox-title"> <h4> <i class="fa fa-table"></i> Perfil</h4></div>
				<div class="sbox-content"> 	
	
					<div class="col-sm-8 col-md-8 col-lg-8">
						
						<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
							<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Nivel: </label>
							<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $info->nivel }}</div>
						</div> 

						<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
							<label class="control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Nombre(s): </label>
							<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $info->nombre }}</div>
						</div> 
	
						<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
							<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Apellido Paterno: </label>
							<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $info->ap }}</div>
						</div> 
	
						<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
							<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Apellido Materno: </label>
							<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $info->am }}</div>
						</div> 
	
						<div class="col-sm-12 col-md-12 col-lg-12 p-xs">
							<label class=" control-label col-sm-3 col-md-3 col-lg-3 text-right s-16"> Correo Electrónico: </label>
							<div class="col-sm-8 col-md-8 col-lg-8 s-16 c-text-alt">{{ $info->email }}</div>
						</div> 
						
	
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4">
						{!! SiteHelpers::avatarUser($info->id,220) !!}
					</div>
	
					<div style="clear:both"></div>	
					
				</div>
			</div>
		</section>
	</article>
 
</main>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("empleados/multisearch")}}');
		$('#SximoTable').submit();
	});

});

</script>

@endsection