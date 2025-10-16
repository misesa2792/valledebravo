@extends('layouts.main')

@section('content')


<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Organigrama de dependencias</i></small></h3>
		</div>
	
		<ul class="breadcrumb bg-body">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
			<li>
				<a href="{{ URL::to('panel/dependencias') }}" class="c-blue"><i>Ejercicio Fiscal</i></a>
			</li>
			<li class="active"><i>{{ $row->year }}</i></li>
		</ul>	  
	</section>
		
	  <article class="col-md-12 m-t-md">
      <div class="page-content-wrapper no-padding">
        <div class="sbox animated fadeInRight ">
            <div class="sbox-title border-t-green"> <h4> Organigrama de dependencias</h4></div>
            <div class="sbox-content bg-white" style="min-height:300px;"> 	


                <div id="block-filtros" class="table-resp">
                    <form enctype="multipart/form-data" id="searchgnal" method="post">
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" name="idy" value="{{ $row->idy }}">
                      <div class="col-md-12 no-padding m-b">
            
                          <div class="col-md-12 no-padding m-t-xs m-b-xs">
                            <table class="table table-bordered no-margins b-gray bg-white">
                              <tbody>
                                  <tr>
                                        <td class="no-borders">
                                            <div class="s-14 c-text-alt">No. Dependencia</div>
                                            <input type="text" name="no" class="form-control" placeholder="Ingresa número">
                                        </td>
                                        <td class="no-borders">
                                            <div class="s-14 c-text-alt">Dependencia General</div>
                                            <input type="text" name="dg" class="form-control" placeholder="Ingresa Nombre">
                                        </td>
                                        <td class="text-center no-borders" width="80">
                                            <div class="s-14 c-text-alt">Paginación</div>
											<select name="nopagina" id="nopagina" class="form-control">
												<option value="10"> Paginación </option>
												@foreach ($pages as $p)
													<option value="{{ $p }}"> {{ $p }} </option>
												@endforeach
											</select>
											<input type="hidden" name="page" value="1" id="pagep">
                                        </td>
                                        <td class="text-center no-borders" width="30">
                                            <div class="s-14 c-text-alt">Buscar</div>
                                            <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                        </td>
                                  </tr>
                              </tbody>
                          </table>
                          </div>
            
                     </form>
                  </div>
                  
                <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
                <div class="col-sm-12 col-md-12 col-lg-12 no-padding " id="result2"></div>

            </div>
        </div>		 
        </div>		
    </article>	
				
</main>	

<div class="p-lg m-b-lg"></div>

<script>

	query();
    function query(){
        var formData = new FormData(document.getElementById("searchgnal"));
        $.ajax("{{ URL::to('coordinaciones/searchdep') }}", {
            type: 'post',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#result").empty().append(mss_tmp.load);
            },success: function(mensaje){
                $("#result").empty();
                $("#result2").empty().append(mensaje);
            }
        });
    }
    $("#searchgnal").on("submit", function(e){
        e.preventDefault();
        $("#pagep").val("1");
        query();
    });
    $(document).on("click",".pagination li a",function(e){
        e.preventDefault();
        var url =$( this).attr("href");
        var nopagina = $("#nopagina").val();
        var cadena = url.split('=');
        $("#pagep").val(cadena[1]);
        query();
    });

	 $(document).on("click",".btnagregar",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to('coordinaciones/update') }}",{id:$(this).attr("id"), idtd:$(this).data("idtd"), idy: "{{ $row->idy }}"}, "Agregar Dependencia Auxiliar",'50%');
    })

	const appTabs = Vue.createApp({
				data() {
					return {
						rowsData : [],
						cancelTokenSource: null,
					};
				},
				methods:{
					loadTitulares(){
						if (this.cancelTokenSource) {
							this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
						}
						// Crear un nuevo token de cancelación
						this.cancelTokenSource = axios.CancelToken.source();

						axios.get('{{ URL::to("panel/searchdepgen") }}',{
							params : {idy: "{{ $row['idy'] }}"},
							cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
						}).then(response => {

							var row = response.data;
							if(row.status == 'ok'){
								this.rowsData = response.data.data;
							}else{
								toastr.error(row.message);
							}
						
						}).catch(error => {
						}).finally(() => {
						});
					},edit(id){
						modalMisesa("{{ URL::to('panel/editartitular') }}",{id:id},"Editar Titular","50%");
					}
				},
				mounted(){
					//this.loadTitulares();
				}
			});

	const vm = appTabs.mount('#app_titulares');
</script>
@stop