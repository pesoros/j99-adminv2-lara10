<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item {{ (request()->segment(1) == 'dashboard') ? 'menu-open' : '' }}">
      <a href="{{ url('dashboard') }}" class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item {{ (request()->segment(1) == 'usermanagement') ? 'menu-open' : '' }}">
      <a href="#" class="nav-link  {{ (request()->segment(1) == 'user-management') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
          User Management
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('usermanagement/account') }}" class="nav-link {{ (request()->segment(2) == 'account') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Account</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>