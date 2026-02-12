<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if (session()->get('rtl') == 1) dir="rtl" @endif>

<head @if (session()->get('rtl') == 1) dir="rtl" @endif>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @include('partials.seo')

    <!----  How to load Css Library, Here is an example ----->
    <link rel="stylesheet" type="text/css" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}" />

    @stack('css-lib')

    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/jquery.rprogessbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <!----  Push your custom css  ----->
    @stack('style')

</head>

<body onload="preloder_function()" class="@if (session()->get('rtl') == 1) rtl @endif">
    <div id="preloader"></div>

    @include($theme . 'partials.topbar')

    <div class="nav_area">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="{{ getFile(config('location.logoIcon.path') . 'logo.png') }}"
                        alt="{{ config('basic.site_title') }}">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="text-center collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="m-auto navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ menuActive(['home'], 3) }}" aria-current="page"
                                href="{{ route('home') }}">@lang('Home')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ menuActive(['about'], 3) }}"
                                href="{{ route('about') }}">@lang('About')</a>
                        </li>

                        @service
                            <li class="nav-item">
                                <a class="nav-link {{ menuActive(['service'], 3) }}"
                                    href="{{ route('service') }}">@lang('Services')</a>
                            </li>
                        @endservice

                      

                        @bookAppointment
                            <li class="nav-item">
                                <a class="nav-link {{ menuActive(['appointment'], 3) }}"
                                    href="{{ route('appointment') }}">@lang('Appointment')</a>
                            </li>
                        @endbookAppointment

                        @shop
                            <li class="nav-item">
                                <a class="nav-link {{ menuActive(['products'], 3) }}"
                                    href="{{ route('products') }}">@lang('Shop')</a>
                            </li>
                        @endshop


                        <li class="nav-item dropdown_list">
                            <a class="nav-link {{ menuActive(['plan.pricing', 'team', 'gallery'], 3) }}"
                                href="javascript:void(0)">@lang('Pages') <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub_menu">


                                @plan
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('plan.pricing') }}">@lang('Pricing plan')</a></li>
                                @endplan

                                @team
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('team') }}">@lang('team')</a></li>
                                @endteam

                                @gallery
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('gallery') }}">@lang('Gallery')</a>
                                    </li>
                                @endgallery

                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link {{ menuActive(['contact'], 3) }}"
                                href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ menuActive(['service'], 3) }}"
                                href="{{ route('service') }}">@lang('Try-On')</a>
                        </li>

                        <li>
                            <div class="login_area">
                                @if (Auth::check())
                                    <a class="login_btn" href="{{ route('user.home') }}">@lang('My Account')</a>
                                @else
                                    <a class="login_btn" href="{{ route('login') }}">@lang('log in')</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                    @include($theme . 'partials.shopping_cart')
                </div>
            </div>
        </nav>
    </div>


    @include($theme . 'partials.banner')

    @yield('content')

    @include($theme . 'partials.footer')

    @stack('extra-content')

    <!----  How to load JS Library, Here is an example ----->
    <script src="{{ asset('assets/global/js/jquery.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/mixitup.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/aos.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/jQuery.rProgressbar.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset($themeTrue . 'js/main.js') }}"></script>


    @stack('extra-js')

    <script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/axios.min.js') }}"></script>

    @stack('script')

    @auth
        @if (config('basic.push_notification') == 1)
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
                                .then(function(res) {
                                    app.items = res.data;
                                })
                        },
                        readAt(id, link) {
                            let app = this;
                            let url = "{{ route('user.push.notification.readAt', 0) }}";
                            url = url.replace(/.$/, id);
                            axios.get(url)
                                .then(function(res) {
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
                                .then(function(res) {
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
                            channel.bind('App\\Events\\UserNotification', function(data) {
                                app.items.unshift(data.message);
                            });
                            channel.bind('App\\Events\\UpdateUserNotification', function(data) {
                                app.getNotifications();
                            });
                        }
                    }
                });
            </script>
        @endif
    @endauth

    @include($theme . 'partials.notification')

    @include('plugins')


</body>

</html>
