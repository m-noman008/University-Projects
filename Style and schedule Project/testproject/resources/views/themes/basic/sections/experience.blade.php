@if(isset($templates['experience'][0]) && $experience = $templates['experience'][0])
    <section class="about2_area">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 ">
                    <div class="about2_left" data-aos="flip-left">
                        <div class="feature1">
                            <img src="{{getFile(config('location.content.path').optional($experience->templateMedia())->image)}}"
                                 alt="">
                        </div>
                    </div>
                </div>
                @if(isset($contentDetails['experience']))
                    <div class="col-md-6">
                        <div class="about2_right" data-aos="flip-right">
                            <div class="section_header">
                                <h2>@lang(optional($experience->description)->title)</h2>
                                <p>@lang(optional($experience->description)->sub_title)</p>
                            </div>
                            @foreach($contentDetails['experience'] as $item)
                                <div class="card border-0 rounded-0 box_shadow2">
                                    <div class="card_inner d-flex">
                                        <div class="img_area">
                                            <img
                                                src="{{getFile(config('location.content.path').optional(optional(optional($item->content)->contentMedia)->description)->image)}}"
                                                alt="">
                                        </div>
                                        <div class="text_area">@lang(optional($item->description)->title)</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
