<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{route('admin.profile.edit')}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media align-items-center">
                        <img src="{{\Auth::user()->getPhotoUrl()}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{\Auth::user()->name}}
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.profile.edit')}}" class="dropdown-item">
                    <i class="fas fa-user"></i> Your Profile
                </a>
                <div class="dropdown-divider"></div>
                <a 
                    href="{{ route('logout')}}" 
                    class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->