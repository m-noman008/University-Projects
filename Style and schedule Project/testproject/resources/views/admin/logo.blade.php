@extends('admin.layouts.app')

@section('title')
    @lang('Logo Settings')
@endsection
@section('content')

    <div class="container-fluid">
        <div class="my-4 bd-callout bd-callout-warning m-md-0 ">
            <i class="mr-2 fas fa-info-circle"></i> @lang("After changes logo. Please clear your browser's cache to see changes.")
        </div>
        <div class="mt-4 row">
            <div class="col-12">
                <div class="shadow card card-primary">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $errors->has('profile') ? 'active' : ($errors->has('password') ? '' : 'active') }}"
                                   data-toggle="tab" href="#home">@lang('Logo & Favicon')</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home"
                                 class="mt-3 container tab-pane {{ $errors->has('profile') ? 'active' : ($errors->has('password') ? '' : 'active') }}">
                                <form action="{{ route('admin.logoUpdate')}}" method="post"
                                      enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @csrf
                                                <div class="image-input">
                                                    <label for="image-upload" id="image-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="image" placeholder="@lang('Choose image')"
                                                           id="image">
                                                    <img id="image_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').'logo.png') ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @csrf
                                                <div class="image-input ">
                                                    <label for="image-upload" id="image-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="favicon" placeholder="@lang('Choose image')"
                                                           id="favicon">
                                                    <img id="favicon_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').'favicon.png') ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('favicon')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <div class="mt-4 text-center submit-btn-wrapper">
                                                <button type="submit"
                                                        class="btn waves-effect waves-light btn-primary btn-block btn-rounded">
                                                    <span>@lang('Save Changes')</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function (e) {
            "use strict";

            $('#image').on("change",function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#adminLogo').on("change",function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#adminLogo_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#favicon').on("change",function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#favicon_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#meta_image').on("change",function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#meta_image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>
@endpush
