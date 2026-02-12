@extends('admin.layouts.login')
@section('title','Admin Login')

@section('content')
    <div class="p-3">
        <h2 class="mt-3 text-center">Dashboard Login</h2>

        <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div class="mb-5 row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark" for="email">@lang('Email Or Username')</label>
                        <input id="username" type="text"
                               class="form-control
                                @error('username') is-invalid @enderror
                                @error('email') is-invalid @enderror
                            " name="username"
                               value="{{old('username')}}"  autocomplete="off" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark" for="pwd">@lang('Password')</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="text-center col-lg-12">
                    <button type="submit" class="btn btn-block btn-dark">@lang('Sign In')</button>
                </div>


                <div class="mt-5 text-center col-lg-12">
                    <a href="{{route('admin.password.request')}}" class="text-danger">{{trans('Forgot Your Password?')}}</a>
                </div>


            </div>
        </form>
    </div>
@endsection
