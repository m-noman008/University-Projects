@extends('admin.layouts.app')
@section('title')
    @lang('Order Product Information')
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <h4 class="mb-0 card-title">@lang('Product Information')
                            </h4>
                        </div>
                        <div class="mb-2 text-right dropdown action_btn_area">
                            <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><i class="pr-2 fas fa-bars"></i> @lang('Action')</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item pending" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('Pending')
                                </button>
                                <button class="dropdown-item processing" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('Processing')
                                </button>
                                <button class="dropdown-item on_shipping" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('On Shipping')
                                </button>
                                {{-- <button class="dropdown-item ship" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('Ship')
                                </button> --}}
                                <button class="dropdown-item completed" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('Completed')
                                </button>
                                <button class="dropdown-item cancel" type="button" data-toggle="modal"
                                    data-target="#stageChange">@lang('Cancel')
                                </button>
                            </div>
                        </div>
                        <table class="table categories-show-table table-hover table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">@lang('Product Name')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Qty')</th>
                                    <th scope="col">@lang('Total Price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($OrderDetailsProductInfo as $product)
                                    <tr>
                                        <td data-label="@lang('Product Name')">
                                            <a href="{{ route('product.details', [@slug(optional(optional($product->getProductInfo)->trashDetails)->product_name), optional($product->getProductInfo)->id]) }}"
                                                class="text-secondary">
                                                <div class="d-lg-flex d-block align-items-center ">
                                                    <div class="mr-3"><img
                                                            src="{{ getFile(config('location.product.path_thumbnail') . optional($product->getProductInfo)->thumbnail_image) }}"
                                                            alt="user" class="rounded-circle" width="45"
                                                            height="45"></div>
                                                    <div>
                                                        <h5 class="mb-0 text-secondary font-16 font-weight-medium">
                                                            @lang(optional(optional($product->getProductInfo)->trashDetails)->product_name)</h5>
                                                        <div>
                                                            @forelse($product->attributes_details as $attr)
                                                                <small>@lang(optional($attr->product_attr)->name)
                                                                    :</small>
                                                                <small>@lang($attr->attributes)</small>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                        </td>
                                        <td data-label="@lang('Price')">
                                            @lang(config('basic.currency_symbol'))
                                            {{ optional($product->getProductInfo)->price }}
                                        </td>
                                        <td data-label="@lang('Qty')">
                                            {{ $product->qty }}
                                        </td>
                                        <td data-label="@lang('Total Price')">
                                            @lang(config('basic.currency_symbol'))
                                            {{ optional($product->getProductInfo)->price * $product->qty }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
                    <div class="card-body buyer-information">
                        <div class="mb-3 d-flex justify-content-between">
                            <h4 class="mb-0 card-title">@lang('Buyer Information')
                            </h4>
                            @if ($OrderProductInfo->status == 0)
                                <span class="text-white badge badge-warning">@lang('Pending')</span>
                            @elseif($OrderProductInfo->status == 1)
                                <span class="badge badge-pill processing">@lang('Processing')</span>
                            @elseif($OrderProductInfo->status == 2)
                                <span class="badge badge-pill shipping">@lang('On Shipping')</span>
                            {{-- @elseif($OrderProductInfo->status == 3)
                                <span class="badge badge-pill ship">@lang('Ship')</span> --}}
                            @elseif($OrderProductInfo->status == 4)
                                <span class="badge badge-success completed">@lang('Completed')</span>
                            @elseif($OrderProductInfo->status == 5)
                                <span class="badge badge-danger cancel">@lang('Cancel')</span>
                            @endif
                        </div>
                        <div>
                            <ul class="list-group">
                                @forelse($OrderProductInfo->shipping as $key => $shipping)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @php
                                            $regex = preg_match('[_]', $key);
                                            if ($regex > 0) {
                                                $name = explode('_', $key);
                                                $realValue = ucfirst($name[0]) . ' ' . ucfirst($name[1]);
                                            } else {
                                                $realValue = $key;
                                            }
                                        @endphp
                                        <span>{{ ucfirst($realValue) }}</span>
                                        <span>{{ $shipping }}</span>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="stageChange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Stage Change Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to change this stage?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="{{ route('admin.stage.change.single', $OrderDetailsProductInfo[0]->order_id) }}"
                        method="post">
                        @csrf
                        <input type="hidden" class="stage" name="stage" value="">
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('js')
    <script>
        "use strict";
        $(document).on('click', '.pending', function() {
            $('.stage').val('pending');
        })
        $(document).on('click', '.processing', function() {
            $('.stage').val('processing');
        })
        $(document).on('click', '.on_shipping', function() {
            $('.stage').val('on_shipping');
        })
        // $(document).on('click', '.ship', function() {
        //     $('.stage').val('ship');
        // })
        $(document).on('click', '.completed', function() {
            $('.stage').val('completed');
        })
        $(document).on('click', '.cancel', function() {
            $('.stage').val('cancel');
        })
        $(document).on('click', '.refund', function() {
            $('.stage').val('refund');
        })
        $(document).on('click', '.return', function() {
            $('.stage').val('return');
        })
    </script>
@endpush
