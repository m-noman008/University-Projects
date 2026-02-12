@extends($theme.'layouts.app')
@section('title','500')


@section('content')
    <div class="error_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="error_area_inner text-center">
                    <div class="text_area mb-40">
                        <span class="cmn_error">@lang('500')</span>
                        <h1 class="mb-40">@lang('Internal Server Error')</h1>
                        <h4>@lang("The server encountered an internal error misconfiguration and was unable to complate your request. Please contact the server administrator.")</h4>
                    </div>
                    <a href="{{ route('home') }}" class="common_btn d-flex justify-content-center align-items-center m-auto">@lang('back To home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
