@extends($theme.'layouts.app')
@section('title','Reset Password')

@section('content')
    <section class="login_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="form-block py-5 registration_form">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ trans(session('status')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form class="login-form" action="{{ route('password.email') }}"  method="post">
                            @csrf
                            <div>
                                <h3 class="title mb-30">@lang('Reset Password')</h3>

                                <div class="form-group mb-30 name_area icon_position">
                                    <input class="form-control" type="email" name="email" value="{{old('email')}}"
                                           placeholder="@lang('Enter your email address')" autocomplete="off">

                                    @error('email')<span class="text-danger  mt-1">{{ trans($message) }}</span>@enderror
                                </div>


                                <div class="btn-area">
                                    <button class="common_btn mb-40 d-flex justify-content-center align-items-center" type="submit"><span>@lang('Send Password Reset Link')</span></button>
                                </div>

                                <div class="login-query mt-30 text-center">
                                    <a href="{{ route('register') }}">@lang("Don't have any account? Sign Up")</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

