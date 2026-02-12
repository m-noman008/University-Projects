@if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0])
    <section class="sub_about_area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section_left">
                        <div class="image_area">
                            <img src="{{getFile(config('location.content.path').@$aboutUs->templateMedia()->image)}}"
                                 alt="...">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center position_right">
                    <div class="section_right">
                        <div class="image_area">
                            <img src="{{ asset($themeTrue. 'images/about.png') }}" alt="...">
                        </div>
                        <div class="section_header">
                            <h2>@lang(optional($aboutUs->description)->title)</h2>
                            <p class="highlight">@lang(optional($aboutUs->description)->sub_title)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
