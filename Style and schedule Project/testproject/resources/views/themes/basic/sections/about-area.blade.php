<section class="about1_area">
    <div class="container">
        <div class="row g-4">
            @if(isset($templates['open-shop'][0]) && $openShop = $templates['open-shop'][0])
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 card1 h-100" data-aos="fade-right">
                        <div class="section_header">
                            <div class="header_text">
                                <p>
                                    <i class="fa-thin fa-location-dot"></i> @lang(optional($openShop->description)->address)
                                </p>
                            </div>
                        </div>
                        <div class="section_body section_body_bg">
                            <div class="sub_title_area d-flex">
                                <div class="section_img">
                                    <img
                                        src="{{getFile(config('location.content.path').optional($openShop->templateMedia())->image)}}"
                                        alt="">
                                </div>
                                <div class="section_sub_title">
                                    <div class="sub_title">
                                        <h4>@lang(optional($openShop->description)->title)</h4>
                                    </div>
                                </div>
                            </div>
                            @if(isset($contentDetails['open-shop-schedule']))
                                @foreach($contentDetails['open-shop-schedule'] as $item)
                                    <div class="section_time_area">
                                        <div class="time1">
                                            <p>@lang(optional($item->description)->day)</p>
                                            <h6>@lang(optional($item->description)->time)</h6>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($templates['about-area'][0]) && $aboutUs = $templates['about-area'][0])
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 bg-transparent card2 px-2 h-100" data-aos="fade-down">
                        <div class="">
                            <div class="header_text">
                                <h5>@lang(optional($aboutUs->description)->short_title)</h5>
                            </div>
                        </div>

                        @if(optional($aboutUs->description)->details)
                            <div class="section_body">
                                <div class="list_item_area pt-4">
                                    <ul class="list_item">
                                        @lang(optional($aboutUs->description)->details)
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="section_bottom_area d-flex justify-content-between mt-auto">
                            <div class="hair_styling_btn">

                                <a class="hair_btn d-flex align-items-center justify-content-center"
                                   href="{{optional($aboutUs->templateMedia())->button_link_one}}">
                                    <span class="scissors"><i class="far fa-cut"></i></span>
                                    @lang(optional($aboutUs->description)->button_name_one)
                                </a>
                            </div>
                            <div class="hair_coloring_btn">
                                <a class="hair_btn d-flex align-items-center justify-content-center"
                                   href="{{optional($aboutUs->templateMedia())->button_link_two}}">
                                    <span class="hair_color_font"><i class="far fa-mortar-pestle"></i></span>
                                    @lang(optional($aboutUs->description)->button_name_two)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 bg-transparent card3 h-100 d-flex" data-aos="fade-left">
                        <div class="">
                            <div class="header_text">
                                <h2>@lang(optional($aboutUs->description)->title)</h2>
                            </div>
                        </div>
                        <div class="section_body mt-auto">
                            <img class="w-100"
                                 src="{{getFile(config('location.content.path').optional($aboutUs->templateMedia())->image)}}"
                                 alt="">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

