@extends('admin.layouts.app')
@section('title')
    @lang('Create Service')
@endsection
@section('content')
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="mb-4 media justify-content-end">
                <a href="{{ route('admin.team.list') }}" class="mr-2 btn btn-sm btn-primary">
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
                        <form method="post" action="{{ route('admin.team.store', $language->id) }}" class="mt-4"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="name"> @lang('Name') </label>
                                    <input type="text" name="name[{{ $language->id }}]"
                                        class="form-control  @error('name' . '.' . $language->id) is-invalid @enderror"
                                        value="{{ old('name' . '.' . $language->id) }}" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('name' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="email"> @lang('Email') </label>
                                    <input type="email" name="email[{{ $language->id }}]"
                                        class="form-control  @error('email' . '.' . $language->id) is-invalid @enderror"
                                        value="{{ old('email' . '.' . $language->id) }}" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('email' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-6">
                                        <label for="phone"> @lang('Phone') </label>
                                        <input type="text" name="phone"
                                            class="form-control  @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" autocomplete="off">
                                        <div class="invalid-feedback">
                                            @error('phone')
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                @endif
                                <div class="col-sm-12 col-md-6">
                                    <label for="position"> @lang('Position') </label>
                                    <input type="text" name="position[{{ $language->id }}]"
                                        class="form-control  @error('position' . '.' . $language->id) is-invalid @enderror"
                                        value="{{ old('position' . '.' . $language->id) }}" autocomplete="off">
                                    <div class="invalid-feedback">
                                        @error('position' . '.' . $language->id)
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                @if ($loop->index == 0)
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="experience"> @lang('Experience') </label>
                                        <input type="text" name="experience"
                                            class="form-control  @error('experience') is-invalid @enderror"
                                            value="{{ old('experience') }}" autocomplete="off">
                                        @error('experience')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="level"> @lang('Level') </label>
                                        <input type="text" name="level"
                                            class="form-control  @error('level') is-invalid @enderror"
                                            value="{{ old('level') }}" autocomplete="off">
                                        @error('level')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="facebook_link"> @lang('Facebook Link') </label>
                                        <input type="text" name="facebook_link"
                                            class="form-control  @error('facebook_link') is-invalid @enderror"
                                            value="{{ old('facebook_link') }}" autocomplete="off">
                                        @error('facebook_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="twitter_link"> @lang('Twitter Link') </label>
                                        <input type="text" name="twitter_link"
                                            class="form-control  @error('twitter_link') is-invalid @enderror"
                                            value="{{ old('twitter_link') }}" autocomplete="off">
                                        @error('twitter_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="linkedin_link"> @lang('Linkedin Link') </label>
                                        <input type="text" name="linkedin_link"
                                            class="form-control  @error('linkedin_link') is-invalid @enderror"
                                            value="{{ old('linkedin_link') }}" autocomplete="off">
                                        @error('linkedin_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-sm-12 col-md-6">
                                        <label for="skype_link"> @lang('Skype Link') </label>
                                        <input type="text" name="skype_link"
                                            class="form-control  @error('skype_link') is-invalid @enderror"
                                            value="{{ old('skype_link') }}" autocomplete="off">
                                        @error('skype_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="my-3 col-sm-12 col-md-12">
                                    <div class="form-group ">
                                        <label for="short_description"> @lang('Short Description') </label>
                                        <textarea class="form-control @error('short_description' . '.' . $language->id) is-invalid @enderror"
                                            name="short_description[{{ $language->id }}]" rows="5"
                                            value="{{ old('short_description' . '.' . $language->id) }}">{{ old('short_description' . '.' . $language->id) }}</textarea>
                                        <div class="invalid-feedback">
                                            @error('short_description' . '.' . $language->id)
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>



                                <div class="my-3 col-sm-12 col-md-12">
                                    <div class="form-group ">
                                        <label for="biography"> @lang('Biography') </label>
                                        <textarea class="form-control summernote @error('biography' . '.' . $language->id) is-invalid @enderror"
                                            name="biography[{{ $language->id }}]" id="summernote" rows="15"
                                            value="{{ old('biography' . '.' . $language->id) }}">{{ old('biography' . '.' . $language->id) }}</textarea>
                                        <div class="invalid-feedback">
                                            @error('biography' . '.' . $language->id)
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>

                                <div class="my-3 col-sm-12 col-md-12">
                                    <div class="form-group ">
                                        <label for="working_process"> @lang('My Working Process') </label>
                                        <textarea class="form-control summernote @error('working_process' . '.' . $language->id) is-invalid @enderror"
                                            name="working_process[{{ $language->id }}]" id="summernote" rows="15"
                                            value="{{ old('working_process' . '.' . $language->id) }}">{{ old('working_process' . '.' . $language->id) }}</textarea>
                                        <div class="invalid-feedback">
                                            @error('working_process' . '.' . $language->id)
                                                @lang($message)
                                            @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>

                            </div>
                            @if ($loop->index == 0)
                                <div class="mt-3 row ">

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
                                            @if (config('location.team.path'))
                                                <span class="mb-2 text-muted">{{ trans('Image size should be') }} {{ config('location.team.size') }} {{ trans('px') }}</span>
                                            @endif
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="float-right mt-3 btn btn-success"
                                                id="generate"><i class="fa fa-plus-circle"></i> Add Top Skills</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row addedField">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="skill_name[]" class="form-control " type="text"
                                                    value="" required placeholder="@lang('Skill Name')">
                                                <input name="skill_percentage[]" class="form-control " type="text"
                                                    value="" required placeholder="@lang('Percentage')">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-danger delete_desc" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js') }}"></script>
@endpush


@push('js')

    <script>
        "use strict";
        $(document).ready(function(e) {

            $("#generate").on('click', function() {
                var form = `<div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">

                                    <input name="skill_name[]" class="form-control " type="text" value="" required
                                           placeholder="@lang('Skill Name')">
                                           <input name="skill_percentage[]" class="form-control " type="text" value="" required
                                           placeholder="@lang('Percentage')">
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger delete_desc" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>`;
                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function() {
                $(this).closest('.input-group').parent().remove();
            });

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
