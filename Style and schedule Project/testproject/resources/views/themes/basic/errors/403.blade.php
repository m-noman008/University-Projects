@extends($theme.'layouts.app')
@section('title','403 Forbidden')


@section('content')
    <div class="error_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="error_area_inner text-center">
                    <div class="text_area mb-40">
                        <span class="cmn_error">@lang('403')</span>
                        <h1 class="mb-40">@lang('Forbidden')</h1>
                        <h4>{{trans("You don't have permission to access on this server")}}</h4>
                    </div>
                    <a href="{{ route('home') }}" class="common_btn d-flex justify-content-center align-items-center m-auto">@lang('back To home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
