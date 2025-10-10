<?php $sidebar = SiteHelpers::menus('sidebar') ;?>
	<nav role="navigation" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse">
      <ul id="sidemenu" class="nav expanded-menu">
				<li class="logo-header bg-white">
		 			<div class="text-center">
						<a class="navbar-brand" href="{{ URL::to('dashboard')}}" style="padding: 0;letf:20px;">
							<img src="{{ asset('mass/images/vb.png')}}" alt="{{ CNF_APPNAME }}" width="220" height="70"/>
						</a>
		 			</div>
				</li>
				<li class="nav-header">
					<div class="dropdown profile-element text-center">
						<span>{!! SiteHelpers::avatar() !!}</span>
						<a href="{{ URL::to('user/profile') }}" >
						<span class="clear"> 
							<span class="block m-t-xs"> 
								<strong class="font-bold">{{ Session::get('fid') }}</strong>
						 	</span>
						 </span>
						 </a>
			</div>
			<div class="photo-header "> {!! SiteHelpers::avatar(40) !!} </div>
		</li>
		<li>
			<a href="{{ URL::to('dashboard') }}"><i class="s-12 icon-home"></i> <span class="nav-label"> Dashboard</span></a>
		</li>

		@foreach ($sidebar as $menu)
			 <li style="margin-bottom:2px" @if(Request::segment(1) == $menu['module']) class="active" @endif>
			 	<a href="{{ ($menu['menu_type'] =='external' ? $menu['url'] : URL::to($menu['module']))  }}"
					@if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
				 	<i class="s-12 {{$menu['menu_icons']}}"></i> <span class="nav-label"> {{$menu['menu_name']}}</span><span class="fa arrow"></span>
				</a>
				@if(count($menu['childs']) > 0)
					<ul class="nav nav-second-level">
						@foreach ($menu['childs'] as $menu2)
						 <li @if(Request::segment(1) == $menu2['module']) class="active" @endif>
						 	<a href="{{ ($menu2['menu_type'] =='external' ? $menu2['url'] : URL::to($menu2['module'])) }}">
								<i class="s-12 {{$menu2['menu_icons']}}"></i> {{$menu2['menu_name']}}
							</a>
							@if(count($menu2['childs']) > 0)
								<ul class="nav nav-third-level">
									@foreach($menu2['childs'] as $menu3)
										<li @if(Request::segment(1) == $menu3['module']) class="active" @endif>
											<a href="{{ ($menu['menu_type'] =='external' ? $menu3['url'] : URL::to($menu3['module'])) }}" >
												<i class="s-12 {{$menu3['menu_icons']}}"></i>{{$menu3['menu_name']}}
											</a>
										</li>
									@endforeach
								</ul>
							@endif
						</li>
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
      </ul>
	</div>
</nav>
