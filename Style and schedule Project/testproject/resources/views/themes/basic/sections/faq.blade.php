<section class="faq_area">
    <div class="container">
        @if(isset($templates['faq'][0]) && $faq = $templates['faq'][0])
            <div class="row">
                <div class="section_header text-center">
                    <h2>@lang(optional($faq->description)->title)</h2>
                    <p>@lang(optional($faq->description)->sub_title)</p>
                </div>
            </div>
        @endif
        @if(isset($contentDetails['faq']))
            <div class="row">
                <div class="col-md-6" data-aos="fade-left">
                    @foreach($contentDetails['faq'] as $k => $data)
                        @if($k % 2 == 0)
                            <div class="accordion_area mt-45">
                                <div class="accordion_item">
                                    <button class="accordion_title">@lang(optional($data->description)->title)<i
                                            class="fa fa-{{ $k == 0 ? 'minus' : 'plus' }}"></i></button>
                                    <p class="accordion_body {{$k == 0 ? 'show' : ''}}">@lang(strip_tags(optional($data->description)->description))</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <div class="accordion_area mt-45">
                        @foreach($contentDetails['faq'] as $k => $data)
                            @if($k % 2 != 0)
                                <div class="accordion_area mt-45">
                                    <div class="accordion_item">
                                        <button class="accordion_title">@lang(optional($data->description)->title)<i
                                                class="fa fa-plus"></i></button>
                                        <p class="accordion_body">@lang(strip_tags(optional($data->description)->description))</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
