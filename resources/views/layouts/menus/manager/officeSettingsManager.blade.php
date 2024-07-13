				<li class="nav-header">ADMINISTRATIVE</li>
        
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
              <p>Authorization</p>
            </a>
            </li>
            
            <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Users</p>
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