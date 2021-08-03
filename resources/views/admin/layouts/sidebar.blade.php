<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
	<!-- Sidebar mobile toggler -->
	<div class="sidebar-mobile-toggler text-center">
		<a href="#" class="sidebar-mobile-main-toggle"><i class="icon-arrow-left8"></i></a>Navigation
		<a href="#" class="sidebar-mobile-expand"><i class="icon-screen-full"></i><i class="icon-screen-normal"></i></a>
	</div>
	<!-- /sidebar mobile toggler -->

	<div class="sidebar-content">
		<!-- User menu -->
		<div class="sidebar-user">
			<div class="card-body">
				<div class="media">
					<div class="mr-3">
						<a href="#"><img src="{{asset('global/images/placeholders/placeholder.jpg')}}" width="38" height="38" class="rounded-circle" alt=""></a>
					</div>

					<div class="media-body">
						<div class="media-title font-weight-semibold">{{auth()->user()->name}}</div>
					</div>

					<div class="ml-3 align-self-center">
						<a href="#" class="text-white"><i class="icon-cog3"></i></a>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->
		<!-- Main navigation -->
		<div class="card card-sidebar-mobile">
			<ul class="nav nav-sidebar" data-nav-type="accordion">
				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
				<li class="nav-item">
					<a href="{{route('admin.dashboard')}}" class="nav-link {{ classActivePath(['dashboard']) }}">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				
				<li class="nav-item nav-item-submenu {{classMenuOpenPath(['admins'])}}">
					<a href="#" class="nav-link"><i class="icon-people"></i> <span>Admin Management</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="Admin Management">
						@can('browse-admin')
						<li class="nav-item"><a href="{{route('admin.admins.index')}}" class="nav-link {{classActivePath(['administrator/admins'])}}">All admin</a></li>
						@endcan

						@can('add-admin')
						<li class="nav-item"><a href="{{route('admin.admins.create')}}" class="nav-link {{classActivePath(['administrator/admins/create'])}}">Add admin</a></li>
						@endcan
					</ul>
				</li>
				
				@can('browse-role')
				<li class="nav-item nav-item-submenu {{classMenuOpenPath(['role'])}}">
					<a href="#" class="nav-link"><i class="icon-list-unordered"></i> <span>Role Management</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="Role Management">
						<li class="nav-item"><a href="{{route('admin.role.index')}}" class="nav-link {{classActivePath(['administrator/role'])}}">All Roles</a></li>
						@can('add-role')
						<li class="nav-item"><a href="{{route('admin.role.create')}}" class="nav-link {{classActivePath(['administrator/role/create'])}}">Add Role</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('browse-post')
				<li class="nav-item nav-item-submenu {{classMenuOpenPath(['posts','categories'])}}">
					<a href="#" class="nav-link"><i class="icon-list-unordered"></i> <span>Post Management</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="Post Management">
						<li class="nav-item"><a href="{{route('admin.posts.index')}}" class="nav-link {{classActivePath(['administrator/posts'])}}">All Posts</a></li>
						@can('add-post')
						<li class="nav-item"><a href="{{route('admin.posts.create')}}" class="nav-link {{classActivePath(['administrator/posts/create'])}}">Add Post</a></li>
						@endcan
						@can('add-post')
						<li class="nav-item"><a href="{{route('admin.categories.index','category')}}" class="nav-link {{classActivePath(['administrator/categories/category'])}}">Category</a></li>
						@endcan
					</ul>
				</li>
				@endcan
				
			</ul>
		</div>
	</div>
</div>
<!-- /Main sidebar -->
