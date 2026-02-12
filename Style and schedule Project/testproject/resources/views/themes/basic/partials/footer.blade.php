@if (isset($contactUs['contact-us'][0]) && ($contact = $contactUs['contact-us'][0]))

    <section class="footer_area">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="widget_logo_side">
                        <div class="logo_area">
                            <a href="{{ route('home') }}"><img
                                    src="{{ getFile(config('location.logoIcon.path') . 'admin-logo.png') }}"
                                    alt="{{ config('basic.site_title') }}">
                            </a>
                        </div>
                    </div>
                    <div class="text_area">
                        <p class="pt-40 pb-45">Welcome to Style & Schedule, where precision meets artistry in men's grooming. Our expert barbers specialize in modern and classic haircuts, clean shaves</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="quick_link_area">
                        <div class="pb-40 section_header">
                            <h5>@lang('QUICK LINKS')</h5>
                        </div>
                        <div class="section_list">
                            <ul>
                                <li><a href="{{ route('about') }}">@lang('About Us')</a></li>

                                @faq
                                <li class="nav-item"><a class="nav-link"
                                                        href="{{ route('faq') }}">@lang('FAQ')</a></li>
                                @endfaq

                                @if(isset($contentDetails['pages']))
                                    @foreach($contentDetails['pages'] as $data)
                                        <li>
                                            <a href="{{ route('getLink', [slug($data->description->title), $data->content_id]) }}">@lang($data->description->title)</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="quick_link_area me-5">
                        <div class="pb-40 section_header">
                            <h5>@lang('CONTACT')</h5>
                        </div>
                        <div class="section_list">
                            <ul>
                                <li>
                                    <i class="fas fa-phone"></i>
                                    <span>+92 3486282154</span>
                                </li>
                                <li>
                                    <i class="far fa-envelope"></i>
                                    <span>@lang(optional($contact->description)->email_one)</span>
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Sadar Bazar MBDIN</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="gallery_area">
                        <div class="pb-40 section_header">
                            <h5>@lang('GALLERY')</h5>
                        </div>
                        <div id="masonryContainer" class="text-center cols footer_magnific_popup">
                            @forelse($manageGallery->take(6) as $gallery)
                                <div class="img-box">
                                    <a href="{{ getFile(config('location.gallery.path') . $gallery->image) }}"
                                       target="">
                                        <img src="{{ getFile(config('location.gallery.path') . $gallery->image) }}"
                                             alt="" class="img-fluid"/>
                                    </a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="copy_right_area pt-50 pb-50">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="text-center col-sm-6 text-sm-start">
                    <h6> @lang('© Copyright') {{ date('Y') }} @lang('by') {{ $basic->site_title }}</h6>
                </div>
                <div class="col-sm-6">
                    <ul class="social_area d-flex justify-content-center justify-content-sm-end">
                        @foreach ($contentDetails['social'] as $data)
                            <li>
                                <a href="{{ optional(optional(optional($data->content)->contentMedia)->description)->link }}"
                                   target="_blank">
                                    <i class="{{ optional(optional(optional($data->content)->contentMedia)->description)->icon }}">
                                    </i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
