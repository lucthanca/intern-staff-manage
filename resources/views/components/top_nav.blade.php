<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main" style="padding-top: 10px;">
    <div class="container-fluid">
        <!-- Brand -->
        @if(auth()->user()->logged_flag !=0 && auth()->user()->logged_flag !=-1)
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/">Quản lý nhân viên</a>

        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ auth()->user()->getAvatar() }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->username }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Chào mừng - {{ Auth::user()->username }} !
                        </h6>
                    </div>
                    <div class="dropdown-divider">
                    </div>
                    <a href="/profile/{{ auth()->user()->id }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>Trang cá nhân</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="javascript:void(0);" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>Đăng xuất</span>
                    </a>
                </div>
            </li>
        </ul>
        @endif
    </div>
</nav>
<!-- Header -->
<div class="header bg-gradient-primary pt-md-6" style="padding-bottom: 10px;">

</div>