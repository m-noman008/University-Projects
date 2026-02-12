@if (isset($contentDetails['hero']))
    <div class="hero_area">
        <div class="hero_slider">
            @foreach ($contentDetails['hero'] as $item)
                <div class="slide slide1"
                     style="background: linear-gradient(rgb(53, 49, 47, 0.5),rgb(53, 49, 47, 0.5)), url({{ getFile(config('location.content.path') . @$item->content->contentMedia->description->image) }}); background-repeat: no-repeat; background-position: center; background-size: cover">
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 ">
                                <div class="section_hedding mb-50">
                                    <div class="section_title">
                                        <h1>@lang(optional($item->description)->title)</h1>
                                    </div>
                                    <div class="section_btn_area">
                                        <a class="common_btn" href="{{ route('appointment') }}">
                                            @lang(optional($item->description)->button_name)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="hero_section_bottom">
            <div class="container">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="section_counter">
                            <div class="slide-count-wrap">
                                <span class="current"></span> /
                                <span class="total"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 d-none d-sm-block">
                        <div class="section_nav">

                        </div>
                    </div>
                    @if (isset($contentDetails['social']))
                        <div class="col col-md-4">
                            <div class="social_area d-flex justify-content-end">
                                <ul class="d-flex ">
                                    @foreach ($contentDetails['social']->take(3) as $data)
                                        <li>
                                            <a href="{{ @$data->content->contentMedia->description->link }}"
                                               target="_blank"><i
                                                    class="{{ @$data->content->contentMedia->description->icon }}"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
