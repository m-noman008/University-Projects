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
                            <div class=" dashboard-box">
                                <div class="row">


                                    <div class="col-md-3">
                                        <img  class="w-75"
                                            src="{{getFile(config('location.gateway.path').optional($order->gateway)->image)}}"
                                            alt="..">
                                    </div>

                                    <div class="col-md-5">
                                        <h4>@lang('Please Pay') {{getAmount($order->final_amount)}} {{$order->gateway_currency}}</h4>

                                        <form
                                            action="{{ route('ipn', [optional($order->gateway)->code ?? 'mercadopago', $order->transaction]) }}"
                                            method="POST">
                                            <script
                                                src="https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js"
                                                data-preference-id="{{ $data->preference }}">
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
