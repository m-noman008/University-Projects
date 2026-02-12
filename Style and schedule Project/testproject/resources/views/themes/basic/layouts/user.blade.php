<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if (session()->get('rtl') == 1) dir="rtl" @endif>

<head  @if(session()->get('rtl') == 1) dir="rtl" @endif>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

@include('partials.seo')

@stack('css-lib')
<!---- Here is your Css Library----->
    <link rel="stylesheet" type="text/css" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/user-panel-style.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fullcalendar.min.css') }}">

    <!----  Push your custom css  ----->
    @stack('style')

</head>

<body class="@if(session()->get('rtl') == 1) rtl @endif">

<div class="dashboard-wrapper">
    @include($theme . 'partials.sidebar')
</div>

<!-- content -->
<div id="content">
    <div class="overlay">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="sidebar-toggler" onclick="toggleSideMenu()">
                    <i class="far fa-bars"></i>
                </button>
                <span class="navbar-text">

                  

                        <div class="user-panel">
                            <span class="profile">
                                <img src="{{ getFile(config('location.user.path') . optional(Auth::user())->image) }}"
                                     class="img-fluid" alt=""/>
                            </span>
                            <ul class="user-dropdown">
                                <li>
                                    <a href="{{ route('user.profile') }}"> <i class="fal fa-user"></i> @lang('Profile')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.profile') }}"> <i class="fal fa-key"></i> @lang('Change Password')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fal fa-sign-out-alt"></i> @lang('Sign Out') </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </span>
            </div>
        </nav>
        @yield('content')
    </div>
</div>


@stack('loadModal')
@stack('extra-content')



<!----  How to load JS Library, Here is an example ----->
<script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
<script src="{{ asset($themeTrue . 'js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset($themeTrue . 'js/user-script.js') }}"></script>

<script src="{{ asset($themeTrue . 'js/flatpickr.js') }}"></script>
<script src="{{ asset($themeTrue . 'js/moment.min.js') }}"></script>
<script src="{{ asset($themeTrue . 'js/Chart.min.js') }}"></script>
<script src="{{ asset($themeTrue . 'js/fullcalendar.min.js') }}"></script>

@stack('extra-js')

<script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>


@auth
    @if(config('basic.push_notification') == 1)
        <script>
            'use strict';
            let pushNotificationArea = new Vue({
                el: "#pushNotificationArea",
                data: {
                    items: [],
                },
                mounted() {
                    this.getNotifications();
                    this.pushNewItem();
                },
                methods: {
                    getNotifications() {
                        let app = this;
                        axios.get("{{ route('user.push.notification.show') }}")
                            .then(function (res) {
                                app.items = res.data;
                            })
                    },
                    readAt(id, link) {
                        let app = this;
                        let url = "{{ route('user.push.notification.readAt', 0) }}";
                        url = url.replace(/.$/, id);
                        axios.get(url)
                            .then(function (res) {
                                if (res.status) {
                                    app.getNotifications();
                                    if (link != '#') {
                                        window.location.href = link
                                    }
                                }
                            })
                    },
                    readAll() {
                        let app = this;
                        let url = "{{ route('user.push.notification.readAll') }}";
                        axios.get(url)
                            .then(function (res) {
                                if (res.status) {
                                    app.items = [];
                                }
                            })
                    },
                    pushNewItem() {
                        let app = this;
                        // Pusher.logToConsole = true;
                        let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                            encrypted: true,
                            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                        });
                        let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                        channel.bind('App\\Events\\UserNotification', function (data) {
                            app.items.unshift(data.message);
                        });
                        channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                            app.getNotifications();
                        });
                    }
                }
            });
        </script>
    @endif
@endauth
@stack('script')


@include($theme . 'partials.notification')

@include('plugins')

<script>
    $(document).ready(function () {
        $(".language").find("select").change(function () {
            window.location.href = "{{ route('language') }}/" + $(this).val()
        })
    })
</script>

</body>

</html>
