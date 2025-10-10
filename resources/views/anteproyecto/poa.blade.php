@extends('layouts.main')

@section('content')
<!-- Multiple Select CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/multiple-select@2.2.0/dist/multiple-select.min.css">

<!-- Multiple Select JS -->
<script src="https://cdn.jsdelivr.net/npm/multiple-select@2.2.0/dist/multiple-select.min.js"></script>

 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
<main class="page-content row bg-body">
	@include("anteproyecto.component.pbrma")
	@include("anteproyecto.component.pbrmc")
	@include("anteproyecto.component.pbrmaa")
	@include("anteproyecto.component.pbrmb")
	@include("anteproyecto.component.pbrme")
	@include("anteproyecto.component.pbrmd")
	@include("anteproyecto.component.planeacion")

	<div class="row no-padding" id="appTabs">

		<section class="page-header bg-body">
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 no-padding">
				<div class="page-title">
					<h3 class="c-blue s-14"> {{ $pageTitle }} <small class="s-12"><i>{{ $data['pageNote'] }}</i></small></h3>
				</div>
			
				<ul class="breadcrumb bg-body">
					<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-16 c-blue"></i> </a></li>
					<li>
						<a href="{{ URL::to($pageModule) }}" class="c-blue"> <i>{{ $data['year'] }}</i> </a>
					</li>
					<li><i>{{ $data['no_dep_gen'].' '.$data['dep_gen'] }}</i></li>
					<li>
			<a href="{{ URL::to($pageModule.'/dependencias?idy='.$idy.'&type='.$type) }}" class="subrayado cursor icon-animation c-text s-12"> <i class="fa fa-arrow-circle-left"></i> Regresar a dependencias</a>
					</li>
				</ul>	


			</div>
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 table-responsive no-borders bg-body">
	

			<div class="btn-table-wrap text-right">
		
				<table class="btn-table">
					<tr>
						<th class="text-center" colspan="3">
							@if($access['is_01a'] == 1 || $access['is_01c'] == 1 || $access['is_02a'] == 1)
  								<div class="poa-pill pill-green">Metas</div>
							@endif
						</th>
						<th class="text-center c-black">
							@if($access['is_01b'] == 1)
							  <div class="poa-pill pill-red">FODA</div>
							@endif
						</th>
						<th class="text-center c-black" colspan="2">
							@if($access['is_01e'] == 1 || $access['is_01d'] == 1)
  								<div class="poa-pill pill-yellow">Indicadores</div>
							@endif
						</th>
					</tr>
					<tr>
						
						<td class="text-center no-padding">
							<ul class="nav nav-tabs poa-tabs d-none">
									<li :class="'tab-green ' + (currentComponent == 'ComponentPlan' ? 'active' : '')">
									<a href="#" :key="'01a'" @click="currentComponent = 'ComponentPlan'"><span class="glyphicon glyphicon-credit-card"></span> Plan</a></li>
								</ul>
							@if($access['is_01a'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-green {{ $modulo == '1a' ? 'active' : '' }}">
									<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=1a') }}" ><span class="glyphicon glyphicon-credit-card"></span> PbRM–01a</a></li>
								</ul>
							@endif
						</td>
						<td class="text-center no-padding">
							@if($access['is_01c'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-green {{ $modulo == '1c' ? 'active' : '' }}">
									<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=1c') }}" ><span class="glyphicon glyphicon-list"></span> PbRM–01c</a></li>
								</ul>
							@endif
						</td>
						<td class="text-center no-padding">
							@if($access['is_02a'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-green {{ $modulo == '2a' ? 'active' : '' }}">
									<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=2a') }}" ><span class="glyphicon glyphicon-signal"></span> PbRM–02a</a></li>
								</ul>
							@endif
						</td>
						<td class="text-center no-padding">
							@if($access['is_01b'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-red {{ $modulo == '1b' ? 'active' : '' }}">
									<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=1b') }}" ><span class="glyphicon glyphicon-stats"></span> PbRM–01b</a></li>
								</ul>
							@endif
						</td>
						<td class="text-center no-padding">
							@if($access['is_01e'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-yellow {{ $modulo == '1e' ? 'active' : '' }}">
										<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=1e') }}" ><span class="glyphicon glyphicon-th-large"></span> PbRM–01e</a></li>
								</ul>
							@endif
						</td>
						<td class="text-center no-padding">
							@if($access['is_01d'] == 1)
								<ul class="nav nav-tabs poa-tabs">
									<li class="tab-yellow {{ $modulo == '1d' ? 'active' : '' }}">
										<a href="{{ URL::to($pageModule.'/poa?idy='.$idy.'&type='.$type.'&id='.$id.'&module=1d') }}" ><span class="glyphicon glyphicon-briefcase"></span> PbRM–01d</a></li>
								</ul>
							@endif
						</td>
					</tr>
				</table>
			</div>

			</div>
		</section>


			<div class="col-md-12 ">
			

			<component :is="currentComponent" ref="componenteActivo"></component>
		</div>
	</div>
</main>	

<style>
	/* Tabla “auto” al tamaño del contenido */
.btn-table {
  display: inline-table;     /* shrink-wrap */
  width: auto;               /* no 100% */
  border-collapse: separate; /* para poder espaciar celdas */
  margin: 0;
}
/* Celdas justas al botón */
.btn-table td, .btn-table th { padding: 0; }
/* Evita que el texto del botón se corte a 2 líneas */
.btn-pill { white-space: nowrap; }
/* (si aún necesitas centrar la tabla) */
.btn-table-wrap { text-align: right; }

  /* ===== Borde IA sutil para el contenedor ===== */
  .ai-border,
  .ai-border-alt {
    position: relative;
    border-radius: 14px;
    background: #fff;
    z-index: 0;
  }
  .ai-border::before,
  .ai-border-alt::before {
    content:"";
    position:absolute; inset:0;
    padding:1px;                 /* grosor del borde */
    border-radius: inherit;
    background: radial-gradient(174.54% 192.41% at 114.71% 114.58%,
      #2DA088 3.5%, #FE9705 36%, #E13288 59%, #1B89F3 100%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    z-index:-1;
  }
  .ai-panel {
    padding: 18px 20px;
    box-shadow: 0 24px 48px rgba(0,0,0,.06), 0 8px 18px rgba(0,0,0,.05);
  }

  /* ===== Tabs con indicador de color (sin “bloquear” todo el tab) ===== */
  .poa-tabs { margin: 8px 0 16px; border-bottom: 0; }
  .poa-tabs > li > a {
    position: relative;
    border: 0; border-radius: 8px;
    color: #5a6273; font-weight: 600;
    padding: 10px 14px;
    transition: background .2s ease, color .2s ease;
  }
  .poa-tabs > li > a:hover { background: #f6f7fb; color: var(--color-blue); }
  .poa-tabs > li.active > a,
  .poa-tabs > li.active > a:focus,
  .poa-tabs > li.active > a:hover {
    background: #fff; 
	color:#1f2533;
    box-shadow: 0 6px 14px rgba(0,0,0,.06);
  }
  /* Línea de estado por color */
  .poa-tabs > li > a:after {
    content:""; position:absolute; left:10px; right:10px; bottom:-8px;
    height:3px; border-radius:3px; opacity:0;
    transition: opacity .2s ease;
  }
  .poa-tabs > li.active > a:after { opacity:1; }
 
  /* ===== Botón CTA protagonista ===== */
  .btn-cta {
    border:0; border-radius: 999px;
    padding: 3px 10px;  color:#fff;
    background-image: linear-gradient(90deg,#3F9035,#A3BE0D);
    box-shadow: 0 12px 24px rgba(63,144,53,.25);
  }
  .btn-cta:hover, .btn-cta:focus {
    color:#fff; background-image: linear-gradient(90deg,#3A7F31,#95AE0C);
  }
  .btn-cta span { margin-right:6px; }

	.btn-cta-danger {
		border:0; border-radius: 999px;
		padding: 3px 10px;  color:#fff;
		background-image: linear-gradient(90deg,#ea4335,#e66a6e);
		box-shadow: 0 12px 24px rgba(144, 53, 53, 0.25);
	}
	.btn-cta-danger:hover, .btn-cta-danger:focus {
		color:#fff; background-image: linear-gradient(90deg,#ea4335,#e66a6e);
	}
	.btn-cta-danger span { margin-right:6px; }

	.btn-cta-yellow {
		border:0; border-radius: 999px;
		padding: 3px 10px;  color:#fff;
		background-image: linear-gradient(90deg,#fbbc05,#f9a825);
		box-shadow: 0 12px 24px rgba(144, 123, 53, 0.25);
	}
	.btn-cta-yellow:hover, .btn-cta-yellow:focus {
		color:#fff; background-image: linear-gradient(90deg,#fbbc05,#f9a825);
	}
	.btn-cta-yellow span { margin-right:6px; }

  /* ===== Empty state ===== */
  .poa-empty {
    min-height: 450px;
    border-radius: 12px;
    background: linear-gradient(180deg,#ffffff, #ffffff);
    display:flex; align-items:center; justify-content:center;
    color:#7c8193; text-align:center;
  }
  .poa-empty .muted { color:#8b92a6; }
	.poa-body {
		min-height: 450px;
		border-radius: 12px;
		background: linear-gradient(180deg,#ffffff, #ffffff);
	}

  /* Activo: fondo blanco, sombra suave, texto más oscuro */
.poa-tabs > li.active > a,
.poa-tabs > li.active > a:focus,
.poa-tabs > li.active > a:hover {
  background:#fff; 
  color:var(--color-blue) !important;
  box-shadow: 0 6px 14px rgba(0,0,0,.06);
}
/* La línea de color sólo aparece cuando está .active */
.poa-tabs > li.active > a:after { opacity:1; }


.poa-pill {
  color:#fff; font-weight:700; text-align:center; padding:6px 0; border-radius:8px;
  box-shadow: 0 4px 10px rgba(0,0,0,.06);
}
.pill-green  { background: linear-gradient(90deg,#3F9035,#A3BE0D); }
.pill-red    { background: linear-gradient(90deg,#ea4335,#e66a6e); }
.pill-yellow { background: linear-gradient(90deg,#fbbc05,#f9a825); }

</style>



<style>
	.p-b-i{padding-bottom:3px;}
	.nav-menu-blue{
	border-bottom:2px solid var(--color-blue) !important;
	}
	.nav-menu-green{
	border-bottom:2px solid var(--color-green-meta) !important;
	}
	.nav-menu-danger{
	border-bottom:2px solid var(--color-red-meta) !important;
	}
	.nav-menu-yellow{
	border-bottom:2px solid var(--color-yellow-meta) !important;
	}
	#sximo-modal .modal-dialog {
		max-height: 95%;
		overflow-y: auto !important;
	}

	#sximo-modal .modal-body {
		max-height: 80vh;
		overflow-y: auto !important;
	}

	.sbox-content {
		min-height: 70vh;
	}
	
</style>

@if($access['is_01a'] == 1)
	<script>
		const componentes = {
							ComponentPbrma,
							ComponentPbrmc,
							ComponentPbrmaa,
							ComponentPbrmb,
							ComponentPbrme,
							ComponentPbrmd,
							ComponentPlan,
						};
		// Mapeo módulo -> componente
		const moduloMap = {
			'1a': 'ComponentPbrma',
			'1c': 'ComponentPbrmc',
			'2a': 'ComponentPbrmaa',
			'1b': 'ComponentPbrmb',
			'1e': 'ComponentPbrme',
			'1d': 'ComponentPbrmd',
			'plan': 'ComponentPlan',
		};

		const appTabs = Vue.createApp({
				data() {
					return {
						 currentComponent: moduloMap['{{ $modulo }}'] 
					};
				},
					components: componentes
				});

		const vm = appTabs.mount('#appTabs');
	</script>
@endif
@stop