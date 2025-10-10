@extends('layouts.app')

@section('content')

<div class="page-content row bg-body no-margins">
    <!-- Page header -->
	<div class="page-header bg-body">
		<div class="page-title">
				<h3 class="c-primary s-20"> {{ $pageTitle }} <small class="s-16">{{ $pageNote }}</small></h3>
		</div>
		<ul class="breadcrumb bg-body s-20">
		  <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
		<li><a href="{{ URL::to('pilares?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>

	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
 
		 {!! Form::open(array('url'=>'ods/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
		 
 	<article class="page-content-wrapper col-md-4">

		<div class="sbox animated fadeInRight border-l-blue">
			<div class="sbox-title"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
			<div class="sbox-content"> 	

				<div class="col-md-12">
					{!! Form::hidden('idods', $row['idods'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}

					<div class="form-group  " >
						<label for="Pilares" class=" control-label col-md-3 text-left s-16"> Nombre de ODS : </label>
						<div class="col-md-8">
							{!! Form::textarea('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'ODS', 'required'  )) !!}
						</div>
					</div>
					
				</div>

				<div style="clear:both"></div>	
			</div>
		</div>		 

	</article>	

	<article class="page-content-wrapper col-md-8">

		<div class="sbox animated fadeInRight border-t-yellow">
			<div class="sbox-title"> <h4> <i class="fa fa-table"></i> Metas</h4></div>
			<div class="sbox-content"> 	

				<div class="col-md-12">

					<table class="table table-bordered table-hover">
						
						<tr>
							<th class="s-16">Meta</th>
							<th width="30">Acción</th>
						</tr>
						@foreach ($metas as $t)
							<tr id="tr_{{ $t->id }}" class="bg-white">
								<td>
									<input type="hidden" name="id_ins[]" value="{{ $t->id }}">
        							<textarea name="metas_ins[]" rows="2" class="form-control no-borders" style="background: transparent;" placeholder="Ingresa meta del ODS" required>{{ $t->meta }}</textarea>
								</td>
								<td class="text-center">
									<button class="btn btn-xs btn-white btneliminar" id="{{ $t->id }}"> <i class="fa fa-trash-o var"></i> </button>
								</td>
							</tr>	
						@endforeach
						<tbody id="_tbody" class="no-borders"></tbody>
						<tbody class="no-borders">
							<tr>
								<td class="no-borders">
									<button type="button" class="btn btn-xs btn-info" id="btnadd"> <i class="fa fa-plus"></i> </button>
								</td>
							</tr>
						</tbody>
					 
					</table>
					
				</div>

				<div style="clear:both"></div>	
				
			</div>
		</div>		 

	</article>

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<div class="col-sm-12 text-center m-t-lg m-b-lg">	
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('ods?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
</div>			 
   <script type="text/javascript">
	//agregarTr();
    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
		$("#btnadd").prop("disabled",false).html(mss_spinner);
        axios.get('{{ URL::to("ods/addtr") }}',{
            params : {}
        }).then(response => {
			$("#btnadd").prop("disabled",false).html('<i class="fa fa-plus"></i>');
            $("#_tbody").append(response.data);
        })
    }
		
	$(document).on("click",".btndestroy",function(e){
        e.preventDefault();
        let time = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
                $("#tr_"+time).remove();
            }
          })
    })
	$(document).on("click",".btneliminar",function(e){
        e.preventDefault();
        let id = $(this).attr("id");
        swal({
            title : 'Estás seguro de eliminar la columna?',
            icon : 'warning',
            buttons : true,
            dangerMode : true
          }).then((willDelete) => {
            if(willDelete){
				eliminadoTr(id);
            }
          })
    })
	function eliminadoTr(id){
        axios.get('{{ URL::to("ods/eliminartrods") }}',{
            params : {id:id}
        }).then(response => {
			let row = response.data;
			if(row.success == "ok"){
				toastr.success("Tema eliminado exitosamente!");
				$("#tr_"+id).remove();
			}else{
				toastr.error("Error al eliminar!");
			}
        })
    }
	</script>		 
@stop