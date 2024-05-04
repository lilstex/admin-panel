<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard' )}}" class="brand-link">
      <img src="{{ url('admin/images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(isset(Auth::guard('admin')->user()->image))
            <img src="{{ url('admin/images/profile/'.Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2" alt="User Image">
          @else 
          <img src="{{ url('admin/images/profile/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="{{ url('admin/dashboard' )}}" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if (Session::get('page') == 'dashboard')
            @php $active = "active" @endphp
          @else
            @php $active = "" @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if (Session::get('page') == 'update-profile' || Session::get('page') == 'change-password')
            @php $active = "active" @endphp
          @else
            @php $active = "" @endphp
          @endif
          <li class="nav-item menu-open">
            <a href="{{ url('admin/dashboard' )}}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (Session::get('page') == 'change-password')
                @php $active = "active" @endphp
              @else
                @php $active = "" @endphp
              @endif
              <li class="nav-item">
                <a href="{{ url('admin/change_password' )}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
              @if (Session::get('page') == 'update-profile')
                @php $active = "active" @endphp
              @else
                @php $active = "" @endphp
              @endif
              <li class="nav-item">
                <a href="{{ url('admin/update_profile' )}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Profile</p>
                </a>
              </li>
            </ul>
          </li>

          @if (Auth::guard('admin')->user()->type === 'admin')
            @if (Session::get('page') == 'sub-admin')
              @php $active = "active" @endphp
            @else
              @php $active = "" @endphp
            @endif
            <li class="nav-item">
              <a href="{{ url('admin/subadmins' )}}" class="nav-link {{$active}}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Subadmins
                </p>
              </a>
            </li>
          @endif
          
          @if (Session::get('page') == 'cms-page')
            @php $active = "active" @endphp
          @else
            @php $active = "" @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/cms_page' )}}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                CMS Pages
              </p>
            </a>
          </li>

          @if (Session::get('page') == 'category')
            @php $active = "active" @endphp
          @else
            @php $active = "" @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/categories' )}}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
