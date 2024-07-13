<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layouts.partials.header')
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- preloader -->
			@include('layouts.partials.preloader')
			<!-- /.preloader -->

			<!-- Navbar -->
			@include('layouts.partials.navbar')
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
      @hasexactroles('manager|employee')
        @include('layouts.menus.director')
      @endhasexactroles
      
      @hasexactroles('admin')
        @include('layouts.menus.sysadmin.admin')
      @endhasexactroles

      @hasexactroles('manager')
        @include('layouts.menus.manager.manager')
      @endhasexactroles
      
      @hasexactroles('pient')
        @include('layouts.menus.pient.pient')
      @endhasexactroles
			<!-- /.Main Sidebar Container -->
			
			<!-- Dynamic content -->
			@yield('content')  		
			<!-- /.Dynamic content -->
					  
			@include('layouts.partials.footer')

			<!-- Control Sidebar -->
			@include('layouts.partials.csidebar')
			<!-- /.control-sidebar -->
			

		</div>
		<!-- scripts -->
    
		@include('layouts.partials.scripts')
    @livewire('wire-elements-modal')
		<!-- /.scripts -->
	</body>
</html>
