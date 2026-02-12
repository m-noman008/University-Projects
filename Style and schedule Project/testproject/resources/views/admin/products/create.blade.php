@extends('admin.layouts.app')
@section('title')
    @lang('Create Product')
@endsection
@section('content')
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="mb-4 media justify-content-end">
                <a href="{{ route('admin.product.list') }}" class="mr-2 btn btn-sm btn-primary">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach ($languages as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                            href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2 tab-content" id="myTabContent">
                @foreach ($languages as $key => $language)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}"
                        role="tabpanel">
                        <form method="post" action="{{ route('admin.product.store', $language->id) }}" class="mt-4"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row generate-btn-parent">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="product_name"> @lang('Product Name') </label>
                                    <input type="text" name="product_name[{{ $language->id }}]"
                                        class="form-control  @error('product_name' . '.' . $language->id) is-invalid @enderror"
                                        value="{{ old('product_name' . '.' . $language->id) }}">
                                    <div class="invalid-feedback">
                                        @error('product_name' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-6">
                                        <label for="category_id"> @lang('Product Category') </label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            name="category_id" id="categoryId">
                                            <option selected disabled>@lang('Select product category')</option>
                                            @foreach ($productCategory as $category)
                                                <option value="{{ $category->id }}">@lang(optional($category->details)->name)</option>
                                            @endforeach
                                        </select>
                                        <div class="mt-3 invalid-feedback d-inline-block">
                                            @error('category_id')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="price"> @lang('Price') </label>
                                        <input type="number" name="price"
                                            class="form-control  @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}">
                                        <div class="invalid-feedback">
                                            @error('price')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="sku" class="mb-1"> @lang('Attribute Name') </label>
                                        <select class="form-select form-control" id="select" multiple="multiple"
                                            name="attributes_id[]">
                                            @foreach ($productAttribute as $attribute)
                                                <option value="{{ $attribute->id }}">@lang($attribute->name)</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('sku')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                @endif
                                <div class="my-3 col-sm-12 col-md-12">
                                    <div class="form-group ">
                                        <label for="description"> @lang('Description') </label>
                                        <textarea class="form-control summernote @error('description' . '.' . $language->id) is-invalid @enderror"
                                            name="description[{{ $language->id }}]" id="summernote" rows="15"
                                            value="{{ old('description' . '.' . $language->id) }}">{{ old('description' . '.' . $language->id) }}</textarea>
                                        <div class="invalid-feedback">
                                            @error('description' . '.' . $language->id)
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="thumb_image">{{ 'Thumbnail Image' }}</label>
                                            <div class="image-input">
                                                <label for="image-upload" id="image-label"><i
                                                        class="fas fa-upload"></i></label>
                                                <input type="file" name="thumb_image" placeholder="@lang('Choose image')"
                                                    id="image">
                                                <img id="image_preview_container" class="preview-image"
                                                    src="{{ getFile(config('location.category.path')) }}"
                                                    alt="@lang('preview image')">
                                            </div>
                                            @error('thumb_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if (config('location.product.size_thumbnail'))
                                            <span class="mb-2 text-muted">{{ trans('Image size should be') }}
                                                {{ config('location.product.size_thumbnail') }} {{ trans('px') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <a href="javascript:void(0)"
                                                    class="float-left mt-3 btn btn-primary generate">
                                                    <i class="fa fa-plus-circle"></i> {{ __('Add Slider Images') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            @error('slider')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3 row addedField">

                            </div>
                            <button type="submit"
                                class="mt-3 btn waves-effect waves-light btn-rounded btn-primary btn-block">@lang('Save')</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
@endpush


@push('js')
    <script>
        "use strict";
        $(document).ready(function(e) {

            $(".generate").on('click', function() {
                var form = `<div class="mt-1 mb-4 col-sm-12 col-md-4 image-column">
                                <div class="form-group">
                                    <div class="input-group justify-content-between">
                                        <div class="image-input z0">
                                            <label for="gallery" id="image-label"><i class="fas fa-upload"></i></label>
                                            <input type="file" name="slider_images[]" id="image-slider" placeholder="@lang('Choose Image')" class="image-preview" required aria-requires="true">
                                            <img id="slider_preview_container" class="preview-image" src="{{ getFile(config('location.product.path_slider')) }}" alt="@lang('Preview Image')">
                                        </div>
                                         @if (config('location.product.size_slider'))
                                            <span class="mb-2 text-muted">{{ trans('Image size should be') }} {{ config('location.product.size_slider') }} {{ trans('px') }}</span>
                                        @endif
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger delete_desc removeFile z9" type="button" title="@lang('Remove Image')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> `;
                $(this).parents('.generate-btn-parent').siblings('.addedField').append(form)
            });

            $(document).on('change', '.image-preview', function() {
                let reader = new FileReader();
                let _this = this;
                reader.onload = (e) => {
                    $(_this).siblings('.preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


            $(document).on('click', '.delete_desc', function() {
                $(this).closest('.input-group').parents('.image-column').remove();
            });

            $('#image').on("change",function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('.summernote').summernote({
                height: 250,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable')
                            .val();
                        $(this).val(codeviewHtml);
                    }
                }
            });


        });


        $('#categoryId').select2({
            selectOnClose: true
        });

        $(function() {
            $('#select').selectpicker();
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
