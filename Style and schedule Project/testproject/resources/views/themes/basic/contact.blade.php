@extends($theme . 'layouts.app')
@section('title', trans($title))

@section('content')
    <!-- CONTACT -->
    <section class="contact_area">
        <div class="container">
            <div class="row gy-5">
                <div class="col-md-6" data-aos="fade-left">
                    <div class="section_left">
                        <div class="section_header">
                            <h2>@lang($contact->heading??null)</h2>
                          
                        </div>
                        @if (isset($contentDetails['social']))
                            <ul class="social_area d-flex justify-content-start pt-40">
                                @foreach ($contentDetails['social'] as $data)
                                    <li>
                                        <a href="{{ optional(optional(optional($data->content)->contentMedia)->description)->link }}">
                                            <i class="{{ optional(optional(optional($data->content)->contentMedia)->description)->icon }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <div class="section_right">
                        <form class="row g-3" action="{{ route('contact.send') }}" method="post">
                            @csrf
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="@lang('Name')" aria-label="name" autocomplete="off" required>
                                    <div class="image_area">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="email_area icon_position">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        placeholder="@lang('Email')" autocomplete="off" required>
                                    <div class="image_area">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="phone_area icon_position">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                        placeholder="@lang('Phone')" autocomplete="off" required>
                                    <div class="image_area">
                                        <i class="fa-light fa-phone-office"></i>
                                    </div>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="subject_area icon_position">
                                    <input type="tel" class="form-control" name="subject" value="{{ old('subject') }}"
                                        placeholder="@lang('Subject')" autocomplete="off" required>
                                    <div class="image_area">
                                        <i class="fa-regular fa-pencil"></i>
                                    </div>
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text_area icon_position">
                                    <textarea class="form-control" rows="5" name="message" value="{{ old('message') }}"
                                        placeholder="@lang('Write Message...')"></textarea>
                                    <div class="image_area">
                                        <i class="fa-regular fa-message"></i>
                                    </div>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 pt-40">
                                <button type="submit" class="common_btn">@lang('SEND MESSAGE')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    @if(isset($contact->map_link))
    <div class="map_area">
        <iframe src="{{$contact->map_link}}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    @endif
    <!-- /CONTACT -->

@endsection
