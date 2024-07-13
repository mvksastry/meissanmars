<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	@include('layouts.menus.officeLogo')
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		@include('layouts.menus.nameBar')
		<!-- SidebarSearch Form -->
    @include('layouts.menus.searchBar')
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
				  with font-awesome or any other icon font library -->
        @include('layouts.menus.commonMenuEmployee')


        
        @include('layouts.menus.confMenuEmployee')
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>