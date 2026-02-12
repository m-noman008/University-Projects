@extends('admin.layouts.app')
@section('title', trans('Add Plan'))
@section('content')
    <div class="row ">
        <div class="col-12">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="media mb-4 justify-content-end">
                        <a href="{{ route('admin.plan.list') }}" class="btn btn-sm  btn-primary mr-2">
                            @lang('Back')
                        </a>
                    </div>
                    <form method="post" action="{{ route('admin.plan.update', $plans->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>{{ trans('Name') }}</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $plans->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-6">
                                <label>{{ trans('Price') }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="price"
                                        value="{{ old('price', $plans->price) }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ $basic->currency ?? 'USD' }}
                                        </div>
                                    </div>
                                </div>
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label for="sku" class="mb-1"> @lang('Service Name') </label>
                                <select class="form-select form-control" id="select" multiple="multiple"
                                    name="service_name[]">
                                    @foreach ($service_name as $service)
                                        <option value="{{ optional($service->serviceDetails)->service_name }}"
                                            @foreach ($plans->services as $data)
                                            {{ optional($service->serviceDetails)->service_name == $data ? 'selected' : '' }} @endforeach>
                                            @lang(optional($service->serviceDetails)->service_name)</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('sku')
                                        @lang($message)
                                    @enderror
                                </div>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="image">{{ 'Image' }}</label>
                                    <div class="image-input">
                                        <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                        <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                        <img id="image_preview_container" class="preview-image"
                                            src="{{ getFile(config('location.plan.path') . $plans->image) }}"
                                            alt="@lang('preview image')">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label>@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox" id="status"
                                            value="0" {{ $plans->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-switch-checkbox-label" for="status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn  btn-primary btn-block mt-3">@lang('Save Changes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
@endpush

@push('js')
    <script>
        "use strict";
        $(document).ready(function(e) {

            $('#image').on("change",function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });

        $(function() {
            $('#select').selectpicker();
        });
    </script>
@endpush
