@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<main class="page-content row bg-body">
    <!-- Page header -->
	<div class="page-header bg-body">
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
		  <li class="active">{{ $pageTitle }}</li>
		</ul>	  
		
	</div>


	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Form::open(array('url'=>'pilares/delete/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
			<div class="toolbar-line ">
				@if($access['is_add'] == 1)
				<a href="{{ URL::to('pilares/update') }}" class="tips btn btn-sm btn-white b-r-30" title="{{ Lang::get('core.btn_create') }}"><i class="fa fa-plus-circle fun"></i>&nbsp;{{ Lang::get('core.btn_create') }}</a>
				@endif  
				@if($access['is_remove'] == 1)
					<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white b-r-30" title="{{ Lang::get('core.btn_remove') }}"><i class="fa fa-minus-circle var"></i>&nbsp;{{ Lang::get('core.btn_remove') }}</a>
				@endif 		
			</div> 
			
			<section class="table-resp bg-white" style="min-height:300px;">

				<table class="table table-bordered">
					<tr class="t-tr-s14">
						<th>#</th>
						<th>Estatus</th>
						<th>Periodo</th>
						<th>Tipo</th>
						<th>Número</th>
						<th>Descripción</th>
						<th>Temas</th>
						<th>Acción</th>
					</tr>
					@foreach (json_decode($rowData) as $row)
						<tr class="t-tr-s14">
							<td>{{ ++$i }}</td>
							<td>
								@if($row->estatus == 1)
									<label class="badge badge-success">Activo</label>
								@elseif($row->estatus == 2)
									<label class="badge badge-danger">Inactivo</label>
								@endif
							</td>
							<td>{{ $row->periodo }}</td>
							<td>{{ $row->tipo }}</td>
							<td class="text-center">{{ $row->numero }}</td>
							<td>{{ $row->pilares }}</td>
							<td>
								<ul>
									@foreach ($row->temas as $c)
										<li class="s-16 c-text-alt m-b-xs m-t-xs">{{ $c->tema }}</li>
									@endforeach
								</ul>
							</td>
							<td class="text-center">
								@if($access['is_edit'] ==1)
									<a  href="{{ URL::to('pilares/update/'.$row->idpdm_pilares.'?return='.$return) }}" class="tips btn btn-xs btn-white fun" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i></a>
								@endif
							</td>
						</tr>
					@endforeach
				</table>
				
			</section>
		{!! Form::close() !!}
		
		@include('footer')
		<br>
		<br>
		<br>
	</div>
</main>	
<script>
$(document).ready(function(){
	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("pilares/multisearch")}}');
		$('#SximoTable').submit();
	});
});	
</script>		
@stop