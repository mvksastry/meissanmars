
<li class="nav-item">
	<a href="/home" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
		  <p>
				Dashboard
				<!-- i class="right fas fa-angle-left"></i -->
		  </p>
	</a>
</li>

<li class="nav-header">OFFICE ROLE</li>


 

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-chart-pie"></i>
    <p>
    Settings
    <i class="right fas fa-angle-left"></i>
    </p>
  </a>
 
  <ul class="nav nav-treeview">
    <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p>IO C Paths</p>
    </a>
    </li>

    <li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p>Users</p>
    </a>
    </li>	
    
    <li class="nav-item">
    <a href="{{ route('roles.index') }}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p>Roles</p>
    </a>
    </li>
    
    <li class="nav-item">
    <a href="{{ route('permissions.index') }}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p>Permissions</p>
    </a>
    </li>			  
  </ul>
</li>