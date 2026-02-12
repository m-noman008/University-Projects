@extends('admin.layouts.app')
@section('title')
    @lang('Edit Product')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{ route('admin.product.list') }}" class="btn btn-sm  btn-primary mr-2">
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
            <div class="tab-content mt-2" id="myTabContent">
                @foreach ($languages as $key => $language)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}"
                        role="tabpanel">
                        <form method="post" action="{{ route('admin.product.update', [$id, $language->id]) }}"
                            class="mt-4" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row generate-btn-parent">
                                <div class="col-sm-12 col-md-6 mb-3">
                                    <label for="product_name"> @lang('Product Name') </label>
                                    <input type="text" name="product_name[{{ $language->id }}]"
                                        class="form-control  @error('product_name' . '.' . $language->id) is-invalid @enderror"
                                        value="<?php echo old('name' . $language->id, isset($productDetails[$language->id]) ? @$productDetails[$language->id][0]->product_name : ''); ?>">
                                    <div class="invalid-feedback">
                                        @error('product_name' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-6">
                                        <label for="category_name"> @lang('Product Category') </label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            name="category_id" id="categoryId">
                                            <option selected disabled>@lang('Select product category')</option>
                                            @foreach ($productCategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == @$productDetails[$language->id][0]->product->category_id ? 'selected' : '' }}>
                                                    @lang($category->details->name)</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback d-inline-block mt-3">
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
                                            value="<?php echo old('price' . $language->id, isset($productDetails[$language->id]) ? @$productDetails[$language->id][0]->product->price : ''); ?>">
                                        <div class="invalid-feedback">
                                            @error('price')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="sku" class="mb-1"> @lang('Attribute Name') <sub
                                                class="text-dark">(optional)</sub></label>
                                        <select class="form-select form-control" id="select" multiple="multiple"
                                            name="attributes_id[]">
                                            @foreach ($productAttribute as $attribute)
                                                <option value="{{ $attribute->id }}"
                                                    @if (@$productDetails[$language->id][0]->product->attributes_id) @foreach (@$productDetails[$language->id][0]->product->attributes_id as $productAttr)
                                                            {{ $productAttr == $attribute->id ? 'selected' : '' }}
                                                        @endforeach @endif>
                                                    @lang($attribute->name)
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('sku')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>


                                    <div class="form-group col-sm-12 col-md-4 mt-2">
                                        <label class="text-dark">@lang('Status')</label>
                                        <div class="custom-switch-btn">
                                            <input type='hidden' value='1' name='status'>
                                            <input type="checkbox" name="status" class="custom-switch-checkbox"
                                                id="status" value="0"
                                                {{ @$productDetails[$language->id][0]->product->status == 0 ? 'checked' : '' }}>
                                            <label class="custom-switch-checkbox-label" for="status">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12 col-md-12 my-3">
                                    <div class="form-group ">
                                        <label for="description"> @lang('Description') </label>
                                        <textarea class="form-control summernote @error('description' . '.' . $language->id) is-invalid @enderror"
                                            name="description[{{ $language->id }}]" id="summernote" rows="15" value="<?php echo old('description' . $language->id, isset($productDetails[$language->id]) ? @$productDetails[$language->id][0]->description : ''); ?>">
                                            <?php echo old('description' . $language->id, isset($productDetails[$language->id]) ? @$productDetails[$language->id][0]->description : ''); ?>
                                        </textarea>
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
                                            <label for="image">{{ 'Thumbnail Image' }}</label>
                                            <div class="image-input product-image">
                                                <label for="thumb_image-upload" id="image-label"><i
                                                        class="fas fa-upload"></i></label>
                                                <input type="file" name="thumb_image" placeholder="@lang('Choose image')"
                                                    id="image">
                                                <img id="image_preview_container" class="preview-image"
                                                    src="{{ getFile(config('location.product.path_thumbnail') . (isset($productDetails[$language->id]) ? @$productDetails[$language->id][0]->product->thumbnail_image : '')) }}"
                                                    alt="@lang('preview image')">
                                            </div>
                                            @error('thumb_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary float-left mt-3 generate">
                                                    <i class="fa fa-plus-circle"></i> {{ __('Add Slider Images') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php
                                $sliderImage = $productDetails[$language->id][0]->product ?? null;
                            @endphp
                            @if ($loop->index == 0)
                                <div class="row addedField mt-3">
                                    @if (isset($sliderImage->slider_image))
                                        @for ($i = 0; $i < count($sliderImage->slider_image); $i++)
                                            <div class="col-sm-12 col-md-4 image-column ">
                                                <div class="form-group">
                                                    <div class="image-input position-relative z0">
                                                        <img id="image_preview_container"
                                                            class="preview-image-product storyDetailImageSize rounded"
                                                            src="{{ getFile(config('location.product.path_slider') . $sliderImage->slider_image[$i]) }}"
                                                            alt="@lang('preview image')">
                                                        <div class="d-flex justify-content-between">
                                                            <button
                                                                class="btn btn-sm btn-danger notiflix-confirm removeFile"
                                                                data-route="{{ route('admin.product.image.delete', [$sliderImage->id, $sliderImage->slider_image[$i]]) }}"
                                                                data-toggle="modal" data-target="#delete-modal"
                                                                type="button" title="@lang('Delete Image')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            @endif
                            <button type="submit"
                                class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
        $(document).ready(function() {
            $(function() {
                $('#size').selectpicker();
            });
        });
    </script>

    <script>
        "use strict";
        $(document).ready(function(e) {

            $(".generate").on('click', function() {
                var form = `<div class="col-sm-12 col-md-4 image-column mt-1 mb-4">
                                <div class="form-group">
                                    <div class="input-group justify-content-between">
                                        <div class="image-input z0">
                                            <label for="gallery" id="image-label"><i class="fas fa-upload"></i></label>
                                            <input type="file" name="slider_images[]" id="image-slider" placeholder="@lang('Choose Image')" class="image-preview" required>
                                            <img id="slider_preview_container" class="preview-image" src="{{ getFile(config('location.product.path_slider')) }}" alt="@lang('Preview Image')">
                                        </div>
                                        @if (config('location.product.size_thumbnail'))
                                            <span class="text-muted mb-2">{{ trans('Image size should be') }} {{ config('location.product.size_slider') }} {{ trans('px') }}</span>
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


            $('.notiflix-confirm').on('click', function() {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })

            $(document).on('click', '.delete_desc', function() {
                $(this).closest('.input-group').parents('.image-column').remove();
            });

            $(document).on('change', '.image-preview', function() {
                let reader = new FileReader();
                let _this = this;
                reader.onload = (e) => {
                    $(_this).siblings('.preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
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
