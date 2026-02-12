@extends($theme.'layouts.app')
@section('title','405')


@section('content')
    <div class="error_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="error_area_inner text-center">
                    <div class="text_area mb-40">
                        <span class="cmn_error">{{trans('405')}}</span>
                        <h1 class="mb-40">@lang('ERROR')</h1>
                        <h4>{{trans("Method Not Allowed")}}</h4>
                    </div>
                    <a href="{{ route('home') }}" class="common_btn d-flex justify-content-center align-items-center m-auto">@lang('back To home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
