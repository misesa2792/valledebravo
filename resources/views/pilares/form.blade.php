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

	{!! Form::open(array('url'=>'pilares/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

 	<div class="page-content-wrapper col-md-6">

		<div class="sbox animated fadeInRight border-l-blue">
			<div class="sbox-title"> <h4> <i class="fa fa-table"></i> {{ $pageTitle }}</h4></div>
			<div class="sbox-content"> 	

				<div class="col-md-12">
					{!! Form::hidden('idpdm_pilares', $row['idpdm_pilares'],array('class'=>'form-control', 'placeholder'=>'',   )) !!}

					<div class="form-group m-t-md">
						<label for="ID periodo" class=" control-label col-md-3 text-left s-16"> Estatus: </label>
						<div class="col-md-8">
							<select name="estatus" class="select2" required>
								<option value="">--Select Please--</option>
								@foreach ($estatus as $key => $p)
									<option value="{{ $key }}" @if($key == $row['estatus']) selected @endif>{{ $p }}</option>
								@endforeach
							</select>
						 </div>
					  </div> 

					<div class="form-group  " >
						<label for="ID periodo" class=" control-label col-md-3 text-left s-16"> Periodo: </label>
						<div class="col-md-8">
							<select name="idperiodo" class="form-control" required>
								<option value="">--Select Please--</option>
								@foreach ($rows_periodos as $p)
									<option value="{{ $p->idperiodo }}" @if($row['idperiodo'] == $p->idperiodo) selected @endif>{{ $p->descripcion }}</option>
								@endforeach
							</select>
						</div>
					</div> 

					<div class="form-group  " >
						<label for="Idpdm Pilares" class=" control-label col-md-3 text-left s-16"> Tipo: </label>
						<div class="col-md-8">
							<select name="idpdm_pilares_tipo" class="form-control" required>
								<option value="">--Select Please--</option>
								@foreach ($rows_pilares as $v)
									<option value="{{ $v->idpdm_pilares_tipo }}" @if($row['idpdm_pilares_tipo'] == $v->idpdm_pilares_tipo) selected @endif>{{ $v->pilar }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group  " >
						<label for="Pilares" class=" control-label col-md-3 text-left s-16"> No. Pilar : </label>
						<div class="col-md-8">
							<input type="text" name="numero" value="{{ $row['numero'] }}" class="form-control" placeholder="Número de Pilar" required>
						</div>
					</div>

					<div class="form-group  " >
						<label for="Pilares" class=" control-label col-md-3 text-left s-16"> Pilares : </label>
						<div class="col-md-8">
							<textarea name='pilares' rows='5' id='pilares' class='form-control' placeholder="Pilar" required>{{ $row['pilares'] }}</textarea>
						</div>
					</div>

					<div class="form-group  " >
						<label for="Idpdm Pilares" class=" control-label col-md-3 text-left s-16"> Color: </label>
						<div class="col-md-8">
							@foreach ($rows_colores as $c)
								<label style="background:var({{ $c->color }});" class="p-xs b-r-5">
									<input type="radio" name="color" value="{{ $c->color }}" @if($c->color == $row['color']) checked @endif required>  
								</label>	
							@endforeach
						</div>
					</div> 
					
				</div>

				<div style="clear:both"></div>	
			</div>
		</div>		 

	</div>	

	<div class="page-content-wrapper col-md-6">

		<div class="sbox animated fadeInRight border-t-yellow">
			<div class="sbox-title"> <h4> <i class="fa fa-table"></i> Temas</h4></div>
			<div class="sbox-content"> 	

				<div class="col-md-12">

					<table class="table table-bordered table-hover">
						
						<tr>
							<th width="20">#</th>
							<th class="s-16">Tema</th>
							<th width="30">Acción</th>
						</tr>
						@foreach ($temas as $t)
							<tr id="tr_{{ $t->id }}" class="bg-white">
								<td class="text-center">{{ $j++ }}</td>
								<td>
									<input type="hidden" name="id_ins[]" value="{{ $t->id }}">
							        <input type="text" class="form-control no-borders" style="background: transparent;" name="temas_ins[]" value="{{ $t->tema }}" placeholder="Ingresa tema" required>
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

	</div>
	
	<div class="form-group">
		<div class="col-sm-12 text-center m-t-lg m-b-lg">	
			<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
			<button type="button" onclick="location.href='{{ URL::to('pilares?return='.$return) }}' " class="btn btn-default btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
		</div>	  
	</div> 

	{!! Form::close() !!}


</div>	
@if(count($temas) > 0)
<script>
	agregarTr();
</script>
@endif		 
   <script type="text/javascript">
	$(document).ready(function() { 

    $("#btnadd").click(function(e){
        e.preventDefault();
        agregarTr();
    })
    function agregarTr(){
		$("#btnadd").prop("disabled",false).html(mss_spinner);
        axios.get('{{ URL::to("pilares/addtr") }}',{
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
        axios.get('{{ URL::to("pilares/eliminartr") }}',{
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
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop