@extends('admin.layouts.app')
@section('title')
    @lang('Edit Service')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{ route('admin.service.list') }}" class="btn btn-sm  btn-primary mr-2">
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
                        <form method="post" action="{{ route('admin.service.update', [$id, $language->id]) }}"
                            class="mt-4" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label for="service_name"> @lang('Service Name') </label>
                                    <input type="text" name="service_name[{{ $language->id }}]"
                                        class="form-control  @error('service_name' . '.' . $language->id) is-invalid @enderror"
                                        value="<?php echo old('service_name' . $language->id, isset($serviceData[$language->id]) ? @$serviceData[$language->id][0]->service_name : ''); ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('service_name' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 mt-2">
                                    <label for="short_title"> @lang('Short Title') </label>
                                    <input type="text" name="short_title[{{ $language->id }}]"
                                        class="form-control  @error('short_title' . '.' . $language->id) is-invalid @enderror"
                                        value="<?php echo old('short_title' . $language->id, isset($serviceData[$language->id]) ? @$serviceData[$language->id][0]->short_title : ''); ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('short_title' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-12 mt-2">
                                        <label for="price"> @lang('Price') </label>
                                        <input type="number" name="price"
                                            class="form-control  @error('price') is-invalid @enderror"
                                            value="<?php echo old('short_title' . $language->id, isset($serviceData[$language->id]) ? @optional($serviceData[$language->id][0]->service)->price : ''); ?>" autocomplete="off">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-sm-12 col-md-12 my-3">
                                    <div class="form-group ">
                                        <label for="description"> @lang('Description') </label>
                                        <textarea class="form-control summernote @error('description' . '.' . $language->id) is-invalid @enderror"
                                            name="description[{{ $language->id }}]" id="summernote" rows="15"
                                            value="{{ old('description' . '.' . $language->id) }}">
                                                <?php echo old('description' . $language->id, isset($serviceData[$language->id]) ? @$serviceData[$language->id][0]->description : ''); ?>
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
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="image">{{ 'Thumbnail Image' }}</label>
                                            <div class="image-input ">
                                                <label for="image-upload" id="image-label"><i
                                                        class="fas fa-upload"></i></label>
                                                <input type="file" name="thumbnail_image"
                                                    placeholder="@lang('Choose image')" id="image">
                                                <img id="image_preview_container" class="preview-image"
                                                    src="{{ getFile(config('location.service.pathThumbnail') . (isset($serviceData[$language->id]) ? @$serviceData[$language->id][0]->service->thumbnail : '')) }}"
                                                    alt="@lang('preview image')">
                                            </div>
                                            @if (config('location.service.pathThumbnail'))
                                                <span class="text-muted mb-2">{{ trans('Image size should be') }} {{ config('location.service.sizeThumbnail') }} {{ trans('px') }}</span>
                                            @endif
                                            @error('thumbnail_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5 ">
                                        <div class="form-group">
                                            <label for="image">{{ 'Description Image' }}</label>
                                            <div class="image-input2 ">
                                                <label for="image-upload" id="image-label"><i
                                                        class="fas fa-upload"></i></label>
                                                <input type="file" name="description_image"
                                                    placeholder="@lang('Choose image')" id="image2">
                                                <img id="image_preview_container2" class="preview-image"
                                                    src="{{ getFile(config('location.service.pathImage') . (isset($serviceData[$language->id]) ? @$serviceData[$language->id][0]->service->image : '')) }}"
                                                    alt="@lang('preview image')">
                                            </div>
                                            @if (config('location.service.pathImage'))
                                                <span class="text-muted mb-2">{{ trans('Image size should be') }} {{ config('location.service.sizeImage') }} {{ trans('px') }}</span>
                                            @endif
                                            @error('description_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit"
                                class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css') }}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js') }}"></script>
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

            $('#image2').on("change",function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container2').attr('src', e.target.result);
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
