@if(isset($templates['facts'][0]) && $facts = $templates['facts'][0])
    <section class="counter_area"
             style="background: linear-gradient(rgba(53, 49, 47, 0.8),rgba(53, 49, 47, 0.9)), url({{ getFile(config('location.content.path') . optional($facts->templateMedia())->image) }}); background-repeat: no-repeat; background-size: cover">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-left">
                    <div class="content_area">
                        <div class="section_header">
                            <h2>@lang(optional($facts->description)->title)</h2>
                            <p>
                                @lang(optional($facts->description)->sub_title)
                            </p>
                        </div>
                    </div>
                </div>
                @if(isset($contentDetails['facts']))
                    @foreach($contentDetails['facts'] as $item)
                        <div class="col-md-2">
                            <div class="card rounded-0">
                                <div class="card_header text-center">
                                    <div class="image_area">
                                        <img
                                            src="{{getFile(config('location.content.path').@$item->content->contentMedia->description->image)}}"
                                            alt="">
                                    </div>
                                    <div class="text_area">
                                        <h5 class="main_services_counter pt-20">@lang(optional($item->description)->count)</h5>
                                    </div>
                                </div>
                                <div class="card_body">
                                    <div class="text_area text-center">
                                        <h6 class="pt-20 pb-20">@lang(optional($item->description)->name)</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endif
