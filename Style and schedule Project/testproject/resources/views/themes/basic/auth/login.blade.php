@extends($theme.'layouts.app')
@section('title','Login')
@section('content')
        <section class="login_area">
            <div class="container">
                <div class="row justify-content-center">

                    @if(isset($templates['login'][0]) && $login = $templates['login'][0])
                    <div class="section_header text-center">
                        <h2>@lang(optional($login->description)->title)</h2>
                    </div>
                    <div class="col-md-6 login_image_area  d-flex align-items-end justify-content-center pb-30"
                         data-aos="fade-left"
                         style="background: linear-gradient(rgb(223, 142, 106,0.5), rgb(223, 142, 106,0.5)), url({{ getFile(config('location.content.path').$login->templateMedia()->image) }}); background-repeat: no-repeat; background-size: cover; ">
                        <a href="{{ route('home') }}"><img
                                src="{{ getFile(config('location.content.path').@$login->templateMedia()->logo_image) }}"
                                alt=""></a>
                    </div>

                    @endif
                    <div class="col-md-6 registration_form" data-aos="fade-right">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="col-md-12">
                                <div class="name_area icon_position mb-30">
                                    <input type="text" name="username" class="form-control"
                                           placeholder="@lang('Username or Email Address')" autocomplete="off">
                                    <div class="image_area mt-1">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    @error('username')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('email')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="name_area icon_position">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="@lang('Password')" autocomplete="off">
                                    <div class="image_area mt-1">
                                        <i class="fa-sharp fa-solid fa-unlock"></i>
                                    </div>
                                    @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            @if(basicControl()->reCaptcha_status_login)
                                <div class="col-md-12 box mt-4 form-group">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display(['data-theme' => '']) !!}
                                    @error('g-recaptcha-response')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif


                            <div class="remember_forgate d-flex justify-content-between align-items-center">
                                <div class="condition_area mt-30 mb-40 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">@lang('Remember Me?')</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="highlight">@lang('Forgot Password?')</a>
                            </div>
                            <button
                                class="common_btn mb-40 d-flex justify-content-center align-items-center">@lang('Login')</button>
                            <h6 class="highlight text-center mb-40">@lang('Haven’t any account?') <a
                                    href="{{ route('register') }}">@lang('Register')</a></h6>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection
