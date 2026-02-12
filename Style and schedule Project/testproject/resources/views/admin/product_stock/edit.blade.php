@extends('admin.layouts.app')
@section('title')
    @lang('Edit Stock')
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
                        <form method="post" action="{{ route('admin.product.stock.update', $id) }}"
                            class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-sm-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <a href="javascript:void(0);"
                                            data-attributes="{{ json_encode($product->attribute_details) }}"
                                            class="btn btn-primary btn-sm addHeaderData"><i class="fas fa-plus"></i>
                                            @lang('Add New')
                                        </a>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                <div class="col-md-12">
                                    <table class="table stockTable" id="table_dynamic">
                                        <thead class="thead-dark">
                                            <tr class="stock-headers">
                                                @foreach ($product->attribute_details as $key => $productDetail)
                                                    <th scope="col">{{ __($productDetail->name) }}</th>
                                                @endforeach
                                                <th scope="col">@lang('Qty')</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="productStock" id="productStock">
                                            @for ($i = 0; $i < $product->stocks->count(); $i++)
                                                <tr>
                                                    @foreach ($product->attribute_details as $item)
                                                        <td>
                                                            <select
                                                                class="form-control @error('attribute_name') is-invalid @enderror"
                                                                name="attribute_name[{{ $i }}][]">
                                                                <option selected disabled>@lang('Select product')
                                                                    {{ $item->name }}</option>
                                                                @foreach ($item->attributes as $attribute)
                                                                    <option value="{{ $attribute->id }}"
                                                                        data-aid="{{ json_encode($product->stocks) }}"
                                                                        {{ in_array($attribute->id, $product->stocks[$i]->attributes_id) ? 'selected' : '' }}>
                                                                        {{ __($attribute->attributes) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $product->stocks[$i]->qty }}" name="qty[]"
                                                            placeholder="Quantity">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger removeStock" type="button"><i
                                                                class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                            @endfor
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

        $(document).on('change', ".selectProduct", function() {
            $('.addHeaderData').removeClass('disabled')
            $('.stock-headers').html('');
            $('.productStock').html('');

        });


        $(document).on('click', ".addHeaderData", function() {
            let attributes = $(this).data("attributes");

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
