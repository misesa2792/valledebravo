@extends('layouts.main')

@section('content')
<main class="page-content row bg-body">

	<section class="page-header bg-body">
	  <div class="page-title">
		<h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
	  </div>
  
	  <ul class="breadcrumb bg-body s-14">
		<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
		<li class="active"><i>PDM alineación con metas</i></li>
	  </ul>	  
  </section>
	
  <div class="toolbar-line col-md-12">
	  <button type="button" onclick="location.href='{{ URL::to($pageModule.'/ejes?idy='.$idy )}}' " class="btn btn-default btn-xs btn-ses"><i class="fa fa-arrow-circle-left"></i> Regresar</button>
  </div> 

  <section class="table-resp m-b-lg " style="min-height:300px;">


	<div class="col-md-12" id="app_pdm">
		<div class="col-md-12 no-padding" id="res_data"></div>
	</div>

  </section>
				
</main>	

<script>
  /* ---- 2) CREACIÓN DEL APP (aislado) ---- */
  const app = Vue.createApp({
    data() {
      return {
        rowsData: [],
        idy: 0,
        idt: 0,
        cancelTokenSource: null
      };
    },
    methods:{
		alinearMeta(idla,idmeta){
			modalMisesa("{{ URL::to($pageModule.'/alinearmetas') }}",{idy:this.idy,idla:idla,idmeta:idmeta},"Alinear con metas","90%");
		},
		loadData(){
				axios.get('{{ URL::to($pageModule."/loadpdm") }}',{
				params : {idy:this.idy,idt:this.idt}
			}).then(response => {
				$('#res_data').empty().html(response.data);
			})
		}
	},
	mounted(){
		this.idy = "{{ $idy }}";
		this.idt = "{{ $idt }}";
		this.loadData();
	}
  });
  /* ---- 4) MONTAJE ---- */
  var appTema = app.mount('#app_pdm');
</script>
	
@stop