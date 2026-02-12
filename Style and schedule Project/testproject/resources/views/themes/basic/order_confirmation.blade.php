@extends($theme . 'layouts.app')
@section('title', trans($title))

@section('content')
    <section id="order_confirmation">
        <div class="container mt-5 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <p class="order-success-text">
                        @lang('Thank you. Your order has been received.')
                    </p>
                    <div class="payment-order mt-40 mb-3 table-responsive card">
                        <table class="table table-borderless ">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-2"> <strong class="d-block">@lang('Order No')</strong>
                                            <span>{{ $orderInfo->order_number }}</span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <strong class="d-block ">@lang('Order Date')</strong>
                                            <span>{{ dateTime($orderInfo->created_at, 'd M Y') }}</span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <strong class="d-block ">@lang('Payment')</strong>
                                            <span>@lang($orderInfo->payment_type)</span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <strong class="d-block ">@lang('Shipping Address')</strong>
                                            <span>@lang(optional($orderInfo->shipping)->street_address)</span> 
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card mt-40">
                        <div class="invoice p-5">
                            <h4>@lang('Your order Confirmed!')</h4>
                            <span class="font-weight-bold d-block mt-4">@lang('Hello'), @lang(optional($orderInfo->shipping)->first_name)</span>
                            <span>@lang('You order has been confirmed and will be shipped in next few days!')</span>
                            <div class="product border-bottom border-top table-responsive mt-5">
                                <table class="table table-borderless">
                                    <tbody>
                                        @php
                                            $sum = 0;
                                        @endphp
                                        @foreach ($productOrder as $item)
                                            <tr>
                                                <td width="40%">
                                                    <div class="mr-3"><img
                                                            src="{{ getFile(config('location.product.path_thumbnail') . optional($item->getProductInfo)->thumbnail_image) }}"
                                                            alt="user" class="rounded-circle" width="45"
                                                            height="45">
                                                        <span
                                                            class="font-weight-bold">{{ optional(optional($item->getProductInfo)->details)->product_name }}</span>
                                                    </div>
                                                </td>
                                                <td width="40%">
                                                    <div class="product-qty"> <span
                                                            class="d-block">@lang('Quantity'):{{ $item->qty }}</span>
                                                    </div>
                                                </td>
                                                <td width="20%">
                                                    <div class="text-right"> <span
                                                            class="font-weight-bold">{{ config('basic.currency_symbol') }}{{ $item->price * $item->qty }}</span>
                                                    </div>
                                                    @php
                                                        $price = $item->price * $item->qty;
                                                        $sum = $sum + $price;
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-5">
                                    <table class="table table-borderless">
                                        <tbody class="totals">
                                            <tr>
                                                <td class="subtotal-text">
                                                    <div class="text-left"> <span class="">@lang('Subtotal')</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-right">
                                                        <span>{{ config('basic.currency_symbol') }}{{ $sum }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p>@lang('We will be sending shipping confirmation email when the item shipped successfully!')</p>
                            <p class="font-weight-bold mb-0">@lang('Thanks for shopping with us!')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        let data = sessionStorage.getItem("shoppingCart");

        (function() {
            if (window.sessionStorage) {
                if (sessionStorage.getItem("shoppingCart")) {
                    sessionStorage['shoppingCart'] = true;
                    window.location.reload();
                    sessionStorage.clear();
                }

            }
        })();
    </script>
@endpush
