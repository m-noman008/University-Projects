@team
@if(isset($templates['team'][0]) && $team = $templates['team'][0])
    <section class="ourteam_area">
        <div class="container">
            <div class="row">
                <div class="section_header text-center  mb-45">
                    <h2>@lang(optional($team->description)->title)</h2>
                    <p class="title_details">Our team is a dynamic collective of experts dedicated to delivering excellence</p>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel owl-theme ourteam_area_carousel">
                    @forelse($team_member as $key => $data)
                        <div class="item" data-aos="{{($key % 2 != 0) ? 'fade-up':'fade-down'}}">
                            <div class="card card1 border-0 box_shadow2">
                                <a href="{{ route('team.details', [@slug(optional($data->teamDetails)->name), $data->id]) }}">
                                    <div class="card_header">
                                        <div class="image_area">
                                            <img src="{{ getFile(config('location.team.path').$data->image) }}" alt="">
                                        </div>
                                        <div class="share_icon">
                                            <a href=""><i class="fa-solid fa-share-nodes"></i></a>
                                        </div>
                                        <div class="social_icon">
                                            <ul class="d-flex justify-content-center">
                                                <li><a href="{{ $data->facebook_link }}" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li><a href="{{ $data->twitter_link }}"><i
                                                            class="fa-brands fa-twitter"></i></a></li>
                                                <li><a href="{{ $data->linkedin_link }}"><i
                                                            class="fa-brands fa-linkedin"></i></a></li>
                                                <li><a href="{{ $data->skype_link }}"><i class="fa-brands fa-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                                <div class="card_body text-center">
                                    <a href="{{ route('team.details', [@slug(optional($data->teamDetails)->name), $data->id]) }}">
                                        <h5 class="mt-40 mb-20">@lang(optional($data->teamDetails)->name)</h5>
                                    </a>
                                    <p class="mb-20">@lang(optional($data->teamDetails)->position)</p>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endif
@endteam
