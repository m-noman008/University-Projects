@extends($theme.'layouts.app')
@section('title', trans($title))
@section('content')
    <section class="main_services_area">
        <div class="container">
            <div class="row gy-4">
                @forelse($services as $item)
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card box_shadow1 border-0 ">
                            <div class="card_header">
                                <div class="image_area ">
                                    <a href="{{ route('service.details', [slug(optional($item->serviceDetails)->service_name), $item->id]) }}">
                                        <img
                                            src="{{ getFile(config('location.service.pathThumbnail').$item->thumbnail)}}"
                                            alt=".."></a>
                                </div>
                                <div class="text_area">
                                    <h6>{{ config('basic.currency_symbol') . number_format($item->price,2) }}</h6>
                                </div>
                            </div>
                            <div class="card_body">
                                <div class="section_header">
                                    <a href="{{ route('service.details', [slug(optional($item->serviceDetails)->service_name), $item->id]) }}">
                                        <h5 class="pb-15 transition">@lang(optional($item->serviceDetails)->service_name)</h5>
                                    </a>
                                    <p class="pb-25">@lang(optional($item->serviceDetails)->short_title)</p>
                                    <a href="{{ route('service.details', [slug(optional($item->serviceDetails)->service_name), $item->id]) }}"><span
                                            class="d-flex align-items-center transition">@lang('READ MORE')
                                            <i class="fa-solid fa-arrow-right-long"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex flex-column justify-content-center py-5">
                        <h3 class="text-center mt-5 mb-3">@lang("No Service  Available")</h3>
                        <a href="{{ url('/') }}" class="text-center">
                            <button class="btn common_btn">@lang('Back')</button>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @include($theme.'sections.facts')
@endsection

