@extends($theme . 'layouts.app')
@section('title', trans($title))
@section('content')
    <section class="ourteam_area">
        <div class="container">
            @if (isset($templates['team'][0]) && ($team = $templates['team'][0]))
                <div class="row">
                    <div class="section_header text-center  mb-45">
                        <h2>@lang(optional($team->description)->title)</h2>
                        
                    </div>
                </div>
            @endif
            <div class="row g-4">
                @forelse($team_member as $key => $data)
                    <div class="col-md-3 col-sm-6" data-aos="{{ $key % 2 != 0 ? 'fade-left' : 'fade-right' }}">
                        <div class="item">
                            <div class="card card1 border-0 box_shadow2">
                                <a
                                    href="{{ route('team.details', [slug(optional($data->teamDetails)->name)??'team-member', $data->id]) }}">
                                    <div class="card_header">
                                        <div class="image_area">
                                            <img src="{{ getFile(config('location.team.path') . $data->image) }}"
                                                alt="..">
                                        </div>
                                        <div class="share_icon">
                                            <a href=""><i class="fa-solid fa-share-nodes"></i></a>
                                        </div>
                                        <div class="social_icon">
                                            <ul class="d-flex justify-content-center">
                                                <li><a href="{{ $data->facebook_link }}" target="_blank"><i
                                                            class="fa-brands fa-facebook-f"></i></a></li>
                                                <li><a href="{{ $data->twitter_link }}" target="_blank"><i
                                                            class="fa-brands fa-twitter"></i></a></li>
                                                <li><a href="{{ $data->linkedin_link }}" target="_blank"><i
                                                            class="fa-brands fa-linkedin"></i></a></li>
                                                <li><a href="{{ $data->skype_link }}" target="_blank"><i
                                                            class="fa-brands fa-skype"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                                <div class="card_body text-center">
                                    <a href="{{ route('team.details', [slug(optional($data->teamDetails)->name)??'team-member', $data->id]) }}">
                                        <h5 class="mt-40 mb-20">@lang(optional($data->teamDetails)->name)</h5>
                                    </a>
                                    <p class="mb-20">@lang(optional($data->teamDetails)->position)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="d-flex flex-column justify-content-center py-5">
                        <h3 class="text-center mt-5 mb-3">@lang("No Team Member  Available")</h3>
                        <a href="{{ url('/') }}" class="text-center">
                            <button class="btn common_btn">@lang('Back')</button>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
