<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layouts.partials.header')
    @livewireStyles
    @powerGridStyles
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
      
      @hasexactroles('pient')
        @include('layouts.menus.pient.pient')
      @endhasexactroles
      
      @hasexactroles('employee')
        @include('layouts.menus.employee')
      @endhasexactroles
			<!-- /.Main Sidebar Container -->
      <main>
        {{ $slot }}
      </main>
			<!-- Dynamic content -->
 		
			<!-- /.Dynamic content -->
					  
			@include('layouts.partials.footer')

			<!-- Control Sidebar -->
			@include('layouts.partials.csidebar')
			<!-- /.control-sidebar -->
			
		</div>
		<!-- scripts -->
    @livewireScripts
    @powerGridScripts
		@include('layouts.partials.scripts')
    @livewire('wire-elements-modal')
		<!-- /.scripts -->
	</body>
</html>