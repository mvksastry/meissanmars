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

      @hasexactroles('manager')
        @include('layouts.menus.director')
      @endhasexactroles
      
      @hasexactroles('admin|team_leader|employee')
        @include('layouts.menus.admin')
      @endhasexactroles
      
      @hasexactroles('finance|employee')
        @include('layouts.menus.finance')
      @endhasexactroles

      @hasrole('supervisor')
        @include('layouts.menus.supervisor')
      @endhasrole      

      @hasrole('strpur')
        @include('layouts.menus.strpur')
      @endhasrole
      
      @hasexactroles('employee')
        @include('layouts.menus.employee')
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
		<!-- /.scripts -->
	</body>
</html>
