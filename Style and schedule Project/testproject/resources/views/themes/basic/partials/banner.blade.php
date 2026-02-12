<style>
    .banner_area {
        background-image: linear-gradient(90deg, rgba(7, 11, 40, 0.65) 0%, rgba(7, 11, 40, 0.65) 100%), url({{ getFile(config('location.logo.path') . 'banner.jpg') }});
    }
</style>
@if (!request()->routeIs('home'))
    <!-- PAGE-BANNER -->
    <div class="banner_area">
        <div class="container">
            <div class="row">
                <div class="secion_header">
                    <h1 class="banner_title">@yield('title')</h1>
                </div>
                <div class="breadcrumb d-flex justify-content-center">
                    <div class="text_area">
                        <h6><a href="{{ route('home') }}"><span>@lang('Home')</span></a> |
                            <span>@yield('title')</span></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /PAGE-BANNER -->
@endif
