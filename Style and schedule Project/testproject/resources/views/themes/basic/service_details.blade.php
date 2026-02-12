@extends($theme . 'layouts.app')
@section('title', trans($title))
@section('content')
    <section class="services_details_area">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="section_left">
                        <ul class="tab_bar">
                            @foreach ($services as $service)
                                <li><a href="{{ route('service.details', [slug(@$service->serviceDetails->service_name), $service->id]) }}"
                                        class="{{ $service->id == optional($service_details->serviceDetails)->service_id ? 'active' : '' }}">@lang(optional($service->serviceDetails)->service_name)</a>
                                </li>
                            @endforeach
                        </ul>
                        @if (isset($templates['need-help'][0]) && ($needHelp = $templates['need-help'][0]))
                            <div class="help_area mt-40"
                                style="background: linear-gradient(rgba(53, 49, 47, 0.9),rgba(53, 49, 47, 0.9)), url({{ getFile(config('location.content.path') . $needHelp->templateMedia()->image) }}) no-repeat; background-size: cover">
                                <div class="section_content">
                                    <h5 class="pb-40">@lang(optional($needHelp->description)->title)</h5>
                                    <p class="pb-40">@lang(optional($needHelp->description)->sub_title)</p>
                                    <h6><i class="fa-solid fa-phone"></i> @lang(optional($needHelp->description)->phone)</h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="section_right">
                        <div class="main_image_area">
                            <img src="{{ getFile(config('location.service.pathImage') . $service_details->image) }}"
                                alt="..">
                        </div>
                        <div class="section_header">
                            <h2 class="mt-40">@lang(optional($service_details->serviceDetails)->service_name)</h2>
                            <p>@lang(optional($service_details->serviceDetails)->description)</p>
                        </div>
                        <div class="section_right_footer">
                            <a class="common_btn mt-40" href="{{ route('appointment') }}">@lang('BOOK APPOINTMENT')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
