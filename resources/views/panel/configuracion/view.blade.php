@extends('layouts.main')

@section('content')


<main class="page-content row bg-body">

	<section class="page-header bg-body">
		<div class="page-title">
			<h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>Configuración general</i></small></h3>
		</div>
	
		<ul class="breadcrumb bg-body">
			<li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-18 c-blue"></i> </a></li>
			<li>
				<a href="{{ URL::to('panel/configuracion') }}" class="c-blue"><i>Ejercicio Fiscal</i></a>
			</li>
			<li class="active"><i>{{ $row->year }}</i></li>
		</ul>	  
	</section>
		
	  <article class="col-md-12 m-t-md">
      <div class="page-content-wrapper no-padding">
        <div class="sbox animated fadeInRight ">
            <div class="sbox-title border-t-green"> <h4> Configuración general</h4></div>
            <div class="sbox-content bg-white" style="min-height:300px;"> 	


        {!! Form::open(array('url'=>'panel/saveconfig?id='.$rows->id.'&idy='.$row->idy, 'class'=>'form-horizontal row', 'files' => true)) !!}

		<div class="col-sm-6 animated fadeInRight ">
		  
            <h3>UIPPE</h3>

            <div class="form-group">
                 <div class="col-md-6">
                    <strong>Ingresa titular</strong>
                    <input name="t_uippe" type="text" class="form-control input-sm"  value="{{ $rows->t_uippe }}" placeholder="Ingresa titular" />  
                </div>
                <div class="col-md-6">
                    <strong>Ingresa cargo</strong>
                    <input name="c_uippe" type="text" class="form-control input-sm" value="{{ $rows->c_uippe }}"  placeholder="Ingresa cargo"/> 
                </div> 
                
            </div>  

            <h3>TESORERÍA</h3>
		  
            <div class="form-group">
                <div class="col-md-6">
                    <strong>Ingresa titular</strong>
                    <input name="t_tesoreria" type="text" class="form-control input-sm"  value="{{ $rows->t_tesoreria }}" placeholder="Ingresa titular" />  
                </div> 
                <div class="col-md-6">
                    <strong>Ingresa cargo</strong>
                    <input name="c_tesoreria" type="text" class="form-control input-sm" value="{{ $rows->c_tesoreria }}"  placeholder="Ingresa cargo"/> 
                </div> 
            </div>  

		  
		  <div class="form-group m-t-lg">
		    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
			<div class="col-md-8">
				<button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }} </button>
			 </div> 
		  </div> 
		</div>


		<div class="col-sm-6 animated fadeInRight ">
		   <div class="form-group">
			    <div class="col-md-6 text-center">
                    <label>Logo Izquierdo</label>
                        <div style="padding:5px;width:auto;" class="bg-white">
                                <img src="{{ asset($rows->logo_izq)}}" width="170" height="70"/>
                        </div>				
                </div> 

                <div class="col-md-6 text-center">
                    <label>Logo Derecho</label>
                        <div style="padding:5px;width:auto;" class="bg-white">
                                <img src="{{ asset($rows->logo_der)}}" width="80" height="70"/>
                        </div>				
                </div> 
		  </div> 
          
		</div>  
		 {!! Form::close() !!}


            </div>
        </div>		 
        </div>		
    </article>	
				
</main>	
<div class="p-lg m-b-lg"></div>

@stop