@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('download?return='.$return) }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
	 </div>  
	 
	 
 	<div class="page-content-wrapper">   
	   <div class="toolbar-line">
	   		<a href="{{ URL::to('download?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa fa-arrow-circle-left"></i>&nbsp;{{ Lang::get('core.btn_back') }}</a>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('download/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit"></i>&nbsp;{{ Lang::get('core.btn_edit') }}</a>
			@endif  		   	  
		</div>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> </h4></div>
	<div class="sbox-content"> 	


	
	<table class="table table-striped table-bordered" >
		<tbody>	
	<tr><td width='30%' class='label-view text-right'>Idplan Pdf</td><td>{{ $row->idplan_pdf }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Idinstituciones</td><td>{{ $row->idinstituciones }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Number</td><td>{{ $row->number }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Url</td><td>{{ $row->url }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Ext</td><td>{{ $row->ext }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Size</td><td>{{ $row->size }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Bytes</td><td>{{ $row->bytes }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Fecha</td><td>{{ $row->fecha }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Iduser</td><td>{{ $row->iduser }} </td>	</tr><tr><td width='30%' class='label-view text-right'>Std Delete</td><td>{{ $row->std_delete }} </td>	</tr>
		</tbody>	
	</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop