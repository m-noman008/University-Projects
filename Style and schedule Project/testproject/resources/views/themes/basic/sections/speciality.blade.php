@if(isset($templates['speciality'][0]) && $speciality = $templates['speciality'][0])
    <section class="speciality_area">
        <div class="container">
            <div class="row">
                <div class="section_header text-center">
                    <div class="header_text">
                        <h2>@lang(optional($speciality->description)->title)</h2>
                        <p class="title_details">At Style & Schedule, we pride ourselves on delivering exceptional grooming services tailored to each client's needs.</p>
                    </div>
                </div>
                @if(isset($contentDetails['speciality']))
                    <div class="col-lg-3 col-md-4 col-sm-6 order-1 order-sm-2">
                        <div class="section_left ">
                            @forelse($contentDetails['speciality'] as $key => $item)
                                @if($key%2==0)
                                    <div class="box box1 d-flex justify-content-md-end justify-content-center mb-3">
                                        <div class="text_area">
                                            <h5>@lang(optional($item->description)->title)</h5>
                                            <p>@lang(optional($item->description)->short_details)</p>
                                        </div>
                                        <div class="img_area d-flex justify-content-center align-items-center">
                                            <img
                                                src="{{getFile(config('location.content.path').optional(optional(optional($item->content)->contentMedia)->description)->image)}}"
                                                alt="">
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 order-2 order-sm-1 order-md-2">
                        <div class="section_middle" data-aos="zoom-in">
                            <img src="{{getFile(config('location.content.path').optional($speciality->templateMedia())->image)}}"
                                 alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 order-1 order-sm-2">
                        <div class="section_left ">
                            @forelse($contentDetails['speciality'] as $key => $item)
                                @if($key%2 != 0)
                                    <div class="box box1 d-flex justify-content-md-end justify-content-center mb-3">
                                        <div class="text_area">
                                            <h5>@lang(optional($item->description)->title)</h5>
                                            <p>@lang(optional($item->description)->short_details)</p>
                                        </div>
                                        <div class="img_area d-flex justify-content-center align-items-center">
                                            <img
                                                src="{{getFile(config('location.content.path').optional(optional(optional($item->content)->contentMedia)->description)->image)}}"
                                                alt="">
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

