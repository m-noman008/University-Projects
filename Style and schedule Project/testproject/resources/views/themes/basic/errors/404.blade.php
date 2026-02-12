@extends($theme.'layouts.app')
@section('title','404')

@section('content')
    <div class="error_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="error_area_inner text-center">
                    <div class="image_area">
                        <img src="{{ asset($themeTrue.'images/404-page/not-found.png') }}" alt="">
                    </div>
                    <div class="text_area mb-40">
                        <h1 class="mt-40 mb-40">@lang('ERROR')</h1>
                        <h4>@lang('Page Not Found')</h4>
                    </div>
                    <a href="{{ route('home') }}" class="common_btn d-flex justify-content-center align-items-center m-auto">@lang('back To home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
