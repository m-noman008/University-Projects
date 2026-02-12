@if(isset($templates['process-behind'][0]) && $processBehind = $templates['process-behind'][0])
    <section class="video_area"
             style="background: linear-gradient(rgb(53, 49, 47, 0.9), rgb(53, 49, 47, 0.9)), url({{ getFile(config('location.content.path').optional($processBehind->templateMedia())->background_image) }});">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <div class="section_left" data-aos="fade-left">
                        <div class="section_header">
                            <h2>@lang(optional($processBehind->description)->title)</h2>
                            <p>@lang(optional($processBehind->description)->short_details)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section_right" data-aos="fade-right">
                        <a data-fancybox data-width="1000" data-height="600"
                           href="@lang(optional($processBehind->templateMedia())->video_link)">
                            <div class="image_area">
                                <img
                                    src="{{ getFile(config('location.content.path').optional($processBehind->templateMedia())->image) }}"
                                    alt="" class="w-100">
                            </div>
                            <div class="play_btn d-flex justify-content-center align-items-center">
                                <i class="fas fa-play"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
