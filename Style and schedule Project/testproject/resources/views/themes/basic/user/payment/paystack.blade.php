@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading mt-2">
                    <h2 class="mb-0">@lang('Pay with '.optional($order->gateway)->name ?? '' )</h2>
                </div>

                <div class="dashboard-box-wrapper mt-3">
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <div class="dashboard-box">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img
                                            src="{{getFile(config('location.gateway.path').optional($order->gateway)->image)}}"
                                            class="w-75" alt="..">
                                    </div>

                                    <div class="col-md-9">
                                        <h4>@lang('Please Pay') {{getAmount($order->final_amount)}} {{$order->gateway_currency}}</h4>
                                        <button type="button"
                                                class="pay_btn"
                                                id="btn-confirm">@lang('Pay Now')</button>
                                        <form
                                            action="{{ route('ipn', [optional($order->gateway)->code, $order->transaction]) }}"
                                            method="POST">
                                            @csrf
                                            <script
                                                src="//js.paystack.co/v1/inline.js"
                                                data-key="{{ $data->key }}"
                                                data-email="{{ $data->email }}"
                                                data-amount="{{$data->amount}}"
                                                data-currency="{{$data->currency}}"
                                                data-ref="{{ $data->ref }}"
                                                data-custom-button="btn-confirm">
                                            </script>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

