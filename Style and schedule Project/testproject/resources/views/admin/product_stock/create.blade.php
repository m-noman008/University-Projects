@extends('admin.layouts.app')
@section('title')
    @lang('Create Stock')
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <div class="media mb-4 justify-content-end">
                            <a href="{{ route('admin.product.stock.list') }}" class="btn btn-sm  btn-primary mr-2">
                                <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                            </a>
                        </div>
                        <form method="post" action="{{ route('admin.product.stock.store') }}"
                            class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-12 ">
                                    <label for="product_name"> @lang('Product Name') </label>
                                    <select class="form-control selectProduct @error('product_name') is-invalid @enderror"
                                        name="product_name" id="stockProductCreate">
                                        <option selected disabled>@lang('Select product category')</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-attributes="{{ json_encode($product->attribute_details) }}">
                                                @lang(@$product->details->product_name)</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback d-inline-block mt-2">
                                        @error('product_name')
                                            @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary btn-sm addHeaderData disabled"><i
                                                class="fas fa-plus"></i>
                                            @lang('Add New')
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12" class="hideStock">
                                    <table class="table stockTable" id="table_dynamic">
                                        <thead class="thead-dark">
                                            <tr class="stock-headers">

                                            </tr>
                                        </thead>
                                        <tbody class="productStock" id="productStock">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script>
        "use strict";
        let count = 0;

        $(document).on('change', ".selectProduct", function() {
            $('.addHeaderData').removeClass('disabled')
            $('.stock-headers').html('');
            $('.productStock').html('');

        });

        $(document).on('click', ".addHeaderData", function() {
            let attributes = $(".selectProduct").select2().find(":selected").data("attributes");


            if (count < 20) {
                count++;

                $('.stock-headers').html('');
                let markup = '<tr>';
                $(attributes).each(function(key, value) {
                    let attributeLength = $(`.productStock tr`).length;
                    $('.stock-headers').append(`<th scope="col">${value.name}</th>`);
                    markup += `<td>
                            <select class="form-control @error('attribute_name') is-invalid @enderror attribute-${value.name}" name="attribute_name[${attributeLength}][]">
                            <option selected disabled>Select product ${value.name}</option>
                            </select>
                        </td>`;
                });

                $('.stock-headers').append(`<th scope="col">{{ __('Quantity') }}</th>
                    <th scope="col"></th>`);
                markup += `<td>
                    <input type="number" min="0" name="qty[]"
                           class="form-control @error('qty') is-invalid @enderror"
                           placeholder="@lang('Quantity')">
                </td>
                <td>
                    <button class="btn btn-danger removeStock" type="button"><i
                        class="fa fa-times"></i></button>
                </td></tr>`;
                $('.productStock').append(markup);
                $(attributes).each(function(key, value) {
                    $(value.attributes).each(function(attributeKey, attributeValue) {
                        $(`.attribute-${value.name}:last`).append(
                            `<option value="${attributeValue.id}">${attributeValue.attributes}</option>`
                            );
                    })
                });
            }
        });

        $(document).on('click', '.removeStock', function() {
            $(this).parents('tr').remove();
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
