@extends($theme . 'layouts.user')
@section('title', trans('My Profile'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h2 class="mb-0">@lang('Edit profile')</h2>
                    <a href="{{ route('user.home') }}" class="btn-custom">@lang('Back')</a>
                </div>
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-4">
                            <div class="sidebar-wrapper">
                                <form method="post" action="{{ route('user.updateProfile') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="profile">
                                        <div class="img">
                                            <img id="profile"
                                                 src="{{ getFile(config('location.user.path') . $user->image) }}"
                                                 alt="@lang('preview image')" class="img-fluid"/>
                                            <button class="upload-img">
                                                <i class="fal fa-camera"></i>
                                                <input class="form-control" accept="image/*" type="file" name="image"
                                                       onchange="previewImage('profile')"/>
                                            </button>
                                        </div>
                                        <div class="text">
                                            <h5 class="name">@lang(ucfirst($user->firstname . ' ' . $user->lastname))</h5>
                                            <span>@lang('@' . $user->username)</span>
                                        </div>
                                    </div>
                                    <div class="image_update_area mt-2">
                                        <button type="submit" class="btn-custom">@lang('Update Image')</button>
                                    </div>
                                </form>

                                <div class="profile-navigator">
                                    <button tab-id="tab1"
                                            class="tab {{ $errors->has('profile') ? 'active' : ($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification') ? '' : ' active') }}">
                                        <i class="fal fa-user"></i> @lang('Profile information')
                                    </button>
                                    <button tab-id="tab2" class="tab {{ $errors->has('password') ? 'active' : '' }}">
                                        <i class="fal fa-key"></i> @lang('Password setting')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="tab1"
                                 class="content {{ $errors->has('profile') ? ' active' : ($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification') ? '' : ' active') }}">
                                <form action="{{ route('user.updateInformation') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('First name')</label>
                                            <input type="text" class="form-control" name="first_name"
                                                   value="{{ old('first_name', $user->firstname) }}"
                                                   placeholder="@lang('Mr. John')"/>
                                            @if ($errors->has('first_name'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('first_name')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('last name')</label>
                                            <input type="text" class="form-control" name="last_name"
                                                   value="{{ old('last_name', $user->lastname) }}" placeholder="Doe"/>
                                            @if ($errors->has('last_name'))
                                                <div class="error text-danger">@lang($errors->first('last_name')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('username')</label>
                                            <input type="text" class="form-control" name="username"
                                                   value="{{ old('username', $user->username) }}"
                                                   placeholder="johndoe"/>
                                            @if ($errors->has('username'))
                                                <div class="error text-danger">@lang($errors->first('username')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('email address')</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="@lang('example@gmail.com')"/>
                                            @if ($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('phone number')</label>
                                            <input type="text" class="form-control" name="phone"
                                                   value="{{ old('phone', $user->phone) }}"
                                                   placeholder="@lang('01234567891')"/>
                                            @if ($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('preferred language')</label>
                                            <select name="language_id" id="language_id" class="form-select">
                                                <option value="" disabled>@lang('Select Language')</option>
                                                @foreach ($languages as $la)
                                                    <option value="{{ $la->id }}"
                                                        {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}>
                                                        @lang($la->name)</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('language_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('language_id')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-12">
                                            <label for="">@lang('address')</label>
                                            <textarea name="address" class="form-control" cols="30" rows="3"
                                                      placeholder="@lang('457 MORNINGVIEW, NEW YORK USA')">{{ $user->address }}</textarea>
                                            @if ($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-12">
                                            <button type="submit" class="btn-custom">@lang('submit')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="tab2" class="content {{ $errors->has('password') ? 'active' : '' }}">
                                <form action="{{ route('user.updatePassword') }}" method="post">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('Current Password')</label>
                                            <input type="password" name="current_password" class="form-control"/>
                                            @if ($errors->has('current_password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('New Password')</label>
                                            <input type="password" name="password" class="form-control"/>
                                            @if ($errors->has('password'))
                                                <div class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('Confirm Password')</label>
                                            <input type="password" name="password_confirmation" class="form-control"/>
                                            @if ($errors->has('password_confirmation'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-12">
                                            <button type="submit" class="btn-custom">@lang('change password')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
