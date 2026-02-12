@extends($theme.'layouts.user')
@section('title',trans('Product Details'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('Product')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Quantity')</th>
                            <th scope="col">@lang('Status')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($my_order_details as $data)
                            <tr>
                                <td data-label="Product">
                                    <div class="d-lg-flex d-block align-items-center ">
                                        <div class="mr-3"><img
                                                src="{{getFile(config('location.product.path_thumbnail').optional($data->getProductInfo)->thumbnail_image) }}"
                                                alt="user" class="rounded-circle" width="45" height="45"></div>
                                        <div class="ms-2">
                                            <span>@lang(optional(optional($data->getProductInfo)->trashDetails)->product_name)</span><br>
                                            @foreach($data->attributes_details as $attr)
                                                <small>{{optional($attr->product_attr)->name}}:</small>
                                                <small>{{$attr->attributes}}</small>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Price">
                                    @lang(config('basic.currency_symbol'))
                                    {{ $data->price }}
                                </td>
                                <td data-label="Quantity">
                                    {{ $data->qty }}
                                </td>
                                <td data-label="Status">
                                    @if(optional($data->getOrder)->status == 0)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif(optional($data->getOrder)->status == 1)
                                        <span class="badge bg-primary">@lang('Processing')</span>
                                    @elseif(optional($data->getOrder)->status == 2)
                                        <span class="badge bg-secondary">@lang('On Shipping')</span>
                                    @elseif(optional($data->getOrder)->status == 3)
                                        <span class="badge bg-info">@lang('Ship')</span>
                                    @elseif(optional($data->getOrder)->status == 4)
                                        <span class="badge bg-success">@lang('Completed')</span>
                                    @elseif(optional($data->getOrder)->status == 5)
                                        <span class="badge bg-danger">@lang('Cancel')</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td class="text-center text-danger" colspan="100%">@lang('No User Data')</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

