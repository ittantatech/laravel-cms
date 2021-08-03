<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a class="d-inline-block" href="{{route('admin.dashboard')}}"><img src="{{asset('global/images/logo-new.png')}}" alt=""></a>
		</div>
		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
			@if(classMenuOpenPath(['products']))
			<!-- <button class="navbar-toggler sidebar-mobile-component-toggle" type="button">
				<i class="icon-unfold"></i>
			</button> -->
			@endif
		</div>
		
		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

			</ul>
			<span class="navbar-text ml-md-3 mr-md-auto">
				
			</span>
	
			<ul class="navbar-nav">
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset('global/images/placeholders/placeholder.jpg')}}" class="rounded-circle" alt="">
						<span>{{auth()->user()->name}}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="{{route('admin.profile')}}" class="dropdown-item"><i class="icon-user-plus"></i> My Profile</a>
						<div class="dropdown-divider"></div>
						<a href="{{ route('admin.logout') }}" class="dropdown-item" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> {{ __('Logout') }}</a>
					</div>
					<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
	                	@csrf
	                </form>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
