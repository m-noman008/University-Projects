@extends('admin.layouts.app')
@section('title')
    @lang('Edit Attribute')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{ route('admin.product.attribute.list') }}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>
            <div class="mt-2">
                <form method="post" action="{{ route('admin.product.attribute.update', $id) }}" class="mt-4"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label for="name"> @lang('Attribute Name') </label>
                            <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror"
                                value="{{ old('name', $productAttributes->name) }}">
                            <div class="invalid-feedback">
                                @error('name')
                                    @lang($message)
                                @enderror
                            </div>
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 margin-left">
                            <div class="form-group">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm addHeaderData"><i
                                        class="fas fa-plus"></i>
                                    @lang('Add New')
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table" id="table_dynamic">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">{{ __('Attributes') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="productAttribute" id="productAttribute">
                                    @foreach ($attributesList as $attr)
                                        <tr>
                                            <td class="w-100">
                                                <input type="text" name="attr[]"
                                                    class="form-control @error('attr') is-invalid @enderror"
                                                    placeholder="@lang('attr')" value="{{ $attr->attributes }}">
                                            </td>
                                            <td>
                                                <button class="btn btn-danger removeStock" type="button"><i
                                                        class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
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

            $(".addHeaderData").on("click",function() {
                var newRowAdd = `<tr>
                                        <td class="w-100">
                                            <input type="text" min="0" name="attr[]" class="form-control
                                                @error('attr') is-invalid @enderror" placeholder="@lang('Attributes')">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger removeStock" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                $('.productAttribute').append(newRowAdd);
            });

            $(document).on('click', ".removeStock", function(e) {
                e.preventDefault();
                let rowCount = $('#productAttribute tr').length;
                rowCount = parseInt(rowCount) - 1;
                $('.number_of_room').val(rowCount);
                $(this).parents('tr').remove();
            });

        
            $('select').select2({
                selectOnClose: true
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
