@extends('layouts.app')

@section('content')
<main class="page-content row bg-body">

    <section class="page-header bg-body">
        <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
        </div>

        <ul class="breadcrumb bg-body s-14">
            <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18"></i> </a></li>
            <li class="active"><i>Dependencias Generales</i></li>
            <li>{{ $ins->municipio }}</li>
            <li>{{ $ins->institucion }}</li>
        </ul>	  
    </section>
	
    <article class="toolbar-line col-md-12">
        <button type="button" onclick="location.href='{{ URL::to($pageModule) }}' " class="btn bg-default c-text b-r-5 btn-ses" ><i class="fa  fa-arrow-circle-left "></i> Regresar</button>
    </article>

    <article class="col-md-12">
        <section class="page-content-wrapper no-padding">
            <div class="sbox animated fadeInRight ">
                        <div class="sbox-title border-t-yellow"> <h4> Dependencias Generales</h4></div>
                        <div class="sbox-content bg-white" style="min-height:300px;"> 	
    
                            <div id="block-filtros" class="table-resp">
                                <form enctype="multipart/form-data" id="searchgnal" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="hidden" name="idy" value="{{ $idy }}">
                                <div class="col-md-12 no-padding">
                        
                                    <div class="col-md-11 no-padding">
                                        @if($access['is_add'] ==1)
                                        <a href="#" class="tips btn btn-sm btn-success btn-ses btnagregar" id="0" data-idy="{{ $idy }}"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</a>
                                        @endif
                                    </div>
                    
                                    <div class="col-md-1 no-padding">
                                        <select name="nopagina" id="nopagina" class="form-control">
                                            <option value="10"> Paginación </option>
                                            @foreach ($pages as $p)
                                                <option value="{{ $p }}"> {{ $p }} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="page" value="1" id="pagep">
                                    </div>
                    
                                    <div class="col-md-12 no-padding m-t-xs m-b-xs">
                                        <table class="table table-bordered no-margins b-gray bg-white">
                                            <tr>
												<td class="no-borders">
                                                    <div class="s-14 c-text-alt">Institución</div>
                                                    <select name="idtipo" class="form-control">
														<option value="">--Select please--</option>
														@foreach($rowsTipo as $v)
															<option value="{{ $v->id }}">{{ $v->abreviatura }}</option>
														@endforeach
													</select>
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Denominación</div>
                                                    <input type="text" name="nodg" class="form-control" placeholder="Ingresa número">
                                                </td>
                                                <td class="no-borders">
                                                    <div class="s-14 c-text-alt">Dependencia General</div>
                                                    <input type="text" name="dg" class="form-control" placeholder="Ingresa Nombre">
                                                </td>
                                                <td class="text-center no-borders" width="30">
                                                    <div class="s-14 c-text-alt">Buscar</div>
                                                    <button type="submit" class="tips btn btn-xs btn-white b-r-30 box-shadow" title="Buscar"><i class="fa fa-search fun"></i> Buscar</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                        
                                </form>
                            </div>
                            
                            <div class="col-sm-12 col-md-12 col-lg-12 c-text-alt s-16" id="result"></div>
                            <div class="col-sm-12 col-md-12 col-lg-12 no-padding " id="result2"></div>
    
                        </div>
                </div>		 
            </section>
    </article>		
<script>
    query();
    function query(){
        var formData = new FormData(document.getElementById("searchgnal"));
        $.ajax("{{ URL::to($pageModule.'/search') }}", {
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

    $(document).on("click",".btneliminar",function(e){
		e.preventDefault();
		let id = $(this).attr('id');

		swal({
			title : 'Estás seguro de eliminar la dependencia general?',
			icon : 'warning',
			buttons : true,
			dangerMode : true
		}).then((willDelete) => {
			if(willDelete){
				axios.delete('{{ URL::to($pageModule."/registro") }}',{
					params : {id:id}
				}).then(response => {
					let row = response.data;
					if(row.status == "ok"){
						toastr.success(row.message);
						query();
					}
				})
			}
		})

	});

    $(document).on("click",".btnagregar",function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{id:$(this).attr("id"), idy: "{{$idy}}"}, "Agregar Dependencia General",'50%');
    })
</script>
</main>		
@stop