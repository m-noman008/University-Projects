@extends($theme.'layouts.app')
@section('title','Register')
@section('content')
    <section class="register_area login_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="text-center section_header">
                    <h2>@lang('Create an Account')</h2>
                </div>
                <div class="col-lg-10 registration_form" data-aos="fade-right">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="text" name="firstname" class="form-control"
                                           placeholder="@lang('First Name')" value="{{ old('firstname') }}"
                                           autocomplete="off" aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    @error('firstname')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="text" name="lastname" class="form-control"
                                           placeholder="@lang('Last Name')" value="{{ old('lastname') }}"
                                           autocomplete="off" aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    @error('lastname')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="text" name="username" class="form-control"
                                           placeholder="@lang('Username')" value="{{ old('username') }}"
                                           autocomplete="off" aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    @error('username')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    @php
                                        $country_code = (string) @getIpInfo()['code'] ?: null;
                                        $myCollection = collect(config('country'))->map(function($row) {
                                            return collect($row);
                                        });
                                        $countries = $myCollection->sortBy('code');
                                    @endphp
                                    <div class="input-group phone-country-code">
                                        <select name="phone_code"
                                                class="form-select country_code dialCode-change text-secondary">
                                            <option value="+92" data-name="Pakistan" data-code="PK" selected> PK (+92)</option>
                                        </select>
                                        <input type="text" name="phone" class="form-control dialcode-set"
                                            value="{{ old('phone', '+92') }}"
                                            placeholder="@lang('Your Phone Number')" required @required(true) aria-required="true">

                                        <div class="mt-1 image_area">
                                            <i class="fa-regular fa-phone"></i>
                                        </div>
                                    </div>

                                    @error('phone')
                                    <span class="mt-1 text-danger">{{ $message }}</span>
                                    @enderror

                                    <input type="hidden" name="country_code" value="{{old('country_code')}}"
                                           class="text-dark">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="email" name="email" class="form-control"
                                           placeholder="@lang('Email Address')" value="{{ old('email') }}"
                                           autocomplete="off" required @@required(true) aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    @error('email')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="text" name="address" class="form-control"
                                           placeholder="@lang('Address')" value="{{ old('address') }}"
                                           autocomplete="off">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-location"></i>
                                    </div>
                                    @error('address')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="@lang('Password')" autocomplete="off" aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-lock"></i>
                                    </div>
                                    @error('password')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name_area icon_position">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="@lang('Confirm Password')" autocomplete="off" aria-required="true">
                                    <div class="mt-1 image_area">
                                        <i class="fa-regular fa-lock"></i>
                                    </div>
                                    @error('password_confirmation')<span class="mt-1 text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            @if(basicControl()->reCaptcha_status_registration)
                                <div class="mt-4 col-md-6 box form-group">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display(['data-theme' => '']) !!}
                                    @error('g-recaptcha-response')
                                    <span class="mt-1 text-danger">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif

                        </div>
                        <div class="remember_forgot">
                            <div class="mt-4 mb-40 condition_area form-check d-flex align-items-center">
                                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1" value="{{ old('remember') ? 'checked' : '' }}">
                                <label class="mt-1 form-check-label" for="exampleCheck1">@lang('I Have Read And Agree To The Website Terms And Conditions')</label>
                            </div>

                        </div>
                        <button type="submit"
                                class="mb-40 common_btn d-flex justify-content-center align-items-center">@lang('Register')</button>
                        <h6 class="mb-40 text-center highlight">@lang('Already have account?') <a
                                href="{{ route('login') }}"> @lang('Sign In')</a>
                        </h6>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });

            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }

        });

    </script>
@endpush
