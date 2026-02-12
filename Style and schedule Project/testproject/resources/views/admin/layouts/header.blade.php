<header class="topbar" data-navbarbg="skin6">

    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <div class="navbar-brand">
                <a href="{{url('/')}}">

                <span class="logo-text">
                  <img src="{{ getFile(config('location.logoIcon.path') . 'logo.png') }}" alt="homepage"
                     class="dark-logo" style="width: 150px; height: auto;"/>
                  <img src="{{ getFile(config('location.logoIcon.path') . 'logo.png') }}" class="light-logo"
                    alt="homepage" style="width: 150px; height: auto;"/>
                </span>

                </a>
            </div>

            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
               data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">

            <ul class="ml-auto navbar-nav">


                <!-- ============================================================== -->
                <!-- User profile and search
                .ti-menu:before {
                content: "\e68e";
                }
                -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">


                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <img src="{{getFile(config('location.admin.path').Auth::guard('admin')->user()->image)}}"
                             alt="user"
                             class="rounded-circle width-40p">
                        <span class="ml-2 d-none d-lg-inline-block"><span class="text-dark">@lang('Hello,')</span> <span
                                class="text-dark">{{ Auth::guard('admin')->user()->username }}</span> <i
                                data-feather="chevron-down"
                                class="svg-icon"></i></span>
                    </a>


                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                        <a class="dropdown-item" href="{{route('admin.profile') }}">
                            <i class="ml-1 mr-2 svg-icon icon-user"></i>
                            @lang('Profile')
                        </a>

                        <a class="dropdown-item" href="{{route('admin.password')}}">
                            <i class="ml-1 mr-2 svg-icon icon-settings"></i>
                            @lang('Password')
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                data-feather="power" class="ml-1 mr-2 svg-icon"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </li>


            </l>
        </div>

    </nav>
</header>

