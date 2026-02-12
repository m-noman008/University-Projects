@extends($theme . 'layouts.app')
@section('title', trans($title))

@section('content')
    <section class="team_details_area">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5" data-aos="fade-left">
                    <div class="image_area">
                        <img src="{{ getFile(config('location.team.path') . $team_details->image) }}" alt="">
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-center" data-aos="fade-right">
                    <div class="text_area">
                        <div class="section_header mb-40">
                            <h2>@lang(optional($team_details->teamDetails)->name)</h2>
                            <p>@lang(optional($team_details->teamDetails)->short_description)</p>
                        </div>
                        <div class="section_body mb-35">
                            <h5><span class="highlight">@lang('Position') : </span> @lang(optional($team_details->teamDetails)->position)
                            </h5>
                            <h5><span class="highlight">@lang('Experience') : </span> @lang($team_details->experience)</h5>
                            <h5><span class="highlight">@lang('Level') : </span> @lang($team_details->level)</h5>
                            <h5><span class="highlight">@lang('Email') : </span> @lang(optional($team_details->teamDetails)->email)
                            </h5>
                            <h5><span class="highlight">@lang('Phone') : </span>@lang($team_details->phone)</h5>
                        </div>
                        <ul class="social_area d-flex justify-content-start">
                            <li><a href="{{ $team_details->facebook_link }}" target="_blank"><i
                                        class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="{{ $team_details->twitter_link }}" target="_blank"><i
                                        class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="{{ $team_details->linkedin_link }}" target="_blank"><i
                                        class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="{{ $team_details->skype_link }}" target="_blank"><i
                                        class="fa-brands fa-skype"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="biography_area" data-aos="fade-up">
                <div class="row">
                    <div class="section_header mt-150 mb-150">
                        <h2 class="title2">@lang('Biography')</h2>
                        <p>
                            @lang(optional($team_details->teamDetails)->biography)
                        </p>
                    </div>
                </div>
            </div>
            <div class="skills_area" data-aos="fade-down">
                <h2 class="title2">@lang('Top Skills')</h2>
                <div class="row">
                    @foreach ($team_details->top_skills as $key => $data)
                        @php
                            $className = str_replace(' ', '_', $data->field_name);
                        @endphp
                        <div class="col-md-4">
                            <h6>{{ $data->field_name }}</h6>
                            <div class="{{ @$className }}">65</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="process_area mt-150">
                <div class="section_header">
                    <h2 class="title2">@lang('My Working Process')</h2>
                </div>

                <div class="section_bottom" data-aos="fade-up">
                    @lang(optional($team_details->teamDetails)->my_working_process)
                </div>
            </div>
        </div>
        <input type="hidden" class="res" value="{{ json_encode($team_details->top_skills) }}">
    </section>

@endsection

@push('script')
    <script>
        'use strict'
        var res = $('.res').val();
        var item = JSON.parse(res);
        for (const [key, value] of Object.entries(item)) {
            let lineItem = key.replace(' ', '_');
            $('.' + lineItem).rProgressbar({
                percentage: value.field_value,
            });
        }
    </script>
@endpush
