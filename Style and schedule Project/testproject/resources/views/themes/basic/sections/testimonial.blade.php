@if(isset($templates['testimonial'][0]) && $testimonial = $templates['testimonial'][0])
    <section class="testimonial_area">
        <div class="container">
            <div class="row">
                <div class="section_header text-center">
                    <h2>@lang(optional($testimonial->description)->title)</h2>
                    <p class="title_details pb-45">Testimonials

At Style & Schedule, our clients consistently rave about their experiences. Alex M. praises our precision haircuts and professional staff, while Sarah K. finds our spa treatments perfect for relaxation</p>
                </div>
            </div>
            <div class="row g-5 g-md-4">
                <div class="col-md-6 col-12">
                    <div class="row align-items-center">
                        <div class="col-4 ">
                            <div class="testimonial_thamnail" data-aos="fade-left">
                                @if(isset($contentDetails['testimonial']))
                                    @foreach($contentDetails['testimonial'] as $key=>$data)
                                        <div class="image_area">
                                            <img
                                                src="{{getFile(config('location.content.path').'thumb_'.optional(optional(optional($data->content)->contentMedia)->description)->image)}}"
                                                alt="...">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="image_area testimonial_slider">
                                @if(isset($contentDetails['testimonial']))
                                    @foreach($contentDetails['testimonial'] as $key=>$data)
                                        <div class="image_area">
                                            <img
                                                src="{{getFile(config('location.content.path').optional(optional(optional($data->content)->contentMedia)->description)->image)}}"
                                                alt="">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-auto" data-aos="fade-right">
                    <div class="content_area testimonial_slider">
                        @if(isset($contentDetails['testimonial']))
                            @foreach($contentDetails['testimonial'] as $key=>$data)
                                <div class="text_area d-flex align-items-center">
                                    <div class="text_area_inner">
                                        <div class="section_header d-flex pb-40">
                                            <img
                                                src="{{ asset($themeTrue. 'images/quotes.png') }}"
                                                alt="">
                                            <div class="text">
                                                <h5 class="heading">@lang(optional($data->description)->name)</h5>
                                                <p>@lang(optional($data->description)->designation)</p>
                                            </div>
                                        </div>
                                        <p class="description">
                                        James is a dedicated and satisfied client of Style & Schedule who continually praises the salon's exceptional services. He particularly appreciates the precision haircuts, which always meet his expectations, and the relaxing spa treatments that help him unwind after a busy week. John's loyalty to Style & Schedule stems from the consistent, high-quality service he receives and the friendly, professional staff who make every visit a pleasant experience. His positive experiences with our expert hair coloring techniques have also contributed to his glowing recommendations. For John, Style & Schedule is the go-to place for all his grooming needs.
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
