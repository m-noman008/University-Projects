@extends('admin.layouts.app')
@section('title')
    @lang('Create a gallery')
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{ route('admin.gallery.items.list') }}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            <form method="post" action="{{ route('admin.gallery.items.store') }}" class="form-row justify-content-center"
                enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="tag_id">@lang('Tag Name')</label>
                            <select name="tag_id" id="tag_id" class="form-control">
                                <option value="" disabled>@lang('Select a Tag')</option>
                                @foreach ($manageTag as $item)
                                    <option value="{{ $item->id }}">@lang($item->name)</option>
                                @endforeach
                            </select>
                            @error('tag_id')
                                <span class="text-danger">@lang($message)</span>
                            @enderror
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="image">@lang('Image')</label>
                                <div class="image-input ">
                                    <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                    <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                    <img id="image_preview_container" class="preview-image"
                                        src="{{ getFile(config('location.gallery.path')) }}" alt="@lang('preview image')">
                                </div>
                                @error('image')
                                    <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                                class="fas fa-save pr-2"></i> @lang('Save')</span>
                            </button>
                </div>
            </form>
        </div>
    </div>
@endsection


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
