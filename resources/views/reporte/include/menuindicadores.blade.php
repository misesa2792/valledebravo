<section class="page-header bg-body no-padding">
    <div class="page-title">
        <h3 class="c-blue s-16"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
    </div>

    <ul class="breadcrumb bg-body">
        <li><a href="{{ URL::to('dashboard') }}"> <i class="fa fa-home s-16 c-blue"></i> </a></li>
        <li><i><a href="{{ URL::to($pageModule) }}" class="cursor c-blue">Ejercicio Fiscal</a></i></li>
        <li><i>{{ $year }}</i></li>
        <li><i><a href="{{ URL::to($pageModule) }}" class="subrayado cursor icon-animation c-text s-12"><i class="fa fa-arrow-circle-left "></i> Regresar</a></i></li>
    </ul>	
</section>

<section class="col-md-12 no-padding m-b-md m-t-md">
    <ul class="nav nav-tabs text-right no-borders">
        <li>
            <a href="{{ URL::to('indicadores/principal?idy='.$idy) }}" class="btn {{ $active == 1 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Dependencias Generales">
                <i class="fa icon-office "></i> Dependencias
            </a>
        </li>
        @if(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
            <li>
                <a href="{{ URL::to('indicadores/reconducciones?idy='.$idy) }}" class="btn {{ $active == 8 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Reconducciones">
                    <i class="fa fa-random s-12"></i> Reconducciones
                </a>
            </li>
            <li>
                <a href="{{ URL::to('indicadores/seguimiento?idy='.$idy) }}" class="btn {{ $active == 3 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Seguimiento por acción">
                    <i class="fa icon-notebook s-12"></i> Seguimiento por indicador
                </a>
            </li>
            @if(Auth::user()->group_id == 1)
            <li>
                    <a href="{{ URL::to('indicadores/ochob?idy='.$idy) }}" class="btn {{ $active == 7 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="PbRM-08d">
                        <i class="fa icon-stats-up s-12"></i> PbRM-08b
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ URL::to('indicadores/permisos?idy='.$idy) }}" class="btn {{ $active == 2 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Permisos">
                    <i class="fa fa-unlock-alt s-12"></i> Permisos
                </a>
            </li>
            <li>
                <a href="{{ URL::to('indicadores/foda?idy='.$idy) }}" class="btn {{ $active == 6 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="FODA">
                    <i class="fa icon-lamp s-12"></i> FODA</a>
                </a>
            </li>
            
            <li>
                <a href="{{ URL::to('indicadores/calendarizar?idy='.$idy) }}" class="btn {{ $active == 4 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Calendarización de Indicadores">
                    <i class="fa icon-table2 s-12"></i> Calendarización
                </a>
            </li>
            <li>
                <a href="{{ URL::to('indicadores/graficas?idy='.$idy) }}" class="btn {{ $active == 5 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} b-r-30 tips" title="Graficas de Indicadores">
                    <i class="fa icon-stats-up s-12"></i> Gráficas
                </a>
            </li>
            <li>
                <a href="{{ URL::to('indicadores/indicadoresproyecto?idy='.$idy) }}" class="btn b-r-30 {{ $active == 9 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Indicadores">
                    <i class="fa icon-notebook"></i> Indicadores
                </a>
            </li>
        @endif
    </ul>
</section>