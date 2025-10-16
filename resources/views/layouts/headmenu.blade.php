<div class="row ">
        <nav style="margin-bottom: 0;" role="navigation" class="navbar navbar-static-top nav-inside bg-white">
        <div class="navbar-header">
            <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn btn bg-body b-r-5"><i class="fa s-20 icon-arrow-left2"></i> </a>
        </div>


        <ul class="nav navbar-top-links navbar-right">

		<li><a href="{{ URL::to('')}}" target="_blank"><i class="fa fa-desktop"></i> Nueva Página </a></li>

		@if(Auth::user()->group_id ==1 || Auth::user()->group_id ==2)
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-desktop"></i> Panel de Control <span class="caret"></span>
			</a>

				<div class="dropdown-menu dropdown-grid dropdown-menu-right">

					<div class="dropdown-grid-section">
						<div class="row">
							<div class="col-xs-4 col-sm-3 grid-item">
							<a href="{{ URL::to('panel/graficas') }}">
								<span class="circle bg-ses-primary c-white"><span class="fa fa-bar-chart-o"></span></span>
								<span class="grid-label c-text-alt">Graficas</span>
							</a>
							</div>

							<div class="col-xs-4 col-sm-3 grid-item">
							<a href="{{ URL::to('panel/generartxt') }}">
								<span class="circle bg-ses-red c-white"><span class="fa fa-file-text-o"></span></span>
								<span class="grid-label c-text-alt">Generardor de .txt</span>
							</a>
							</div>

							<div class="col-xs-4 col-sm-3 grid-item">
							<a href="{{ URL::to('panel/titulares') }}">
								<span class="circle bg-ses-orange c-white"><span class="fa fa-building-o"></span></span>
								<span class="grid-label c-text-alt">Titulares Dependencias</span>
							</a>
							</div>

							<div class="col-xs-4 col-sm-3 grid-item">
								<a href="{{ URL::to('panel/enlaces') }}">
									<span class="circle bg-ses-green c-white"><span class="fa fa-users"></span></span>
									<span class="grid-label c-text-alt">Enlaces</span>
								</a>
							</div>

							<div class="col-xs-4 col-sm-3 grid-item">
								<a href="{{ URL::to('panel/dependencias') }}">
									<span class="circle bg-ses-yellow c-white"><span class="fa fa-building-o"></span></span>
									<span class="grid-label c-text-alt">Dependencias</span>
								</a>
							</div>
							
						</div>
					</div>
				</div>
			</li>
		@endif
		@if(Auth::user()->id == 1)
			<li class="dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-desktop"></i> <span>{{ Lang::get('core.m_controlpanel') }}</span><i class="caret"></i></a>
				<ul class="dropdown-menu dropdown-menu-right icons-right">
					<li><a href="{{ URL::to('planpdf')}}"><i class="fa fa-folder-open-o"></i> Auditoría</a></li>
					<li><a href="{{ URL::to('core/users')}}"><i class="fa fa-users"></i> Usuarios Generales</a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::to('core/groups')}}"><i class="fa fa-user"></i>  {{ Lang::get('core.m_groups') }} </a></li>
					<li><a href="{{ URL::to('core/users/blast')}}"><i class="fa fa-envelope"></i> {{ Lang::get('core.m_blastemail') }} </a></li>
					<li><a href="{{ URL::to('core/logs')}}"><i class="fa fa-clock-o"></i> {{ Lang::get('core.m_logs') }}</a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::to('core/pages')}}"><i class="fa fa-copy"></i> {{ Lang::get('core.m_pagecms')}}</a></li>

					<li class="divider"></li>
					<li><a href="{{ URL::to('sximo/module')}}"><i class="fa fa-cogs"></i> {{ Lang::get('core.m_codebuilder') }}</a></li>
					<li><a href="{{ URL::to('sximo/tables')}}"><i class="icon-database"></i> Database Tables </a></li>
					<li><a href="{{ URL::to('sximo/menu')}}"><i class="fa fa-sitemap"></i> {{ Lang::get('core.m_menu') }}</a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::to('core/template')}}"><i class="fa fa-desktop"></i> Template Guide </a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::to('sximo/config')}}"><i class="fa  fa-wrench"></i> Configuración</a></li>
				</ul>
			</li>
		@endif

		<li class="dropdown"><a class="dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown">
			{!! SiteHelpers::avatar(35) !!}
			<i class="caret"></i></a>
			<ul class="dropdown-menu dropdown-menu-right icons-right">
				<li style="padding:3px 20px;margin:4px;"><strong>{{ Session::get('fid') }}</strong></li>
				<li style="padding:3px 20px;margin:4px;">{{ Session::get('eid') }}</li>
				<li class="divider"></li>
				<li><a href="{{ URL::to('user/profile')}}"><i class="fa fa-user"></i> Perfil</a></li>
				<li class="divider"></li>
				<li><a href="{{ URL::to('user/logout')}}"><i class="fa fa-sign-out c-danger"></i> <strong class="c-danger">Cerrar sesión</strong></a></li>
			</ul>
		  </li>
    </ul>

	</nav>
</div>
