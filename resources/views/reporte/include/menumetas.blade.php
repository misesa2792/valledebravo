<section class="page-header bg-body no-padding">
    <div class="page-title">
        <h3 class="c-blue"> {{ $pageTitle }} <small class="s-12"><i>{{ $pageNote }}</i></small></h3>
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
                <a href="{{ URL::to('reporte/principal?idy='.$idy) }}" class="btn b-r-30 {{ $active == 1 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Dependencias Generales">
                    <i class="fa icon-office "></i> Dependencias
                </a>
            </li>
            @if(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
                <li>
                    <a href="{{ URL::to('reporte/reconducciones?idy='.$idy) }}" class="btn b-r-30 {{ $active == 7 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Reconducciones">
                        <i class="fa fa-random"></i> Reconducciones
                    </a>
                </li>
                
                <li>
                    <a href="{{ URL::to('reporte/seguimiento?idy='.$idy) }}" class="btn b-r-30 {{ $active == 3 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Seguimiento por acción">
                        <i class="fa icon-notebook"></i> Seguimiento por meta
                    </a>
                </li>
                @if(Auth::user()->group_id == 1)
                    <li>
                        <a href="{{ URL::to('reporte/ochoc?idy='.$idy) }}" class="btn b-r-30 {{ $active == 6 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="PbRM-08c">
                            <i class="fa icon-stats-up"></i> PbRM-08c
                        </a>
                    </li>
                @endif
                
                <li>
                    <a href="{{ URL::to('reporte/permisos?idy='.$idy) }}" class="btn b-r-30 {{ $active == 2 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Permisos">
                        <i class="fa fa-unlock-alt"></i> Permisos
                    </a>
                </li>
                
                <li>
                    <a href="{{ URL::to('reporte/calendarizar?idy='.$idy) }}" class="btn b-r-30 {{ $active == 4 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Calendarización de Metas">
                        <i class="fa icon-table2"></i> Calendarización
                    </a>
                </li>
                <li>
                    <a href="{{ URL::to('reporte/graficas?idy='.$idy) }}" class="btn b-r-30 {{ $active == 5 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Graficas de Metas">
                        <i class="fa icon-stats-up"></i> Gráficas
                    </a>
                </li>
                @if($idy == 2)
                <li>
                    <a href="{{ URL::to('reporte/cuentapublica?idy='.$idy) }}" class="btn b-r-30 bg-white c-text tips" title="Cuenta Pública 2024">
                        <i class="fa icon-file-excel"></i> Cuenta Pública 2024</a>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ URL::to('reporte/metasproyecto?idy='.$idy) }}" class="btn b-r-30 {{ $active == 8 ? 'bg-blue c-white' : ' border-black bg-white c-text' }} tips" title="Metas">
                        <i class="fa icon-notebook"></i> Metas
                    </a>
                </li>
            @endif
        </ul>
</section>