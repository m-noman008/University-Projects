@extends('admin.layouts.app')
@section('title')
    @lang('Edit Team')
@endsection
@section('content')
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="mb-4 media justify-content-end">
                <a href="{{ route('admin.staff.list') }}" class="mr-2 btn btn-sm btn-primary">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>
            <div class="mt-2 tab-content" id="myTabContent">
                    <div class="container"
                        role="tabpanel">
                        <form method="post" action="{{ route('admin.staff.update',['id' =>$data->id]) }}" class="mt-4"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="name"> @lang('Name') </label>
                                    <input type="text" name="name"
                                        class="form-control  @error('name') is-invalid @enderror"
                                        value="{{ old('name',$data->name) }}" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('name')
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" name="username"
                                        class="form-control  @error('username') is-invalid @enderror"
                                        value="{{ old('username',$data->username) }}" autocomplete="off">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                    <div class="col-sm-12 col-md-6">
                                        <label for="phone"> @lang('Phone') </label>
                                        <input type="text" name="phone"
                                            class="form-control  @error('phone') is-invalid @enderror"
                                            value="{{ old('phone',$data->phone) }}" autocomplete="off">
                                        <div class="phone">
                                            @error('phone')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="email"> @lang('Email') </label>
                                        <input type="email" name="email"
                                            class="form-control  @error('email') is-invalid @enderror"
                                            value="{{ old('email',$data->email) }}" autocomplete="off">
                                        <div class="email">
                                            @error('email')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>


                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="address">Address </label>
                                        <input type="text" name="address"
                                            class="form-control  @error('address') is-invalid @enderror"
                                            value="{{ old('address',$data->address) }}" autocomplete="off">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="password">Password</label>
                                        <input type="text" name="password"
                                            class="form-control  @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}" autocomplete="off">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="role">Role</label>
                                        <select name="role" class="form-control @error('role') is-invalid @enderror">
                                            <option value="">Select Role</option>
                                            <option value="order_manager" {{ old('role',$data->role) == 'order_manager' ? 'selected' : '' }}>Order Manager</option>
                                            <option value="appointer" {{ old('role',$data->role) == 'appointer' ? 'selected' : '' }}>Appointer</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="image">{{ 'Image' }}</label>
                                            <div class="image-input ">
                                                <label for="image-upload" id="image-label"><i
                                                        class="fas fa-upload"></i></label>
                                                <input type="file" name="image" placeholder="@lang('Choose image')"
                                                    id="image">
                                                <img id="image_preview_container" class="preview-image" src=""
                                                    alt="@lang('preview image')">
                                            </div>
                                            @if (config('location.admin.path'))
                                                <span class="mb-2 text-muted">{{ trans('Image size should be') }}
                                                    {{ config('location.admin.size') }} {{ trans('px') }}</span>
                                            @endif
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                            <button type="submit"
                                class="mt-3 btn waves-effect waves-light btn-rounded btn-primary btn-block">@lang('Save')</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        "use strict";
        $(document).ready(function(e) {

            $('#image').on("change", function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#image2').on("change", function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container2').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
                Notiflix.Notify.Failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif
@endpush
