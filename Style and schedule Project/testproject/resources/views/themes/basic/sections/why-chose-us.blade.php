<section class="main_about_area about2_area">
    <div class="container">
        @if(isset($templates['why-chose-us'][0]) && $whyChoseUs = $templates['why-chose-us'][0])
            <div class="row g-md-4 g-5">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="about2_left">
                        <div class="feature1">
                            <img src="{{getFile(config('location.content.path').@$whyChoseUs->templateMedia()->image)}}"
                                 alt="...">
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="about2_right">
                        <div class="section_header">
                            <h2>@lang(optional($whyChoseUs->description)->title)</h2>
                            <p>@lang(optional($whyChoseUs->description)->short_details)</p>
                        </div>
                        <div class="section_body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <i class="fa-solid fa-arrow-right-long"></i>@lang(optional($whyChoseUs->description)->about_us_text_one)
                                    </p>
                                    <p>
                                        <i class="fa-solid fa-arrow-right-long"></i>@lang(optional($whyChoseUs->description)->about_us_text_two)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <i class="fa-solid fa-arrow-right-long"></i>@lang(optional($whyChoseUs->description)->about_us_text_three)
                                    </p>
                                    <p>
                                        <i class="fa-solid fa-arrow-right-long"></i>@lang(optional($whyChoseUs->description)->about_us_text_four)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><span
                                            class="highlight">@lang(optional($whyChoseUs->description)->ceo_name)</span>
                                        - @lang('CEO')
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($contentDetails['why-chose-us']))
            <div class="bottom_area pt-150" data-aos="fade-up">
                <div class="row g-4">
                    @foreach($contentDetails['why-chose-us'] as $item)
                        <div class="col-md-4">
                            <div class="card border-0 rounded-0 h-100 box_shadow2">
                                <div class="card_inner d-flex  align-items-center m-auto">
                                    <div class="img_area">
                                        <img
                                            src="{{getFile(config('location.content.path').optional(optional(optional($item->content)->contentMedia)->description)->image)}}"
                                            alt="">
                                    </div>
                                    <div class="text_area">@lang(optional($item->description)->title)</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
